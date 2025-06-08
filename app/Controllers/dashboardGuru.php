<?php

namespace App\Controllers;
use App\Models\ModelSekolah;

class dashboardGuru extends BaseController
{
    public function __construct() {
        $this->ModelSekolah = new ModelSekolah();
    }
    
    public function index(): string
    {
        $data = [
            'judul' => 'Dashboard Guru',
            'subjudul' => 'Dashboard Guru',
            'menu' => 'dashboard',
            'submenu' => 'dashboard',
            'page' => 'dashboard_guru',
            'sekolah' => $this->ModelSekolah->DetailData(),
        ];
        return view('template_guru', $data);
    }
}
