<?php
class MedisMata_model extends CI_Model {

   public function get_asesmenMedisMata_by_no_rawat($no_rawat) 
   {
        $this->db->select('*');
        $this->db->from('penilaian_medis_ralan_mata');
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->get()->result();
    }

    public function insert_asesmenMedisMata($data) {
        return $this->db->insert('penilaian_medis_ralan_mata', $data);
    }

    public function update_asesmenMedisMata($no_rawat, $data) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->update('penilaian_medis_ralan_mata', $data);
    }

    public function delete_asesmenMedisMata($no_rawat) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->delete('penilaian_medis_ralan_mata');
    }
}
