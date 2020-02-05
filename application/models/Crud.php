<?php
Class Crud extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function ambil_matkul(){
		$result=$this->db->select('*');
		$result=$this->db->from('matkul');
		$result=$this->db->get('');
		return $result->result();
	}

	function ambil_matkul_id($id){
		$result=$this->db->select('*');
		$result=$this->db->from('matkul');
		$result=$this->db->where('id', $id);
		$result=$this->db->get('');
		return $result->result();
	}

	function tambah_matkul($data){
		$query=$this->db->insert($data);
		return $query;
	}

	function edit_matkul($data, $id){
		$this->db->where('id', $id);
		$result=$this->db->update('matkul',$data);
		return $result;
	}

	function hapus_matkul($id){
		$this->db->where('id', $id);
		$this->db->delete('matkul');
	}
}