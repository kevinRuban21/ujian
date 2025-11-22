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

    public function summernote()
    {
        $validationRule = [
            'soal' => [
                'label' => 'Image File',
                'rules' => 'uploaded[soal]'
                       . '|is_image[soal]'
                       . '|mime_in[soal,image/jpg,image/jpeg,image/gif,image/png]'
                       . '|max_size[soal,2048]', // Max 2MB
            ],
        ];

        if (! $this->validate($validationRule)) {
            // Gagal validasi
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengunggah gambar: ' . $this->validator->getError('soal')
            ])->setStatusCode(400);
        }

        $img = $this->request->getFile('soal');
        
        // Cek apakah file benar-benar diunggah
        if ($img->isValid() && ! $img->hasMoved())
        {
            // Tentukan folder penyimpanan (misalnya: public/uploads/summernote)
            $filepath = 'img/soal/';
            
            // Generate nama file baru yang unik
            $newName = $img->getRandomName();

            // Pindahkan file ke folder tujuan
            $img->move(FCPATH . $filepath, $newName);
            
            // Kembalikan URL gambar ke Summernote
            return $this->response->setJSON([
                'status' => 'success',
                // URL publik yang dapat diakses oleh browser
                'url' => base_url($filepath . $newName) 
            ]);
        }

        // Gagal menyimpan
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal memproses file.'
        ])->setStatusCode(500);
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
            'kunci_jawaban' => $jawaban,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'e' => $e,
        ];
        $this->ModelSoal->InsertData($data);

    }
}
