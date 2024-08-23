<?php
class MedisDalam_model extends CI_Model {

    public function get_penilaian_medis_ralan_penyakit_dalam($no_rawat)
    {
        $this->db->select('penilaian_medis_ralan_penyakit_dalam.*,dokter.nm_dokter');
        $this->db->from('penilaian_medis_ralan_penyakit_dalam');
        $this->db->join('dokter', 'penilaian_medis_ralan_penyakit_dalam.kd_dokter=dokter.kd_dokter');
        $this->db->where('penilaian_medis_ralan_penyakit_dalam.no_rawat', $no_rawat);
        return $this->db->get()->result();
    }

    public function insert_asesmen($data) {
        return $this->db->insert('penilaian_medis_ralan_penyakit_dalam', $data);
    }

    public function get_asesmen_by_no_rawat($no_rawat) {
        $this->db->where('no_rawat', $no_rawat);
        $query = $this->db->get('penilaian_medis_ralan_penyakit_dalam');
        return $query->result();
    }

    public function update_asesmen($no_rawat, $data) {
    $this->db->where('no_rawat', $no_rawat);
    return $this->db->update('penilaian_medis_ralan_penyakit_dalam', $data);
}


    public function delete_asesmen($no_rawat) {
    // Pastikan no_rawat sesuai dengan data yang ada di database
    $this->db->where('no_rawat', $no_rawat);
    $result = $this->db->delete('penilaian_medis_ralan_penyakit_dalam'); // Ganti dengan nama tabel yang sesuai
    
    // Mengembalikan true jika berhasil, false jika gagal
    return $result;
}



}
