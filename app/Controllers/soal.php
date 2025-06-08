<?php

namespace App\Controllers;
use App\Models\ModelTahunAjaran;
use App\Models\ModelMapel;
use App\Models\ModelJadwalUjian;
use App\Models\ModelSoal;

class soal extends BaseController
{
    public function __construct() {
        $this->ModelTahunAjaran = new ModelTahunAjaran();
        $this->ModelMapel = new ModelMapel();
        $this->ModelJadwalUjian = new ModelJadwalUjian();
        $this->ModelSoal = new ModelSoal();
    }

    public function index(): string
    {
        $data = [
            'judul' => 'Bank Soal',
            'subjudul' => 'Bank Soal',
            'menu' => 'master-data',
            'submenu' => 'soal',
            'page' => 'soal/index',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
            // 'soal' => $this->ModelJadwalUjian->AllData(), 
        ];
        return view('template_guru', $data);
    }

    public function lihat($id_jadwal_ujian)
    {
        $data = [
            'judul' => 'Bank Soal',
            'subjudul' => 'Buat Soal',
            'menu' => 'master-data',
            'submenu' => 'soal',
            'page' => 'soal/buat',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
            'jadwal' => $this->ModelJadwalUjian->DetailData($id_jadwal_ujian),
        ];
        return view('template_guru', $data);
    }

    public function input($id_jadwal_ujian)
    {
        $data = [
            'judul' => 'Bank Soal',
            'subjudul' => 'Input Soal',
            'menu' => 'master-data',
            'submenu' => 'soal',
            'page' => 'soal/input',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
            'soal' => $this->ModelJadwalUjian->DetailData($id_jadwal_ujian),
        ];
        return view('template_guru', $data);
    }

    public function InsertData()
    {
        $id_jadwal_ujian = $this->request->getPost('id_jadwal_ujian');
        $soal = $this->request->getPost('soal');
        $jawaban = $this->request->getPost('jawaban');
        $a = $this->request->getPost('a');
        $b = $this->request->getPost('b');
        $c = $this->request->getPost('c');
        $d = $this->request->getPost('d');
        $e = $this->request->getPost('e');
        $bobot = $this->request->getPost('bobot');

        $validate = $this->validate([
            'soal' =>[
                'label' => 'Soal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',
                ]
            ],
            'jawaban' =>[
                'label' => 'Kunci Jawaban',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',   
                ]
            ],
            'a' =>[
                'label' => 'Jawaban A',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',  
                ]
            ],
            'b' =>[
                'label' => 'Jawaban B',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ],
            'c' =>[
                'label' => 'Jawaban C',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',  
                ]
            ],
            'd' =>[
                'label' => 'Jawaban D',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',
                ]
            ],
            'e' =>[
                'label' => 'Jawaban E',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',
                ]
            ],
            'bobot' =>[
                'label' => 'Bobot',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',
                ]
            ],
        ]);

        if(!$validate){
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
    
        $data = [
            'id_jadwal_ujian' => $id_jadwal_ujian,
            'soal' => $soal,
            'jawaban' => $jawaban,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'e' => $e,
            'bobot' => $bobot,
        ];
        $this->ModelSoal->InsertData($data);

    }
}
