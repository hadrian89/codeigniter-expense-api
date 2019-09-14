<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class Users extends CI_Model{

	public $table= 'users';
	
	function get_user($q) {
		return $this->db->get_where($this->table,$q);
	}

	function register($data){
		return $this->db->insert($this->table,$data);
	}

	function update_user($where,$data){
		$this->db->where($where);
		$this->db->update($this->table, $data);
		return true;
	}

	function delete_user($where){
		$this->db->where($where);
		$this->db->delete($this->table);
		return true;
	}
	
}