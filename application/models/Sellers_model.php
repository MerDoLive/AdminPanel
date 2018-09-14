<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sellers_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    private function _get_datatables_query($cond2)
    {
        $this->db->select('*');
        $this->db->from('SELR_MSTR');
        $i=0;
        if($_POST['search']['value']) // if datatable send POST for search
        {
            $explode_string = explode(' ', $_POST['search']['value']);
            foreach ($explode_string as $show_string)
            {
                $cond  = " ";
                $cond.=" ( SELR_MSTR.SELR_MSTR_seller_name LIKE '%".$show_string."%' ";
                $cond.=" OR SELR_MSTR.SELR_MSTR_seller_id LIKE '%".$show_string."%'  ) ";
                $this->db->where($cond);
            }
        }	
        if($cond2)
        {
            if($cond2=='ACTIVE')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='ACTIVE'";	
               }
               else if($cond2=='PENDING')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='PENDING'";	
               }
               else if($cond2=='DISABLED')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='DISABLED'";	
               }
              /*  else if($cont2=='DLTD')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='DLTD'";
               } */
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
            $order_data = "SELR_REGISTR.SELR_REGISTR_ID ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 2 ){
            $order_data = "SELR_REGISTR.SELR_REGISTR_seller_firstname ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 3 ){
            $order_data = "SELR_REGISTR.SELR_REGISTR_seller_lastname ".$order_by;
        }
        /* if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 4 ){
            $order_data = "SELR_REGISTR.USER_MSTR_USER_NAME ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 5 ){
            $order_data = "SELR_REGISTR.USER_MSTR_USER_DESC ".$order_by;
        } */
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 6 ){
            $order_data = "SELR_REGISTR.SELR_REGISTR_createdTime ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 7 ){
            $order_data = "SELR_REGISTR.SELR_REGISTR_status ".$order_by;
        }
        $this->db->order_by($order_data);
        // sort code end

		$query = $this->db->get();
		return $query->result();
    }
    
    public function count_all($cond2)
	{    
        $this->db->from('SELR_MSTR');
        if($cond2)
        {
            if($cond2=='ACTIVE')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='ACTIVE'";	
               }
               else if($cond2=='PENDING')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='PENDING'";	
               }
               else if($cond2=='DISABLED')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='DISABLED'";	
               }
              /*  else if($cont2=='DLTD')
               {
               $cond  = "SELR_MSTR.SELR_MSTR_status='DLTD'";
               } */
               $this->db->where($cond);
        }
	    return $this->db->count_all_results();
	}
	function count_filtered($cond2)
	{
		$this->_get_datatables_query($cond2);
		$query = $this->db->get();
		return $query->num_rows();
	}
}