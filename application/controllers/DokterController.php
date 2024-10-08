<?php

class DokterController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dokter_model');
        $this->load->model('RegPeriksa_model');
        $this->load->model('Resep_model');
        $this->load->model('Soap_model');
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

    public function dokterRajal_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['soap_data_list'] = $this->Soap_model->get_soap_data($full_no_rawat);
        $data['soap_detail'] = $this->Soap_model->get_single_soap($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat; // Pastikan ini ditambahkan

        $this->load->view('template/header.php');
        $this->load->view('rekammedis/form_soap.php', $data);
        $this->load->view('rekammedis/rincian_riwayat.php', $data);
        $this->load->view('rekammedis/form_diagnosa.php', $data);
        $this->load->view('rekammedis/resep.php', $data);
        $this->load->view('rekammedis/tindakan_ralan_dokter.php', $data);
        $this->load->view('rekammedis/permintaan_radiologi.php', $data);
        $this->load->view('rekammedis/permintaan_laboratorium.php', $data);
        $this->load->view('template/footer.php');
    }

    public function diagnosaProsedur_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat; // Pastikan ini ditambahkan

        $this->load->view('template/header.php');
        $this->load->view('rekammedis/form_diagnosa.php', $data);
        $this->load->view('template/footer.php');
    }

    public function permintaanLaboratorium_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['soap_data_list'] = $this->Soap_model->get_soap_data($full_no_rawat);
        $data['soap_detail'] = $this->Soap_model->get_single_soap($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat; // Pastikan ini ditambahkan

        $this->load->view('template/header.php');
        $this->load->view('rekammedis/permintaan_laboratorium.php', $data);
        $this->load->view('template/footer.php');
    }

    public function permintaanRadiologi_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['soap_data_list'] = $this->Soap_model->get_soap_data($full_no_rawat);
        $data['soap_detail'] = $this->Soap_model->get_single_soap($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat; // Pastikan ini ditambahkan

        $this->load->view('template/header.php');
        $this->load->view('rekammedis/permintaan_radiologi.php', $data);
        $this->load->view('template/footer.php');
    }


    //Ujicoba panggil setiap form
    public function load_rekam_medis($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['soap_data_list'] = $this->Soap_model->get_soap_data($full_no_rawat);
        $data['soap_detail'] = $this->Soap_model->get_single_soap($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat;

        // Memanggil header
        $this->load->view('template/header.php');
        $this->load->view('rekammedis/form_soap', $data);
        $this->load->view('rekammedis/rincian_riwayat', $data);

        // Memanggil footer
        $this->load->view('template/footer.php');
    }



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
            $no_rawat = $this->input->post('no_rawat');
        }

        if (!$no_rawat) {
            show_error('No Rawat tidak diberikan', 400);
            return;
        }

        $data = [
            'no_rawat' => $no_rawat,
            'kd_penyakit' => $this->input->post('kd_penyakit'),
            'prioritas' => $this->input->post('prioritas'),
            'status' => 'Ralan',
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
        $query = $this->db->select('databarang.kode_brng, databarang.nama_brng, gudangbarang.stok, databarang.ralan AS harga_obat')
                          ->from('gudangbarang')
                          ->join('databarang', 'gudangbarang.kode_brng = databarang.kode_brng')
                          ->where('gudangbarang.kd_bangsal', 'AP')
                          ->like('databarang.nama_brng', $term)
                          ->where('gudangbarang.stok >', 0)
                          ->limit(10)
                          ->get();
        $result = $query->result_array();

        // Pastikan mengembalikan data dalam bentuk JSON
        echo json_encode($result);
    }


    public function save_resep()
    {
        $data = $this->input->post();

        if (!isset($data['no_rawat']) || !isset($data['kd_dokter'])) {
            $response = ['status' => 'error', 'message' => 'Data no_rawat atau kd_dokter tidak ditemukan'];
            echo json_encode($response);
            return;
        }

        // Logika untuk memeriksa apakah resep dokter sudah ada atau belum
        $existing_resep = $this->Dokter_model->get_existing_resep($data['no_rawat'], $data['kd_dokter']);
        if ($existing_resep) {
            $no_resep = $existing_resep->no_resep;
        } else {
            $no_resep = $this->Dokter_model->create_resep_dokter($data);
        }

        // Cek apakah obat dengan kode barang yang sama sudah ada
        $is_obat_exist = $this->Dokter_model->check_existing_obat($no_resep, $data['kode_brng']);
        if ($is_obat_exist) {
            $response = ['status' => 'error', 'message' => 'Obat dengan kode barang yang sama sudah ada di resep ini'];
            echo json_encode($response);
            return;
        }

        $result = $this->Dokter_model->save_resep_obat($no_resep, $data);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Resep berhasil ditambahkan'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menambahkan resep'];
        }

        echo json_encode($response);
    }

    public function get_resep_data()
    {
        $no_rawat = $this->input->get('no_rawat');
        $resep_list = $this->Resep_model->get_resep_data($no_rawat);
        echo json_encode($resep_list);
    }

    public function delete_resep()
    {
        $no_resep = $this->input->post('no_resep');
        $kode_brng = $this->input->post('kode_brng');

        $result = $this->Resep_model->delete_resep($no_resep, $kode_brng);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Resep berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menghapus resep'];
        }

        echo json_encode($response);
    }


   public function save_resep_batch() 
    {
        $data = $this->input->post();

        if (!isset($data['no_rawat']) || !isset($data['kd_dokter'])) {
            $response = ['status' => 'error', 'message' => 'Data no_rawat atau kd_dokter tidak ditemukan'];
            echo json_encode($response);
            return;
        }

        // Logika untuk memeriksa apakah resep dokter sudah ada atau belum
        $existing_resep = $this->Dokter_model->get_existing_resep($data['no_rawat'], $data['kd_dokter']);
        if ($existing_resep) {
            $no_resep = $existing_resep->no_resep;
        } else {
            $no_resep = $this->Dokter_model->create_resep_dokter($data);
        }

        $duplicate_obat = false;
        $overstock_obat = false;
        $overstock_messages = [];
        $success_insert = false;

        // Implementasikan logika penyimpanan batch untuk data resep
        foreach ($data['kode_brng'] as $index => $kode) {
            // Dapatkan stok barang dari database
            $barang = $this->Dokter_model->get_barang_by_kode($kode);
            $jumlah = $data['jml'][$index];

            if ($jumlah > $barang->stok) {
                // Jika jumlah lebih besar dari stok
                $overstock_obat = true;
                $overstock_messages[] = "Jumlah untuk obat {$barang->nama_brng} melebihi stok yang tersedia ({$barang->stok}).";
                continue;
            }

            // Cek apakah obat dengan kode barang yang sama sudah ada di resep
            $is_obat_exist = $this->Dokter_model->check_existing_obat($no_resep, $kode);
            if ($is_obat_exist) {
                $duplicate_obat = true;
                continue; // Abaikan obat yang sudah ada dan lanjutkan ke iterasi berikutnya
            }

            $obat_data = [
                'no_resep' => $no_resep,
                'kode_brng' => $kode,
                'jml' => $jumlah,
                'aturan_pakai' => $data['aturan_pakai'][$index],
                // tambahkan field lainnya jika diperlukan
            ];
            $this->db->insert('resep_dokter', $obat_data);
            $success_insert = true;
        }

        if ($overstock_obat) {
            $response = ['status' => 'error', 'message' => implode(' ', $overstock_messages)];
        } elseif ($duplicate_obat) {
            if ($success_insert) {
                $response = ['status' => 'warning', 'message' => 'Beberapa obat tidak ditambahkan karena sudah ada dalam resep, namun beberapa obat lain berhasil ditambahkan.'];
            } else {
                $response = ['status' => 'warning', 'message' => 'Beberapa obat tidak ditambahkan karena sudah ada dalam resep.'];
            }
        } else {
            $response = ['status' => 'success', 'message' => 'Resep berhasil ditambahkan'];
        }

        // Kembalikan response
        echo json_encode($response);
    }


}
?>
