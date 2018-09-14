<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
   	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Crud_model');
   	}

	public function index()
	{
		$this->load->view('index');
	}

	public function login_action()
	{
		$condition = "USER_MSTR_USER_NAME= '".$this->input->post('username')."' and USER_MSTR_USER_PASS='".md5($this->input->post('password'))."' and USER_MSTR_STATUS= 'LIVE'";
		$user = $this->Crud_model->GetData("USER_MSTR",'',$condition,'','','','single');
		if(!empty($user))
		{
			unset($user->PASSWORD);
			$sess_array['tbsCampaign'] = array('id'=>$user->USER_MSTR_USER_ID,
										'name'=>$user->USER_MSTR_USER_NAME,
										'type'=>$user->USER_MSTR_USER_TYPE_ID,
									);	
			$this->session->set_userdata($sess_array);
			print_r("login should be oK");
			redirect('Dashboard/index');
		}
		else
		{
			$this->session->set_flashdata('msg', 'Invalid login credentials.');
			redirect(site_url('Login/index'));
		}		
	}

	public function logout()
	{
		//session_destroy();
		unset($_SESSION['tbsCampaign']);
		redirect(site_url('Login/index'));
	}

	public function change_password()
	{
		$data = array('action'=>site_url('Login/changePass'));
		$this->load->view('change_password',$data);
	}

	public function changePass()
	{
		$user = $this->Crud_model->GetData("users",'',"id='".$_SESSION['tbsCampaign']['id']."'",'','','','single');
		if($user->SHOW_PASSWORD==$_POST['current_password'])
		{
			$data = array('PASSWORD'=>md5($_POST['new_password']),
						'SHOW_PASSWORD'=>$_POST['new_password'],
					);
			$passwordUpdate = $this->Crud_model->SaveData('users',$data,"ID='".$_SESSION['tbsCampaign']['id']."'");
			
			session_destroy();
			redirect(site_url('Login/index'));
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-block alert-danger">
                                                <p>Current password is not correct.</p></div>');
            redirect(site_url('Login/change_password'));
		}
	}

	public function GoHome()
	{
		redirect(site_url('Login/index'));
	}

	public function profile()
	{
	    $id = ($_SESSION['tbsCampaign']['id']);
		$con = "id='$id'";
	    $row = $this->Crud_model->GetData('users','',$con,'','','','single');
	    $data = array(
		     'name' => $row->name,
			 'mobile' => $row->mobile,
			 'email' => $row->email,
			 'image' => $row->image,
			 'modified' => $row->modified,
		);
	    //print_r($row);exit;
		$this->load->view('edit_profile', $data);
	}
	// Profile Edit Action
	public function edit_profile(){

		$this->form_validation->set_rules(
			'name', 'name','trim|required|regex_match[/^[a-zA-Z ]*$/]|min_length[3]',
			array(
					'required'      => 'Please enter %s',
					'min_length' => 'Please enter minimun 3 characters',
					'regex_match' => 'Please enter valid %s',
			)
	    );
		
		 /*$this->form_validation->set_rules(
			'email', 'email','trim|required|valid_email',
			array(
					'required'      => 'Please enter %s',
			)
	    );
		
		 $this->form_validation->set_rules(
			'mobile', 'mobile','trim|required|regex_match[/^[7-9]{1}[0-9]{9}$/i]',
			array(
					'required'      => 'Please enter %s',
					'regex_match' => 'Please enter valid %s',
			)
	    );*/
		
		if ($this->form_validation->run() == FALSE) {
            $this->index();
		} 
        else
        {
          $id = ($_SESSION['tbsCampaign']['id']);
        
        if($_FILES['image']['name']!='')
		{
			$file_element_name = 'image';
			$config['upload_path'] = getcwd().'/uploads/users';
			$config['allowed_types'] = 'jpg|png|JPEG|jpeg|PNG|JPG|bmp';
			$config['max_size'] = 1024 * 8;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload($file_element_name))
			{
				$error =$this->upload->display_errors('<p style="color:#AF5655;">', '</p>');
				$this->session->set_flashdata('image_error', '<p style="color:red;">This file type is not allowed</p>');
			      $this->index();
			}
			else
			{
			  $file_name = $this->upload->data();
			  $data=array('name'=>$this->input->post('name'),
						'email'=>$this->input->post('email'),
						'image'=>$file_name['file_name'],
						'mobile' => $this->input->post('mobile'),
				     	'modified' => date("Y-m-d h:i:s")
						);
			    $this->Crud_model->SaveData('users',$data,"id='".$id."'");
				$this->session->set_flashdata('message', 'Profile has been updated Successfully');
				redirect(site_url('Login/profile'));
			}
		}

        else {  
			    $id = ($_SESSION['tbsCampaign']['id']);
				$data = array(
					 'name' => $this->input->post('name'),
					 'email' => $this->input->post('email'),
					 'mobile' => $this->input->post('mobile'),
					 'modified' => date("Y-m-d h:i:s"),
				);		
				
				$this->Crud_model->SaveData('users',$data,"id='".$id."'");
				$this->session->set_flashdata('message', 'Profile has been updated Successfully');
				redirect(site_url('Login/profile'));
		}
		}		
	}
}
