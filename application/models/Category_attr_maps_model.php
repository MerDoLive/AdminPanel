<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_attr_maps_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	private function _get_datatables_query()
	{
		$this->db->select('CATG_ATTR_MAP.*,ATTR_MSTR.ATTR_MSTR_ATTR_NAME,CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE');
		$this->db->from('CATG_ATTR_MAP');
		$this->db->join('CATG_TYPE_MSTR',"CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE_ID=CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID",'left');
		$this->db->join('ATTR_MSTR',"ATTR_MSTR.ATTR_MSTR_ATTR_ID=CATG_ATTR_MAP.CATG_ATTR_MAP_ATTR_ID",'left');
		$this->db->order_by('CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID',"desc");
		$i = 0;
	    if($_POST['search']['value']) // if datatable send POST for search
            {
                $explode_string = explode(' ', $_POST['search']['value']);
                foreach ($explode_string as $show_string) {
                    $cond  = " ";
                    $cond.=" ( ATTR_MSTR.ATTR_MSTR_ATTR_NAME LIKE '%".$show_string."%' ";
                    
                    $cond.=" OR CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE  LIKE '%".$show_string."%'  ) ";
                    $this->db->where($cond);
                }
             }	
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all()
	{    
	    $this->db->from('CATG_ATTR_MAP');
	    return $this->db->count_all_results();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

}
