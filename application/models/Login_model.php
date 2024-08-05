<?php
class Login_model extends CI_Model {

    public function check_user($kd_dokter, $password)
    {
        $this->db->where('kd_dokter', $kd_dokter);
        $this->db->where('password', $password);
        $query = $this->db->get('tohar_users_login');
        return $query->row();
    }
}
