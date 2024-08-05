<?php

class LoginController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Dokter_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function login()
    {
        $kd_dokter = $this->input->post('kd_dokter');
        $password = md5($this->input->post('password'));

        $user = $this->Login_model->check_user($kd_dokter, $password);

        if ($user) {
            // Ambil nama dokter dari tabel dokter
            $dokter = $this->Dokter_model->get_dokter_by_kd($user->kd_dokter);

            $session_data = array(
                'kd_dokter' => $user->kd_dokter,
                'nama_dokter' => $dokter->nm_dokter,
                'level' => $user->level,
                'logged_in' => true
            );
            $this->session->set_userdata($session_data);
            redirect('DokterController/index');
        } else {
            $this->session->set_flashdata('error', 'Invalid credentials');
            redirect('LoginController/index');
        }
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function logout()
    {
        $this->session->unset_userdata(array('kd_dokter', 'level', 'logged_in'));
        $this->session->set_flashdata('message', 'Apakah Anda Ingin Keluar ?');
        redirect('LoginController/index');
    }
}
?>

?>