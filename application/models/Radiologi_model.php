<?php

class Radiologi_model extends CI_Model
{

    public function get_permintaan_radiologi($no_rawat)
	{
	    $this->db->select('
	        permintaan_radiologi.noorder,
	        permintaan_radiologi.tgl_permintaan,
	        permintaan_radiologi.jam_permintaan,
	        permintaan_radiologi.informasi_tambahan,
	        permintaan_radiologi.diagnosa_klinis,
	        permintaan_radiologi.no_rawat,
	        jns_perawatan_radiologi.nm_perawatan,
	        jns_perawatan_radiologi.total_byr
	    ');
	    $this->db->from('permintaan_radiologi');
	    $this->db->join('permintaan_pemeriksaan_radiologi', 'permintaan_radiologi.noorder = permintaan_pemeriksaan_radiologi.noorder');
	    $this->db->join('jns_perawatan_radiologi', 'permintaan_pemeriksaan_radiologi.kd_jenis_prw = jns_perawatan_radiologi.kd_jenis_prw');
	    $this->db->where('permintaan_radiologi.no_rawat', $no_rawat);
	    
	    $query = $this->db->get();
	    return $query->result_array();
	}

    public function delete_tindakan($noorder)
	{
	    $this->db->where('noorder', $noorder);
	    return $this->db->delete('permintaan_radiologi');
	}

    public function save_tindakan($data)
    {
        return $this->db->insert('permintaan_radiologi', $data);
    }

    public function save_permintaan_radiologi($data)
    {
        return $this->db->insert('permintaan_pemeriksaan_radiologi', $data);
    }
}

