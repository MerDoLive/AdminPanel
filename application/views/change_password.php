<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>
    <section id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-settings"></i>&nbsp;Change Password</h3></div>                    
                    <div style="clear:both"></div>
                </div>
                <div class="table-responsive">
                    <form method="post" action="<?= $action ?>" id="loginform" enctype="multipart/form-data" onsubmit="return checkError()">
                        <?php 
                           if(count($this->session->userdata('message')))
                           {
                        ?>
                        <span id="hide"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></span>          
                        <?php } ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Password<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="password" class="form-control input-sm" name="current_password" placeholder="Current Password" id="current_password">

                                    </div>
                                </div>
                            </div>
                            <div>
                                <i style="color:#FF6666">Note:- You have to login again after successfully changing password.</i>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label>New Password<span class="err">*</span></label>
                                    <div class="fg-line" id="newPassDiv">
                                        <input type="password" class="form-control input-sm" name="new_password" placeholder="New Password" id="new_password" >
                                    </div>
                                    <div id="errorNewPass" style="color: #F6757E"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password<span class="err">*</span></label>
                                    <div class="fg-line" id="confPassDiv">
                                        <input type="password" class="form-control input-sm" name="confirm_password" placeholder="Confirm Password" id="confirm_password">
                                    </div>
                                    <div id="errorConfirmPass" style="color: #F6757E"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">Change Password</button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Dashboard') ?>'" >Back</button>
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
    var url = '<?= site_url('Categories/ajax_manage_page')?>';
    var actioncolumn=4;
</script>
<?php $this->load->view('common/footer');  ?>
<script type="text/javascript">
    function checkError() 
    {
        var current_password = $("#current_password").val();
        var new_password = $("#new_password").val();
        var confirm_password = $("#confirm_password").val();
        if((new_password!='') && (new_password==current_password))
        {
            $("#errorNewPass").fadeIn().html("New password and current password can't be same");
            setTimeout(function(){$("#errorNewPass").html("&nbsp;");},5000)
            //$("#new_password").focus();
            $("#newPassDiv").addClass("has-error");
            return false;       
        } 

        if((confirm_password!='') && (new_password!=confirm_password))
        {
            $("#errorConfirmPass").fadeIn().html("New password and confirm password not matching");
            setTimeout(function(){$("#errorConfirmPass").html("&nbsp;");},5000)
            $("#confPassDiv").addClass("has-error");
            return false;       
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#loginform').bootstrapValidator({
            excluded: [':disabled'],       
            fields: {
                "current_password": {
                    validators: {
                        notEmpty: {
                            message: 'Current password is required.'
                        },                   
                    }
                },
                "new_password": {
                    validators: {
                        notEmpty: {
                            message: 'New password is required.'
                        },                   
                    }
                },
                "confirm_password": {
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