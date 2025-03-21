<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk mengelola jadwal praktek dokter
 * 
 * @property Jadwal_model $Jadwal_model
 * @property Dokter_model $Dokter_model
 * @property Poliklinik_model $Poliklinik_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Jadwal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Jadwal_model');
        $this->load->model('Dokter_model');
        $this->load->model('Poliklinik_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = 'Manajemen Jadwal Praktek Dokter';
        $data['jadwal'] = $this->Jadwal_model->get_all_jadwal();
        $data['hari'] = $this->Jadwal_model->get_hari();
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Jadwal Praktek Dokter';
        $data['dokter'] = $this->Dokter_model->get_dropdown_dokter();
        $data['poli'] = $this->Poliklinik_model->get_dropdown_poli();
        $data['hari'] = $this->Jadwal_model->get_hari();
        
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poliklinik', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        $this->form_validation->set_rules('kuota_pasien', 'Kuota Pasien', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('jadwal/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $jadwal_data = [
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];
            
            // Periksa apakah jadwal bentrok dengan jadwal yang sudah ada
            $is_conflict = $this->_check_jadwal_conflict(
                $jadwal_data['id_dokter'],
                $jadwal_data['hari'],
                $jadwal_data['jam_mulai'],
                $jadwal_data['jam_selesai']
            );
            
            if ($is_conflict) {
                $this->session->set_flashdata('error', 'Jadwal bentrok dengan jadwal dokter yang sudah ada.');
                $this->load->view('templates/header', $data);
                $this->load->view('jadwal/tambah', $data);
                $this->load->view('templates/footer');
            } else {
                $this->Jadwal_model->save_jadwal($jadwal_data);
                $this->session->set_flashdata('success', 'Jadwal praktek dokter berhasil ditambahkan.');
                redirect('jadwal');
            }
        }
    }
    
    public function edit($id) {
        if (!$id) {
            redirect('jadwal');
        }
        
        $data['title'] = 'Edit Jadwal Praktek Dokter';
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_id($id);
        
        if (!$data['jadwal']) {
            $this->session->set_flashdata('error', 'Jadwal tidak ditemukan.');
            redirect('jadwal');
        }
        
        $data['dokter'] = $this->Dokter_model->get_dropdown_dokter();
        $data['poli'] = $this->Poliklinik_model->get_dropdown_poli();
        $data['hari'] = $this->Jadwal_model->get_hari();
        
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poliklinik', 'required');
        $this->form_validation->set_rules('hari', 'Hari', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        $this->form_validation->set_rules('kuota_pasien', 'Kuota Pasien', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('jadwal/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $jadwal_data = [
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'hari' => $this->input->post('hari'),
                'jam_mulai' => $this->input->post('jam_mulai'),
                'jam_selesai' => $this->input->post('jam_selesai'),
                'kuota_pasien' => $this->input->post('kuota_pasien'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => $this->input->post('status')
            ];
            
            // Periksa apakah jadwal bentrok dengan jadwal yang sudah ada (kecuali jadwal ini sendiri)
            $is_conflict = $this->_check_jadwal_conflict(
                $jadwal_data['id_dokter'],
                $jadwal_data['hari'],
                $jadwal_data['jam_mulai'],
                $jadwal_data['jam_selesai'],
                $id
            );
            
            if ($is_conflict) {
                $this->session->set_flashdata('error', 'Jadwal bentrok dengan jadwal dokter yang sudah ada.');
                $this->load->view('templates/header', $data);
                $this->load->view('jadwal/edit', $data);
                $this->load->view('templates/footer');
            } else {
                $this->Jadwal_model->update_jadwal($id, $jadwal_data);
                $this->session->set_flashdata('success', 'Jadwal praktek dokter berhasil diperbarui.');
                redirect('jadwal');
            }
        }
    }
    
    public function hapus($id) {
        if (!$id) {
            redirect('jadwal');
        }
        
        $jadwal = $this->Jadwal_model->get_jadwal_by_id($id);
        
        if (!$jadwal) {
            $this->session->set_flashdata('error', 'Jadwal tidak ditemukan.');
            redirect('jadwal');
        }
        
        $this->Jadwal_model->delete_jadwal($id);
        $this->session->set_flashdata('success', 'Jadwal praktek dokter berhasil dihapus.');
        redirect('jadwal');
    }
    
    public function dokter($id_dokter) {
        if (!$id_dokter) {
            redirect('jadwal');
        }
        
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id_dokter);
        
        if (!$data['dokter']) {
            $this->session->set_flashdata('error', 'Dokter tidak ditemukan.');
            redirect('jadwal');
        }
        
        $data['title'] = 'Jadwal Praktek Dokter: ' . $data['dokter']->nama_lengkap;
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_dokter($id_dokter);
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/dokter', $data);
        $this->load->view('templates/footer');
    }
    
    public function poli($id_poli) {
        if (!$id_poli) {
            redirect('jadwal');
        }
        
        $data['poli'] = $this->Poliklinik_model->get_poli_by_id($id_poli);
        
        if (!$data['poli']) {
            $this->session->set_flashdata('error', 'Poliklinik tidak ditemukan.');
            redirect('jadwal');
        }
        
        $data['title'] = 'Jadwal Praktek Poliklinik: ' . $data['poli']->nama_poli;
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_poli($id_poli);
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/poli', $data);
        $this->load->view('templates/footer');
    }
    
    public function hari($hari = null) {
        if (!$hari || !in_array($hari, $this->Jadwal_model->get_hari())) {
            redirect('jadwal');
        }
        
        $data['title'] = 'Jadwal Praktek Hari ' . ucfirst($hari);
        $data['hari'] = $hari;
        $data['jadwal'] = $this->Jadwal_model->get_jadwal_by_hari($hari);
        
        $this->load->view('templates/header', $data);
        $this->load->view('jadwal/hari', $data);
        $this->load->view('templates/footer');
    }
    
    private function _check_jadwal_conflict($id_dokter, $hari, $jam_mulai, $jam_selesai, $current_id = null) {
        return $this->Jadwal_model->check_jadwal_conflict($id_dokter, $hari, $jam_mulai, $jam_selesai, $current_id);
    }
} 