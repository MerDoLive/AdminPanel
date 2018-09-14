<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products_model extends CI_Model
{
	var $column_search = array('PRODUCT_MSTR.PRODUCT_MSTR_PRODUCT_ID','PRODUCT_MSTR.PRODUCT_MSTR_PRODUCT_NAME','PRODUCT_MSTR.PRODUCT_MSTR_PRODUCT_DESC','PRODUCT_MSTR.PRODUCT_MSTR_CREATED_BY','PRODUCT_MSTR.PRODUCT_MSTR_CREATED_TIME','PRODUCT_MSTR.PRODUCT_MSTR_BRAND_NAME','PRODUCT_MSTR.PRODUCT_MSTR_STATUS'); 
	function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query($cond2)
	{
		$this->db->select('*');
		$this->db->from('PRODUCT_MSTR');

		$i = 0;

	    foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
             if($cond2)
             {
             	
                	$cond  = "PRODUCT_MSTR.PRODUCT_MSTR_STATUS='".$cond2."'";	
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
		$order_data = "PRODUCT_MSTR.PRODUCT_MSTR_PRODUCT_ID ".$order_by;
	}
	if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 2 ){
		$order_data = "CATG_MSTR.CATG_MSTR_CATEGORY_NAME ".$order_by;
	}
	if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 3 ){
		$order_data = "PRODUCT_MSTR.PRODUCT_MSTR_PRODUCT_NAME ".$order_by;
	}
	if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 4 ){
		$order_data = "PRODUCT_MSTR.PRODUCT_MSTR_PRODUCT_DESC".$order_by;
	}
	if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 5 ){
		$order_data = "PRODUCT_MSTR.PRODUCT_MSTR_CREATED_BY ".$order_by;
	}
	if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 6 ){
		$order_data = "PRODUCT_MSTR.PRODUCT_MSTR_CREATED_TIME ".$order_by;
	}
		if(!empty($_POST['order']) && $_POST['order']['0']['column'] == 10 ){
			$order_data = "PRODUCT_MSTR.PRODUCT_MSTR_STATUS; ".$order_by;
	}
	$this->db->order_by($order_data);
	// sort code end

		$query = $this->db->get();
		return $query->result();
	}

	public function count_all($cond2)
	{    
	    $this->db->from('PRODUCT_MSTR');
	    if($cond2)
             {
             	
                	$cond  = "PRODUCT_MSTR.PRODUCT_MSTR_STATUS='".$cond2."'";	
                	
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

	function GetCatData($id){
		$this->db->select('CATG_MSTR.CATG_MSTR_CATEGORY_ID,CATG_MSTR.CATG_MSTR_CATEGORY_NAME');
		$this->db->from('CATG_SUB_CATG_MAP');
		$this->db->join('CATG_MSTR','CATG_SUB_CATG_MAP.CATG_SUB_CATG_MAP_CATEGORY_ID=CATG_MSTR.CATG_MSTR_CATEGORY_ID','left');
		$this->db->where("CATG_SUB_CATG_MAP.CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID='".$id."'");
 		return $this->db->get()->result();
	}
	function add_product($category_id,$category_name,$product_name,$prdt_attr,$prdt_attr_val,$prdt_attr_name,$prdt_attr1,$prdt_attr_val1,$prdt_attr_name1,$prdt_attr2,$prdt_attr_val2,$prdt_attr_name2,$brand_id,$brand_name)
	{
		/*print_r($prdt_attr);
		print_r($prdt_attr_val);
		print_r($prdt_attr_name);
		exit();*/
		//error_reporting(1);
		

		foreach($prdt_attr_val1 as $color)
		{
		$dataProcedure = $this->db->query("SELECT GET_SEQ('PRDT')");
		$result = $dataProcedure->row();
		foreach ($result as $value) 
		{
			$pro_id = $value;
		}
		

		//print_r("INSERT INTO PRODUCT_MSTR(PRODUCT_MSTR_PRODUCT_ID,PRODUCT_MSTR_CATEGORY_ID,PRODUCT_MSTR_PRODUCT_NAME,PRODUCT_MSTR_BRAND_NAME,PRODUCT_MSTR_BRAND_id,PRODUCT_MSTR_STATUS) VALUES ('$pro_id','$category_id','$product_name','$brand_id','$brand_name','PNDG')");
		//exit();

		$this->db->query("INSERT INTO PRODUCT_MSTR(PRODUCT_MSTR_PRODUCT_ID,PRODUCT_MSTR_CATEGORY_ID,PRODUCT_MSTR_PRODUCT_NAME,PRODUCT_MSTR_BRAND_NAME,PRODUCT_MSTR_BRAND_id,PRODUCT_MSTR_STATUS) VALUES ('$pro_id','$category_id','$product_name','$brand_id','$brand_name','PNDG')");
		$i=0;
		foreach($prdt_attr as $val)
		{
			if($prdt_attr_val[$i]!='' && $prdt_attr_val[$i]!='0' && $prdt_attr_val[$i]!=' '){


			$this->db->query("INSERT INTO PRODUCT_ATTR_MAP(PRODUCT_ATTR_MAP_PRODUCT_ID, PRODUCT_ATTR_MAP_CATEGORY_ID,PRODUCT_ATTR_MAP_CATEGORY_NAME, PRODUCT_ATTR_MAP_ATTR_ID,PRODUCT_ATTR_MAP_ATTR_NAME, PRODUCT_ATTR_MAP_ATTR_VALUES) VALUES('$pro_id','$category_id','$category_name','$val','$prdt_attr_name[$i]','$prdt_attr_val[$i]')");
			//print_r("INSERT INTO PRODUCT_ATTR_MAP(PRODUCT_ATTR_MAP_PRODUCT_ID, PRODUCT_ATTR_MAP_CATEGORY_ID,PRODUCT_ATTR_MAP_CATEGORY_NAME, PRODUCT_ATTR_MAP_ATTR_ID,PRODUCT_ATTR_MAP_ATTR_NAME, PRODUCT_ATTR_MAP_ATTR_VALUES) VALUES('$pro_id','$category_id','$category_name','$val','$prdt_attr_name[$i]','$prdt_attr_val[$i]')");
			}
			$i++;
		}
		$i=0;
		foreach($prdt_attr1 as $val)

		{
			if($val!='' && $val!='0'&& $val[$i]!=' '){
			if($prdt_attr_val1[$i]!='' && $prdt_attr_val1[$i]!='0'&& $prdt_attr_val1[$i]!=' '){


			$this->db->query("INSERT INTO PRODUCT_ATTR_MAP(PRODUCT_ATTR_MAP_PRODUCT_ID, PRODUCT_ATTR_MAP_CATEGORY_ID,PRODUCT_ATTR_MAP_CATEGORY_NAME, PRODUCT_ATTR_MAP_ATTR_ID,PRODUCT_ATTR_MAP_ATTR_NAME, PRODUCT_ATTR_MAP_ATTR_VALUES) VALUES('$pro_id','$category_id','$category_name','$val','$prdt_attr_name1[$i]','$color')");
			//	print_r("INSERT INTO PRODUCT_ATTR_MAP(PRODUCT_ATTR_MAP_PRODUCT_ID, PRODUCT_ATTR_MAP_CATEGORY_ID,PRODUCT_ATTR_MAP_CATEGORY_NAME, PRODUCT_ATTR_MAP_ATTR_ID,PRODUCT_ATTR_MAP_ATTR_NAME, PRODUCT_ATTR_MAP_ATTR_VALUES) VALUES('$pro_id','$category_id','$category_name','$val','$prdt_attr_name1[$i]','$color')");
			}
		}
			$i++;
		}
	}
	}
	function update_product($pro_id,$category_id,$category_name,$product_name,$prdt_attr,$prdt_attr_val,$prdt_attr_name,$status,$brand_id,$brand_name)
	{
		//error_reporting(1);
		//$this->db->query("INSERT INTO PRODUCT_MSTR(PRODUCT_MSTR_PRODUCT_ID,PRODUCT_MSTR_CATEGORY_ID,PRODUCT_MSTR_PRODUCT_NAME) VALUES ('$pro_id','$category_id','$product_name')");
		$i=0;
		foreach($prdt_attr as $val)
		{
			if($prdt_attr_val[$i]){

			$s=$this->db->query("SELECT * FROM PRODUCT_ATTR_MAP WHERE PRODUCT_ATTR_MAP_PRODUCT_ID='$pro_id' AND PRODUCT_ATTR_MAP_ATTR_ID='$val'");
			/*$this->db->select('*');
			$this->db->from('PRODUCT_ATTR_MAP');
			$this->db->where("PRODUCT_ATTR_MAP_PRODUCT_ID='".$pro_id."' AND PRODUCT_ATTR_MAP_ATTR_ID='".$VAL."'");
			if($this->db->get()->result())
 			{*/
 			$NUM_ROW=$s->num_rows();
			$this->db->query("UPDATE PRODUCT_MSTR SET PRODUCT_MSTR_STATUS='$status',PRODUCT_MSTR_BRAND_ID='$brand_id',PRODUCT_MSTR_BRAND_NAME='$brand_name'
				WHERE PRODUCT_MSTR_PRODUCT_ID='$pro_id'");
 			if($NUM_ROW>0){
			$this->db->query("UPDATE PRODUCT_ATTR_MAP SET PRODUCT_ATTR_MAP_ATTR_NAME='$prdt_attr_name[$i]', PRODUCT_ATTR_MAP_ATTR_VALUES='$prdt_attr_val[$i]',PRODUCT_ATTR_MAP_STATUS='$status'
				WHERE PRODUCT_ATTR_MAP_PRODUCT_ID='$pro_id' AND PRODUCT_ATTR_MAP_ATTR_ID='$val'");
			}
			else
			{
			$this->db->query("INSERT INTO PRODUCT_ATTR_MAP(PRODUCT_ATTR_MAP_PRODUCT_ID, PRODUCT_ATTR_MAP_CATEGORY_ID,PRODUCT_ATTR_MAP_CATEGORY_NAME, PRODUCT_ATTR_MAP_ATTR_ID,PRODUCT_ATTR_MAP_ATTR_NAME, PRODUCT_ATTR_MAP_ATTR_VALUES) VALUES('$pro_id','$category_id','$category_name','$val','$prdt_attr_name[$i]','$prdt_attr_val[$i]')");	
			}
			}
			$i++;
		}
	}




}