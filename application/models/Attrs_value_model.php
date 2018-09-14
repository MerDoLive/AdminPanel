<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attrs_value_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query()
	{
		$this->db->select('ATTR_VALUES.*,ATTR_MSTR.ATTR_MSTR_ATTR_ID,ATTR_MSTR.ATTR_MSTR_ATTR_NAME,ATTR_MSTR.ATTR_MSTR_ATTR_DESC');
		$this->db->from('ATTR_VALUES');
		$this->db->join('ATTR_MSTR',"ATTR_VALUES.ATTR_VALUES_ATTR_ID=ATTR_MSTR.ATTR_MSTR_ATTR_ID",'left');
		$this->db->order_by('ATTR_VALUES.ATTR_VALUES_ATTR_VALUES',"ASC");
		
		$i = 0;
	    if($_POST['search']['value']) // if datatable send POST for search
            {
                $explode_string = explode(' ', $_POST['search']['value']);
                foreach ($explode_string as $show_string) {
                    $cond  = " ";
                    $cond.=" ( ATTR_VALUES.ATTR_VALUES_ATTR_VALUES LIKE '%".$show_string."%' ";
                    $this->db->where($cond);
                }
             }	
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		
		 //Sorting Code Starts//
		 $order_data = "";
		 if(!empty($_POST['order']) && $_POST['order']['0']['dir'] == 'asc'){
			 $order_by = "";
		 }else{
			 $order_by = "DESC";
		 }
		 if(!empty($_POST['order']) && ($_POST['order']['0']['column'] == 0 || $_POST['order']['0']['column'] == 1)){
			 $order_data = "ATTR_MSTR.ATTR_MSTR_ATTR_ID ".$order_by;
		 }
		/*  if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 2 ){
			 $order_data = "ATTR_VALUES.USER_MSTR_USER_TYPE_ID ".$order_by;
		 }
		 if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 3 ){
			 $order_data = "ATTR_VALUES.USER_MSTR_USER_PASS ".$order_by;
		 }
		 if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 4 ){
			 $order_data = "ATTR_VALUES.USER_MSTR_USER_NAME ".$order_by;
		 }
		 if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 5 ){
			 $order_data = "ATTR_VALUES.USER_MSTR_USER_DESC ".$order_by;
		 }
		 if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 6 ){
			 $order_data = "ATTR_VALUES.USER_MSTR_STATUS ".$order_by;
		 } */
		 $this->db->order_by($order_data);
		 //Sorting Code End//

		$query = $this->db->get();
		return $query->result();
	}

	public function count_all()
	{    
	    $this->db->from('ATTR_MSTR');
	    return $this->db->count_all_results();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function GetAttrData($id){
		$this->db->select('CATG_MSTR.CATG_MSTR_CATEGORY_NAME');
		$this->db->from('CATG_ATTR_MAP');
		$this->db->join('CATG_MSTR','CATG_MSTR.CATG_MSTR_CATEGORY_ID=CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID','left');
		$this->db->where("CATG_ATTR_MAP.CATG_ATTR_MAP_ATTR_ID='".$id."'");
 		return $this->db->get()->result();
	}

}