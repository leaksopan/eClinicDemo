<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengguna Controller
 * 
 * Controller untuk mengelola pengguna sistem
 * 
 * @package     eClinic
 * @subpackage  Controllers
 * @category    Pengguna
 */

/**
 * @property Pengguna_model $Pengguna_model
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Pengguna extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pengguna_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    
    public function index() {
        $data['title'] = 'Daftar Pengguna';
        $data['pengguna'] = $this->Pengguna_model->get_all_pengguna();
        $data['roles'] = $this->Pengguna_model->get_all_roles();
        
        $this->load->view('pengguna/index', $data);
    }
    
    public function tambah() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|is_unique[pengguna.username]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pengguna.email]');
        $this->form_validation->set_rules('id_role', 'Role', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Pengguna';
            $data['roles'] = $this->Pengguna_model->get_all_roles();
            
            $this->load->view('pengguna/tambah', $data);
        } else {
            $password = $this->input->post('password');
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $data_pengguna = [
                'username' => $this->input->post('username'),
                'password' => $hashed_password,
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $this->input->post('email'),
                'no_telp' => $this->input->post('no_telp'),
                'alamat' => $this->input->post('alamat'),
                'id_role' => $this->input->post('id_role'),
                'status' => 'aktif'
            ];
            
            if ($this->Pengguna_model->save_pengguna($data_pengguna)) {
                $this->session->set_flashdata('success', 'Pengguna baru berhasil ditambahkan');
                redirect('pengguna');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan pengguna baru');
                redirect('pengguna/tambah');
            }
        }
    }
    
    public function edit($id) {
        $pengguna = $this->Pengguna_model->get_pengguna_by_id($id);
        
        if (empty($pengguna)) {
            $this->session->set_flashdata('error', 'Pengguna tidak ditemukan');
            redirect('pengguna');
        }
        
        // Aturan validasi - jika username diubah
        if ($this->input->post('username') != $pengguna->username) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|is_unique[pengguna.username]');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
        }
        
        // Aturan validasi - jika email diubah
        if ($this->input->post('email') != $pengguna->email) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pengguna.email]');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        }
        
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('id_role', 'Role', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Pengguna';
            $data['pengguna'] = $pengguna;
            $data['roles'] = $this->Pengguna_model->get_all_roles();
            
            $this->load->view('pengguna/edit', $data);
        } else {
            $data_pengguna = [
                'username' => $this->input->post('username'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $this->input->post('email'),
                'no_telp' => $this->input->post('no_telp'),
                'alamat' => $this->input->post('alamat'),
                'id_role' => $this->input->post('id_role')
            ];
            
            if ($this->Pengguna_model->update_pengguna($id, $data_pengguna)) {
                $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui');
                redirect('pengguna');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data pengguna');
                redirect('pengguna/edit/' . $id);
            }
        }
    }
    
    public function lihat($id) {
        $data['pengguna'] = $this->Pengguna_model->get_pengguna_by_id($id);
        
        if (empty($data['pengguna'])) {
            $this->session->set_flashdata('error', 'Pengguna tidak ditemukan');
            redirect('pengguna');
        }
        
        $data['title'] = 'Detail Pengguna';
        $data['roles'] = $this->Pengguna_model->get_all_roles();
        
        $this->load->view('pengguna/lihat', $data);
    }
    
    public function hapus($id) {
        $pengguna = $this->Pengguna_model->get_pengguna_by_id($id);
        
        if (empty($pengguna)) {
            $this->session->set_flashdata('error', 'Pengguna tidak ditemukan');
            redirect('pengguna');
        }
        
        // Mencegah admin default dihapus
        if ($pengguna->username == 'admin') {
            $this->session->set_flashdata('error', 'Admin default tidak dapat dihapus');
            redirect('pengguna');
        }
        
        if ($this->Pengguna_model->delete_pengguna($id)) {
            $this->session->set_flashdata('success', 'Pengguna berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pengguna');
        }
        
        redirect('pengguna');
    }
    
    public function reset_password($id) {
        $pengguna = $this->Pengguna_model->get_pengguna_by_id($id);
        
        if (empty($pengguna)) {
            $this->session->set_flashdata('error', 'Pengguna tidak ditemukan');
            redirect('pengguna');
        }
        
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'trim|required|matches[password_baru]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Reset Password';
            $data['pengguna'] = $pengguna;
            
            $this->load->view('pengguna/reset_password', $data);
        } else {
            $password_baru = $this->input->post('password_baru');
            $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);
            
            if ($this->Pengguna_model->update_password($id, $hashed_password)) {
                $this->session->set_flashdata('success', 'Password berhasil direset');
                redirect('pengguna');
            } else {
                $this->session->set_flashdata('error', 'Gagal mereset password');
                redirect('pengguna/reset_password/' . $id);
            }
        }
    }
    
    public function aktifkan($id) {
        if ($this->Pengguna_model->update_status($id, 'aktif')) {
            $this->session->set_flashdata('success', 'Pengguna berhasil diaktifkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengaktifkan pengguna');
        }
        
        redirect('pengguna');
    }
    
    public function nonaktifkan($id) {
        $pengguna = $this->Pengguna_model->get_pengguna_by_id($id);
        
        if ($pengguna->username == 'admin') {
            $this->session->set_flashdata('error', 'Admin default tidak dapat dinonaktifkan');
            redirect('pengguna');
        }
        
        if ($this->Pengguna_model->update_status($id, 'nonaktif')) {
            $this->session->set_flashdata('success', 'Pengguna berhasil dinonaktifkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menonaktifkan pengguna');
        }
        
        redirect('pengguna');
    }
    
    public function ganti_password() {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'trim|required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'trim|required|matches[password_baru]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Ganti Password';
            
            $this->load->view('pengguna/ganti_password', $data);
        } else {
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru');
            
            // Ambil ID pengguna dari session login (perlu disesuaikan)
            $id_pengguna = $this->session->userdata('id_pengguna');
            
            // Cek password lama
            $pengguna = $this->Pengguna_model->get_pengguna_by_id($id_pengguna);
            
            if (!password_verify($password_lama, $pengguna->password)) {
                $this->session->set_flashdata('error', 'Password lama tidak sesuai');
                redirect('pengguna/ganti_password');
            }
            
            $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);
            
            if ($this->Pengguna_model->update_password($id_pengguna, $hashed_password)) {
                $this->session->set_flashdata('success', 'Password berhasil diubah');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah password');
                redirect('pengguna/ganti_password');
            }
        }
    }
} 