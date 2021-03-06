<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories_type_model extends CI_Model
{
	var $column_search = array('CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE_ID','CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE'); //set column field database for datatable searchable 
	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query($cond2)
	{
		$this->db->select('*');
		$this->db->from('CATG_TYPE_MSTR');
		//$this->db->order_by('CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE_ID',"desc");
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

		if($cond2)
             {
             	
                	$cond  = "CATG_TYPE_MSTR.CATG_TYPE_MSTR_STATUS='".$cond2."'";	
                	
                    $this->db->where($cond);
             }
		
	}

	function get_datatables($cond2)
	{
		if($cond2=='')
		{

			$cond2='LIVE';
		}
		if($cond2=='ALL')
		{

			$cond2='';
		}
		$this->_get_datatables_query($cond2);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);

		//sorting code starts
        if(!empty($_POST['order']) && $_POST['order']['0']['dir'] == 'asc'){
		$order_by = "";
	}else{
		$order_by = "DESC";
	}
	if(!empty($_POST['order']) && ($_POST['order']['0']['column'] == 0 || $_POST['order']['0']['column'] == 1)){
		$order_data = "CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE_ID ".$order_by;
	}
	if(!empty($_POST['order']) && ($_POST['order']['0']['column'] == 2)){
		$order_data = "CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE ".$order_by;
	}
        $this->db->order_by($order_data);
		// sorting code end
		

		$query = $this->db->get();
		return $query->result();
	}

	public function count_all($cond2)
	{    
	    $this->db->from('CATG_TYPE_MSTR');
	    if($cond2=='')
		{

			$cond2='LIVE';
		}
		if($cond2=='ALL')
		{

			$cond2='';
		}
	    if($cond2)
             {
             	
                	$cond  = "CATG_TYPE_MSTR.CATG_TYPE_MSTR_STATUS='".$cond2."'";	
                	
                    $this->db->where($cond);
             }
		return $this->db->count_all_results();
	}

	function count_filtered($cond2)
	{
		if($cond2=='')
		{

			$cond2='LIVE';
		}
		if($cond2=='ALL')
		{

			$cond2='';
		}
		$this->_get_datatables_query($cond2);
		$query = $this->db->get();
		return $query->num_rows();
	}

}