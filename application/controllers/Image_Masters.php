<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);
class Image_Masters extends CI_Controller {
    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Images_model');
        $this->load->model('Crud_model');       
    }
    public function index($cond2)
    {
        $data = array('heading'=>'Images Managment', 'cond2' => $cond2);
        $this->load->view('image_masters/list',$data);
    }
    public function ajax_manage_page($cond2)
    {   
        $userData = $this->Images_model->get_datatables($cond2);
// print_r($userData); exit;
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
            $no =$_POST['start'];
        }
        $data = array();        
        foreach ($userData as $usersData) 
        {

            
// print_r($value); exit;
            $btn = anchor(site_url('Image_Masters/view/'.$usersData->IMAGE_GROUP_MSTR_GROUP),'<button title="View" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-eye"></i></button>');
            $btn .= ' | '.anchor(site_url('Image_Masters/update/'.$usersData->IMAGE_GROUP_MSTR_GROUP),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .= ' | '.anchor(site_url('Image_Masters/delete/'.$usersData->IMAGE_GROUP_MSTR_GROUP),'<button title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            
            if($usersData->IMAGE_GROUP_MSTR_STATUS =='LIVE')
            {
                $status =  "<span class='label-success label'>".$usersData->IMAGE_GROUP_MSTR_STATUS."</span>";            
            }else if($usersData->IMAGE_GROUP_MSTR_STATUS =='PNDG')
            {
                $status =  "<span class='label-primary label'>".$usersData->IMAGE_GROUP_MSTR_STATUS."</span>";  
            }else if($usersData->IMAGE_GROUP_MSTR_STATUS =='REJ')
            {
                $status =  "<span class='label-warning label'>".$usersData->IMAGE_GROUP_MSTR_STATUS."</span>";  
            }else
            {
                $status =  "<span class='label-danger label'>".$usersData->IMAGE_GROUP_MSTR_STATUS."</span>";  
            }
            $no++;
            $nestedData = array();
            /*$nestedData[] ='<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value='.$usersData->ATTR_MSTR_ATTR_ID.'>';*/
            $nestedData[] = $no;
            $nestedData[] = ($usersData->IMAGE_GROUP_MSTR_GROUP);
            $nestedData[] = ($usersData->IMAGE_GROUP_MSTR_SIZE);
            $nestedData[] = ($usersData->IMAGE_GROUP_MSTR_RESOLUTION."px");
            $nestedData[] = ($usersData->IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS."px");
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Images_model->count_all(),
            "recordsFiltered" => $this->Images_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function view($id)
    {
        $getUsers = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$id."'",'','','','single');
        
        $data = array('heading'=>'Attr',
            'subheading'=>'View Attr',
            'action'=>site_url('Image_Masters/update_action'),
            'name' => set_value('name',$getUsers->IMAGE_GROUP_MSTR_GROUP),
            'size' => set_value('size',$getUsers->IMAGE_GROUP_MSTR_SIZE),
            'resolution' => set_value('resolution',$getUsers->IMAGE_GROUP_MSTR_RESOLUTION),
            'dimention' => set_value('dimention',$getUsers->IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS),
            'status1' => set_value('status1',$getUsers->IMAGE_GROUP_MSTR_STATUS),
            'id' => set_value('id',$id),
            'abtn' => "ADD",
        );
        $this->load->view('image_masters/view',$data);
    }


    
    public function delete($id)
    {
        $this->Crud_model->DeleteData('IMAGE_GROUP_MSTR',"IMAGE_GROUP_MSTR_GROUP='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
        redirect('Image_Masters');
    }

    public function create()
    {
        // $allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE'",'','');
        $data = array('heading'=>'Images Group Master',
            'subheading'=>'Create Images Group',
            'button'=>'Submit',
            'action'=>site_url('Image_Masters/create_action'),
            'name' => set_value('name'),
            'size' => set_value('size'),
            'resolution' => set_value('resolution'),
            'dimention' => set_value('dimention'),
            'status1' => set_value('status1'),
            'type' => set_value('type'),
        );
        $this->load->view('image_masters/form',$data);
    }

    public function create_action() 
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required',
            array(
                'required' => 'Please enter name',
                'regex_match' => 'Please enter valid name',                
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
        else 
        {
           /// print_r($_POST); exit;
            // $dataProcedure = $this->db->query("SELECT GET_SEQ('ATTR')");
            // $result = $dataProcedure->row();
            // foreach ($result as $value) 
            //     $array[] = $value;
                $dataArray= array(
                                // 'ATTR_MSTR_ATTR_ID'=>$array[0],
                                'IMAGE_GROUP_MSTR_GROUP'=>$_POST['name'],
                                'IMAGE_GROUP_MSTR_SIZE'=>$_POST['size'],
                                'IMAGE_GROUP_MSTR_RESOLUTION'=>$_POST['resolution'],
                                'IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS'=>$_POST['dimention'],
                                'IMAGE_GROUP_MSTR_IMAGE_STATUS'=>$_POST['status1'],
                                'IMAGE_GROUP_SQL'=>$_POST['type'],
                             );
                $this->Crud_model->SaveData('IMAGE_GROUP_MSTR',$dataArray);
                // for ($i=0; $i <count($_POST['categoryId']) ; $i++) { 
                //     $dataMapArray= array(
                //         'CATG_ATTR_MAP_ATTR_ID'=>$array[0],
                //         'CATG_ATTR_MAP_CATEGORY_ID'=>$_POST['categoryId'][$i],
                //     );
                //     $this->Crud_model->SaveData('CATG_ATTR_MAP',$dataMapArray);
                // }
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
            redirect(site_url('Image_Masters'));
        }
    }
    public function update($id)
    {
        $getUsers = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$id."'",'','','','single');
        $data = array('heading'=>'Images Group Master',
            'subheading'=>'Edit Images Group',
            'button'=>'Update',
            'action'=>site_url('Image_Masters/update_action'),
            'name' => set_value('name',$getUsers->IMAGE_GROUP_MSTR_GROUP),
            'size' => set_value('size',$getUsers->IMAGE_GROUP_MSTR_SIZE),
            'resolution' => set_value('resolution',$getUsers->IMAGE_GROUP_MSTR_RESOLUTION),
            'dimention' => set_value('dimention',$getUsers->IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS),
            'status1' => set_value('status1',$getUsers->IMAGE_GROUP_MSTR_STATUS),
            'type' => set_value('type',$getUsers->IMAGE_GROUP_SQL),
            'abtn' => "ADD",
        );
        $this->load->view('image_masters/form',$data);
    }
    public function update_action()
    {
        $getUsers = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$_POST['name']."'",'','','','single'); 
        
        $dataArray= array('IMAGE_GROUP_MSTR_SIZE'=>$_POST['size'],
                          'IMAGE_GROUP_MSTR_RESOLUTION'=>$_POST['resolution'],
                          'IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS'=>$_POST['dimention'],
                          'IMAGE_GROUP_MSTR_IMAGE_STATUS'=>$_POST['status1'],
                          'IMAGE_GROUP_SQL'=>$_POST['type'],
                    );
        
        $this->Crud_model->SaveData('IMAGE_GROUP_MSTR',$dataArray,"IMAGE_GROUP_MSTR_GROUP='".$_POST['name']."'");
                // $this->Crud_model->DeleteData('ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$_POST['id']."'");
                // for ($i=0; $i <count($_POST['attr_value']) ; $i++) { 
                //     $getvalue =$this->Crud_model->GetData('ATTR_VALUES','',"ATTR_VALUES_ATTR_ID='".$_POST['id']."' and ATTR_VALUES_ATTR_VALUES='".$_POST['attr_value'][$i]."'");
                //     if(count($getvalue)=='0')
                //     {
                //         $datavalueArray= array(
                //             'ATTR_VALUES_ATTR_ID'=>$_POST['id'],
                //             'ATTR_VALUES_ATTR_VALUES'=>$_POST['attr_value'][$i],
                //         );
                //         $this->Crud_model->SaveData('ATTR_VALUES',$datavalueArray);
                //     }
                // }
        $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success">
            <p>Record has been updated successfully.</p>
            </div>');
        redirect(site_url('Image_Masters'));
    }
    public function changeStatus()
    {
        $getUsers = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$_POST['name']."'",'','','','single');
        if($getUsers->status=='Active')
        {
            $this->Crud_model->SaveData('IMAGE_GROUP_MSTR',array('status'=>'Inactive'),"IMAGE_GROUP_MSTR_GROUP='".$_POST['name']."'");
        }
        else
        {
            $this->Crud_model->SaveData('IMAGE_GROUP_MSTR',array('status'=>'Active'),"IMAGE_GROUP_MSTR_GROUP='".$_POST['name']."'");
        }
        $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success">
            <p>Status has been changed successfully.</p>
            </div>
            ');
        redirect(site_url('Image_Masters'));
    }  
}