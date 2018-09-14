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
                                    <label>Import File<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="file" class="form-control input-sm" name="image">
                                    </div>
                                    
                                </div>
                            </div>
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
</script>