<?php
class MedisAnak_model extends CI_Model {

   public function get_asesmenMedisAnak_by_no_rawat($no_rawat) 
   {
        $this->db->select('penilaian_medis_ralan_anak.*, dokter.nm_dokter, tohar_gambar_lokalis.image');
        $this->db->from('penilaian_medis_ralan_anak');
        $this->db->join('dokter', 'penilaian_medis_ralan_anak.kd_dokter = dokter.kd_dokter');
        $this->db->join('tohar_gambar_lokalis', 'penilaian_medis_ralan_anak.no_rawat = tohar_gambar_lokalis.no_rawat', 'left');
        $this->db->where('penilaian_medis_ralan_anak.no_rawat', $no_rawat);
        return $this->db->get()->result();
    }

    public function insert_asesmenMedisAnak($data) {
        return $this->db->insert('penilaian_medis_ralan_anak', $data);
    }

    public function update_asesmenMedisAnak($no_rawat, $data) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->update('penilaian_medis_ralan_anak', $data);
    }

    public function delete_asesmenMedisAnak($no_rawat) {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->delete('penilaian_medis_ralan_anak');
    }


    public function saveLokalisImage($no_rawat, $imageName) 
    {
        $data = array(
            'no_rawat' => $no_rawat,
            'image' => $imageName
        );
        return $this->db->insert('tohar_gambar_lokalis', $data);
    }


    public function getLokalisImagesByNoRawat($no_rawat) 
    {
        $this->db->where('no_rawat', $no_rawat);
        $query = $this->db->get('tohar_gambar_lokalis');
        return $query->result();
    }


    public function deleteLokalisImage($id) {
        
        $this->db->where('id', $id);
        $image = $this->db->get('tohar_gambar_lokalis')->row();

        if ($image) {
            // Hapus file gambar dari server
            $file_path = './webapps/berkasrawat/pages/upload/gambarlokalis/' . $image->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Hapus data dari database
            $this->db->where('id', $id);
            return $this->db->delete('tohar_gambar_lokalis');
        }

        return false;
    }
}
