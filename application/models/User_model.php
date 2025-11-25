<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login($email, $password)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            $row = $query->row();

            if (md5($password) === $row->password) {
                return $row;
            } else {
                return false;
            }
        }
        return false;
    }
}