<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nasabah extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nasabah_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        
        // Uncomment jika sudah ada sistem login
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('auth/login');
        // }
    }

    // Halaman utama data nasabah
    public function index()
    {
        $data['title'] = 'Data Nasabah - Aplikasi Tabungan';
        
        // Pencarian
        $keyword = $this->input->get('search');
        if ($keyword) {
            $data['nasabah'] = $this->Nasabah_model->search_nasabah($keyword);
        } else {
            $data['nasabah'] = $this->Nasabah_model->get_all_nasabah();
        }
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('nasabah/index', $data);
        $this->load->view('templates/footer');
    }

    // Halaman tambah nasabah
    public function tambah()
    {
        $data['title'] = 'Tambah Nasabah - Aplikasi Tabungan';
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('nasabah/tambah', $data);
        $this->load->view('templates/footer');
    }

    // Proses tambah nasabah
    public function tambah_aksi()
    {
        // Validasi form
        $this->form_validation->set_rules('no_rekening', 'Nomor Rekening', 'required|is_unique[nasabah.no_rekening]', [
            'required' => 'Nomor rekening harus diisi',
            'is_unique' => 'Nomor rekening sudah terdaftar'
        ]);
        $this->form_validation->set_rules('nama_nasabah', 'Nama Nasabah', 'required|min_length[3]', [
            'required' => 'Nama nasabah harus diisi',
            'min_length' => 'Nama nasabah minimal 3 karakter'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[5]', [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat terlalu pendek, minimal 5 karakter'
        ]);
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|numeric|min_length[10]|max_length[15]', [
            'required' => 'No. telepon harus diisi',
            'numeric' => 'No. telepon harus berupa angka',
            'min_length' => 'No. telepon minimal 10 digit',
            'max_length' => 'No. telepon maksimal 15 digit'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'valid_email', [
            'valid_email' => 'Format email tidak valid'
        ]);
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|callback_validate_date', [
            'required' => 'Tanggal lahir harus diisi',
            'validate_date' => 'Format tanggal tidak valid'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]', [
            'required' => 'Jenis kelamin harus dipilih',
            'in_list' => 'Jenis kelamin tidak valid'
        ]);
        $this->form_validation->set_rules('saldo', 'Saldo Awal', 'required|numeric|greater_than_equal_to[0]', [
            'required' => 'Saldo awal harus diisi',
            'numeric' => 'Saldo harus berupa angka',
            'greater_than_equal_to' => 'Saldo tidak boleh kurang dari 0'
        ]);

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form dengan data input sebelumnya
            $this->session->set_flashdata('error', validation_errors());
            $this->tambah();
        } else {
            // Data nasabah
            $data = [
                'no_rekening' => $this->input->post('no_rekening'),
                'nama_nasabah' => ucwords(strtolower($this->input->post('nama_nasabah'))),
                'alamat' => $this->input->post('alamat'),
                'no_telepon' => $this->input->post('no_telepon'),
                'email' => strtolower($this->input->post('email')),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'pekerjaan' => $this->input->post('pekerjaan') ?: null,
                'saldo' => $this->input->post('saldo'),
                'tanggal_daftar' => date('Y-m-d H:i:s'),
                'status' => 'aktif'
            ];

            // Mulai transaksi database
            $this->db->trans_start();
            
            // Insert ke database
            $insert = $this->Nasabah_model->insert_nasabah($data);
            
            // Jika ingin mencatat transaksi pertama (opsional)
            if ($insert && $data['saldo'] > 0) {
                $transaksi = [
                    'id_nasabah' => $this->db->insert_id(),
                    'jenis' => 'setor',
                    'jumlah' => $data['saldo'],
                    'keterangan' => 'Saldo awal pembukaan rekening',
                    'tanggal' => date('Y-m-d H:i:s'),
                    'id_petugas' => $this->session->userdata('user_id') ?? 1 // Ganti dengan session user yang login
                ];
                $this->db->insert('transaksi', $transaksi);
            }
            
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal menambahkan data nasabah! ' . $this->db->error()['message']);
                $this->tambah();
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Data nasabah berhasil ditambahkan!');
                redirect('nasabah');
            }
        }
    }

    // Halaman detail nasabah
    public function detail($id)
    {
        $data['title'] = 'Detail Nasabah - Aplikasi Tabungan';
        $data['nasabah'] = $this->Nasabah_model->get_nasabah_by_id($id);
        
        if (!$data['nasabah']) {
            $this->session->set_flashdata('error', 'Data nasabah tidak ditemukan!');
            redirect('nasabah');
        }
        
        // Ambil riwayat transaksi
        $data['transaksi'] = $this->Nasabah_model->get_transaksi_by_nasabah($id);
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('nasabah/detail', $data);
        $this->load->view('templates/footer');
    }

    // Halaman edit nasabah
    public function edit($id)
    {
        $data['title'] = 'Edit Nasabah - Aplikasi Tabungan';
        $data['nasabah'] = $this->Nasabah_model->get_nasabah_by_id($id);
        
        if (!$data['nasabah']) {
            $this->session->set_flashdata('error', 'Data nasabah tidak ditemukan!');
            redirect('nasabah');
        }
        
        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('nasabah/edit', $data);
        $this->load->view('templates/footer');
    }

    // Proses edit nasabah
    public function edit_aksi()
    {
        $id = $this->input->post('id_nasabah');
        
        // Validasi form
        $this->form_validation->set_rules('nama_nasabah', 'Nama Nasabah', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('nasabah/edit/' . $id);
        } else {
            // Data nasabah (tanpa saldo dan no_rekening karena tidak boleh diubah)
            $data = [
                'nama_nasabah' => $this->input->post('nama_nasabah'),
                'alamat' => $this->input->post('alamat'),
                'no_telepon' => $this->input->post('no_telepon'),
                'email' => $this->input->post('email'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'status' => $this->input->post('status')
            ];

            // Update ke database
            $update = $this->Nasabah_model->update_nasabah($id, $data);

            if ($update) {
                $this->session->set_flashdata('success', 'Data nasabah berhasil diperbarui!');
                redirect('nasabah');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data nasabah!');
                redirect('nasabah/edit/' . $id);
            }
        }
    }

    // Hapus nasabah
    public function hapus($id)
    {
        // Cek apakah nasabah memiliki transaksi
        $transaksi = $this->Nasabah_model->get_transaksi_by_nasabah($id);
        
        if (count($transaksi) > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus nasabah yang memiliki riwayat transaksi!');
            redirect('nasabah');
        }
        
        $delete = $this->Nasabah_model->delete_nasabah($id);

        if ($delete) {
            $this->session->set_flashdata('success', 'Data nasabah berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data nasabah!');
        }
        
        redirect('nasabah');
    }

    // Generate nomor rekening otomatis
    public function generate_no_rekening()
    {
        $no_rekening = $this->Nasabah_model->generate_no_rekening();
        echo json_encode(['no_rekening' => $no_rekening]);
    }

    // Export data ke Excel (opsional)
    public function export_excel()
    {
        // Load library PHPExcel jika ada
        $data['nasabah'] = $this->Nasabah_model->get_all_nasabah();
        
        // Untuk sementara, redirect dulu
        $this->session->set_flashdata('info', 'Fitur export sedang dalam pengembangan');
        redirect('nasabah');
    }
}
