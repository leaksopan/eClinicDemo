<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 * 
 * Controller untuk menangani autentikasi pengguna
 * 
 * @package     eClinic
 * @subpackage  Controllers
 * @category    Auth
 */

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengguna_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    /**
     * Halaman login
     */
    public function index() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data['title'] = 'Login eClinic';
        
        // Validasi form login
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            // Cek login
            $user = $this->Pengguna_model->check_login($username, $password);
            
            if ($user) {
                // Update waktu login terakhir
                $this->Pengguna_model->update_pengguna($user->id_pengguna, [
                    'terakhir_login' => date('Y-m-d H:i:s')
                ]);
                
                // Set session data
                $user_data = [
                    'user_id' => $user->id_pengguna,
                    'username' => $user->username,
                    'name' => $user->nama_lengkap,
                    'email' => $user->email,
                    'role_id' => $user->id_role,
                    'role' => $user->nama_role,
                    'logged_in' => TRUE
                ];
                
                $this->session->set_userdata($user_data);
                
                // Redirect ke dashboard
                redirect('dashboard');
            } else {
                // Jika login gagal
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('auth');
            }
        }
    }
    
    /**
     * Logout pengguna
     */
    public function logout() {
        // Hapus session data
        $this->session->unset_userdata([
            'user_id', 'username', 'name', 'email', 'role_id', 'role', 'logged_in'
        ]);
        
        $this->session->set_flashdata('success', 'Anda berhasil logout');
        redirect('auth');
    }
    
    /**
     * Lupa password
     */
    public function forgot_password() {
        $data['title'] = 'Lupa Password';
        
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/forgot_password', $data);
        } else {
            $email = $this->input->post('email');
            $user = $this->Pengguna_model->get_pengguna_by_email($email);
            
            if ($user) {
                // TODO: Implementasi reset password dengan mengirim email
                $this->session->set_flashdata('success', 'Instruksi reset password telah dikirim ke email Anda');
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan');
            }
            
            redirect('auth/forgot_password');
        }
    }
} 