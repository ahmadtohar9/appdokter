<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaboratoriumController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Laboratorium_model'); // Pastikan model diload di sini
    }

    public function get_hasil_lab()
    {
        $no_rawat = $this->input->get('no_rawat', true);
        if (empty($no_rawat)) {
            echo json_encode([]);
            return;
        }

        $hasil_lab = $this->Laboratorium_model->get_hasil_lab($no_rawat);
        echo json_encode($hasil_lab);
    }

    // Fungsi untuk mendapatkan daftar tes laboratorium
    public function get_lab_tests() {
        $limit = $this->input->get('limit', true);
        $lab_tests = $this->Laboratorium_model->get_lab_tests($limit);
        echo json_encode($lab_tests);
    }

    // Fungsi untuk mencari tes laboratorium
    public function search_lab_tests() {
        $query = $this->input->get('query', true);
        $lab_tests = $this->Laboratorium_model->search_lab_tests($query);
        echo json_encode($lab_tests);
    }

    // Fungsi untuk mendapatkan detail tes laboratorium berdasarkan kode jenis perawatan
    public function get_lab_details() {
        $kd_jenis_prw = $this->input->get('kd_jenis_prw');
        $details = $this->Laboratorium_model->get_lab_details($kd_jenis_prw);
        echo json_encode($details);
    }

    // Fungsi untuk menyimpan permintaan laboratorium
    public function save_lab_order() 
    {
        $data = [
            'noorder' => $this->generateOrderNumber(),
            'no_rawat' => $this->input->post('no_rawat'),
            'dokter_perujuk' => $this->input->post('kd_dokter'),
            'tgl_permintaan' => $this->input->post('tgl_permintaan'),
            'jam_permintaan' => $this->input->post('jam_permintaan'),
            'tgl_hasil' => '0000-00-00',
            'jam_hasil' => '00:00:00',
            'status' => 'ralan',
            'informasi_tambahan' => $this->input->post('informasi_tambahan'),
            'diagnosa_klinis' => $this->input->post('diagnosa_klinis')
        ];

        $result = $this->Laboratorium_model->insert_lab_order($data);

        if ($result) {
            // Simpan data pemeriksaan laboratorium yang dipilih
            $lab_orders = $this->input->post('lab_orders');
            foreach ($lab_orders as $kd_jenis_prw) {
                $this->Laboratorium_model->insert_lab_order_detail([
                    'noorder' => $data['noorder'],
                    'kd_jenis_prw' => $kd_jenis_prw,
                    'stts_bayar' => 'Belum'
                ]);
            }

            // Simpan detail pemeriksaan laboratorium yang dipilih
            $lab_details = $this->input->post('lab_details');
            foreach ($lab_details as $detail) {
                $this->Laboratorium_model->insert_lab_order_detail_template([
                    'noorder' => $data['noorder'],
                    'kd_jenis_prw' => $detail['kd_jenis_prw'],
                    'id_template' => $detail['id_template'],
                    'stts_bayar' => 'Belum'
                ]);
            }

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // Fungsi untuk menghasilkan nomor order unik
    private function generateOrderNumber() {
        $currentDate = date('Ymd');
        $lastOrder = $this->Laboratorium_model->get_last_order_number($currentDate);
        if ($lastOrder) {
            $lastOrderNumber = (int)substr($lastOrder['noorder'], -4);
            $newOrderNumber = $lastOrderNumber + 1;
        } else {
            $newOrderNumber = 1;
        }
        return 'PK' . $currentDate . sprintf('%04d', $newOrderNumber);
    }

    public function delete_hasil_lab()
    {
        $no_rawat = $this->input->post('no_rawat', true);
        $no_order = $this->input->post('no_order', true);

        if (empty($no_rawat) || empty($no_order)) {
            echo json_encode(['status' => 'error', 'message' => 'No Rawat dan No Order harus diisi.']);
            return;
        }

        $delete_result = $this->Laboratorium_model->delete_hasil_lab($no_rawat, $no_order);

        if ($delete_result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus hasil lab.']);
        }
    }

}
