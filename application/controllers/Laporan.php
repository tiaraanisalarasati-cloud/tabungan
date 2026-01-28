<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Laporan_model', 'Nasabah_model', 'Transaksi_model']);
        $this->load->helper(['url', 'form']);
        $this->load->library(['session']);
        
        // Uncomment jika sudah ada sistem login
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('auth/login');
        // }
    }

    // Halaman utama laporan
    public function index()
    {
        $data['title'] = 'Laporan - Aplikasi Tabungan';
        
        // Statistik umum
        $data['total_nasabah'] = $this->Nasabah_model->count_all_nasabah();
        $data['total_saldo'] = $this->Laporan_model->get_total_saldo_semua();
        $data['total_transaksi_bulan_ini'] = $this->Laporan_model->get_total_transaksi_bulan_ini();
        $data['total_setoran_bulan_ini'] = $this->Laporan_model->get_total_setoran_bulan_ini();
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    // Laporan Saldo Per Nasabah
    public function saldo_nasabah()
    {
        $data['title'] = 'Laporan Saldo Per Nasabah - Aplikasi Tabungan';
        
        // Filter
        $status = $this->input->get('status');
        $urutan = $this->input->get('urutan') ? $this->input->get('urutan') : 'saldo_desc';
        
        // Get data nasabah dengan filter
        $data['nasabah'] = $this->Laporan_model->get_laporan_saldo_nasabah($status, $urutan);
        
        // Statistik
        $data['total_nasabah'] = count($data['nasabah']);
        $data['total_saldo'] = 0;
        $data['saldo_tertinggi'] = 0;
        $data['saldo_terendah'] = PHP_INT_MAX;
        
        foreach ($data['nasabah'] as $n) {
            $data['total_saldo'] += $n->saldo;
            if ($n->saldo > $data['saldo_tertinggi']) {
                $data['saldo_tertinggi'] = $n->saldo;
            }
            if ($n->saldo < $data['saldo_terendah']) {
                $data['saldo_terendah'] = $n->saldo;
            }
        }
        
        if ($data['total_nasabah'] > 0) {
            $data['rata_rata_saldo'] = $data['total_saldo'] / $data['total_nasabah'];
        } else {
            $data['rata_rata_saldo'] = 0;
            $data['saldo_terendah'] = 0;
        }
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/saldo_nasabah', $data);
        $this->load->view('templates/footer');
    }

    // Laporan Transaksi Per Bulan
    public function transaksi_bulanan()
    {
        $data['title'] = 'Laporan Transaksi Per Bulan - Aplikasi Tabungan';
        
        // Filter bulan dan tahun
        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        
        // Get data transaksi per bulan
        $data['transaksi'] = $this->Laporan_model->get_transaksi_per_bulan($bulan, $tahun);
        
        // Statistik bulanan
        $statistik = $this->Laporan_model->get_statistik_bulanan($bulan, $tahun);
        $data['total_transaksi'] = $statistik['total_transaksi'];
        $data['total_setoran'] = $statistik['total_setoran'];
        $data['total_penarikan'] = $statistik['total_penarikan'];
        $data['jumlah_setoran'] = $statistik['jumlah_setoran'];
        $data['jumlah_penarikan'] = $statistik['jumlah_penarikan'];
        $data['selisih'] = $statistik['total_setoran'] - $statistik['total_penarikan'];
        
        // Data per hari untuk chart
        $data['data_per_hari'] = $this->Laporan_model->get_transaksi_per_hari($bulan, $tahun);
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/transaksi_bulanan', $data);
        $this->load->view('templates/footer');
    }

    // Laporan Transaksi Per Nasabah
    public function transaksi_nasabah($id_nasabah = null)
    {
        $data['title'] = 'Laporan Transaksi Per Nasabah - Aplikasi Tabungan';
        
        // Get semua nasabah untuk dropdown
        $data['nasabah_list'] = $this->Nasabah_model->get_all_nasabah();
        
        // id_nasabah bisa dikirim sebagai segment URL atau sebagai query string (?id_nasabah=...)
        if ($id_nasabah === null) {
            $id_nasabah = $this->input->get('id_nasabah');
        }
        
        if ($id_nasabah) {
            // Get detail nasabah
            $data['nasabah'] = $this->Nasabah_model->get_nasabah_by_id($id_nasabah);
            
            if (!$data['nasabah']) {
                $this->session->set_flashdata('error', 'Nasabah tidak ditemukan!');
                redirect('laporan/transaksi_nasabah');
            }
            
            // Filter tanggal
            $tgl_dari = $this->input->get('tgl_dari');
            $tgl_sampai = $this->input->get('tgl_sampai');
            
            $data['tgl_dari'] = $tgl_dari;
            $data['tgl_sampai'] = $tgl_sampai;
            
            // Get transaksi nasabah
            $data['transaksi'] = $this->Laporan_model->get_transaksi_by_nasabah($id_nasabah, $tgl_dari, $tgl_sampai);
            
            // Statistik
            $data['total_setoran'] = 0;
            $data['total_penarikan'] = 0;
            $data['jumlah_setoran'] = 0;
            $data['jumlah_penarikan'] = 0;
            
            foreach ($data['transaksi'] as $t) {
                if ($t->jenis_transaksi == 'setoran') {
                    $data['total_setoran'] += $t->jumlah;
                    $data['jumlah_setoran']++;
                } else {
                    $data['total_penarikan'] += $t->jumlah;
                    $data['jumlah_penarikan']++;
                }
            }
        } else {
            $data['nasabah'] = null;
            $data['transaksi'] = [];
            $data['total_setoran'] = 0;
            $data['total_penarikan'] = 0;
            $data['jumlah_setoran'] = 0;
            $data['jumlah_penarikan'] = 0;
        }
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/transaksi_nasabah', $data);
        $this->load->view('templates/footer');
    }

    // Print Laporan Saldo Nasabah
    public function print_saldo_nasabah()
    {
        $data['title'] = 'Laporan Saldo Per Nasabah';
        
        $status = $this->input->get('status');
        $urutan = $this->input->get('urutan') ? $this->input->get('urutan') : 'saldo_desc';
        
        $data['nasabah'] = $this->Laporan_model->get_laporan_saldo_nasabah($status, $urutan);
        
        // Statistik
        $data['total_nasabah'] = count($data['nasabah']);
        $data['total_saldo'] = 0;
        
        foreach ($data['nasabah'] as $n) {
            $data['total_saldo'] += $n->saldo;
        }
        
        $data['rata_rata_saldo'] = $data['total_nasabah'] > 0 ? $data['total_saldo'] / $data['total_nasabah'] : 0;
        
        // Load view print
        $this->load->view('laporan/print_saldo_nasabah', $data);
    }

    // Print Laporan Transaksi Bulanan
    public function print_transaksi_bulanan()
    {
        $data['title'] = 'Laporan Transaksi Per Bulan';
        
        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        
        $data['transaksi'] = $this->Laporan_model->get_transaksi_per_bulan($bulan, $tahun);
        
        // Statistik
        $statistik = $this->Laporan_model->get_statistik_bulanan($bulan, $tahun);
        $data['total_transaksi'] = $statistik['total_transaksi'];
        $data['total_setoran'] = $statistik['total_setoran'];
        $data['total_penarikan'] = $statistik['total_penarikan'];
        $data['jumlah_setoran'] = $statistik['jumlah_setoran'];
        $data['jumlah_penarikan'] = $statistik['jumlah_penarikan'];
        
        // Load view print
        $this->load->view('laporan/print_transaksi_bulanan', $data);
    }

    // Print Laporan Transaksi Nasabah
    public function print_transaksi_nasabah($id_nasabah)
    {
        $data['title'] = 'Laporan Transaksi Nasabah';
        
        $data['nasabah'] = $this->Nasabah_model->get_nasabah_by_id($id_nasabah);
        
        if (!$data['nasabah']) {
            show_error('Nasabah tidak ditemukan');
        }
        
        $tgl_dari = $this->input->get('tgl_dari');
        $tgl_sampai = $this->input->get('tgl_sampai');
        
        $data['tgl_dari'] = $tgl_dari;
        $data['tgl_sampai'] = $tgl_sampai;
        
        $data['transaksi'] = $this->Laporan_model->get_transaksi_by_nasabah($id_nasabah, $tgl_dari, $tgl_sampai);
        
        // Statistik
        $data['total_setoran'] = 0;
        $data['total_penarikan'] = 0;
        
        foreach ($data['transaksi'] as $t) {
            if ($t->jenis_transaksi == 'setoran') {
                $data['total_setoran'] += $t->jumlah;
            } else {
                $data['total_penarikan'] += $t->jumlah;
            }
        }
        
        // Load view print
        $this->load->view('laporan/print_transaksi_nasabah', $data);
    }

    // Export Excel Saldo Nasabah (placeholder)
    public function export_saldo_excel()
    {
        $this->session->set_flashdata('info', 'Fitur export Excel sedang dalam pengembangan');
        redirect('laporan/saldo_nasabah');
    }

    // Export Excel Transaksi Bulanan (placeholder)
    public function export_transaksi_excel()
    {
        $this->session->set_flashdata('info', 'Fitur export Excel sedang dalam pengembangan');
        redirect('laporan/transaksi_bulanan');
    }
}
