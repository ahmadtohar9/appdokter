<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soap_model extends CI_Model {

    // Mengambil data SOAP berdasarkan no_rawat
    public function get_soap_data($no_rawat) {
        $this->db->select('pemeriksaan_ralan.*, pegawai.nik, pegawai.nama');
        $this->db->from('pemeriksaan_ralan');
        $this->db->join('pegawai', 'pemeriksaan_ralan.nip = pegawai.nik');
        $this->db->where('pemeriksaan_ralan.no_rawat', $no_rawat);
        $query = $this->db->get();
        return $query->result();
    }

    // Menyimpan data SOAP baru
    public function save_soap($data) {
        $insert_data = array(
            'no_rawat' => $data['no_rawat'],
            'nip' => $data['kd_dokter'],
            'tgl_perawatan' => $data['tanggal'],
            'jam_rawat' => $data['jam'],
            'suhu_tubuh' => $data['suhu_tubuh'],
            'tensi' => $data['tensi'],
            'nadi' => $data['nadi'],
            'respirasi' => $data['respirasi'],
            'tinggi' => $data['tinggi'],
            'berat' => $data['berat'],
            'spo2' => $data['spo2'],
            'gcs' => $data['gcs'],
            'kesadaran' => $data['kesadaran'],
            'keluhan' => $data['keluhan'],
            'pemeriksaan' => $data['pemeriksaan'],
            'alergi' => $data['alergi'],
            'lingkar_perut' => $data['lingkar_perut'],
            'penilaian' => $data['penilaian'],
            'rtl' => $data['rtl'],
            'instruksi' => $data['instruksi'],
            'evaluasi' => $data['evaluasi']
        );
        return $this->db->insert('pemeriksaan_ralan', $insert_data);
    }

    // Menghapus data SOAP berdasarkan no_rawat dan nip
    public function delete_soap($no_rawat, $nip) {
        $this->db->where('no_rawat', $no_rawat);
        $this->db->where('nip', $nip);
        return $this->db->delete('pemeriksaan_ralan');
    }

    // Mengambil detail SOAP untuk pengeditan berdasarkan no_rawat
    public function get_single_soap($no_rawat) 
    {
        $this->db->select('pemeriksaan_ralan.*, pegawai.nik, pegawai.nama');
        $this->db->from('pemeriksaan_ralan');
        $this->db->join('pegawai', 'pemeriksaan_ralan.nip = pegawai.nik');
        $this->db->where('pemeriksaan_ralan.no_rawat', $no_rawat);
        $query = $this->db->get();
        return $query->row();
    }

    // Mengupdate status reg_periksa setelah SOAP disimpan
    public function update_status_reg_periksa($no_rawat, $status) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->update('reg_periksa', ['stts' => $status]);
    }

    public function get_soap_by_no_rawat_and_tanggal($no_rawat, $tgl_perawatan) 
    {
        $this->db->where('no_rawat', $no_rawat);
        $this->db->where('tgl_perawatan', $tgl_perawatan);
        $query = $this->db->get('pemeriksaan_ralan'); // Sesuaikan nama tabel dengan tabel yang digunakan
        return $query->row_array(); // Atau return $query->result_array(); jika ingin mendapatkan hasil dalam bentuk array
    }

    public function update_soap($data) 
    {
        $update_data = array(
            'nip' => $data['kd_dokter'],
            'tgl_perawatan' => $data['tanggal'],
            'suhu_tubuh' => $data['suhu_tubuh'],
            'tensi' => $data['tensi'],
            'nadi' => $data['nadi'],
            'respirasi' => $data['respirasi'],
            'tinggi' => $data['tinggi'],
            'berat' => $data['berat'],
            'spo2' => $data['spo2'],
            'gcs' => $data['gcs'],
            'kesadaran' => $data['kesadaran'],
            'keluhan' => $data['keluhan'],
            'pemeriksaan' => $data['pemeriksaan'],
            'alergi' => $data['alergi'],
            'lingkar_perut' => $data['lingkar_perut'],
            'penilaian' => $data['penilaian'],
            'rtl' => $data['rtl'],
            'instruksi' => $data['instruksi'],
            'evaluasi' => $data['evaluasi']
        );

        $this->db->where('no_rawat', $data['no_rawat']);
        $this->db->where('tgl_perawatan', $data['tanggal']);
        
        // Update tanpa mengubah jam_rawat
        return $this->db->update('pemeriksaan_ralan', $update_data);
    }
}
