<?php

namespace App\Controllers;
use App\Models\ModelAdmin;

class dashboardAdmin extends BaseController
{
    public function __construct() {
        $this->ModelAdmin = new ModelAdmin();
    }

    public function index(): string
    {
        $data = [
            'judul' => 'Dashboard Admin',
            'subjudul' => 'Dashboard Admin',
            'menu' => 'dashboard',
            'submenu' => 'dashboard',
            'page' => 'dashboard_admin',
            'jmlh_jurusan' => $this->ModelAdmin->JmlhJurusan(),
            'jmlh_guru' => $this->ModelAdmin->JmlhGuru(),
            'jmlh_siswa' => $this->ModelAdmin->JmlhSiswa(),
            'jmlh_kelas' => $this->ModelAdmin->JmlhKelas(),
        ];
        return view('template_admin', $data);
    }
}
