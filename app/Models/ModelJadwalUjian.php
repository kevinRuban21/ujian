<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJadwalUjian extends Model
{

    public function InsertData($data)
    {
        $this->db->table('tbl_jadwal_ujian')->insert($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tbl_jadwal_ujian')->where('id_jadwal_ujian', $data['id_jadwal_ujian'])->delete($data);
    }

    public function DetailData($id_jadwal_ujian)
    {
        return $this->db->table('tbl_jadwal_ujian')
            ->join('tbl_jadwal_pelajaran', 'tbl_jadwal_pelajaran.id_jadwal=tbl_jadwal_ujian.id_jadwal', 'LEFT')
            ->join('tbl_mapel', 'tbl_mapel.id_mapel=tbl_jadwal_pelajaran.id_mapel', 'LEFT')
            ->join('tbl_guru', 'tbl_guru.id_guru=tbl_jadwal_pelajaran.id_guru', 'LEFT')
            ->join('tbl_kelas', 'tbl_kelas.id_kelas=tbl_jadwal_pelajaran.id_kelas', 'LEFT')
            ->join('tbl_jurusan', 'tbl_jurusan.id_jurusan=tbl_jadwal_pelajaran.id_jurusan', 'LEFT')
            ->join('tbl_ta', 'tbl_ta.id_ta=tbl_jadwal_pelajaran.id_ta', 'LEFT')
            ->where('id_jadwal_ujian', $id_jadwal_ujian)
            ->get()->getRowArray();
    }

    public function AllData()
    {
        return $this->db->table('tbl_jadwal_ujian')
            ->join('tbl_jadwal_pelajaran', 'tbl_jadwal_pelajaran.id_jadwal=tbl_jadwal_ujian.id_jadwal', 'LEFT')
            ->join('tbl_mapel', 'tbl_mapel.id_mapel=tbl_jadwal_pelajaran.id_mapel', 'LEFT')
            ->join('tbl_guru', 'tbl_guru.id_guru=tbl_jadwal_pelajaran.id_guru', 'LEFT')
            ->join('tbl_kelas', 'tbl_kelas.id_kelas=tbl_jadwal_pelajaran.id_kelas', 'LEFT')
            ->join('tbl_jurusan', 'tbl_jurusan.id_jurusan=tbl_jadwal_pelajaran.id_jurusan', 'LEFT')
            ->join('tbl_ta', 'tbl_ta.id_ta=tbl_jadwal_pelajaran.id_ta', 'LEFT')
            ->where('tbl_jadwal_pelajaran.id_guru', session()->get('id_guru'))
            ->get()->getResultArray();
    }

    public function UpdateData($data)
    {
        $this->db->table('tbl_jadwal_ujian')
        ->where('id_jadwal_ujian', $data['id_jadwal_ujian'])
        ->update($data);
    }

}
