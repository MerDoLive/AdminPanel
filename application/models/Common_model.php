<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model
{
    //common for all
    public function insert_record($table,$values)
	{		
		$this->db->insert($table,$values);
		return $this->db->insert_id();	
	}
	
    public function insert_records($table,$values)
	{		
		$this->db->insert_batch($table,$values);
	}
	
	public function update_record($table,$values,$where = '')
	{
		if($where)
			$this->db->where($where); 	
		$this->db->update($table,$values);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	public function update_where_in($table,$values,$col,$where_in, $where = '')
	{
		if($where)
			$this->db->where($where);
		if(!empty($where_in))
				$this->db->where_in($col,$where_in);
		$this->db->update($table,$values);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	public function delete_record($table,$where)
	{
		 $this->db->delete($table, $where); 
	}
	
	//Select the single record from db
	public function get_record($table,$fields='*',$where='')
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			return $this->db->get($table)->row();					
	}
	
	//Select the single record from db with or condition
	public function get_record_or($table,$fields='*',$where='',$orwhere='')
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			if(!empty($orwhere))
				$this->db->or_where($orwhere);
			return $this->db->get($table)->row();					
	}
	
	//Select the multiple records from db
	public function get_records($table,$fields='*',$where='')
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			return $this->db->get($table)->result();		
			
	}
	
	//Select the multiple records from db using Where Class in
	public function get_records_in($table,$fields='*',$col, $where_in, $where="")
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where_in))
				$this->db->where_in($col,$where_in);
            if(!empty($where))
				$this->db->where($where);
			return $this->db->get($table)->result();		
			
	}
	
	public function get_records_in_orderby($table,$fields='*',$col, $where,$orderby,$type = 'ASC')
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where_in($col,$where);
			$this->db->order_by($orderby, $type); 
			return $this->db->get($table)->result();		
			
	}
	
	//Select the multiple records from db using Where Class Not in
	public function get_records_notin($table, $fields='*', $where, $ncol, $narray)
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			if(!empty($narray))
				$this->db->where_not_in($ncol, $narray);
			return $this->db->get($table)->result();		
			
	}
	
	public function get_records_notin_orderby_limit($table, $fields='*', $where, $ncol, $narray,$orderby,$type,$from,$to)
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			if(!empty($narray))
				$this->db->where_not_in($ncol, $narray);
			if(!empty($orderby))
			$this->db->order_by($orderby, $type); 
			$this->db->limit($from, $to);
			return $this->db->get($table)->result();		
			
	}
	
	
	//Select the multiple records from db
	public function get_records_unique($table,$fields='*',$where='')
	{
			if($fields)
				$this->db->distinct();
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			return $this->db->get($table)->result();		
			
	}
	
	
	//Select the count multiple records from db
	public function get_records_count($table,$fields='*',$where='')
	{
		if(!empty($where))
			$this->db->where($where);
		$this->db->from($table);
		return $this->db->count_all_results();	

	}
	
	//Select the multiple record from db
	public function get_records_order_by($table,$fields='*',$where='',$orderby,$type = 'ASC')
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			$this->db->order_by($orderby, $type); 
			return $this->db->get($table)->result();			
	}
	
	
	//Recordes Order By Limit
	public function get_records_orderby_limit($table, $fields='*', $where, $orderby,$type,$limit,$start){
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			if(!empty($narray))
				$this->db->where_not_in($ncol, $narray);
			if(!empty($orderby))
			$this->db->order_by($orderby, $type); 
			$this->db->limit($limit, $start);
			return $this->db->get($table)->result();		
	}
	
	//Select the records from table using group By
	public function get_records_group_by($table,$fields='*',$where="",$group_col,$in_col="",$where_in="")
	{
			if($fields)
                $this->db->select($fields);
			if(!empty($where))
                $this->db->where($where);
            if(!empty($where_in))
				$this->db->where_in($in_col,$where_in);
        
			$this->db->group_by($group_col);
			return $this->db->get($table)->result();			
	}
	
	//Select the record from table using group By Single Row Result
	public function get_record_group_by($table,$fields='*',$where="",$group_col,$in_col="",$where_in="")
	{
			if($fields)
                $this->db->select($fields);
			if(!empty($where))
                $this->db->where($where);
            if(!empty($where_in))
				$this->db->where_in($in_col,$where_in);
        
			$this->db->group_by($group_col);
			return $this->db->get($table)->row();			
	}

	public function get_records_orderby_banner($table,$fields='*',$where,$orderby,$type = 'DESC',$limit)
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			$this->db->order_by($orderby, $type); 
			$this->db->limit($limit);
			return $this->db->get($table)->result();		
			
	}

	public function get_record_orderby($table,$fields='*',$where,$orderby,$type = 'DESC')
	{
			if($fields)
				$this->db->select($fields);
			if(!empty($where))
				$this->db->where($where);
			$this->db->order_by($orderby, $type); 
			return $this->db->get($table)->row();			
	}

}