<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model {
    
    private $table = 'pengguna';
    private $table_role = 'role';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data pengguna
     */
    public function get_all_pengguna() {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from($this->table);
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan semua data role/peran
     */
    public function get_all_roles() {
        $this->db->select('*');
        $this->db->from($this->table_role);
        $this->db->order_by('nama_role', 'ASC');
        $query = $this->db->get();
        
        $data = [];
        foreach ($query->result() as $row) {
            $data[$row->id_role] = $row->nama_role;
        }
        
        return $data;
    }
    
    /**
     * Mendapatkan data pengguna berdasarkan ID
     */
    public function get_pengguna_by_id($id_pengguna) {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from($this->table);
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        $this->db->where('pengguna.id_pengguna', $id_pengguna);
        return $this->db->get()->row();
    }
    
    /**
     * Mendapatkan data pengguna berdasarkan username
     */
    public function get_pengguna_by_username($username) {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from($this->table);
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        $this->db->where('pengguna.username', $username);
        return $this->db->get()->row();
    }
    
    /**
     * Menyimpan data pengguna baru
     */
    public function save_pengguna($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data pengguna
     */
    public function update_pengguna($id_pengguna, $data) {
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Mengupdate password pengguna
     */
    public function update_password($id_pengguna, $password) {
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->update($this->table, ['password' => $password]);
    }
    
    /**
     * Mengupdate status pengguna
     */
    public function update_status($id_pengguna, $status) {
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->update($this->table, ['status' => $status]);
    }
    
    /**
     * Menghapus data pengguna
     */
    public function delete_pengguna($id_pengguna) {
        $this->db->where('id_pengguna', $id_pengguna);
        return $this->db->delete($this->table);
    }
    
    /**
     * Mencari pengguna berdasarkan kata kunci
     */
    public function search_pengguna($keyword) {
        $this->db->select('pengguna.*, role.nama_role');
        $this->db->from($this->table);
        $this->db->join('role', 'role.id_role = pengguna.id_role', 'left');
        $this->db->like('pengguna.username', $keyword);
        $this->db->or_like('pengguna.nama_lengkap', $keyword);
        $this->db->or_like('pengguna.email', $keyword);
        $this->db->or_like('role.nama_role', $keyword);
        $this->db->order_by('pengguna.nama_lengkap', 'ASC');
        return $this->db->get()->result();
    }
    
    /**
     * Cek login pengguna
     */
    public function check_login($username, $password) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        $this->db->where('status', 'aktif');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $pengguna = $query->row();
            if (password_verify($password, $pengguna->password)) {
                return $pengguna;
            }
        }
        
        return null;
    }
} 