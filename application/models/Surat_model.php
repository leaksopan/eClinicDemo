<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {
    
    private $table = 'surat';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all surat
     */
    public function get_all_surat() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Count all surat
     */
    public function count_all_surat() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Get surat by ID
     */
    public function get_surat_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    /**
     * Save surat data
     */
    public function save_surat($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update surat data
     */
    public function update_surat($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete surat
     */
    public function delete_surat($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Mendapatkan nomor surat terakhir
     */
    public function get_last_nomor_surat($kode_template) {
        $tahun = date('Y');
        $bulan = date('m');
        
        $this->db->like('no_surat', "$kode_template/$bulan/$tahun");
        $this->db->order_by('id_surat', 'DESC');
        $this->db->limit(1);
        
        $last_surat = $this->db->get('cetak_surat')->row();
        
        if ($last_surat) {
            $last_no = explode('/', $last_surat->no_surat);
            return (int)$last_no[0];
        }
        
        return 0;
    }

    /**
     * Generate nomor surat baru
     */
    public function generate_nomor_surat($kode_template) {
        $last_no = $this->get_last_nomor_surat($kode_template);
        $new_no = $last_no + 1;
        
        $tahun = date('Y');
        $bulan = date('m');
        
        return sprintf('%03d/%s/%s/%s', $new_no, $kode_template, $bulan, $tahun);
    }
    
    /**
     * Mendapatkan daftar pasien untuk dropdown
     */
    public function get_pasien_dropdown() {
        $query = $this->db->select('id_pasien, nama_pasien, no_rm')
                        ->from('pasien')
                        ->order_by('nama_pasien', 'ASC')
                        ->get();
        
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->id_pasien] = $row->nama_pasien . ' (' . $row->no_rm . ')';
        }
        
        return $result;
    }
    
    /**
     * Mendapatkan daftar dokter untuk dropdown
     */
    public function get_dokter_dropdown() {
        $query = $this->db->select('id_dokter, nama_dokter')
                        ->from('dokter')
                        ->order_by('nama_dokter', 'ASC')
                        ->get();
        
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->id_dokter] = $row->nama_dokter;
        }
        
        return $result;
    }
} 