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
                    <form method="post" action="<?= $action; ?>" id="loginform" enctype="multipart/form-data" >
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php 
                               if(count($this->session->userdata('msg')))
                               {
                            ?>
                            <span id="hide"><?php echo $this->session->userdata('msg') <> '' ? $this->session->userdata('msg') : ''; ?></span>          
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image Group Name<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="name" placeholder="GROUP NAME" id="name" value="<?= $name; ?>" <?php if(!empty($name)){ echo "readonly";} ?>>
                                    </div>
                                    <div class="text-danger"><?= form_error('name') ?><span id="ename"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image Group Size<span class="err"></span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="size" placeholder="SIZE" id="name" value="<?= $size; ?>">

                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image Group Width<span class="err"></span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm numbers" name="resolution" placeholder="Width" id="width" value="<?= $resolution; ?>">  
                                    </div>
                                    <div class="text-danger"><?= form_error('name') ?><span id="ewidth"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image Group Height<span class="err"></span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm numbers" name="dimention" placeholder="Height" id="height" value="<?= $dimention; ?>">
                                    </div>
                                    <div class="text-danger"><?= form_error('name') ?><span id="eheight"></span></div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label>Image Group Status<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <select name="status1" class="form-control">
                                            <option value="LIVE" <?php if($status1=='LIVE'){ ?> selected="selected" <?php  } ?>>LIVE</option>
                                            <option value="PNDG" <?php if($status1=='PNDG'){ ?> selected="selected" <?php  } ?>>PNDG</option>
                                            <option value="REJ" <?php if($status1=='REJ'){ ?> selected="selected" <?php  } ?>>REJ</option>
                                        </select>
                                    </div>
                                    <div><?= form_error('brandName') ?></div>
                                </div>
                            </div>
                        </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Group Type<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <select name="type" class="form-control">
                                                <option value="Banner" <?php if($type=='Banner'){ ?> selected="selected" <?php  } ?>>Banner</option>
                                                <option value="Cat-Icon" <?php if($type=='Cat-Icon'){ ?> selected="selected" <?php  } ?>>Category Icon</option>
                                                <option value="Product" <?php if($type=='Product'){ ?> selected="selected" <?php  } ?>>Product</option>
                                                <option value="Brand" <?php if($type=='Brand'){ ?> selected="selected" <?php  } ?>>Brand</option>
                                                <option value="Category" <?php if($type=='Category'){ ?> selected="selected" <?php  } ?>>Category</option>
                                                <option value="Promo" <?php if($type=='Promo'){ ?> selected="selected" <?php  } ?>>Promo-Banner</option>
                                                
                                            </select>
                                        </div>
                                        <div><?= form_error('brandName') ?></div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" id="validation" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Image_Masters'); ?>'" >Back</button>
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

<!--fck editor code end -->
<script type="text/javascript">
   $("#validation").click(function(){

        var name = $("#name").val();
        // var desc = CKEDITOR.instances['desc'].getData()
        // var attr_value = document.getElementsByName('attr_value[]');
        /*var pattern_name = /^[A-Za-z ]{0,50}$/i;*/
        if(name.trim()=='')
        { 
            $("#ename").fadeIn().html("Image Group name is required");
            setTimeout(function(){$("#ename").html("&nbsp;");},4000)
            $("#name").focus();
            return false;
        } 
 
    });
   $(document).ready(function () {
  //called when key is pressed in textbox
  $("#width").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#ewidth").fadeIn().html("Numbers Only");
            setTimeout(function(){$("#ewidth").html("&nbsp;");},4000)
            $("#width").focus();
               return false;
    }
   });
  $("#height").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#eheight").fadeIn().html("Numbers Only");
            setTimeout(function(){$("#eheight").html("&nbsp;");},4000)
            $("#height").focus();
               return false;
    }
   });
});

</script>