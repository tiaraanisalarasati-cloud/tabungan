<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo "<h1>Debug Info</h1>";
        echo "<p>Base URL: " . base_url() . "</p>";
        echo "<p>Site URL: " . site_url() . "</p>";
        echo "<p>Current URL: " . current_url() . "</p>";
        echo "<p>Request Method: " . $this->input->server('REQUEST_METHOD') . "</p>";
        echo "<p>Session Data: <pre>" . print_r($this->session->userdata(), true) . "</pre></p>";
        echo "<p>POST Data: <pre>" . print_r($this->input->post(), true) . "</pre></p>";
        echo "<p>GET Data: <pre>" . print_r($this->input->get(), true) . "</pre></p>";
        
        echo "<h2>Test Form</h2>";
        echo '<form method="post" action="' . site_url('debug/test') . '">';
        echo '<input type="text" name="test" placeholder="Test input">';
        echo '<button type="submit">Submit</button>';
        echo '</form>';
    }
    
    public function test() {
        echo "<h1>Test Result</h1>";
        echo "<p>POST Data: <pre>" . print_r($this->input->post(), true) . "</pre></p>";
        echo '<a href="' . site_url('debug') . '">Back</a>';
    }
}
