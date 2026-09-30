<?php

if (!function_exists('time_ago')) {
    /**
     * Returns a human-readable "time ago" string in Bahasa Indonesia.
     */
    function time_ago(?string $datetime): string
    {
        if (empty($datetime)) return '-';

        $now  = new DateTime();
        $then = new DateTime($datetime);
        $diff = $now->diff($then);

        if ($diff->days === 0 && $diff->h === 0 && $diff->i < 2)  return 'Baru saja';
        if ($diff->days === 0 && $diff->h === 0)                   return $diff->i . ' menit lalu';
        if ($diff->days === 0)                                      return $diff->h . ' jam lalu';
        if ($diff->days === 1)                                      return 'Kemarin';

        return $diff->days . ' hari lalu';
    }
}
