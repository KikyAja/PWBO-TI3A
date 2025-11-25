<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index()
    {
        // Langsung arahkan ke halaman login
        $this->login();
    }

    public function login()
    {
        // Jika user sudah login, arahkan ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['title'] = 'Login';
        $this->load->view('login', $data);
    }

    public function process_login()
    {
        // 1. Validasi Input
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE)
        {
            // Validasi gagal, tampilkan ulang form login
            $this->login();
        }
        else
        {
            // 2. Proses Autentikasi
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->login($email, $password);

            if ($user) {
                // 3. Autentikasi Berhasil: Buat Session
                $session_data = array(
                    'id_user'    => $user->id_user,
                    'email'   => $user->email,
                    'logged_in'  => TRUE
                );
                
                $this->session->set_userdata($session_data);
                
                // Arahkan ke Dashboard
                redirect('dashboard');
            } else {
                // 4. Autentikasi Gagal
                $this->session->set_flashdata('error', 'Email atau Password salah.');
                redirect('auth/login');
            }
        }
    }

    public function logout()
    {
        // Hapus semua data session
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();

        // Arahkan kembali ke halaman login
        redirect('auth/login');
    }
}