<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSoal extends Model
{
    protected $table = 'tbl_soal';

    protected $primaryKey = 'id_soal';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_jadwal_ujian', 
        'soal',  
        'jawaban',  
        'a',
        'b',
        'c',
        'd',
        'e',
        'bobot',
    ];

    public function InsertData($data)
    {
        $this->db->table('tbl_soal')->insert($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tbl_soal')->where('id_soal', $data['id_soal'])->delete($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('tbl_soal')
        ->where('id_soal', $data['id_soal'])
        ->update($data);
    }

    public function AllData()
    {
        $this->db->table('tbl_soal')
            ->get()->getResultArray();
    }

}
