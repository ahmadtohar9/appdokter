<?php
class User_model extends CI_Model {

    public function validate_user($kd_dokter, $password) {
        $this->db->where('kd_dokter', $kd_dokter);
        $this->db->where('password', md5($password));
        $query = $this->db->get('tohar_users_login');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return false;
    }
}
?>
