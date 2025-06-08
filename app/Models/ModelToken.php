<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelToken extends Model
{
    public function CekToken($id_jadwal_ujian, $token)
    {
        return $this->db->table('tbl_jadwal_ujian')
            ->where('id_jadwal_ujian', $id_jadwal_ujian)
            ->where('token', $token)
            ->get()->getRowArray();
    }
}
