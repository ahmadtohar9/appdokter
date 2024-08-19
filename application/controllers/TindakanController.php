<?php

class TindakanController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tindakan_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function get_tindakan_ralan()
    {
        $no_rawat = $this->input->get('no_rawat');
        $tindakan_list = $this->Tindakan_model->get_tindakan_data($no_rawat);
        echo json_encode($tindakan_list);
    }

    public function get_DataTindakan() 
    {
        $term = $this->input->get('term');
        $query = $this->db->like('kd_jenis_prw', $term)
                          ->or_like('nm_perawatan', $term)
                          ->where('total_byrdr !=', 0) // Tambahkan kondisi ini
                          ->limit(10)
                          ->get('jns_perawatan');
        $result = $query->result_array();
        echo json_encode($result);
    }


    public function delete_tindakan()
    {
        $no_rawat = $this->input->post('no_rawat');
        $kd_jenis_perawatan = $this->input->post('kd_jenis_prw');
        $jam_rawat = $this->input->post('jam_rawat');

        $result = $this->Tindakan_model->delete_tindakan($no_rawat, $kd_jenis_perawatan, $jam_rawat);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Tindakan berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menghapus tindakan'];
        }
        echo json_encode($response);
    }


    public function save_tindakan_ralan() {
    $no_rawat = $this->input->post('no_rawat');
    $kd_dokter = $this->input->post('kd_dokter');
    $kd_jenis_prw = $this->input->post('kd_jenis_prw');
    $material = $this->input->post('material');
    $bhp = $this->input->post('bhp');
    $tarif_tindakandr = $this->input->post('tarif_tindakandr');
    $kso = $this->input->post('kso');
    $menejemen = $this->input->post('menejemen');
    $total_byrdr = $this->input->post('total_byrdr');

    if ($kd_jenis_prw && $no_rawat && $kd_dokter) {
        $data = array(
            'no_rawat' => $no_rawat,
            'kd_jenis_prw' => $kd_jenis_prw,
            'kd_dokter' => $kd_dokter,
            'tgl_perawatan' => date('Y-m-d'),
            'jam_rawat' => date('H:i:s'),
            'material' => $material,
            'bhp' => $bhp,
            'tarif_tindakandr' => $tarif_tindakandr,
            'kso' => $kso,
            'menejemen' => $menejemen,
            'biaya_rawat' => $total_byrdr,
            'stts_bayar' => 'Sudah'
        );

        $this->db->insert('rawat_jl_dr', $data);

        $response = array('status' => 'success');
    } else {
        $response = array('status' => 'error', 'message' => 'Data kd_jenis_prw tidak ditemukan atau tidak valid');
    }

    echo json_encode($response);
}



}


