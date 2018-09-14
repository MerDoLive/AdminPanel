<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>
<section id="content">
        <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-city-alt"></i>&nbsp;<?= $subheading ?></h3></div>
                </div>
                <div class="main-page">
                <div class="col-sm-10 col-md-10 col-lg-10" style="padding:100px 10px; margin:auto;float:none; ">
                 <form class="form-horizontal" id="seller_form" role="form" style="padding:15px;" method="post" action="<?php echo base_url()?>index.php/Sellers/update_action" enctype="multipart/form-data">
                    <!--<pre><?php print_r($usertype); ?></pre> -->
                        <?php 
                            if(!empty($id) && isset($id)) {
                        ?>
                        <input type="hidden"  class="form-control input-sm" name="SELR_REGISTR_ID"  id="SELR_REGISTR_ID" value="<?= $id ?>">
                        <?php   
                            }
                        ?>
                        <div class="form-group row">
                     <label class="col-sm-4 control-label">Name *</label>
					 <div class="col-sm-6">
						 <div class="row">
							 <div class="col-sm-6 no-padding-right">
								<input required placeholder="First Name" type="text" name="seller_firstname" class="form-control" value="<?= $seller_firstname ?>">
							 </div>
							 <div class="col-sm-6 no-padding-left">
								<input required placeholder="Last Name" type="text" name="seller_lastname" class="form-control" value="<?= $seller_lastname ?>">
							 </div>
						 </div>
                     </div>
                  </div>
                                <?php
                                if(!empty($id))
                                {
                                ?>
                                <div class="form-group">
                                <label class="col-sm-4 control-label ">Status</label>
                                <div class="col-sm-6">
                                       <select id="status" name="status" style="width:100%;padding:5px;" required class="form-control">
                                            <option value="0">Select Status</option>
                                            <!-- <option value="LIVE" <?php if($status=='LIVE'){ ?> selected="selected" <?php  } ?>>LIVE</option> -->
                                                <option value="PNDG" <?php if($status=='PNDG'){ ?> selected="selected" <?php  } ?>>PNDG</option>
                                                <option value="REJECTED" <?php if($status=='REJECTED'){ ?> selected="selected" <?php  } ?>>REJECTED</option>
                                                <option value="ACTIVE" <?php if($status=='ACTIVE') { echo "selected"; } ?>>Active</option>                              
                                       </select>
                                       <div><?= form_error('status') ?></div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>   

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Sellers') ?>'" >Back</button>
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
    var url = '<?= site_url('Designations/ajax_manage_page')?>';
    var actioncolumn=3;
</script>
<?php $this->load->view('common/footer');  ?>

<script type="text/javascript">
$(document).ready(function(){
   $('#seller_form').bootstrapValidator({        
        excluded: [':disabled'],       
        fields: {
            "status": {
                validators: {
                    notEmpty: {
                        message: 'status is required.'
                    },
                    "seller_firstname": {
                validators: {
                    notEmpty: {
                        message: 'firstname is required.'
                }
            },
        }
        "seller_lastname": {
            validators:{
                notEmpty:{
                    message: 'seller_lastname is required.'
                }
            }
        }
    });
 });
</script>