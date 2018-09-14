<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_count_model extends CI_Model
{
	var $column_search = array('CATG_MSTR.CATG_MSTR_CATEGORY_NAME'); //set column field database for datatable searchable 
	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query($CATG_MSTR_CATEGORY_TYPE_ID)
	{
 		 $con = "CATG_MSTR.CATG_MSTR_CATEGORY_TYPE_ID='".$CATG_MSTR_CATEGORY_TYPE_ID."'";
	     $this->db->select('CATG_MSTR.*');
	     $this->db->from('CATG_MSTR');
	     $this->db->where($con);
	     
	     		
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
		
	}

	function get_datatables($CATG_MSTR_CATEGORY_TYPE_ID)
	{
		$this->_get_datatables_query($CATG_MSTR_CATEGORY_TYPE_ID);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all($CATG_MSTR_CATEGORY_TYPE_ID)
	{    
	    $this->_get_datatables_query($CATG_MSTR_CATEGORY_TYPE_ID);
		return $this->db->count_all_results();
	}

	function count_filtered($CATG_MSTR_CATEGORY_TYPE_ID)
	{
		$this->_get_datatables_query($CATG_MSTR_CATEGORY_TYPE_ID);
		$query = $this->db->get();
		return $query->num_rows();
	}

}
