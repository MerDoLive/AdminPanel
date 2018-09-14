<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 error_reporting(1);

class Image_Values extends CI_Controller {
    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Images_value_model');
             
    }
    public function index($cond2)
    {
        // echo phpinfo(); exit;
        $data = array('heading'=>'Images Value','cond2' => $cond2);
        $this->load->view('image_values/list',$data);
    }
    

    public function ajax_manage_page($cond2)
    {   
        //$this->load->model('Images_value_model');
        $userData = $this->Images_value_model->get_datatables($cond2);
        //print_r($userData);
        if(empty($_POST['start']))
        {
            $no =0;   
        }else{
            $no =$_POST['start'];
        }
        $data = array(); 
        // print_r($userData); exit;       
        foreach ($userData as $usersData) 
        {
            $btn = anchor(site_url('Image_Values/update/'.$usersData->IMAGE_MSTR_IMAGE_ID),'<button type="button" title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
            $btn .= ' | '.anchor(site_url('Image_Values/delete/'.$usersData->IMAGE_MSTR_IMAGE_ID),'<button type="button" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');

            $no++;
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="checkitems" name="selectedRows[]" value="'.$usersData->IMAGE_MSTR_IMAGE_ID.'" >';
            $nestedData[] = $no;
            $nestedData[] = $usersData->IMAGE_MSTR_IMAGE_ID;
            $nestedData[] = $usersData->IMAGE_MSTR_IMAGE_NAME;
            $nestedData[] = $usersData->IMAGE_MSTR_IMAGE_GROUP;
            $nestedData[] = $usersData->IMAGE_GROUP_SQL;
            $nestedData[] = $usersData->IMAGE_MSTR_IMAGE_STATUS;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Images_value_model->count_all(),
                "recordsFiltered" => $this->Images_value_model->count_filtered(),
                "data" => $data,
                   );
        echo json_encode($output);
    }


    public function view($id)
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
        $this->load->view('image_values/view',$data);
    }


    
    public function delete($id)
    {
        $this->Crud_model->DeleteData('IMAGE_MSTR',"IMAGE_MSTR_IMAGE_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
        redirect('Image_Values');
    }
    
    public function create()
    {
        $allIcon = $this->Crud_model->GetData('ICON_MSTR','',"",'','');
        $allValue = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_STATUS='LIVE'",'','');
        $userData = $this->Images_value_model->get_data_query();
        $data = array('heading'=>'Image Master',
            'subheading'=>'Create Image Master Value',
            'button'=>'Submit',
            'action'=>site_url('Image_Values/create_action'),
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
        $this->load->view('image_values/form',$data);
    }

    public function create_action() 
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
                redirect(site_url('Image_Values'));
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                        $this->Crud_model->SaveData('IMAGE_MSTR',$dataMapArray);
                $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
                redirect(site_url('Image_Values'));
    
                // print_r($_FILES['filename']);
                // print_r($data['upload_data']); exit;
            }
        // }

        // move_uploaded_file($_FILES['filename']['tmp_name'],$upPath.'/'.$_FILES['filename']['name']);
            
        
        // if($var[1]!="Banner" || $var[1]!="Cat-Icon"){
        

    }

    public function update($id)
    {
        $tmp = '/home/image/dev';//ini_get('upload_tmp_dir');
        
        $allIcon = $this->Crud_model->GetData('ICON_MSTR','',"",'','');
        $allValue = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_STATUS='LIVE'",'','');
        $getUsers = $this->Crud_model->GetData('IMAGE_MSTR','',"IMAGE_MSTR_IMAGE_ID='".$id."'",'','','','single');
        $getUsers2 = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$getUsers->IMAGE_MSTR_IMAGE_GROUP."'",'','','','single');
        $userData = $this->Images_value_model->get_data_query();
        
        $data = array('heading'=>'Image Master',
            'subheading'=>'Edit Image Master',
            'button'=>'Update',
            'action'=>site_url('Image_Values/update_action'),
            'filename' => set_value('IMAGE_MSTR_IMAGE_NAME',$getUsers->IMAGE_MSTR_IMAGE_NAME),
            'group' => set_value('IMAGE_MSTR_IMAGE_GROUP',$getUsers->IMAGE_MSTR_IMAGE_GROUP),
            'entityId' =>  set_value('IMAGE_MSTR_ENTITY_ID',$getUsers->IMAGE_MSTR_ENTITY_ID),
            'atribute' => $allValue,
            'startBNR' => set_value('IMAGE_MSTR_START_DATE',date('d-m-Y',strtotime($getUsers->IMAGE_MSTR_START_DATE))),
            'endBNR' => set_value('IMAGE_MSTR_END_DATE',date('d-m-Y',strtotime($getUsers->IMAGE_MSTR_END_DATE))),
            'path' => $tmp,
            'position' => set_value('IMAGE_MSTR_POSITION',$getUsers->IMAGE_MSTR_POSITION),
            'status' => set_value('IMAGE_MSTR_IMAGE_STATUS',$getUsers->IMAGE_MSTR_IMAGE_STATUS),
            'mainIcon' =>$allIcon,
            'type' => set_value('type',$getUsers2->IMAGE_GROUP_SQL),
            'id' => set_value('id',$id),
            'imgmstr' => $userData,
        );
        $this->load->view('image_values/form',$data);
    }
    public function update_action()
    {
        $getUsers = $this->Crud_model->GetData('IMAGE_MSTR','',"IMAGE_MSTR_IMAGE_ID='".$_POST['id']."'",'','','','single'); 
        $checkExists = $this->Crud_model->GetData('IMAGE_MSTR','',"IMAGE_MSTR_IMAGE_ID='".$_POST['id']."'",'','','','single');
        // print_r($checkExists); exit;
        $var = preg_split("#/#",$_POST['group']);
        $getGRPdata = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$var[0]."'",'','','','single');
        
        if(!empty($checkExists))
        {
            if($_FILES['filename']['name']!="")
            {
                $ext=pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
                $filenm= $_POST['id'].'.'.$ext;
                $upload_path= "uploads/images";  
                $tmp = '/home/image/dev';//ini_get('upload_tmp_dir');
                $uid=$var[1]; //creare seperate folder for each user 
                $upPath=$upload_path;
                 $config['upload_path']          = $upload_path;
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 2048000;
                $config['max_width']            = $getGRPdata->IMAGE_GROUP_MSTR_RESOLUTION;
                $config['max_height']           = $getGRPdata->IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS;
                
                // if($var[1]=="Banner"){
                //     $config['max_width']            = 850;
                //     $config['max_height']           = 400;
                // }
                // else if($var[1]=="Category"){
                //     $config['max_width']            = 800;
                //     $config['max_height']           = 360;
                // }
                // else if($var[1]=="Cat-Icon"){
                //     $config['max_width']            = 50;
                //     $config['max_height']           = 50;
                // }

                $config['file_name']           = $filenm;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('filename'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    // echo $upload_path."<br>";
                    $this->session->set_flashdata('message', '
                        <div class="alert alert-block alert-danger">
                        <p>"'.$error['error'].'"</p>
                        </div>
                        ');
                    redirect(site_url('Image_Values'));

                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $image_name=$data['upload_data']['file_name'];
                    if($var[1]=="Banner"){
                        $dataMapArray= array(
                        // 'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                        'IMAGE_MSTR_IMAGE_NAME'=>$image_name,
                        'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                        // 'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                        'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                        'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                        'IMAGE_MSTR_POSITION'=>$_POST['position'],
                        'IMAGE_MSTR_START_DATE'=>date('Y-m-d',strtotime($_POST['startBNR'])),
                        'IMAGE_MSTR_END_DATE'=>date('Y-m-d',strtotime($_POST['endBNR'])),
                        );
                    }
                    else if($var[1]=="Promo"){
                        $dataMapArray= array(
                        // 'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                        'IMAGE_MSTR_IMAGE_NAME'=>$image_name,
                        'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                        // 'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                        'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                        'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                        // 'IMAGE_MSTR_START_DATE'=>date('Y-m-d',strtotime($_POST['startBNR'])),
                        // 'IMAGE_MSTR_END_DATE'=>date('Y-m-d',strtotime($_POST['endBNR'])),
                        );
                    }
                    else{
                        $dataMapArray= array(
                        // 'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                        'IMAGE_MSTR_IMAGE_NAME'=>$image_name,
                        'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                        'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                        'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                        'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],    
                        );
                    }
                    $this->Crud_model->SaveData('IMAGE_MSTR',$dataMapArray,"IMAGE_MSTR_IMAGE_ID='".$_POST['id']."'");
                   
                    $this->session->set_flashdata('message', '
                        <div class="alert alert-block alert-success">
                        <p>Record has been updated successfully.</p>
                        </div>
                        ');
                    redirect(site_url('Image_Values'));
                }
            }
            else{

                $image_name=$this->input->post('old');

                    if($var[1]!="Banner"){
                $dataMapArray= array(
                    // 'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                    'IMAGE_MSTR_IMAGE_NAME'=>$image_name,
                    'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                    'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                    'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                    'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                    );
                }
                else if($var[1]=="Banner"){
                    $dataMapArray= array(
                    // 'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                    'IMAGE_MSTR_IMAGE_NAME'=>$image_name,
                    'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                    // 'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                    'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                    'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                    'IMAGE_MSTR_POSITION'=>$_POST['position'],
                    'IMAGE_MSTR_START_DATE'=>date('Y-m-d',strtotime($_POST['startBNR'])),
                    'IMAGE_MSTR_END_DATE'=>date('Y-m-d',strtotime($_POST['endBNR'])),
                    
                );
            }
                $this->Crud_model->SaveData('IMAGE_MSTR',$dataMapArray,"IMAGE_MSTR_IMAGE_ID='".$_POST['id']."'");
               
                $this->session->set_flashdata('message', '
                    <div class="alert alert-block alert-success">
                    <p>Record has been updated successfully.</p>
                    </div>
                    ');
                redirect(site_url('Image_Values'));
            
            }
            
            // if($var[1]!="Banner" || $var[1]!="Cat-Icon"){
            
        }
        else
        {
            $this->session->set_flashdata('message', '
                <div class="alert alert-block alert-danger">
                <p>Entered Image already exists.</p>
                </div>
                ');
            redirect(site_url('Image_Values/update/'.$_POST['id']));
        }
    }

    public function changeStatus()
    {
        $getUsers = $this->Crud_model->GetData('IMAGE_MSTR','',"id='".$_POST['id']."'",'','','','single');
        if($getUsers->status=='Active')
        {
            $this->Crud_model->SaveData('IMAGE_MSTR',array('status'=>'Inactive'),"id='".$_POST['id']."'");
        }
        else
        {
            $this->Crud_model->SaveData('IMAGE_MSTR',array('status'=>'Active'),"id='".$_POST['id']."'");
        }
        $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success">
            <p>Status has been changed successfully.</p>
            </div>
            ');
        redirect(site_url('Image_Values'));
    } 
    
    public function fetchdata()
    {   
        $id=$_POST['categoryid'];
        $entityId=$_POST['entity'];
        $getUsers = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$id."'",'','','','single');
        $table=$getUsers->IMAGE_GROUP_SQL;
        if($table=="Category" || $table=="Cat-Icon"){
            $mainCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' AND CATG_MSTR_CATEGORY_LEVEL=1",'','');
            print_r("<option value='0'>Select Category</option>");
            foreach($mainCategory as $category){
                print_r($b_option[]="<option value='".$category->CATG_MSTR_CATEGORY_ID."'"); if($category->CATG_MSTR_CATEGORY_ID==$entityId){ echo 'selected';} print_r(">".$category->CATG_MSTR_CATEGORY_NAME."</option>");
            }
        }
        else if($table=="Brand"){
            $mainCategory = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_STATUS='LIVE'",'','');
            print_r("<option value='0'>Select Brand</option>");
            foreach($mainCategory as $category){
            print_r($b_option[]="<option value='".$category->BRND_MSTR_BRAND_ID."'"); if($category->BRND_MSTR_BRAND_ID==$entityId){ echo 'selected';} print_r(">".$category->BRND_MSTR_BRAND_NAME."</option>");
            }
        }
        else if($table=="Product"){
            $mainCategory = $this->Crud_model->GetData('PRODUCT_MSTR','',"PRODUCT_MSTR_STATUS='LIVE'",'','');
            print_r("<option value='0'>Select Product</option>");
            foreach($mainCategory as $category){
            print_r($b_option[]="<option value='".$category->PRODUCT_MSTR_PRODUCT_ID."'"); if($category->PRODUCT_MSTR_PRODUCT_ID==$entityId){ echo 'selected';} print_r(">".$category->PRODUCT_MSTR_PRODUCT_NAME."</option>");
            }
        }
        // else if($table=="Cat-Icon"){
        //     $mainCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_STATUS='LIVE' AND CATG_MSTR_CATEGORY_LEVEL=1",'','');
        //     print_r("<option value='0'>Select Category</option>");
        //     foreach($mainCategory as $category){
        //         print_r($b_option[]="<option value='".$category->CATG_MSTR_CATEGORY_ID."'"); if($category->CATG_MSTR_CATEGORY_ID==$entityId){ echo 'selected';} print_r(">".$category->CATG_MSTR_CATEGORY_NAME."</option>");
        //     }
        // }                                        
    }

        public function bulkdelete()
    {
        $cnt=0;
        foreach($this->input->post('selectedRows') as $value){
            $cnt++;
            // echo $cnt; exit;
           $this->Crud_model->DeleteData('IMAGE_MSTR',"IMAGE_MSTR_IMAGE_ID='".$value."'");
        }

        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>"'.$cnt.'" Records has been deleted successfully.</p></div>');
        redirect('Image_Values');
    }

    public function fetchGRPdata()
    {   
        $id=$_POST['categoryid'];
        $getGRPdata = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_GROUP='".$id."'",'','','','single');
        print_r("<p class='text-danger'>Image Diamention Should be ".$getGRPdata->IMAGE_GROUP_MSTR_RESOLUTION."px(width) X ".$getGRPdata->IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS."px(height)</p> <input type='hidden' name='imgwidth' id='imgwidth' value='".$getGRPdata->IMAGE_GROUP_MSTR_RESOLUTION."'><input type='hidden' name='imgheight' id='imgheight' value='".$getGRPdata->IMAGE_GROUP_MSTR_IMAGE_DIMENTIONS."'>");
        // echo json_encode($getGRPdata);
    } 

}