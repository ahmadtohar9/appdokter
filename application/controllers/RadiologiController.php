<?php

class RadiologiController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Radiologi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    private function generate_no_order()
    {
        $this->db->select('MAX(noorder) as last_order');
        $this->db->like('noorder', 'PR' . date('Ymd'));
        $query = $this->db->get('permintaan_radiologi');
        $last_order = $query->row()->last_order;

        if ($last_order) {
            $last_number = (int) substr($last_order, -4);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }

        return 'PR' . date('Ymd') . sprintf('%04d', $new_number);
    }


    public function get_permintaan_radiologi()
    {
        $no_rawat = $this->input->get('no_rawat');
        $tindakanRadiologi_list = $this->Radiologi_model->get_permintaan_radiologi($no_rawat);
        echo json_encode($tindakanRadiologi_list);
    }

    public function get_DataTindakanRadiologi() 
    {
        $term = $this->input->get('term');
        $this->db->select('kd_jenis_prw, nm_perawatan, total_byr');
        $this->db->like('kd_jenis_prw', $term);
        $this->db->or_like('nm_perawatan', $term);
        $this->db->limit(10);
        $query = $this->db->get('jns_perawatan_radiologi');
        $result = $query->result_array();
        echo json_encode($result);
    }


    public function delete_permintaanRadiologi()
    {
        $noorder = $this->input->post('no_order');
        $no_rawat = $this->input->post('no_rawat');
        
        // Hapus dari permintaan_pemeriksaan_radiologi terlebih dahulu
        $this->db->where('noorder', $noorder);
        $this->db->where('no_rawat', $no_rawat);
        $this->db->delete('permintaan_radiologi');
        
        // Lalu hapus dari permintaan_radiologi
        $result = $this->Radiologi_model->delete_tindakan($noorder);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Permintaan Radiologi berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menghapus Permintaan Radiologi'];
        }
        echo json_encode($response);
    }


    public function save_permintaan_radiologi() 
    {
        $noorder = $this->generate_no_order(); // Menghasilkan noorder otomatis
        
        // Data untuk tabel permintaan_radiologi
        $data_permintaan_radiologi = array(
            'noorder'           => $noorder,
            'no_rawat'          => $this->input->post('no_rawat'),
            'dokter_perujuk'    => $this->input->post('kd_dokter'),
            'tgl_permintaan'    => $this->input->post('tgl_permintaan'),
            'jam_permintaan'    => $this->input->post('jam_permintaan'),
            'tgl_hasil'         => '0000:00:00',
            'jam_hasil'         => '00:00:00',
            'status'            => 'ralan',
            'informasi_tambahan'=> $this->input->post('informasi_tambahan'),
            'diagnosa_klinis'   => $this->input->post('diagnosa_klinis')
        );

        // Data untuk tabel permintaan_pemeriksaan_radiologi
        $data_permintaan_pemeriksaan = array(
            'noorder'           => $noorder,
            'kd_jenis_prw'      => $this->input->post('kd_jenis_prw'),
            'stts_bayar'        => 'Belum'
        );

        $result_radiologi = $this->Radiologi_model->save_tindakan($data_permintaan_radiologi);
        $result_pemeriksaan = $this->Radiologi_model->save_permintaan_radiologi($data_permintaan_pemeriksaan);

        if ($result_radiologi && $result_pemeriksaan) {
            $response = ['status' => 'success', 'message' => 'Permintaan Radiologi berhasil disimpan', 'noorder' => $noorder];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan Permintaan Radiologi'];
        }
        echo json_encode($response);
    }


}
