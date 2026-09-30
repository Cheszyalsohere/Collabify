<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div>
    <h1 class="page-title mb-1">Tambah Tugas</h1>
    <p class="page-sub mb-0">Tambahkan tugas baru ke kelompokmu.</p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-7">

        <div class="card">
            <div class="card-body">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <strong>Periksa kembali:</strong>

                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (empty($groups)): ?>

                    <div class="text-center py-4">
                        <i class="ti ti-users-off"
                           style="font-size:38px;color:var(--faint);"></i>

                        <h3 class="mt-3" style="font-size:18px;">
                            Belum punya kelompok
                        </h3>

                        <p class="text-muted">
                            Kamu perlu bergabung atau membuat kelompok terlebih dahulu.
                        </p>

                        <a href="<?= base_url('groups/create') ?>"
                           class="btn btn-primary mr-2">
                            <i class="ti ti-plus mr-1"></i>
                            Buat Kelompok
                        </a>

                        <a href="<?= base_url('groups/join') ?>"
                           class="btn btn-light">
                            Gabung Kelompok
                        </a>
                    </div>

                <?php else: ?>

                    <form action="<?= base_url('tasks/store') ?>" method="post">

                        <?= csrf_field() ?>

                        <!-- KELOMPOK -->
                        <div class="form-group">
                            <label for="id_group">
                                Kelompok
                            </label>

                            <select
                                id="id_group"
                                name="id_group"
                                class="form-control"
                                required>

                                <option value="">
                                    Pilih kelompok
                                </option>

                                <?php foreach ($groups as $group): ?>
                                    <option
                                        value="<?= esc($group['id_group']) ?>"
                                        <?= old('id_group') == $group['id_group'] ? 'selected' : '' ?>>
                                        <?= esc($group['nama_kelompok']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>

                            <small class="form-text text-muted">
                                Pilih kelompok tempat tugas ini dikerjakan.
                            </small>
                        </div>


                        <!-- ASSIGN -->
                        <div class="form-group">

                            <label for="assigned_to">
                                Penanggung jawab
                                <span class="text-muted font-weight-normal">(opsional)</span>
                            </label>

                            <select
                                id="assigned_to"
                                name="assigned_to"
                                class="form-control"
                                disabled>

                                <option value="">
                                    Pilih kelompok terlebih dahulu
                                </option>

                            </select>

                            <small
                                id="memberHelp"
                                class="form-text text-muted">
                                Siapa yang mengerjakan tugas ini? Anggota kelompok muncul setelah kelompok dipilih.
                                Boleh dikosongkan, nanti bisa dibagi lewat Spin.
                            </small>

                        </div>


                        <!-- JUDUL -->
                        <div class="form-group">
                            <label for="judul">
                                Judul Tugas
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                class="form-control"
                                value="<?= old('judul') ?>"
                                placeholder="Contoh: Membuat proposal penelitian"
                                maxlength="200"
                                required>
                        </div>


                        <!-- DESKRIPSI -->
                        <div class="form-group">
                            <label for="deskripsi">
                                Deskripsi
                            </label>

                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                class="form-control"
                                rows="5"
                                placeholder="Tuliskan detail tugas..."><?= old('deskripsi') ?></textarea>
                        </div>


                        <!-- DEADLINE -->
                        <div class="form-group">
                            <label for="deadline">
                                Deadline
                            </label>

                            <input
                                type="date"
                                id="deadline"
                                name="deadline"
                                class="form-control"
                                value="<?= old('deadline') ?>">

                            <small class="form-text text-muted">
                                Kosongkan jika tugas tidak memiliki deadline.
                            </small>
                        </div>


                        <!-- BUTTON -->
                        <div class="d-flex justify-content-between mt-4">

                            <a href="<?= base_url('tasks') ?>"
                               class="btn btn-light">
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="ti ti-plus mr-1"></i>
                                Tambah Tugas

                            </button>

                        </div>

                    </form>

                <?php endif; ?>

            </div>
        </div>

    </div>
</div>


<style>

#assigned_to:disabled {
    background-color: var(--paper);
    cursor: not-allowed;
}

.member-loading {
    opacity: .65;
}

</style>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const groupSelect = document.getElementById('id_group');
    const memberSelect = document.getElementById('assigned_to');
    const memberHelp   = document.getElementById('memberHelp');

    if (!groupSelect || !memberSelect) {
        return;
    }

    groupSelect.addEventListener('change', function () {

        const groupId = this.value;

        memberSelect.innerHTML =
            '<option value="">Memuat anggota...</option>';

        memberSelect.disabled = true;

        if (!groupId) {

            memberSelect.innerHTML =
                '<option value="">Pilih kelompok terlebih dahulu</option>';

            memberHelp.textContent =
                'Anggota kelompok akan muncul setelah kelompok dipilih.';

            return;
        }

        memberSelect.classList.add('member-loading');

        fetch('<?= base_url('groups') ?>/' + groupId + '/members')
            .then(response => {

                if (!response.ok) {
                    throw new Error('Gagal mengambil data anggota.');
                }

                return response.json();

            })
            .then(data => {

                memberSelect.classList.remove('member-loading');

                if (!data.success || !data.members.length) {

                    memberSelect.innerHTML =
                        '<option value="">Belum ada anggota</option>';

                    memberHelp.textContent =
                        'Kelompok ini belum memiliki anggota.';

                    return;
                }

                memberSelect.innerHTML =
                    '<option value="">Belum ditentukan (bisa dibagi lewat Spin)</option>';

                data.members.forEach(function (member) {

                    const option = document.createElement('option');

                    option.value = member.id_user;

                    option.textContent =
                        member.name +
                        (member.peran === 'ketua'
                            ? ' — Ketua'
                            : ' — Anggota');

                    memberSelect.appendChild(option);

                });

                memberSelect.disabled = false;

                memberHelp.textContent =
                    'Boleh dikosongkan dan dibagi nanti lewat Spin. ' +
                    data.members.length +
                    ' anggota di kelompok ini.';

            })
            .catch(error => {

                console.error(error);

                memberSelect.classList.remove('member-loading');

                memberSelect.innerHTML =
                    '<option value="">Gagal memuat anggota</option>';

                memberHelp.textContent =
                    'Terjadi kesalahan saat mengambil anggota kelompok.';

            });

    });

});

</script>

<?= $this->endSection() ?>
