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
            title: 'Oops...',
            text: '<?= session()->getFlashdata('error'); ?>',
            timer: 1500,
        });
    </script>
<?php endif; ?>

<?php $no=1; 
    $db = \Config\Database::connect();
    $soal = $db->table('tbl_soal')
                ->join('tbl_jadwal_ujian', 'tbl_jadwal_ujian.id_jadwal=tbl_soal.id_jadwal_ujian', 'LEFT')
                ->where('tbl_soal.id_jadwal_ujian', $ujian['id_jadwal_ujian'])
                ->get()->getResultArray();
?>

<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Soal Ujian</h4>
		</div>
		<div class="card-body">
			<div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                        <?php $no=1; foreach ($soal as $key => $d) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $no == '1' ? 'active' : ''  ?>" id="pills-<?= $d['id_soal'] ?>-tab" data-bs-toggle="pill" href="#soal<?= $d['id_soal'] ?>" role="tab" aria-controls="pills-<?= $d['id_soal'] ?>"><?= $no++ ?></a>
                            </li>
                        <?php } ?>
                    </ul>
			    </div>
                <div class="col-md-9">
                    <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                        <?php $no=1; foreach ($soal as $key => $d) : ?>
                            <div class="tab-pane question-item fade <?= $no == '1' ? 'show active' : ''  ?>" id="soal<?= $d['id_soal'] ?>" role="tabpanel" aria-labelledby="pills-<?= $d['id_soal'] ?>-tab">
                                <?php $no++ ?>
                            <form id="input_jawaban_form" action="<?= base_url('ujian/selesai') ?>" method="POST">
                                <p><?= $d['soal'] ?></p>
                                <div class="form-check">
                                    <input type="hidden" name="jawaban[<?= $d['id_soal'] ?>][id_soal]" value="<?= $d['id_soal'] ?>">
                                    <input class="form-check-input" type="radio" value="a" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_a">
                                    <label class="form-check-label" for="flexRadioDefault1_<?= $d['id_soal'] ?>_a">
                                        A : <?= $d['a'] ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="jawaban[<?= $d['id_soal'] ?>][id_soal]" value="<?= $d['id_soal'] ?>">
                                    <input class="form-check-input" type="radio" value="b" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_b">
                                    <label class="form-check-label" for="flexRadioDefault1_<?= $d['id_soal'] ?>_b">
                                        B : <?= $d['b'] ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="jawaban[<?= $d['id_soal'] ?>][id_soal]" value="<?= $d['id_soal'] ?>">
                                    <input class="form-check-input" type="radio" value="c" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_c">
                                    <label class="form-check-label" for="flexRadioDefault1_<?= $d['id_soal'] ?>_c">
                                        C : <?= $d['c'] ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="jawaban[<?= $d['id_soal'] ?>][id_soal]" value="<?= $d['id_soal'] ?>">
                                    <input class="form-check-input" type="radio" value="d" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_d">
                                    <label class="form-check-label" for="flexRadioDefault_<?= $d['id_soal'] ?>_d">
                                        D : <?= $d['d'] ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="jawaban[<?= $d['id_soal'] ?>][id_soal]" value="<?= $d['id_soal'] ?>">
                                    <input class="form-check-input" type="radio" value="e" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_e">
                                    <label class="form-check-label" for="flexRadioDefault1_<?= $d['id_soal'] ?>_e">
                                        E : <?= $d['e'] ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
		</div>
            <div class="card-action">
                <button type="button" onclick="confirmSubmission()" class="btn btn-danger me-2">Akhiri Ujian !!!</button>
            </div>
        </form>
	</div>
</div>

    <script>
        function confirmSubmission() {
            Swal.fire({
                title: 'Yakin ingin mengakhiri Ujian?',
                text: "Pastikan semua soal telah dijawab!!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Akhiri!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('input_jawaban_form').submit();
                }
            });
        }
    </script>