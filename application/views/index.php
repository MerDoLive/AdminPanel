<!DOCTYPE html>
<html class="login-content">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Merzido Admin</title>
        <!-- <link rel="icon" href="<?php echo base_url()?>/uploads/favicon-16x16.png" type="image/x-icon"> -->
        <!-- Vendor CSS -->
        <link href="<?= base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/css/material-design-iconic-font.min.css" rel="stylesheet">
        <!-- CSS -->
        <link href="<?= base_url(); ?>assets/css/app_index.css" rel="stylesheet">
    </head>

    <body class="login-content">
            <!-- Login -->
            <div class="lc-block lcb-alt toggled" id="l-login">
            <!---<img width="" height="" alt="Email" class="lcb-user" src="<?= base_url('assets/img/logo_signature.png') ?>">-->
                <form method="post" action="<?= site_url('Login/login_action') ?>" onsubmit="return checkError()">
                    <div class="lcb-form">
			         <div style="text-align: center;"><h1>Login</h1></div>
                        <div style="color: rgb(255, 0, 0); text-align: center; height: 20px;"><?= $this->session->flashdata('msg'); ?></div>
                        <div class="input-group m-b-20">
                            <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                            <div class="fg-line" id="emailDiv">
                                <input type="text" class="form-control" name="username" placeholder="Username" id="email" autocomplete="off">
                                <div style="color:#F6757E;" id="errorEmail"></div>
                            </div>
                        </div>
                        <div class="input-group m-b-20">
                            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                            <div class="fg-line" id="passDiv">
                                <input type="password" class="form-control" name="password" placeholder="Password" id="password" autocomplete="off">
                                <div style="color:#F6757E;" id="errorPass"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></buton>
                    </div>
                </form>
            </div>
        <script type="text/javascript">
            function checkError()
            {
                var email = $('#email').val();
                var password = $('#password').val();

                if(email.trim()=='')
                {
                    $("#emailDiv").addClass("has-error");
                    $("#errorEmail").fadeIn().html("Please enter username ");
                    setTimeout(function(){$("#errorEmail").html("&nbsp;");},5000)
                    return false;
                }
                else
                {
                    $("#emailDiv").removeClass("has-error");
                    $("#emailDiv").addClass("has-success");
                }
                
                if(password.trim()=='')
                {
                    $("#passDiv").addClass("has-error");
                    $("#errorPass").fadeIn().html("Please enter password ");
                    setTimeout(function(){$("#errorPass").html("&nbsp;");},5000)
                    return false;
                }
                else
                {
                    $("#passDiv").removeClass("has-error");
                    $("#passDiv").addClass("has-success");
                }
            }
        </script>
        <!-- Javascript Libraries -->
        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/waves.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
    </body>
</html>