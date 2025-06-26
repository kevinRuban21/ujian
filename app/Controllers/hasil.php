<?php

namespace App\Controllers;
use App\Models\ModelTahunAjaran;
use App\Models\ModelJawaban;
use App\Models\ModelSoal;
use App\Models\ModelJadwalUjian;

class hasil extends BaseController
{
    public function __construct() {
        $this->ModelTahunAjaran = new ModelTahunAjaran();
    }

    public function index(): string
    {
        $idPengguna = session()->get('id_siswa');

        $soalModel = new ModelSoal();
        $jawabanPesertaModel = new ModelJawaban();
        $jadwalUjianModel = new ModelJadwalUjian();

         // Ambil semua soal dan kunci jawabannya
        $dataSoal = $soalModel->findAll();
        $kunciJawaban = [];
        foreach ($dataSoal as $soal) {
            $kunciJawaban[$soal['id_soal']] = $soal['jawaban'];
        }

        // Ambil jawaban peserta untuk pengguna ini
        $jawabanPeserta = $jawabanPesertaModel->where('id_siswa', $idPengguna)->findAll();

        $jumlahBenar = 0;
        $jumlahSalah = 0;

        foreach ($jawabanPeserta as $jawaban) {
            $idSoal = $jawaban['id_soal'];
            $jawabanDipilih = $jawaban['jawaban'];

            // Bandingkan jawaban peserta dengan kunci jawaban
            if (isset($kunciJawaban[$idSoal]) && strtoupper($jawabanDipilih) === strtoupper($kunciJawaban[$idSoal])) {
                $jumlahBenar++;
            } else {
                $jumlahSalah++;
            }
        }

        $data = [
            'judul' => 'Hasil Ujian',
            'subjudul' => 'Hasil Ujian',
            'menu' => 'master-data',
            'submenu' => 'hasil',
            'page' => 'hasil/index',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
            'jumlahBenar' => $jumlahBenar,
            'jumlahSalah' => $jumlahSalah,
            'totalSoal'   => count($dataSoal),
        ];
        return view('template_siswa', $data);
    }
}
