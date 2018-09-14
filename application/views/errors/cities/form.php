<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>
    <section id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-city"></i>&nbsp;<?= $subheading ?></h3></div>                    
                    <div style="clear:both"></div>
                </div>
                <div class="table-responsive">
                    <form method="post" action="<?= $action ?>" id="loginform" enctype="multipart/form-data" >
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <?php 
                               if(count($this->session->userdata('message')))
                               {
                            ?>
                            <span id="hide"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></span>          
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="state_id" name="state_id" class="form-control input-sm" onchange="getDistricts(this.value)">
                                            <option value="">Select State</option>
                                          <?php foreach($states as $state){ ?>
                                              <option value="<?php echo $state->id ?>" <?php if($state->id==$state_id){ echo 'selected'; } ?>> <?php echo $state->name ?>
                                              </option>
                                           <?php } ?>                                          
                                       </select>
                                    <div><?= form_error('state_id') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Districts<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <select id="district_id" name="district_id" class="form-control input-sm">
                                            <?php if($button!='Update') { ?>
                                            <option value="">Select District</option>  
                                            <?php } else { ?>
                                            <option value="">Select District</option>  
                                            <?php foreach ($districts as $district) { ?>
                                            <option value="<?= $district->id ?>" <?php if($district->id==$district_id){ echo "selected"; } ?> ><?= $district->name ?></option>  
                                            <?php }  } ?>
                                        </select>
                                        <div><?= form_error('district_id') ?></div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="name" placeholder="City" id="name" value="<?= $name ?>">
                                        <div><?= form_error('name') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Cities') ?>'" >Back</button>
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
    var url = '<?= site_url('Cities/ajax_manage_page')?>';
    var actioncolumn=4;
</script>
<?php $this->load->view('common/footer');  ?>

<script type="text/javascript">
$(document).ready(function(){
   $('#loginform').bootstrapValidator({        
        excluded: [':disabled'],       
        fields: {
            "state_id": {
                validators: {
                    notEmpty: {
                        message: 'State is required.'
                    }
                }
            },
            "district_id": {
                validators: {
                    notEmpty: {
                        message: 'District is required.'
                    }
                }
            },
            "name": {
                validators: {
                    notEmpty: {
                        message: 'City is required.'
                    },
                    regexp: {
                    regexp: /^[a-zA-Z ]+$/,
                        message: 'The City can only consist of alphabetical'
                    },                    
                }
            },    
        }
    });
 });

function getDistricts(id) 
    {
        $.ajax({
            type:'POST',
            url:'<?= site_url('Districts/getDistricts'); ?>',
            data:{id:id},
            cache:false,
            success:function(returndata)
            {  
                $('#district_id').html(returndata);              
            }
        });
    }
</script>
