
<div class="row">
        <div class="card">
            <div class="card-header d-flex">
                <div class="card-title">
                  <?= $subjudul ?>
                </div>
                <div class="card-tools ms-auto">
                    <a href="<?= base_url('soal/input/' . $jadwal['id_jadwal_ujian']) ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a> 
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <th width='150px'>Ujian</th>
                        <td>:</td>
                        <td><?= $jadwal['jenis_ujian'] ?></td>
                    </tr>
                    <tr>
                        <th width='150px'>Jurusan</th>
                        <td>:</td>
                        <td><?= $jadwal['jurusan'] ?></td>
                    </tr>
                    <tr>
                        <th width='150px'>Kelas</th>
                        <td>:</td>
                        <td><?= $jadwal['kelas'] ?></td>
                    </tr>
                    <tr>
                        <th  width='150px'>Mata Pelajaran</th>
                        <td>:</td>
                        <td><?= $jadwal['mapel'] ?></td>
                    </tr>
                    <tr>
                        <th  width='150px'>Tahun Pelajaran</th>
                        <td>:</td>
                        <td><?= $ta_aktif['semester'] ?>-<?= $ta_aktif['ta'] ?></td>
                    </tr>
                </table><br>
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
                          <th>Soal</th>
                          <th>Kunci Jawaban</th>
                          <th>Bobot</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; 
                        $db = \Config\Database::connect();
                        $soal = $db->table('tbl_soal')
                            ->join('tbl_jadwal_ujian', 'tbl_jadwal_ujian.id_jadwal_ujian=tbl_soal.id_jadwal_ujian', 'LEFT')
                            ->join('tbl_jadwal_pelajaran', 'tbl_jadwal_pelajaran.id_jadwal=tbl_jadwal_ujian.id_jadwal', 'LEFT')
                            ->join('tbl_mapel', 'tbl_mapel.id_mapel=tbl_jadwal_pelajaran.id_mapel', 'LEFT')
                            ->join('tbl_guru', 'tbl_guru.id_guru=tbl_jadwal_pelajaran.id_guru', 'LEFT')
                            ->join('tbl_kelas', 'tbl_kelas.id_kelas=tbl_jadwal_pelajaran.id_kelas', 'LEFT')
                            ->join('tbl_jurusan', 'tbl_jurusan.id_jurusan=tbl_jadwal_pelajaran.id_jurusan', 'LEFT')
                            ->join('tbl_ta', 'tbl_ta.id_ta=tbl_jadwal_pelajaran.id_ta', 'LEFT')
                            ->where('tbl_jadwal_pelajaran.id_ta', $ta_aktif['id_ta'])
                            ->where('tbl_jadwal_pelajaran.id_guru', session()->get('id_guru'))
                            ->get()->getResultArray();
                        foreach($soal as $key => $d){ 
                      ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['soal'] ?></td>
                            <td class="text-uppercase"><?= $d['jawaban'] ?></td>
                            <td><?= $d['bobot'] ?></td>
                            <td>
                                <a href="<?= base_url('soal/edit/' . $d['id_soal']) ?>" class="btn btn-warning btn-sm my-2"><i class="icon-pencil"></i> Edit Data</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('#btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah link langsung navigasi

                const productId = this.dataset.id;
                const deleteUrl = `<?= base_url('jadwalUjian/DeleteData/') ?>${productId}`;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengklik "Ya, hapus!", arahkan ke URL penghapusan
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    });
</script>
            