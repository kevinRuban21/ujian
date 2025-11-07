<div class="row">
        <div class="card">
            <div class="card-header d-flex">
                <div class="card-title">
                  <?= $judul ?>
                </div>
                <div class="card-tools ms-auto">
                     
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="display table table-striped table-hover" id="basic-datatables">
                    <thead>
                        <tr>
                          <th width="5px">#</th>
                          <th>Ujian</th>
                          <th>Jurusan</th>
                          <th>Kelas</th>
                          <th>Mata Pelajaran</th>
                          <th>Jumlah Soal</th>
                          <th>Benar</th>
                          <th>Salah</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; 
                        $db = \Config\Database::connect();
                        $jadwal = $db->table('tbl_jadwal_ujian')
                            ->join('tbl_jadwal_pelajaran', 'tbl_jadwal_pelajaran.id_jadwal=tbl_jadwal_ujian.id_jadwal', 'LEFT')
                            ->join('tbl_mapel', 'tbl_mapel.id_mapel=tbl_jadwal_pelajaran.id_mapel', 'LEFT')
                            ->join('tbl_guru', 'tbl_guru.id_guru=tbl_jadwal_pelajaran.id_guru', 'LEFT')
                            ->join('tbl_kelas', 'tbl_kelas.id_kelas=tbl_jadwal_pelajaran.id_kelas', 'LEFT')
                            ->join('tbl_jurusan', 'tbl_jurusan.id_jurusan=tbl_jadwal_pelajaran.id_jurusan', 'LEFT')
                            ->join('tbl_ta', 'tbl_ta.id_ta=tbl_jadwal_pelajaran.id_ta', 'LEFT')
                            ->where('tbl_jadwal_pelajaran.id_ta', $ta_aktif['id_ta'])
                            ->where('tbl_jadwal_pelajaran.id_kelas', session()->get('id_kelas'))
                            ->get()->getResultArray();

                        foreach($jadwal as $key => $d){ 

                            $jmlhSoal = $db->table('tbl_jawaban')
                                ->join('tbl_soal', 'tbl_soal.id_soal=tbl_jawaban.id_soal', 'LEFT')
                                ->join('tbl_jadwal_ujian', 'tbl_jadwal_ujian.id_jadwal_ujian=tbl_soal.id_jadwal_ujian', 'LEFT')
                                ->where('tbl_soal.id_jadwal_ujian', $d['id_jadwal_ujian'])
                                ->where('tbl_jawaban.id_siswa', session()->get('id_siswa'))
                                ->countAllResults();
                            $jawaban  = $db->table('tbl_soal')
                                ->join('tbl_jawaban', 'tbl_jawaban.id_soal=tbl_soal.id_soal', 'LEFT')
                                ->where('tbl_jawaban.id_siswa', session()->get('id_siswa'))
                                ->where('tbl_soal.id_jadwal_ujian', $d['id_jadwal_ujian'])
                                ->get()->getResultArray();

                            $jumlahBenar = 0;
                            $jumlahSalah = 0;
                            
                            foreach ($jawaban as $key => $j) {
                              if ($j['jawaban'] == $j['kunci_jawaban']) {
                                $jumlahBenar++;
                              }else{
                                $jumlahSalah++;
                              }
                            }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['jenis_ujian'] ?></td>
                            <td><?= $d['jurusan'] ?></td>
                            <td><?= $d['kelas'] ?></td>
                            <td><?= $d['mapel'] ?></td>
                            <td><?= $jmlhSoal ?></td>
                            <td><?= $jumlahBenar ?></td>
                            <td><?= $jumlahSalah ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });
    });
</script>

<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success'); ?>',
            timer: 1500,
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error'); ?>',
            timer: 1500,
        });
    </script>
<?php endif; ?>
            