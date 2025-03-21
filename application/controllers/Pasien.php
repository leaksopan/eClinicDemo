<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pasien_model');
        $this->load->helper(['form', 'url', 'date']);
        $this->load->library(['form_validation', 'session', 'upload']);
    }
    
    /**
     * Halaman daftar pasien
     */
    public function index() {
        $data['title'] = 'Daftar Pasien';
        $data['pasien'] = $this->Pasien_model->get_all_pasien();
        
        $this->load->view('pasien/index', $data);
    }
    
    /**
     * Halaman tambah pasien baru
     */
    public function tambah() {
        $data['title'] = 'Tambah Pasien Baru';
        $data['provinsi'] = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 
            'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten',
            'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
            'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat'
        ];
        
        // Set rules validasi
        $this->form_validation->set_rules('nama_lengkap', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('pasien/tambah', $data);
        } else {
            // Upload foto jika ada
            $foto = NULL;
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/pasien/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'foto_' . time();

                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('foto')) {
                    $foto_data = $this->upload->data();
                    $foto = $config['upload_path'] . $foto_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('pasien/tambah');
                }
            }
            
            // Data pasien
            $data_pasien = [
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'alamat' => $this->input->post('alamat'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'provinsi' => $this->input->post('provinsi'),
                'kode_pos' => $this->input->post('kode_pos'),
                'no_telp' => $this->input->post('no_telp'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'no_identitas' => $this->input->post('no_identitas'),
                'jenis_identitas' => $this->input->post('jenis_identitas'),
                'agama' => $this->input->post('agama'),
                'suku' => $this->input->post('suku'),
                'status_pernikahan' => $this->input->post('status_pernikahan'),
                'pendidikan' => $this->input->post('pendidikan'),
                'nama_keluarga' => $this->input->post('nama_keluarga'),
                'hubungan_keluarga' => $this->input->post('hubungan_keluarga'),
                'telp_keluarga' => $this->input->post('telp_keluarga'),
                'golongan_darah' => $this->input->post('golongan_darah'),
                'rhesus' => $this->input->post('rhesus'),
                'alergi' => $this->input->post('alergi'),
                'catatan_khusus' => $this->input->post('catatan_khusus'),
                'status' => $this->input->post('status'),
                'tanggal_daftar' => date('Y-m-d H:i:s'),
                'foto' => $foto,
                'no_rm' => $no_rm
            ];
            
            $id_pasien = $this->Pasien_model->save_pasien($data_pasien);
            
            if ($id_pasien) {
                $this->session->set_flashdata('success', 'Data pasien berhasil disimpan!');
                redirect('pasien/lihat/' . $id_pasien);
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data pasien!');
                redirect('pasien/tambah');
            }
        }
    }
    
    /**
     * Halaman edit data pasien
     */
    public function edit($id_pasien) {
        $data['title'] = 'Edit Data Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $data['provinsi'] = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 
            'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten',
            'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
            'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat'
        ];
        
        // Set rules validasi
        $this->form_validation->set_rules('nama_lengkap', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('pasien/edit', $data);
        } else {
            // Upload foto jika ada
            $foto = $data['pasien']->foto;
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/pasien/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'foto_' . time();

                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('foto')) {
                    // Hapus foto lama jika ada
                    if ($foto && file_exists($foto)) {
                        unlink($foto);
                    }
                    
                    $foto_data = $this->upload->data();
                    $foto = $config['upload_path'] . $foto_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('pasien/edit/' . $id_pasien);
                }
            }
            
            // Data pasien
            $data_pasien = [
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'alamat' => $this->input->post('alamat'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kota' => $this->input->post('kota'),
                'provinsi' => $this->input->post('provinsi'),
                'kode_pos' => $this->input->post('kode_pos'),
                'no_telp' => $this->input->post('no_telp'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'no_identitas' => $this->input->post('no_identitas'),
                'jenis_identitas' => $this->input->post('jenis_identitas'),
                'agama' => $this->input->post('agama'),
                'suku' => $this->input->post('suku'),
                'status_pernikahan' => $this->input->post('status_pernikahan'),
                'pendidikan' => $this->input->post('pendidikan'),
                'nama_keluarga' => $this->input->post('nama_keluarga'),
                'hubungan_keluarga' => $this->input->post('hubungan_keluarga'),
                'telp_keluarga' => $this->input->post('telp_keluarga'),
                'golongan_darah' => $this->input->post('golongan_darah'),
                'rhesus' => $this->input->post('rhesus'),
                'alergi' => $this->input->post('alergi'),
                'catatan_khusus' => $this->input->post('catatan_khusus'),
                'status' => $this->input->post('status'),
                'tanggal_daftar' => date('Y-m-d H:i:s'),
                'foto' => $foto
            ];
            
            if ($this->Pasien_model->update_pasien($id_pasien, $data_pasien)) {
                $this->session->set_flashdata('success', 'Data pasien berhasil diperbarui!');
                redirect('pasien/lihat/' . $id_pasien);
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data pasien!');
                redirect('pasien/edit/' . $id_pasien);
            }
        }
    }
    
    /**
     * Halaman detail pasien
     */
    public function lihat($id_pasien) {
        $data['title'] = 'Detail Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $this->load->view('pasien/lihat', $data);
    }
    
    /**
     * Halaman kartu pasien
     */
    public function kartu($id_pasien = NULL) {
        if ($id_pasien === NULL) {
            $this->session->set_flashdata('error', 'ID Pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $data['title'] = 'Kartu Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        $this->load->view('pasien/kartu', $data);
    }
    
    /**
     * Hapus data pasien
     */
    public function hapus($id_pasien) {
        $pasien = $this->Pasien_model->get_pasien_by_id($id_pasien);
        
        if (!$pasien) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
            redirect('pasien');
        }
        
        // Hapus foto jika ada
        if ($pasien->foto && file_exists($pasien->foto)) {
            unlink($pasien->foto);
        }
        
        if ($this->Pasien_model->delete_pasien($id_pasien)) {
            $this->session->set_flashdata('success', 'Data pasien berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pasien!');
        }
        
        redirect('pasien');
    }
    
    /**
     * Pencarian pasien
     */
    public function cari() {
        $keyword = $this->input->get('keyword');
        
        if (empty($keyword)) {
            redirect('pasien');
        }
        
        $data['title'] = 'Hasil Pencarian: ' . $keyword;
        $data['pasien'] = $this->Pasien_model->search_pasien($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('pasien/index', $data);
    }
    
    /**
     * Halaman statistik pasien
     */
    public function statistik() {
        $data['title'] = 'Statistik Pasien';
        $data['jenis_kelamin'] = $this->Pasien_model->get_statistik_jenis_kelamin();
        $data['usia'] = $this->Pasien_model->get_statistik_usia();
        $data['total_pasien'] = $this->Pasien_model->count_all_pasien();
        
        $this->load->view('pasien/statistik', $data);
    }
    
    /**
     * Cetak data pasien
     */
    public function cetak($id_pasien = NULL) {
        if ($id_pasien) {
            // Cetak data individual
            $data['title'] = 'Cetak Data Pasien';
            $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id_pasien);
            
            if (!$data['pasien']) {
                $this->session->set_flashdata('error', 'Data pasien tidak ditemukan!');
                redirect('pasien');
            }
            
            $this->load->view('pasien/cetak_individual', $data);
        } else {
            // Cetak semua data
            $data['title'] = 'Cetak Daftar Pasien';
            $data['pasien'] = $this->Pasien_model->get_all_pasien();
            
            $this->load->view('pasien/cetak_all', $data);
        }
    }
} 