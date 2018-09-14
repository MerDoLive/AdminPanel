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
                                    <label>Category Type<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="categoryId" name="maincategoryId" class="form-control input-sm">
                                            <option value="0">Select Category</option>
                                          <?php foreach($mainCategory as $category){ ?>
                                              <option value="<?php echo $category->CATG_TYPE_MSTR_CATEGORY_TYPE_ID ?>" <?php if($category->CATG_TYPE_MSTR_CATEGORY_TYPE_ID==$mainCategoryId){ echo 'selected'; } ?>> <?php echo $category->CATG_TYPE_MSTR_CATEGORY_TYPE ?>
                                              </option>
                                           <?php } ?>                                          
                                       </select>
                                    <div><?= form_error('mainCategoryId') ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Attribute <span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="categoryId" name="attrId" class="form-control input-sm">
                                            <option value="0">Select Attribute</option>
                                          <?php foreach($attr as $attribute){ ?>
                                              <option value="<?php echo $attribute->ATTR_MSTR_ATTR_ID ?>" <?php if($attribute->ATTR_MSTR_ATTR_ID==$attrId){ echo 'selected'; } ?>> <?php echo $attribute->ATTR_MSTR_ATTR_NAME ?>
                                              </option>
                                           <?php } ?>                                          
                                       </select>
                                    <div><?= form_error('AtrrId') ?></div>
                                    </div>
                                </div>
                            </div>
                           
                        </div> 
                       

                        <?php if($button!='Submit') { ?>
                         <div class="col-md-12 col-sm-12 col-xs-12">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status<span class="err"></span></label>
                                    <div class="fg-line">
                                        <select class="form-control" name="status">
                                            <option value="LIVE" <?php if($status=='LIVE') { echo "selected"; } ?>>LIVE</option>
                                            <option value="PNDG" <?php if($status=='PNDG') { echo "selected"; } ?>>PNDG</option>
                                            <option value="REJ" <?php if($status=='REJ') { echo "selected"; } ?>>REJ</option>
                                            <option value="DLTD" <?php if($status=='DLTD') { echo "selected"; } ?>>DLTD</option>
                                        </select>
                                    </div>
                                     
                                </div>
                            </div>
                           
                        </div>                 
                        <?php } ?>
                        
                        
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Category_attr_maps') ?>'" >Back</button>
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
$(document).ready(function(){
   $('#loginform').bootstrapValidator({        
        excluded: [':disabled'],       
        fields: {
            "name": {
                validators: {
                    notEmpty: {
                        message: 'Name is required.'
                    },
                    regexp: {
                    regexp: /^[a-zA-Z ]+$/,
                        message: 'The name can only consist of alphabetical'
                    },                  
                }
            }, 
            "mobile": {
                validators: {
                    notEmpty: {
                        message: 'Mobile is required.'
                    },
                    regexp: {
                    regexp: /^[0-9]+$/,
                        message: 'The mobile can only consist of numeric'
                    },
                    stringLength: {
                        min: 10,
                        message: 'The mobile number must be of 10 digits'
                    }                     
                }
            }
            
        }
    });
 });
</script>