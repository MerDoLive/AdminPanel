<?php $this->load->view('common/header'); ?>
<?php $this->load->view('common/left_panel'); ?>

    <section id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-account"></i>&nbsp;<?= $subheading ?></h3></div>                    
                    <div style="clear:both"></div>
                </div>
                <div class="table-responsive">
                    <form method="post" action="<?= $action ?>" id="loginform" enctype="multipart/form-data" >
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        
                            <?php 
                               if(count($this->session->userdata('msg')))
                               {
                            ?>
                            <span id="hide"><?php echo $this->session->userdata('msg') <> '' ? $this->session->userdata('msg') : ''; ?></span>          
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="name" placeholder="Name" id="name" value="<?= $name ?>">
                                    </div>
                                    <div class="text-danger"><?= form_error('name') ?><span id="ename"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Attribute Type<span class="err"></span></label>
                                    <div class="fg-line">
                                        <select class="form-control" name="type_id">
                                             <option value="0">Select Type</option>
                                            <option value="1" <?php if($status1=='1') { echo "selected"; } ?>>INT</option>
                                            <option value="2" <?php if($status1=='2') { echo "selected"; } ?>>CHAR</option>
                                            <option value="3" <?php if($status1=='3') { echo "selected"; } ?>>STRING</option>
                                           
                                        </select>
                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Attribute Cate Page<span class="err"></span></label>
                                    <div class="fg-line">
                                        <select class="form-control" name="CATG_ATTR_MAP_PAGE">
                                            <option value="0">Select Cate Page</option>
                                            <option value="2" <?php if($pageStatus=='2') { echo "selected"; } ?>>2 (information)</option>
                                            <option value="3" <?php if($pageStatus=='3') { echo "selected"; } ?>>3 (More Details)</option>
                                            <option value="4" <?php if($pageStatus=='4') { echo "selected"; } ?>>4 (Image)</option>
                                            <option value="5" <?php if($pageStatus=='5') { echo "selected"; } ?>>5 (Accodian)</option>
                                        </select>
                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Attribute Display Type<span class="err"></span></label>
                                    <div class="fg-line">
                                        <select class="form-control" name="CATG_ATTR_DISPLAY_TYPE">
                                            <option value="0">Select Cate Page</option>
                                            <option value="1" <?php if($status1=='1') { echo "selected"; } ?>>1 (Dropdown)</option>
                                            <option value="2" <?php if($status1=='2') { echo "selected"; } ?>>2 (textbox)</option>
                                            <option value="3" <?php if($status1=='3') { echo "selected"; } ?>>3 (html editor)</option>
                                            <option value="4" <?php if($status1=='4') { echo "selected"; } ?>>4 (datepicker)</option>
                                            <option value="5" <?php if($status1=='5') { echo "selected"; } ?>>5 (multiselect)</option>  
                                            <option value="6" <?php if($status1=='6') { echo "selected"; } ?>>6 (multicheck)</option>
                                             <option value="7" <?php if($status1=='7') { echo "selected"; } ?>>7 (number)</option>
                                             <option value="8" <?php if($status1=='8') { echo "selected"; } ?>>8 (image)</option>

                                        </select>
                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:1%"> 
                            <label>Is Mandatory<span class="err">*</span></label>
                                <div class="form-group">
                                     <div class="col-md-6" style="margin-bottom:1%">   
                                        <label class="radio radio-inline m-r-30">
                                            <input type="radio" name="CATG_ATTR_MAP_MANDATORY" value="1"><i class="input-helper"></i>Yes
                                        </label>
                                         <label class="radio radio-inline m-r-30">
                                            <input type="radio" checked="checked"  name="CATG_ATTR_MAP_MANDATORY" value="2"><i class="input-helper"></i> NO
                                        </label>
                                    </div>
                                 </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:1%"> 
                            <label>Category<span class="err">*</span></label>
                                <div class="form-group"> 

                                <div class="col-md-3" style="margin-bottom:1%">   
                                        <label class="checkbox checkbox-inline m-r-30">
                                        <input type="checkbox" id="selectall" value="selectall"><i class="input-helper"></i>Select All
                                        </label>
                                    </div>
                                <?php 
                                  $selected = [];
                                  foreach($selectedVal as $cat){
                                      $selected[$cat->CATG_ATTR_MAP_CATEGORY_ID] = $cat->CATG_ATTR_MAP_CATEGORY_ID;
                                  }
                                 foreach($categories as $category) {
                                    if(isset($selected[$category->CATG_MSTR_CATEGORY_ID])){
                                        $checked = "checked";
                                    }else{
                                        $checked = "";
                                    }
                                    ?>
                                     <div class="col-md-3" style="margin-bottom:1%">   
                                        <label class="checkbox checkbox-inline m-r-30">
                                            <input class="myCheckbox" type="checkbox" name="categoryId[]" value="<?php echo $category->CATG_MSTR_CATEGORY_ID;  ?>" <?php echo $checked; ?> ><i class="input-helper"></i><?php echo $category->CATG_MSTR_CATEGORY_NAME; ?>
                                        </label>
                                    </div>
                                    <?php } ?>
                                </div>
                        </div>
                           <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:1%">
                            <div class="col-md-8">
                                <div class="">
                                    <label>Value<span class="err">*</span> <span class="text-danger" id="eattr_value"></span></label>
                                            <?php if($button=='Submit') { ?>
                                              <table class="table table-bordered" id="customFields" style="margin-top:2%; border: 1px solid">
                                                <tbody>
                                                  <tr style="border: 1px solid">
                                                    <td> <input type="text" class="code form-control" id="attr_value[]" name="attr_value[]" value="" placeholder="Enter value" /></td>
                                                     <td><a href="javascript:void(0);" title="Add" class="addCF btn btn-info btn-xs">Add</a> </td> 
                                                  </tr>
                                                </tbody>
                                              </table>
                                            <?php } else foreach ($values as $key => $value)   {  ?>
                                                <table class="table table-bordered" id="customFields" border="1">
                                                <tbody>
                                                  <tr style="border: 1px solid" id="deleterow<?php echo $key; ?>">
                                                    <td> <input type="text" class="code form-control" id="attr_value[]" name="attr_value[]" value="<?php echo $value->ATTR_VALUES_ATTR_VALUES; ?>" placeholder="Enter value" /></td>
                                                       <td>
                                                     <?php if($key=='0') { ?>
                                                        <a href="javascript:void(0);" title="Add" class="addCF btn btn-info btn-xs">Add</a> 
                                                     <?php } else { ?>
                                                        <a onclick="deletefun('deleterow<?php echo $key; ?>')" href="javascript:void(0);" title="Remove" class="remCF btn btn-danger btn-xs">Remove</a>
                                                     <?php } ?>
                                                    </td> 
                                                  </tr>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    <div><?= form_error('value') ?></div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:2%">
                            <div class="form-group">
                                <label>Description<span class="err">*</span></label>
                                <div class="">
                                    <textarea type="text"  class="form-control input-sm ckeditor" name="desc" placeholder=" Description" id="desc" row="6"><?= $desc ?></textarea>
                                </div>
                                <div class="text-danger"><?= form_error('desc') ?><span id="edesc"></span></div>
                            </div>
                        </div>  
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-sm btn-primary" id="validation"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Attr_Masters') ?>'" >Back</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
<script>
    var url = '<?= site_url('Campaigns/ajax_manage_page')?>';
    var actioncolumn=3;
</script>
<!-- Ckeditor -->

<?php $this->load->view('common/footer');  ?>
<!--Validation start here -->
<script src="<?= base_url(); ?>assets/editor/ckeditor.js"></script>
<script>
$(function () {
  CKEDITOR.replace('desc');
});
</script>
<!--fck editor code end -->
<script type="text/javascript">
   $("#validation").click(function(){

        var name = $("#name").val();
        var desc = CKEDITOR.instances['desc'].getData()
        var attr_value = document.getElementsByName('attr_value[]');
        /*var pattern_name = /^[A-Za-z ]{0,50}$/i;*/
        if(name.trim()=='')
        { 
            $("#ename").fadeIn().html("Attr name is required");
            setTimeout(function(){$("#ename").html("&nbsp;");},4000)
            $("#name").focus();
            return false;
        } 
        for (i=0; i<attr_value.length; i++)
            {

                 
             if (attr_value[i].value == "")
                {
                $("#eattr_value").fadeIn().html("Attr value is required");
                setTimeout(function(){$("#eattr_value").html("&nbsp;");},4000)
                $("#attr_value").focus();
                return false;
                }
            }

        if(desc.trim()=='')
        {
            $("#edesc").fadeIn().html("Description is required");
            setTimeout(function(){$("#edesc").html("&nbsp;");},4000)
            $("#desc").focus();
            return false;
        }
    });

</script>

<script type="text/javascript">
    $(document).ready(function(){
    $(".addCF").click(function(){
        $("#customFields").append('<tr> <td><input type="text" class="code form-control" id="attr_value[]" name="attr_value[]" value="" placeholder="Enter value" /> &nbsp;&nbsp;&nbsp; </td><td><a href="javascript:void(0);" title="Remove" class="remCF btn btn-danger btn-xs">Remove</a></td><br></tr>');
    });
    $("#customFields").on('click','.remCF',function(){

        $(this).parent().parent().remove();
    });
});
</script>


<script type="text/javascript">
    $(".addCF").click(function(){
        $("#customFields").on('click','.remCF',function(){
            $(id).parent().parent().remove();
        });
    });

</script>

<script type="text/javascript"> 
   
    $("#selectall").click(function() {
       if( $('.myCheckbox').prop('checked'))
       {
        $('.myCheckbox').prop('checked',false);
       }
       else{
        $('.myCheckbox').prop('checked',true);
       }
    });
    
</script>