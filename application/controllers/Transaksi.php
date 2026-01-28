<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Transaksi_model', 'Nasabah_model']);
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        
        // Uncomment jika sudah ada sistem login
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('auth/login');
        // }
    }

    // Halaman utama daftar transaksi
    public function index()
    {
        $data['title'] = 'Data Transaksi - Aplikasi Tabungan';
        
        // Filter berdasarkan jenis transaksi
        $jenis = $this->input->get('jenis');
        $tgl_dari = $this->input->get('tgl_dari');
        $tgl_sampai = $this->input->get('tgl_sampai');
        $search = $this->input->get('search');
        
        // Build filter
        $filter = [];
        if ($jenis) {
            $filter['jenis_transaksi'] = $jenis;
        }
        if ($tgl_dari) {
            $filter['tgl_dari'] = $tgl_dari;
        }
        if ($tgl_sampai) {
            $filter['tgl_sampai'] = $tgl_sampai;
        }
        if ($search) {
            $filter['search'] = $search;
        }
        
        // Get transaksi dengan filter
        if (!empty($filter)) {
            $data['transaksi'] = $this->Transaksi_model->get_transaksi_filtered($filter);
        } else {
            $data['transaksi'] = $this->Transaksi_model->get_all_transaksi();
        }
        
        // Statistik
        $data['total_transaksi'] = count($data['transaksi']);
        $data['total_setoran'] = $this->Transaksi_model->get_total_by_jenis('setoran', $tgl_dari, $tgl_sampai);
        $data['total_penarikan'] = $this->Transaksi_model->get_total_by_jenis('penarikan', $tgl_dari, $tgl_sampai);
        $data['jumlah_setoran'] = $this->Transaksi_model->get_count_by_jenis('setoran', $tgl_dari, $tgl_sampai);
        $data['jumlah_penarikan'] = $this->Transaksi_model->get_count_by_jenis('penarikan', $tgl_dari, $tgl_sampai);
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
    }

    // Halaman form setoran
    public function setoran()
    {
        $data['title'] = 'Setoran - Aplikasi Tabungan';
        
        // Get ID nasabah dari parameter jika ada
        $id_nasabah = $this->input->get('id');
        $data['nasabah_selected'] = null;
        
        if ($id_nasabah) {
            $data['nasabah_selected'] = $this->Nasabah_model->get_nasabah_by_id($id_nasabah);
        }
        
        // Get semua nasabah aktif untuk dropdown
        $data['nasabah_list'] = $this->Nasabah_model->get_all_nasabah();
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/setoran', $data);
        $this->load->view('templates/footer');
    }

    // Proses setoran
    public function setoran_aksi()
    {
        // Validasi form
        $this->form_validation->set_rules('id_nasabah', 'Nasabah', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Setoran', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke halaman setoran dengan error
            $this->session->set_flashdata('error', validation_errors());
            redirect('transaksi/setoran');
        } else {
            $id_nasabah = $this->input->post('id_nasabah');
            $jumlah = $this->input->post('jumlah');
            $keterangan = $this->input->post('keterangan');
            
            // Get data nasabah
            $nasabah = $this->Nasabah_model->get_nasabah_by_id($id_nasabah);
            
            if (!$nasabah) {
                $this->session->set_flashdata('error', 'Data nasabah tidak ditemukan!');
                redirect('transaksi/setoran');
            }
            
            // Cek status nasabah
            if ($nasabah->status != 'aktif') {
                $this->session->set_flashdata('error', 'Nasabah tidak aktif! Tidak dapat melakukan transaksi.');
                redirect('transaksi/setoran');
            }
            
            $saldo_sebelum = $nasabah->saldo;
            $saldo_sesudah = $saldo_sebelum + $jumlah;
            
            // Data transaksi
            $data_transaksi = array(
                'id_nasabah' => $id_nasabah,
                'jenis_transaksi' => 'setoran',
                'jumlah' => $jumlah,
                'saldo_sebelum' => $saldo_sebelum,
                'saldo_sesudah' => $saldo_sesudah,
                'keterangan' => $keterangan,
                'petugas' => 'Admin', // Ganti dengan session user jika sudah ada login
                'tanggal' => date('Y-m-d H:i:s')
            );
            
            // Start transaction
            $this->db->trans_start();
            
            // Insert transaksi
            $this->Transaksi_model->insert_transaksi($data_transaksi);
            
            // Update saldo nasabah
            $this->Nasabah_model->update_saldo($id_nasabah, $saldo_sesudah);
            
            // Complete transaction
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal melakukan setoran!');
                redirect('transaksi/setoran');
            } else {
                $this->session->set_flashdata('success', 'Setoran berhasil! Saldo baru: Rp ' . number_format($saldo_sesudah, 0, ',', '.'));
                redirect('transaksi');
            }
        }
    }

    // Halaman form penarikan
    public function penarikan()
    {
        $data['title'] = 'Penarikan - Aplikasi Tabungan';
        
        // Get ID nasabah dari parameter jika ada
        $id_nasabah = $this->input->get('id');
        $data['nasabah_selected'] = null;
        
        if ($id_nasabah) {
            $data['nasabah_selected'] = $this->Nasabah_model->get_nasabah_by_id($id_nasabah);
        }
        
        // Get semua nasabah aktif untuk dropdown
        $data['nasabah_list'] = $this->Nasabah_model->get_all_nasabah();
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/penarikan', $data);
        $this->load->view('templates/footer');
    }

    // Proses penarikan
    public function penarikan_aksi()
    {
        // Validasi form
        $this->form_validation->set_rules('id_nasabah', 'Nasabah', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Penarikan', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('transaksi/penarikan');
        } else {
            $id_nasabah = $this->input->post('id_nasabah');
            $jumlah = $this->input->post('jumlah');
            $keterangan = $this->input->post('keterangan');
            
            // Get data nasabah
            $nasabah = $this->Nasabah_model->get_nasabah_by_id($id_nasabah);
            
            if (!$nasabah) {
                $this->session->set_flashdata('error', 'Data nasabah tidak ditemukan!');
                redirect('transaksi/penarikan');
            }
            
            // Cek status nasabah
            if ($nasabah->status != 'aktif') {
                $this->session->set_flashdata('error', 'Nasabah tidak aktif! Tidak dapat melakukan transaksi.');
                redirect('transaksi/penarikan');
            }
            
            $saldo_sebelum = $nasabah->saldo;
            
            // Cek saldo mencukupi
            if ($saldo_sebelum < $jumlah) {
                $this->session->set_flashdata('error', 'Saldo tidak mencukupi! Saldo saat ini: Rp ' . number_format($saldo_sebelum, 0, ',', '.'));
                redirect('transaksi/penarikan');
            }
            
            $saldo_sesudah = $saldo_sebelum - $jumlah;
            
            // Data transaksi
            $data_transaksi = [
                'id_nasabah' => $id_nasabah,
                'jenis_transaksi' => 'penarikan',
                'jumlah' => $jumlah,
                'saldo_sebelum' => $saldo_sebelum,
                'saldo_sesudah' => $saldo_sesudah,
                'keterangan' => $keterangan,
                'petugas' => 'Admin' // Ganti dengan session user jika sudah ada login
            ];
            
            // Start transaction
            $this->db->trans_start();
            
            // Insert transaksi
            $this->Transaksi_model->insert_transaksi($data_transaksi);
            
            // Update saldo nasabah
            $this->Nasabah_model->update_saldo($id_nasabah, $saldo_sesudah);
            
            // Complete transaction
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal melakukan penarikan!');
                redirect('transaksi/penarikan');
            } else {
                $this->session->set_flashdata('success', 'Penarikan berhasil! Saldo baru: Rp ' . number_format($saldo_sesudah, 0, ',', '.'));
                redirect('transaksi');
            }
        }
    }

    // Detail transaksi
    public function detail($id)
    {
        $data['title'] = 'Detail Transaksi - Aplikasi Tabungan';
        $data['transaksi'] = $this->Transaksi_model->get_transaksi_by_id($id);
        
        if (!$data['transaksi']) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan!');
            redirect('transaksi');
        }
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/detail', $data);
        $this->load->view('templates/footer');
    }

    // Hapus transaksi (hanya untuk admin)
    public function hapus($id)
    {
        $transaksi = $this->Transaksi_model->get_transaksi_by_id($id);
        
        if (!$transaksi) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan!');
            redirect('transaksi');
        }
        
        // Kembalikan saldo
        $nasabah = $this->Nasabah_model->get_nasabah_by_id($transaksi->id_nasabah);
        
        if ($transaksi->jenis_transaksi == 'setoran') {
            $saldo_baru = $nasabah->saldo - $transaksi->jumlah;
        } else {
            $saldo_baru = $nasabah->saldo + $transaksi->jumlah;
        }
        
        // Start transaction
        $this->db->trans_start();
        
        // Update saldo
        $this->Nasabah_model->update_saldo($transaksi->id_nasabah, $saldo_baru);
        
        // Hapus transaksi
        $this->Transaksi_model->delete_transaksi($id);
        
        // Complete transaction
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menghapus transaksi!');
        } else {
            $this->session->set_flashdata('success', 'Transaksi berhasil dihapus!');
        }
        
        redirect('transaksi');
    }

    // Get saldo nasabah (AJAX)
    public function get_saldo()
    {
        $id_nasabah = $this->input->post('id_nasabah');
        $nasabah = $this->Nasabah_model->get_nasabah_by_id($id_nasabah);
        
        if ($nasabah) {
            echo json_encode([
                'success' => true,
                'saldo' => $nasabah->saldo,
                'saldo_formatted' => number_format($nasabah->saldo, 0, ',', '.'),
                'nama' => $nasabah->nama_nasabah,
                'no_rekening' => $nasabah->no_rekening,
                'status' => $nasabah->status
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Nasabah tidak ditemukan'
            ]);
        }
    }

    // Print bukti transaksi
    public function print_bukti($id)
    {
        $data['title'] = 'Bukti Transaksi';
        $data['transaksi'] = $this->Transaksi_model->get_transaksi_by_id($id);
        
        if (!$data['transaksi']) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan!');
            redirect('transaksi');
        }
        
        // Load view khusus print
        $this->load->view('transaksi/print_bukti', $data);
    }
}