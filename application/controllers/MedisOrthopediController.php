<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedisOrthopediController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MedisOrthopedi_model');
        $this->load->model('Dokter_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function MedisOrthopedi_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        
        // Ambil detail pasien dengan no_rawat lengkap
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat;

        $this->load->view('template/header.php');
        $this->load->view('awalMedisDokter/MedisOrthopedi_form', $data);
        $this->load->view('awalMedisDokter/hasilMedisOrthopedi_view', $data);
        $this->load->view('template/footer.php');
    }

    public function save_asesmenMedisOrthopedi() {
        log_message('debug', 'save_asesmenMedisOrthopedi called');
        $data = array(
            'no_rawat' => $this->input->post('no_rawat'),
            'kd_dokter' => $this->input->post('kd_dokter'),
            'tanggal' => $this->input->post('tanggal_jam'),
            'anamnesis' => $this->input->post('anamnesis') ?? 'autoanamnesis',
            'hubungan' => $this->input->post('hubungan') ?? NULL,
            'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
            'rps' => $this->input->post('rps') ?? NULL,
            'rpd' => $this->input->post('rpd') ?? NULL,
            'rpo' => $this->input->post('rpo') ?? NULL,
            'alergi' => $this->input->post('alergi') ?? NULL,
            'kesadaran' => $this->input->post('kesadaran') ?? NULL,
            'status' => $this->input->post('status') ?? NULL,
            'td' => $this->input->post('td') ?? NULL,
            'nadi' => $this->input->post('nadi') ?? NULL,
            'rr' => $this->input->post('rr') ?? NULL,
            'suhu' => $this->input->post('suhu') ?? NULL,
            'bb' => $this->input->post('bb') ?? NULL,
            'nyeri' => $this->input->post('nyeri') ?? NULL,
            'gcs' => $this->input->post('gcs') ?? NULL,
            'kepala' => $this->input->post('kepala') ?? NULL,
            'thoraks' => $this->input->post('thoraks') ?? NULL,
            'abdomen' => $this->input->post('abdomen') ?? NULL,
            'genetalia' => $this->input->post('genetalia') ?? NULL,
            'ekstremitas' => $this->input->post('ekstremitas') ?? NULL,
            'columna' => $this->input->post('columna') ?? NULL,
            'muskulos' => $this->input->post('muskulos') ?? NULL,
            'lainnya' => $this->input->post('lainnya') ?? NULL,
            'ket_lokalis' => $this->input->post('ket_lokalis') ?? NULL,
            'lab' => $this->input->post('lab') ?? NULL,
            'rad' => $this->input->post('rad') ?? NULL,
            'pemeriksaan' => $this->input->post('pemeriksaan') ?? NULL,
            'diagnosis' => $this->input->post('diagnosis') ?? NULL,
            'diagnosis2' => $this->input->post('diagnosis2') ?? NULL,
            'permasalahan' => $this->input->post('permasalahan') ?? NULL,
            'terapi' => $this->input->post('terapi') ?? NULL,
            'tindakan' => $this->input->post('tindakan') ?? NULL,
            'edukasi' => $this->input->post('edukasi') ?? NULL,
        );

        $result = $this->MedisOrthopedi_model->insert_asesmenMedisOrthopedi($data);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Asesmen berhasil disimpan'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan asesmen'];
        }

        echo json_encode($response);
    }

    public function get_asesmenMedisOrthopedi_data() {
        $no_rawat = $this->input->get('no_rawat');
        $asesmen_data = $this->MedisOrthopedi_model->get_asesmenMedisOrthopedi_by_no_rawat($no_rawat);
        
        if ($asesmen_data) {
            echo json_encode($asesmen_data);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function saveLokalisImage() 
    {
        $no_rawat = $this->input->post('no_rawat');
        
        // Cek apakah gambar sudah ada di database
        $existing_image = $this->db->get_where('tohar_gambar_lokalis', ['no_rawat' => $no_rawat])->row();

        if ($existing_image) {
            echo json_encode(['status' => 'error', 'message' => 'Gambar untuk no rawat ini sudah ada. Anda hanya bisa mengunggah gambar satu kali.']);
            return;
        }

        $imageData = $this->input->post('imageData');
        $imageName = 'lokalis_' . uniqid() . '.jpg';

        // Gunakan konfigurasi global untuk path penyimpanan
        $path = $this->config->item('upload_full_path') . $imageName;

        // Cek apakah direktori dapat ditulisi
        if (is_writable($this->config->item('upload_full_path'))) {
            // Menyimpan data gambar ke file
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);

            if (file_put_contents($path, $imageData)) {
                // Simpan nama atau path gambar ke database
                $this->db->insert('tohar_gambar_lokalis', [
                    'no_rawat' => $no_rawat,
                    'image' => $imageName
                ]);
                echo json_encode(['status' => 'success', 'message' => 'Gambar berhasil disimpan.', 'image' => $imageName]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan gambar.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Direktori tidak dapat ditulisi.']);
        }
    }

    public function deleteLokalisImage() {
        $no_rawat = $this->input->post('no_rawat');

        // Ambil data gambar dari database
        $imageData = $this->db->get_where('tohar_gambar_lokalis', ['no_rawat' => $no_rawat])->row();

        if ($imageData) {
            $imageName = $imageData->image;
            $filePath = $this->config->item('upload_full_path') . $imageName;

            // Hapus dari database terlebih dahulu
            $this->db->delete('tohar_gambar_lokalis', ['no_rawat' => $no_rawat]);

            // Cek apakah file ada dan bisa dihapus
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    echo json_encode(['status' => 'success', 'message' => 'Gambar berhasil dihapus.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus file gambar dari folder.']);
                }
            } else {
                echo json_encode(['status' => 'success', 'message' => 'File gambar tidak ditemukan, namun data telah dihapus dari database.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data gambar tidak ditemukan.']);
        }
    }

    public function update_asesmenMedisOrthopedi() {
        $no_rawat = $this->input->post('no_rawat');
        $data = array(
            'kd_dokter' => $this->input->post('kd_dokter'),
            'tanggal' => $this->input->post('tanggal_jam'),
            'anamnesis' => $this->input->post('anamnesis') ?? 'autoanamnesis',
            'hubungan' => $this->input->post('hubungan') ?? NULL,
            'keluhan_utama' => $this->input->post('keluhan_utama') ?? NULL,
            'rps' => $this->input->post('rps') ?? NULL,
            'rpd' => $this->input->post('rpd') ?? NULL,
            'rpo' => $this->input->post('rpo') ?? NULL,
            'alergi' => $this->input->post('alergi') ?? NULL,
            'kesadaran' => $this->input->post('kesadaran') ?? NULL,
            'status' => $this->input->post('status') ?? NULL,
            'td' => $this->input->post('td') ?? NULL,
            'nadi' => $this->input->post('nadi') ?? NULL,
            'rr' => $this->input->post('rr') ?? NULL,
            'suhu' => $this->input->post('suhu') ?? NULL,
            'bb' => $this->input->post('bb') ?? NULL,
            'nyeri' => $this->input->post('nyeri') ?? NULL,
            'gcs' => $this->input->post('gcs') ?? NULL,
            'kepala' => $this->input->post('kepala') ?? NULL,
            'thoraks' => $this->input->post('thoraks') ?? NULL,
            'abdomen' => $this->input->post('abdomen') ?? NULL,
            'genetalia' => $this->input->post('genetalia') ?? NULL,
            'ekstremitas' => $this->input->post('ekstremitas') ?? NULL,
            'columna' => $this->input->post('columna') ?? NULL,
            'muskulos' => $this->input->post('muskulos') ?? NULL,
            'lainnya' => $this->input->post('lainnya') ?? NULL,
            'ket_lokalis' => $this->input->post('ket_lokalis') ?? NULL,
            'lab' => $this->input->post('lab') ?? NULL,
            'rad' => $this->input->post('rad') ?? NULL,
            'pemeriksaan' => $this->input->post('pemeriksaan') ?? NULL,
            'diagnosis' => $this->input->post('diagnosis') ?? NULL,
            'diagnosis2' => $this->input->post('diagnosis2') ?? NULL,
            'permasalahan' => $this->input->post('permasalahan') ?? NULL,
            'terapi' => $this->input->post('terapi') ?? NULL,
            'tindakan' => $this->input->post('tindakan') ?? NULL,
            'edukasi' => $this->input->post('edukasi') ?? NULL,
        );

        $result = $this->MedisOrthopedi_model->update_asesmenMedisOrthopedi($no_rawat, $data);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui asesmen']);
        }
    }

    public function delete_asesmenMedisOrthopedi() {
        $no_rawat = $this->input->post('no_rawat');
        $result = $this->MedisOrthopedi_model->delete_asesmenMedisOrthopedi($no_rawat);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus asesmen']);
        }
    }
}
?>
