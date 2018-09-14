<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seller_request_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($cond2)
    {
        $this->db->select('*');
        $this->db->from('SELR_REGISTR');
        $i=0;
        if($_POST['search']['value']) // if datatable send POST for search
        {
            $explode_string = explode(' ', $_POST['search']['value']);
            foreach ($explode_string as $show_string)
            {
                $cond  = " ";
                $cond.=" ( SELR_REGISTR.SELR_REGISTR_seller_firstname LIKE '%".$show_string."%' ";
                $cond.=" OR SELR_REGISTR.SELR_REGISTR_ID LIKE '%".$show_string."%'  ) ";
                $this->db->where($cond);
            }
        }	

        if($cond2)
             {
             	if($cond2=='PROCESSED')
                	{
                	$cond  = "SELR_REGISTR.SELR_REGISTR_status='PROCESSED'";	
                	}
                	else if($cond2=='PENDING')
                	{
                	$cond  = "SELR_REGISTR.SELR_REGISTR_status='PENDING'";	
                    }
                    else if($cond2=='REJECTED')
                	{
                	$cond  = "SELR_REGISTR.SELR_REGISTR_status='REJECTED'";	
                	}
                	/* else
                	{
                    $cond  = "SELR_REGISTR.SELR_REGISTR_status='DLTD'";
                    } */
                    $this->db->where($cond);
             }
    }

    function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        
        //sort code
        /* $order_data = "";
        if(!empty($_POST['order']) && $_POST['order']['0']['dir'] == 'asc'){
            $order_by = "";
        }else{
            $order_by = "DESC";
        }
        if(!empty($_POST['order']) && ($_POST['order']['0']['column'] == 0 || $_POST['order']['0']['column'] == 1)){
            $order_data = "USER_MSTR.USER_MSTR_USER_ID ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 2 ){
            $order_data = "USER_MSTR.USER_MSTR_USER_TYPE_ID ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 3 ){
            $order_data = "USER_MSTR.USER_MSTR_USER_PASS ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 4 ){
            $order_data = "USER_MSTR.USER_MSTR_USER_NAME ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 5 ){
            $order_data = "USER_MSTR.USER_MSTR_USER_DESC ".$order_by;
        }
        if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 6 ){
            $order_data = "USER_MSTR.USER_MSTR_STATUS ".$order_by;
        }
        $this->db->order_by($order_data); */
        // sort code end

		$query = $this->db->get();
		return $query->result();
    }
    
    public function count_all()
	{    
        $this->db->from('SELR_REGISTR');
        if($cond2)
             {
             	if($cond2=='PROCESSED')
                	{
                	$cond  = "SELR_REGISTR.SELR_REGISTR_status='PROCESSED'";	
                	}
                	else if($cond2=='PENDING')
                	{
                	$cond  = "SELR_REGISTR.SELR_REGISTR_status='PENDING'";	
                    }
                    else if($cond2=='REJECTED')
                	{
                	$cond  = "SELR_REGISTR.SELR_REGISTR_status='REJECTED'";	
                	}
                	/* else
                	{
                    $cond  = "SELR_REGISTR.SELR_REGISTR_status='DLTD'";
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
