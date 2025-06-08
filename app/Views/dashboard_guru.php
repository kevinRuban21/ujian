<?php

      use CodeIgniter\Database\BaseUtils;

  if(session()->get('pesan')){
      echo '<div class="alert alert-primary">';
      echo '<div class="d-flex align-items-center gap-2">';
      echo '<h1><i class="fas fa-info-circle"></i></h1> ';
      echo session()->get('pesan');
      echo '</div>';
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

<div class="row">
  <div class="col"></div>
  <div class="col">
    <img src="<?= base_url('img/logo2.ico') ?>" alt="" style="width: 200px;">
  </div>
  <div class="col"></div>
  <h1 class="text-center">Selamat Datang di Sistem Ujian Berbasis Online</h1>
  <h1 class="text-center"><?= $sekolah['nama_sekolah'] ?></h1>
</div>
            