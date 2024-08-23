<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedisDalamController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MedisDalam_model');
        $this->load->model('Dokter_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function AsesmentDokter_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        
        // Ambil detail pasien dengan no_rawat lengkap
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat;

        $this->load->view('template/header.php');
        $this->load->view('AwalMedisDokter/medis_PenyakitDalam.php', $data);
        $this->load->view('AwalMedisDokter/hasil_medisPenyakitDalam.php', $data);
        $this->load->view('template/footer.php');
    }

    public function save_asesmen() {
        $data = array(
            'no_rawat' => $this->input->post('no_rawat'),
            'kd_dokter' => $this->input->post('kd_dokter'),
            'tanggal' => $this->input->post('tanggal_jam'),
            'anamnesis' => $this->input->post('anamnesis') ?? 'autoanamnesis',
            'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
            'rpo' => $this->input->post('riwayat_penggunaan_obat') ?? NULL,
            'rps' => $this->input->post('riwayat_penyakit_sekarang') ?? NULL,
            'rpd' => $this->input->post('riwayat_penyakit_dahulu') ?? NULL,
            'alergi' => $this->input->post('riwayat_alergi') ?? NULL,
            'status' => $this->input->post('status_nutrisi') ?? NULL,
            'td' => $this->input->post('td') ?? NULL,
            'nadi' => $this->input->post('nadi') ?? NULL,
            'suhu' => $this->input->post('suhu') ?? NULL,
            'rr' => $this->input->post('rr') ?? NULL,
            'bb' => $this->input->post('bb') ?? NULL,
            'nyeri' => $this->input->post('nyeri') ?? NULL,
            'gcs' => $this->input->post('gcs') ?? NULL,
            'kondisi' => $this->input->post('kondisi_umum') ?? NULL,
            'kepala' => $this->input->post('kepala') ?? NULL,
            'keterangan_kepala' => $this->input->post('keterangan_kepala') ?? NULL,
            'thoraks' => $this->input->post('thoraks') ?? NULL,
            'keterangan_thorak' => $this->input->post('keterangan_thorak') ?? NULL,
            'abdomen' => $this->input->post('abdomen') ?? NULL,
            'keterangan_abdomen' => $this->input->post('keterangan_abdomen') ?? NULL,
            'ekstremitas' => $this->input->post('ekstremitas') ?? NULL,
            'keterangan_ekstremitas' => $this->input->post('keterangan_ekstremitas') ?? NULL,
            'lainnya' => $this->input->post('lainnya') ?? NULL,
            'lab' => $this->input->post('laboratorium') ?? NULL,
            'rad' => $this->input->post('radiologi') ?? NULL,
            'penunjanglain' => $this->input->post('penunjang_lainnya') ?? NULL,
            'diagnosis' => $this->input->post('diagnosis') ?? NULL,
            'diagnosis2' => $this->input->post('diagnosis2') ?? NULL,
            'permasalahan' => $this->input->post('permasalahan') ?? NULL,
            'terapi' => $this->input->post('terapi') ?? NULL,
            'tindakan' => $this->input->post('tindakan') ?? NULL,
            'edukasi' => $this->input->post('edukasi') ?? NULL,
        );

        $result = $this->MedisDalam_model->insert_asesmen($data);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Asesmen berhasil disimpan'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan asesmen'];
        }

        echo json_encode($response);
    }

    public function get_asesmen_data() {
        $no_rawat = $this->input->get('no_rawat');
        $asesmen_data = $this->MedisDalam_model->get_penilaian_medis_ralan_penyakit_dalam($no_rawat);
        
        if ($asesmen_data) {
            echo json_encode($asesmen_data);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function update_asesmen() {
    $no_rawat = $this->input->post('no_rawat');
    
    $data = array(
        'kd_dokter' => $this->input->post('kd_dokter'),
        'tanggal' => $this->input->post('tanggal_jam'),
        'anamnesis' => $this->input->post('anamnesis') ?? 'autoanamnesis',
        'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
        'rpo' => $this->input->post('riwayat_penggunaan_obat') ?? NULL,
        'rps' => $this->input->post('riwayat_penyakit_sekarang') ?? NULL,
        'rpd' => $this->input->post('riwayat_penyakit_dahulu') ?? NULL,
        'alergi' => $this->input->post('riwayat_alergi') ?? NULL,
        'status' => $this->input->post('status_nutrisi') ?? NULL,
        'td' => $this->input->post('td') ?? NULL,
        'nadi' => $this->input->post('nadi') ?? NULL,
        'suhu' => $this->input->post('suhu') ?? NULL,
        'rr' => $this->input->post('rr') ?? NULL,
        'bb' => $this->input->post('bb') ?? NULL,
        'nyeri' => $this->input->post('nyeri') ?? NULL,
        'gcs' => $this->input->post('gcs') ?? NULL,
        'kondisi' => $this->input->post('kondisi_umum') ?? NULL,
        'kepala' => $this->input->post('kepala') ?? NULL,
        'keterangan_kepala' => $this->input->post('keterangan_kepala') ?? NULL,
        'thoraks' => $this->input->post('thoraks') ?? NULL,
        'keterangan_thorak' => $this->input->post('keterangan_thorak') ?? NULL,
        'abdomen' => $this->input->post('abdomen') ?? NULL,
        'keterangan_abdomen' => $this->input->post('keterangan_abdomen') ?? NULL,
        'ekstremitas' => $this->input->post('ekstremitas') ?? NULL,
        'keterangan_ekstremitas' => $this->input->post('keterangan_ekstremitas') ?? NULL,
        'lainnya' => $this->input->post('lainnya') ?? NULL,
        'lab' => $this->input->post('laboratorium') ?? NULL,
        'rad' => $this->input->post('radiologi') ?? NULL,
        'penunjanglain' => $this->input->post('penunjang_lainnya') ?? NULL,
        'diagnosis' => $this->input->post('diagnosis') ?? NULL,
        'diagnosis2' => $this->input->post('diagnosis2') ?? NULL,
        'permasalahan' => $this->input->post('permasalahan') ?? NULL,
        'terapi' => $this->input->post('terapi') ?? NULL,
        'tindakan' => $this->input->post('tindakan') ?? NULL,
        'edukasi' => $this->input->post('edukasi') ?? NULL,
    );

    $result = $this->MedisDalam_model->update_asesmen($no_rawat, $data);

    if ($result) {
        $response = ['status' => 'success', 'message' => 'Asesmen berhasil diperbarui'];
    } else {
        $response = ['status' => 'error', 'message' => 'Gagal memperbarui asesmen'];
    }

    echo json_encode($response);
}


  public function delete_asesmen() 
      {
        $no_rawat = $this->input->post('no_rawat');
        $result = $this->MedisDalam_model->delete_asesmen($no_rawat);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus asesmen']);
        }
    }

}

