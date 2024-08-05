<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegPeriksa_model extends CI_Model {

    public function get_all_data()
    {
        $this->db->select('reg_periksa.*, dokter.nm_dokter, poliklinik.nm_poli, pasien.nm_pasien, penjab.png_jawab');
        $this->db->from('reg_periksa');
        $this->db->join('dokter', 'reg_periksa.kd_dokter = dokter.kd_dokter');
        $this->db->join('poliklinik', 'reg_periksa.kd_poli = poliklinik.kd_poli');
        $this->db->join('pasien', 'reg_periksa.no_rkm_medis = pasien.no_rkm_medis');
        $this->db->join('penjab', 'reg_periksa.kd_pj = penjab.kd_pj');
        $this->db->order_by('reg_periksa.no_rawat', 'ASC'); // Mengurutkan berdasarkan no_rawat secara descending
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data_by_dokter($kd_dokter)
    {
        $this->db->select('reg_periksa.*, dokter.nm_dokter, poliklinik.nm_poli, pasien.nm_pasien, penjab.png_jawab');
        $this->db->from('reg_periksa');
        $this->db->join('dokter', 'reg_periksa.kd_dokter = dokter.kd_dokter');
        $this->db->join('poliklinik', 'reg_periksa.kd_poli = poliklinik.kd_poli');
        $this->db->join('pasien', 'reg_periksa.no_rkm_medis = pasien.no_rkm_medis');
        $this->db->join('penjab', 'reg_periksa.kd_pj = penjab.kd_pj');
        $this->db->where('reg_periksa.kd_dokter', $kd_dokter);
        $this->db->order_by('reg_periksa.no_reg', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    public function get_dropdown_options()
    {
        return [
            'Assesment Dokter',
            'SOAP',
            'Billing Pasien'
        ];
    }
}
