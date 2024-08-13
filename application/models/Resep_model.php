<?php

/**
 * 
 */
class Resep_model extends CI_Model
{
	
	public function get_resep_data($no_rawat)
    {
        $this->db->select('resep_obat.no_rawat,resep_dokter.no_resep, reg_periksa.no_rkm_medis,pasien.nm_pasien,databarang.kode_brng,databarang.nama_brng,databarang.ralan,resep_dokter.jml,resep_dokter.aturan_pakai');
        $this->db->from('resep_obat');
        $this->db->join('resep_dokter', 'resep_obat.no_resep = resep_dokter.no_resep');
        $this->db->join('reg_periksa', 'resep_obat.no_rawat = reg_periksa.no_rawat');
        $this->db->join('databarang', 'resep_dokter.kode_brng = databarang.kode_brng');
        $this->db->join('pasien', 'reg_periksa.no_rkm_medis = pasien.no_rkm_medis');
        $this->db->where('resep_obat.no_rawat', $no_rawat);
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_resep($no_resep, $kode_brng)
    {
        $this->db->where('no_resep', $no_resep);
        $this->db->where('kode_brng', $kode_brng);
        return $this->db->delete('resep_dokter');
    }

}