<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedisMataController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MedisMata_model');
        $this->load->model('Dokter_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function MedisMata_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        
        // Ambil detail pasien dengan no_rawat lengkap
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat;

        $this->load->view('template/header.php');
        $this->load->view('awalMedisDokter/MedisMata_form', $data);
        $this->load->view('awalMedisDokter/hasilMedisMata_view', $data);
        $this->load->view('template/footer.php');
    }

    public function save_asesmenMedisMata() {
        log_message('debug', 'save_asesmenMedisMata called');
        $data = array(
            'no_rawat' => $this->input->post('no_rawat'),
            'kd_dokter' => $this->input->post('kd_dokter'),
            'tanggal' => $this->input->post('tanggal_jam'),
            'informasi' => $this->input->post('informasi') ?? 'autoanamnesis',
            'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
            'rpd' => $this->input->post('rpd') ?? NULL,
            'rpk' => $this->input->post('rpk') ?? NULL,
            'rpo' => $this->input->post('rpo') ?? NULL,
            'alergi' => $this->input->post('alergi') ?? NULL,
            'td' => $this->input->post('td') ?? NULL,
            'nadi' => $this->input->post('nadi') ?? NULL,
            'rr' => $this->input->post('rr') ?? NULL,
            'suhu' => $this->input->post('suhu') ?? NULL,
            'bb' => $this->input->post('bb') ?? NULL,
            'tb' => $this->input->post('tb') ?? NULL,
            'bmi' => $this->input->post('bmi') ?? NULL,
            'status_nutrisi' => $this->input->post('status_nutrisi') ?? NULL,
            'nyeri' => $this->input->post('nyeri') ?? NULL,
            'visuskanan' => $this->input->post('visuskanan') ?? NULL,
            'visuskiri' => $this->input->post('visuskiri') ?? NULL,
            'refraksikanan' => $this->input->post('refraksikanan') ?? NULL,
            'refraksikiri' => $this->input->post('refraksikiri') ?? NULL,
            'tiokanan' => $this->input->post('tiokanan') ?? NULL,
            'tiokiri' => $this->input->post('tiokiri') ?? NULL,
            'palberakanan' => $this->input->post('palberakanan') ?? NULL,
            'palberakiri' => $this->input->post('palberakiri') ?? NULL,
            'konjungtivakanan' => $this->input->post('konjungtivakanan') ?? NULL,
            'konjungtivakiri' => $this->input->post('konjungtivakiri') ?? NULL,
            'sklerakanan' => $this->input->post('sklerakanan') ?? NULL,
            'sklerakiri' => $this->input->post('sklerakiri') ?? NULL,
            'korneakanan' => $this->input->post('korneakanan') ?? NULL,
            'korneakiri' => $this->input->post('korneakiri') ?? NULL,
            'bmdkanan' => $this->input->post('bmdkanan') ?? NULL,
            'bmdkiri' => $this->input->post('bmdkiri') ?? NULL,
            'irisakanan' => $this->input->post('irisakanan') ?? NULL,
            'irisakiri' => $this->input->post('irisakiri') ?? NULL,
            'pupilkanan' => $this->input->post('pupilkanan') ?? NULL,
            'pupilkiri' => $this->input->post('pupilkiri') ?? NULL,
            'lensakanan' => $this->input->post('lensakanan') ?? NULL,
            'lensakiri' => $this->input->post('lensakiri') ?? NULL,
            'oftalmoskopikanan' => $this->input->post('oftalmoskopikanan') ?? NULL,
            'oftalmoskopikiri' => $this->input->post('oftalmoskopikiri') ?? NULL,
            'rencana' => $this->input->post('rencana') ?? NULL,
        );

        $result = $this->MedisMata_model->insert_asesmenMedisMata($data);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Asesmen berhasil disimpan'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan asesmen'];
        }

        echo json_encode($response);
    }

    public function get_asesmenMedisMata_data() {
        $no_rawat = $this->input->get('no_rawat');
        $asesmen_data = $this->MedisMata_model->get_asesmenMedisMata_by_no_rawat($no_rawat);
        
        if ($asesmen_data) {
            echo json_encode($asesmen_data);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function update_asesmenMedisMata() {
        $no_rawat = $this->input->post('no_rawat');
        $data = array(
            'kd_dokter' => $this->input->post('kd_dokter'),
            'tanggal' => $this->input->post('tanggal_jam'),
            'informasi' => $this->input->post('informasi') ?? 'autoanamnesis',
            'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
            'rpd' => $this->input->post('rpd') ?? NULL,
            'rpk' => $this->input->post('rpk') ?? NULL,
            'rpo' => $this->input->post('rpo') ?? NULL,
            'alergi' => $this->input->post('alergi') ?? NULL,
            'td' => $this->input->post('td') ?? NULL,
            'nadi' => $this->input->post('nadi') ?? NULL,
            'rr' => $this->input->post('rr') ?? NULL,
            'suhu' => $this->input->post('suhu') ?? NULL,
            'bb' => $this->input->post('bb') ?? NULL,
            'tb' => $this->input->post('tb') ?? NULL,
            'bmi' => $this->input->post('bmi') ?? NULL,
            'status_nutrisi' => $this->input->post('status_nutrisi') ?? NULL,
            'nyeri' => $this->input->post('nyeri') ?? NULL,
            'visuskanan' => $this->input->post('visuskanan') ?? NULL,
            'visuskiri' => $this->input->post('visuskiri') ?? NULL,
            'refraksikanan' => $this->input->post('refraksikanan') ?? NULL,
            'refraksikiri' => $this->input->post('refraksikiri') ?? NULL,
            'tiokanan' => $this->input->post('tiokanan') ?? NULL,
            'tiokiri' => $this->input->post('tiokiri') ?? NULL,
            'palberakanan' => $this->input->post('palberakanan') ?? NULL,
            'palberakiri' => $this->input->post('palberakiri') ?? NULL,
            'konjungtivakanan' => $this->input->post('konjungtivakanan') ?? NULL,
            'konjungtivakiri' => $this->input->post('konjungtivakiri') ?? NULL,
            'sklerakanan' => $this->input->post('sklerakanan') ?? NULL,
            'sklerakiri' => $this->input->post('sklerakiri') ?? NULL,
            'korneakanan' => $this->input->post('korneakanan') ?? NULL,
            'korneakiri' => $this->input->post('korneakiri') ?? NULL,
            'bmdkanan' => $this->input->post('bmdkanan') ?? NULL,
            'bmdkiri' => $this->input->post('bmdkiri') ?? NULL,
            'irisakanan' => $this->input->post('irisakanan') ?? NULL,
            'irisakiri' => $this->input->post('irisakiri') ?? NULL,
            'pupilkanan' => $this->input->post('pupilkanan') ?? NULL,
            'pupilkiri' => $this->input->post('pupilkiri') ?? NULL,
            'lensakanan' => $this->input->post('lensakanan') ?? NULL,
            'lensakiri' => $this->input->post('lensakiri') ?? NULL,
            'oftalmoskopikanan' => $this->input->post('oftalmoskopikanan') ?? NULL,
            'oftalmoskopikiri' => $this->input->post('oftalmoskopikiri') ?? NULL,
            'rencana' => $this->input->post('rencana') ?? NULL,
        );

        $result = $this->MedisMata_model->update_asesmenMedisMata($no_rawat, $data);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui asesmen']);
        }
    }

    public function delete_asesmenMedisMata() {
        $no_rawat = $this->input->post('no_rawat');
        $result = $this->MedisMata_model->delete_asesmenMedisMata($no_rawat);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus asesmen']);
        }
    }
}
