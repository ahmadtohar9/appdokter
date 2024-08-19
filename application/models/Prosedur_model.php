<?php

class Prosedur_model extends CI_Model
{
	

    public function save_prosedur($data)
    {
        $this->db->select('no_rawat');
        $this->db->from('prosedur_pasien');
        $this->db->where('no_rawat', $data['no_rawat']);
        $query = $this->db->get();
        return $this->db->insert('prosedur_pasien', $data);
    }

    public function get_prosedur_data($no_rawat)
    {
        $this->db->select('prosedur_pasien.*, icd9.deskripsi_panjang');
        $this->db->from('prosedur_pasien');
        $this->db->join('icd9', 'prosedur_pasien.kode = icd9.kode');
        $this->db->where('prosedur_pasien.no_rawat', $no_rawat);
        return $this->db->get()->result();
    }

    public function delete_prosedur($no_rawat, $kode)
    {
        $this->db->where('no_rawat', $no_rawat);
        $this->db->where('kode', $kode);
        return $this->db->delete('prosedur_pasien');
    }

}