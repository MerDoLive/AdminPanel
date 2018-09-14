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
        <form method="post" action="<?= $action ?>" id="loginform" enctype="multipart/form-data" >
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
                    <td>Product Name : <?php echo $product_name;?></td>
                    <td><input type='hidden' name='product_name' value="<?= $product_name ?>"></td>
                  </tr>
                  <tr>
                    <td>Brand Name : <?php echo $brand_name;?></td>
                    <td><input type='hidden' name='brand_id' value='<?= $brand ?>'>
                      <input type='hidden' name='brand_name' value='<?= $brand_name ?>'>
                    </td>
                  </tr>
                  <tr>
                    <td>Category:
                      <?php
                                    foreach($categoryLevel1 as $val){
                                        echo $val->CATG_MSTR_CATEGORY_NAME;
                                    }
                                    echo "<input type='hidden' id='categoryLevel1' name='categoryLevel1' value='".$val->CATG_MSTR_CATEGORY_ID."'>";
                                    echo "<input type='hidden' name='categoryLevelName1' value='".$val->CATG_MSTR_CATEGORY_NAME."'>";
                                    if($categoryLevel2){
                                           foreach($categoryLevel2 as $val){
                                               echo "->".$val->CATG_MSTR_CATEGORY_NAME;
                                           }
                                    }
                                    if($categoryLevel3){
                                          foreach($categoryLevel3 as $val){
                                               echo "->".$val->CATG_MSTR_CATEGORY_NAME;
                                          }
                                    }?>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php
                         if($status!=''){
                        ?>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Status </label>
                        <div class="col-sm-6">
                          <select name="status" class="form-control">
                            <option value="LIVE" <?php if($status=='LIVE'){ ?> selected="selected" <?php  } ?>>LIVE</option>
                            <option value="PNDG" <?php if($status=='PNDG'){ ?> selected="selected" <?php  } ?>>PNDG</option>
                            <option value="REJ" <?php if($status=='REJ'){ ?> selected="selected" <?php  } ?>>REJ</option>
                          </select>
                        </div>
                      </div>
                      
                      <?php } 
                      
              /*  $prdt_attr='';
                $prdt_attr_name='';
                $prdt_attr_display='';*/
                        echo $view1;
                        echo $view2;

                        
                      ?>
                      <div id="group3_content">
               
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <div class="fg-line">
                  <input type='hidden' name='prdt_attr' value="<?= $prdt_attr ?>">
                  <input type='hidden' name='prdt_attr_name' value="<?= $prdt_attr_name ?>">
                  <input type='hidden' name='prdt_attr_display' value="<?= $prdt_attr_display ?>">
                </div>
                <div>
                  <?= form_error('textarea1') ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6">
              <div class="form-group">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn btn-sm btn-primary" id="validation">
                <?= $button ?>
                </button>
                <?php if($button1){ ?>
                <button type="button" class="btn btn-sm btn-primary" onClick="window.location='<?= site_url('products/update_uploaded_img/'.$id) ?>'" >
                <?= $button1 ?>
                </button>
                <?php } ?>
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
  CKEDITOR.replace('textarea1');
});
</script>
<script type="text/javascript">
   $("#validation").click(function(){

        var textarea1 = CKEDITOR.instances['textarea1'].getData()
        /*var pattern_name = /^[A-Za-z ]{0,50}$/i;*/
    
        if(textarea1.trim()=='')
        {
            $("#etextarea1").fadeIn().html("Please fill some data");
            setTimeout(function(){$("#etextarea1").html("&nbsp;");},4000)
            $("#textarea1").focus();
            return false;
        }
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

$(document).on("click",".skucheck",function(){
  var categoryLevel1="<?= $val->CATG_MSTR_CATEGORY_ID;?>";
  
      skucheck = [];
      $(".skucheck").each(function(){
        if($(this).is(":checked")){
          skucheck.push($(this).val());
        }       
      });
      skucheck = skucheck.join("_");
      
          $.ajax({
            url: "<?php echo site_url(); ?>/Products/get_group3_attributes",
            type: "POST",
            data: {
              skucheck: skucheck,
              categoryLevel1:categoryLevel1,

            },
            success: function( data ) {
              $("#group3_content").html(data);
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
<script>

function isInt(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isChar(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
        return false;
        
    }
    return true;
}

</script>
