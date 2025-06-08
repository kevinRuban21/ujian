<?php

namespace App\Controllers;
use App\Models\ModelTahunAjaran;
use App\Models\ModelMapel;
use App\Models\ModelJadwalUjian;

class jadwalUjian extends BaseController
{
    public function __construct() {
        $this->ModelTahunAjaran = new ModelTahunAjaran();
        $this->ModelMapel = new ModelMapel();
        $this->ModelJadwalUjian = new ModelJadwalUjian();
    }

    public function index(): string
    {
        $data = [
            'judul' => 'Jadwal Ujian',
            'subjudul' => 'Jadwal',
            'menu' => 'master-data',
            'submenu' => 'Jadwal',
            'page' => 'jadwal/index',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
        ];
        return view('template_admin', $data);
    }

    public function input(): string
    {
        $data = [
            'judul' => 'Jadwal Ujian',
            'subjudul' => 'Input',
            'menu' => 'master-data',
            'submenu' => 'Jadwal',
            'page' => 'jadwal/input',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
        ];
        return view('template_admin', $data);
    }

    public function InsertData()
    {
        $id_jadwal = $this->request->getPost('id_jadwal');
        $tgl_ujian = $this->request->getPost('tgl_ujian');
        $jenis_ujian = $this->request->getPost('jenis_ujian');
        $waktu_mulai = $this->request->getPost('waktu_mulai');
        $waktu_selesai = $this->request->getPost('waktu_selesai');
        $token = $this->request->getPost('token');

        $validate = $this->validate([
            'jenis_ujian' =>[
                'label' => 'Ujian',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!', 
                ]
            ],
            'id_jadwal' =>[
                'label' => 'Mata Pelajaran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',   
                ]
            ],
            'tgl_ujian' =>[
                'label' => 'Tanggal Ujian',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',  
                ]
            ],
            'waktu_mulai' =>[
                'label' => 'Waktu Mulai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ],
            'waktu_selesai' =>[
                'label' => 'Waktu Selesai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',  
                ]
            ],
            'token' =>[
                'label' => 'Token',
                'rules' => 'required|is_unique[tbl_jadwal_ujian.token]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',
                    'is_unique' => '{field} ini Sudah ada !!!',
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
            'id_jadwal' => $id_jadwal,
            'jenis_ujian' => $jenis_ujian,
            'tgl_ujian' => $tgl_ujian,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'token' => $token,
        ];
        $this->ModelJadwalUjian->InsertData($data);

    }

    public function edit($id_jadwal_ujian): string
    {
        $data = [
            'judul' => 'Jadwal Ujian',
            'subjudul' => 'Edit',
            'menu' => 'master-data',
            'submenu' => 'Jadwal',
            'page' => 'jadwal/edit',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
            'mapel' => $this->ModelJadwalUjian->DetailData($id_jadwal_ujian),
        ];
        return view('template_admin', $data);
    }

    public function UpdateData($id_jadwal_ujian)
    {
        $id_jadwal = $this->request->getPost('id_jadwal');
        $tgl_ujian = $this->request->getPost('tgl_ujian');
        $jenis_ujian = $this->request->getPost('jenis_ujian');
        $waktu_mulai = $this->request->getPost('waktu_mulai');
        $waktu_selesai = $this->request->getPost('waktu_selesai');
        $token = $this->request->getPost('token');

        $validate = $this->validate([
            'jenis_ujian' =>[
                'label' => 'Ujian',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!', 
                ]
            ],
            'id_jadwal' =>[
                'label' => 'Mata Pelajaran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',   
                ]
            ],
            'tgl_ujian' =>[
                'label' => 'Tanggal Ujian',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',  
                ]
            ],
            'waktu_mulai' =>[
                'label' => 'Waktu Mulai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ],
            'waktu_selesai' =>[
                'label' => 'Waktu Selesai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong !!!',  
                ]
            ],
            'token' =>[
                'label' => 'Token',
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
            'id_jadwal' => $id_jadwal,
            'jenis_ujian' => $jenis_ujian,
            'tgl_ujian' => $tgl_ujian,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'token' => $token,
        ];
        $this->ModelJadwalUjian->UpdateData($data);

    }

    public function DeleteData($id_jadwal_ujian){
        $data = [
            'id_jadwal_ujian' => $id_jadwal_ujian,
        ];
        $this->ModelJadwalUjian->DeleteData($data);
        session()->setFlashdata('delete', 'Data Berhasil Dihapus');
        return redirect()->to('jadwalUjian');
    }
}
