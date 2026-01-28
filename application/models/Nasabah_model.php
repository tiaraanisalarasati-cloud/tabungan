<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nasabah_model extends CI_Model {

    private $table = 'nasabah';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Mendapatkan semua data nasabah
    public function get_all_nasabah()
    {
        $this->db->order_by('tanggal_daftar', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Mendapatkan data nasabah berdasarkan ID
    public function get_nasabah_by_id($id)
    {
        $this->db->where('id_nasabah', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    // Mendapatkan data nasabah berdasarkan nomor rekening
    public function get_nasabah_by_norek($no_rekening)
    {
        $this->db->where('no_rekening', $no_rekening);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    // Insert data nasabah baru
    public function insert_nasabah($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update data nasabah
    public function update_nasabah($id, $data)
    {
        $this->db->where('id_nasabah', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete data nasabah
    public function delete_nasabah($id)
    {
        $this->db->where('id_nasabah', $id);
        return $this->db->delete($this->table);
    }

    // Pencarian nasabah
    public function search_nasabah($keyword)
    {
        $this->db->like('no_rekening', $keyword);
        $this->db->or_like('nama_nasabah', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('no_telepon', $keyword);
        $this->db->order_by('tanggal_daftar', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Generate nomor rekening otomatis
    public function generate_no_rekening()
    {
        // Format: TAB + YYYYMMDD + XXXX (counter)
        $date = date('Ymd');
        
        // Cari nomor rekening terakhir hari ini
        $this->db->select('no_rekening');
        $this->db->like('no_rekening', 'TAB' . $date);
        $this->db->order_by('no_rekening', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        
        if ($query->num_rows() > 0) {
            $last_norek = $query->row()->no_rekening;
            // Ambil 4 digit terakhir dan tambah 1
            $counter = intval(substr($last_norek, -4)) + 1;
        } else {
            $counter = 1;
        }
        
        // Format nomor rekening: TAB + YYYYMMDD + counter 4 digit
        $no_rekening = 'TAB' . $date . str_pad($counter, 4, '0', STR_PAD_LEFT);
        
        return $no_rekening;
    }

    // Mendapatkan transaksi berdasarkan ID nasabah
    public function get_transaksi_by_nasabah($id_nasabah, $limit = 10)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->where('id_nasabah', $id_nasabah);
        $this->db->order_by('tanggal', 'DESC');
        
        if ($limit > 0) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    // Hitung total nasabah
    public function count_all_nasabah()
    {
        return $this->db->count_all($this->table);
    }

    // Hitung nasabah aktif
    public function count_aktif_nasabah()
    {
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results($this->table);
    }

    // Hitung nasabah non-aktif
    public function count_nonaktif_nasabah()
    {
        $this->db->where('status', 'nonaktif');
        return $this->db->count_all_results($this->table);
    }

    // Update saldo nasabah
    public function update_saldo($id_nasabah, $saldo_baru)
    {
        $data = ['saldo' => $saldo_baru];
        $this->db->where('id_nasabah', $id_nasabah);
        return $this->db->update($this->table, $data);
    }

    // Get nasabah dengan pagination
    public function get_nasabah_paginated($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->order_by('tanggal_daftar', 'DESC');
        $query = $this->db->get($this->table);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        
        return false;
    }

    // Cek apakah nomor rekening sudah ada
    public function check_no_rekening($no_rekening, $exclude_id = null)
    {
        $this->db->where('no_rekening', $no_rekening);
        
        if ($exclude_id) {
            $this->db->where('id_nasabah !=', $exclude_id);
        }
        
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }
}