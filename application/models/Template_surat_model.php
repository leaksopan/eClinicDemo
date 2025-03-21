<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_surat_model extends CI_Model {
    
    private $table = 'template_surat';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all templates
     */
    public function get_all_templates() {
        $this->db->order_by('nama_template', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Get template by ID
     */
    public function get_template($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    /**
     * Get template name by ID
     */
    public function get_template_name($id) {
        $template = $this->db->get_where($this->table, ['id' => $id])->row();
        return $template ? $template->nama_template : '';
    }
    
    /**
     * Get template fields
     */
    public function get_template_fields($template_id) {
        $template = $this->get_template($template_id);
        
        if (!$template || empty($template->fields)) {
            return [];
        }
        
        return json_decode($template->fields, true);
    }
    
    /**
     * Render template
     */
    public function render_template($template_id, $data) {
        $template = $this->get_template($template_id);
        
        if (!$template) {
            return 'Template tidak ditemukan';
        }
        
        $html = $template->konten_html;
        
        // Replace placeholders
        foreach ($data as $key => $value) {
            $html = str_replace('{{' . $key . '}}', $value, $html);
        }
        
        return $html;
    }
} 