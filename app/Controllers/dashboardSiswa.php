<?php

namespace App\Controllers;
use App\Models\ModelSekolah;

class dashboardSiswa extends BaseController
{
    public function __construct() {
        $this->ModelSekolah = new ModelSekolah();
    }
    
    public function index(): string
    {
        $data = [
            'judul' => 'Dashboard Siswa',
            'subjudul' => 'Dashboard Siswa',
            'menu' => 'dashboard',
            'submenu' => 'dashboard',
            'page' => 'dashboard_siswa',
            'sekolah' => $this->ModelSekolah->DetailData(),
        ];
        return view('template_siswa', $data);
    }
}
