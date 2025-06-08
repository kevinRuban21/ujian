<?php

namespace App\Controllers;
use App\Models\ModelTahunAjaran;
use App\Models\ModelMapel;

class mapel extends BaseController
{
    public function __construct() {
        $this->ModelTahunAjaran = new ModelTahunAjaran();
        $this->ModelMapel = new ModelMapel();
    }

    public function index(): string
    {
        $data = [
            'judul' => 'Mata Pelajaran',
            'subjudul' => 'mapel',
            'menu' => 'master-data',
            'submenu' => 'mapel',
            'page' => 'mapel/index',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
        ];
        return view('template_admin', $data);
    }
}
