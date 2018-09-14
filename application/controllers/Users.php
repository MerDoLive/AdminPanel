<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);
class Users extends CI_Controller {

	function __construct()
   	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Users_model');
        $this->load->model('Crud_model');		
   	}

	public function index($cond2)
	{
        /* try
        {
            $data = array('heading'=>'Users');
            $this->load->view('users/list',$data);
        }
        catch(Exception $e)
        {
            print_r($e);
            $this->session->set('form_errors', $e->errors());
        } */
        $data = array('heading'=>'Users','cond2'=>$cond2);
        $this->load->view('users/list',$data);
	}

	public function ajax_manage_page($cond2)
    {  	
		$userData = $this->Users_model->get_datatables($cond2);
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
             $no =$_POST['start'];
        }
		$data = array();		
		foreach ($userData as $usersData) 
		{
            
            $btn = anchor(site_url('Users/update/'.$usersData->USER_MSTR_USER_ID),'<button title="Edit" class="btn btn-xs btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .= ' | ' .anchor(site_url('Users/delete/'.$usersData->USER_MSTR_USER_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-xs btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            $btn .= ' | ' .anchor(site_url('Users/pass_ch/'.$usersData->USER_MSTR_USER_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to Change Password?\')" title="Change Password" class="btn btn-xs  waves-effect"><i class="glyphicon glyphicon-retweet"></i></button>');
            if($usersData->USER_MSTR_STATUS=='LIVE')
            {
                $status =  "<button class='label-success label'>Live</button>";            
            }
            else if($usersData->USER_MSTR_STATUS=='PNDG')
            {
                $status =  "<button class='label-warning label'>PNDG</button>";
            } 
            else if($usersData->USER_MSTR_STATUS=='REJ')
            {
            	$status =  "<button class='label-info label'>REJ</button>";
            } 
            else
            {
                $status =  "<button class='label-danger label'>DLTD</button>";
            }

			$no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $usersData->USER_MSTR_USER_ID;
            $nestedData[] = $usersData->USER_MSTR_USER_TYPE_ID;
		    $nestedData[] = $usersData->USER_MSTR_USER_PASS;
		    $nestedData[] = $usersData->USER_MSTR_USER_NAME;
            $nestedData[] = $usersData->USER_MSTR_USER_DESC;
            $nestedData[] = $status;
            //$nestedData[] = $usersData->USER_MSTR_SUBSTATUS;
		    $nestedData[] = $btn;
            $data[] = $nestedData;
            
		}
        
        $output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->Users_model->count_all(),
					"recordsFiltered" => $this->Users_model->count_filtered(),
					"data" => $data,
                );
		echo json_encode($output);
    }

    //Creating new user
    public function create()
    {
        $userrole = $this->Crud_model->GetData('USER_ROLE_MSTR','',"",'','');
        $data = array('heading'=>'Users',
    				'subheading'=>'Create User',
    				'button'=>'Submit',
                    'action'=>site_url('Users/create_action'),
                    'usertype'=>$userrole,
                    'roleid'=>set_value('USER_ROLE_MSTR_TYPE_ID'),
                    'id' => set_value('id'),
                    'userName' => set_value('userName'),
                    'pass' => set_value('pass'),
                    'desc' => set_value('desc'), 
                    'status' => set_value('PNDG')
                );  
        $this->load->view('users/form',$data);
    }

    public function create_action() 
    {
       //echo "Coming Here";
            $dataProcedure = $this->db->query("SELECT GET_SEQ('USER')");
            $result = $dataProcedure->row();
            $encrypt_password = md5($_POST['pass']);
            foreach ($result as $value) 
            $array[] = $value;
            //print_r($array);
            $dataArray= array('USER_MSTR_USER_ID'=>$array[0],
                             'USER_MSTR_USER_TYPE_ID'=>$_POST['userRole'],
                            'USER_MSTR_USER_NAME'=>$_POST['userName'],
                            'USER_MSTR_USER_DESC'=>$_POST['desc'],
                            'USER_MSTR_USER_PASS'=>$encrypt_password,
                            'USER_MSTR_STATUS' => "PNDG",                   
                        );
                            
            $this->Crud_model->SaveData('USER_MSTR',$dataArray);
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
            redirect(site_url('Users'));
        
    }

    //Update an Existing User
    public function update($id)
    {
        $userrole = $this->Crud_model->GetData('USER_ROLE_MSTR','',"",'','');
        $getUsers = $this->Crud_model->GetData('USER_MSTR','',"USER_MSTR_USER_ID='".$id."'",'','','','single');
		$data = array('heading'=>'Users',
                    'subheading'=>'Edit Users',
                    'button'=>'Update',
                    'action'=>site_url('Users/update_action'),
                    'id' => set_value('id',$id),
                    'usertype'=>$userrole,
                    'userName' => set_value('userName',$getUsers->USER_MSTR_USER_NAME),
                   // 'pass' => set_value('pass',$getUsers->USER_MSTR_USER_PASS),
                    'desc' => set_value('desc',$getUsers->USER_MSTR_USER_DESC),
                    'status' => set_value('status',$getUsers->USER_MSTR_STATUS)
                    
                );
        $this->load->view('users/form',$data);
    }

    public function update_action() 
    {
        if(empty($id))
        {
            $id = $_POST['USER_MSTR_ID'];
        } 
        $getUsers = $this->Crud_model->GetData('USER_MSTR','',"USER_MSTR_USER_ID='".$id."'",'','','','single');
        $encrypt_password = md5($_POST['USER_MSTR_USER_PASS']);
        $dataArray= array(
                             'USER_MSTR_USER_TYPE_ID'=>$_POST['userRole'],
                            'USER_MSTR_USER_NAME' =>$_POST['userName'],
                          //  'USER_MSTR_USER_PASS'=>$encrypt_password,
                            'USER_MSTR_USER_DESC'=>$_POST['desc'] ,
                            'USER_MSTR_STATUS' =>$_POST['status'],
                    );
        $this->Crud_model->SaveData('USER_MSTR',$dataArray,"USER_MSTR_USER_ID='".$id."'");
        $this->session->set_flashdata('message', '<span class="label label-success" style="font-size:12px;">Record updated successfully</span>');
        redirect(site_url('Users'));
        
    }
    
    //For Deleting User
    public function delete($id) 
    { 
        /* $this->Crud_model->DeleteData('USER_MSTR',"USER_MSTR_USER_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Record has been deleted successfully.</p></div>');
        redirect(site_url('Users')); */

        $dataArray= array('USER_MSTR_STATUS'=>'DLTD');
		$this->Crud_model->SaveData('USER_MSTR',$dataArray,"USER_MSTR_USER_ID='".$id."'");
		$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
		redirect('Users');
    }

//for password change

    public function pass_ch($id)
    {
        $userrole = $this->Crud_model->GetData('USER_ROLE_MSTR','',"",'','');
        $getUsers = $this->Crud_model->GetData('USER_MSTR','',"USER_MSTR_USER_ID='".$id."'",'','','','single');
		$data = array('heading'=>'Users',
                    'subheading'=>'Change Password',
                    'button'=>'Update',
                    'action'=>site_url('Users/pass_ch_action'),
                    'id' => set_value('id',$id),
                    //'usertype'=>$userrole,
                    
                    'pass' => set_value('pass',$getUsers->USER_MSTR_USER_PASS),
                   
                );
        $this->load->view('users/pass_ch',$data);
    }


    public function pass_ch_action() 
    {
        if(empty($id))
        {
            $id = $_POST['USER_MSTR_ID'];
        } 
        $getUsers = $this->Crud_model->GetData('USER_MSTR','',"USER_MSTR_USER_ID='".$id."'",'','','','single');
        $encrypt_password = md5($_POST['conpass']);
        $dataArray= array(
                           /*   'USER_MSTR_USER_TYPE_ID'=>$_POST['userRole'],
                            'USER_MSTR_USER_NAME' =>$_POST['userName'], */
                            'USER_MSTR_USER_PASS'=>$encrypt_password,
                            /* 'USER_MSTR_USER_DESC'=>$_POST['desc'] ,
                            'USER_MSTR_STATUS' =>$_POST['status'], */
                    );
        $this->Crud_model->SaveData('USER_MSTR',$dataArray,"USER_MSTR_USER_ID='".$id."'");
        $this->session->set_flashdata('message', '<span class="label label-success" style="font-size:12px;">Record updated successfully</span>');
        redirect(site_url('Users'));
        
    }
    
    public function filter()
    {
        
    }
}
?>