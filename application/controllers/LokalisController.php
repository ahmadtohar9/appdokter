<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LokalisController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lokalis_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function saveLokalisImage() 
    {
        $no_rawat = $this->input->post('no_rawat');
        $kd_dokter = $this->input->post('kd_dokter');
        
        // Cek apakah gambar sudah ada untuk kombinasi no_rawat dan kd_dokter
        $existing_image = $this->Lokalis_model->getLokalisImageByNoRawatAndDokter($no_rawat, $kd_dokter);

        if ($existing_image) {
            echo json_encode(['status' => 'error', 'message' => 'Gambar untuk no rawat dan dokter ini sudah ada. Anda hanya bisa mengunggah gambar satu kali.']);
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
    
    log_message('debug', 'Menghapus gambar untuk no_rawat: ' . $no_rawat . ' dan kd_dokter: ' . $kd_dokter);

    // Ambil data gambar dari database
    $imageData = $this->Lokalis_model->getLokalisImageByNoRawatAndDokter($no_rawat, $kd_dokter);

    if ($imageData) {
        $imageName = $imageData->image;
        $filePath = $this->config->item('upload_full_path') . $imageName;

        // Hapus dari database terlebih dahulu
        $this->Lokalis_model->deleteLokalisImageByNoRawatAndDokter($no_rawat, $kd_dokter);

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

    public function getLokalisImageByNoRawatAndDokter($no_rawat, $kd_dokter)
    {
        // Ambil data gambar dari database berdasarkan no_rawat dan kd_dokter
        $imageData = $this->Lokalis_model->getLokalisImageByNoRawatAndDokter($no_rawat, $kd_dokter);
        
        if ($imageData) {
            // Berikan response dengan data gambar
            echo json_encode(['status' => 'success', 'image' => $imageData->image]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gambar tidak ditemukan untuk kombinasi no_rawat dan kd_dokter ini.']);
        }
    }
}
?>
