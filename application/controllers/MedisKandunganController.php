<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedisKandunganController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MedisKandungan_model');
        $this->load->model('Dokter_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function MedisKandungan_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        
        // Ambil detail pasien dengan no_rawat lengkap
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat;

        $this->load->view('template/header.php');
        $this->load->view('awalMedisDokter/MedisKandungan_form', $data);
        $this->load->view('awalMedisDokter/hasilMedisKandungan_view', $data);
        $this->load->view('template/footer.php');
    }

    public function save_asesmenMedisKandungan() {
        log_message('debug', 'save_asesmenMedisKandungan called');
        $data = array(
            'no_rawat' => $this->input->post('no_rawat'),
            'kd_dokter' => $this->input->post('kd_dokter'),
            'tanggal' => $this->input->post('tanggal_jam'),
            'anamnesis' => $this->input->post('anamnesis') ?? 'autoanamnesis',
            'hubungan' => $this->input->post('hubungan') ?? NULL,
            'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
            'rps' => $this->input->post('rps') ?? NULL,
            'rpd' => $this->input->post('rpd') ?? NULL,
            'rpk' => $this->input->post('rpk') ?? NULL,
            'rpo' => $this->input->post('rpo') ?? NULL,
            'alergi' => $this->input->post('alergi') ?? NULL,
            'keadaan' => $this->input->post('keadaan') ?? NULL,
            'gcs' => $this->input->post('gcs') ?? NULL,
            'kesadaran' => $this->input->post('kesadaran') ?? NULL,
            'td' => $this->input->post('td') ?? NULL,
            'nadi' => $this->input->post('nadi') ?? NULL,
            'rr' => $this->input->post('rr') ?? NULL,
            'suhu' => $this->input->post('suhu') ?? NULL,
            'spo' => $this->input->post('spo') ?? NULL,
            'bb' => $this->input->post('bb') ?? NULL,
            'tb' => $this->input->post('tb') ?? NULL,
            'kepala' => $this->input->post('kepala') ?? NULL,
            'mata' => $this->input->post('mata') ?? NULL,
            'gigi' => $this->input->post('gigi') ?? NULL,
            'tht' => $this->input->post('tht') ?? NULL,
            'thoraks' => $this->input->post('thoraks') ?? NULL,
            'abdomen' => $this->input->post('abdomen') ?? NULL,
            'genital' => $this->input->post('genital') ?? NULL,
            'ekstremitas' => $this->input->post('ekstremitas') ?? NULL,
            'kulit' => $this->input->post('kulit') ?? NULL,
            'ket_fisik' => $this->input->post('ket_fisik') ?? NULL,
            'tfu' => $this->input->post('tfu') ?? NULL,
            'tbj' => $this->input->post('tbj') ?? NULL,
            'his' => $this->input->post('his') ?? NULL,
            'kontraksi' => $this->input->post('kontraksi') ?? NULL,
            'djj' => $this->input->post('djj') ?? NULL,
            'inspeksi' => $this->input->post('inspeksi') ?? NULL,
            'inspekulo' => $this->input->post('inspekulo') ?? NULL,
            'vt' => $this->input->post('vt') ?? NULL,
            'rt' => $this->input->post('rt') ?? NULL,
            'ultra' => $this->input->post('ultra') ?? NULL,
            'kardio' => $this->input->post('kardio') ?? NULL,
            'lab' => $this->input->post('lab') ?? NULL,
            'diagnosis' => $this->input->post('diagnosis') ?? NULL,
            'tata' => $this->input->post('tata') ?? NULL,
            'konsul' => $this->input->post('konsul') ?? NULL,
        );

        $result = $this->MedisKandungan_model->insert_asesmenMedisKandungan($data);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Asesmen berhasil disimpan'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan asesmen'];
        }

        echo json_encode($response);
    }

    public function get_asesmenMedisKandungan_data() {
        $no_rawat = $this->input->get('no_rawat');
        $asesmen_data = $this->MedisKandungan_model->get_asesmenMedisKandungan_by_no_rawat($no_rawat);
        
        if ($asesmen_data) {
            echo json_encode($asesmen_data);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function update_asesmenMedisKandungan() {
        $no_rawat = $this->input->post('no_rawat');
        $data = array(
            'kd_dokter' => $this->input->post('kd_dokter'),
            'tanggal' => $this->input->post('tanggal_jam'),
            'anamnesis' => $this->input->post('anamnesis') ?? 'autoanamnesis',
            'hubungan' => $this->input->post('hubungan') ?? NULL,
            'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
            'rps' => $this->input->post('rps') ?? NULL,
            'rpd' => $this->input->post('rpd') ?? NULL,
            'rpk' => $this->input->post('rpk') ?? NULL,
            'rpo' => $this->input->post('rpo') ?? NULL,
            'alergi' => $this->input->post('alergi') ?? NULL,
            'keadaan' => $this->input->post('keadaan') ?? NULL,
            'gcs' => $this->input->post('gcs') ?? NULL,
            'kesadaran' => $this->input->post('kesadaran') ?? NULL,
            'td' => $this->input->post('td') ?? NULL,
            'nadi' => $this->input->post('nadi') ?? NULL,
            'rr' => $this->input->post('rr') ?? NULL,
            'suhu' => $this->input->post('suhu') ?? NULL,
            'spo' => $this->input->post('spo') ?? NULL,
            'bb' => $this->input->post('bb') ?? NULL,
            'tb' => $this->input->post('tb') ?? NULL,
            'kepala' => $this->input->post('kepala') ?? NULL,
            'mata' => $this->input->post('mata') ?? NULL,
            'gigi' => $this->input->post('gigi') ?? NULL,
            'tht' => $this->input->post('tht') ?? NULL,
            'thoraks' => $this->input->post('thoraks') ?? NULL,
            'abdomen' => $this->input->post('abdomen') ?? NULL,
            'genital' => $this->input->post('genital') ?? NULL,
            'ekstremitas' => $this->input->post('ekstremitas') ?? NULL,
            'kulit' => $this->input->post('kulit') ?? NULL,
            'ket_fisik' => $this->input->post('ket_fisik') ?? NULL,
            'tfu' => $this->input->post('tfu') ?? NULL,
            'tbj' => $this->input->post('tbj') ?? NULL,
            'his' => $this->input->post('his') ?? NULL,
            'kontraksi' => $this->input->post('kontraksi') ?? NULL,
            'djj' => $this->input->post('djj') ?? NULL,
            'inspeksi' => $this->input->post('inspeksi') ?? NULL,
            'inspekulo' => $this->input->post('inspekulo') ?? NULL,
            'vt' => $this->input->post('vt') ?? NULL,
            'rt' => $this->input->post('rt') ?? NULL,
            'ultra' => $this->input->post('ultra') ?? NULL,
            'kardio' => $this->input->post('kardio') ?? NULL,
            'lab' => $this->input->post('lab') ?? NULL,
            'diagnosis' => $this->input->post('diagnosis') ?? NULL,
            'tata' => $this->input->post('tata') ?? NULL,
            'konsul' => $this->input->post('konsul') ?? NULL,
        );

        $result = $this->MedisKandungan_model->update_asesmenMedisKandungan($no_rawat, $data);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui asesmen']);
        }
    }

    public function delete_asesmenMedisKandungan() {
        $no_rawat = $this->input->post('no_rawat');
        $result = $this->MedisKandungan_model->delete_asesmenMedisKandungan($no_rawat);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus asesmen']);
        }
    }
}
