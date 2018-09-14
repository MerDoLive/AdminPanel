<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);

class Seller_Request extends CI_Controller {

	function __construct()
   	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Seller_request_model');
        $this->load->model('Crud_model');		
   	}

	public function index($cond2)
	{
        $data = array('heading'=>'Seller Requests','cond2'=>$cond2);
        $this->load->view('seller_request/list',$data);
	}
    public function ajax_manage_page($cond2)
    {  	
		$userData = $this->Seller_request_model->get_datatables($cond2);
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
             $no =$_POST['start'];
        }
		$data = array();		
		foreach ($userData as $usersData) 
		{
            $btn = anchor(site_url('Seller_Request/update/'.$usersData->SELR_REGISTR_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .= ' | ' .anchor(site_url('Seller_Request/delete/'.$usersData->SELR_REGISTR_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            if($usersData->SELR_REGISTR_status=='ACTIVE')
            {
                $status =  "<button class='label-success label'>Active</button>";            
            }
            else if($usersData->SELR_REGISTR_status=='PNDG')
            {
                $status =  "<button class='label-info label'>PNDG</button>";
            } 
            else if($usersData->SELR_REGISTR_status=='DISABLED')
            {
            	$status =  "<button class='label-warning label'>Disabled</button>";
            } 

			$no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $usersData->SELR_REGISTR_ID;
            $nestedData[] = $usersData->SELR_REGISTR_seller_firstname;
		    $nestedData[] = $usersData->SELR_REGISTR_seller_lastname;
		    $nestedData[] = $usersData->SELR_REGISTR_seller_email;
			$nestedData[] = $usersData->SELR_REGISTR_seller_mobile;
			$nestedData[] = $usersData->SELR_REGISTR_createdTime;
            $nestedData[] = $status;
		    $nestedData[] = $btn;
            $data[] = $nestedData;
            
		}
        
        $output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->Seller_request_model->count_all(),
					"recordsFiltered" => $this->Seller_request_model->count_filtered(),
					"data" => $data,
                );
		echo json_encode($output);
    }
}
