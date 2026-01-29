<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('login_view');
    }

    public function proses() {
        // Enable error reporting untuk debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        // Debug: Log semua request data
        log_message('debug', 'Login proses called');
        log_message('debug', 'POST data: ' . print_r($this->input->post(), true));
        log_message('debug', 'Request method: ' . $this->input->server('REQUEST_METHOD'));
        
        // Cek apakah request menggunakan POST
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            log_message('error', 'Login proses called without POST request');
            $this->session->set_flashdata('error', 'Invalid request method');
            redirect('login');
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Debug: Log input values
        log_message('debug', 'Login attempt - Username: "' . $username . '", Password length: ' . strlen($password));

        // Validasi input
        if (empty($username) || empty($password)) {
            log_message('debug', 'Empty username or password');
            $this->session->set_flashdata('error', 'Username dan password harus diisi!');
            redirect('login');
            return;
        }

        if ($username === 'admin' && $password === 'admin123') {
            $session_data = array(
                'username' => $username,
                'logged_in' => TRUE,
                'login_time' => time()
            );
            $this->session->set_userdata($session_data);
            
            // Debug: Log successful login
            log_message('debug', 'Login successful for user: ' . $username);
            log_message('debug', 'Session data: ' . print_r($this->session->userdata(), true));
            
            redirect('dashboard');
        } else {
            // Debug: Log failed login
            log_message('debug', 'Login failed for user: ' . $username);
            
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function test() {
        // Test function for debugging
        log_message('debug', 'Test function called');
    }
}