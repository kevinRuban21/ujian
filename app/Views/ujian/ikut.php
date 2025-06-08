<div class="row">
    <div class="card">
        <div class="card-header d-flex">
            <div class="card-title"><?= $subjudul ?></div>
        </div>
        <?php echo form_open('ujian/CekToken/' . $ujian['id_jadwal_ujian']) ?>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width='150px'>Ujian</th>
                        <td>:</td>
                        <td><?= $ujian['jenis_ujian'] ?></td>
                    </tr>
                    <tr>
                        <th width='150px'>Jurusan</th>
                        <td>:</td>
                        <td><?= $ujian['jurusan'] ?></td>
                    </tr>
                    <tr>
                        <th width='150px'>Kelas</th>
                        <td>:</td>
                        <td><?= $ujian['kelas'] ?></td>
                    </tr>
                    <tr>
                        <th  width='150px'>Mata Pelajaran</th>
                        <td>:</td>
                        <td><?= $ujian['mapel'] ?></td>
                    </tr>
                    <tr>
                        <th  width='150px'>Guru Mapel</th>
                        <td>:</td>
                        <td><?= $ujian['nama_guru'] ?></td>
                    </tr>
                    <tr>
                        <th  width='150px'>Waktu Pengerjaan</th>
                        <td>:</td>
                        <td><?= date('H:i', strtotime($ujian['waktu_mulai']))?>-<?= date('H:i', strtotime($ujian['waktu_selesai']))?></td>
                    </tr>
                </table><br>
                <div class="form-group">
                    <label>Token</label>
                    <input type="text" name="token" class="form-control" placeholder="Masukkan Token" required>
                </div>
                <div class="card-action">
                    <button class="btn btn-secondary me-2">Masuk</button>
                </div>
            </div>
        <?php echo form_close() ?>
    </div>
</div>

<?php if (session()->getFlashdata('errors')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops..',
            text: '<?= session()->getFlashdata('errors'); ?>',
            timer: 1500,
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('warning')) : ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: '<?= session()->getFlashdata('warning'); ?>',
            timer: 1500,
        });
    </script>
<?php endif; ?>
