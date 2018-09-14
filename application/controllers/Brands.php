<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
class Brands extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Brands_model');
		$this->load->model('Crud_model');		
	}

	public function index($cond2)
	{
		$all=$this->Brands_model->count_filtered('ALL');
        $live=$this->Brands_model->count_filtered('LIVE');
        $deleted=$this->Brands_model->count_filtered('DLTD');
        $rej=$this->Brands_model->count_filtered('REJ');
        $pndg=$this->Brands_model->count_filtered('PNDG');
		$data = array('heading'=>'Brand Management','cond2'=>$cond2,'live'=>$live,'all'=>$all,'deleted'=>$deleted,'rej'=>$rej,'pndg'=>$pndg);
		$this->load->view('brands/list',$data);
	}

	public function ajax_manage_page($cond2,$delete = null)
	{  	
		$userData = $this->Brands_model->get_datatables($cond2);
		if(empty($_POST['start']))
		{
			$no =0;   
		}
		else
		{
			$no =$_POST['start'];
		}
		$data = array();		
		foreach ($userData as $usersData) 
		{
			$allBrandCategory = $this->Brands_model->GetBrandData($usersData->BRND_MSTR_BRAND_ID);
			$value= '';
			$x=1;
			for ($i=0; $i < count($allBrandCategory); $i++) {
				$value .= $x. " ) ". $allBrandCategory[$i]->CATG_MSTR_CATEGORY_NAME."<br>"; 
                $x++;
			}
			$btn='';
            if($usersData->BRND_MSTR_STATUS!='DLTD')
            {

			$btn = anchor(site_url('Brands/update/'.$cond2.'/'.$usersData->BRND_MSTR_BRAND_ID),'<button type="button" title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
			$btn .= ' | '.anchor(site_url('Brands/view/'.$cond2.'/'.$usersData->BRND_MSTR_BRAND_ID),'<button type="button" title="View" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-eye"></i></button> |');
				}
			if($usersData->BRND_MSTR_STATUS=='DLTD')
            {
            $btn .=anchor(site_url('Brands/restore/'.$cond2.'/'.$usersData->BRND_MSTR_BRAND_ID),'<button type="button" onclick="javasciprt: return confirm(\'Are you really want to Restore?\')"title="Restore" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-time-restore"></i></button>&nbsp;');
        }else
        {
           $btn .= anchor(site_url('Brands/delete/'.$cond2.'/'.$usersData->BRND_MSTR_BRAND_ID),'<button type="button" onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
        }

			if($usersData->BRND_MSTR_STATUS=='LIVE')
			{
				$status =  "<button class='label-success label'>Live</button>";            
			}
			else if($usersData->BRND_MSTR_STATUS=='PNDG')
			{
				$status =  "<button class='label-warning label'>PNDG</button>";
			}else if($usersData->BRND_MSTR_STATUS=='DLTD')
			{
				$status =  "<button class='label-warning label'>DLTD</button>";
			} else{
				$status =  "<button class='label-danger label'>REJ</button>";
			}

			
			

			$no++;
			$nestedData = array();
            $nestedData[] = '<input type="checkbox" class="checkitems" name="selectedRows[]" value="'.$usersData->BRND_MSTR_BRAND_ID.'" >';
			$nestedData[] = $no;
			$nestedData[] = $usersData->BRND_MSTR_BRAND_ID;
			$nestedData[] = $usersData->BRND_MSTR_BRAND_NAME;
			$nestedData[] = $value;
			$nestedData[] = $usersData->BRND_MSTR_BRAND_DESC;
			$nestedData[] = $status;
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}

		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Brands_model->count_all($cond2),
				"recordsFiltered" => $this->Brands_model->count_filtered($cond2),
				"data" => $data,
			       );
		echo json_encode($output);
	}

	
	public function bulkdelete()
	{
		 $cnt=0;
		 $dataArray= array('BRND_MSTR_STATUS'=>'DLTD');
			$dataArray1= array('CATG_BRND_MAP_STATUS'=>'DLTD');
        foreach($this->input->post('selectedRows') as $id){
            $cnt++;
			$row = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$id."'",'','','','single');
			if($row) 
			{
				$this->Crud_model->SaveData('BRND_MSTR',$dataArray,"BRND_MSTR_BRAND_ID='".$id."'");
				$this->Crud_model->SaveData('CATG_BRND_MAP',$dataArray1,"CATG_BRND_MAP_BRAND_ID='".$id."'");
			}
		}
		$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>"'.$cnt.'" Records Deleted Successfully.</p></div>');
		//echo json_encode(['responce'=>'success']);
			redirect(site_url('Brands/index/'.$_POST['cond2']));
	}
	

	public function delete($cond2,$id) 
	{
		$dataArray= array('BRND_MSTR_STATUS'=>'DLTD');
			$dataArray1= array('CATG_BRND_MAP_STATUS'=>'DLTD');
		$row = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$id."'",'','','','single');
			if($row) 
			{

				$this->Crud_model->SaveData('BRND_MSTR',$dataArray,"BRND_MSTR_BRAND_ID='".$id."'");
				$this->Crud_model->SaveData('CATG_BRND_MAP',$dataArray1,"CATG_BRND_MAP_BRAND_ID='".$id."'");
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Brand Deleted Successfully.</p></div>');
			}
		
			redirect(site_url('Brands/index/'.$cond2));
	
	}

	public function create($cond2)
	{
		$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and CATG_MSTR_CATEGORY_LEVEL='1'",'','');
		$data = array('heading'=>'Brands',
						'subheading'=>'Create Brand',
						'button'=>'Submit',
						'action'=>site_url('Brands/create_action'),
						'brandName' => set_value('brandName'),
						'desc' => set_value('desc'),
						'id' => set_value('id'),
						'cond2' => set_value('cond2'),
						'categories' => $allCategory,
			    	 );
		$this->load->view('brands/form',$data);
	}

	public function create_action() 
	{
		$this->form_validation->set_rules('desc', 'desc', 'required',
				array(
					'required' => 'Please enter Desciption',
				     )
				);
		if ($this->form_validation->run() == FALSE) {
		$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and CATG_MSTR_CATEGORY_LEVEL='1'",'','');
		for ($i=0; $i < count($_POST['categoryId']) ; $i++) { 
					$dataMapArray[]=$_POST['categoryId'][$i];
				} 
		$data = array('heading'=>'Brands',
						'subheading'=>'Create Brand',
						'button'=>'Submit',
						'action'=>site_url('Brands/create_action'),
						'brandName' => set_value('brandName'),
						'desc' => set_value('desc'),
						'id' => set_value('id'),
						'cond2' => set_value('cond2',$_POST['cond2']),
						'categories' => $allCategory,
						'categories2' => $dataMapArray,
			    	 );
		$this->load->view('brands/form',$data);
		} 
		else 
		{   
			$dataProcedure = $this->db->query("SELECT GET_SEQ('BRND')");
			$result = $dataProcedure->row();
			foreach ($result as $value) 
				$array[] = $value;
			$dataPositionProcedure = $this->db->query("SELECT GET_BRND_MSTR_POSITION()");
			$resultPosition = $dataPositionProcedure->row();
			foreach ($resultPosition as $valuePosition) 
				$arrayPosition[] = $valuePosition;
			$dataArray= array('BRND_MSTR_BRAND_ID'=>$array[0],
					'BRND_MSTR_BRAND_NAME'=>$_POST['brandName'],
					'BRND_MSTR_CREATED_BY'=>$_SESSION['tbsCampaign']['id'],
					'BRND_MSTR_BRAND_DESC'=>$_POST['desc'],
					'BRND_MSTR_POSITION'=>$arrayPosition[0],
					);
			$this->Crud_model->SaveData('BRND_MSTR',$dataArray);
			for ($i=0; $i < count($_POST['categoryId']) ; $i++) { 
                $dataMapArray= array(
                    'CATG_BRND_MAP_BRAND_ID'=>$array[0],
                    'CATG_BRND_MAP_CATEGORY_ID'=>$_POST['categoryId'][$i],
                );
                $this->Crud_model->SaveData('CATG_BRND_MAP',$dataMapArray);
            }
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
			redirect(site_url('Brands/index/'.$_POST['cond2']));
		}
	}

	public function update($cond2,$id)
	{
		
					$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and CATG_MSTR_CATEGORY_LEVEL='1'",'','');
					//$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and CATG_MSTR_CATEGORY_LEVEL='1'",'','');

		$getUsers = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$id."'",'','','','single');
		$allBrandCategory = $this->Brands_model->GetBrandData($getUsers->BRND_MSTR_BRAND_ID);
			

		$data = array('heading'=>'Brands',
						'subheading'=>'Edit Brand',
						'button'=>'Update',
						'action'=>site_url('Brands/update_action'),
						'brandName' => set_value('brandName',$getUsers->BRND_MSTR_BRAND_NAME),
						'status' => set_value('status',$getUsers->BRND_MSTR_STATUS),
						'desc' => set_value('desc',$getUsers->BRND_MSTR_BRAND_DESC),
						'id' => set_value('id',$id),
						'cond2' => set_value('cond2',$cond2),
						'categories' => $allCategory,
						'categories1' => $allBrandCategory,
						
				 );
		 
		$this->load->view('brands/form',$data);
	}

	public function update_action()
	{
		//print_r($_POST);exit;
		$getUsers = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$_POST['id']."'",'','','','single'); 
		$checkExists = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID!='".$_POST['id']."' and BRND_MSTR_BRAND_NAME='".$_POST['brandName']."'",'','','','single');
		if(empty($checkExists))
		{
			$this->form_validation->set_rules('desc', 'desc', 'required',
					array(
						'required' => 'Please enter Description',
						
					     )
					);
			if ($this->form_validation->run() == FALSE) {
				

					$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and CATG_MSTR_CATEGORY_LEVEL='1'",'','');
					//$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and CATG_MSTR_CATEGORY_LEVEL='1'",'','');

					$getUsers = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$id."'",'','','','single');
					for ($i=0; $i < count($_POST['categoryId']) ; $i++) { 
					$dataMapArray[]=$_POST['categoryId'][$i];
				} 	

					$data = array('heading'=>'Brands',
									'subheading'=>'Edit Brand',
							'button'=>'Update',
							'action'=>site_url('Brands/update_action'),
							'brandName' => set_value('brandName',$getUsers->BRND_MSTR_BRAND_NAME),
							'status' => set_value('status',$getUsers->BRND_MSTR_STATUS),
							'desc' => set_value('desc',$_POST['desc']),
							'id' => set_value('id',$id),
						'cond2' => set_value('cond2',$_POST['cond2']),
							'categories' => $allCategory,
							'categories2' => $dataMapArray,
						
				 );
		 
		$this->load->view('brands/form',$data);


			} 
			else 
			{
				$dataArray= array(
						'BRND_MSTR_BRAND_NAME'=>$_POST['brandName'],
						'BRND_MSTR_MODIFIED_BY'=>$_SESSION['tbsCampaign']['id'],
						'BRND_MSTR_BRAND_DESC'=>$_POST['desc'],
						'BRND_MSTR_STATUS'=>$_POST['status'],
						);

				$this->Crud_model->SaveData('BRND_MSTR',$dataArray,"BRND_MSTR_BRAND_ID='".$_POST['id']."'");
				$this->Crud_model->DeleteData('CATG_BRND_MAP',"CATG_BRND_MAP_BRAND_ID='".$_POST['id']."'");
				for ($i=0; $i < count($_POST['categoryId']) ; $i++) { 
					$dataMapArray= array(
						'CATG_BRND_MAP_BRAND_ID'=>$_POST['id'],
						'CATG_BRND_MAP_CATEGORY_ID'=>$_POST['categoryId'][$i],
					);
					$this->Crud_model->SaveData('CATG_BRND_MAP',$dataMapArray);
				} 
				$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been updated successfully.</p></div>');
				redirect(site_url('Brands/index/'.$_POST['cond2']));
			}

		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Entered brand name already exists.</p></div>');
			redirect(site_url('Brands/update/'.$_POST['cond2'].'/'.$_POST['id']));
		}
	}


//Roshani code start
    public function restore($cond2,$id)
    {
        $dataArray= array(
                            'BRND_MSTR_STATUS'=>'LIVE',
                    );
        $dataArray1= array(
                            'CATG_BRND_MAP_STATUS'=>'LIVE',
                    );
        $this->Crud_model->SaveData('BRND_MSTR',$dataArray,"BRND_MSTR_BRAND_ID='".$id."'");
        $this->Crud_model->SaveData('CATG_BRND_MAP',$dataArray1,"CATG_BRND_MAP_BRAND_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been restore successfully.</p></div>');
		redirect(site_url('Brands/index/'.$cond2));
    }
    public function View($cond2,$id)
    {
        $getbrand = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$id."'",'','','','single');
		$allBrandCategory = $this->Brands_model->GetBrandData($getbrand->BRND_MSTR_BRAND_ID);
			$value= '';
			$x=1;
			for ($i=0; $i < count($allBrandCategory); $i++) {
				$value .= $x. " ) ". $allBrandCategory[$i]->CATG_MSTR_CATEGORY_NAME."<br>"; 
                $x++;
			}        $data = array('heading'=>'Brand',
                    'subheading'=>'View Brand Management',
                    'action'=>site_url('Brands'),
                  
						'brandName' => set_value('brandName',$getbrand->BRND_MSTR_BRAND_NAME),
						'status' => set_value('status',$getbrand->BRND_MSTR_STATUS),
						'desc' => set_value('desc',$getbrand->BRND_MSTR_BRAND_DESC),
						'id' => set_value('id',$id),
						'cond2' => set_value('cond2',$cond2),
						'categories' => set_value('categories',$value),
                );
        $this->load->view('brands/view',$data);
    }
    public function export()
    {
        $this->load->library("excel");
        $object=new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns=array("Brand ID","Brand Name","Categoty Level1 Name","Status");
        $column=0;
        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
            $column++;

        }
        $allCategoryType = $this->Brands_model->get_datatables($cond2);
        $excel_row=2;
        foreach($allCategoryType as $row)
        {
        	$allBrandCategory = $this->Brands_model->GetBrandData($row->BRND_MSTR_BRAND_ID);
			$value= '';
			$x=1;
			for ($i=0; $i < count($allBrandCategory); $i++) {
				$value .= $x. " ) ". $allBrandCategory[$i]->CATG_MSTR_CATEGORY_NAME."<br>"; 
                $x++;
			}
            $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->BRND_MSTR_BRAND_ID);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->BRND_MSTR_BRAND_NAME);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$value);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$row->BRND_MSTR_STATUS);
            $excel_row++;
        }
        $object_writer=PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="Brand-'.date('d-m-y-h:m:s').'.xls"');
        $object_writer->save('php://output');

    }
    //Roshani Code end
}
