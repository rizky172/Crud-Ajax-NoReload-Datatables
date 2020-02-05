<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_crud extends CI_Model {

	function getData($type = null, $select, $table, $limit = null, $offset = null, $joins = null, $where = null, $group = null, $order = null, $like = null)
	{
		if($type == 'result_array'){
			$data = $this->db->get_where($table,$where);
			return $data->result_object();
		}else{
			$command = "SELECT $select FROM $table";
			if ($joins != null)
				{	
					foreach($joins as $key => $values)
					{
						$command .= " LEFT JOIN $key ON $values ";
					}
				}
				
			if ($where != null)
				{	
					$command .= ' WHERE '.implode(' AND ',$where);
				}

			if ($like != null AND $where == null)
				{
					$command .= ' WHERE '.$like;
				}elseif ($like != null AND $where != null) {
					$command .= ' AND '.'('.$like.')';
				}

			if ($group != null)
				{	
					$command .= ' GROUP BY '.implode(', ',$group);
				}

			if ($order != null)
				{	
					$command .= ' ORDER BY '.implode(', ',$order);
				}
			if ($limit != null)
				{
					if ($offset != null)
						{
							$command .= " LIMIT $offset, $limit";
						}else{
							$command .= " LIMIT $limit";
						}	
				}
			$data = $this->db->query($command);
			if ($data->num_rows() > 0)
			{
				return  ($type == 'result') ? $data->result() : $data->row();
			}else{
				return false;
			}
		}
	}

	function qry($type = null, $command)
	{
		$data = $this->db->query($command);
		if ($type != null)
		{
			if ($type == 'bool') {
				return $data;
			}else{
				return ($type == 'result') ? $data->result() : $data->row();
			}
		}else{
			if ($data->num_rows() > 0)
			{
				return true;
			}else{
				return false;
			}
		}
	}

	function checkData($row, $table, $where)
	{
		$command = "SELECT $row FROM $table";
		if ($where != null)
			{	
				$command .= ' WHERE '.implode(' AND ',$where);
			}
		//return $command;
		$data = $this->db->query($command);
		if ($data->num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}

	}

	function insertData($table,$data)
	{
		$data = $this->db->insert($table,$data);
		return $data;
	}

	function insertBatch($table, $data)
	{
		return $this->db->insert_batch($table, $data);
	}

	function updateData($table,$data,$where)
	{
		foreach ($where as $key => $values) {
			$this->db->where($key, $values);
		}
		$data = $this->db->update($table,$data);
		return $data;
	}

	function deleteData($table,$where)
	{
		foreach ($where as $key => $values) {
			$this->db->where($key, $values);
		}
		$data = $this->db->delete($table);
		return $data;
	}

	function delete_all($table)
	{
		$delete = $this->db->truncate($table);
		if ($delete) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function autoNumber($field, $table, $format, $digit)
	{
		$qry = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS KodeAkhir FROM $table WHERE $field LIKE '$format%'");
		if ($qry->num_rows() > 0){
			$nextCode = $qry->row('KodeAkhir') + 1;
		}else{
			$nextcode = 1;
		}
		$kode = $format.sprintf("%0".$digit."s", $nextCode);
		return $kode;
	}

	function countData($type = null, $select, $table, $limit = null, $offset = null, $joins = null, $where = null, $group = null, $order = null, $like = null)
	{
		$command = "SELECT $select FROM $table";
	 	if ($joins != null)
			{	
				foreach($joins as $key => $values)
				{
					$command .= " LEFT JOIN $key ON $values ";
				}
			}
			
		if ($where != null)
			{	
				$command .= ' WHERE '.implode(' AND ',$where);
			}

		if ($like != null AND $where == null)
			{
				$command .= ' WHERE '.$like;
			}elseif ($like != null AND $where != null) {
				$command .= ' AND '.'('.$like.')';
			}

		if ($group != null)
			{	
				$command .= ' GROUP BY '.implode(', ',$group);
			}

		if ($order != null)
			{	
				$command .= ' ORDER BY '.implode(', ',$order);
			}
		if ($limit != null)
			{
				if ($offset != null)
					{
						$command .= " LIMIT $offset, $limit";
					}else{
						$command .= " LIMIT $limit";
					}	
			}
		$data = $this->db->query($command);
		return $data->num_rows();
	}
	
	function setsession_qry(){
		$query=$this->db->query('SET SESSION sql_mode = ""');
		if ($query) {
			return TRUE;
		}else{
			return FALSE;
		}
	}	


	var $column_order = array(null, 'nama','buy'); //set column field database for datatable orderable
	var $column_search = array('nama','nama'); //set column field database for datatable searchable 
	var $order = array('id' => 'asc'); // default order 

	private function _get_datatables_query()
	{
		
		//add custom filter here
		if($this->input->post('nama'))
		{
			$this->db->where('nama', $this->input->post('nama'));
		}
		if($this->input->post('buy'))
		{
			$this->db->where('buy', $this->input->post('buy'));
		}

		$this->db->from('barang');
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($table)
    {
        $this->db->from($table);
        return $this->db->count_all_results();
    }

}

/* End of file Mod_crud.php */
/* Location: ./application/models/Mod_crud.php */
