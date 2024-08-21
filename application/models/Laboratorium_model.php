<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorium_model extends CI_Model 
{
    public function get_hasil_lab($no_rawat)
    {
        $this->db->select('
            permintaan_lab.noorder, 
            permintaan_lab.tgl_permintaan,
            permintaan_lab.jam_permintaan, 
            permintaan_detail_permintaan_lab.kd_jenis_prw,
            jns_perawatan_lab.nm_perawatan, 
            template_laboratorium.Pemeriksaan'
        );
        $this->db->from('permintaan_lab');
        $this->db->join('permintaan_detail_permintaan_lab', 'permintaan_lab.noorder = permintaan_detail_permintaan_lab.noorder');
        $this->db->join('jns_perawatan_lab', 'permintaan_detail_permintaan_lab.kd_jenis_prw = jns_perawatan_lab.kd_jenis_prw');
        $this->db->join('template_laboratorium', 'permintaan_detail_permintaan_lab.id_template = template_laboratorium.id_template');
        $this->db->where('permintaan_lab.no_rawat', $no_rawat);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Mengambil tes laboratorium dengan limit tertentu
    public function get_lab_tests($limit) 
    {
        $this->db->limit($limit);
        $query = $this->db->get('jns_perawatan_lab'); // Sesuaikan nama tabelnya
        return $query->result_array();
    }

    // Mencari tes laboratorium berdasarkan query
    public function search_lab_tests($query) 
    {
        $this->db->like('nm_perawatan', $query);
        $query = $this->db->get('jns_perawatan_lab'); // Sesuaikan nama tabelnya
        return $query->result_array();
    }

    // Mengambil detail laboratorium berdasarkan kode jenis perawatan
    public function get_lab_details($kd_jenis_prw) 
    {
        $this->db->where('kd_jenis_prw', $kd_jenis_prw);
        $query = $this->db->get('template_laboratorium');
        return $query->result_array();
    }

    // Menyimpan data permintaan laboratorium
    public function insert_lab_order($data) 
    {
        return $this->db->insert('permintaan_lab', $data);
    }

    // Menyimpan detail pemeriksaan laboratorium
    public function insert_lab_order_detail($data) 
    {
        return $this->db->insert('permintaan_pemeriksaan_lab', $data);
    }

    // Menyimpan detail template pemeriksaan laboratorium
    public function insert_lab_order_detail_template($data) 
    {
        return $this->db->insert('permintaan_detail_permintaan_lab', $data);
    }

    // Mengambil nomor order terakhir berdasarkan tanggal
    public function get_last_order_number($currentDate) 
    {
        $this->db->like('noorder', 'PK' . $currentDate, 'after');
        $this->db->order_by('noorder', 'desc');
        $query = $this->db->get('permintaan_lab');
        return $query->row_array();
    }

    public function delete_hasil_lab($no_rawat, $no_order)
    {
        // Hapus dari tabel permintaan_detail_permintaan_lab
        $this->db->where('noorder', $no_order);
        $this->db->delete('permintaan_detail_permintaan_lab');

        // Hapus dari tabel permintaan_pemeriksaan_lab
        $this->db->where('noorder', $no_order);
        $this->db->delete('permintaan_pemeriksaan_lab');

        // Hapus dari tabel permintaan_lab
        $this->db->where('noorder', $no_order);
        $this->db->where('no_rawat', $no_rawat);
        $result = $this->db->delete('permintaan_lab');

        return $result;
    }

}
