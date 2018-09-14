<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Images_value_model extends CI_Model
{

	 

	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query($cond2)
	{
		$this->db->select('IMAGE_MSTR.*,IMAGE_GROUP_SQL');
		$this->db->from('IMAGE_MSTR');
		$this->db->join('IMAGE_GROUP_MSTR',"IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_GROUP=IMAGE_MSTR.IMAGE_MSTR_IMAGE_GROUP",'left');
		$this->db->order_by('IMAGE_MSTR_IMAGE_ID',"desc");
		
		$i = 0;
	    if($_POST['search']['value']) // if datatable send POST for search
            {
                $explode_string = explode(' ', $_POST['search']['value']);
                foreach ($explode_string as $show_string) {
                    $cond  = " ";
                    $cond.=" ( IMAGE_MSTR.IMAGE_MSTR_IMAGE_NAME LIKE '%".$show_string."%' ";
                    $cond.=" OR IMAGE_MSTR.IMAGE_MSTR_IMAGE_GROUP LIKE '%".$show_string."%' )";
                    
                    $this->db->where($cond);
                }
			 }	
			 
			 if($cond2)
             {
             	if($cond2=='LIVE')
                	{
                	$cond  = "IMAGE_MSTR.IMAGE_MSTR_IMAGE_STATUS='LIVE'";	
                	}
                	else if($cond2=='PNDG')
                	{
                	$cond  = "IMAGE_MSTR.IMAGE_MSTR_IMAGE_STATUS='PNDG'";	
                    }
                    else if($cond2=='REJ')
                	{
                	$cond  = "IMAGE_MSTR.IMAGE_MSTR_IMAGE_STATUS='REJ'";	
                	}
                    $this->db->where($cond);
             }
	}

	function get_datatables($cond2)
	{
		$this->_get_datatables_query($cond2);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all()
	{    
	    $this->db->from('IMAGE_MSTR');
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

	function get_data_query($id='')
	{
		$this->db->select('IMAGE_MSTR.*');
		$this->db->from('IMAGE_MSTR');
		$this->db->join('IMAGE_GROUP_MSTR',"IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_GROUP=IMAGE_MSTR.IMAGE_MSTR_IMAGE_GROUP",'left');
		$this->db->order_by('IMAGE_MSTR_IMAGE_ID',"desc");
		if($id!=''){
			$this->db->where("IMAGE_MSTR.IMAGE_MSTR_IMAGE_GROUP='".$id."'");
		}
		$query = $this->db->get();
		return $query->result();
	}

}