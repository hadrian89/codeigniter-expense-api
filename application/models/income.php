<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class Income extends CI_Model{

	public $table= 'income';
	
	function get_all($q) {
		return $this->db->get_where($this->table,$q);
	}

	function add($data){
	 $this->db->insert($this->table,$data);
	 $last_id = $this->db->insert_id();
		return $last_id;
	}

	function update($where,$data){
		$this->db->where($where);
		$this->db->update($this->table, $data);
		return true;
	}

	function delete($where){
		$this->db->where($where);
		$this->db->delete($this->table);
		return true;
	}
	
}