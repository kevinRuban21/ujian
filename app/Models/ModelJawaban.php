<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJawaban extends Model
{
    protected $table = 'tbl_jawaban';

    protected $primaryKey = 'id_jawaban';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_soal',   
        'id_siswa',  
        'jawaban',    
    ];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at'; 
    // protected $updatedField  = 'updated_at'; 
    // protected $dateFormat    = 'datetime';

    // Validasi
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}