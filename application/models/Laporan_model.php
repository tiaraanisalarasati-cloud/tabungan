<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ==================== LAPORAN SALDO NASABAH ====================
    
    // Get laporan saldo semua nasabah dengan filter dan urutan
    public function get_laporan_saldo_nasabah($status = null, $urutan = 'saldo_desc')
    {
        $this->db->select('id_nasabah, no_rekening, nama_nasabah, alamat, no_telepon, saldo, status, tanggal_daftar');
        $this->db->from('nasabah');
        
        // Filter status
        if ($status) {
            $this->db->where('status', $status);
        }
        
        // Urutan
        switch ($urutan) {
            case 'saldo_desc':
                $this->db->order_by('saldo', 'DESC');
                break;
            case 'saldo_asc':
                $this->db->order_by('saldo', 'ASC');
                break;
            case 'nama_asc':
                $this->db->order_by('nama_nasabah', 'ASC');
                break;
            case 'nama_desc':
                $this->db->order_by('nama_nasabah', 'DESC');
                break;
            case 'terbaru':
                $this->db->order_by('tanggal_daftar', 'DESC');
                break;
            default:
                $this->db->order_by('saldo', 'DESC');
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get total saldo semua nasabah
    public function get_total_saldo_semua()
    {
        $this->db->select_sum('saldo');
        $query = $this->db->get('nasabah');
        $result = $query->row();
        return $result->saldo ? $result->saldo : 0;
    }

    // Get nasabah dengan saldo tertinggi
    public function get_nasabah_saldo_tertinggi($limit = 10)
    {
        $this->db->select('id_nasabah, no_rekening, nama_nasabah, saldo');
        $this->db->from('nasabah');
        $this->db->order_by('saldo', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    // Get nasabah dengan saldo terendah
    public function get_nasabah_saldo_terendah($limit = 10)
    {
        $this->db->select('id_nasabah, no_rekening, nama_nasabah, saldo');
        $this->db->from('nasabah');
        $this->db->where('saldo >', 0);
        $this->db->order_by('saldo', 'ASC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    // ==================== LAPORAN TRANSAKSI BULANAN ====================
    
    // Get transaksi per bulan
    public function get_transaksi_per_bulan($bulan, $tahun)
    {
        $this->db->select('transaksi.*, nasabah.no_rekening, nasabah.nama_nasabah');
        $this->db->from('transaksi');
        $this->db->join('nasabah', 'nasabah.id_nasabah = transaksi.id_nasabah');
        $this->db->where('MONTH(transaksi.tanggal)', $bulan);
        $this->db->where('YEAR(transaksi.tanggal)', $tahun);
        $this->db->order_by('transaksi.tanggal', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get statistik bulanan
    public function get_statistik_bulanan($bulan, $tahun)
    {
        $statistik = [];
        
        // Total transaksi
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $statistik['total_transaksi'] = $this->db->count_all_results('transaksi');
        
        // Total setoran
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', 'setoran');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $query = $this->db->get('transaksi');
        $result = $query->row();
        $statistik['total_setoran'] = $result->jumlah ? $result->jumlah : 0;
        
        // Total penarikan
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', 'penarikan');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $query = $this->db->get('transaksi');
        $result = $query->row();
        $statistik['total_penarikan'] = $result->jumlah ? $result->jumlah : 0;
        
        // Jumlah setoran
        $this->db->where('jenis_transaksi', 'setoran');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $statistik['jumlah_setoran'] = $this->db->count_all_results('transaksi');
        
        // Jumlah penarikan
        $this->db->where('jenis_transaksi', 'penarikan');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $statistik['jumlah_penarikan'] = $this->db->count_all_results('transaksi');
        
        return $statistik;
    }

    // Get transaksi per hari dalam bulan tertentu (untuk chart)
    public function get_transaksi_per_hari($bulan, $tahun)
    {
        $this->db->select('DATE(tanggal) as tanggal, jenis_transaksi, COUNT(*) as jumlah, SUM(jumlah) as total');
        $this->db->from('transaksi');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->group_by('DATE(tanggal), jenis_transaksi');
        $this->db->order_by('tanggal', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get total transaksi bulan ini
    public function get_total_transaksi_bulan_ini()
    {
        $this->db->where('MONTH(tanggal)', date('m'));
        $this->db->where('YEAR(tanggal)', date('Y'));
        return $this->db->count_all_results('transaksi');
    }

    // Get total setoran bulan ini
    public function get_total_setoran_bulan_ini()
    {
        $this->db->select_sum('jumlah');
        $this->db->where('jenis_transaksi', 'setoran');
        $this->db->where('MONTH(tanggal)', date('m'));
        $this->db->where('YEAR(tanggal)', date('Y'));
        $query = $this->db->get('transaksi');
        $result = $query->row();
        return $result->jumlah ? $result->jumlah : 0;
    }

    // ==================== LAPORAN TRANSAKSI PER NASABAH ====================
    
    // Get transaksi by nasabah dengan filter tanggal
    public function get_transaksi_by_nasabah($id_nasabah, $tgl_dari = null, $tgl_sampai = null)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->where('id_nasabah', $id_nasabah);
        
        if ($tgl_dari) {
            $this->db->where('DATE(tanggal) >=', $tgl_dari);
        }
        
        if ($tgl_sampai) {
            $this->db->where('DATE(tanggal) <=', $tgl_sampai);
        }
        
        $this->db->order_by('tanggal', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // ==================== LAPORAN REKAP ====================
    
    // Get rekap transaksi per bulan dalam tahun tertentu
    public function get_rekap_tahunan($tahun)
    {
        $rekap = [];
        
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data = [];
            $data['bulan'] = $bulan;
            
            // Total transaksi
            $this->db->where('MONTH(tanggal)', $bulan);
            $this->db->where('YEAR(tanggal)', $tahun);
            $data['total_transaksi'] = $this->db->count_all_results('transaksi');
            
            // Total setoran
            $this->db->select_sum('jumlah');
            $this->db->where('jenis_transaksi', 'setoran');
            $this->db->where('MONTH(tanggal)', $bulan);
            $this->db->where('YEAR(tanggal)', $tahun);
            $query = $this->db->get('transaksi');
            $result = $query->row();
            $data['total_setoran'] = $result->jumlah ? $result->jumlah : 0;
            
            // Total penarikan
            $this->db->select_sum('jumlah');
            $this->db->where('jenis_transaksi', 'penarikan');
            $this->db->where('MONTH(tanggal)', $bulan);
            $this->db->where('YEAR(tanggal)', $tahun);
            $query = $this->db->get('transaksi');
            $result = $query->row();
            $data['total_penarikan'] = $result->jumlah ? $result->jumlah : 0;
            
            $rekap[] = $data;
        }
        
        return $rekap;
    }

    // Get top 10 nasabah berdasarkan total transaksi
    public function get_top_nasabah_transaksi($limit = 10)
    {
        $this->db->select('nasabah.id_nasabah, nasabah.no_rekening, nasabah.nama_nasabah, COUNT(transaksi.id_transaksi) as total_transaksi, SUM(transaksi.jumlah) as total_nominal');
        $this->db->from('nasabah');
        $this->db->join('transaksi', 'transaksi.id_nasabah = nasabah.id_nasabah');
        $this->db->group_by('nasabah.id_nasabah');
        $this->db->order_by('total_transaksi', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    // Get pertumbuhan saldo per bulan
    public function get_pertumbuhan_saldo($tahun)
    {
        $pertumbuhan = [];
        
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Get total saldo di akhir bulan
            // Ini perlu dihitung berdasarkan transaksi sampai akhir bulan
            
            $data = [];
            $data['bulan'] = $bulan;
            
            // Hitung dari transaksi
            $this->db->select('SUM(CASE WHEN jenis_transaksi = "setoran" THEN jumlah ELSE -jumlah END) as pertumbuhan');
            $this->db->where('MONTH(tanggal)', $bulan);
            $this->db->where('YEAR(tanggal)', $tahun);
            $query = $this->db->get('transaksi');
            $result = $query->row();
            $data['pertumbuhan'] = $result->pertumbuhan ? $result->pertumbuhan : 0;
            
            $pertumbuhan[] = $data;
        }
        
        return $pertumbuhan;
    }

    // ==================== UTILITY ====================
    
    // Get daftar tahun yang tersedia (dari transaksi)
    public function get_available_years()
    {
        $this->db->select('DISTINCT YEAR(tanggal) as tahun');
        $this->db->from('transaksi');
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        
        $years = [];
        foreach ($result as $row) {
            $years[] = $row->tahun;
        }
        
        // Jika tidak ada data, return tahun sekarang
        if (empty($years)) {
            $years[] = date('Y');
        }
        
        return $years;
    }

    // Get nama bulan dalam bahasa Indonesia
    public function get_nama_bulan($bulan)
    {
        $nama_bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : '';
    }
}