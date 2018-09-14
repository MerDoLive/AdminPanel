<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Destinations_model extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query()
	{
		$this->db->select('destinations.*,categories.name as categoryName');
		$this->db->from('destinations');
		$this->db->join('categories',"categories.id=destinations.categoryId",'left');
		$i = 0;
	    if($_POST['search']['value']) // if datatable send POST for search
            {
                $explode_string = explode(' ', $_POST['search']['value']);
                foreach ($explode_string as $show_string) {
                    $cond  = " ";
                    $cond.=" ( destinations.destinationName LIKE '%".$show_string."%' ";
                    $cond.=" OR destinations.prize LIKE '%".$show_string."%' ";
                    $cond.=" OR categories.name LIKE '%".$show_string."%'  ) ";
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
	    $this->db->from('destinations');
	    return $this->db->count_all_results();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

}