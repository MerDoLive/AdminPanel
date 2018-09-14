<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);


class Categories_type extends CI_Controller {

	function __construct()
   	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Categories_type_model');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('download');
       // $this->load->library('PHPExcel');
   	}

	public function index($cond2)
	{
        $all=$this->Categories_type_model->count_filtered('ALL');
        $live=$this->Categories_type_model->count_filtered('LIVE');
        $deleted=$this->Categories_type_model->count_filtered('DLTD');
        $data = array('heading'=>'Category Type Management', 'cond2'=>$cond2,'all'=>$all,'live'=>$live,'deleted'=>$deleted);
		$this->load->view('categories_type/list',$data);
	}

	public function ajax_manage_page($cond2)
    {
	
		$categoryData = $this->Categories_type_model->get_datatables($cond2);

    	if(empty($_POST['start']))
        {
            $no =0;   
        }else{
             $no =$_POST['start'];
        }
		$data = array();		
		foreach ($categoryData as $catData) 
		{
            $btn='';
            if($catData->CATG_TYPE_MSTR_STATUS!='DLTD')
            {
            $btn = anchor(site_url('Categories_type/update/'.$cond2.'/'.$catData->CATG_TYPE_MSTR_CATEGORY_TYPE_ID),'<button title="Edit" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-edit"></i></button>&nbsp;');
            
            $btn .= ' | '.anchor(site_url('Categories_type/view/'.$cond2.'/'.$catData->CATG_TYPE_MSTR_CATEGORY_TYPE_ID),'<button title="View" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-eye"></i></button>&nbsp; | ');
            }
            if($catData->CATG_TYPE_MSTR_STATUS=='DLTD')
            {
            $btn .= anchor(site_url('Categories_type/restore/'.$cond2.'/'.$catData->CATG_TYPE_MSTR_CATEGORY_TYPE_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to Restore?\')"title="Restore" class="btn btn-sm btn-info waves-effect"><i class="zmdi zmdi-time-restore"></i></button>&nbsp;');
            }else
            {
                $btn .= anchor(site_url('Categories_type/delete/'.$cond2.'/'.$catData->CATG_TYPE_MSTR_CATEGORY_TYPE_ID),'<button onclick="javasciprt: return confirm(\'Are you really want to delete?\')" title="Delete" class="btn btn-sm btn-danger waves-effect"><i class="zmdi zmdi-delete"></i></button>');
            }
            if($catData->CATG_TYPE_MSTR_STATUS=='LIVE')
            {
                $status =  "<button class='label-success label'>Live</button>";            
            }
            else if($catData->CATG_TYPE_MSTR_STATUS=='PNDG')
            {
                $status =  "<button class='label-warning label'>PNDG</button>";
            }else if($catData->CATG_TYPE_MSTR_STATUS=='DLTD')
            {
                $status =  "<button class='label-danger label'>DLTD</button>";
            } else{
            	$status =  "<button class='label-danger label'>REJ</button>";
            }

			$no++;
            $nestedData = array();
		    $nestedData[] = $no;
            $nestedData[] = $catData->CATG_TYPE_MSTR_CATEGORY_TYPE_ID;
            $nestedData[] = $catData->CATG_TYPE_MSTR_CATEGORY_TYPE;
            $nestedData[] = $status;
		    $nestedData[] = $btn;
		    $data[] = $nestedData;
		}

		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->Categories_type_model->count_all($cond2),
					"recordsFiltered" => $this->Categories_type_model->count_filtered($cond2),
					"data" => $data,
				);
		echo json_encode($output);
    }

    public function createMasterType()
    {
        $data = array('heading'=>'Category',
                    'subheading'=>'Create Category Type Management',
                    'button'=>'Submit',
                    'action'=>site_url('Categories_type/createMasterType_action'),
                    'name' => set_value('CATG_TYPE_MSTR_CATEGORY_TYPE'),
                  
                );
        $this->load->view('categories_type/form',$data);
    }

    public function createMasterType_action() 
    {
        $id=0;
        $condition = "CATG_TYPE_MSTR_CATEGORY_TYPE_ID !='".$id."' and CATG_TYPE_MSTR_CATEGORY_TYPE ='".$this->input->post('CATG_TYPE_MSTR_CATEGORY_TYPE',TRUE)."'";
        $row = $this->Crud_model->getSingleData('CATG_TYPE_MSTR', $condition);
        if(count($row) > 0)
        {
            $is_unique = "|is_unique[CATG_TYPE_MSTR.CATG_TYPE_MSTR_CATEGORY_TYPE]";  
        }
        else
        {
            $is_unique = "";    
        }    
        /*$this->form_validation->set_rules('CATG_TYPE_MSTR_CATEGORY_TYPE', 'CATG_TYPE_MSTR_CATEGORY_TYPE', 'trim|regex_match[/^[a-zA-Z ]+$/]|required'.$is_unique,
            array(
                'required' => 'Please enter name',
                'regex_match' => 'Please enter valid name',   
                'is_unique'     => 'This category type already exists.',             
            )
        );*/
        /*if ($this->form_validation->run() == FALSE) {
            $this->createMasterType();
        } 
        else 
        {*/
            $dataProcedure = $this->db->query("SELECT GET_SEQ('CTYP')");
            $result = $dataProcedure->row();
            foreach ($result as $value) 
            $array[] = $value;
            $dataArray= array(
                            'CATG_TYPE_MSTR_CATEGORY_TYPE_ID'=>$array[0],
                            'CATG_TYPE_MSTR_CATEGORY_TYPE' =>$_POST['CATG_TYPE_MSTR_CATEGORY_TYPE'] ,
                      );
            $this->Crud_model->SaveData('CATG_TYPE_MSTR',$dataArray);
            $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been added successfully.</p></div>');
            redirect(site_url('Categories_type'));
        //}
    }


    public function update($cond,$id)
    {

        $allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'",'','');
		$data = array('heading'=>'Category',
                    'subheading'=>'Edit Category Type Management',
                    'button'=>'Update',
                    'action'=>site_url('Categories_type/update_action/'.$id),
                    'name' => $allCategoryType[0]->CATG_TYPE_MSTR_CATEGORY_TYPE,
                    'id' => $id,
                    'status' => $allCategoryType[0]->CATG_TYPE_MSTR_STATUS ,
                    'cond2'=>$cond,
                    'EDIT'=>1,
                    
                );
        $this->load->view('categories_type/form',$data);
    }

     public function update_action() 
    {

        $category_count=$this->Crud_model->GetTableCount('CATG_MSTR',"CATG_MSTR_CATEGORY_TYPE_ID='".$_POST['id']."' and CATG_MSTR_STATUS='LIVE'");
        if($category_count==0)
        {
        $dataArray= array(
                            'CATG_TYPE_MSTR_CATEGORY_TYPE' =>$_POST['CATG_TYPE_MSTR_CATEGORY_TYPE'],
                            'CATG_TYPE_MSTR_STATUS'=>$_POST['status'] ,
                    );
        $this->Crud_model->SaveData('CATG_TYPE_MSTR',$dataArray,"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$_POST['id']."'");
        $this->session->set_flashdata('message', '<span class="label label-success" style="font-size:12px;">Record updated successfully</span>');
         }
        else
        {
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>This Category Type is belong category level, Unable to Update.</p></div>');
        }
        redirect(site_url('Categories_type/index/'.$_POST['cond2']));
        
    }
    //Roshani Code start
    public function delete($cond2,$id)
    {
        $dataArray= array(
                            'CATG_TYPE_MSTR_STATUS'=>'DLTD',
                    );
        $category_count = $this->Crud_model->GetTableCount('CATG_MSTR',"CATG_MSTR_CATEGORY_TYPE_ID='".$id."' and CATG_MSTR_STATUS='LIVE'");
        if($category_count==0)
        {
        $this->Crud_model->SaveData('CATG_TYPE_MSTR',$dataArray,"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'");
       // $this->Crud_model->DeleteData('CATG_TYPE_MSTR',"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><p>Record has been deleted successfully.</p></div>');
        }
        else
        {
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>This Category Type is belong category level, Unable to delete.</p></div>');
        }
        redirect('Categories_type/index/'.$cond2);
    }
    public function restore($cond2,$id)
    {
        $dataArray= array(
                            'CATG_TYPE_MSTR_STATUS'=>'LIVE',
                    );

        $this->Crud_model->SaveData('CATG_TYPE_MSTR',$dataArray,"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'");
       // $this->Crud_model->DeleteData('CATG_TYPE_MSTR',"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'");
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-danger"><p>Record has been restore successfully.</p></div>');
        redirect('Categories_type/index/'.$cond2);
    }
    public function View($cond2,$id)
    {
        $allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"CATG_TYPE_MSTR_CATEGORY_TYPE_ID='".$id."'",'','');
        $data = array('heading'=>'Category',
                    'subheading'=>'View Category Type Management',
                    'action'=>site_url('Categories_type'),
                    'cond2'=>$cond2,
                    'name' => $allCategoryType[0]->CATG_TYPE_MSTR_CATEGORY_TYPE,
                    'status' => $allCategoryType[0]->CATG_TYPE_MSTR_STATUS ,
                    
                );
        $this->load->view('categories_type/view',$data);
    }
    public function export()
    {
        $this->load->library("excel");
        $object=new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns=array("Category ID","Category Type","Status");
        $column=0;
        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
            $column++;

        }

        $allCategoryType = $this->Crud_model->GetData('CATG_TYPE_MSTR','',"",'','');
        $excel_row=2;
        foreach($allCategoryType as $row)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->CATG_TYPE_MSTR_CATEGORY_TYPE_ID);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->CATG_TYPE_MSTR_CATEGORY_TYPE);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->CATG_TYPE_MSTR_STATUS);
            $excel_row++;
        }
        $object_writer=PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="CategoryType-'.date('d-m-y-h:m:s').'.xls"');
        $object_writer->save('php://output');

    }
    //Roshani Code end
}
