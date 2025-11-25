<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Akses ditolak. Silakan login terlebih dahulu.');
            redirect('auth/login');
        }
    }

    public function index() {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard');
        $this->load->view('template/footer');
    }
}