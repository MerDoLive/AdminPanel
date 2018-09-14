<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Images_model extends CI_Model
{

	 

	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query($cond2)
	{
		$this->db->select('IMAGE_GROUP_MSTR.*');
		$this->db->from('IMAGE_GROUP_MSTR');
		//$this->db->join('ATTR_VALUES',"ATTR_VALUES.ATTR_VALUES_ATTR_ID=IMAGE_GROUP_MSTR.ATTR_MSTR_ATTR_ID",'left');
		$this->db->order_by('IMAGE_GROUP_MSTR_GROUP',"desc");
		
		$i = 0;
	    if($_POST['search']['value']) // if datatable send POST for search
            {
                $explode_string = explode(' ', $_POST['search']['value']);
                foreach ($explode_string as $show_string) {
                    $cond  = " ";
                    $cond.=" ( IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_GROUP LIKE '%".$show_string."%' ";
                    
                //    $cond.=" OR IMAGE_GROUP_MSTR.ATTR_MSTR_ATTR_DESC  LIKE '%".$show_string."%'  ) ";
                    $this->db->where($cond);
                }
			 }	
		
		if($cond2)
		{
			if($cond2=='LIVE')
                	{
                	$cond  = "IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_STATUS='LIVE'";	
                	}
                	else if($cond2=='PNDG')
                	{
                	$cond  = "IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_STATUS='PNDG'";	
                    }
                    else if($cond2=='REJ')
                	{
                	$cond  = "IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_STATUS='REJ'";	
                	}
                	else
                	{
                    $cond  = "IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_STATUS='DLTD'";
                    }
                    $this->db->where($cond);
		}	 

	}

	function get_datatables($cond2)
	{
		$this->_get_datatables_query($cond2);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);

		//sort code
        $order_data = "";
        if(!empty($_POST['order']) && $_POST['order']['0']['dir'] == 'asc'){
            $order_by = "";
        }else{
            $order_by = "DESC";
        }
        if(!empty($_POST['order']) && ($_POST['order']['0']['column'] == 0 || $_POST['order']['0']['column'] == 1)){
            $order_data = "IMAGE_GROUP_MSTR.IMAGE_GROUP_MSTR_GROUP ".$order_by;
        }
        /* if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 2 ){
            $order_data = "IMAGE_MSTR.USER_MSTR_USER_TYPE_ID ".$order_by;
        }*/
        $this->db->order_by($order_data);
        // sort code end

		$query = $this->db->get();
		return $query->result();
	}

	public function count_all()
	{    
	    $this->db->from('IMAGE_GROUP_MSTR');
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