<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->helper('url');
        
        // Uncomment jika sudah ada sistem login
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('auth/login');
        // }
    }

    public function index()
    {
        $data['title'] = 'Dashboard - Aplikasi Tabungan';
        
        // Mengambil data statistik dari model
        $data['total_nasabah'] = $this->Dashboard_model->get_total_nasabah();
        $data['total_saldo'] = $this->Dashboard_model->get_total_saldo();
        $data['transaksi_hari_ini'] = $this->Dashboard_model->get_transaksi_hari_ini();
        $data['total_transaksi'] = $this->Dashboard_model->get_total_transaksi();
        
        // Mengambil data transaksi terbaru
        $data['transaksi_terbaru'] = $this->Dashboard_model->get_transaksi_terbaru(10);
        
        // Mengambil data nasabah dengan saldo tertinggi
        $data['nasabah_top'] = $this->Dashboard_model->get_nasabah_top(5);
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}