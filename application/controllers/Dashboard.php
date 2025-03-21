<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
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
        
        // Tampilkan view
        $this->load->view('dashboard/index', $data);
    }
} 