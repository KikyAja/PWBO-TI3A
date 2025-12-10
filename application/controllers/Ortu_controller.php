<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ortu_controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ortu_model');
    }

    public function index()
    {
        $data['list_ortu'] = $this->Ortu_model->get_all();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('ortu/index',$data);
        $this->load->view('template/footer');
    }

    public function tambah_ortu()
    {
        $this->form_validation->set_rules('ibu', 'ayah', 'required');
        if ($this->form_validation->run() !== FALSE) {
            $this->__simpan_ortu();
        } else {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('ortu/tambah_ortu');
            $this->load->view('template/footer');
        }
    }

    private function __simpan_ortu()
    {
        $data = [
            'name_ibu' => $this->input->post('ibu'),
            'name_ayah' => $this->input->post('ayah'),
            'hubungan' => $this->input->post('hubungan'),
            'telp' => $this->input->post('telp'),
            'alamat' => $this->input->post('alamat'),
            'create_at' => date('Y-m-d H:i:s')
        ];
        $simpan = $this->Ortu_model->tambah($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Berhasil di tambahkan
            </div>');
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="alert">
                Gagal di tambahkan
            </div>');
        }
        redirect('ortu');
    }

    public function hapus_ortu($id) {
        $ortu = $this->Ortu_model->get_by_id($id);
        if($ortu) {
            $hapus = $this->Ortu_model->hapus($id);
            if($hapus) {
                $this->session->set_flashdata('message', '
                <div class="alert alert-success" role="alert">
                Berhasil di hapus
                </div>');
            } else {
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                Gagal di hapus
                </div>');
            }
            redirect('ortu');
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="alert">
            Gagal di hapus
            </div>');
            redirect('ortu');
        }
    }

    public function ubah_ortu($id)
    {
        $ortu = $this->Ortu_model->get_by_id($id);
        if($ortu) {
            $this->form_validation->set_rules('ibu', 'ayah', 'required');
            if($this->form_validation->run() !== FALSE) {
                $this->__ubah_ortu($id);
            } else {
                $data['title'] = 'Ubah ortu';
                $data['ortu'] = $ortu;
                $this->load->view('template/header', $data);
                $this->load->view('template/sidebar');
                $this->load->view('ortu/ubah_ortu', $data);
                $this->load->view('template/footer');
            }
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-warning" role="alert">
                Data Ortu tidak ditemukan
            </div>');
            redirect('ortu');
        }
    }

    public function __ubah_ortu($id)
    {
        $data = [
            'name_ibu' => $this->input->post('ibu'),
            'name_ayah' => $this->input->post('ayah'),
            'hubungan' => $this->input->post('hubungan'),
            'telp' => $this->input->post('telp'),
            'alamat' => $this->input->post('alamat'),
            'create_at' => date('Y-m-d H:i:s')
        ];

        $ubah = $this->Ortu_model->ubah($data, $id);

        if($ubah) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Berhasil di ubah
            </div>
            ');
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="alert">
                Gagal di ubah
            </div>
            ');            
        }
        redirect('ortu');
    }
}
