<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Helper untuk autentikasi dan otorisasi pengguna
 */

if (!function_exists('is_logged_in')) {
    /**
     * Memeriksa apakah pengguna sudah login
     * 
     * @return boolean
     */
    function is_logged_in() {
        $CI =& get_instance();
        return (bool) $CI->session->userdata('logged_in');
    }
}

if (!function_exists('check_auth')) {
    /**
     * Memeriksa autentikasi dan redirect ke halaman login jika belum login
     */
    function check_auth() {
        $CI =& get_instance();
        if (!is_logged_in()) {
            $CI->session->set_flashdata('error', 'Anda harus login terlebih dahulu');
            redirect('auth');
        }
    }
}

if (!function_exists('is_admin')) {
    /**
     * Memeriksa apakah pengguna adalah administrator
     * 
     * @return boolean
     */
    function is_admin() {
        $CI =& get_instance();
        return (is_logged_in() && $CI->session->userdata('role') === 'Administrator');
    }
}

if (!function_exists('check_admin')) {
    /**
     * Memeriksa apakah pengguna adalah administrator
     * Redirect ke dashboard jika bukan admin
     */
    function check_admin() {
        $CI =& get_instance();
        if (!is_admin()) {
            $CI->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut');
            redirect('dashboard');
        }
    }
}

if (!function_exists('check_role')) {
    /**
     * Memeriksa apakah pengguna memiliki role tertentu
     * 
     * @param string|array $allowed_roles Role yang diizinkan akses
     * @param string $redirect_to URL redirect jika tidak punya akses
     * @return boolean
     */
    function check_role($allowed_roles, $redirect_to = 'dashboard') {
        $CI =& get_instance();
        
        // Pastikan pengguna sudah login
        if (!is_logged_in()) {
            $CI->session->set_flashdata('error', 'Anda harus login terlebih dahulu');
            redirect('auth');
            return false;
        }
        
        // Konversi role tunggal ke array
        if (!is_array($allowed_roles)) {
            $allowed_roles = [$allowed_roles];
        }
        
        // Periksa admin selalu dapat akses
        if (is_admin()) {
            return true;
        }
        
        // Periksa pengguna memiliki role yang sesuai
        $user_role = $CI->session->userdata('role');
        if (in_array($user_role, $allowed_roles)) {
            return true;
        }
        
        // Jika tidak punya akses, redirect
        $CI->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut');
        redirect($redirect_to);
        return false;
    }
}

if (!function_exists('get_current_user')) {
    /**
     * Mendapatkan data pengguna yang sedang login
     * 
     * @param string $field Field yang ingin diambil, null untuk semua
     * @return mixed
     */
    function get_current_user($field = null) {
        $CI =& get_instance();
        
        if (!is_logged_in()) {
            return null;
        }
        
        if ($field) {
            return $CI->session->userdata($field);
        }
        
        return [
            'user_id' => $CI->session->userdata('user_id'),
            'username' => $CI->session->userdata('username'),
            'name' => $CI->session->userdata('name'),
            'email' => $CI->session->userdata('email'),
            'role_id' => $CI->session->userdata('role_id'),
            'role' => $CI->session->userdata('role')
        ];
    }
} 