<?php

namespace App\Controllers;
use App\Models\ModelTahunAjaran;
use App\Models\ModelJadwalUjian;
use App\Models\ModelToken;
use App\Models\ModelSoal;
// use App\Models\ModelJawaban;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ujian extends BaseController
{
    protected $session;
    public function __construct() {
        $this->ModelTahunAjaran = new ModelTahunAjaran();
        $this->ModelJadwalUjian = new ModelJadwalUjian();
        $this->ModelSoal = new ModelSoal();
        // $this->ModelJawaban = new ModelJawaban();
        $this->ModelToken = new ModelToken();
        $this->session = \Config\Services::session();
    }

    public function index(): string
    {
        $data = [
            'judul' => 'Ujian',
            'subjudul' => 'Ujian',
            'menu' => 'master-data',
            'submenu' => 'ujian',
            'page' => 'ujian/index',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
        ];
        return view('template_siswa', $data);
    }

    public function ikut($id_jadwal_ujian)
    {
        $data = [
            'judul' => 'Ujian',
            'subjudul' => 'Ikut Ujian',
            'menu' => 'master-data',
            'submenu' => 'ujian',
            'page' => 'ujian/ikut',
            'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
            'ujian' => $this->ModelJadwalUjian->DetailData($id_jadwal_ujian),
        ];
        return view('template_siswa', $data);
    }

    public function CekToken($id_jadwal_ujian)
    {
        if($this->validate([
            'token' =>[
                'label' => 'Token',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ]
        ])){
            // jika Valid
            $token = $this->request->getPost('token');
            $cek = $this->ModelToken->CekToken($id_jadwal_ujian, $token);
            if($cek){
                session()->setFlashdata('success', 'Token yang Anda Masukan Benar');
                return redirect()->to('ujian/mulai/' . $id_jadwal_ujian);
            }else{
                session()->setFlashdata('errors', 'Token yang Anda Masukan Salah !!!');
                return redirect()->to('ujian/ikut/' . $id_jadwal_ujian);
            }

        }else{
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->to('ujian/ikut/' . $id_jadwal_ujian)->withInput();
        }

    }

    public function mulai($id_jadwal_ujian)
    {
        if (session()->getFlashdata('success')) {
            $data = [
                'judul' => 'Ujian',
                'subjudul' => 'Ujian',
                'menu' => 'master-data',
                'submenu' => 'ujian',
                'page' => 'ujian/mulai',
                'ta_aktif' => $this->ModelTahunAjaran->TaAktif(),
                'ujian' => $this->ModelJadwalUjian->DetailData($id_jadwal_ujian),
            ];
            return view('template_siswa', $data);

        } else{
            session()->setFlashdata('warning', 'Token Wajib diisi !!!');
            return redirect()->to('ujian/ikut/' . $id_jadwal_ujian);
        }
    }

    // public function selesai()
    // {
    //     if ($this->request->getMethod() === 'POST') {
    //         // --- DEBUGGING START ---
    //         // echo '<pre>'; // Tag <pre> agar output lebih mudah dibaca di browser
    //         // echo '<h3>Data POST yang Diterima:</h3>';
    //         // print_r($this->request->getPost()); // Baris ini yang penting
    //         // echo '</pre>';
    //         // die('Eksekusi berhenti untuk debugging. Lihat output di atas.'); // Hentikan eksekusi kode selanjutnya
    //         // --- DEBUGGING END ---

    //         $jawabanModel = new \App\Models\ModelJawaban(); // Gunakan nama model Anda
    //         $jawabanInput = $this->request->getPost('jawaban'); // Ambil hanya data 'jawaban'
    //         $dataToSave = [];

    //         $id_siswa = session()->get('id_siswa');
    //         if (empty($id_siswa)) {
    //             session()->setFlashdata('error', 'ID Siswa tidak ditemukan. Mohon login kembali.');
    //             return redirect()->back();
    //         }

    //         // --- DEBUGGING BARU: Periksa $jawabanInput sebelum loop ---
    //         // UNCOMMENT BARIS DI BAWAH INI untuk melihat data POST 'jawaban'
    //         // echo '<pre>';
    //         // echo '<h3>Data $jawabanInput (dari $_POST[\'jawaban\']):</h3>';
    //         // var_dump($jawabanInput);
    //         // echo '</pre>';
    //         // die('Debugging: Periksa $jawabanInput.');
    //         // --- END DEBUGGING ---

    //         if ($jawabanInput) { // Pastikan ada data jawaban yang dikirim
    //             foreach ($jawabanInput as $soalId => $soalData) {

    //                 $pilihan_jawaban = NULL;
    //                 // Akses 'id_soal' dan 'pilihan' dari $soalData
    //                 $id_soal = $soalData['id_soal'] ?? NULL; // Gunakan null coalescing untuk keamanan
    //                 $pilihan_jawaban = $soalData['pilihan'] ?? NULL;

    //                 // Logika baru: Jika pilihan_jawaban NULL, set ke 0
    //                 if ($pilihan_jawaban === NULL) {
    //                     $pilihan_jawaban = 'kosong'; // Setel ke 0 jika tidak ada pilihan jawaban
    //                 }

    //                 if ($pilihan_jawaban !== NULL) {
    //                     $dataToSave[] = [
    //                         'id_soal'     => $id_soal,
    //                         'id_siswa'    => $id_siswa,
    //                         'jawaban'     => $pilihan_jawaban,
    //                     ];
    //                 }

    //                 // echo '<pre>';
    //                 // var_dump($dataToSave);
    //                 // echo '</pre>';
    //                 // die('Debugging: Data siap disimpan.');
    //             }
    //         }

    //         // ... (lanjutkan dengan insertBatch dan redirect seperti sebelumnya)
    //         if (!empty($dataToSave)) {
    //             $saved = $jawabanModel->insertBatch($dataToSave);

    //             if ($saved) {
    //                 session()->setFlashdata('success', 'Jawaban berhasil disimpan!');
    //                 return redirect()->to(base_url('ujian')); // Arahkan ke halaman hasil
    //             } else {
    //                 session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan jawaban Anda. Silakan coba lagi.');
    //                 return redirect()->back()->withInput();
    //             }
    //         } else {
    //             session()->setFlashdata('warning', 'Tidak ada jawaban yang ditemukan untuk disimpan.');
    //             return redirect()->to(base_url('ujian'));
    //         }
    //     } else {
    //         return redirect()->back()->with('error', 'Akses tidak valid.');
    //     }
    // }

    public function selesai()
    {
        // Memeriksa apakah permintaan adalah POST
        if ($this->request->getMethod() === 'POST') {
            // Inisialisasi model Jawaban
            $jawabanModel = new \App\Models\ModelJawaban(); 
            // Mengambil semua data 'jawaban' dari POST request
            $jawabanInput = $this->request->getPost('jawaban'); 
            // Array untuk menyimpan data jawaban yang akan disimpan ke database
            $dataToSave = [];

            // Mendapatkan ID siswa dari session
            $id_siswa = session()->get('id_siswa');
            // Jika ID siswa tidak ditemukan, set flashdata error dan redirect kembali
            if (empty($id_siswa)) {
                session()->setFlashdata('error', 'ID Siswa tidak ditemukan. Mohon login kembali.');
                return redirect()->back();
            }

            // Memastikan ada data jawaban yang dikirim
            if ($jawabanInput) { 
                // Loop melalui setiap jawaban yang dikirim
                foreach ($jawabanInput as $soalId => $soalData) {
                    $pilihan_jawaban = NULL;
                    
                    $id_soal = $soalData['id_soal'] ?? NULL; 
                    $pilihan_jawaban = $soalData['pilihan'] ?? NULL;

                    // Logika: Jika pilihan_jawaban NULL, set ke '0' (string)
                    if ($pilihan_jawaban === NULL) {
                        $pilihan_jawaban = 'Tidak dijawab'; 
                    }
                    
                    // Jika id_soal tidak NULL (pastikan soalnya ada)
                    if ($id_soal !== NULL) {
                        $dataToSave[] = [
                            'id_soal'       => $id_soal,
                            'id_siswa'      => $id_siswa,
                            'jawaban'       => $pilihan_jawaban,
                        ];
                    }
                }
            }

            // Jika ada data yang akan disimpan
            if (!empty($dataToSave)) {
                try {
                    // Simpan batch data ke database
                    $saved = $jawabanModel->insertBatch($dataToSave);

                    // Cek apakah penyimpanan berhasil
                    if ($saved) {
                        session()->setFlashdata('success', 'Jawaban berhasil disimpan!');
                        return redirect()->to(base_url('ujian')); // Arahkan ke halaman hasil
                    } else {
                        // Jika insertBatch mengembalikan false tanpa exception
                        session()->setFlashdata('error', 'Terjadi kesalahan tidak terduga saat menyimpan jawaban Anda. Silakan coba lagi. (Model insertBatch mengembalikan false)');
                        return redirect()->back()->withInput();
                    }
                } catch (DatabaseException $e) {
                    // Tangani exception database dan tampilkan pesan error yang lebih detail
                    log_message('error', 'Database Error saat menyimpan jawaban: ' . $e->getMessage());
                    session()->setFlashdata('error', 'Terjadi kesalahan *database* saat menyimpan jawaban Anda: ' . $e->getMessage() . '. Silakan periksa konfigurasi *database* dan model.');
                    return redirect()->back()->withInput();
                } catch (\Exception $e) {
                    // Tangani exception umum lainnya
                    log_message('error', 'Kesalahan umum saat menyimpan jawaban: ' . $e->getMessage());
                    session()->setFlashdata('error', 'Terjadi kesalahan umum saat menyimpan jawaban Anda: ' . $e->getMessage() . '. Silakan coba lagi.');
                    return redirect()->back()->withInput();
                }

            } else {
                // Jika tidak ada jawaban yang ditemukan untuk disimpan
                session()->setFlashdata('warning', 'Tidak ada jawaban yang ditemukan untuk disimpan.');
                return redirect()->to(base_url('ujian'));
            }
        } else {
            // Jika akses tidak valid (bukan POST request)
            return redirect()->back()->with('error', 'Akses tidak valid.');
        }
    }


}
