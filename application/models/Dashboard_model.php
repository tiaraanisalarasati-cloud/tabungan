<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Mendapatkan total jumlah nasabah
    public function get_total_nasabah()
    {
        return $this->db->count_all('nasabah');
    }

    // Mendapatkan total saldo semua nasabah
    public function get_total_saldo()
    {
        $this->db->select_sum('saldo');
        $query = $this->db->get('nasabah');
        $result = $query->row();
        return $result->saldo ? $result->saldo : 0;
    }

    // Mendapatkan jumlah transaksi hari ini
    public function get_transaksi_hari_ini()
    {
        $this->db->where('DATE(tanggal)', date('Y-m-d'));
        return $this->db->count_all_results('transaksi');
    }

    // Mendapatkan total semua transaksi
    public function get_total_transaksi()
    {
        return $this->db->count_all('transaksi');
    }

    // Mendapatkan transaksi terbaru
    public function get_transaksi_terbaru($limit = 10)
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening');
        $this->db->from('transaksi');
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->order_by('transaksi.tanggal', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan nasabah dengan saldo tertinggi
    public function get_nasabah_top($limit = 5)
    {
        $this->db->select('id_nasabah, no_rekening, nama_nasabah, saldo');
        $this->db->from('nasabah');
        $this->db->order_by('saldo', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan data untuk grafik transaksi 7 hari terakhir
    public function get_grafik_transaksi_mingguan()
    {
        $this->db->select('DATE(tanggal) as tanggal, COUNT(*) as jumlah');
        $this->db->from('transaksi');
        $this->db->where('tanggal >=', date('Y-m-d', strtotime('-7 days')));
        $this->db->group_by('DATE(tanggal)');
        $this->db->order_by('tanggal', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan total penarikan hari ini
    public function get_total_penarikan_hari_ini()
    {
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', 'penarikan');
        $this->db->where('DATE(tanggal)', date('Y-m-d'));
        $query = $this->db->get('transaksi');
        $result = $query->row();
        return $result->jumlah ? $result->jumlah : 0;
    }

    // Mendapatkan total setoran hari ini
    public function get_total_setoran_hari_ini()
    {
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', 'setoran');
        $this->db->where('DATE(tanggal)', date('Y-m-d'));
        $query = $this->db->get('transaksi');
        $result = $query->row();
        return $result->jumlah ? $result->jumlah : 0;
    }
}