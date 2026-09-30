<?php

namespace App\Libraries;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use ZipArchive;

/**
 * Konversi ringan .docx → HTML untuk editor Workspace, plus sanitizer HTML.
 *
 * Yang didukung: paragraf, heading, tebal/miring/garis bawah, rata teks,
 * daftar (bullet/nomor, satu tingkat), tabel, tab, line/page break.
 * Yang tidak didukung: gambar, header/footer, kolom, tata letak halaman.
 * File .docx asli tidak diubah.
 */
class DocxToHtml
{
    private const NS = 'http://schemas.openxmlformats.org/wordprocessingml/2006/main';

    /** @var array<string,string> styleId => nama style (lowercase) */
    private array $styles = [];

    /** @var array<string,string> numId => 'ol'|'ul' */
    private array $lists = [];

    /**
     * Baca file .docx dan kembalikan HTML. String kosong jika gagal dibaca.
     */
    public static function fromFile(string $path): string
    {
        if (! class_exists(ZipArchive::class) || ! is_file($path)) {
            return '';
        }

        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            return '';
        }

        $document  = $zip->getFromName('word/document.xml');
        $styles    = $zip->getFromName('word/styles.xml');
        $numbering = $zip->getFromName('word/numbering.xml');
        $zip->close();

        if ($document === false) {
            return '';
        }

        try {
            return (new self())->convert($document, $styles ?: '', $numbering ?: '');
        } catch (\Throwable $e) {
            log_message('error', 'DocxToHtml gagal: ' . $e->getMessage());
            return '';
        }
    }

    private function convert(string $documentXml, string $stylesXml, string $numberingXml): string
    {
        $this->loadStyles($stylesXml);
        $this->loadNumbering($numberingXml);

        $doc = $this->load($documentXml);
        if ($doc === null) {
            return '';
        }

        $body = $doc->getElementsByTagNameNS(self::NS, 'body')->item(0);
        if (! $body) {
            return '';
        }

        return $this->blocks($body);
    }

    // ────────────────────────────────────────────────────────────────
    // Blok: paragraf, daftar, tabel
    // ────────────────────────────────────────────────────────────────

    private function blocks(DOMNode $parent): string
    {
        $html     = '';
        $openList = null; // 'ul' | 'ol'

        foreach ($parent->childNodes as $node) {
            if (! $node instanceof DOMElement || $node->namespaceURI !== self::NS) {
                continue;
            }

            switch ($node->localName) {
                case 'p':
                    $list = $this->listType($node);
                    if ($list !== null) {
                        if ($openList !== $list) {
                            $html .= $openList ? "</{$openList}>" : '';
                            $html .= "<{$list}>";
                            $openList = $list;
                        }
                        $html .= '<li>' . $this->runs($node) . '</li>';
                        break;
                    }
                    if ($openList) {
                        $html    .= "</{$openList}>";
                        $openList = null;
                    }
                    $html .= $this->paragraph($node);
                    break;

                case 'tbl':
                    if ($openList) {
                        $html    .= "</{$openList}>";
                        $openList = null;
                    }
                    $html .= $this->table($node);
                    break;

                case 'sdt': // content control (mis. sampul/daftar isi)
                    if ($openList) {
                        $html    .= "</{$openList}>";
                        $openList = null;
                    }
                    foreach ($node->childNodes as $child) {
                        if ($child instanceof DOMElement && $child->localName === 'sdtContent') {
                            $html .= $this->blocks($child);
                        }
                    }
                    break;
            }
        }

        if ($openList) {
            $html .= "</{$openList}>";
        }

        return $html;
    }

    private function paragraph(DOMElement $p): string
    {
        $inner = $this->runs($p);
        $tag   = 'p';

        $styleId = $this->attr($this->child($this->child($p, 'pPr'), 'pStyle'), 'val');
        $name    = $this->styles[$styleId] ?? strtolower($styleId);

        if ($name === 'title') {
            $tag = 'h1';
        } elseif (preg_match('/^(?:heading|judul)\s*(\d)/', $name, $m)) {
            $tag = 'h' . min(3, max(1, (int) $m[1]));
        }

        $jc    = $this->attr($this->child($this->child($p, 'pPr'), 'jc'), 'val');
        $align = ['center' => 'center', 'right' => 'right', 'end' => 'right', 'both' => 'justify'][$jc] ?? null;
        $style = $align ? ' style="text-align:' . $align . '"' : '';

        if (trim(strip_tags($inner, '<hr>')) === '' && stripos($inner, '<hr') === false) {
            return "<{$tag}{$style}><br></{$tag}>";
        }

        return "<{$tag}{$style}>{$inner}</{$tag}>";
    }

    private function runs(DOMElement $p): string
    {
        $out = '';

        foreach ($p->childNodes as $node) {
            if (! $node instanceof DOMElement || $node->namespaceURI !== self::NS) {
                continue;
            }

            if ($node->localName === 'r') {
                $out .= $this->run($node);
            } elseif (in_array($node->localName, ['hyperlink', 'smartTag', 'ins', 'sdt'], true)) {
                foreach ($node->childNodes as $child) {
                    if ($child instanceof DOMElement && $child->localName === 'r') {
                        $out .= $this->run($child);
                    } elseif ($child instanceof DOMElement && $child->localName === 'sdtContent') {
                        foreach ($child->childNodes as $c2) {
                            if ($c2 instanceof DOMElement && $c2->localName === 'r') {
                                $out .= $this->run($c2);
                            }
                        }
                    }
                }
            }
        }

        return $out;
    }

    private function run(DOMElement $r): string
    {
        $text = '';

        foreach ($r->childNodes as $n) {
            if (! $n instanceof DOMElement || $n->namespaceURI !== self::NS) {
                continue;
            }
            switch ($n->localName) {
                case 't':
                    $text .= htmlspecialchars($n->textContent, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                    break;
                case 'tab':
                    $text .= '&emsp;';
                    break;
                case 'br':
                case 'cr':
                    $text .= $this->attr($n, 'type') === 'page' ? '<hr>' : '<br>';
                    break;
            }
        }

        if ($text === '') {
            return '';
        }

        $rPr = $this->child($r, 'rPr');
        if ($rPr) {
            if ($this->on($this->child($rPr, 'b'))) {
                $text = "<b>{$text}</b>";
            }
            if ($this->on($this->child($rPr, 'i'))) {
                $text = "<i>{$text}</i>";
            }
            $u = $this->child($rPr, 'u');
            if ($u && $this->attr($u, 'val') !== 'none') {
                $text = "<u>{$text}</u>";
            }
        }

        return $text;
    }

    private function table(DOMElement $tbl): string
    {
        $html = '<table style="border-collapse:collapse;width:100%">';

        foreach ($tbl->childNodes as $tr) {
            if (! $tr instanceof DOMElement || $tr->localName !== 'tr') {
                continue;
            }
            $html .= '<tr>';
            foreach ($tr->childNodes as $tc) {
                if (! $tc instanceof DOMElement || $tc->localName !== 'tc') {
                    continue;
                }
                $span  = (int) $this->attr($this->child($this->child($tc, 'tcPr'), 'gridSpan'), 'val');
                $attrs = $span > 1 ? ' colspan="' . $span . '"' : '';
                $html .= '<td' . $attrs . ' style="border:1px solid #999;padding:6px">' . $this->blocks($tc) . '</td>';
            }
            $html .= '</tr>';
        }

        return $html . '</table>';
    }

    // ────────────────────────────────────────────────────────────────
    // Styles & numbering
    // ────────────────────────────────────────────────────────────────

    private function loadStyles(string $xml): void
    {
        $doc = $xml !== '' ? $this->load($xml) : null;
        if ($doc === null) {
            return;
        }
        foreach ($doc->getElementsByTagNameNS(self::NS, 'style') as $style) {
            $id   = $this->attr($style, 'styleId');
            $name = $this->attr($this->child($style, 'name'), 'val');
            if ($id !== '' && $name !== '') {
                $this->styles[$id] = strtolower($name);
            }
        }
    }

    private function loadNumbering(string $xml): void
    {
        $doc = $xml !== '' ? $this->load($xml) : null;
        if ($doc === null) {
            return;
        }

        $abstract = [];
        foreach ($doc->getElementsByTagNameNS(self::NS, 'abstractNum') as $a) {
            $id = $this->attr($a, 'abstractNumId');
            foreach ($a->getElementsByTagNameNS(self::NS, 'lvl') as $lvl) {
                if ($this->attr($lvl, 'ilvl') === '0') {
                    $fmt = $this->attr($this->child($lvl, 'numFmt'), 'val');
                    $abstract[$id] = ($fmt === 'bullet' || $fmt === 'none') ? 'ul' : 'ol';
                    break;
                }
            }
        }

        foreach ($doc->getElementsByTagNameNS(self::NS, 'num') as $num) {
            $numId = $this->attr($num, 'numId');
            $aId   = $this->attr($this->child($num, 'abstractNumId'), 'val');
            $this->lists[$numId] = $abstract[$aId] ?? 'ul';
        }
    }

    private function listType(DOMElement $p): ?string
    {
        $numPr = $this->child($this->child($p, 'pPr'), 'numPr');
        if (! $numPr) {
            return null;
        }
        $numId = $this->attr($this->child($numPr, 'numId'), 'val');

        return $numId === '' || $numId === '0' ? null : ($this->lists[$numId] ?? 'ul');
    }

    // ────────────────────────────────────────────────────────────────
    // Helper DOM
    // ────────────────────────────────────────────────────────────────

    private function load(string $xml): ?DOMDocument
    {
        $doc  = new DOMDocument();
        $prev = libxml_use_internal_errors(true);
        // LIBXML_NONET: tanpa akses jaringan; entity eksternal tidak dimuat.
        $ok = $doc->loadXML($xml, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        return $ok ? $doc : null;
    }

    private function child(?DOMNode $node, string $name): ?DOMElement
    {
        if (! $node) {
            return null;
        }
        foreach ($node->childNodes as $c) {
            if ($c instanceof DOMElement && $c->namespaceURI === self::NS && $c->localName === $name) {
                return $c;
            }
        }

        return null;
    }

    private function attr(?DOMElement $el, string $name): string
    {
        return $el ? (string) $el->getAttributeNS(self::NS, $name) : '';
    }

    /** Elemen toggle seperti <w:b/> aktif kecuali val=false/0/none. */
    private function on(?DOMElement $el): bool
    {
        return $el !== null && ! in_array(strtolower($this->attr($el, 'val')), ['false', '0', 'none', 'off'], true);
    }

    // ────────────────────────────────────────────────────────────────
    // Sanitizer HTML (untuk isi editor yang disimpan pengguna)
    // ────────────────────────────────────────────────────────────────

    private const TAGS = [
        'p', 'br', 'b', 'strong', 'i', 'em', 'u', 'h1', 'h2', 'h3', 'h4', 'ul', 'ol', 'li',
        'div', 'span', 'table', 'thead', 'tbody', 'tr', 'td', 'th', 'hr', 'blockquote', 'font', 'sub', 'sup',
    ];

    private const DROP = ['script', 'style', 'iframe', 'object', 'embed', 'link', 'meta', 'svg', 'math', 'form', 'template'];

    private const CSS = ['text-align', 'font-weight', 'font-style', 'text-decoration', 'border', 'border-collapse', 'padding', 'width', 'color', 'font-size'];

    /**
     * Whitelist tag & atribut. Tag di luar daftar dibuang tapi teksnya dipertahankan;
     * script/iframe dibuang beserta isinya; semua atribut on*, href, src dibuang.
     */
    public static function sanitize(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        $doc  = new DOMDocument();
        $prev = libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="__root">' . $html . '</div>', LIBXML_NONET | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        $root = $doc->getElementById('__root');
        if (! $root) {
            return '';
        }

        self::clean($root);

        $out = '';
        foreach ($root->childNodes as $c) {
            $out .= $doc->saveHTML($c);
        }

        return $out;
    }

    private static function clean(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (in_array($tag, self::DROP, true)) {
                    $node->removeChild($child);
                    continue;
                }

                self::clean($child);

                if (! in_array($tag, self::TAGS, true)) {
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                    continue;
                }

                foreach (iterator_to_array($child->attributes) as $attr) {
                    $name = strtolower($attr->name);
                    if ($name === 'style') {
                        $safe = self::safeStyle($attr->value);
                        $safe === '' ? $child->removeAttribute('style') : $child->setAttribute('style', $safe);
                    } elseif (! in_array($name, ['colspan', 'rowspan'], true) || ! ctype_digit($attr->value)) {
                        $child->removeAttribute($attr->name);
                    }
                }
            } elseif (! ($child instanceof \DOMText)) {
                $node->removeChild($child); // komentar, CDATA, dll.
            }
        }
    }

    private static function safeStyle(string $style): string
    {
        $keep = [];
        foreach (explode(';', $style) as $decl) {
            [$prop, $val] = array_pad(explode(':', $decl, 2), 2, '');
            $prop = strtolower(trim($prop));
            $val  = trim($val);

            if (! in_array($prop, self::CSS, true) || $val === '') {
                continue;
            }
            // tolak url(), expression(), javascript:, @import, dan karakter kontrol
            if (preg_match('/url\s*\(|expression|javascript|@import|[<>\\\\]/i', $val)) {
                continue;
            }
            $keep[] = "{$prop}:{$val}";
        }

        return implode(';', $keep);
    }
}
