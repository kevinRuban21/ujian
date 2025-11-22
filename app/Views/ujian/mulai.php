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
                ->join('tbl_jadwal_ujian', 'tbl_jadwal_ujian.id_jadwal_ujian=tbl_soal.id_jadwal_ujian', 'LEFT')
                ->where('tbl_soal.id_jadwal_ujian', $ujian['id_jadwal_ujian'])
                ->get()->getResultArray();
?>

<style>
    .answered {
        background-color: #28a745; /* Green */
        color: #fff !important;
        border-color: #28a745;
    }
</style>

<div class="col-md-12">
	<div class="card">
		<div class="card-header d-flex">
			<h4 class="card-title">Soal Ujian</h4>
            <div class="card-tools ms-auto">
                <span id="countdown" class="h5" style="font-weight: bold;"></span>
            </div>
		</div>
		<div class="card-body">
			<div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12">
                    <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                        <?php $no=1; foreach ($soal as $key => $d) { ?>
                            <li class="nav-item">
                                <a class="nav-link nav-soal-<?= $d['id_soal'] ?> <?= $no == '1' ? 'active' : ''  ?>" id="pills-<?= $d['id_soal'] ?>-tab" data-bs-toggle="pill" href="#soal<?= $d['id_soal'] ?>" role="tab" data-qId="<?= $d['id_soal'] ?>" aria-controls="pills-<?= $d['id_soal'] ?>"><?= $no++ ?></a>
                            </li>
                        <?php } ?>
                    </ul>
			    </div>
                <div class="col-md-9 col-lg-9 col-sm-12">
                    <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                        <?php $no=1; foreach ($soal as $key => $d) : ?>
                            <div class="tab-pane question-item fade <?= $no == '1' ? 'show active' : ''  ?>" id="soal<?= $d['id_soal'] ?>" role="tabpanel" aria-labelledby="pills-<?= $d['id_soal'] ?>-tab">
                                <?php $no++ ?>
                            <form id="input_jawaban_form" action="<?= base_url('ujian/selesai/' . $d['id_jadwal']) ?>" method="POST">
                                <p style="width: 100%;"><?= $d['soal'] ?></p>

                                <!-- Hidden input untuk ID Soal, CUKUP SATU PER SOAL -->
                                <input type="hidden" name="jawaban[<?= $d['id_soal'] ?>][id_soal]" value="<?= $d['id_soal'] ?>">

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="a" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_a" onchange="markAnswered(<?= $d['id_soal'] ?>)">
                                    <label class="form-check-label" for="flexRadioDefault1_<?= $d['id_soal'] ?>_a">
                                        <p>A : <?= $d['a'] ?></p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="b" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_b" onchange="markAnswered(<?= $d['id_soal'] ?>)">
                                    <label class="form-check-label" for="flexRadioDefault1_<?= $d['id_soal'] ?>_b">
                                        B : <?= $d['b'] ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="c" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_c" onchange="markAnswered(<?= $d['id_soal'] ?>)">
                                    <label class="form-check-label" for="flexRadioDefault1_<?= $d['id_soal'] ?>_c">
                                        C : <?= $d['c'] ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="d" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_d" onchange="markAnswered(<?= $d['id_soal'] ?>)">
                                    <label class="form-check-label" for="flexRadioDefault_<?= $d['id_soal'] ?>_d">
                                        D : <?= $d['d'] ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="e" name="jawaban[<?= $d['id_soal'] ?>][pilihan]" id="flexRadioDefault1_<?= $d['id_soal'] ?>_e" onchange="markAnswered(<?= $d['id_soal'] ?>)">
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
        function markAnswered(soalId) {
            // Menggunakan querySelector untuk menemukan elemen navigasi dengan class yang spesifik
            const navLink = document.querySelector(`.nav-soal-${soalId}`);
            if (navLink) {
                navLink.classList.add('answered'); // Menambahkan kelas 'answered'
            }
        }
    </script>

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

    
    <script>
        // Tanggal target (ganti dengan tanggal yang Anda inginkan)
        // Format: "Month Day, Year HH:MM:SS"
        const targetDate = new Date("<?= $ujian['tgl_ujian'] ?>, <?= $ujian['waktu_selesai'] ?>").getTime();

        // Dapatkan elemen HTML untuk menampilkan countdown
        const countdownElement = document.getElementById("countdown");

        // Fungsi untuk memperbarui countdown setiap detik
        const updateCountdown = () => {
            // Dapatkan waktu saat ini
            const now = new Date().getTime();

            // Hitung selisih waktu
            const distance = targetDate - now;

            // Jika countdown sudah selesai
            if (distance < 0) {
                countdownElement.innerHTML = "Waktu Habis!";
                document.getElementById('input_jawaban_form').submit();
                clearInterval(countdownInterval); // Hentikan interval
                return;
            }

            // Konversi milidetik ke hari, jam, menit, dan detik
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan hasil di elemen HTML
            countdownElement.innerHTML = `${hours} : ${minutes} : ${seconds}`;
        };

        // Panggil fungsi updateCountdown setiap detik
        const countdownInterval = setInterval(updateCountdown, 1000);

        // Panggil sekali saat pertama kali dimuat untuk menghindari jeda awal
        updateCountdown();
    </script>