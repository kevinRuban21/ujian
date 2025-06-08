<div class="row">
        <div class="card">
            <div class="card-header d-flex">
                <div class="card-title"><?= $subjudul ?></div>
            </div>
            <form id="input_jadwal_form" action="#" method="post" autocomplete="off">
                <div class="card-body">
                    <div class="form-group">
                        <label>Ujian</label>
                        <select name="jenis_ujian" class="form-control">\
                            <option value="Ujian Tengah Semester">Ujian Tengah Semester</option>
                            <option value="Ujian Akhir Semester">Ujian Akhir Semester</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select name="id_jadwal" class="form-control">
                            <option value="">--Pilih Mapel--</option>
                            <?php
                                $db = \Config\Database::connect();
                                $jadwal = $db->table('tbl_jadwal_pelajaran')
                                ->join('tbl_mapel', 'tbl_mapel.id_mapel=tbl_jadwal_pelajaran.id_mapel', 'LEFT')
                                ->join('tbl_guru', 'tbl_guru.id_guru=tbl_jadwal_pelajaran.id_guru', 'LEFT')
                                ->join('tbl_kelas', 'tbl_kelas.id_kelas=tbl_jadwal_pelajaran.id_kelas', 'LEFT')
                                ->join('tbl_jurusan', 'tbl_jurusan.id_jurusan=tbl_jadwal_pelajaran.id_jurusan', 'LEFT')
                                ->join('tbl_ta', 'tbl_ta.id_ta=tbl_jadwal_pelajaran.id_ta', 'LEFT')
                                ->where('tbl_jadwal_pelajaran.id_ta', $ta_aktif['id_ta'])
                                ->get()->getResultArray();
                             foreach ($jadwal as $key => $k) { ?>
                                <option value="<?= $k['id_jadwal'] ?>"><?= $k['jurusan'] ?> | <?= $k['kelas'] ?> | <?= $k['mapel'] ?></option>
                            <?php }  ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Ujian</label>
                        <input type="date" name="tgl_ujian" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" class="form-control">
                    <div class="form-group">
                        <label>Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Token</label>
                        <input name="token" class="form-control" placeholder="Token">
                    </div>
                    <div class="card-action">
                        <button class="btn btn-secondary me-2">Submit</button>
                        <a href="<?= base_url('jadwalUjian') ?>" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </form>
          </div>
</div>

        <script>
          $(document).ready(function() {
            $('#input_jadwal_form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= base_url('jadwalUjian/InsertData') ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan:',
                                html: '<ul>' +
                                    $.map(response.errors, function(value, index) {
                                        return '<li>' + value + '</li>';
                                    }).join('') +
                                    '</ul>'
                            });
                        } else {
                            window.location.href = '<?= base_url('jadwalUjian') ?>';
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan!',
                                timer: 1000,
                            });
                        }
                    }
                });
            });
        });

        
    </script>
