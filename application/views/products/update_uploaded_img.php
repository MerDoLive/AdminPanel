<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel'); 
error_reporting(1) ?>

<section id="content">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="col-md-4" style="padding: 0">
          <h3><i class="zmdi zmdi-city-alt"></i>&nbsp;
            <?= $subheading ?>
          </h3>
        </div>
        <div style="clear:both"></div>
      </div>
      <div class="table-responsive">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <?php 
          if(count($this->session->userdata('msg')))
          {
          ?>
          <span id="hide"><?php echo $this->session->userdata('msg') <> '' ? $this->session->userdata('msg') : ''; ?></span>
          <?php } ?>
          <div class="card-body table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>Product Name</td>
                  <td><?= $product_name ?></td>
                </tr>
                <tr>
                  <td>Brand Name</td>
                  <td><?= $brand_name; ?>
                  </td>
                </tr>
                <tr>
                  <td>Category</td>
                  <td><?= $category ?></td>
                </tr>
                <tr>
                  <td colspan="2">Update Images</td>
                </tr>
                
               
                      <?php
                    foreach($img as $img1){
                      
                    echo "<tr>
                  <td><img src='".base_url()."uploads/images/".$img1->IMAGE_MSTR_IMAGE_NAME."' class='img-thumbnail' width='100' height='100'></td><td>";
                  ?>
                  <button type="button" class="btn btn-sm btn-primary" onClick="window.location='<?= site_url('Image_Values/update/'.$img1->IMAGE_MSTR_IMAGE_ID) ?>'" ><i class="zmdi zmdi-edit"></i></button>
                  <button type="button" class="btn btn-sm btn-primary" onClick="window.location='<?= site_url('Image_Values/delete/'.$img1->IMAGE_MSTR_IMAGE_ID) ?>'" ><i class="zmdi zmdi-delete"></i></button>
                </td>
                </tr>
                <?php

                    }
                    ?>
                   
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="col-md-6">
            <div class="form-group">
              <input type="hidden" name="id" value="<?= $id ?>">
              <button type="button" class="btn btn-sm btn-danger" onClick="window.location='<?= site_url('products') ?>'" >Back</button>
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
<script src="<?= base_url() ?>assets/editor/ckeditor.js"></script>
<?php $this->load->view('common/footer');  ?>
<script>
$(function () {
  CKEDITOR.replace('email_description');
});
</script>
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
</script>
