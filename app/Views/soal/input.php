<div class="row">
        <div class="card">
            <div class="card-header d-flex">
                <div class="card-title"><?= $subjudul ?></div>
            </div>
            <form id="input_jadwal_form" action="#" method="post" autocomplete="off">
                <div class="card-body">
                    <div class="form-group">
                        <label>Soal</label>
                        <textarea name="soal" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jawaban A</label>
                        <textarea name="a" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jawaban B</label>
                        <textarea name="b" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jawaban C</label>
                        <textarea name="c" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jawaban D</label>
                        <textarea name="d" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jawaban E</label>
                        <textarea name="e" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kunci Jawaban</label>
                        <select name="jawaban" class="form-control">
                            <option value="">--- Kunci Jawaban ---</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                            <option value="e">E</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bobot</label>
                        <input name="bobot" type="number" class="form-control" placeholder="Bobot">
                    </div>
                    <div class="form-group">
                        <input name="id_jadwal_ujian" class="form-control" value="<?= $soal['id_jadwal_ujian'] ?>" type="hidden">
                    </div>
                    <div class="card-action">
                        <button class="btn btn-secondary me-2">Submit</button>
                        <a href="<?= base_url('soal/lihat/' . $soal['id_jadwal_ujian']) ?>" class="btn btn-danger">Kembali</a>
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
                    url: '<?= base_url('soal/InsertData') ?>',
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
                            window.location.href = '<?= base_url('soal/lihat/' . $soal['id_jadwal_ujian']) ?>';
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
