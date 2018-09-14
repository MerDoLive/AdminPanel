<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);
class Categories_level2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Categories_level2_model');
		$this->load->model('Categories_Subcategories_model', 'cat_subcat_model', TRUE);       
		 $this->load->helper(array('form', 'url','download','security'));
       
	}

	public function index($cond2)
	{
		$all=$this->Categories_level2_model->count_filtered('ALL');
        $live=$this->Categories_level2_model->count_filtered('LIVE');
        $pndg=$this->Categories_level2_model->count_filtered('PNDG');
        $rej=$this->Categories_level2_model->count_filtered('REJ');
        $deleted=$this->Categories_level2_model->count_filtered('DLTD');
		$data = array('heading'=>'Category Level 2', 'cond2'=>$cond2,'all'=>$all,'live'=>$live,'deleted'=>$deleted,'pndg'=>$pndg,'rej'=>$rej);
		$this->load->view('category_level2/list',$data);
	}
	public function ajax_manage_page($cond2)
	{
		$categoryData = $this->Categories_level2_model->get_datatables($cond2);
		if(empty($_POST['start']))
		{
			$no =0;   
		}else{
			$no =$_POST['start'];
		}
		$data = array();		
		foreach ($categoryData as $catData) 
		{
			$parentCatName = $this->Crud_model->GetData('CATG_MSTR','CATG_MSTR_CATEGORY_NAME',"CATG_MSTR_CATEGORY_ID='".$catData->CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID."'",'','','','single');
			if($catData->CATG_MSTR_STATUS=='LIVE')
			{
				$status =  "<button class='label-success label'>Live</button>";            
			}
			else if($catData->CATG_MSTR_STATUS=='PNDG')
			{
				$status =  "<button class='label-warning label'>PNDG</button>";
			} else if($catData->CATG_MSTR_STATUS=='DLTD'){
				$status =  "<button class='label-danger label'>DLTD</button>";
			} else {
				$status =  "<button class='label-danger label'>REJ</button>";
			}
			$btn='';
            if($catData->CATG_MSTR_STATUS!='DLTD')
            {

			$btn = anchor(site_url('Categories_level2/update/'.$cond2.'/'.$catData->CATG_MSTR_CATEGORY_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
			$btn .= ' | '.anchor(site_url('Categories_level2/view/'.$cond2.'/'.$catData->CATG_MSTR_CATEGORY_ID),'<button title="View" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-eye"></i></button> | ');
			}
			 if($catData->CATG_MSTR_STATUS=='DLTD')
            {
            $btn .= anchor(site_url('Categories_level2/restore/'.$cond2.'/'.$catData->CATG_MSTR_CATEGORY_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to Restore?\')"title="Restore" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-time-restore"></i></button>&nbsp;');
        }else
        {
            $btn .= anchor(site_url('Categories_level2/delete/'.$cond2.'/'.$catData->CATG_MSTR_CATEGORY_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
        }
			
			$no++;
			$nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = $catData->CATG_TYPE_MSTR_CATEGORY_TYPE;
			$nestedData[] = $catData->CATG_MSTR_CATEGORY_ID;
			//$nestedData[] = ucfirst($parentCatName->CATG_MSTR_CATEGORY_NAME);
			$nestedData[] = ucfirst($parentCatName->CATG_MSTR_CATEGORY_NAME);
			$nestedData[] = ucfirst($catData->CATG_MSTR_CATEGORY_NAME);
			$nestedData[] = $status;
			$nestedData[] = $catData->USER_MSTR_USER_NAME;
			$nestedData[] = date("d F, Y g:i A",strtotime($catData->CATG_MSTR_CREATED_TIME));
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}

		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Categories_level2_model->count_all($cond2),
				"recordsFiltered" => $this->Categories_level2_model->count_filtered($cond2),
				"data" => $data,
			       );
		echo json_encode($output);
	}
	public function create($cond2)
	{
		$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"CATG_TYPE_MSTR_STATUS='LIVE'",'','');
		$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and  	CATG_MSTR_CATEGORY_LEVEL='1'",'','');
		$data = array('heading'=>'Category',
				'subheading'=>'Create Category Level 2',
				'button'=>'Submit',
				'action'=>site_url('Categories_level2/create_action'),
				'categories' => $allCategoryType,
				'mainCategory' => $allCategory,
				'categoryId' => set_value('categoryId'),
				'mainCategoryId' => set_value('mainCategoryId'),
				'name' => set_value('CATG_MSTR_CATEGORY_NAME'),
				'desc' => set_value('CATG_MSTR_CATEGORY_DESC'),
				'id' => set_value('CATG_MSTR_CATEGORY_ID'),
				'cond2' => set_value('cond2',$cond2),

			     );
		$this->load->view('category_level2/form',$data);
	}

	public function create_action() 
	{
		$checkExists = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID!='".$_POST['id']."' and CATG_MSTR_CATEGORY_NAME='".$_POST['name']."'",'','','','single');
		if(empty($checkExists))
		{
		$this->form_validation->set_rules('categoryId','categoryId','required',array(
					'required' => 'Please Select CATEGORY Type',
					               
				     )
				);
		
		$this->form_validation->set_rules('name','name','required',array(
					'required' => 'Please enter CATEGORY Level2',
					               
				     )
				);
		$this->form_validation->set_rules('desc', 'desc', 'required',
				array(
					'required' => 'Please enter Description',
					               
				     )
				);

		if ($this->form_validation->run() == FALSE) {
			$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"CATG_TYPE_MSTR_STATUS='LIVE'",'','');
		$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and  	CATG_MSTR_CATEGORY_LEVEL='1'",'','');
		$data = array('heading'=>'Category',
				'subheading'=>'Create Category Level 2',
				'button'=>'Submit',
				'action'=>site_url('Categories_level2/create_action'),
				'categories' => $allCategoryType,
				'mainCategory' => $allCategory,
				'categoryId' => set_value('categoryId'),
				'mainCategoryId' => $_POST['maincategoryId'],
				'name' =>$_POST['name'],
				'desc' => set_value('CATG_MSTR_CATEGORY_DESC'),
				'id' => set_value('CATG_MSTR_CATEGORY_ID'),
				'cond2' => set_value('cond2',$_POST['cond2']),
			     );
		$this->load->view('category_level2/form',$data);
		} 
		else 
		{  
			if($_POST['maincategoryId']!=''){
			$dataProcedure = $this->db->query("SELECT GET_SEQ('CATG')");
			$result = $dataProcedure->row();
			foreach ($result as $value) 
				$array[] = $value;
			$catgPositionFunction = $this->db->query("SELECT GET_CATG_MSTR_POSITION()");
			$catgPosition = $catgPositionFunction->row();
			foreach ($catgPosition as $catgPositionValue)
				$catgPositionArray[] = $catgPositionValue;
			$CATG_MSTR_CATEGORY_LEVEL="2";
			$dataArray= array('CATG_MSTR_CATEGORY_NAME'=>$_POST['name'],
					'CATG_MSTR_CATEGORY_ID'=>$array[0],
					'CATG_MSTR_POSITION'=>$catgPositionArray[0],
					'CATG_MSTR_CATEGORY_DESC'=>$_POST['desc'],
					'CATG_MSTR_CATEGORY_TYPE_ID'=>$_POST['categoryId'],
					'CATG_MSTR_CREATED_BY'=>$_SESSION['tbsCampaign']['id'],
					'CATG_MSTR_CATEGORY_LEVEL'=>$CATG_MSTR_CATEGORY_LEVEL,
					);
			$data = $this->Crud_model->SaveData('CATG_MSTR',$dataArray);
			$dataSubArray= array('CATG_SUB_CATG_MAP_CATEGORY_ID'=>$array[0],
							  	'CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID'=>$_POST['maincategoryId'],
					        	);
			$data = $this->Crud_model->SaveData('CATG_SUB_CATG_MAP',$dataSubArray);
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
			redirect(site_url('Categories_level2/index/'.$_POST['cond2']));

		}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Category level 2 is Manadatory.</p></div>');

				$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"CATG_TYPE_MSTR_STATUS='LIVE'",'','');
				$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and  	CATG_MSTR_CATEGORY_LEVEL='1'",'','');
				$data = array('heading'=>'Category',
				'subheading'=>'Create Category Level 2',
				'button'=>'Submit',
				'action'=>site_url('Categories_level2/create_action'),
				'categories' => $allCategoryType,
				'mainCategory' => $allCategory,
				'categoryId' => set_value('categoryId'),
				'mainCategoryId' => $_POST['maincategoryId'],
				'name' =>$_POST['name'],
				'desc' => $_POST['desc'],
				'id' => set_value('CATG_MSTR_CATEGORY_ID'),
				'cond2' => set_value('cond2',$_POST['cond2']),
			     );
		$this->load->view('category_level2/form',$data);
			}
			
		}
		
		} 
		else 
		{ 
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Entered Category name already exists.</p></div>');
			$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"CATG_TYPE_MSTR_STATUS='LIVE'",'','');
				$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and  	CATG_MSTR_CATEGORY_LEVEL='1'",'','');
				$data = array('heading'=>'Category',
				'subheading'=>'Create Category Level 2',
				'button'=>'Submit',
				'action'=>site_url('Categories_level2/create_action'),
				'categories' => $allCategoryType,
				'mainCategory' => $allCategory,
				'categoryId' => set_value('categoryId'),
				'mainCategoryId' => $_POST['maincategoryId'],
				'name' =>$_POST['name'],
				'desc' => $_POST['desc'],
				'id' => set_value('CATG_MSTR_CATEGORY_ID'),
				'cond2' => set_value('cond2',$_POST['cond2']),
			     );
		$this->load->view('category_level2/form',$data);
		}
	}

	public function update($cond2,$id)
	{
		  
		$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"",'','');
		$getCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$id."'",'','','','single');
		$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and  	CATG_MSTR_CATEGORY_LEVEL='1'",'','');
		$getMapCategory = $this->Crud_model->GetData('CATG_SUB_CATG_MAP','CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID',"CATG_SUB_CATG_MAP_CATEGORY_ID='".$getCategory->CATG_MSTR_CATEGORY_ID."'",'','','','single');
		$data = array('heading'=>'Categories',
				'subheading'=>'Update Category Level 2',
				'button'=>'Update',
				'categories' => $allCategoryType,
				'mainCategory' => $allCategory,
				'mainCategoryId' => set_value('mainCategoryId',$getMapCategory->CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID),
				'action'=>site_url('Categories_level2/update_action'),
				'name' => set_value('name',$getCategory->CATG_MSTR_CATEGORY_NAME),
				'position' => set_value('position',$getCategory->CATG_MSTR_POSITION),
				'desc' => set_value('desc',$getCategory->CATG_MSTR_CATEGORY_DESC),
				'categoryId' =>set_value('categoryId',$getCategory->CATG_MSTR_CATEGORY_TYPE_ID),
				'status' => set_value('status',$getCategory->CATG_MSTR_STATUS),
				'id' => set_value('id',$id),
				'cond2' => set_value('cond2',$cond2),
			);
		$this->load->view('category_level2/form',$data);
		
	}

	public function update_action()
	{
		$this->form_validation->set_rules('categoryId','categoryId','required',array(
					'required' => 'Please Select CATEGORY Type',
					               
				     )
				);
		
		$this->form_validation->set_rules('name','name','required',array(
					'required' => 'Please enter CATEGORY Level2',
					               
				     )
				);
		$this->form_validation->set_rules('desc', 'desc', 'required',
				array(
					'required' => 'Please enter Description',
					               
				     )
				);
		if ($this->form_validation->run() == FALSE) 
		{
						$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"",'','');
						$getCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$id."'",'','','','single');
						$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and  	CATG_MSTR_CATEGORY_LEVEL='1'",'','');
						$getMapCategory = $this->Crud_model->GetData('CATG_SUB_CATG_MAP','CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID',"CATG_SUB_CATG_MAP_CATEGORY_ID='".$id."'",'','','','single');
						$data = array('heading'=>'Categories',
							'subheading'=>'Update Category Level 2',
							'button'=>'Update',
							'categories' => $allCategoryType,
							'mainCategory' => $allCategory,
							'mainCategoryId' => $_POST['maincategoryId'],
							'action'=>site_url('Categories_level2/update_action'),
							'name' => $_POST['name'],
							'position' => set_value('position',$getCategory->CATG_MSTR_POSITION),
							'desc' => set_value('desc',$getCategory->CATG_MSTR_CATEGORY_DESC),
							'categoryId' =>set_value('categoryId',$getCategory->CATG_MSTR_CATEGORY_TYPE_ID),
							'status' => set_value('status',$getCategory->CATG_MSTR_STATUS),
							'id' => $_POST['id'],
							'cond2' => $_POST['cond2'],
						);
					$this->load->view('category_level2/form',$data);
		} 
		else 
		{  
					if($_POST['maincategoryId']!='')
					{
								$category_count = $this->Crud_model->GetTableCount('CATG_SUB_CATG_MAP',"CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID='".$_POST['id']."' and CATG_SUB_CATG_MAP_STATUS='LIVE'");
						        if($category_count==0)
						        {
									$dataArray= array('CATG_MSTR_CATEGORY_NAME'=>$_POST['name'],
									'CATG_MSTR_CATEGORY_DESC'=>$_POST['desc'],
									'CATG_MSTR_CATEGORY_TYPE'=>$_POST['categoryId'],
									'CATG_MSTR_STATUS'=>$_POST['status'],
									'CATG_MSTR_POSITION'=>$_POST['position'],
									'CATG_MSTR_MODIFIED_BY'=>$_SESSION['tbsCampaign']['id'],
									'CATG_MSTR_MODIFIED_TIME'=>date("Y-m-d h:m:s"),
									);
									$this->Crud_model->SaveData('CATG_MSTR',$dataArray,"CATG_MSTR_CATEGORY_ID='".$_POST['id']."'"); 
									$dataSubArray= array('CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID'=>$_POST['maincategoryId']);
									$getMapCategory = $this->Crud_model->GetData('CATG_SUB_CATG_MAP','CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID',"CATG_SUB_CATG_MAP_CATEGORY_ID='".$_POST['id']."'",'','','','single');

									$data = $this->Crud_model->SaveData('CATG_SUB_CATG_MAP',$dataSubArray,"CATG_SUB_CATG_MAP_CATEGORY_ID='".$_POST['id']."'");
									$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been updated successfully.</p></div>');
								}
								else
						        {
						        	$this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>This Category Level2 Mapped with category level 3, Unable to uPDATE.</p></div>');
						        }
						        redirect(site_url('Categories_level2/index/'.$_POST['cond2']));
					}
					else
					{
								$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"",'','');
								$getCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$_POST['id']."'",'','','','single');
								$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' and  	CATG_MSTR_CATEGORY_LEVEL='1'",'','');
								$getMapCategory = $this->Crud_model->GetData('CATG_SUB_CATG_MAP','CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID',"CATG_SUB_CATG_MAP_CATEGORY_ID='".$id."'",'','','','single');
								$data = array('heading'=>'Categories',
									'subheading'=>'Update Category Level 2',
									'button'=>'Update',
									'categories' => $allCategoryType,
									'mainCategory' => $allCategory,
									'mainCategoryId' => $_POST['maincategoryId'],
									'action'=>site_url('Categories_level2/update_action'),
									'name' => $_POST['name'],
									'position' => set_value('position',$getCategory->CATG_MSTR_POSITION),
									'desc' => set_value('desc',$getCategory->CATG_MSTR_CATEGORY_DESC),
									'categoryId' =>set_value('categoryId',$getCategory->CATG_MSTR_CATEGORY_TYPE_ID),
									'status' => set_value('status',$getCategory->CATG_MSTR_STATUS),
									'id' => $_POST['id'],
									'cond2' => $_POST['cond2'],
								);
						        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Provide Category Level1, found empty </p></div>');
								$this->load->view('category_level2/form',$data);
					}
		        
					
		}
	}

	public function delete($cond2,$id)
	{
		

		$dataArray= array('CATG_MSTR_STATUS'=>'DLTD');
				$dataArray1= array('CATG_SUB_CATG_MAP_STATUS'=>'DLTD');

		$category_count = $this->Crud_model->GetTableCount('CATG_SUB_CATG_MAP',"CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID='".$id."' and CATG_SUB_CATG_MAP_STATUS='LIVE'");
        if($category_count==0)
        {
		$this->Crud_model->SaveData('CATG_MSTR',$dataArray,"CATG_MSTR_CATEGORY_ID='".$id."'");
		$this->Crud_model->SaveData('CATG_SUB_CATG_MAP',$dataArray1,"CATG_SUB_CATG_MAP_CATEGORY_ID='".$id."'");
       // $this->Crud_model->DeleteData('CATG_TYPE_MSTR',"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
        }
        else
        {
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>This Category Level2 Mapped with category level 3, Unable to delete.</p></div>');
        }
		redirect('Categories_level2/index/'.$cond2);
	}

	public function view($cond2,$id){
		$getCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$id."'",'','','','single');
		$getCategory1 = $this->Crud_model->GetData('CATG_SUB_CATG_MAP','',"CATG_SUB_CATG_MAP_CATEGORY_ID='".$getCategory->CATG_MSTR_CATEGORY_ID."'",'','','','single');
		$getCategory2 = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$getCategory1->CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID."'",'','','','single');
		$getCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','CATG_TYPE_MSTR_CATEGORY_TYPE',"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$getCategory->CATG_MSTR_CATEGORY_TYPE_ID."'",'','','','single');
		$data = array(
				'heading'=>'Categories',
				'subheading'=>'View Category Level 2',
				'categoryTypeName' => set_value('categoryTypeName',$getCategoryType->CATG_TYPE_MSTR_CATEGORY_TYPE),
				'categoryLevel1' => set_value('categoryLevel1',$getCategory2->CATG_MSTR_CATEGORY_NAME),
				'categoryLevel2' => set_value('categoryLevel2',$getCategory->CATG_MSTR_CATEGORY_NAME),
				'position' => set_value('position',$getCategory->CATG_MSTR_POSITION),
				'level' => set_value('level',$getCategory->CATG_MSTR_CATEGORY_LEVEL),
				'desc' => set_value('desc',$getCategory->CATG_MSTR_CATEGORY_DESC),
				'status' => set_value('status',$getCategory->CATG_MSTR_STATUS),
				'id' => set_value('id',$id),
				'cond2' => set_value('cond2',$cond2),
			);
		$this->load->view('category_level2/view',$data);

	}

	// Roshani code start

	public function get_category1()
	{
		$categorytype = $this->input->post('categorytype');
		//      $categorylevel2Id = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_LEVEL='".$categorylevel1Id."'",'','');

		$categorylevel1Id = $this->cat_subcat_model->get_category1_query($categorytype);   
		if(count($categorylevel1Id)>0)
		{
			$pro_select_box = '';
			$pro_select_box .= '<option value="" >Select Category Level 1</option>';
			foreach ($categorylevel1Id as $categorylevel1Id1) {
				$pro_select_box .='<option value="'.$categorylevel1Id1->CATG_MSTR_CATEGORY_ID.'">'.$categorylevel1Id1->CATG_MSTR_CATEGORY_NAME.'</option>';
			}
			echo json_encode($pro_select_box);
		}
		else
		{
			$pro_select_box = '';
			$pro_select_box .= '<option value="">no sub-category</option>';
			echo json_encode($pro_select_box);
		}
	}
	 public function restore($cond2,$id)
    {
        
		$dataArray= array('CATG_MSTR_STATUS'=>'LIVE');
		$dataArray1= array('CATG_SUB_CATG_MAP_STATUS'=>'LIVE');
		$getCategory = $this->Crud_model->GetData('CATG_SUB_CATG_MAP','',"CATG_SUB_CATG_MAP_CATEGORY_ID='".$id."'",'','','','single');
		$category_tcount = $this->Crud_model->GetTableCount('CATG_MSTR',"CATG_MSTR_CATEGORY_ID='".$getCategory->CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID."' and CATG_MSTR_STATUS='LIVE'");
        if($category_tcount!=0)
        {
        $this->Crud_model->SaveData('CATG_MSTR',$dataArray,"CATG_MSTR_CATEGORY_ID='".$id."'");
        $this->Crud_model->SaveData('CATG_SUB_CATG_MAP',$dataArray1,"CATG_SUB_CATG_MAP_CATEGORY_ID='".$id."'");
       // $this->Crud_model->DeleteData('CATG_TYPE_MSTR',"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been restore successfully.</p></div>');
        }
        else
        {
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Record unable to restore because Mapped category Type not available.</p></div>');
        }

        redirect('Categories_level2/index/'.$cond2);
    }
	public function export()
    {
        $this->load->library("excel");
        $object=new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns=array("Category Level 2 ID","Category Level 2","Category Type","Category Level 1","Status","Created By","Created Time","Modified By","Modified Time");
        $column=0;
        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
            $column++;

        }
		$categoryData = $this->Categories_level2_model->get_datatables($cond2);
        $excel_row=2;
        foreach($categoryData as $row)
        {
			$parentCatName = $this->Crud_model->GetData('CATG_MSTR','CATG_MSTR_CATEGORY_NAME',"CATG_MSTR_CATEGORY_ID='".$row->CATG_SUB_CATG_MAP_PARENT_CATEGORY_ID."'",'','','','single');

            $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->CATG_MSTR_CATEGORY_ID);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->CATG_MSTR_CATEGORY_NAME);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->CATG_TYPE_MSTR_CATEGORY_TYPE);

            $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$parentCatName->CATG_MSTR_CATEGORY_NAME);

         
            $object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,$row->CATG_MSTR_STATUS);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5,$excel_row,$row->USER_MSTR_USER_NAME);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6,$excel_row,$row->CATG_MSTR_CREATED_TIME);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6,$excel_row,$row->CATG_MSTR_MODIFIED_BY);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7,$excel_row,$row->CATG_MSTR_MODIFIED_TIME);
            $excel_row++;
        }
        $object_writer=PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="CategoryLevel2-'.date('d-m-y-h:m:s').'.xls"');
        $object_writer->save('php://output');

    }
    //Roshani Code end

}
