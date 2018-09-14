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
                                    <label>Attribute<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="valueId" name="valueId" class="form-control input-sm">
                                            <option value="0">Select Attribute</option>
                                          <?php foreach($atribute as $atributes){ ?>
                                              <option value="<?php echo $atributes->ATTR_MSTR_ATTR_ID ?>" <?php if($atributes->ATTR_MSTR_ATTR_ID==$mainatributId){ echo 'selected'; } ?>> <?php echo $atributes->ATTR_MSTR_ATTR_NAME ?>
                                              </option>
                                           <?php } ?>                                          
                                       </select>
                                    <div><?= form_error('valueId') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
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
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:2% ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-sm btn-primary" id="validation"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Attr_Values') ?>'" >Back</button>
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
<script type="text/javascript">
   $("#validation").click(function(){

        var name = $("#name").val();
        var desc = CKEDITOR.instances['desc'].getData()
        var attr_value = document.getElementsByName('attr_value[]');
        var pattern_name = /^[A-Za-z ]{0,50}$/i;
        if(name.trim()=='')
        { 
            $("#ename").fadeIn().html("Attr name is required");
            setTimeout(function(){$("#ename").html("&nbsp;");},4000)
            $("#name").focus();
            return false;
        } 
        else if(!pattern_name.test(name))
        {
            $("#ename").fadeIn().html("Only alphabet are allowed");
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
    
</script>