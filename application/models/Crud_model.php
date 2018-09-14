<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	

	public function GetData($table,$field='',$condition='',$group='',$order='',$limit='',$result='')
    {
        if($field != '')
        $this->db->select($field);
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        if($result != '')
        {
            $return =  $this->db->get($table)->row();
        }else{
            $return =  $this->db->get($table)->result();
        }
        return $return;
    }

    public function GetDataArr($table,$field='',$condition='',$group='',$order='',$limit='',$result='')
    {
        if($field != '')
        $this->db->select($field);
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        if($result != '')
        {
            $return =  $this->db->get($table)->row_array();
        }else{
            $return =  $this->db->get($table)->result_array();
        }
        return $return;
    }

	public function SaveData($table,$data,$condition='')
    {
    	$DataArray = array();
        if(empty($condition))
        {
            $data['CREATED']= date("Y-m-d H:i:s");
            $data['MODIFIED']= date("Y-m-d H:i:s");
        }else{
            $data['MODIFIED']=date("Y-m-d H:i:s");
        }
        $table_fields = $this->db->list_fields($table);
        foreach($data as $field=>$value)
        {
            if(in_array($field,$table_fields))
            {
                $DataArray[$field]= $value;

            }
        }
       // print_r($data);
        if($condition != '')
    	{
    		$this->db->where($condition);
    		$this->db->update($table, $DataArray);
    	}else{
    		$this->db->insert($table, $DataArray);
    	}
       // echo $this->db->last_query(); die;
    }
    
    public function alttable($table_name,$name)
    {
       //$replaceName= preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $name);
       
       $this->db->query("ALTER TABLE ".$table_name." ADD ".$name." varchar2(255) NULL");
    }
    
    public function tableFiled($table)
    {
       //$filedName = $this->db->query("show COLUMNS from ".$table)->result();
       $filedName = $this->db->query("select column_name FROM  all_tab_cols WHERE  table_name = '".$table."'")->result();
       return $filedName;
    }

    public function DeleteData($table,$condition='',$limit='')
    {
       if($condition != '')
        $this->db->where($condition);
        if($limit != '')
        $this->db->limit($limit);
        $this->db->delete($table);
    }
    
    public function GetTableCount($table,$condition='')
    {
        $this->db->from($table);
        if($condition!='')
            $this->db->where($condition);
        return $this->db->count_all_results();
    }

    function getSingleData($tablename,$condition)
    {
        $this->db->where($condition);
        return $this->db->get($tablename)->row();
    }
   
}

?>