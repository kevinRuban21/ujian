<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMapel extends Model
{
    public function AllData()
    {
        return $this->db->table('tbl_jadwal_pelajaran')
            ->join('tbl_mapel', 'tbl_mapel.id_mapel=tbl_jadwal_pelajaran.id_mapel', 'LEFT')
            ->join('tbl_jurusan', 'tbl_jurusan.id_jurusan=tbl_jadwal_pelajaran.id_jurusan', 'LEFT')
            ->join('tbl_guru', 'tbl_guru.id_guru=tbl_jadwal_pelajaran.id_guru', 'LEFT')
            ->join('tbl_kelas', 'tbl_kelas.id_kelas=tbl_jadwal_pelajaran.id_kelas', 'LEFT')
            ->join('tbl_ta', 'tbl_ta.id_ta=tbl_jadwal_pelajaran.id_ta', 'LEFT')
            ->orderBy('tbl_mapel.smt', 'ASC')
            ->get()->getResultArray();
    }

    public function Mapel($id_jurusan) {
        return $this->db->table('tbl_mapel')
            ->where('id_jurusan', $id_jurusan)
            ->orderBy('smt', 'ASC')
            ->get()->getResultArray();
    }

    public function Kelas($id_jurusan) {
        return $this->db->table('tbl_kelas')
            ->where('id_jurusan', $id_jurusan)
            ->orderBy('kelas', 'ASC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('tbl_jadwal_pelajaran')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('tbl_jadwal_pelajaran')->where('id_jadwal', $data['id_jadwal'])->update($data);
    }

    // public function AllDataMatkul($id_jurusan)
    // {
    //     return $this->db->table('tbl_mapel')
    //         ->where('id_jurusan', $id_jurusan)
    //         ->orderBy('smt', 'ASC')
    //         ->get()->getResultArray();
    // }

    public function DeleteData($data)
    {
        $this->db->table('tbl_jadwal_pelajaran')
            ->where('id_jadwal', $data['id_jadwal'])
            ->delete($data);
    }
}
