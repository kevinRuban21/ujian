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
  <div class="col-sm-6 col-md-3">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-warning bubble-shadow-small">
              <i class="fas fa-users"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Siswa</p>
              <h4 class="card-title"><?= $jmlh_siswa ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-3">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-success bubble-shadow-small">
              <i class="fas fa-user-friends"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Guru</p>
              <h4 class="card-title"><?= $jmlh_guru ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-3">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-danger bubble-shadow-small">
              <i class="fas fa-university"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Jurusan</p>
              <h4 class="card-title"><?= $jmlh_jurusan ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-3">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-secondary bubble-shadow-small">
              <i class="fas fa-school"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Kelas</p>
              <h4 class="card-title"><?= $jmlh_kelas ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
            