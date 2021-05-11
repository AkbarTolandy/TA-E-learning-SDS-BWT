<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($table, $data) 
	{
		$sql = $this->db->insert($table, $data);

		if($sql === true) :
			return true; 
		else:
			return false;
		endif;
	}

	public function edit($table, $data, $id = null) 
	{
		if($id) :
			$this->db->where('id', $id);
			$sql = $this->db->update($table, $data);

			if($sql === true) :
				return true; 
			else:
				return false;
			endif;
		endif;
	}

	public function fetchData($table, $id = null) 
	{
		if($id) :
			$sql = "SELECT * FROM $table WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		endif;

		$sql = "SELECT * FROM $table";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function remove($table, $id = null) {
		if($id) :
			$sql = "DELETE FROM $table WHERE id = ?";
			$query = $this->db->query($sql, array($id));

			// ternary operator
			return ($query === true) ? true : false;			
		endif;
	}
}
