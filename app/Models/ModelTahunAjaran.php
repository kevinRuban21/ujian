<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTahunAjaran extends Model
{

    public function TaAktif()
    {
        return $this->db->table('tbl_ta')
            ->where('status', 1)
            ->get()->getRowArray();
    }
    
}
