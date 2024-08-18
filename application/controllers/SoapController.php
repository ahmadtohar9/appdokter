<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SoapController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Soap_model');
    }

    public function get_soap_data() {
        $no_rawat = $this->input->get('no_rawat');
        if (empty($no_rawat)) {
            echo json_encode([]);
            return;
        }

        $data = $this->Soap_model->get_soap_data($no_rawat);
        echo json_encode($data);
    }

    public function save_soap() {
        $data = $this->input->post();
        $full_no_rawat = $data['no_rawat'];
        $is_edit_mode = !empty($data['soap_id']);

        if ($is_edit_mode) {
            $result = $this->Soap_model->update_soap($data);
        } else {
            $result = $this->Soap_model->save_soap($data);
        }

        if ($result) {
            if (!$is_edit_mode) {
                $update_status = $this->Soap_model->update_status_reg_periksa($full_no_rawat, 'Sudah');
                if ($update_status) {
                    $message = ['status' => 'success', 'message' => 'Data berhasil disimpan dan status diperbarui'];
                } else {
                    $message = ['status' => 'warning', 'message' => 'Data berhasil disimpan, tetapi gagal memperbarui status'];
                }
            } else {
                $message = ['status' => 'success', 'message' => 'Data berhasil diperbarui'];
            }
        } else {
            $message = ['status' => 'error', 'message' => 'Gagal menyimpan data'];
        }

        echo json_encode($message);
    }

    public function delete_soap() {
        $no_rawat = $this->input->post('no_rawat');
        $nip = $this->input->post('nip');

        if (empty($no_rawat) || empty($nip)) {
            echo json_encode(['status' => 'error', 'message' => 'No Rawat atau NIP tidak ditemukan']);
            return;
        }

        $result = $this->Soap_model->delete_soap($no_rawat, $nip);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'SOAP berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menghapus SOAP'];
        }

        echo json_encode($response);
    }

    public function get_single_soap() {
        $no_rawat = $this->input->get('no_rawat');
        $tgl_perawatan = $this->input->get('tgl_perawatan');

        if (empty($no_rawat) || empty($tgl_perawatan)) {
            echo json_encode(['status' => 'error', 'message' => 'SOAP id tidak ditemukan']);
            return;
        }

        $soapData = $this->Soap_model->get_soap_by_no_rawat_and_tanggal($no_rawat, $tgl_perawatan);

        if ($soapData) {
            echo json_encode(['status' => 'success', 'data' => $soapData]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'SOAP id tidak ditemukan']);
        }
    }

    public function update_soap() 
    {
        $data = $this->input->post();

        // Cek apakah jam diubah oleh user
        if ($data['jam'] === substr($data['original_jam'], 0, 5)) {
            // Jika jam tidak diubah, tetap gunakan nilai asli dari database
            $data['jam'] = $data['original_jam'];
        } else {
            // Jika jam diubah, tambahkan ':00' jika hanya ada jam dan menit
            if (strlen($data['jam']) === 5) {
                $data['jam'] .= ':00';
            }
        }

        // Proses update data ke database
        $result = $this->Soap_model->update_soap($data);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data SOAP berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data SOAP']);
        }
    }


}
