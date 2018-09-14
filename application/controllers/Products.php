<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);
class Products extends CI_Controller {

	function __construct()
	{
		parent::__construct();      
		$this->load->database();
		$this->load->model('Products_model');
		$this->load->model('Crud_model'); 
		$this->load->model('Images_value_model'); 
		$this->load->model('Categories_Subcategories_model', 'cat_subcat_model', TRUE);       
	}

	public function index($cond2)
	{
		$data = array('heading'=>'Products','cond2'=>$cond2);
		$this->load->view('products/list',$data);
	}

	public function ajax_manage_page($cond2)
	{   
		$userData = $this->Products_model->get_datatables($cond2);
		if(empty($_POST['start']))
		{
			$no =0;   
		}else{
			$no =$_POST['start'];
		}
		$data = array();        
		foreach ($userData as $usersData) 
		{
			
			$CATEGORY = $this->Crud_model->GetData('CATG_MSTR','CATG_MSTR_CATEGORY_NAME',"CATG_MSTR_CATEGORY_ID='".$usersData->PRODUCT_MSTR_CATEGORY_ID."'",'','','','single');
			$brand = $this->Crud_model->GetData('BRND_MSTR','BRND_MSTR_BRAND_NAME',"BRND_MSTR_BRAND_ID='".$usersData->PRODUCT_MSTR_CATEGORY_ID."'",'','','','single');
			$img = $this->Crud_model->GetData('IMAGE_MSTR','IMAGE_MSTR_IMAGE_NAME',"IMAGE_MSTR_ENTITY_ID='".$usersData->PRODUCT_MSTR_PRODUCT_ID."'",'','','','single');
			if($usersData->PRODUCT_MSTR_STATUS=='LIVE')
			{
				$status =  "<button class='label-success label'>Live</button>";            
			}
			else if($usersData->PRODUCT_MSTR_STATUS=='PNDG')
			{
				$status =  "<button class='label-warning label'>PNDG</button>";
			} else if($usersData->PRODUCT_MSTR_STATUS=='DLTD'){
				$status =  "<button class='label-danger label'>DLTD</button>";
			} else {
				$status =  "<button class='label-danger label'>REJ</button>";
			}
			$btn = anchor(site_url('Products/view/'.$usersData->PRODUCT_MSTR_PRODUCT_ID),'<button title="View" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-eye"></i></button>');
			$btn .= ' | '.anchor(site_url('Products/upload_image/'.$usersData->PRODUCT_MSTR_PRODUCT_ID),'<button title="Upload Image" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-image"></i></button>');
			$btn .= ' | '.anchor(site_url('Products/update/'.$usersData->PRODUCT_MSTR_PRODUCT_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>');
			$btn .= ' | '.anchor(site_url('Products/delete/'.$usersData->PRODUCT_MSTR_PRODUCT_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
			$no++;
			$nestedData = array();
			/* $nestedData[] = '<input type="checkbox" class="checkitems" name="selectedRows[]" value="'.$usersData->PRODUCT_MSTR_PRODUCT_ID.'" >'; */
			if($img->IMAGE_MSTR_IMAGE_NAME){
			$nestedData[]="<img src='".base_url()."uploads/images/".$img->IMAGE_MSTR_IMAGE_NAME."' class='img-thumbnail' width='60px' height='30px'>";
			}
			else
			{
			$nestedData[]="";	
			}
			$nestedData[] = $no;
			$nestedData[] = $CATEGORY->CATG_MSTR_CATEGORY_NAME;
			$nestedData[] = $usersData->PRODUCT_MSTR_PRODUCT_NAME;
			$nestedData[] = $usersData->PRODUCT_MSTR_PRODUCT_DESC;
			$nestedData[] = $usersData->PRODUCT_MSTR_CREATED_BY;
			$nestedData[] = $usersData->PRODUCT_MSTR_CREATED_TIME;
			$nestedData[] = $usersData->PRODUCT_MSTR_MODIFIED_BY;
			$nestedData[] = $usersData->PRODUCT_MSTR_MODIFIED_TIME;
			$nestedData[] = $userData->PRODUCT_MSTR_BRAND_NAME;
			$nestedData[] = $status;
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}

		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Products_model->count_all($cond2),
				"recordsFiltered" => $this->Products_model->count_filtered($cond2),
				"data" => $data,
			       );
		echo json_encode($output);
	}


	public function view($id) 
	{


		$getUsers = $this->Crud_model->GetData('PRODUCT_MSTR','',"PRODUCT_MSTR_PRODUCT_ID='".$id."'",'','','','single');
		$Category1 = $this->Crud_model->GetData('CATG_MSTR','CATG_MSTR_CATEGORY_NAME',"CATG_MSTR_CATEGORY_ID='".$getUsers->PRODUCT_MSTR_CATEGORY_ID."'",'','','','single');
		$img = $this->Crud_model->GetData('IMAGE_MSTR','IMAGE_MSTR_IMAGE_NAME',"IMAGE_MSTR_ENTITY_ID='".$id."'",'','');

		$attribute_value_selected = $this->Crud_model->GetData('PRODUCT_ATTR_MAP','',"PRODUCT_ATTR_MAP_PRODUCT_ID='".$getUsers->PRODUCT_MSTR_PRODUCT_ID."'",'','');
		$data = array('heading'=>'Products',
				'subheading'=>'View Products',
				'product_name' => set_value('product_name',$getUsers->PRODUCT_MSTR_PRODUCT_NAME),
				'attributes' => $attribute_value_selected,
				'img'=>$img,
				'category'=>$Category1->CATG_MSTR_CATEGORY_NAME,
				'brand'=> set_value('brand',$getUsers->PRODUCT_MSTR_BRAND_ID),
				'brand_name'=> set_value('brand_name',$getUsers->PRODUCT_MSTR_BRAND_NAME),
				'id' => set_value('id',$id),
			     );
		$this->load->view('products/view',$data);
	}
	public function update_uploaded_img($id) 
	{
		$getUsers = $this->Crud_model->GetData('PRODUCT_MSTR','',"PRODUCT_MSTR_PRODUCT_ID='".$id."'",'','','','single');
		$Category1 = $this->Crud_model->GetData('CATG_MSTR','CATG_MSTR_CATEGORY_NAME',"CATG_MSTR_CATEGORY_ID='".$getUsers->PRODUCT_MSTR_CATEGORY_ID."'",'','','','single');
		$img = $this->Crud_model->GetData('IMAGE_MSTR','',"IMAGE_MSTR_ENTITY_ID='".$id."'",'','');

		$attribute_value_selected = $this->Crud_model->GetData('PRODUCT_ATTR_MAP','',"PRODUCT_ATTR_MAP_PRODUCT_ID='".$getUsers->PRODUCT_MSTR_PRODUCT_ID."'",'','');
		$data = array('heading'=>'Products',
				'subheading'=>'View Products',
				'product_name' => set_value('product_name',$getUsers->PRODUCT_MSTR_PRODUCT_NAME),
				'attributes' => $attribute_value_selected,
				'img'=>$img,
				'category'=>$Category1->CATG_MSTR_CATEGORY_NAME,
				'brand'=> set_value('brand',$getUsers->PRODUCT_MSTR_BRAND_ID),
				'brand_name'=> set_value('brand_name',$getUsers->PRODUCT_MSTR_BRAND_NAME),
				'id' => set_value('id',$id),
			     );
		$this->load->view('products/update_uploaded_img',$data);

	}

	public function upload_image($id) 
	{


		$getUsers = $this->Crud_model->GetData('PRODUCT_MSTR','',"PRODUCT_MSTR_PRODUCT_ID='".$id."'",'','','','single');

		$allIcon = $this->Crud_model->GetData('ICON_MSTR','',"",'','');
        $allValue = $this->Crud_model->GetData('IMAGE_GROUP_MSTR','',"IMAGE_GROUP_MSTR_STATUS='LIVE' AND IMAGE_GROUP_SQL='Product' ",'','');
        $userData = $this->Images_value_model->get_data_query();
        $data = array('heading'=>'Image Master',
			'subheading'=>'Upload Images',
            'button'=>'Submit',
            'product_name' => set_value('product_name',$getUsers->PRODUCT_MSTR_PRODUCT_NAME),

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
            'entityId' => set_value('entityId',$getUsers->PRODUCT_MSTR_PRODUCT_ID),
            'atribute' => $allValue,
             'mainIcon' =>$allIcon,
            'imgmstr' => $userData,
            				'id' => set_value('id',$id),

        );
        $this->load->view('products/upload_image',$data);




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

        if($var[1]=="Product"){
        	            	 $getData = $this->Crud_model->GetData('IMAGE_MSTR','MAX(`IMAGE_MSTR_POSITION`) as maxpos',"IMAGE_MSTR_IMAGE_GROUP='".$var[0]."'",'','','','single');

            $dataMapArray= array(
                'IMAGE_MSTR_IMAGE_ID'=>$array[0],
                'IMAGE_MSTR_IMAGE_NAME'=>$filenm,
                'IMAGE_MSTR_IMAGE_STATUS'=>$_POST['status'],
                'IMAGE_MSTR_ENTITY_ID'=>$_POST['entityId'],
                'IMAGE_MSTR_IMAGE_PATH'=>$var[0],
                'IMAGE_MSTR_IMAGE_GROUP'=>$var[0],
                'IMAGE_MSTR_POSITION'=>($getData->maxpos+1),
                'IMAGE_MSTR_START_DATE'=>date("Y-m-d",strtotime($_POST['startBNR'])),
                'IMAGE_MSTR_END_DATE'=>date("Y-m-d",strtotime($_POST['endBNR'])),
            );
        }
        else if($var[1]==""){
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
        else if($var[1]!="Product"){
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
                $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Image has been added successfully.</p></div>');
                redirect(site_url('Products'));
    
                // print_r($_FILES['filename']);
                // print_r($data['upload_data']); exit;
            }
        // }

        // move_uploaded_file($_FILES['filename']['tmp_name'],$upPath.'/'.$_FILES['filename']['name']);
            
        
        // if($var[1]!="Banner" || $var[1]!="Cat-Icon"){
        

    }


	public function create()
	{

		$Category1 = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_LEVEL='1' AND CATG_MSTR_STATUS='LIVE'",'','');
		$brand = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_STATUS='LIVE'",'','');

		$data = array('heading'=>'Products',
				'subheading'=>'Create Product',
				'button'=>'Submit',
				'action'=>site_url('Products/create_action'),
				'category1' => $Category1,
				'brandName' => $brand,

				// 'categoryId' => set_value('categoryId'),
				'prdName' => set_value('prdName'),
				// 'desc' => set_value('desc'),
				'id' => set_value('id'),
			     );
		$this->load->view('products/form',$data);
	}
 

	public function create_action() 
	{
		$Category1 = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$_POST['categoryLevel1']."' AND CATG_MSTR_STATUS='LIVE'",'','');
		$Category2 = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$_POST['categoryLevel2']."' AND CATG_MSTR_STATUS='LIVE'",'','');
		$Category3 = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$_POST['categoryLevel3']."' AND CATG_MSTR_STATUS='LIVE'",'','');
		//$brand = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_STATUS='LIVE'",'','');
		$brand = $this->Crud_model->GetData('BRND_MSTR','',"BRND_MSTR_BRAND_ID='".$_POST['brandName']."'",'','','','single');
		$attribute_group0 = $this->cat_subcat_model->get_attribute($_POST['categoryLevel1'],$_POST['categoryLevel2'],$_POST['categoryLevel3'],0,0);  
		$values_group0 = $this->cat_subcat_model->get_values($_POST['categoryLevel1'],$_POST['categoryLevel2'],$_POST['categoryLevel3'],0,0);  
		$attribute_group1 = $this->cat_subcat_model->get_attribute($_POST['categoryLevel1'],$_POST['categoryLevel2'],$_POST['categoryLevel3'],1,0);  
		$values_group1 = $this->cat_subcat_model->get_values($_POST['categoryLevel1'],$_POST['categoryLevel2'],$_POST['categoryLevel3'],1,0);  
		$attribute_group2 = $this->cat_subcat_model->get_attribute($_POST['categoryLevel1'],$_POST['categoryLevel2'],$_POST['categoryLevel3'],2,0);  
		$values_group2 = $this->cat_subcat_model->get_values($_POST['categoryLevel1'],$_POST['categoryLevel2'],$_POST['categoryLevel3'],2,0);  
		$data = array('heading'=>'Products',
				'subheading'=>'Attributes For Selected Category',
				'action'=>site_url('Products/add_product'),
				'button'=>'Add',
				'categoryLevel1' => $Category1,
				'categoryLevel2' => $Category2,
				'categoryLevel3' => $Category3,
				'status' => '',
				'brand_name' =>  set_value('brand_name',$brand->BRND_MSTR_BRAND_NAME),
				'brand' =>$_POST['brandName'],
				'product_name' => $_POST['prdName'],
			     );
		$data1=array('attributes' => $attribute_group0,
				'values' => $values_group0,'group'=>set_value('group','0'));
		$data2=array('attributes' => $attribute_group1,
				'values' => $values_group1,'group'=>set_value('group','1'));
	//	$data3=array('attributes' => $attribute_group2,
		//		'values' => $values_group2);
		
		$data['view1'] = $this->load->view('products/getAttr',$data1,true);
		$data['view2'] = $this->load->view('products/getAttr',$data2,true);
		//$data['view3'] = $this->load->view('products/getAttr',$data3,true);

		$this->load->view('products/view_attr',$data);
	}
	

	public function get_group3_attributes() 
	{
		$skucheck = trim(strip_tags($this->input->post('skucheck')));
      $skucheck2 = trim(strip_tags($this->input->post('skucheck2')));
      if($skucheck && $skucheck2)
            $sku = $skucheck.'_'.$skucheck2;
         else
            $sku = $skucheck;
            
		$attribute_group2 = $this->cat_subcat_model->get_attribute($_POST['categoryLevel1'],'','',2);  
		$values_group2 = $this->cat_subcat_model->get_values($_POST['categoryLevel1'],'','',2);  
		
		$data3=array('attributes' => $attribute_group2,
				'values' => $values_group2,'skucheck'=>$sku);
		//exit();
		
		echo $this->load->view('products/getSubAttr',$data3,true);
		 
		
	}
	public function add_product()
	{
		/* roshani code
		print_r($_POST['prdt_attr0']);
		print_r($this->input->post());
		exit();
		*/
		error_reporting(1);
		$prdt_attr=explode(';', $_POST['prdt_attr0']);  
		$prdt_attr_name=explode(';',$_POST['prdt_attr_name0']);  
		$prdt_attr_display=explode(';',$_POST['prdt_attr_display0']);
		$i=0;
		foreach($prdt_attr_display as $val)
		{
			// $i=0;
			switch($val)
			{
				case '1':
					{
						//dropdown 
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm];      
						break;
					}
				case '2':
					{
						//text
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm];  
						break;
					}
				case '3':
					{
						//textarea
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm]; 
						break;
					}
				case '4':
					{
						//date  
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm];                          
						break;
					}
				case '5':
					{
						//multiple dropdown
						$nm=$prdt_attr[$i];
						$mult_drop_val='';
						$a=$_POST[$nm];
						foreach($a as $val1)
						{
							$mult_drop_val.=$val1.",";
						}
						$prdt_attr_val[$i]=$mult_drop_val;  
						break;
					}
				case '6':
					{
						//checkbox
						$nm=$prdt_attr[$i];
						$mult_drop_val='';
						$a=$_POST[$nm];
						foreach($a as $val1)
						{
							$mult_drop_val.=$val1.",";
							
						}
						$prdt_attr_val[$i]=$mult_drop_val; 
						//  $nm=$prdt_attr[$i];
						// $prdt_attr_val[$i]=$_POST[$nm];  
						break;
					}
				case '7':
					{
						//number
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm]; 
						break;
					}
				case '8':
					{
						//image
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm]; 
						break;
					}
			}
			$i++;
		}
		$prdt_attr1=explode(';', $_POST['prdt_attr1']); 
		$prdt_attr_name1=explode(';', $_POST['prdt_attr_name1']); 
		foreach($prdt_attr1 as $val1)
		{
			foreach($_POST[$val1] as $val2)
			{
			$prdt_attr_val1[]=$val2;
			}

		}
	//	print_r($prdt_attr_val1);				 
					
		


		$prdt_attr2=explode(';', $_POST['prdt_attr2']);  
		$prdt_attr_name2=explode(';',$_POST['prdt_attr_name2']);  

		$prdt_attr_display2=explode(';',$_POST['prdt_attr_display2']);
			$i=0;
		foreach($prdt_attr_display2 as $val)
		{
			// $i=0;
			switch($val)
			{
				case '1':
					{
						//dropdown 
						$nm=$prdt_attr2[$i];
						$prdt_attr_val2[$i]=$_POST[$nm];      
						break;
					}
				case '2':
					{
						//text
						$nm=$prdt_attr2[$i];
						$prdt_attr_val2[$i]=$_POST[$nm];  
						break;
					}
				case '3':
					{
						//textarea
						$nm=$prdt_attr2[$i];
						$prdt_attr_val2[$i]=$_POST[$nm]; 
						break;
					}
				case '4':
					{
						//date  
						$nm=$prdt_attr2[$i];
						$prdt_attr_val2[$i]=$_POST[$nm];                          
						break;
					}
				case '5':
					{
						//multiple dropdown
						$nm=$prdt_attr2[$i];
						$mult_drop_val='';
						$a=$_POST[$nm];
						foreach($a as $val1)
						{
							$mult_drop_val.=$val1.",";
						}
						$prdt_attr_val2[$i]=$mult_drop_val;  
						break;
					}
				case '6':
					{
						//checkbox
						$nm=$prdt_attr2[$i];
						$mult_drop_val='';
						$a=$_POST[$nm];
						foreach($a as $val1)
						{
							$mult_drop_val.=$val1.",";
							
						}
						$prdt_attr_val2[$i]=$mult_drop_val; 
						//  $nm=$prdt_attr[$i];
						// $prdt_attr_val[$i]=$_POST[$nm];  
						break;
					}
				case '7':
					{
						//number
						$nm=$prdt_attr2[$i];
						$prdt_attr_val2[$i]=$_POST[$nm]; 
						break;
					}
				case '8':
					{
						//image
						$nm=$prdt_attr2[$i];
						$prdt_attr_val2[$i]=$_POST[$nm]; 
						break;
					}
			}
			$i++;
		}
		
		$category_level_id=$_POST['categoryLevel1'];
		$category_level_name=$_POST['categoryLevelName1'];
		$product_name=$_POST['product_name'];
		$brand_name=$_POST['brand_name'];
		$brand_id=$_POST['brand_id'];
		
		$values=$this->Products_model->add_product($category_level_id,$category_level_name,$product_name,$prdt_attr,$prdt_attr_val,$prdt_attr_name,$prdt_attr1,$prdt_attr_val1,$prdt_attr_name1,$prdt_attr2,$prdt_attr_val2,$prdt_attr_name2,$brand_id,$brand_name); 



		$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Product has been added successfully.</p></div>');
		$url='Products/upload_image/'.$pro_id;
		redirect(site_url($url));
	//	upload_image($pro_id);

	}
	public function update_product()
	{
		error_reporting(1);
		//echo $prdt_attr;
		$prdt_attr=explode(';', $_POST['prdt_attr']);  
		$prdt_attr_name=explode(';',$_POST['prdt_attr_name']);  

		$prdt_attr_display=explode(';',$_POST['prdt_attr_display']);
		$i=0;
		foreach($prdt_attr_display as $val)
		{
			// $i=0;
			switch($val)
			{
				case '1':
					{
						//dropdown 
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm];      
						break;
					}
				case '2':
					{
						//text
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm];  
						break;
					}
				case '3':
					{
						//textarea
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm]; 
						break;
					}
				case '4':
					{
						//date  
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm];                          
						break;
					}
				case '5':
					{
						//multiple dropdown
						$nm=$prdt_attr[$i];
						$mult_drop_val='';
						$a=$_POST[$nm];
						foreach($a as $val1)
						{
							$mult_drop_val.=$val1.",";
						}
						$prdt_attr_val[$i]=$mult_drop_val;  
						break;
					}
				case '6':
					{
						//checkbox
						$nm=$prdt_attr[$i];
						$mult_drop_val='';
						$a=$_POST[$nm];
						foreach($a as $val1)
						{
							$mult_drop_val.=$val1.",";
						}
						$prdt_attr_val[$i]=$mult_drop_val; 
						//  $nm=$prdt_attr[$i];
						// $prdt_attr_val[$i]=$_POST[$nm];  
						break;
					}
				case '7':
					{
						//number
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm]; 
						break;
					}
				case '8':
					{
						//image
						$nm=$prdt_attr[$i];
						$prdt_attr_val[$i]=$_POST[$nm]; 
						break;
					}
			}
			$i++;
		}


		/*$pro_id=$_POST['id'];
		$brand_name=$_POST['brand_name'];
		$brand_id=$_POST['brand_id'];
		$category_level_id=$_POST['categoryLevel1'];
		$category_level_name=$_POST['categoryLevelName1'];
		$product_name=$_POST['product_name'];
		$status=$_POST['status'];
		$values=$this->Products_model->update_product($pro_id,$category_level_id,$category_level_name,$product_name,$prdt_attr,$prdt_attr_val,$prdt_attr_name,$status,$brand,$brand_name); 
		$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Product has been updated successfully.</p></div>');
		redirect(site_url('Products'));
*/

	}
	public function get_category2()
	{
		$categorylevel1Id = $this->input->post('categorylevel1Id');
		//      $categorylevel2Id = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_LEVEL='".$categorylevel1Id."'",'','');

		$categorylevel2Id = $this->cat_subcat_model->get_category2_query($categorylevel1Id);   
		if(count($categorylevel2Id)>0)
		{
			$pro_select_box = '';
			$pro_select_box .= '<option value="">Select Category Level 2</option>';
			foreach ($categorylevel2Id as $categorylevel2Id2) {
				$pro_select_box .='<option value="'.$categorylevel2Id2->CATG_MSTR_CATEGORY_ID.'">'.$categorylevel2Id2->CATG_MSTR_CATEGORY_NAME.'</option>';
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
	public function get_category3()
	{
		$categorylevel2Id = $this->input->post('categorylevel2Id');
		//      $categorylevel2Id = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_LEVEL='".$categorylevel1Id."'",'','');

		$categorylevel3Id = $this->cat_subcat_model->get_category2_query($categorylevel2Id);   
		if(count($categorylevel3Id)>0)
		{
			$pro_select_box = '';
			$pro_select_box .= '<option value="">Select Category Level 3</option>';
			foreach ($categorylevel3Id as $categorylevel3Id3) {
				$pro_select_box .='<option value="'.$categorylevel3Id3->CATG_MSTR_CATEGORY_ID.'">'.$categorylevel3Id3->CATG_MSTR_CATEGORY_NAME.'</option>';
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
	public function update($id)
	{

		$getUsers = $this->Crud_model->GetData('PRODUCT_MSTR','',"PRODUCT_MSTR_PRODUCT_ID='".$id."'",'','','','single');
		$category1 = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$getUsers->PRODUCT_MSTR_CATEGORY_ID."' AND CATG_MSTR_STATUS='LIVE'",'','');
		$attribute_selected = $this->Crud_model->GetData('PRODUCT_ATTR_MAP','',"PRODUCT_ATTR_MAP_PRODUCT_ID='".$getUsers->PRODUCT_MSTR_PRODUCT_ID."' AND PRODUCT_ATTR_MAP_STATUS='LIVE'",'','');
		$attribute_value_selected = $this->Crud_model->GetData('PRODUCT_ATTR_MAP','',"PRODUCT_ATTR_MAP_PRODUCT_ID='".$getUsers->PRODUCT_MSTR_PRODUCT_ID."' AND PRODUCT_ATTR_MAP_STATUS='LIVE'",'','');


		$attribute = $this->cat_subcat_model->get_attribute($getUsers->PRODUCT_MSTR_CATEGORY_ID,'','','',1);  
		$values = $this->cat_subcat_model->get_values($getUsers->PRODUCT_MSTR_CATEGORY_ID,'','','',1);  
		$data = array('heading'=>'Products',
				'subheading'=>'Edit Products',
				'button'=>'Update',
				'button1'=>'Update Uploaded Image',
				'action'=>site_url('Products/update_product'),
				'product_name' => set_value('product_name',$getUsers->PRODUCT_MSTR_PRODUCT_NAME),

				'status' => set_value('status',$getUsers->PRODUCT_MSTR_STATUS),
				'attributes' => $attribute,
				'values' => $values,
				'brand'=> set_value('brand',$getUsers->PRODUCT_MSTR_BRAND_ID),
				'brand_name'=> set_value('brand_name',$getUsers->PRODUCT_MSTR_BRAND_NAME),
				'attribute_value_selected'=>$attribute_value_selected,
				'attribute_selected'=>$attribute_selected,
				'categoryLevel1' => $category1,
				//'desc' => set_value('desc',$getUsers->PRODUCT_MSTR_PRODUCT_DESC),
				'id' => set_value('id',$id),
			     );
		$this->load->view('products/edit_product',$data);
	}
	public function delete($id) 
	{
		$this->Crud_model->DeleteData('PRODUCT_ATTR_MAP',"PRODUCT_ATTR_MAP_PRODUCT_ID='".$id."'");

		$this->Crud_model->DeleteData('PRODUCT_MSTR',"PRODUCT_MSTR_PRODUCT_ID='".$id."'");
		$this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Record has been deleted successfully.</p></div>');
		redirect(site_url('Products'));
	}
  public function bulkdelete($selectedRows)
    {
        $cnt=0;
        foreach($selectedRows as $value){
            $cnt++;
            // echo $cnt; exit;
		$this->Crud_model->DeleteData('PRODUCT_ATTR_MAP',"PRODUCT_ATTR_MAP_PRODUCT_ID='".$value."'");

		$this->Crud_model->DeleteData('PRODUCT_MSTR',"PRODUCT_MSTR_PRODUCT_ID='".$value."'");
		        }

        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>"'.$cnt.'" Records has been deleted successfully.</p></div>');
		redirect(site_url('Products'));
    }

	public function import(){

		$data = array('heading'=>'Products',
				'subheading'=>'Import Bulk Product',
				'button'=>'Submit',
				'action'=>site_url('Products/import_action'),
				'image' => set_value('image'),
				'id' => set_value('id'),
			     );
		$this->load->view('products/form_import',$data);
	} 

	public function import_action(){


		if($_FILES['image']['error']==0)
		{

			$file_element_name = 'image';        
			/*upload image with size of 500x214 */ 
			$_POST['image']= $_FILES['image']['name'];
			$config2['source_image'] =  $_FILES['image']['tmp_name'];
			$config2['new_image'] =   getcwd().'/uploads/users/'.$_POST['image'];
			$config2['upload_path'] =  getcwd().'/uploads/users/';
			print_r($config2['upload_path']); exit;
			$this->image_lib->initialize($config2);

		}

		/*$dataArray= array('image'=>$_POST['image'],
		  'status'=>'Active',
		  );

		  $this->Crud_model->SaveData('galleries',$dataArray);*/
		$this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
		redirect(site_url('Products'));
	}



	public function getcateleve2(){
		$prd_cat_id = $this->input->post('prd_cat_id');
		$allCategoryLeve2 = $this->Crud_model->GetData('CATG_SUB_CATG_MAP','',"CATG_MSTR_CATEGORY_LEVEL='2' and ",'','');
	}
}
