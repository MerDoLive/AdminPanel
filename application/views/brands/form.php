<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel'); ?>

    <section id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-city-alt"></i>&nbsp;<?= $subheading ?></h3></div>                    
                    <div style="clear:both"></div>
                </div>
                <div class="table-responsive">
                    <form method="post" action="<?= $action ?>" id="loginform" enctype="multipart/form-data" >
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- <pre><?PHP print_r($categoriesBrandMap); ?></pre> -->
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
                                        <input type="text" class="form-control input-sm" name="brandName" placeholder="Name" id="brandName" value="<?= $brandName ?>">
                                    </div>
                                    <div><?= form_error('brandName') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <label>Category Level 1<span class="err">*</span></label> <lable class="checkbox checkbox-inline m-r-30"><input type="checkbox" id="checkall"><i class="input-helper"></i></lable>
                                <div class="form-group" style="margin-top: 1%">
                                    <?php
                                    foreach($categories as $category)
                                    {
                                        
                                    ?>
                                     <div class="col-md-3" style="margin-bottom:1%">   
                                        <lable class="checkbox checkbox-inline m-r-30">
                                            <input class='checkitems' type="checkbox" id='categoryId' name="categoryId[]" value="<?php echo $category->CATG_MSTR_CATEGORY_ID;?>"  
                                            <?php $checked='';
                                        foreach($categories1 as $category1) {
                                        if($category->CATG_MSTR_CATEGORY_NAME==$category1->CATG_MSTR_CATEGORY_NAME){
                                            echo "checked";
                                        }else{
                                            echo "";
                                        }
                                    } ?>
                                                 <?php $checked='';
                                        foreach($categories2 as $category1) {
                                        if($category->CATG_MSTR_CATEGORY_ID==$category1){
                                            echo "checked";
                                        }else{
                                            echo "";
                                        }
                                    } ?>
                                     ><i class="input-helper"></i><?php echo $category->CATG_MSTR_CATEGORY_NAME; ?>
                                        </lable>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div><?= form_error('brandName') ?></div>
                            </div>
                        </div>
                        <?php if($button=='Update') { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <select name="status" class="form-control">
                                                <option value="LIVE" <?php if($status=='LIVE'){ ?> selected="selected" <?php  } ?>>LIVE</option>
                                                <option value="PNDG" <?php if($status=='PNDG'){ ?> selected="selected" <?php  } ?>>PNDG</option>
                                                <option value="REJ" <?php if($status=='REJ'){ ?> selected="selected" <?php  } ?>>REJ</option>
                                            </select>
                                        </div>
                                        <div><?= form_error('brandName') ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>    
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Description<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <textarea type="text"  class="form-control input-sm ckeditor" name="desc" placeholder=" Description" id="desc" row="6"><?= $desc ?></textarea>
                                    </div>
                                    <div><span class="err"><?= form_error('desc') ?></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="cond2" value="<?= $cond2 ?>">
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Brands/index/'.$cond2) ?>'" >Back</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
<?php $this->load->view('common/footer');  ?>
<script>
    var url = '<?= site_url('Designations/ajax_manage_page')?>';
    var actioncolumn=3;
</script>
<script src="<?= base_url(); ?>assets/editor/ckeditor.js"></script>
<script>
$(function () {
  CKEDITOR.replace('desc');
});
</script>
<script type="text/javascript">    
    $('#checkall').change(function() {
        $('.checkitems').prop("checked", $(this).prop("checked"));
    })
</script>
<script type="text/javascript">
$(document).ready(function(){
   $('#loginform').bootstrapValidator({        
        excluded: [':disabled'],       
        fields: {
            "brandName": {
                validators: {
                    notEmpty: {
                        message: 'Name is required.'
                    },
                }
            },
            "categoryId[]": {
                validators: {
                    notEmpty: {
                        message: 'Please select atleast one category.'
                    },
                }
            },
            
        }
    });
 });
</script>
