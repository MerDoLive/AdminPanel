<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel'); 

 $id = ($_SESSION['tbsCampaign']['id']);
        $con = "ID='$id'";
        $row = $this->Crud_model->GetData('CMP_USERS','',$con,'','','','single');
 ?>
     <section id="content">
                <div class="container container-alt">

                    <div class="block-header">
                        <h2>Edit Profile
                        <span style="margin-left:200px;text-transform:none;padding-top: 10px;padding-bottom: 10px;" class="alert-success hideerror"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                        </h2>



                    </div>

                    <div class="card" id="profile-main">
                        <div class="pm-overview c-overflow">

                            <div class="pmo-pic">
                                <div class="p-relative">
                                        <img style="height:200px" class="img-responsive" src="<?= base_url(); ?>/uploads/users/<?= $row->IMAGE ?>" alt="">
                                </div>


                                <div class="pmo-stat">
                                   <?php echo $row->NAME; ?>
                                </div>
                            </div>

                            <div class="pmo-block pmo-contact hidden-xs">
                                <h2>Contact</h2>

                                <ul>
                                 <!--<li><i class="zmdi zmdi-account"></i> <?php echo $row->name; ?></li>-->

                                    <li><i class="zmdi zmdi-phone"></i><?php echo $row->MOBILE; ?></li>
                                    <li><i class="zmdi zmdi-email"></i> <?php echo $row->EMAIL; ?></li>
                                  
                                   
                                    
                                </ul>
                            </div>
                             </div>

                        <div class="pm-body clearfix">
                            <ul class="tab-nav tn-justified">
                                <li class="active"><a href="<?= site_url('Profile/index') ?>">Edit Profile</a></li>
                               <!-- <li><a href="<?= site_url('Profile/change_password') ?>">Change Password</a></li>-->
                            </ul>

                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-account m-r-10"></i> Basic Information</h2>
                              </div>
                                <div class="pmbb-body p-l-30">
                                <form method="post" action="<?= site_url('Login/edit_profile'); ?>" enctype="multipart/form-data" id="form">
                                    <div class="pmbb-view">
                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Name</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <input type="text" class="form-control" name="name" value="<?= $name; ?>" id="name">
                                                     <span style="color:red;" class="hideerror"><?php echo form_error('name') ?></span>
                                                </div>

                                            </dd>
                                        </dl>

                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Email</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <input id="email" type="email" class="form-control" name="email" value="<?= $email; ?>">
                                                     <span style="color:red;" class="hideerror"><?php echo form_error('email') ?></span>
                                                </div>
                                            </dd>
                                        </dl>

                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Mobile</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <input id="mobile" type="text" class="form-control" name="mobile" value="<?= $mobile; ?>" maxlength="10">
                                                     <span style="color:red;" class="hideerror"><?php echo form_error('mobile') ?></span>
                                                </div>
                                            </dd>
                                        </dl>
                                        
                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Image</dt>
                                            <dd>
                                                <div class="dtp-container dropdown fg-line">
                                                    <input type='file' class="form-control" name="image">
                                                     <span style="color:red;" class="hideerror"><?php echo $this->session->userdata('image_error') <> '' ? $this->session->userdata('image_error') : ''; unset($_SESSION['image_error']); ?></span>
                                                </div>
                                            </dd>
                                        </dl>
                                        

                                        <div class="m-t-30"><br/><br/>
                                            <button class="btn btn-primary btn-sm" type="submit">Update Profile</button>&nbsp;&nbsp;
                                            <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Dashboard') ?>'" >Back</button>
                                            <!--<a href="<?php echo site_url('Dashboard');?>" class="btn btn-default btn-sm">Cancel</a>-->
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
           <br/><br/><br/><br/>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
</section>
<?php $this->load->view('common/footer');  ?>
<script type="text/javascript">
$(document).ready(function(){
   $('#form').bootstrapValidator({        
        excluded: [':disabled'],       
        fields: {
            "name": {
                validators: {
                    notEmpty: {
                        message: 'Current password is required.'
                    },                   
                }
            },
            "email": {
                validators: {
                    notEmpty: {
                        message: 'New password is required.'
                    },                   
                }
            },
            "mobile": {
                validators: {
                    notEmpty: {
                        message: 'Confirm password is required.'
                    },                    
                }
            },          
        }
    });
 });
</script>
<script>
    function edit_validation()
    {
        
        var image = $("#image").val();           
        var filetype = image.split(".");
        ext = filetype[filetype.length-1];  
        if(!(ext=='jpg') && !(ext=='png') && !(ext=='jpeg') && !(ext=='JPG') && !(ext=='PNG')&& !(ext=='JPEG'))
        {   
            $("#error_msg3").fadeIn().html("Please enter valid image");
              setTimeout(function(){ $("#error_msg3").fadeOut(); }, 3000);
              $("#image").focus();
              return false; 
        }
        
    }
</script>   