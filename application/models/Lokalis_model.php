<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lokalis_model extends CI_Model {

    public function saveLokalisImage($no_rawat, $kd_dokter, $imageName) 
    {
        $data = array(
            'no_rawat' => $no_rawat,
            'kd_dokter' => $kd_dokter,
            'image' => $imageName,
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('tohar_gambar_lokalis', $data);
    }

    public function getLokalisImageByNoRawatAndDokter($no_rawat, $kd_dokter) 
    {
        return $this->db->get_where('tohar_gambar_lokalis', ['no_rawat' => $no_rawat, 'kd_dokter' => $kd_dokter])->row();
    }

    public function deleteLokalisImageByNoRawatAndDokter($no_rawat, $kd_dokter) {
        return $this->db->delete('tohar_gambar_lokalis', ['no_rawat' => $no_rawat, 'kd_dokter' => $kd_dokter]);
    }
}
?>
