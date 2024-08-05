<?php

class DokterController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dokter_model');
        $this->load->model('RegPeriksa_model');
        date_default_timezone_set('Asia/Jakarta');
    }

     public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('LoginController/index');
        }

        $kd_dokter = $this->session->userdata('kd_dokter');
        $data['reg_periksa'] = $this->RegPeriksa_model->get_data_by_dokter($kd_dokter);
        $data['dropdown_options'] = $this->RegPeriksa_model->get_dropdown_options();
        $this->load->view('template/header.php');
        $this->load->view('dokter/index', $data);
        $this->load->view('template/footer.php');
    }

    public function get_new_data()
    {
        $kd_dokter = $this->session->userdata('kd_dokter');
        $reg_periksa = $this->RegPeriksa_model->get_data_by_dokter($kd_dokter);
        echo json_encode($reg_periksa);
    }

    public function get_soap_data() 
    {
        $no_rawat = $this->input->get('no_rawat');
        if (empty($no_rawat)) {
            echo json_encode([]);
            return;
        }

        $data = $this->Dokter_model->get_soap_data($no_rawat);
        echo json_encode($data);
    }




    public function soap_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['soap_data_list'] = $this->Dokter_model->get_soap_data($full_no_rawat);
        $data['soap_detail'] = $this->Dokter_model->get_soap_detail($full_no_rawat);

        $this->load->view('template/header.php');
        $this->load->view('dokter/soap_form.php', $data);
        $this->load->view('template/footer.php');
    }




   public function save_soap()
    {
        $data = $this->input->post();
        $full_no_rawat = $data['no_rawat'];
        $is_edit_mode = $data['mode'] === 'edit';

        if ($is_edit_mode) {
            // Update existing SOAP data
            $result = $this->Dokter_model->update_soap($data);
        } else {
            // Insert new SOAP data
            $result = $this->Dokter_model->save_soap($data);
        }

        if ($result) {
            if (!$is_edit_mode) {
                // Update reg_periksa status only for new entries
                $update_status = $this->Dokter_model->update_status_reg_periksa($full_no_rawat, 'Sudah');
                if ($update_status) {
                    $message = ['status' => 'success', 'message' => 'Data berhasil disimpan dan status diperbarui'];
                } else {
                    $message = ['status' => 'error', 'message' => 'Data berhasil disimpan, tetapi gagal memperbarui status'];
                }
            } else {
                $message = ['status' => 'success', 'message' => 'Data berhasil diperbarui'];
            }
        } else {
            $message = ['status' => 'error', 'message' => 'Gagal menyimpan data'];
        }

        echo json_encode($message);
    }

    public function delete_soap()
    {
        $no_rawat = $this->input->post('no_rawat');
        $nip = $this->input->post('nip');

        $result = $this->Dokter_model->delete_soap($no_rawat, $nip);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'SOAP berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menghapus SOAP'];
        }

        echo json_encode($response);
    }


    // public function delete_soap($tahun, $bulan, $tanggal, $no_rawat)
    // {
    //     $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";

    //     if ($this->Dokter_model->delete_soap($full_no_rawat)) {
    //         $this->session->set_flashdata('message', 'Data berhasil dihapus.');
    //     } else {
    //         $this->session->set_flashdata('error', 'Gagal menghapus data.');
    //     }

    //     redirect('DokterController/index');

    //     // redirect('DokterController/soap_form/' . $full_no_rawat);
    // }


    public function get_penyakit() 
    {
        $term = $this->input->get('term');
        $query = $this->db->like('kd_penyakit', $term)
                          ->or_like('nm_penyakit', $term)
                          ->limit(10)
                          ->get('penyakit');
        $result = $query->result_array();
        echo json_encode($result);
    }

    public function save_diagnosa($no_rawat = null)
        {
            if ($no_rawat === null) {
                // Mengambil no_rawat dari input jika tidak disediakan sebagai argumen
                $no_rawat = $this->input->post('no_rawat');
            }

            if (!$no_rawat) {
                show_error('No Rawat tidak diberikan', 400);
                return;
            }

            $no_rawat = $this->input->post('no_rawat');
            $kd_penyakit = $this->input->post('kd_penyakit');
            $prioritas = $this->input->post('prioritas');
            $status = 'Ralan'; // Atau ambil dari data lain sesuai kebutuhan

            $data = [
                'no_rawat' => $no_rawat,
                'kd_penyakit' => $this->input->post('kd_penyakit'),
                'prioritas' => $this->input->post('prioritas'),
                'status' => $status,
            ];

            $result = $this->Dokter_model->save_diagnosa($data);
            
            if ($result) {
                $response = ['status' => 'success', 'message' => 'Diagnosa berhasil disimpan'];
            } else {
                $response = ['status' => 'error', 'message' => 'Gagal menyimpan diagnosa'];
            }

            echo json_encode($response);
        }

   
   public function get_diagnosa_data()
    {
        $no_rawat = $this->input->get('no_rawat');
        $diagnosa_list = $this->Dokter_model->get_diagnosa_data($no_rawat);
        echo json_encode($diagnosa_list);
    }

    public function delete_diagnosa()
    {
        $no_rawat = $this->input->post('no_rawat');
        $kd_penyakit = $this->input->post('kd_penyakit');

        $result = $this->Dokter_model->delete_diagnosa($no_rawat, $kd_penyakit);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Diagnosa berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menghapus diagnosa'];
        }

        echo json_encode($response);
    }

    public function get_DataBarang()
    {
        $term = $this->input->get('term');
        $query = $this->db->like('kode_brng', $term)
                          ->or_like('nama_brng', $term)
                          ->limit(10)
                          ->get('databarang');
        $result = $query->result_array();

        // Pastikan mengembalikan data dalam bentuk JSON
        echo json_encode($result);
    }

}
?>
