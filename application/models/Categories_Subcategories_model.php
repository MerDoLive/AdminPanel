<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories_Subcategories_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	function get_category1_query($categoryType)
	{
		//$query = $this->db->query("SELECT CATG_MSTR_CATEGORY_ID,CATG_MSTR_CATEGORY_NAME FROM CATG_MSTR INNER JOIN CATG_SUB_CATG_MAP ON CATG_SUB_CATG_MAP_CATEGORY_ID=CATG_MSTR_CATEGORY_ID where CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID='".$categorylevel1Id."' AND CATG_MSTR_STATUS='LIVE'");
 
		$this->db->select('CATG_MSTR_CATEGORY_ID,CATG_MSTR_CATEGORY_NAME');
		$this->db->from('CATG_MSTR');
		$this->db->where("CATG_MSTR_CATEGORY_TYPE_ID='".$categoryType."' AND CATG_MSTR_STATUS='LIVE' AND CATG_MSTR_CATEGORY_LEVEL='1'");
		$query = $this->db->get();
		return $query->result();
	}
	function get_category2_query($categorylevel1Id)
	{
		//$query = $this->db->query("SELECT CATG_MSTR_CATEGORY_ID,CATG_MSTR_CATEGORY_NAME FROM CATG_MSTR INNER JOIN CATG_SUB_CATG_MAP ON CATG_SUB_CATG_MAP_CATEGORY_ID=CATG_MSTR_CATEGORY_ID where CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID='".$categorylevel1Id."' AND CATG_MSTR_STATUS='LIVE'");
 
		$this->db->select('CATG_MSTR_CATEGORY_ID,CATG_MSTR_CATEGORY_NAME');
		$this->db->from('CATG_MSTR');
		$this->db->join('CATG_SUB_CATG_MAP', "CATG_SUB_CATG_MAP_CATEGORY_ID=CATG_MSTR_CATEGORY_ID",'left');
		$this->db->where("CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID='".$categorylevel1Id."' AND CATG_MSTR_STATUS='LIVE'");
		$query = $this->db->get();
		return $query->result();
	}
	function get_values($categorylevel1Id,$categorylevel2Id,$categorylevel3Id,$group,$edit)
	{
 
		$this->db->select('ATTR_MSTR.ATTR_MSTR_ATTR_ID,ATTR_MSTR.ATTR_MSTR_ATTR_NAME,ATTR_VALUES.ATTR_VALUES_ATTR_VALUES,CATG_ATTR_MAP.CATG_ATTR_DISPLAY_TYPE,ATTR_VALUES.ATTR_VALUES_ATTR_ID');
		$this->db->from('CATG_ATTR_MAP');
		$this->db->join('ATTR_MSTR', "CATG_ATTR_MAP.CATG_ATTR_MAP_ATTR_ID=ATTR_MSTR.ATTR_MSTR_ATTR_ID");
		$this->db->join('ATTR_VALUES', "ATTR_VALUES.ATTR_VALUES_ATTR_ID=ATTR_MSTR.ATTR_MSTR_ATTR_ID");
		if($edit==1)
		{
			$this->db->where("(CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel1Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel2Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel3Id."')AND CATG_ATTR_MAP.CATG_ATTR_MAP_STATUS='LIVE' AND ATTR_VALUES.ATTR_VALUES_ATTR_VALUES!=''");
		
		}
		else
		{
			$this->db->where("(CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel1Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel2Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel3Id."')AND CATG_ATTR_MAP.CATG_ATTR_MAP_STATUS='LIVE' AND ATTR_VALUES.ATTR_VALUES_ATTR_VALUES!='' AND CATG_ATTR_MAP.CATG_ATTR_MAP_GROUP=".$group);
		}
		$query = $this->db->get();
		return $query->result();
	}
	function get_attribute($categorylevel1Id,$categorylevel2Id,$categorylevel3Id,$group,$edit)
	{
 
		$this->db->select('DISTINCT(ATTR_MSTR.ATTR_MSTR_ATTR_ID),CATG_ATTR_MAP.CATG_ATTR_MAP_MANDATORY,ATTR_MSTR.ATTR_MSTR_ATTR_NAME,CATG_ATTR_MAP.CATG_ATTR_DISPLAY_TYPE,ATTR_MSTR.ATTR_MSTR_ATTR_TYPE');
		$this->db->from('CATG_ATTR_MAP');
		$this->db->join('ATTR_MSTR', "CATG_ATTR_MAP.CATG_ATTR_MAP_ATTR_ID=ATTR_MSTR.ATTR_MSTR_ATTR_ID");
		if($edit==1)
		{
		
			$this->db->where("(CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel1Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel2Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel3Id."')AND CATG_ATTR_MAP.CATG_ATTR_MAP_STATUS='LIVE' AND CATG_ATTR_MAP.CATG_ATTR_DISPLAY_TYPE!=''");
		
		}
		else
		{
			$this->db->where("(CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel1Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel2Id."' OR CATG_ATTR_MAP.CATG_ATTR_MAP_CATEGORY_ID='".$categorylevel3Id."')AND CATG_ATTR_MAP.CATG_ATTR_MAP_STATUS='LIVE' AND CATG_ATTR_MAP.CATG_ATTR_DISPLAY_TYPE!='' AND CATG_ATTR_MAP.CATG_ATTR_MAP_GROUP=".$group);
		}

		$query = $this->db->get();
	//	print_r($this->db->last_query());
		return $query->result();
	}

}