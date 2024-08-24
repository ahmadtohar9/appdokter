<?php
class MedisKandungan_model extends CI_Model {

    public function get_asesmenMedisKandungan_by_no_rawat($no_rawat) {
        $this->db->select('penilaian_medis_ralan_kandungan.*, dokter.nm_dokter');
        $this->db->from('penilaian_medis_ralan_kandungan');
        $this->db->join('dokter', 'penilaian_medis_ralan_kandungan.kd_dokter = dokter.kd_dokter');
        $this->db->where('penilaian_medis_ralan_kandungan.no_rawat', $no_rawat);
        return $this->db->get()->result();
    }

    public function insert_asesmenMedisKandungan($data) {
        return $this->db->insert('penilaian_medis_ralan_kandungan', $data);
    }

    public function update_asesmenMedisKandungan($no_rawat, $data) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->update('penilaian_medis_ralan_kandungan', $data);
    }

    public function delete_asesmenMedisKandungan($no_rawat) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->delete('penilaian_medis_ralan_kandungan');
    }
}
