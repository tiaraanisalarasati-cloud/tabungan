<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    private $table = 'transaksi';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Mendapatkan semua transaksi dengan join nasabah
    public function get_all_transaksi()
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening');
        $this->db->from($this->table);
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->order_by('transaksi.tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan transaksi dengan filter
    public function get_transaksi_filtered($filter = [])
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening');
        $this->db->from($this->table);
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        
        // Filter jenis transaksi
        if (isset($filter['jenis_transaksi'])) {
            $this->db->where('transaksi.jenis_transaksi', $filter['jenis_transaksi']);
        }
        
        // Filter tanggal dari
        if (isset($filter['tgl_dari'])) {
            $this->db->where('DATE(transaksi.tanggal) >=', $filter['tgl_dari']);
        }
        
        // Filter tanggal sampai
        if (isset($filter['tgl_sampai'])) {
            $this->db->where('DATE(transaksi.tanggal) <=', $filter['tgl_sampai']);
        }
        
        // Filter pencarian
        if (isset($filter['search'])) {
            $this->db->group_start();
            $this->db->like('nasabah.nama_nasabah', $filter['search']);
            $this->db->or_like('nasabah.no_rekening', $filter['search']);
            $this->db->or_like('transaksi.keterangan', $filter['search']);
            $this->db->group_end();
        }
        
        $this->db->order_by('transaksi.tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan transaksi berdasarkan ID
    public function get_transaksi_by_id($id)
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening, nasabah.alamat, nasabah.no_telepon');
        $this->db->from($this->table);
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->where('transaksi.id_transaksi', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Insert transaksi baru
    public function insert_transaksi($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update transaksi
    public function update_transaksi($id, $data)
    {
        $this->db->where('id_transaksi', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete transaksi
    public function delete_transaksi($id)
    {
        $this->db->where('id_transaksi', $id);
        return $this->db->delete($this->table);
    }

    // Mendapatkan transaksi berdasarkan nasabah
    public function get_transaksi_by_nasabah($id_nasabah, $limit = 0)
    {
        $this->db->where('id_nasabah', $id_nasabah);
        $this->db->order_by('tanggal', 'DESC');
        
        if ($limit > 0) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Mendapatkan total transaksi berdasarkan jenis
    public function get_total_by_jenis($jenis, $tgl_dari = null, $tgl_sampai = null)
    {
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', $jenis);
        
        if ($tgl_dari) {
            $this->db->where('DATE(tanggal) >=', $tgl_dari);
        }
        
        if ($tgl_sampai) {
            $this->db->where('DATE(tanggal) <=', $tgl_sampai);
        }
        
        $query = $this->db->get($this->table);
        $result = $query->row();
        return $result->jumlah ? $result->jumlah : 0;
    }

    // Mendapatkan jumlah transaksi berdasarkan jenis
    public function get_count_by_jenis($jenis, $tgl_dari = null, $tgl_sampai = null)
    {
        $this->db->where('jenis_transaksi', $jenis);
        
        if ($tgl_dari) {
            $this->db->where('DATE(tanggal) >=', $tgl_dari);
        }
        
        if ($tgl_sampai) {
            $this->db->where('DATE(tanggal) <=', $tgl_sampai);
        }
        
        return $this->db->count_all_results($this->table);
    }

    // Mendapatkan transaksi hari ini
    public function get_transaksi_hari_ini()
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening');
        $this->db->from($this->table);
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->where('DATE(transaksi.tanggal)', date('Y-m-d'));
        $this->db->order_by('transaksi.tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan transaksi bulan ini
    public function get_transaksi_bulan_ini()
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening');
        $this->db->from($this->table);
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->where('MONTH(transaksi.tanggal)', date('m'));
        $this->db->where('YEAR(transaksi.tanggal)', date('Y'));
        $this->db->order_by('transaksi.tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan statistik transaksi
    public function get_statistik($tgl_dari = null, $tgl_sampai = null)
    {
        $statistik = [];
        
        // Total setoran
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', 'setoran');
        if ($tgl_dari) $this->db->where('DATE(tanggal) >=', $tgl_dari);
        if ($tgl_sampai) $this->db->where('DATE(tanggal) <=', $tgl_sampai);
        $query = $this->db->get($this->table);
        $statistik['total_setoran'] = ($query->row() !== null) ? $query->row()->jumlah : 0;
        
        // Total penarikan
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', 'penarikan');
        if ($tgl_dari) $this->db->where('DATE(tanggal) >=', $tgl_dari);
        if ($tgl_sampai) $this->db->where('DATE(tanggal) <=', $tgl_sampai);
        $query = $this->db->get($this->table);
        $statistik['total_penarikan'] = ($query->row() !== null) ? $query->row()->jumlah : 0;
        
        // Jumlah transaksi
        $this->db->where('jenis_transaksi', 'setoran');
        if ($tgl_dari) $this->db->where('DATE(tanggal) >=', $tgl_dari);
        if ($tgl_sampai) $this->db->where('DATE(tanggal) <=', $tgl_sampai);
        $statistik['jumlah_setoran'] = $this->db->count_all_results($this->table);
        
        $this->db->where('jenis_transaksi', 'penarikan');
        if ($tgl_dari) $this->db->where('DATE(tanggal) >=', $tgl_dari);
        if ($tgl_sampai) $this->db->where('DATE(tanggal) <=', $tgl_sampai);
        $statistik['jumlah_penarikan'] = $this->db->count_all_results($this->table);
        
        return $statistik;
    }

    // Mendapatkan transaksi dengan pagination
    public function get_transaksi_paginated($limit, $start, $filter = [])
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening');
        $this->db->from($this->table);
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        
        // Apply filters
        if (isset($filter['jenis_transaksi'])) {
            $this->db->where('transaksi.jenis_transaksi', $filter['jenis_transaksi']);
        }
        if (isset($filter['tgl_dari'])) {
            $this->db->where('DATE(transaksi.tanggal) >=', $filter['tgl_dari']);
        }
        if (isset($filter['tgl_sampai'])) {
            $this->db->where('DATE(transaksi.tanggal) <=', $filter['tgl_sampai']);
        }
        
        $this->db->order_by('transaksi.tanggal', 'DESC');
        $this->db->limit($limit, $start);
        
        $query = $this->db->get();
        return $query->result();
    }

    // Hitung total transaksi untuk pagination
    public function count_transaksi_filtered($filter = [])
    {
        $this->db->from($this->table);
        
        if (isset($filter['jenis_transaksi'])) {
            $this->db->where('jenis_transaksi', $filter['jenis_transaksi']);
        }
        if (isset($filter['tgl_dari'])) {
            $this->db->where('DATE(tanggal) >=', $filter['tgl_dari']);
        }
        if (isset($filter['tgl_sampai'])) {
            $this->db->where('DATE(tanggal) <=', $filter['tgl_sampai']);
        }
        
        return $this->db->count_all_results();
    }

    // Mendapatkan transaksi terbaru
    public function get_transaksi_terbaru($limit = 10)
    {
        $this->db->select('transaksi.*, nasabah.nama_nasabah, nasabah.no_rekening');
        $this->db->from($this->table);
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->order_by('transaksi.tanggal', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
}