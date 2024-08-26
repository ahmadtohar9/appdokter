<?php
class MedisOrthopedi_model extends CI_Model {

    public function get_asesmenMedisOrthopedi_by_no_rawat($no_rawat) 
    {
        $this->db->select('penilaian_medis_ralan_orthopedi.*, dokter.nm_dokter, tohar_gambar_lokalis.image');
        $this->db->from('penilaian_medis_ralan_orthopedi');
        $this->db->join('dokter', 'penilaian_medis_ralan_orthopedi.kd_dokter = dokter.kd_dokter');
        $this->db->join('tohar_gambar_lokalis', 'penilaian_medis_ralan_orthopedi.no_rawat = tohar_gambar_lokalis.no_rawat', 'left');
        $this->db->where('penilaian_medis_ralan_orthopedi.no_rawat', $no_rawat);
        return $this->db->get()->result();
    }

    public function insert_asesmenMedisOrthopedi($data) {
        return $this->db->insert('penilaian_medis_ralan_orthopedi', $data);
    }

    public function update_asesmenMedisOrthopedi($no_rawat, $data) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->update('penilaian_medis_ralan_orthopedi', $data);
    }

    public function delete_asesmenMedisOrthopedi($no_rawat) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->delete('penilaian_medis_ralan_orthopedi');
    }
}
?>
