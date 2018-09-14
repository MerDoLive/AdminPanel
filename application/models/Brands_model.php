<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Brands_model extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query($cond2)
	{
		$this->db->select('*');
		$this->db->from('BRND_MSTR');
		$i = 0;
	    if($_POST['search']['value']) // if datatable send POST for search
        {
            $explode_string = explode(' ', $_POST['search']['value']);
			foreach ($explode_string as $show_string) 
			{
                $cond  = " ";
                $cond.=" ( BRND_MSTR.BRND_MSTR_BRAND_NAME LIKE '%".$show_string."%' ";
                $cond.=" OR BRND_MSTR.BRND_MSTR_BRAND_DESC LIKE '%".$show_string."%'  ) ";
                $this->db->where($cond);
            }
        }	

		if($cond2)
             {
             	   $cond  = "BRND_MSTR.BRND_MSTR_STATUS='".$cond2."'";

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


		   //sort code
		   $order_data = "";
		   if(!empty($_POST['order']) && $_POST['order']['0']['dir'] == 'asc'){
			   $order_by = "";
		   }else{
			   $order_by = "DESC";
		   }
		   if(!empty($_POST['order']) && ($_POST['order']['0']['column'] == 1 || $_POST['order']['0']['column'] == 2)){
			   $order_data = "BRND_MSTR.BRND_MSTR_BRAND_ID ".$order_by;
		   }
		   if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 3 ){
			   $order_data = "BRND_MSTR.BRND_MSTR_BRAND_NAME ".$order_by;
		   }
		   if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 5 ){
			   $order_data = "BRND_MSTR.BRND_MSTR_BRAND_DESC ".$order_by;
		   }
		   if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 6 ){
			   $order_data = "BRND_MSTR.BRND_MSTR_STATUS ".$order_by;
		   }
		   if($order_data){
		   $this->db->order_by($order_data);
		}
		   // sort code end
		   
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all($cond2)
	{    
		if($cond2=='')
		{

			$cond2='LIVE';
		}
		if($cond2=='ALL')
		{

			$cond2='';
		}
		$this->db->from('BRND_MSTR');
		if($cond2)
             {
             	
                    $cond  = "BRND_MSTR.BRND_MSTR_STATUS='".$cond2."'";
                   
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

	function GetBrandData($id){
		
		$this->db->select('CATG_MSTR.CATG_MSTR_CATEGORY_NAME');
		$this->db->from('CATG_BRND_MAP');
		$this->db->join('CATG_MSTR','CATG_MSTR.CATG_MSTR_CATEGORY_ID=CATG_BRND_MAP.CATG_BRND_MAP_CATEGORY_ID','left');
		$this->db->where("CATG_BRND_MAP.CATG_BRND_MAP_BRAND_ID='".$id."'");
 		$query=$this->db->get();
 		return $query->result();
	}

}