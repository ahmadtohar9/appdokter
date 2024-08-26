<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedisAnakController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MedisAnak_model');
        $this->load->model('Dokter_model');
        $this->load->model('Lokalis_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function MedisAnak_form($tahun, $bulan, $tanggal, $no_rawat)
    {
        $full_no_rawat = "$tahun/$bulan/$tanggal/$no_rawat";
        
        // Ambil detail pasien dengan no_rawat lengkap
        $data['detail_pasien'] = $this->Dokter_model->get_patient_detail($full_no_rawat);
        $data['no_rawat'] = $full_no_rawat;

        $this->load->view('template/header.php');
        $this->load->view('awalMedisDokter/MedisAnak_form', $data);
        $this->load->view('awalMedisDokter/hasilMedisAnak_view', $data);
        $this->load->view('template/footer.php');
    }

    public function save_asesmenMedisAnak() {
        log_message('debug', 'save_asesmenMedisAnak called');
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
            'ket_lokalis' => $this->input->post('ket_lokalis') ?? NULL,
            'penunjang' => $this->input->post('penunjang') ?? NULL,
            'diagnosis' => $this->input->post('diagnosis') ?? NULL,
            'tata' => $this->input->post('tata') ?? NULL,
            'konsul' => $this->input->post('konsul') ?? NULL,
        );

        $result = $this->MedisAnak_model->insert_asesmenMedisAnak($data);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Asesmen berhasil disimpan'];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal menyimpan asesmen'];
        }

        echo json_encode($response);
    }

    public function get_asesmenMedisAnak_data() {
        $no_rawat = $this->input->get('no_rawat');
        $asesmen_data = $this->MedisAnak_model->get_asesmenMedisAnak_by_no_rawat($no_rawat);
        
        if ($asesmen_data) {
            echo json_encode($asesmen_data);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function saveLokalisImage() 
    {
        $no_rawat = $this->input->post('no_rawat');
        $kd_dokter = $this->input->post('kd_dokter');
        
        // Cek apakah gambar sudah ada di database untuk kombinasi no_rawat dan kd_dokter
        $existing_image = $this->Lokalis_model->getLokalisImage($no_rawat, $kd_dokter);

        if ($existing_image) {
            echo json_encode(['status' => 'error', 'message' => 'Gambar untuk no rawat ini dan dokter ini sudah ada. Anda hanya bisa mengunggah gambar satu kali.']);
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
                $this->Lokalis_model->saveLokalisImage($no_rawat, $kd_dokter, $imageName);
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
        $kd_dokter = $this->input->post('kd_dokter');

        // Ambil data gambar dari database berdasarkan no_rawat dan kd_dokter
        $imageData = $this->Lokalis_model->getLokalisImage($no_rawat, $kd_dokter);

        if ($imageData) {
            $imageName = $imageData->image;
            $filePath = $this->config->item('upload_full_path') . $imageName;

            // Hapus dari database terlebih dahulu
            $this->Lokalis_model->deleteLokalisImage($no_rawat, $kd_dokter);

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

    public function update_asesmenMedisAnak() {
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
            'ket_lokalis' => $this->input->post('ket_lokalis') ?? NULL,
            'penunjang' => $this->input->post('penunjang') ?? NULL,
            'diagnosis' => $this->input->post('diagnosis') ?? NULL,
            'tata' => $this->input->post('tata') ?? NULL,
            'konsul' => $this->input->post('konsul') ?? NULL,
        );

        $result = $this->MedisAnak_model->update_asesmenMedisAnak($no_rawat, $data);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui asesmen']);
        }
    }

    public function delete_asesmenMedisAnak() {
        $no_rawat = $this->input->post('no_rawat');
        $result = $this->MedisAnak_model->delete_asesmenMedisAnak($no_rawat);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Asesmen berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus asesmen']);
        }
    }

    
}
