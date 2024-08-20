<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorium_model extends CI_Model 
{
    public function get_lab_tests($limit) 
    {
        $this->db->limit($limit);
        $query = $this->db->get('jns_perawatan_lab'); // Sesuaikan nama tabelnya
        return $query->result_array();
    }

    public function search_lab_tests($query) 
    {
        $this->db->like('nm_perawatan', $query);
        $query = $this->db->get('jns_perawatan_lab'); // Sesuaikan nama tabelnya
        return $query->result_array();
    }

    public function get_lab_details($kd_jenis_prw) 
    {
        $this->db->where('kd_jenis_prw', $kd_jenis_prw);
        $query = $this->db->get('template_laboratorium');
        return $query->result_array();
    }

    public function insert_lab_order($data) 
    {
        return $this->db->insert('permintaan_lab', $data);
    }

    public function insert_lab_order_detail($data) 
    {
        return $this->db->insert('permintaan_pemeriksaan_lab', $data);
    }

    public function insert_lab_order_detail_template($data) {
        return $this->db->insert('permintaan_detail_permintaan_lab', $data);
    }

    public function get_last_order_number($currentDate) 
    {
        $this->db->like('noorder', 'PK' . $currentDate, 'after');
        $this->db->order_by('noorder', 'desc');
        $query = $this->db->get('permintaan_lab');
        return $query->row_array();
    }
}
