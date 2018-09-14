<?php 
defined('BASEPATH') or exit('no direct script access allowed');
error_reporting(0);

class Deals extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Deals_model');
        $this->load->model('Crud_model');
    }

    public function index($cond2)
    {
        $data = array('heading' => 'Deals','cond2' =>$cond2);
        $this->load->view('deals/list',$data);
    }

    public function ajax_manage_page($cond2)
	{  	
		$userData = $this->Deals_model->get_datatables($cond2);
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
            $btn = anchor(site_url('Deals/upload_image/'.$usersData->DEAL_MSTR_DEAL_ID),'<button title="upload_image"class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-image"></i></button>');
			$btn .= ' | '.anchor(site_url('Deals/update/'.$usersData->DEAL_MSTR_DEAL_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
			$btn .= ' | '.anchor(site_url('Deals/delete/'.$usersData->DEAL_MSTR_DEAL_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            $btn .= ' | '.anchor(site_url('Deals/view/'.$usersData->DEAL_MSTR_DEAL_ID),'<button title="view" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-eye"></i></button>');
            

			if($usersData->DEAL_MSTR_STATUS=='LIVE')
			{
				$status =  "<button class='label-success label'>Live</button>";            
			}
			else if($usersData->DEAL_MSTR_STATUS=='PNDG')
			{
				$status =  "<button class='label-warning label'>PNDG</button>";
            } 
            else
            {
				$status =  "<button class='label-danger label'>REJ</button>";
			}

			$no++;
            $nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = $usersData->DEAL_MSTR_DEAL_ID;
			$nestedData[] = $usersData->DEAL_MSTR_DEAL_NAME;
			$nestedData[] = $usersData->DEAL_MSTR_DEAL_DESC;
            $nestedData[] = $status;
            $nestedData[] = $usersData->DEAL_MSTR_START_DATE;
			$nestedData[] = $usersData->DEAL_MSTR_END_DATE;
			$nestedData[] = $usersData->DEAL_MSTR_DEAL_TYPE;
			/* $nestedData[] = $usersData->DEAL_MSTR_START_TIME;
			$nestedData[] = $usersData->DEAL_MSTR_END_TIME; */
			$nestedData[] = $usersData->DEAL_MSTR_DEAL_DISCOUNT;
			$nestedData[] = $usersData->DEAL_MSTR_CREATED_BY;
			$nestedData[] = $usersData->DEAL_MSTR_MODIFIED_BY;
			$nestedData[] = $usersData->DEAL_MSTR_POSITION;
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}

		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Deals_model->count_all(),
				"recordsFiltered" => $this->Deals_model->count_filtered(),
				"data" => $data,
			       );
		echo json_encode($output);
     }

    public function create()
	 {
		$data = array('heading'=>'Deals',
				'subheading'=>'Create Deal',
				'button'=>'Submit',
                'action'=>site_url('Deals/create_action'),
                'id' => set_value('DEAL_MSTR_DEAL_ID'),
				'dealsName' => set_value('DEAL_MSTR_DEAL_NAME'),
                'desc' => set_value('DEAL_MSTR_DEAL_DESC'),
                'status' => set_value('PNDG'),
                'startdate' => set_value('DEAL_MSTR_START_DATE'),
				'enddate' => set_value('DEAL_MSTR_END_DATE'),
				'dealtype' => set_value('DEAL_MSTR_DEAL_TYPE'),
				'starttime' => set_value('DEAL_MSTR_START_TIME'),
				'endtime' => set_value('DEAL_MSTR_END_TIME'),
				'discount' => set_value('DEAL_MSTR_DEAL_DISCOUNT'),
				'createdby' => set_value('DEAL_MSTR_CREATED_BY'),
				'position' => set_value('DEAL_MSTR_POSITION')
			     );
		$this->load->view('deals/form',$data);
	}

	public function create_action() 
	{

		$this->form_validation->set_rules('dealsName', 'dealsName', 'trim|regex_match[/^[a-zA-Z ]+$/]|required',
            array(
                'required' => 'Please enter name',
                'regex_match' => 'Please enter valid name',         
            )
        );
        if ($this->form_validation->run() == FALSE) 
        {
            echo "frm validation";
            $this->create();
        } 
        else 
        {
            //echo "Coming Here";
            $dataProcedure = $this->db->query("SELECT GET_SEQ('DEAL')");
            $result = $dataProcedure->row();
            foreach ($result as $value) 
			$array[] = $value;
			$PositionFunction = $this->db->query("SELECT GET_DEAL_MSTR_POSITION()");
			$Position = $PositionFunction->row();
			foreach ($Position as $PositionValue)
				$PositionArray[] = $PositionValue;
		
			$dataArray= array('DEAL_MSTR_DEAL_ID'=>$array[0],
                            'DEAL_MSTR_DEAL_NAME'=>$_POST['dealsName'],
                            'DEAL_MSTR_DEAL_DESC'=>$_POST['desc'],
                            'DEAL_MSTR_STATUS' => "PNDG",
                            'DEAL_MSTR_START_DATE' => $_POST['startdate'],
							'DEAL_MSTR_END_DATE' => $_POST['enddate'],
							'DEAL_MSTR_DEAL_TYPE' => $_POST['dealtype'],
							'DEAL_MSTR_START_TIME' => $_POST['starttime'],
							'DEAL_MSTR_END_TIME' => $_POST['endtime'],
							'DEAL_MSTR_DEAL_DISCOUNT' => $_POST['discount'],
							'DEAL_MSTR_CREATED_BY'=>$_SESSION['tbsCampaign']['id'],
							'DEAL_MSTR_POSITION' => $PositionArray[0],
						);
						
			//print_r($array);
            $this->Crud_model->SaveData('DEAL_MSTR',$dataArray);
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
            redirect(site_url('Deals'));
		}   
    }

    // Update an existing deal
    public function update($id)
	{
		//$allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"",'','');
		$getDeal = $this->Crud_model->GetData('DEAL_MSTR','',"DEAL_MSTR_DEAL_ID='".$id."'",'','','','single');
		//$allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_TYPE_ID='".$getCategory->CATG_MSTR_CATEGORY_TYPE_ID."'",'','');
		$data = array('heading'=>'Deals',
				'subheading'=>'Update Deal',
				'button'=>'Update',
                'action'=>site_url('Deals/update_action'),
                'id' => set_value('id',$id),
				'dealsName' => set_value('dealsName',$getDeal->DEAL_MSTR_DEAL_NAME),
				'desc' => set_value('desc',$getDeal->DEAL_MSTR_DEAL_DESC),
                'status' => set_value('status',$getDeal->DEAL_MSTR_STATUS),
                'startdate' => set_value('startdate',$getDeal->DEAL_MSTR_START_DATE),
				'enddate' => set_value('enddate',$getDeal->DEAL_MSTR_END_DATE),
				'dealtype' => set_value('dealtype',$getDeal->DEAL_MSTR_DEAL_TYPE),
				'starttime' => set_value('starttime',$getDeal->DEAL_MSTR_START_TIME),
				'endtime' => set_value('endtime',$getDeal->DEAL_MSTR_END_TIME),
				'discount' => set_value('discount',$getDeal->DEAL_MSTR_DEAL_DISCOUNT),

	        	);
		$this->load->view('deals/form',$data);
	}

	public function update_action()
	{
		$this->form_validation->set_rules('dealsName', 'dealsName', 'trim|regex_match[/^[a-zA-Z ]+$/]|required',
				array(
					'required' => 'Please enter name',
					'regex_match' => 'Please enter valid name',                
				     )
				);

		if ($this->form_validation->run() == FALSE) {
			$this->update();
		} 
		else 
		{
			$dataArray= array('DEAL_MSTR_DEAL_NAME'=>$_POST['dealsName'],
				'DEAL_MSTR_DEAL_DESC'=>$_POST['desc'],
                'DEAL_MSTR_STATUS'=>$_POST['status'],
                'DEAL_MSTR_START_DATE'=>$_POST['startdate'],
				'DEAL_MSTR_END_DATE'=>$_POST['enddate'],
				'DEAL_MSTR_DEAL_TYPE' => $_POST['dealtype'],
				'DEAL_MSTR_START_TIME' => $_POST['starttime'],
				'DEAL_MSTR_END_TIME' => $_POST['endtime'],
				'DEAL_MSTR_DEAL_DISCOUNT' => $_POST['discount'],
				'DEAL_MSTR_MODIFIED_BY'=>$_SESSION['tbsCampaign']['id'],
				);

			$this->Crud_model->SaveData('DEAL_MSTR',$dataArray,"DEAL_MSTR_DEAL_ID='".$_POST['id']."'"); 
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been updated successfully.</p></div>');
			redirect(site_url('Deals'));
		}
	} 
    
    //For Deleting a deal
    public function delete($id) 
    { 
        $this->Crud_model->DeleteData('DEAL_MSTR',"DEAL_MSTR_DEAL_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Record has been deleted successfully.</p></div>');
        redirect(site_url('Deals'));
	}
	
	
	public function view($id){
		$getDeal = $this->Crud_model->GetData('DEAL_MSTR','',"DEAL_MSTR_DEAL_ID='".$id."'",'','','','single');
		$data = array(
				'heading'=>'Deals',
				'subheading'=>'View Deal',
				'dealsName' => set_value('dealsName',$getDeal->DEAL_MSTR_DEAL_NAME),
				'desc'=> set_value('desc',$getDeal->DEAL_MSTR_DEAL_DESC),
				'status' => set_value('status',$getDeal->DEAL_MSTR_STATUS),
				'startdate' => set_value('startdate',$getDeal->DEAL_MSTR_START_DATE),
				'enddate' => set_value('enddate',$getDeal->DEAL_MSTR_END_DATE),
				'dealtype' => set_value('dealtype',$getDeal->DEAL_MSTR_DEAL_TYPE),
				'discount' => set_value('discount',$getDeal->DEAL_MSTR_DEAL_DISCOUNT),
				'id' => set_value('id',$id),
			);
		//print_r($data); exit;
		$this->load->view('deals/view',$data);
	}

	public function upload_image()
	{
		$allIcon = $this->Crud_model->GetData('ICON_MSTR','',"",'','');
        $allValue = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_STATUS='LIVE'",'','');
        //$userData = $this->Images_value_model->get_data_query();
        $data = array('heading'=>'Image Master',
            'subheading'=>'Create Image Master Value',
            'button'=>'Submit',
            'action'=>site_url('Deals/upload_image_action'),
            'id' => set_value('id'),
            'filename' => set_value('filename'),
            'visible' => set_value('visible'),
            'status' => set_value('status'),
            'position' => set_value('position'),
            'startBNR' => set_value('startBNR'),
            'endBNR' => set_value('endBNR'),
            'group' => '',
            'type' => '',
            'entityId' => '',
            'atribute' => $allValue,
             'mainIcon' =>$allIcon,
            'imgmstr' => $userData,
        );
        $this->load->view('deals/upload_image',$data);
	}

	public function upload_image_action()
	{
		$var = preg_split("#/#",$_POST['group']);

        $getGRPdata = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$var[0]."'",'','','','single');
            
        $dataProcedure = $this->db->query("SELECT GET_SEQ('INMG')");
            $result = $dataProcedure->row();
            foreach ($result as $value) 
            $array[] = $value;
        
            $ext=pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
            $filenm= $array[0].'.'.$ext;
                // if($var[1]!="Cat-Icon"){
            $upload_path= "uploads/images";  
            $tmp = '/home/image/dev';//ini_get('upload_tmp_dir');
            $uid=$var[1]; //creare seperate folder for each user 
            $upPath=$upload_path;
            // $upPath=$upload_path."/".$uid."/";
            // if(!file_exists($upPath)) 
            // {
            //            mkdir($upPath, 0777, true);
            // }
            $config['upload_path']          = $upload_path;
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048000;
            $config['max_width']            = $getGRPdata->IMAGE_GROUP_MSTR_RESOLUTION;
            $config['max_height']           = $getGRPdata->IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS;
            
            // if($var[1]=="Banner"){
            //         $config['max_width']            = 850;
            //         $config['max_height']           = 400;
            //     }
            //     else if($var[1]=="Category"){
            //         $config['max_width']            = 800;
            //         $config['max_height']           = 360;
            //     }
            //     else if($var[1]=="Cat-Icon"){
            //         $config['max_width']            = 50;
            //         $config['max_height']           = 50;
            //     }
            
            $config['file_name']           = $filenm;
            // $config['file_name']            = $array[0];

        if($var[1]=="Banner"){
            $dataMapArray= array(
                'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                'IMAGE_MSTR_IMAGE_NAME'=>$filenm,
                'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                // 'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                'IMAGE_MSTR_POSITION'=>$_POST['position'],
                'IMAGE_MSTR_START_DATE'=>date("Y-m-d",strtotime($_POST['startBNR'])),
                'IMAGE_MSTR_END_DATE'=>date("Y-m-d",strtotime($_POST['endBNR'])),
            );
        }
        else if($var[1]=="Promo"){
            $getData = $this->Crud_model->GetData('IMAGE_MSTR','MAX(`IMAGE_MSTR_POSITION`) as maxpos',"IMAGE_MSTR_IMAGE_GROUP='".$var[0]."'",'','','','single');
        
            $dataMapArray= array(
                'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                'IMAGE_MSTR_IMAGE_NAME'=>$filenm,
                'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                // 'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                'IMAGE_MSTR_POSITION'=>($getData->maxpos+1),
                // 'IMAGE_MSTR_START_DATE'=>date("Y-m-d",strtotime($_POST['startBNR'])),
                // 'IMAGE_MSTR_END_DATE'=>date("Y-m-d",strtotime($_POST['endBNR'])),
            );
        }
        else if($var[1]!="Banner"){
            $getData = $this->Crud_model->GetData('IMAGE_MSTR','MAX(`IMAGE_MSTR_POSITION`) as maxpos',"IMAGE_MSTR_IMAGE_GROUP='".$var[0]."'",'','','','single');
        
            $dataMapArray= array(
                'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                'IMAGE_MSTR_IMAGE_NAME'=>$filenm,
                'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                'IMAGE_MSTR_POSITION'=>($getData->maxpos+1),
            );
        }

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('filename'))
            {
                $error = array('error' => $this->upload->display_errors());
                // print_r($tmp);
                // print_r($error); exit;
                  $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>"'.$error['error'].'"</p></div>');
                redirect(site_url('Deals'));
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                        $this->Crud_model->SaveData('IMAGE_MSTR',$dataMapArray);
                $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
                redirect(site_url('Deals'));
    
                // print_r($_FILES['filename']);
                // print_r($data['upload_data']); exit;
            }
        // }

        // move_uploaded_file($_FILES['filename']['tmp_name'],$upPath.'/'.$_FILES['filename']['name']);
            
        
        // if($var[1]!="Banner" || $var[1]!="Cat-Icon"){
    }
}