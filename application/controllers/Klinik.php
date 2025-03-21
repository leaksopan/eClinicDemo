<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Klinik Controller
 * 
 * Controller untuk mengelola data klinik, poli, dokter, jadwal, dan ruangan
 * 
 * @package     eClinic
 * @subpackage  Controllers
 * @category    Klinik
 */

/**
 * @property Poliklinik_model $Poliklinik_model
 * @property Dokter_model $Dokter_model
 * @property Jadwal_model $Jadwal_model
 * @property Ruang_model $Ruang_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 */
class Klinik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model yang diperlukan
        $this->load->model('Poliklinik_model');
        $this->load->model('Dokter_model');
        $this->load->model('Jadwal_model');
        $this->load->model('Ruang_model');
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'session']);
    }

    /**
     * Halaman utama modul klinik
     */
    public function index() {
        $data['title'] = 'Modul Klinik';
        $data['total_poli'] = $this->Poliklinik_model->count_all_poli();
        $data['total_dokter'] = $this->Dokter_model->count_all_dokter();
        $data['total_jadwal'] = $this->Jadwal_model->count_all_jadwal();
        
        // Debug: Cek hari ini
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari_index = date('w');
        $hari_ini = $days[$hari_index];
        $data['debug_hari'] = $hari_index . ' - ' . $hari_ini;
        
        // Ambil jadwal hari ini    
        $data['jadwal_hari_ini'] = $this->Jadwal_model->get_jadwal_hari_ini();
        
        // Debug jumlah data
        $data['debug_jumlah_jadwal'] = count($data['jadwal_hari_ini']);
        $data['debug_jadwal_aktif'] = $this->Jadwal_model->count_jadwal_aktif();
        
        $this->load->view('templates/header', $data);
        $this->load->view('klinik/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * MANAJEMEN POLIKLINIK
     */
    
    public function poli() {
        $data['title'] = 'Manajemen Poliklinik';
        $data['poli'] = $this->Poliklinik_model->get_all_poli();
        
        $this->load->view('templates/header', $data);
        $this->load->view('klinik/poli/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function tambah_poli() {
        $this->form_validation->set_rules('kode_poli', 'Kode Poli', 'required|is_unique[poliklinik.kode_poli]');
        $this->form_validation->set_rules('nama_poli', 'Nama Poli', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Poliklinik';
            
            $this->load->view('templates/header', $data);
            $this->load->view('klinik/poli/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data_poli = [
                'kode_poli' => $this->input->post('kode_poli'),
                'nama_poli' => $this->input->post('nama_poli'),
                'deskripsi' => $this->input->post('deskripsi'),
                'lokasi' => $this->input->post('lokasi'),
                'kapasitas' => $this->input->post('kapasitas'),
                'jam_buka' => $this->input->post('jam_buka'),
                'jam_tutup' => $this->input->post('jam_tutup'),
                'status' => $this->input->post('status')
            ];
            
            if ($this->Poliklinik_model->save_poli($data_poli)) {
                $this->session->set_flashdata('success', 'Poliklinik berhasil ditambahkan');
                redirect('klinik/poli');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan poliklinik');
                redirect('klinik/tambah_poli');
            }
        }
    }
    
    public function edit_poli($id) {
        $poli = $this->Poliklinik_model->get_poli_by_id($id);
        
        if (empty($poli)) {
            $this->session->set_flashdata('error', 'Poliklinik tidak ditemukan');
            redirect('klinik/poli');
        }
        
        $this->form_validation->set_rules('kode_poli', 'Kode Poli', 'required');
        $this->form_validation->set_rules('nama_poli', 'Nama Poli', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Poliklinik';
            $data['poli'] = $poli;
            
            $this->load->view('templates/header', $data);
            $this->load->view('klinik/poli/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $data_poli = [
                'kode_poli' => $this->input->post('kode_poli'),
                'nama_poli' => $this->input->post('nama_poli'),
                'deskripsi' => $this->input->post('deskripsi'),
                'lokasi' => $this->input->post('lokasi'),
                'kapasitas' => $this->input->post('kapasitas'),
                'jam_buka' => $this->input->post('jam_buka'),
                'jam_tutup' => $this->input->post('jam_tutup'),
                'status' => $this->input->post('status')
            ];
            
            if ($this->Poliklinik_model->update_poli($id, $data_poli)) {
                $this->session->set_flashdata('success', 'Poliklinik berhasil diperbarui');
                redirect('klinik/poli');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui poliklinik');
                redirect('klinik/edit_poli/' . $id);
            }
        }
    }
    
    public function hapus_poli($id) {
        $poli = $this->Poliklinik_model->get_poli_by_id($id);
        
        if (empty($poli)) {
            $this->session->set_flashdata('error', 'Poliklinik tidak ditemukan');
            redirect('klinik/poli');
        }
        
        if ($this->Poliklinik_model->delete_poli($id)) {
            $this->session->set_flashdata('success', 'Poliklinik berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus poliklinik');
        }
        
        redirect('klinik/poli');
    }

    /**
     * MANAJEMEN DOKTER
     */
    
    public function dokter() {
        $data['title'] = 'Manajemen Dokter';
        $data['dokter'] = $this->Dokter_model->get_all_dokter();
        
        $this->load->view('templates/header', $data);
        $this->load->view('klinik/dokter/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function tambah_dokter() {
        $this->form_validation->set_rules('id_pengguna', 'Pengguna', 'required');
        $this->form_validation->set_rules('sip', 'SIP', 'required');
        $this->form_validation->set_rules('tarif_konsultasi', 'Tarif Konsultasi', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Dokter';
            $data['pengguna'] = $this->Dokter_model->get_pengguna_dropdown();
            
            $this->load->view('templates/header', $data);
            $this->load->view('klinik/dokter/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data_dokter = [
                'id_pengguna' => $this->input->post('id_pengguna'),
                'sip' => $this->input->post('sip'),
                'spesialis' => $this->input->post('spesialis'),
                'tarif_konsultasi' => $this->input->post('tarif_konsultasi'),
                'komisi_persen' => $this->input->post('komisi_persen'),
                'status_praktek' => $this->input->post('status_praktek'),
                'jatah_pasien' => $this->input->post('jatah_pasien'),
                'gelar_depan' => $this->input->post('gelar_depan'),
                'gelar_belakang' => $this->input->post('gelar_belakang'),
                'alumni' => $this->input->post('alumni'),
                'tahun_lulus' => $this->input->post('tahun_lulus'),
                'mulai_praktek' => $this->input->post('mulai_praktek')
            ];
            
            if ($this->Dokter_model->save_dokter($data_dokter)) {
                $this->session->set_flashdata('success', 'Data dokter berhasil ditambahkan');
                redirect('klinik/dokter');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data dokter');
                redirect('klinik/tambah_dokter');
            }
        }
    }
    
    public function edit_dokter($id) {
        $dokter = $this->Dokter_model->get_dokter_by_id($id);
        
        if (empty($dokter)) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
            redirect('klinik/dokter');
        }
        
        $this->form_validation->set_rules('sip', 'SIP', 'required');
        $this->form_validation->set_rules('tarif_konsultasi', 'Tarif Konsultasi', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Dokter';
            $data['dokter'] = $dokter;
            $data['pengguna'] = $this->Dokter_model->get_pengguna_dropdown();
            
            $this->load->view('templates/header', $data);
            $this->load->view('klinik/dokter/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $data_dokter = [
                'sip' => $this->input->post('sip'),
                'spesialis' => $this->input->post('spesialis'),
                'tarif_konsultasi' => $this->input->post('tarif_konsultasi'),
                'komisi_persen' => $this->input->post('komisi_persen'),
                'status_praktek' => $this->input->post('status_praktek'),
                'jatah_pasien' => $this->input->post('jatah_pasien'),
                'gelar_depan' => $this->input->post('gelar_depan'),
                'gelar_belakang' => $this->input->post('gelar_belakang'),
                'alumni' => $this->input->post('alumni'),
                'tahun_lulus' => $this->input->post('tahun_lulus'),
                'mulai_praktek' => $this->input->post('mulai_praktek')
            ];
            
            if ($this->Dokter_model->update_dokter($id, $data_dokter)) {
                $this->session->set_flashdata('success', 'Data dokter berhasil diperbarui');
                redirect('klinik/dokter');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data dokter');
                redirect('klinik/edit_dokter/' . $id);
            }
        }
    }
    
    public function hapus_dokter($id) {
        $dokter = $this->Dokter_model->get_dokter_by_id($id);
        
        if (empty($dokter)) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
            redirect('klinik/dokter');
        }
        
        if ($this->Dokter_model->delete_dokter($id)) {
            $this->session->set_flashdata('success', 'Data dokter berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data dokter');
        }
        
        redirect('klinik/dokter');
    }

    /**
     * MANAJEMEN JADWAL DOKTER
     */
    
    public function jadwal() {
        $data['title'] = 'Manajemen Jadwal Dokter';
        $data['jadwal'] = $this->Jadwal_model->get_all_jadwal();
        
        $this->load->view('templates/header', $data);
        $this->load->view('klinik/jadwal/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function tambah_jadwal() {
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poliklinik', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Jadwal Dokter';
            $data['dokter'] = $this->Dokter_model->get_dropdown();
            $data['poli'] = $this->Poliklinik_model->get_dropdown();
            $data['hari'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            
            $this->load->view('templates/header', $data);
            $this->load->view('klinik/jadwal/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data_jadwal = [
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'status' => $this->input->post('status'),
                'keterangan' => $this->input->post('keterangan')
            ];
            
            if ($this->Jadwal_model->save_jadwal($data_jadwal)) {
                $this->session->set_flashdata('success', 'Jadwal dokter berhasil ditambahkan');
                redirect('klinik/jadwal');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan jadwal dokter');
                redirect('klinik/tambah_jadwal');
            }
        }
    }
    
    public function edit_jadwal($id) {
        $jadwal = $this->Jadwal_model->get_jadwal_by_id($id);
        
        if (empty($jadwal)) {
            $this->session->set_flashdata('error', 'Jadwal dokter tidak ditemukan');
            redirect('klinik/jadwal');
        }
        
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poliklinik', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Jadwal Dokter';
            $data['jadwal'] = $jadwal;
            $data['dokter'] = $this->Dokter_model->get_dropdown();
            $data['poli'] = $this->Poliklinik_model->get_dropdown();
            $data['hari'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            
            $this->load->view('templates/header', $data);
            $this->load->view('klinik/jadwal/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $data_jadwal = [
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'status' => $this->input->post('status'),
                'keterangan' => $this->input->post('keterangan')
            ];
            
            if ($this->Jadwal_model->update_jadwal($id, $data_jadwal)) {
                $this->session->set_flashdata('success', 'Jadwal dokter berhasil diperbarui');
                redirect('klinik/jadwal');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui jadwal dokter');
                redirect('klinik/edit_jadwal/' . $id);
            }
        }
    }
    
    public function hapus_jadwal($id) {
        $jadwal = $this->Jadwal_model->get_jadwal_by_id($id);
        
        if (empty($jadwal)) {
            $this->session->set_flashdata('error', 'Jadwal dokter tidak ditemukan');
            redirect('klinik/jadwal');
        }
        
        if ($this->Jadwal_model->delete_jadwal($id)) {
            $this->session->set_flashdata('success', 'Jadwal dokter berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jadwal dokter');
        }
        
        redirect('klinik/jadwal');
    }

    /**
     * MANAJEMEN RUANG RAWAT INAP
     */
    
    public function ruangan() {
        $data['title'] = 'Manajemen Ruang Rawat Inap';
        $data['ruangan'] = $this->Ruang_model->get_all_ruang();
        
        $this->load->view('templates/header', $data);
        $this->load->view('klinik/ruangan/index', $data);
        $this->load->view('templates/footer');
    }
} 