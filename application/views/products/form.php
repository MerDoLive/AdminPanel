<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>

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
                            <?php 
                               if(count($this->session->userdata('msg')))
                               {
                            ?>
                            <span id="hide"><?php echo $this->session->userdata('msg') <> '' ? $this->session->userdata('msg') : ''; ?></span>          
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Level 1<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="categorylevel1Id" name="categoryLevel1" class="form-control input-sm" >
                                            <option value="0">Select Category Level 1</option>
                                          <?php
                                          /* foreach($categories as $designation){ ?>
                                              <option value="<?php echo $designation->CATG_MSTR_CATEGORY_ID ?>" <?php if($designation->CATG_MSTR_CATEGORY_ID==$categoryId){ echo 'selected'; } ?>> <?php echo $designation->CATG_MSTR_CATEGORY_NAME ?>
                                              </option>
                                           <?php } */
                                           ?>   
                                            <?php foreach($category1 as $designation){ ?>
                                              <option value="<?php echo $designation->CATG_MSTR_CATEGORY_ID; ?>"> <?php echo $designation->CATG_MSTR_CATEGORY_NAME; ?>
                                              </option>
                                           <?php } ?>                                           
                                                                             
                                       </select>
                                    <div><?= form_error('categorylevel1Id') ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Level 2<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="categorylevel2Id" name="categoryLevel2" class="form-control input-sm" >
                                            <option value="0">Select Category Level 2</option>
                                          <?php 
                                          /*foreach($categories as $designation){ ?>
                                              <option value="<?php echo $designation->CATG_MSTR_CATEGORY_ID ?>" <?php if($designation->CATG_MSTR_CATEGORY_ID==$categoryId){ echo 'selected'; } ?>> <?php echo $designation->CATG_MSTR_CATEGORY_NAME ?>
                                              </option>
                                           <?php } 
                                           */?> 
                                                                                    
                                                                               
                                       </select>
                                    <div><?= form_error('categorylevel2Id') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Level 3<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="categorylevel3Id" name="categoryLevel3" class="form-control input-sm" >
                                            <option value="0">Select Category Level 3</option>
                                          <?php /*
                                          foreach($categories as $designation){ ?>
                                              <option value="<?php echo $designation->CATG_MSTR_CATEGORY_ID ?>" <?php if($designation->CATG_MSTR_CATEGORY_ID==$categoryId){ echo 'selected'; } ?>> <?php echo $designation->CATG_MSTR_CATEGORY_NAME ?>
                                              </option>
                                           <?php } 
                                           */?> 
                                                                                      
                                                                               
                                       </select>
                                    <div><?= form_error('categorylevel3Id') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="prdName" placeholder="Name" id="name" value="<?= $prdName ?>" required>
                                    </div>
                                    <div><?= form_error('prdName') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Brand<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="brandName" name="brandName" class="form-control input-sm">
                                            <option value="0">Select Brand</option>
                                          <?php
                                          /* foreach($categories as $designation){ ?>
                                              <option value="<?php echo $designation->CATG_MSTR_CATEGORY_ID ?>" <?php if($designation->CATG_MSTR_CATEGORY_ID==$categoryId){ echo 'selected'; } ?>> <?php echo $designation->CATG_MSTR_CATEGORY_NAME ?>
                                              </option>
                                           <?php } 
                                           */?> 
                                            <?php foreach($brandName as $designation){ ?>
                                              <option value="<?php echo $designation->BRND_MSTR_BRAND_ID; ?>"> <?php echo $designation->BRND_MSTR_BRAND_NAME; ?>
                                              </option>
                                           <?php } ?>                                           
                                                                               
                                       </select>
                                    <div><?= form_error('categoryId') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            
                            
                           
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Products') ?>'" >Back</button>
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
    var url = '<?= site_url('Email_template/ajax_manage_page')?>';
    var actioncolumn=3;
</script>
<script src="<?= base_url() ?>assets/js/jquery.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

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
            
        }
    });
 });


function getCatLev2(value){
	var prd_cat_id = value;
	$.ajax({
        type:"post",
        cache:false,
        url:"<?php echo site_url(); ?>/Products/getcateleve2",
        data:{                    
            prd_cat_id:prd_cat_id
        },
        beforeSend:function(){},
        success:function(returndata)
        {   
       		alert(returndata); return false;
          $('#cat_leve2_id').html(returndata);
           
        }
       });
    }

   $(document).ready(function(){
           $('#categorylevel1Id').on('change', function(){
            var categorylevel1Id = $(this).val();
            if(categorylevel1Id == '')
                {
                    $('#categorylevel2Id').prop('disabled', true);
                }
                else
                {
                    $('#categorylevel2Id').prop('disabled', false);
                    $.ajax({
                    url:"<?php echo site_url(); ?>/Products/get_category2",

                        type: "POST",
                        data: {'categorylevel1Id' : categorylevel1Id},
                        dataType: 'json',
                        success: function(data){
                           $('#categorylevel2Id').html(data);
                        },
                        error: function(){
                            alert('Error occur...!!');
                        }
                    });
                  }
           });
           
        });

        $(document).ready(function(){
           $('#categorylevel2Id').on('change', function(){
            var categorylevel2Id = $(this).val();
            if(categorylevel2Id == '')
                {
                    $('#categorylevel3Id').prop('disabled', true);
                }
                else
                {
                    $('#categorylevel3Id').prop('disabled', false);
                    $.ajax({
                    url:"<?php echo site_url(); ?>/Products/get_category3",

                        type: "POST",
                        data: {'categorylevel2Id' : categorylevel2Id},
                        dataType: 'json',
                        success: function(data){
                           $('#categorylevel3Id').html(data);
                        },
                        error: function(){
                            alert('Sub Category not found!!');
                        }
                    });
                  }
           }); });
</script>



