<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library Template Surat
 * 
 * Library untuk mengelola template surat dan melakukan proses rendering
 */
class Template_surat {
    protected $CI;
    protected $templates = [];
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('templates', TRUE);
        $this->templates = $this->CI->config->item('surat_templates', 'templates');
    }
    
    /**
     * Mendapatkan semua template surat
     */
    public function get_all_templates() {
        return $this->templates;
    }
    
    /**
     * Mendapatkan template surat berdasarkan kode
     */
    public function get_template($kode_template) {
        if (isset($this->templates[$kode_template])) {
            return $this->templates[$kode_template];
        }
        
        return null;
    }
    
    /**
     * Mendapatkan konten template surat
     */
    public function get_template_content($kode_template) {
        $template = $this->get_template($kode_template);
        
        if ($template && file_exists(APPPATH . 'templates/' . $template['file'])) {
            return file_get_contents(APPPATH . 'templates/' . $template['file']);
        }
        
        return null;
    }
    
    /**
     * Render template surat dengan parameter
     */
    public function render_template($kode_template, $parameters = []) {
        $content = $this->get_template_content($kode_template);
        
        if (!$content) {
            return null;
        }
        
        // Render template dengan parameter
        foreach ($parameters as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        
        // Return rendered content
        return $content;
    }
    
    /**
     * Mendapatkan daftar jenis surat untuk dropdown
     */
    public function get_jenis_surat_dropdown() {
        $result = [];
        
        foreach ($this->templates as $kode => $template) {
            if ($template['status'] == 'aktif') {
                $result[$kode] = $template['jenis'] . ' - ' . $template['nama'];
            }
        }
        
        return $result;
    }
    
    /**
     * Mendapatkan semua placeholder untuk template
     */
    public function get_placeholder($kode_template) {
        $template = $this->get_template($kode_template);
        
        if ($template && isset($template['placeholder'])) {
            return $template['placeholder'];
        }
        
        return [];
    }
} 