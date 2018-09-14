<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shop_model extends CI_Model
{
	public function subcat_list($cid=0){
	}
	
	public function parentcat_list($pnode=0){
	}
	
	public function parent_list($cid=0){
	}
	
	public function product_list($categories, $start=0, $limit=12, $brand='', $price_range='', $discount, $sort, $rating, $promotions){
	}
	
	public function product_detail($pro_id){
	}
	
	public function pro_detail($pro_id){		
	}
	
	public function pro_attributes($pro_id){		
	}
	
	public function seller_store($seller_id){
	}
	
	public function brand_products($brand_id){
	}
	
	public function cat_brand_products($brand_id,$category_id){
	}
	
	
	public function category_brands($categories){
	}
	
	public function related_products($cpro_sku,$category_id){		
	}
	
	public function recent_view_products($userid,$cpro_sku){		
	}
	
	public function recent_images($userid){
	}
	
	public function whishlist_products($product_id){
		
	}	
		
	public function product_special_price($sku_id){	
	}
		
	public function cart_products(){	
	}
	
	public function product_availability($product_sku_id){
	}
	
	public function prosearch_brand($like){
        $qry="select b.brand_name, c.category_name,p.* from (SELECT `category_id`, `brand_id` FROM `products` group by brand_id, category_id)p, categories c, brands b where b.brand_id=p.brand_id and c.category_id=p.category_id and b.brand_name like '%$like%' limit 0,5";
		$result=$this->db->query($qry)->result();
		return $result;
	}
	
	public function prosearch_cat($like){
		$this->db->select("distinct(`category_id`),(SELECT category_name from categories c WHERE c.category_id=p.category_id)category_name ,model");
		$this->db->from("products p");
		$this->db->like("model",$like);
        $this->db->limit(3, 0);
		$result=$this->db->get()->result();
		return $result;
	}
	
	public function prosearch_products($like){
		$this->db->select("ps.product_id, ps.product_sku_id, ps.product_price, p.value as product_name");
		$this->db->from("`product_sku_base` ps");
		$this->db->join("product_attributes p", "ps.product_id=p.product_id");
		$this->db->where("p.attribute_id",10);
		$this->db->like("p.value",$like);
        $this->db->limit(3, 0);
		$result=$this->db->get()->result();
		return $result;
	}
	
	public function search_cat($like){
		$this->db->select("category_id,category_name");
		$this->db->from("categories");
		$this->db->like("category_name",$like);
        $this->db->limit(3, 0);
		$result=$this->db->get()->result();
		return $result;
	}
	
	public function cus_delprice(){
		//SELECT ut.*,ps.value as weigh,lp.customer_price, (lp.customer_price * ut.quantity)product_delivery_price FROM `user_cart_table` ut,`product_sku` ps, `logistics_pricing` lp WHERE ps.`attribute_id`=23 AND ut.product_id=ps.product_id AND ut.sku_id=ps.sku_id AND ut.value_id=ps.value_id and ps.value >lp.weight_from and ps.value<=lp.weight_to;
		
		$customerid=customerid();
		$this->db->select("ut.*,ps.value as weigh,lp.customer_price, (lp.customer_price * ut.quantity)product_delivery_price");
		$this->db->from("`user_cart_table` ut");
		$this->db->join("product_sku ps", "ut.product_id=ps.product_id AND ut.sku_id=ps.sku_id AND ut.value_id=ps.value_id");		
		$this->db->join("`logistics_pricing` lp", "ps.value >lp.weight_from and ps.value<=lp.weight_to");		
		
		$this->db->where('ut.user_id',$customerid);
		$this->db->where('ut.cart_status',1);
		$this->db->where('ps.attribute_id',23);
		$result=$this->db->get()->result();
		return $result;
	}
	
	public function cart_delprice($product_id=""){
		//$this->db->query("SELECT ps.product_id, ps.value as weigh,MAX(lp.customer_price) FROM `product_sku` ps, `logistics_pricing` lp WHERE (ps.`attribute_id`=23 AND ps.value >lp.weight_from and ps.value<=lp.weight_to) OR (ps.`attribute_id`=24 AND ps.value >lp.length_from and ps.value<=lp.length_to) GROUP BY ps.product_id");
		
		$this->db->select("ps.product_id, MAX(lp.customer_price)delprice");
		$this->db->from("`product_sku` ps");
		$this->db->from("`logistics_pricing` lp");
		

		
		$this->db->group_start();
		$this->db->where('ps.`attribute_id`',23);
		$this->db->where('ps.value >lp.weight_from ');
		$this->db->where('ps.value<=lp.weight_to');
		$this->db->group_end();
		
		$this->db->or_group_start();
		$this->db->where('ps.`attribute_id`',24);
		$this->db->where('ps.value >lp.length_from');
		$this->db->where('ps.value<=lp.length_to');
		$this->db->group_end();
		$this->db->group_by('ps.product_id'); 
		if(!empty($product_id)){
			if(is_array($product_id)){
				$pro = implode(',', $product_id);
				$this->db->having("ps.product_id in (".$pro.")");
			}
			else {
				$this->db->having('ps.product_id', $product_id); 
			}
		}
		$result=$this->db->get()->result_array();
		return $result;
	}
	
	public function order_stock_update($pro_quantity, $where){
		/*********Sku Table Update************/
		$this->db->set('value', 'value-'.$pro_quantity,FALSE);
		$this->db->where($where);
		$this->db->where("attribute_id",16);
		$this->db->update('product_sku');
		$this->db->trans_complete();
		
		/******** Sku Base Table Update************/
		$this->db->set('product_quantity', 'product_quantity-'.$pro_quantity,FALSE);
		$this->db->where($where);
		$this->db->update('product_sku_base');
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	// public function merzido_menu(){
 //        $this->db->select("category_id, category_name");
	// 	$this->db->where('`parent_id`',0);	
	// 	$this->db->where('`status`',1);	
	// 	$pro_fcat= $this->db->get('categories')->result();
 //        $f_cat = array_map('current', $pro_fcat);

 //        $this->db->select("category_id,category_name,parent_id");
	// 	$this->db->where('`status`',1);	
 //        $this->db->where_in("parent_id",$f_cat);
 //        $this->db->order_by('parent_id','asc');
 //        $pro_scat= $this->db->get('categories')->result();
 //        $s_cat = array_map('current', $pro_scat);
        
 //        $this->db->select("category_id,category_name,parent_id");
	// 	$this->db->where('`status`',1);	
 //        $this->db->where_in("parent_id",$s_cat);
 //        $this->db->order_by('parent_id','asc');
 //        $pro_tcat= $this->db->get('categories')->result();
        
 //        $result= new stdClass();
 //        $result->first_level=$pro_fcat;
 //        $result->second_level=$pro_scat;
 //        $result->third_level=$pro_tcat;
        
 //        return($result);
	// }

	public function merzido_menu(){
        $this->db->select("CATG_MSTR_CATEGORY_ID, CATG_MSTR_CATEGORY_NAME");
        $this->db->from('CATG_MSTR');
		$this->db->where('`CATG_MSTR_CATEGORY_LEVEL`',1);	
		$this->db->where('`CATG_MSTR_STATUS`','LIVE');	
		$pro_fcat= $this->db->get()->result();
        $f_cat = array_map('current', $pro_fcat);

        $this->db->select("CATG_MSTR_CATEGORY_ID,CATG_MSTR_CATEGORY_NAME,CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID");
        $this->db->from('CATG_MSTR');
		$this->db->where('`CATG_SUB_CATG_MAP_STATUS`','LIVE');
		$this->db->join('CATG_SUB_CATG_MAP', 'CATG_MSTR.CATG_MSTR_CATEGORY_ID = CATG_SUB_CATG_MAP.CATG_SUB_CATG_MAP_CATEGORY_ID', 'left');	
        $this->db->where_in("CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID",$f_cat);
        $this->db->order_by('CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID','asc');
        $pro_scat= $this->db->get()->result();
        $s_cat = array_map('current', $pro_scat);
        
        $this->db->select("CATG_MSTR_CATEGORY_ID,CATG_MSTR_CATEGORY_NAME,CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID");
        $this->db->from('CATG_MSTR');
		$this->db->where('`CATG_SUB_CATG_MAP_STATUS`','LIVE');	
        $this->db->where_in("CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID",$s_cat);
        $this->db->join('CATG_SUB_CATG_MAP', 'CATG_MSTR.CATG_MSTR_CATEGORY_ID = CATG_SUB_CATG_MAP.CATG_SUB_CATG_MAP_CATEGORY_ID', 'left');	
        $this->db->order_by('CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID','asc');
        $pro_tcat= $this->db->get()->result();
        
        $result= new stdClass();
        $result->first_level=$pro_fcat;
        $result->second_level=$pro_scat;
        $result->third_level=$pro_tcat;
        
        return($result);
	}
    
    public function time_deals($deal_id){

	/*
        $this->db->select('ps.*,dt.deal_id,dt.percentage, coalesce(sp.`price`,ps.`product_price`) as `special_price`, round(((ps.product_price-coalesce(sp.`price`,ps.`product_price`))/ps.product_price)*100) as `discount`');
		$this->db->from('`deals_time_products` dt');
		$this->db->join('`product_sku_base` ps', 'dt.product_id=ps.product_id and dt.sku_id=ps.sku_id and dt.value_id=ps.value_id');
        $this->db->join("(SELECT `product_id`, `sku_id`, `value_id`, min(`price`)price FROM `product_sale_price` WHERE date(now()) BETWEEN `start_date` AND `end_date` group by product_id, value_id) sp", "ps.product_id =sp.product_id and ps.sku_id =sp.sku_id and ps.value_id =sp.value_id", "left outer");	
        
		$this->db->where_in('dt.deal_id',$deal_id);
		$this->db->limit(30,0);
		$result=$this->db->get()->result();
		return $result;
	*/
    }
    
    public function daily_deals($deal_id){
	}
}
