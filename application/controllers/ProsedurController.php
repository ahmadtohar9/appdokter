<?php

class ProsedurController extends CI_Controller

{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Prosedur_model');
        date_default_timezone_set('Asia/Jakarta');
    }

   public function get_penyakit_prosedur() 
	{
	    $term = $this->input->get('term');
	    $query = $this->db->like('kode', $term)
	                      ->or_like('deskripsi_panjang', $term)
	                      ->limit(10)
	                      ->get('icd9');
	    $result = $query->result_array();
	    echo json_encode($result);
	}


    public function save_prosedur($no_rawat = null)
    {
        if ($no_rawat === null) {
            $no_rawat = $this->input->post('no_rawat');
        }

        if (!$no_rawat) {
            show_error('No Rawat tidak diberikan', 400);
            return;
        }

        $data = [
            'no_rawat' => $no_rawat,
            'kode' => $this->input->post('kode'),
            'prioritas' => $this->input->post('prioritas'),
            'status' => 'Ralan',
        ];

        $result = $this->Prosedur_model->save_prosedur($data);
        
        if ($result) {
            $response = ['status' => 'success', 'message' => 'Prosedur berhasil disimpan'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan prosedur'];
        }

        echo json_encode($response);
    }

    public function get_prosedur_data()
    {
        $no_rawat = $this->input->get('no_rawat');
        $prosedur_list = $this->Prosedur_model->get_prosedur_data($no_rawat);
        echo json_encode($prosedur_list);
    }

    public function delete_prosedur()
    {
        $no_rawat = $this->input->post('no_rawat');
        $kode = $this->input->post('kode');

        $result = $this->Prosedur_model->delete_prosedur($no_rawat, $kode);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Prosedur berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menghapus prosedur'];
        }

        echo json_encode($response);
    }



}