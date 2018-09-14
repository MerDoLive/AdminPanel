<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_brand_maps extends CI_Controller {

	function __construct()
   	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Category_brand_maps_model');
        $this->load->model('Crud_model');		
   	}

	public function index()
	{
        $data = array('heading'=>'Category Brand Maps');
		$this->load->view('category_brand_maps/list',$data);
	}

	public function ajax_manage_page()
    {  	
		$userData = $this->Category_brand_maps_model->get_datatables();
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
             $no =$_POST['start'];
        }
		$data = array();		
		foreach ($userData as $usersData) 
		{
            $btn = anchor(site_url('Category_brand_maps/update/'.$usersData->CATG_BRND_MAP_BRAND_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .=' | '.'<a href="#deleteData" data-toggle="modal" title="Delete" class="btn btn-sm btn-danger waves-effect" onclick="checkStatus('.$usersData->CATG_BRND_MAP_BRAND_ID.')"><i class="zmdi zmdi-delete"></i></a>';
            if($usersData->CATG_BRND_MAP_STATUS =='LIVE')
            {
                $status =  "<span class='label-success label'>".$usersData->CATG_BRND_MAP_STATUS."</span>";            
            }else if($usersData->CATG_BRND_MAP_STATUS =='PNDG')
            {
                 $status =  "<span class='label-primary label'>".$usersData->CATG_BRND_MAP_STATUS."</span>";  
            }else if($usersData->CATG_BRND_MAP_STATUS =='REJ')
            {
                 $status =  "<span class='label-warning label'>".$usersData->CATG_BRND_MAP_STATUS."</span>";  
            }else
            {
                 $status =  "<span class='label-danger label'>".$usersData->CATG_BRND_MAP_STATUS."</span>";  
            }


			$no++;
			$nestedData = array();
		    $nestedData[] = $no;
            $nestedData[] = $usersData->CATG_MSTR_CATEGORY_NAME;
            $nestedData[] = $usersData->BRND_MSTR_BRAND_NAME;
            $nestedData[] = $status;
		    $nestedData[] = $btn;
		    $data[] = $nestedData;
		}

		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->Category_brand_maps_model->count_all(),
					"recordsFiltered" => $this->Category_brand_maps_model->count_filtered(),
					"data" => $data,
				);
		echo json_encode($output);
    }

       
    public function delete() 
    {
        $row = $this->Crud_model->GetData('ATTR_MSTR','',"id='".$_POST['id']."'",'','','','single');
        if($row) 
        {
            $this->Crud_model->DeleteData('ATTR_MSTR',"id='".$_POST['id']."'");
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record Deleted Successfully.</p></div>');
            redirect(site_url('Attr_Masters'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Category_brand_maps'));
        }
    }

    public function create()
    {
        $brand_mstr = $this->Crud_model->GetData('BRND_MSTR','',"",'','');
        $allCategory = $this->Crud_model->GetData('CATG_MSTR','',"",'','');
        $data = array('heading'=>'blogs',
    				'subheading'=>'Category Brands Maps',
    				'button'=>'Submit',
                    'action'=>site_url('Category_brand_maps/create_action'),
                    'brands'=>$brand_mstr,
                    'mainCategory'=>$allCategory,
                    'id' => set_value('id'),
                    'mainCategoryId' => set_value('mainCategoryId'),
                    'brandId' => set_value('brandId'),
    			);
    	$this->load->view('category_brand_maps/form',$data);
    }

    public function create_action() 
    {
        $dataArray= array(
                        'CATG_BRND_MAP_BRAND_ID'=>$_POST['brandId'],
                        'CATG_BRND_MAP_CATEGORY_ID'=>$_POST['maincategoryId'],
                     );
        $this->Crud_model->SaveData('CATG_BRND_MAP',$dataArray);
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
        redirect(site_url('Category_brand_maps'));
    }

    public function update($id)
    {
    	$getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$id."'",'','','','single');
        $getAttrValue = $this->Crud_model->GetData('ATTR_VALUES','',"ATTR_VALUES_ATTR_ID='".$id."'",'','','','single');
        $data = array('heading'=>'Attr',
    				'subheading'=>'Edit Attr',
    				'button'=>'Update',
                    'action'=>site_url('Category_brand_maps/update_action'),
                    'name' => set_value('name',$getUsers->ATTR_MSTR_ATTR_NAME),
                    'status' => set_value('ATTR_MSTR_ATTR_STATUS',$getUsers->ATTR_MSTR_ATTR_STATUS),
                    'id' => set_value('id',$id),
    			);
    	$this->load->view('category_brand_maps/form',$data);
    }

    public function update_action()
    {
        $getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$_POST['id']."'",'','','','single'); 
        $dataArray= array('ATTR_MSTR_ATTR_NAME'=>$_POST['name'],
                            'ATTR_MSTR_ATTR_DESC'=>$_POST['desc'],
                            'ATTR_MSTR_ATTR_STATUS'=>$_POST['status'],
                          );
        $this->Crud_model->SaveData('ATTR_MSTR',$dataArray,"ATTR_MSTR_ATTR_ID='".$_POST['id']."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been updated successfully.</p></div>');
        redirect(site_url('Category_brand_maps'));
    }
	public function changeStatus()
    {
        $getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"id='".$_POST['id']."'",'','','','single');
        if($getUsers->status=='Active')
        {
            $this->Crud_model->SaveData('ATTR_MSTR',array('status'=>'Inactive'),"id='".$_POST['id']."'");
        }
        else
        {
            $this->Crud_model->SaveData('ATTR_MSTR',array('status'=>'Active'),"id='".$_POST['id']."'");
        }
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Status has been changed successfully.</p></div>');
        redirect(site_url('Category_brand_maps'));
    }  
}