<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($cond2)
    {
        $this->db->select('*');
        $this->db->from('USER_MSTR');
        $i=0;
        if($_POST['search']['value']) // if datatable send POST for search
        {
            $explode_string = explode(' ', $_POST['search']['value']);
            foreach ($explode_string as $show_string)
            {
                $cond  = " ";
                $cond.=" ( USER_MSTR.USER_MSTR_USER_NAME LIKE '%".$show_string."%' ";
                $cond.=" OR USER_MSTR.USER_MSTR_USER_ID LIKE '%".$show_string."%'  ) ";
                $this->db->where($cond);
            }
        }	

        if($cond2)
             {
             	if($cond2=='LIVE')
                	{
                	$cond  = "USER_MSTR.USER_MSTR_STATUS='LIVE'";	
                	}
                	else if($cond2=='PNDG')
                	{
                	$cond  = "USER_MSTR.USER_MSTR_STATUS='PNDG'";	
                    }
                    else if($cond2=='REJ')
                	{
                	$cond  = "USER_MSTR.USER_MSTR_STATUS='REJ'";	
                	}
                	else
                	{
                    $cond  = "USER_MSTR.USER_MSTR_STATUS='DLTD'";
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
        $this->db->order_by($order_data);
        // sort code end

		$query = $this->db->get();
		return $query->result();
    }
    
    public function count_all($cond2)
	{    
        $this->db->from('USER_MSTR');
        if($cond2)
        {
            if($cond2=='LIVE')
               {
               $cond  = "USER_MSTR.USER_MSTR_STATUS='LIVE'";	
               }
               else if($cond2=='PNDG')
               {
               $cond  = "USER_MSTR.USER_MSTR_STATUS='PNDG'";	
               }
               else if($cond2=='REJ')
               {
               $cond  = "USER_MSTR.USER_MSTR_STATUS='REJ'";	
               }
               else if($cont2=='DLTD')
               {
               $cond  = "USER_MSTR.USER_MSTR_STATUS='DLTD'";
               }
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
