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

    public function get_soap_data($no_rawat)
    {
        $this->db->select('pemeriksaan_ralan.*, pegawai.nik, pegawai.nama');
        $this->db->from('pemeriksaan_ralan');
        $this->db->join('pegawai', 'pemeriksaan_ralan.nip=pegawai.nik');
        $this->db->where('no_rawat', $no_rawat);
        $query = $this->db->get();
        return $query->result();
    }

   public function save_soap($data) 
    {
        $this->db->where('no_rawat', $data['no_rawat']);
        $this->db->where('tgl_perawatan', $data['tanggal']);
        $this->db->where('jam_rawat', $data['jam']);
        $existing_entry = $this->db->get('pemeriksaan_ralan')->row();

        if ($existing_entry) {
            // Jika entri sudah ada, lakukan update
            return $this->update_soap($data);
        } else {
            // Jika entri tidak ada, lakukan insert
            $insert_data = array(
                'no_rawat' => $data['no_rawat'],
                'nip' => $data['kd_dokter'],
                'tgl_perawatan' => $data['tanggal'],
                'jam_rawat' => $data['jam'],
                'suhu_tubuh' => $data['suhu_tubuh'],
                'tensi' => $data['tensi'],
                'nadi' => $data['nadi'],
                'respirasi' => $data['respirasi'],
                'tinggi' => $data['tinggi'],
                'berat' => $data['berat'],
                'spo2' => $data['spo2'],
                'gcs' => $data['gcs'],
                'kesadaran' => $data['kesadaran'],
                'keluhan' => $data['keluhan'],
                'pemeriksaan' => $data['pemeriksaan'],
                'alergi' => $data['alergi'],
                'lingkar_perut' => $data['lingkar_perut'],
                'penilaian' => $data['penilaian'],
                'rtl' => $data['rtl'],
                'instruksi' => $data['instruksi'],
                'evaluasi' => $data['evaluasi']
            );
            return $this->db->insert('pemeriksaan_ralan', $insert_data);
        }
    }

    public function update_soap($data)
    {
        $update_data = array(
            'nip' => $data['kd_dokter'],
            'tgl_perawatan' => $data['tanggal'],
            'jam_rawat' => $data['jam'],
            'suhu_tubuh' => $data['suhu_tubuh'],
            'tensi' => $data['tensi'],
            'nadi' => $data['nadi'],
            'respirasi' => $data['respirasi'],
            'tinggi' => $data['tinggi'],
            'berat' => $data['berat'],
            'spo2' => $data['spo2'],
            'gcs' => $data['gcs'],
            'kesadaran' => $data['kesadaran'],
            'keluhan' => $data['keluhan'],
            'pemeriksaan' => $data['pemeriksaan'],
            'alergi' => $data['alergi'],
            'lingkar_perut' => $data['lingkar_perut'],
            'penilaian' => $data['penilaian'],
            'rtl' => $data['rtl'],
            'instruksi' => $data['instruksi'],
            'evaluasi' => $data['evaluasi']
        );

        $this->db->where('no_rawat', $data['no_rawat']);
        $this->db->where('tgl_perawatan', $data['tanggal']);
        $this->db->where('jam_rawat', $data['jam']);
        return $this->db->update('pemeriksaan_ralan', $update_data);
    }

    public function update_status_reg_periksa($no_rawat, $status)
    {
        $this->db->where('no_rawat', $no_rawat);
        return $this->db->update('reg_periksa', ['stts' => $status]);
    }


    public function get_soap_detail($no_rawat)
    {
        $this->db->select('pemeriksaan_ralan.*, pegawai.nik,pegawai.nama');
        $this->db->from('pemeriksaan_ralan');
        $this->db->join('pegawai', 'pemeriksaan_ralan.nip = pegawai.nik');
        $this->db->where('no_rawat', $no_rawat);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete_soap($no_rawat, $nip)
    {
        $this->db->where('no_rawat', $no_rawat);
        $this->db->where('nip', $nip);
        return $this->db->delete('pemeriksaan_ralan');
    }


    // public function delete_soap($no_rawat) 
    // {
    //     $this->db->where('no_rawat', $no_rawat);
    //     return $this->db->delete('pemeriksaan_ralan');
    // }



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



}

?>
