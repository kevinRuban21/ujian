<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelSekolah;
use App\Models\ModelAuth;

class Auth extends BaseController
{
    public function __construct() {
        $this->ModelSekolah = new ModelSekolah();
        $this->ModelAuth = new ModelAuth();
    }

    public function index()
    {
        $data = [
            'judul' => 'Login',
            'subjudul' => '',
            'sekolah' => $this->ModelSekolah->DetailData(),
        ];
        return view('login', $data);
    }

    public function CekLogin(){
        if($this->validate([
            'username' =>[
                'label' => 'username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ],
            'level' =>[
                'label' => 'Level User',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ],
            'password' =>[
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ]
        ])){
            // jika Valid
            $username = $this->request->getPost('username');
            $level = $this->request->getPost('level');
            $password= $this->request->getPost('password');

            if($level == 1){
                $cek = $this->ModelAuth->LoginUser($username, $password);
                if($cek){
                    session()->set('id_user', $cek['id_user']);
                    session()->set('level', $level);
                    session()->set('nama_user', $cek['nama_user']);
                    session()->set('foto', $cek['foto']);
                    session()->setFlashdata('pesan', 'Selamat Datang ' . session()->get('nama_user'));
                    return redirect()->to('DashboardAdmin');
                }else{
                    session()->setFlashdata('pesan', 'Username atau Password Salah !!!');
                    return redirect()->to('Auth');
                }
            }else if($level == 2){
                $cek = $this->ModelAuth->LoginGuru($username, $password);
                if($cek){
                    session()->set('id_guru', $cek['id_guru']);
                    session()->set('level', $level);
                    session()->set('nama_guru', $cek['nama_guru']);
                    session()->set('foto_guru', $cek['foto_guru']);
                    session()->setFlashdata('pesan', 'Selamat Datang ' . session()->get('nama_guru'));
                    return redirect()->to('DashboardGuru');
                }else{
                    session()->setFlashdata('pesan', 'Username atau Password Salah !!!');
                    return redirect()->to('Auth');
                }
            }else if($level == 3){
                $cek = $this->ModelAuth->LoginSiswa($username, $password);
                if($cek){
                    session()->set('id_siswa', $cek['id_siswa']);
                    session()->set('id_kelas', $cek['id_kelas']);
                    session()->set('level', $level);
                    session()->set('nama_siswa', $cek['nama_siswa']);
                    session()->set('foto_siswa', $cek['foto_siswa']);
                    session()->setFlashdata('pesan', 'Selamat Datang ' . session()->get('nama_siswa'));
                    return redirect()->to('DashboardSiswa');
                }else{
                    session()->setFlashdata('pesan', 'Username atau Password Salah !!!');
                    return redirect()->to('Auth');
                }
            }else{
                return redirect()->to('Auth');
            }

        }else{
            return redirect()->to('Auth')->withInput();
        }
        
    }

    public function Logout(){
        session()->destroy();
        return redirect()->to('Auth');

        
    }
}
