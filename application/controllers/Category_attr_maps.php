<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_attr_maps extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Category_attr_maps_model');
		$this->load->model('Crud_model');		
	}

	public function index()
	{
		$data = array('heading'=>'Category Attr Maps');
		$this->load->view('category_attr_maps/list',$data);
	}

	public function ajax_manage_page()
	{  	
		$userData = $this->Category_attr_maps_model->get_datatables();
		if(empty($_POST['start']))
		{
			$no =0;   
		}else{
			$no =$_POST['start'];
		}
		$data = array();		
		foreach ($userData as $usersData) 
		{
			$btn = anchor(site_url('Category_attr_maps/update/'.$usersData->CATG_ATTR_MAP_CATEGORY),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
			$btn .=' | '.'<a href="#deleteData" data-toggle="modal" title="Delete" class="btn btn-sm btn-danger waves-effect" onclick="checkStatus('.$usersData->CATG_ATTR_MAP_CATEGORY.')"><i class="zmdi zmdi-delete"></i></a>';
			if($usersData->CATG_ATTR_MAP_STATUS =='LIVE')
			{
				$status =  "<span class='label-success label'>".$usersData->CATG_ATTR_MAP_STATUS."</span>";            
			}else if($usersData->CATG_ATTR_MAP_STATUS =='PNDG')
			{
				$status =  "<span class='label-primary label'>".$usersData->CATG_ATTR_MAP_STATUS."</span>";  
			}else if($usersData->CATG_ATTR_MAP_STATUS =='REJ')
			{
				$status =  "<span class='label-warning label'>".$usersData->CATG_ATTR_MAP_STATUS."</span>";  
			}else
			{
				$status =  "<span class='label-danger label'>".$usersData->CATG_ATTR_MAP_STATUS."</span>";  
			}


			$no++;
			$nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = $usersData->ATTR_MSTR_ATTR_NAME;
			$nestedData[] = $usersData->CATG_TYPE_MSTR_CATEGORY_TYPE;
			$nestedData[] = $status;
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}

		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Category_attr_maps_model->count_all(),
				"recordsFiltered" => $this->Category_attr_maps_model->count_filtered(),
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
			redirect(site_url('Attr_Masters'));
		}
	}

	public function create()
	{
		$allAttr = $this->Crud_model->GetData('ATTR_MSTR','',"",'','');
		$allCategory = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"",'','');
		$data = array('heading'=>'blogs',
				'subheading'=>'Category Attr Maps',
				'button'=>'Submit',
				'action'=>site_url('Category_attr_maps/create_action'),
				'attr'=>$allAttr,
				'mainCategory'=>$allCategory,
				'id' => set_value('id'),
				'mainCategoryId' => set_value('mainCategoryId'),
				'attrId' => set_value('attrId'),
			     );
		$this->load->view('category_attr_maps/form',$data);
	}

	public function create_action() 
	{
		$dataArray= array(
				'CATG_ATTR_MAP_CATEGORY'=>$_POST['maincategoryId'],
				'CATG_ATTR_MAP_ATTR_ID'=>$_POST['attrId'],
				);
		$this->Crud_model->SaveData('CATG_ATTR_MAP',$dataArray);
		$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
		redirect(site_url('Category_attr_maps'));

	}

	public function update($id)
	{
		$getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$id."'",'','','','single');
		$getAttrValue = $this->Crud_model->GetData('ATTR_VALUES','',"ATTR_VALUES_ATTR_ID='".$id."'",'','','','single');
		$data = array('heading'=>'Attr',
				'subheading'=>'Edit Attr',
				'button'=>'Update',
				'action'=>site_url('Attr_Masters/update_action'),
				'name' => set_value('name',$getUsers->ATTR_MSTR_ATTR_NAME),
				'value' => set_value('value',$getAttrValue->ATTR_VALUES_ATTR_VALUES),
				'desc' => set_value('desc',$getUsers->ATTR_MSTR_ATTR_DESC),
				'status' => set_value('ATTR_MSTR_ATTR_STATUS',$getUsers->ATTR_MSTR_ATTR_STATUS),
				'id' => set_value('id',$id),
			     );
		$this->load->view('category_attr_maps/form',$data);
	}

	public function update_action()
	{
		$getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$_POST['id']."'",'','','','single'); 
		$checkExists = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID!='".$_POST['id']."' and ATTR_MSTR_ATTR_NAME='".$_POST['name']."'",'','','','single');
		if(empty($checkExists))
		{
			$this->form_validation->set_rules('name', 'name', 'trim|regex_match[/^[a-zA-Z ]+$/]|required',
					array(
						'required' => 'Please enter name',
						'regex_match' => 'Please enter valid name',
					     )
					);
			if ($this->form_validation->run() == FALSE) {
				$this->update($_POST['id']);
			} 
			else 
			{
				$dataArray= array('ATTR_MSTR_ATTR_NAME'=>$_POST['name'],
						'ATTR_MSTR_ATTR_DESC'=>$_POST['desc'],
						'ATTR_MSTR_ATTR_STATUS'=>$_POST['status'],
						);
				$this->Crud_model->SaveData('ATTR_MSTR',$dataArray,"ATTR_MSTR_ATTR_ID='".$_POST['id']."'");

				$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been updated successfully.</p></div>');
				redirect(site_url('Attr_Masters'));
			}

		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Entered Attr already exists.</p></div>');
			redirect(site_url('Attr_Masters/update/'.$_POST['id']));
		}
	}

}
