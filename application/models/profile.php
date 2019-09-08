<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class Profile extends CI_Model{

	public $table= 'profile';
	
	function get($q) {
		return $this->db->get_where($this->table,$q);
	}

	function add($data){
		return $this->db->insert($this->table,$data);
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