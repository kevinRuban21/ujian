<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSekolah extends Model
{

    public function DetailData()
    {
        return $this->db->table('tbl_sekolah')->where('id', 1)->get()->getRowArray();
    }

    public function UpdateData($data)
    {
        $this->db->table('tbl_sekolah')->where('id', $data['id'])->update($data);
    }
}
