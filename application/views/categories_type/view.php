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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span class="err"></span></label>
                                    <div class="fg-line">
                                        <?= $name ?>
                                    </div>
                                    <div class="text-danger"><?= form_error('CATG_TYPE_MSTR_CATEGORY_TYPE') ?></div>
                                </div>
                            </div>
                         </div>   
                         
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status<span class="err"></span></label>
                                    <div class="fg-line">
                                        
                                        <?= $status ?> 

                                    </div>
                                    <div class="text-danger"><?= form_error('status') ?></div>
                                </div>
                            </div>
                         </div>  
                            
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                   
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Categories_type/index/'.$cond2) ?>'" >Back</button>
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
   $('#loginform').bootstrapValidator({        
        excluded: [':disabled'],       
        fields: {
            "CATG_TYPE_MSTR_CATEGORY_TYPE": {
                validators: {
                    notEmpty: {
                        message: 'Type name is required.'
                    },
                }
            },
        }
    });
 });
</script>