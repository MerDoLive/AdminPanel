<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	function __construct()
   	{
		parent::__construct();	
		$this->load->database();
		$this->load->model('Crud_model');
	}

	public function index()
	{
		$categories = $this->Crud_model->GetTableCount('CATG_MSTR');
		$brands = $this->Crud_model->GetTableCount('BRND_MSTR');
		$categoryType = $this->Crud_model->GetTableCount('CATG_TYPE_MSTR');
		$products = $this->Crud_model->GetTableCount('PRODUCT_MSTR');
		$users=$this->Crud_model->GetTableCount('USER_MSTR');
		$deals=$this->Crud_model->GetTableCount('DEAL_MSTR');
		$attributes=$this->Crud_model->GetTableCount('ATTR_MSTR');
		$data = array('countcategories'=>$categories,'countbrands'=>$brands,'countcategoryType'=>$categoryType,'countproducts'=>$products,'countusers'=>$users,'countdeals'=>$deals,'countattributes'=>$attributes);
		$this->load->view('dashboard',$data);
	}

}
