<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);


class Sellers extends CI_Controller {

	function __construct()
   	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Sellers_model');
        $this->load->model('Crud_model');		
   	}

	public function index($cond2)
	{
        $data = array('heading'=>'Sellers','cond2'=>$cond2);
        $this->load->view('sellers/list',$data);
    }

    public function ajax_manage_page($cond2)
    {  	
		$userData = $this->Sellers_model->get_datatables($cond2);
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
             $no =$_POST['start'];
        }
		$data = array();		
		foreach ($userData as $usersData) 
		{
            $btn = anchor(site_url('Sellers/update/'.$usersData->SELR_REGISTR_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .= ' | ' .anchor(site_url('Sellers/delete/'.$usersData->SELR_REGISTR_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            if($usersData->SELR_REGISTR_status=='ACTIVE')
            {
                $status =  "<button class='label-success label'>Active</button>";            
            }
            else if($usersData->SELR_REGISTR_status=='PNDG')
            {
                $status =  "<button class='label-warning label'>PNDG</button>";
            } 
            else if($usersData->SELR_REGISTR_status=='DISABLED')
            {
            	$status =  "<button class='label-danger label'>Disabled</button>";
            } 

			$no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $usersData->SELR_REGISTR_ID;
            $nestedData[] = $usersData->SELR_REGISTR_seller_firstname;
		    $nestedData[] = $usersData->SELR_REGISTR_seller_lastname;
		    $nestedData[] = $usersData->SELR_REGISTR_seller_email;
			$nestedData[] = $usersData->SELR_REGISTR_seller_mobile;
            $nestedData[] = $status;
		    $nestedData[] = $btn;
            $data[] = $nestedData;
            
		}
        
        $output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->Sellers_model->count_all(),
					"recordsFiltered" => $this->Sellers_model->count_filtered(),
					"data" => $data,
                );
		echo json_encode($output);
    }

	public function create()
	{
		$categories = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$id."'",'','','','single');
		$brands = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$id."'",'','','','single');
        $data = array('heading'=>'Seller',
    				'subheading'=>'Create Seller',
    				'button'=>'Submit',
                    'action'=>site_url('Sellers/create_action'),
                    'seller_firstname'=>set_value('seller_firstname'),
                    'seller_lastname'=>set_value('seller_lastname'),
                    'seller_email' => set_value('seller_email'),
                    'seller_mobile' => set_value('seller_mobile'),
                    'compnay_name' => set_value('compnay_name'),
                    'buissness_reg_no' => set_value('buissness_reg_no'),
					'bank_account_name' => set_value('bank_account_name'),
					'bank_name' => set_value('bank_name'),
					'bank_account_no' => set_value('bank_account_no'),
					//'bank_codeno' => set_value('bank_codeno'),
					//'bank_other_code' => set_value('bank_other_code'),
					'company_address' => set_value('company_address'),
					'company_postal' => set_value('company_postal'),
					'company_office_no' => set_value('company_office_no'),
					'same_address' => set_value('same_address'),
					'warehouse_address' => set_value('warehouse_address'),
					'warehouse_postal' => set_value('warehouse_postal'),
					'warehouse_office_no' => set_value('warehouse_office_no'),

					'customercare_address' => set_value('customercare_address'),
					'customercare_postal' => set_value('customercare_postal'),
					'customercare_office_no' => set_value('customercare_office_no'),
					'gst_registered' => set_value('gst_registered'),
					'gst_number' => set_value('warehouse_postal'),

					'merzido_store_name' => set_value('merzido_store_name'),
					'merzido_category' =>set_value('merzido_category'),
					'seller_product_count' => set_value('seller_product_count'),
					'seller_brands' => set_value('merzido_store_name'),
					'seller_new_brands' => set_value('merzido_store_name'),
					'status' => set_value('PNDG'),
					'createdTime' => set_value('date("Y-m-d H:i:s")'),
                );  
        $this->load->view('sellers/form',$data);
	}

	public function create_action()
	{
		$categories = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$id."'",'','','','single');
		$brands = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$id."'",'','','','single');
			/* echo "<pre>";
			print_r($_POST);exit;
			echo "</pre>"; */
			$dataProcedure = $this->db->query("SELECT GET_SEQ('SELR')");
            $result = $dataProcedure->row();
            foreach ($result as $value) 
            $array[] = $value;
            //print_r($array);
            $dataArray= array('SELR_REGISTR_ID'=>$array[0],
                             'SELR_REGISTR_seller_firstname'=>$_POST['seller_firstname'],
                            'SELR_REGISTR_seller_lastname'=>$_POST['seller_lastname'],
                            'SELR_REGISTR_seller_email'=>$_POST['seller_email'],
                            'SELR_REGISTR_seller_mobile'=>$_POST['seller_mobile'],
							'SELR_REGISTR_compnay_name' =>$_POST['compnay_name'],
							'SELR_REGISTR_buissness_reg_no' =>$_POST['buissness_reg_no'],
							'SELR_REGISTR_bank_account_name' =>$_POST['bank_account_name'], 
							'SELR_REGISTR_bank_name' =>$_POST['bank_name'],
							'SELR_REGISTR_bank_account_no' =>$_POST['bank_account_no'],
							//'SELR_REGISTR_bank_codeno' =>'other',
							//'SELR_REGISTR_bank_other_code' =>'other',
							'SELR_REGISTR_company_address' =>$_POST['company_address'],
							'SELR_REGISTR_company_postal' =>$_POST['company_postal'],
							'SELR_REGISTR_company_office_no' =>$_POST['company_office_no'],              
							'SELR_REGISTR_same_address' =>$_POST['same_address'],
							'SELR_REGISTR_warehouse_address' =>$_POST['warehouse_address'],
							'SELR_REGISTR_warehouse_postal' =>$_POST['warehouse_postal'],
							'SELR_REGISTR_warehouse_office_no' =>$_POST['warehouse_office_no'],

							'SELR_REGISTR_customercare_address' =>$_POST['customercare_address'],
							'SELR_REGISTR_customercare_postal' =>$_POST['customercare_postal'],
							'SELR_REGISTR_customercare_office_no' =>$_POST['customercare_office_no'],
							'SELR_REGISTR_gst_registered' =>$_POST['gst_registered'],
							'SELR_REGISTR_gst_number' =>$_POST['gst_number'],

							'SELR_REGISTR_merzido_store_name' =>$_POST['merzido_store_name'],
							//'SELR_REGISTR_merzido_category' =>$_POST['merzido_category'],
							'SELR_REGISTR_merzido_category' =>1,
							'SELR_REGISTR_seller_product_count' =>$_POST['seller_product_count'],
							//'SELR_REGISTR_seller_brands' =>$_POST['seller_brands'],
							'SELR_REGISTR_seller_brands' =>1,
							'SELR_REGISTR_seller_new_brands' =>$_POST['seller_new_brands'],
							//'SELR_REGISTR_buissness_licence' =>$_POST['buissness_licence'],
							//'SELR_REGISTR_buissness_licence' =>1,
							//'SELR_REGISTR_bank_account' =>$_POST['bank_account'],
							//'SELR_REGISTR_bank_account' =>1,
							'SELR_REGISTR_status' =>'PNDG',
							'SELR_REGISTR_createdTime' =>date('d-m-Y'),
                        );
			if (!empty($_FILES['SELR_REGISTR_buissness_licence']["name"]))
			{
			$tmp=$_FILES['SELR_REGISTR_buissness_licence']["name"];
			$temp = explode(".", $tmp);
			$file_name = $temp[0].time().rand().".".end($temp);	
			$file_path="./site/seller_files/".$file_name;
			move_uploaded_file($_FILES['SELR_REGISTR_buissness_licence']["tmp_name"],$file_path);
			$dataArray['SELR_REGISTR_buissness_licence']= $file_name;
			//$data['buissness_licence']= $file_name;	
			}
		
			if (!empty($_FILES['SELR_REGISTR_bank_account']["name"]))
			{
			$tmp=$_FILES['SELR_REGISTR_bank_account']["name"];
			$temp = explode(".", $tmp);
			$file_name = $temp[0].time().rand().".".end($temp);	
			$file_path="./site/seller_files/".$file_name;
			move_uploaded_file($_FILES['SELR_REGISTR_bank_account']["tmp_name"],$file_path);
			$dataArray['SELR_REGISTR_bank_account']= $file_name;
			//$data['bank_account']=$file_name;	
			}
		
		/* $res=$this->Common_model->insert_record("SELR_REGISTR",$data);
		if($res){
			$this->session->set_flashdata('success', 'success');
		}
		else{
			$this->session->set_flashdata('error', 'Fail');
		}
		redirect('Sellers'); */
		/* echo "<pre>";
		print_r($dataArray);exit;
		echo "</pre>"; */
		$this->Crud_model->SaveData('SELR_REGISTR',$dataArray);
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
        redirect(site_url('Sellers'));
	}

	public function update($id)
    {
        $getSellers = $this->Crud_model->GetData('SELR_REGISTR','',"SELR_REGISTR_ID='".$id."'",'','','','single');
		$data = array('heading'=>'Users',
                    'subheading'=>'Edit Users',
                    'button'=>'Update',
                    'action'=>site_url('Users/update_action'),
                    'SELR_REGISTR_ID' => set_value('SELR_REGISTR_ID',$id),
					'seller_firstname' => set_value('seller_firstname',$getSellers->SELR_REGISTR_seller_firstname),
					'seller_lastname' => set_value('seller_lastname',$getSellers->SELR_REGISTR_seller_lastname),
                    'status' => set_value('status',$getUsers->SELR_REGISTR_status), 
                );
        $this->load->view('sellers/update',$data);
    }

    public function update_action() 
    {
        if(empty($id))
        {
            $id = $_POST['SELR_REGISTR_ID'];
        } 
        $getUsers = $this->Crud_model->GetData('SELR_REGISTR','',"SELR_REGISTR_ID='".$id."'",'','','','single');
        $dataArray= array(
                             'SELR_REGISTR_seller_lastname'=>$_POST['seller_firstname'],
                            'seller_lastname' =>$_POST['SELR_REGISTR_seller_lastname'],
                            'SELR_REGISTR_status' =>$_POST['status'],
                    );
        $this->Crud_model->SaveData('SELR_REGISTR',$dataArray,"SELR_REGISTR_ID='".$id."'");
        $this->session->set_flashdata('message', '<span class="label label-success" style="font-size:12px;">Record updated successfully</span>');
        redirect(site_url('Sellers'));
        
    }
    
    //For Deleting User
    public function delete($id) 
    { 
        /* $this->Crud_model->DeleteData('SELR_REGISTR',"SELR_REGISTR_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Record has been deleted successfully.</p></div>');
        redirect(site_url('Sellers')); */

        $dataArray= array('USER_MSTR_STATUS'=>'DISABLED');
		$this->Crud_model->SaveData('SELR_REGISTR',$dataArray,"SELR_REGISTR_ID='".$id."'");
		$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
		redirect('Sellers');
    }
}