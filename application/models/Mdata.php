<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdata extends CI_Model{

	function __construct(){ 
        parent::__construct();
        $this->load->database();
    }
	
	public function getAllDesa(){
        $data = $this->db->get('villages');
        return $data->result_array();
	}

    public function getDesaById($id){
        $data = $this->db->get_where('villages', array('id' => $id));
        return $data->result_array();
	}

	public function insertDesa($data){
        $id = $data['id'];
        $this->db->insert('villages', $data);
        if ($this->db->affected_rows() > 0) {
            $insert_id = $id;

            $result = $this->db->get_where('villages', array('id' => $insert_id));

            return $result->row_array();
        } else {
            return null;
        }
    }

    public function updateDesa($data, $id){
        $this->db->where('id', $id);
        $this->db->update('villages', $data);

        $result = $this->db->get_where('villages', array('id' => $id));
        
        return $result->row_array();
    }

    // public function deleteDesa($id){
    //     $result = $this->db->get_where('villages', array('id' => $id));

    //     $this->db->where('id', $id);
    //     $this->db->delete('villages');
        
    //     return $result->row_array();
    // }

    public function deleteDesa($id) {
        $this->db->where('id', $id);
        return $this->db->delete('villages');
    }
}