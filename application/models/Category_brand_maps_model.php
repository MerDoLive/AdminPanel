<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_brand_maps_model extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query()
	{
		$this->db->select('CATG_BRND_MAP.*,BRND_MSTR.BRND_MSTR_BRAND_NAME,CATG_MSTR.CATG_MSTR_CATEGORY_NAME');
		$this->db->from('CATG_BRND_MAP');
		$this->db->join('BRND_MSTR',"BRND_MSTR.BRND_MSTR_BRAND_ID=CATG_BRND_MAP.CATG_BRND_MAP_BRAND_ID",'left');
		$this->db->join('CATG_MSTR',"CATG_MSTR.CATG_MSTR_CATEGORY_ID=CATG_BRND_MAP.CATG_BRND_MAP_CATEGORY_ID",'left');
		$this->db->order_by('CATG_BRND_MAP.CATG_BRND_MAP_BRAND_ID',"desc");
		
		$i = 0;
	    if($_POST['search']['value']) // if datatable send POST for search
            {
                $explode_string = explode(' ', $_POST['search']['value']);
                foreach ($explode_string as $show_string) {
                    $cond  = " ";
                    $cond.=" ( BRND_MSTR.BRND_MSTR_BRAND_NAME LIKE '%".$show_string."%' ";
                    
                    $cond.=" OR CATG_MSTR.CATG_MSTR_CATEGORY_NAME  LIKE '%".$show_string."%'  ) ";
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
	    $this->db->from('CATG_BRND_MAP');
	    return $this->db->count_all_results();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

}