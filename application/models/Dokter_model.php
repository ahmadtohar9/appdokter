<?php

class Dokter_model extends CI_Model {

    public function get_patient_detail($no_rawat)
    {
        $this->db->select('reg_periksa.no_rawat, reg_periksa.no_rkm_medis, pasien.nm_pasien, dokter.nm_dokter, dokter.kd_dokter, poliklinik.nm_poli');
        $this->db->from('reg_periksa');
        $this->db->join('pasien', 'reg_periksa.no_rkm_medis = pasien.no_rkm_medis');
        $this->db->join('dokter', 'reg_periksa.kd_dokter = dokter.kd_dokter');
        $this->db->join('poliklinik', 'reg_periksa.kd_poli = poliklinik.kd_poli');
        $this->db->where('reg_periksa.no_rawat', $no_rawat);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_dokter_by_kd($kd_dokter)
    {
        $this->db->where('kd_dokter', $kd_dokter);
        $query = $this->db->get('dokter');
        return $query->row();
    }

    public function save_diagnosa($data)
    {
        // Cek apakah no_rawat sudah ada di tabel diagnosa_pasien
        $this->db->select('no_rawat');
        $this->db->from('diagnosa_pasien');
        $this->db->where('no_rawat', $data['no_rawat']);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Jika data sudah ada, set status_penyakit menjadi 'Lama'
            $data['status_penyakit'] = 'Lama';
        } else {
            // Jika data belum ada, set status_penyakit menjadi 'Baru'
            $data['status_penyakit'] = 'Baru';
        }

        // Insert data ke tabel diagnosa_pasien
        return $this->db->insert('diagnosa_pasien', $data);
    }

    public function get_diagnosa_data($no_rawat)
    {
        $this->db->select('diagnosa_pasien.*, penyakit.nm_penyakit');
        $this->db->from('diagnosa_pasien');
        $this->db->join('penyakit', 'diagnosa_pasien.kd_penyakit = penyakit.kd_penyakit');
        $this->db->where('diagnosa_pasien.no_rawat', $no_rawat); // pastikan kolom benar
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_diagnosa($no_rawat, $kd_penyakit)
    {
        $this->db->where('no_rawat', $no_rawat);
        $this->db->where('kd_penyakit', $kd_penyakit);
        return $this->db->delete('diagnosa_pasien');
    }

    public function get_existing_resep($no_rawat, $kd_dokter)
    {
        $this->db->where('no_rawat', $no_rawat);
        $this->db->where('kd_dokter', $kd_dokter);
        $this->db->where('status', 'ralan'); // Sesuaikan dengan kondisi yang diinginkan
        $query = $this->db->get('resep_obat'); // Sesuaikan dengan nama tabel yang benar

        return $query->row();
    }

    public function check_existing_obat($no_resep, $kode_brng)
    {
        $this->db->where('no_resep', $no_resep);
        $this->db->where('kode_brng', $kode_brng);
        $query = $this->db->get('resep_dokter'); // Sesuaikan dengan nama tabel yang benar

        return $query->num_rows() > 0;
    }


    public function create_resep_dokter($data)
    {
        // Hilangkan karakter garis miring (/) dari no_rawat untuk membuat no_resep
        $no_resep = str_replace('/', '', $data['no_rawat']);
        
        $insert_data = [
            'no_resep' => $no_resep, // Menggunakan no_rawat yang sudah diubah
            'tgl_peresepan' => date('Y-m-d'),
            'jam_peresepan' => date('H:i:s'),
            'tgl_perawatan' => '0000-00-00',
            'no_rawat' => $data['no_rawat'],
            'kd_dokter' => $data['kd_dokter'],
            'status' => 'ralan' // Sesuaikan dengan status yang diinginkan
        ];

        $this->db->insert('resep_obat', $insert_data); // Sesuaikan dengan nama tabel yang benar

        return $insert_data['no_resep'];
    }

    public function save_resep_obat($no_resep, $data)
    {
        $insert_data = [
            'no_resep' => $no_resep,
            'kode_brng' => $data['kode_brng'],
            'jml' => $data['jml'],
            'aturan_pakai' => $data['aturan_pakai']
        ];

        return $this->db->insert('resep_dokter', $insert_data); // Sesuaikan dengan nama tabel yang benar
    }

    public function get_barang_by_kode($kode)
    {
        return $this->db->get_where('gudangbarang', ['kode_brng' => $kode])->row();
    }

}

?>
