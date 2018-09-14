<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
class Attr_Masters extends CI_Controller {
    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Attrs_model');
        $this->load->model('Crud_model');       
    }
    public function index($cond2)
    {
        $data = array('heading'=>'Attributes Managment', 'cond2' => $cond2);
        $this->load->view('attr_masters/list',$data);
    }
    public function ajax_manage_page($cond2)
    {   
        $userData = $this->Attrs_model->get_datatables($cond2);
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
            $no =$_POST['start'];
        }
        $data = array();        
        foreach ($userData as $usersData) 
        {
            $allAttrCategory = $this->Attrs_model->GetAttrData($usersData->ATTR_MSTR_ATTR_ID);
            ///print_r($allAttrCategory); exit;
            $value = '';
            $x='1';
            for ($i=0; $i <count($allAttrCategory) ; $i++) { 
                $value = $value.$x.". ".ucwords($allAttrCategory[$i]->CATG_MSTR_CATEGORY_NAME)."<br>";  
                $x++;     
            }
            $allAttrvalue = $this->Attrs_model->GetAttrValueData($usersData->ATTR_MSTR_ATTR_ID);
            $attrvalue = '';
            $y='1';
            for ($i=0; $i <count($allAttrvalue) ; $i++) { 
                $attrvalue = $attrvalue.$y.". ".ucwords($allAttrvalue[$i]->ATTR_VALUES_ATTR_VALUES)."<br>";  
                $y++;     
            }
            
            $btn = anchor(site_url('Attr_Masters/view/'.$usersData->ATTR_MSTR_ATTR_ID),'<button title="View" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-eye"></i></button>');
            $btn .= ' | '.anchor(site_url('Attr_Masters/update/'.$usersData->ATTR_MSTR_ATTR_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .= ' | '.anchor(site_url('Attr_Masters/delete/'.$usersData->ATTR_MSTR_ATTR_ID),'<button title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            
            if($usersData->ATTR_MSTR_ATTR_STATUS =='LIVE')
            {
                $status =  "<span class='label-success label'>".$usersData->ATTR_MSTR_ATTR_STATUS."</span>";            
            }else if($usersData->ATTR_MSTR_ATTR_STATUS =='PNDG')
            {
                $status =  "<span class='label-primary label'>".$usersData->ATTR_MSTR_ATTR_STATUS."</span>";  
            }else if($usersData->ATTR_MSTR_ATTR_STATUS =='REJ')
            {
                $status =  "<span class='label-warning label'>".$usersData->ATTR_MSTR_ATTR_STATUS."</span>";  
            }else
            {
                $status =  "<span class='label-danger label'>".$usersData->ATTR_MSTR_ATTR_STATUS."</span>";  
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ($usersData->ATTR_MSTR_ATTR_ID);
            $nestedData[] = ucwords($usersData->ATTR_MSTR_ATTR_NAME);
            $nestedData[] = $value;
            $nestedData[] = $attrvalue;
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Attrs_model->count_all(),
            "recordsFiltered" => $this->Attrs_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function view($id)
    {
        $getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$id."'",'','','','single');
        $valuesData = $this->Crud_model->GetData('ATTR_VALUES','ATTR_VALUES_ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$id."'"); 
        $categoryData = $this->Crud_model->GetData('CATG_ATTR_MAP','CATG_ATTR_MAP_CATEGORY_ID',"CATG_ATTR_MAP_ATTR_ID='".$id."'"); 
        $data = array('heading'=>'Attr',
            'subheading'=>'Attribute View',
            'action'=>site_url('Attr_Masters/update_action'),
            'name' => set_value('name',$getUsers->ATTR_MSTR_ATTR_NAME),
            'desc' => set_value('desc',$getUsers->ATTR_MSTR_ATTR_DESC),
            'status' => set_value('ATTR_MSTR_ATTR_STATUS',$getUsers->ATTR_MSTR_ATTR_STATUS),
            'id' => set_value('id',$id),
            'values' => $valuesData,
            'abtn' => "ADD",
            'categories' =>$categoryData,
        );
        $this->load->view('attr_masters/view',$data);
    }


    
	public function delete($id)
	{
         $this->Crud_model->DeleteData('CATG_ATTR_MAP',"CATG_ATTR_MAP_ATTR_ID='".$id."'");
        $this->Crud_model->DeleteData('ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$id."'");
        $this->Crud_model->DeleteData('ATTR_MSTR',"ATTR_MSTR_ATTR_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
		redirect('Attr_Masters');
    }
    
    public function create()
    {
        $allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE'",'','');
        $data = array('heading'=>'blogs',
            'subheading'=>'Create Attributes',
            'button'=>'Submit',
            'action'=>site_url('Attr_Masters/create_action'),
            'name' => set_value('name'),
            'desc' => set_value('desc'),
            'value' => set_value('value'),
            'status1' => set_value('status1'),
            'pageStatus' => set_value('pageStatus'),
            'id' => set_value('id'),
            'categories' => $allCategory,
        );
        $this->load->view('attr_masters/form',$data);
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
           /// print_r($_POST); EXIT;
            $dataProcedure = $this->db->query("SELECT GET_SEQ('ATTR')");
            $result = $dataProcedure->row();
            foreach ($result as $value) 
                $array[] = $value;
                $dataArray= array(
                                'ATTR_MSTR_ATTR_ID'=>$array[0],
                                'ATTR_MSTR_ATTR_NAME'=>$_POST['name'],
                                'ATTR_MSTR_ATTR_DESC'=>$_POST['desc'],
                                'ATTR_MSTR_ATTR_TYPE'=>$_POST['type_id'],
                             );
                $this->Crud_model->SaveData('ATTR_MSTR',$dataArray);
                for ($i=0; $i <count($_POST['categoryId']) ; $i++) { 
                    $dataMapArray= array(
                        'CATG_ATTR_MAP_ATTR_ID'=>$array[0],
                        'CATG_ATTR_MAP_CATEGORY_ID'=>$_POST['categoryId'][$i],
                        'CATG_ATTR_MAP_PAGE'=>$_POST['CATG_ATTR_MAP_PAGE'],
                        'CATG_ATTR_MAP_MANDATORY'=>$_POST['CATG_ATTR_MAP_MANDATORY'],
                        'CATG_ATTR_DISPLAY_TYPE'=>$_POST['CATG_ATTR_DISPLAY_TYPE'],
                        
                    );
                    $this->Crud_model->SaveData('CATG_ATTR_MAP',$dataMapArray);
                }
                
                 for ($i=0; $i <count($_POST['attr_value']) ; $i++) { 
                $dataMapArray1= array(
                    'ATTR_VALUES_ATTR_ID'=>$array[0],
                    'ATTR_VALUES_ATTR_VALUES'=>$_POST['attr_value'][$i],
                );
                $this->Crud_model->SaveData('ATTR_VALUES',$dataMapArray1);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
            redirect(site_url('Attr_Masters'));
        }
    }
    public function update($id)
    {
        $getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$id."'",'','','','single');
        $valuesData = $this->Crud_model->GetData('ATTR_VALUES','ATTR_VALUES_ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$id."'"); 
        $valuesData = $this->Crud_model->GetData('ATTR_VALUES','ATTR_VALUES_ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$id."'"); 
        $allCategoryAttrMap = $this->Crud_model->GetData('CATG_ATTR_MAP','',"CATG_ATTR_MAP_ATTR_ID='".$id."'",'','','','singel');
        $allCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE'",'','');
        $allSelectedAttrCategoryMap = $this->db->query('select CATG_ATTR_MAP_CATEGORY_ID from CATG_ATTR_MAP where CATG_ATTR_MAP_ATTR_ID="'.$id.'"')->result();
        $data = array('heading'=>'Attr',
            'subheading'=>'Edit Attribute',
            'button'=>'Update',
            'action'=>site_url('Attr_Masters/update_action'),
            'name' => set_value('name',$getUsers->ATTR_MSTR_ATTR_NAME),
            'desc' => set_value('desc',$getUsers->ATTR_MSTR_ATTR_DESC),
            'status' => set_value('ATTR_MSTR_ATTR_STATUS',$getUsers->ATTR_MSTR_ATTR_STATUS),
            'status1' => set_value('ATTR_MSTR_ATTR_TYPE',$getUsers->ATTR_MSTR_ATTR_TYPE),
            'pageStatus' => set_value('CATG_ATTR_MAP_PAGE',$allCategoryAttrMap->CATG_ATTR_MAP_PAGE),
            'isMandatory' => set_value('CATG_ATTR_MAP_MANDATORY',$allCategoryAttrMap->CATG_ATTR_MAP_MANDATORY),
            'selectedVal'=> $allSelectedAttrCategoryMap,
            'id'=>set_value('id',$id),
            'values' => $valuesData,
            'categories' => $allCategory,
            'abtn' => "ADD",
        );
        //print_r($data); exit;
        $this->load->view('attr_masters/form',$data);
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
                $dataArray= array(
                	'ATTR_MSTR_ATTR_NAME'=>$_POST['name'],
                    'ATTR_MSTR_ATTR_DESC'=>$_POST['desc'],
                    'ATTR_MSTR_ATTR_TYPE'=>$_POST['type_id'],
                );
                $this->Crud_model->SaveData('ATTR_MSTR',$dataArray,"ATTR_MSTR_ATTR_ID='".$_POST['id']."'");
                $this->Crud_model->DeleteData('ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$_POST['id']."'");
                $this->Crud_model->DeleteData('CATG_ATTR_MAP',"CATG_ATTR_MAP_ATTR_ID='".$_POST['id']."'");
                for ($i=0; $i <count($_POST['attr_value']) ; $i++) { 
                    $getvalue =$this->Crud_model->GetData('ATTR_VALUES','',"ATTR_VALUES_ATTR_ID='".$_POST['id']."' and ATTR_VALUES_ATTR_VALUES='".$_POST['attr_value'][$i]."'");
                    if(count($getvalue)=='0')
                    {
                        $datavalueArray= array(
                            'ATTR_VALUES_ATTR_ID'=>$_POST['id'],
                            'ATTR_VALUES_ATTR_VALUES'=>$_POST['attr_value'][$i],
                        );
                        $this->Crud_model->SaveData('ATTR_VALUES',$datavalueArray);
                    }
                }
                for ($i=0; $i <count($_POST['categoryId']) ; $i++) { 
                    $dataMapArray= array(
                        'CATG_ATTR_MAP_ATTR_ID'=>$_POST['id'],
                        'CATG_ATTR_MAP_CATEGORY_ID'=>$_POST['categoryId'][$i],
                        'CATG_ATTR_MAP_PAGE'=>$_POST['CATG_ATTR_MAP_PAGE'],
                        'CATG_ATTR_MAP_MANDATORY'=>$_POST['CATG_ATTR_MAP_MANDATORY'],
                        'CATG_ATTR_DISPLAY_TYPE'=>$_POST['CATG_ATTR_DISPLAY_TYPE'],
                        
                    );
                    $this->Crud_model->SaveData('CATG_ATTR_MAP',$dataMapArray);
                }
                $this->session->set_flashdata('message', '
                    <div class="alert alert-block alert-success">
                    <p>Record has been updated successfully.</p>
                    </div>
                    ');
                redirect(site_url('Attr_Masters'));
            }
        }
        else
        {
            $this->session->set_flashdata('message', '
                <div class="alert alert-block alert-danger">
                <p>Entered Attr already exists.</p>
                </div>
                ');
            redirect(site_url('Attr_Masters/update/'.$_POST['id']));
        }
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
        $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success">
            <p>Status has been changed successfully.</p>
            </div>
            ');
        redirect(site_url('Attr_Masters'));
    }  
}
