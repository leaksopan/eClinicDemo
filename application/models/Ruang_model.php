<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_model extends CI_Model {
    
    private $table = 'ruang_inap';
    private $table_bed = 'bed';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data ruang inap
     */
    public function get_all_ruang($limit = NULL, $offset = NULL) {
        $this->db->order_by('kelas', 'ASC');
        $this->db->order_by('nama_ruang', 'ASC');
        
        if ($limit !== NULL) {
            return $this->db->get($this->table, $limit, $offset)->result();
        }
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Mendapatkan jumlah total ruang inap
     */
    public function count_all_ruang() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Mendapatkan data ruang inap berdasarkan ID
     */
    public function get_ruang_by_id($id_ruang) {
        return $this->db->get_where($this->table, ['id_ruang' => $id_ruang])->row();
    }
    
    /**
     * Mendapatkan data ruang inap berdasarkan kode
     */
    public function get_ruang_by_kode($kode_ruang) {
        return $this->db->get_where($this->table, ['kode_ruang' => $kode_ruang])->row();
    }
    
    /**
     * Menyimpan data ruang inap
     */
    public function save_ruang($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mengupdate data ruang inap
     */
    public function update_ruang($id_ruang, $data) {
        $this->db->where('id_ruang', $id_ruang);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Menghapus data ruang inap
     */
    public function delete_ruang($id_ruang) {
        $this->db->where('id_ruang', $id_ruang);
        return $this->db->delete($this->table);
    }
    
    /**
     * Mendapatkan data ruang inap untuk dropdown
     */
    public function get_dropdown() {
        $this->db->select('id_ruang, kode_ruang, nama_ruang, kelas, tarif_per_hari');
        $this->db->where('status', 'Tersedia');
        $this->db->order_by('kelas', 'ASC');
        $this->db->order_by('nama_ruang', 'ASC');
        $query = $this->db->get($this->table);
        
        $data = [];
        foreach ($query->result() as $row) {
            $nama_ruang = $row->nama_ruang . ' - ' . $row->kelas . ' (Rp ' . number_format($row->tarif_per_hari, 0, ',', '.') . ')';
            $data[$row->id_ruang] = $nama_ruang;
        }
        
        return $data;
    }
    
    /**
     * Mendapatkan semua data bed berdasarkan ID ruang
     */
    public function get_bed_by_ruang($id_ruang) {
        $this->db->order_by('nomor_bed', 'ASC');
        return $this->db->get_where($this->table_bed, ['id_ruang' => $id_ruang])->result();
    }
    
    /**
     * Mendapatkan data bed berdasarkan ID
     */
    public function get_bed_by_id($id_bed) {
        return $this->db->get_where($this->table_bed, ['id_bed' => $id_bed])->row();
    }
    
    /**
     * Menyimpan data bed
     */
    public function save_bed($data) {
        $this->db->insert($this->table_bed, $data);
        $inserted = $this->db->insert_id();
        
        if ($inserted) {
            // Update jumlah terisi di ruang inap
            $this->update_terisi_count($data['id_ruang']);
        }
        
        return $inserted;
    }
    
    /**
     * Mengupdate data bed
     */
    public function update_bed($id_bed, $data) {
        $bed = $this->get_bed_by_id($id_bed);
        $id_ruang_lama = $bed->id_ruang;
        
        $this->db->where('id_bed', $id_bed);
        $updated = $this->db->update($this->table_bed, $data);
        
        if ($updated) {
            // Update jumlah terisi di ruang inap lama dan baru jika berbeda
            $this->update_terisi_count($id_ruang_lama);
            
            if (isset($data['id_ruang']) && $id_ruang_lama != $data['id_ruang']) {
                $this->update_terisi_count($data['id_ruang']);
            }
        }
        
        return $updated;
    }
    
    /**
     * Menghapus data bed
     */
    public function delete_bed($id_bed) {
        $bed = $this->get_bed_by_id($id_bed);
        
        $this->db->where('id_bed', $id_bed);
        $deleted = $this->db->delete($this->table_bed);
        
        if ($deleted) {
            // Update jumlah terisi di ruang inap
            $this->update_terisi_count($bed->id_ruang);
        }
        
        return $deleted;
    }
    
    /**
     * Update jumlah bed terisi pada ruang inap
     */
    private function update_terisi_count($id_ruang) {
        $this->db->where('id_ruang', $id_ruang);
        $this->db->where('status', 'Terisi');
        $count = $this->db->count_all_results($this->table_bed);
        
        $this->db->where('id_ruang', $id_ruang);
        return $this->db->update($this->table, ['terisi' => $count]);
    }
    
    /**
     * Mendapatkan data bed untuk dropdown
     */
    public function get_bed_dropdown($id_ruang) {
        $this->db->select('id_bed, nomor_bed, status');
        $this->db->where('id_ruang', $id_ruang);
        $this->db->where('status', 'Kosong');
        $this->db->order_by('nomor_bed', 'ASC');
        $query = $this->db->get($this->table_bed);
        
        $data = [];
        foreach ($query->result() as $row) {
            $data[$row->id_bed] = 'Bed No. ' . $row->nomor_bed;
        }
        
        return $data;
    }
} 