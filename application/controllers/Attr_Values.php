<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attr_Values extends CI_Controller {
    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Attrs_value_model');
             
    }
    public function index()
    {
        $data = array('heading'=>'Attributes Value');
        $this->load->view('attr_values/list',$data);
    }
    /*public function ajax_manage_page()
    {   
        $userData = $this->Attrs_value_model->get_datatables();
        //print_r($userData); exit;
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
            $no =$_POST['start'];
        }
        $data = array();        
        foreach ($userData as $usersData) 
        {
            // $allAttrCategory = $this->Attrs_value_model->GetAttrData($usersData->ATTR_MSTR_ATTR_ID);
            // print_r($allAttrCategory); exit;
            // $value = '';
            // $x='1';
            // for ($i=0; $i <count($allAttrCategory) ; $i++) { 
            //     $value = $value.$x.". ".ucwords($allAttrCategory[$i]->CATG_MSTR_CATEGORY_NAME)."<br>";  
            //     $x++;     
            // }
           
            $btn = anchor(site_url('Attr_Values/view/'.$usersData->ATTR_MSTR_ATTR_ID),'<button title="View" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-eye"></i></button>');
            $btn .= ' | '.anchor(site_url('Attr_Values/update/'.$usersData->ATTR_MSTR_ATTR_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .= ' | '.anchor(site_url('Attr_Values/delete/'.$usersData->ATTR_MSTR_ATTR_ID),'<button title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            
            if($usersData->ATTR_VALUES_ATTR_STATUS =='LIVE')
            {
                $status =  "<span class='label-success label'>".$usersData->ATTR_VALUES_ATTR_STATUS."</span>";            
            }else if($usersData->ATTR_VALUES_ATTR_STATUS =='PNDG')
                $status =  "<span class='label-primary label'>".$usersData->ATTR_VALUES_ATTR_STATUS."</span>";  
            }else if($usersData->ATTR_VALUES_ATTR_STATUS =='REJ')
            {
                $status =  "<span class='label-warning label'>".$usersData->ATTR_VALUES_ATTR_STATUS."</span>";  
            }else
            {
                $status =  "<span class='label-danger label'>".$usersData->ATTR_VALUES_ATTR_STATUS."</span>";  
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ($usersData->ATTR_MSTR_ATTR_ID);
            $nestedData[] = ucwords($usersData->ATTR_MSTR_ATTR_NAME);
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Attrs_value_model->count_all(),
            "recordsFiltered" => $this->Attrs_value_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }*/

    public function ajax_manage_page()
    {   
         //$this->load->model('Attrs_value_model');
         $userData = $this->Attrs_value_model->get_datatables();
         //print_r($userData);
         if(empty($_POST['start']))
         {
             $no =0;   
         }else{
             $no =$_POST['start'];
         }
         $data = array();        
         foreach ($userData as $usersData) 
         {
             /*$allBrandCategory = $this->Attrs_value_model->GetBrandData($usersData->BRND_MSTR_BRAND_ID);
             $value= '';
             $x=1;
             for ($i=0; $i < count($allBrandCategory); $i++) {
                 $value .= $x. " ) ". $allBrandCategory[$i]->CATG_MSTR_CATEGORY_NAME."<br>"; 
                 $x++;
             }*/
             
             $btn = anchor(site_url('Brands/update/'.$usersData->ATTR_MSTR_ATTR_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
             $btn .= ' | '.anchor(site_url('Brands/delete/'.$usersData->ATTR_MSTR_ATTR_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
 
             if($usersData->ATTR_VALUES_ATTR_STATUS=='LIVE')
             {
                 $status =  "<button class='label-success label'>Live</button>";            
             }
             else if($usersData->ATTR_VALUES_ATTR_STATUS=='PNDG')
             {
                 $status =  "<button class='label-warning label'>PNDG</button>";
             } else{
                 $status =  "<button class='label-danger label'>REJ</button>";
             }
 
             $no++;
             $nestedData = array();
             $nestedData[] = $no;
             $nestedData[] = $usersData->ATTR_MSTR_ATTR_ID;
             $nestedData[] = $usersData->ATTR_VALUES_ATTR_VALUES;
             $nestedData[] = $usersData->ATTR_MSTR_ATTR_NAME;
             $nestedData[] = $usersData->ATTR_VALUES_ATTR_STATUS;
             $nestedData[] = $btn;
             // $nestedData[] = $usersData->ATTR_MSTR_ATTR_ID;
             $data[] = $nestedData;
         }
 
         $output = array(
                 "draw" => $_POST['draw'],
                 "recordsTotal" => $this->Attrs_value_model->count_all(),
                 "recordsFiltered" => $this->Attrs_value_model->count_filtered(),
                 "data" => $data,
                    );
         echo json_encode($output);
    }
    /* public function view($id)
    {
        $getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$id."'",'','','','single');
        $valuesData = $this->Crud_model->GetData('ATTR_VALUES','ATTR_VALUES_ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$id."'"); 
        $data = array('heading'=>'Attr',
            'subheading'=>'View Attr',
            'name' => set_value('name',$getUsers->ATTR_MSTR_ATTR_NAME),
            'status' => set_value('ATTR_MSTR_ATTR_STATUS',$getUsers->ATTR_MSTR_ATTR_STATUS),
            'id' => set_value('id',$id),
            'values' => $valuesData,
            'abtn' => "ADD",
            'values' => $valuesData,
        );
        $this->load->view('attr_values/view',$data);
    }


    
    public function delete($id)
    {
        $this->Crud_model->DeleteData('ATTR_MSTR',"ATTR_MSTR_ATTR_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
        redirect('Attr_Values');
    }
    
    public function create()
    {
        $allValue = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_STATUS='LIVE'",'','');
        $data = array('heading'=>'Attributes',
            'subheading'=>'Create Attributes Value',
            'button'=>'Submit',
            'action'=>site_url('Attr_Values/create_action'),
            'name' => set_value('name'),
            'id' => set_value('id'),
            'atribute' => $allValue,
            'mainatributId' =>'',
        );
        $this->load->view('attr_values/form',$data);
    }
    public function create_action() 
    {
        $this->form_validation->set_rules('valueId', 'valueId', 'required',
            array(
                'required' => 'Please select Attribute',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
        else 
        {
            for ($i=0; $i <count($_POST['attr_value']) ; $i++) { 
                $dataMapArray= array(
                    'ATTR_VALUES_ATTR_ID'=>$_POST['valueId'],
                    'ATTR_VALUES_ATTR_VALUES'=>$_POST['attr_value'][$i],
                );
                $this->Crud_model->SaveData('ATTR_VALUES',$dataMapArray);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
            redirect(site_url('Attr_Values'));
        }
    }
    public function update($id)
    {
        $getUsers = $this->Crud_model->GetData('ATTR_MSTR','',"ATTR_MSTR_ATTR_ID='".$id."'",'','','','single');
        $valuesData = $this->Crud_model->GetData('ATTR_VALUES','ATTR_VALUES_ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$id."'"); 
        $data = array('heading'=>'Attr',
            'subheading'=>'Edit Attr',
            'button'=>'Update',
            'action'=>site_url('Attr_Values/update_action'),
            'name' => set_value('name',$getUsers->ATTR_MSTR_ATTR_NAME),
            'desc' => set_value('desc',$getUsers->ATTR_MSTR_ATTR_DESC),
            'status' => set_value('ATTR_MSTR_ATTR_STATUS',$getUsers->ATTR_MSTR_ATTR_STATUS),
            'status1' => set_value('ATTR_MSTR_ATTR_TYPE',$getUsers->ATTR_MSTR_ATTR_TYPE),
            'id' => set_value('id',$id),
            'values' => $valuesData,
            'abtn' => "ADD",
        );
        $this->load->view('attr_values/form',$data);
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
                $this->Crud_model->DeleteData('ATTR_VALUES',"ATTR_VALUES_ATTR_ID='".$_POST['id']."'");
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
                $this->session->set_flashdata('message', '
                    <div class="alert alert-block alert-success">
                    <p>Record has been updated successfully.</p>
                    </div>
                    ');
                redirect(site_url('Attr_Values'));
            }
        }
        else
        {
            $this->session->set_flashdata('message', '
                <div class="alert alert-block alert-danger">
                <p>Entered Attr already exists.</p>
                </div>
                ');
            redirect(site_url('Attr_Values/update/'.$_POST['id']));
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
        redirect(site_url('Attr_Values'));
    }   */

}