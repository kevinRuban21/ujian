<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function JmlhJurusan(){
        return $this->db->table('tbl_jurusan')->countAll();
    }
    public function JmlhGuru(){
        return $this->db->table('tbl_guru')->countAll();
    }
    public function JmlhSiswa(){
        return $this->db->table('tbl_siswa')->countAll();
    }
    public function JmlhKelas(){
        return $this->db->table('tbl_kelas')->countAll();
    }
}
