
<div class="row">
        <div class="card">
            <div class="card-header d-flex">
                <div class="card-title">
                  <?= $judul ?>
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
                          <th>Jurusan</th>
                          <th>Kelas</th>
                          <th>Mata Pelajaran</th>
                          <th>Guru</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; 
                        $db = \Config\Database::connect();
                        $jadwal = $db->table('tbl_jadwal_pelajaran')
                            ->join('tbl_mapel', 'tbl_mapel.id_mapel=tbl_jadwal_pelajaran.id_mapel', 'LEFT')
                            ->join('tbl_guru', 'tbl_guru.id_guru=tbl_jadwal_pelajaran.id_guru', 'LEFT')
                            ->join('tbl_kelas', 'tbl_kelas.id_kelas=tbl_jadwal_pelajaran.id_kelas', 'LEFT')
                            ->join('tbl_jurusan', 'tbl_jurusan.id_jurusan=tbl_jadwal_pelajaran.id_jurusan', 'LEFT')
                            ->join('tbl_ta', 'tbl_ta.id_ta=tbl_jadwal_pelajaran.id_ta', 'LEFT')
                            ->where('tbl_jadwal_pelajaran.id_ta', $ta_aktif['id_ta'])
                            ->get()->getResultArray();

                        foreach($jadwal as $key => $d){ 
                      ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['jurusan'] ?></td>
                            <td><?= $d['kelas'] ?></td>
                            <td><?= $d['mapel'] ?></td>
                            <td><?= $d['nama_guru'] ?></td>
                            <td>
                                <a href="<?= base_url('mapel/settings/' . $d['id_jadwal']) ?>" class="btn btn-primary btn-sm my-2"><i class="fas fa-cog"></i> Setting</a>
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
            