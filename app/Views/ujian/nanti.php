
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
            <?php

                use CodeIgniter\Database\BaseUtils;

                if(session()->get('insert')){
                  echo '<div class="alert alert-primary">';
                  echo session()->get('insert');
                  echo '</div>';
                  echo '<script>
                    $(document).ready(function(){
                      $(".alert").fadeIn();
                      setTimeout(function(){
                          $(".alert").fadeOut();
                      }, 3000);
                    });
                  </script>';
                }
                if(session()->get('update')){
                  echo '<div class="alert alert-primary">';
                  echo session()->get('update');
                  echo '</div>';
                  echo '<script>
                  $(document).ready(function(){
                    $(".alert").fadeIn();
                    setTimeout(function(){
                        $(".alert").fadeOut();
                    }, 3000);
                  });
                  </script>';
                }
                if(session()->get('delete')){
                  echo '<div class="alert alert-danger">';
                  echo session()->get('delete');
                  echo '</div>';
                  echo '<script>
                    $(document).ready(function(){
                      $(".alert").fadeIn();
                      setTimeout(function(){
                          $(".alert").fadeOut();
                      }, 3000);
                    });
                </script>';
                }
              ?>
                <table class="display table table-striped table-hover" id="basic-datatables">
                    <thead>
                        <tr>
                          <th width="5px">#</th>
                          <th>Ujian</th>
                          <th>Jurusan</th>
                          <th>Kelas</th>
                          <th>Mata Pelajaran</th>
                          <th>Tanggal Ujian</th>
                          <th>Waktu Ujian</th>
                          <th>Aksi</th>
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
                            date_default_timezone_set('Asia/Jayapura');
                            $tgl = date('d M Y', strtotime($d['tgl_ujian']));
                            $angka = date('l', strtotime($d['tgl_ujian']));
                            $hari = [
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                                'Sunday' => 'Minggu',
                            ];
                      ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['jenis_ujian'] ?></td>
                            <td><?= $d['jurusan'] ?></td>
                            <td><?= $d['kelas'] ?></td>
                            <td><?= $d['mapel'] ?></td>
                            <td><?= $hari[$angka] ?>,<?= $tgl ?></td>
                            <td><?= date('H:i', strtotime($d['waktu_mulai']))?>-<?= date('H:i', strtotime($d['waktu_selesai']))?></td>
                            <td>
                                <?php if ($d['tgl_ujian'] == date('Y-m-d') && $d['waktu_mulai'] == date('H-i-s')) { ?>
                                    <a href="<?= base_url('ujian/ikut/' . $d['id_jadwal_ujian']) ?>" class="btn btn-primary btn-sm my-2"><i class="icon-pencil"></i> Ikut Ujian</a>
                                <?php } elseif ($d['tgl_ujian'] == date('Y-m-d') && $d['waktu_mulai'] > date('H-i-s')) { ?>
                                    <p>Ujian Belum Dimulai</p>
                                <?php } elseif ($d['tgl_ujian'] > date('Y-m-d')) { ?>
                                    <p>Ujian Belum Dimulai</p>
                                <?php } else { ?>
                                    <p>Ujian Telah Berakhir</p>
                                <?php } ?>
                            </td>
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
            