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
                                    <label>Brand Name</label>
                                    <div class="fg-line">
                                        <input class="form-control" id="inputSuccess1" value="<?= $brandName;  ?>" type="text" disabled="">
                                    </div>
                                    <div><?= form_error('brandName') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                                <div class="form-group">
                                <label>Category Level 1</label>
                                <div class="fg-line">
                                        <?= html_entity_decode($categories);  ?>
                                    </div>
                                    </div></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="cond2" value="<?= $cond2 ?>">
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
