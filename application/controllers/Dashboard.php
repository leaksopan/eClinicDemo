<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Cek apakah pengguna sudah login
        check_auth();
        
        $this->load->model('Surat_model');
        $this->load->helper('date');
    }
    
    /**
     * Halaman Dashboard
     */
    public function index() {
        $data['title'] = 'Dashboard';
        
        // Mengambil data untuk statistik
        $data['total_surat'] = $this->Surat_model->count_all_surat();
        $data['user'] = get_current_user();
        
        // Tampilkan view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
} 