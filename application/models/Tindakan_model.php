<?php

class Tindakan_model extends CI_Model
{
    public function save_tindakan($data)
    {
        return $this->db->insert('rawat_jl_dr', $data);
    }

    public function get_tindakan_data($no_rawat)
    {
        $this->db->select('rawat_jl_dr.*, jns_perawatan.nm_perawatan, jns_perawatan.total_byrdr');
        $this->db->from('rawat_jl_dr');
        $this->db->join('jns_perawatan', 'rawat_jl_dr.kd_jenis_prw = jns_perawatan.kd_jenis_prw');
        $this->db->where('rawat_jl_dr.no_rawat', $no_rawat);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_tindakan($no_rawat, $kd_jenis_prw, $jam_rawat)
    {
        $this->db->where('no_rawat', $no_rawat);
        $this->db->where('kd_jenis_prw', $kd_jenis_prw);
        $this->db->where('jam_rawat', $jam_rawat);
        return $this->db->delete('rawat_jl_dr');
    }

}
