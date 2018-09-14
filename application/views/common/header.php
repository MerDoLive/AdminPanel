<?php

    if(!isset($_SESSION['tbsCampaign']['id']))
    {
        redirect(site_url('Login'));
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Merzido Admin</title>
    <!-- <link rel="icon" href="<?php echo base_url()?>/uploads/favicon-16x16.png" type="image/x-icon"> -->
    <!-- CSS -->
    <link href="<?= base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/jquery.dataTables.min.css" rel="stylesheet">    
    <link href="<?= base_url(); ?>assets/css/bootstrapValidator.min.css" rel="stylesheet">    
    <link href="<?= base_url(); ?>assets/css/datepicker3.css" rel="stylesheet">    
    <link href="<?= base_url(); ?>assets/css/app_1.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/app_2.min.css" rel="stylesheet">


    <!-- roshani code -->
 <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />-->
<!-- roshani code end -->
    <style type="text/css">
        .err{
            color: red;
        }
       th{
            color: #000 !important;
            /* roshani code */
padding: 0px;
text-align: left;
        /* roshani code end*/
        }
        /* roshani code */
        
        body{
          /*   position: absolute;
           width: 100%;*/
        }
        a{
            font-size: 12px;
        }

        /* roshani code end*/

        /*.preloader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('<?= base_url('assets/img/ajax-loader.gif')?>') 50% 50% no-repeat rgba(19, 0, 0, 0.4);
        }*/
    </style>
</head>
<body>


<header id="header" class="clearfix" data-ma-theme="teal">
    <ul class="h-inner">
        <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
            <div class="line-wrap">
                <div class="line center"></div>
                <div class="line bottom"></div>
            </div>
        </li>
        <li class="hi-logo hidden-xs">
              <a href="<?= site_url('Dashboard/index') ?>"><!--<img src="<?= base_url('assets/img/logo_signature.png') ?>" alt="Campaign" style="margin-top: -10%;height: 70px">--></a>
        </li>
        
        
    </ul>
</header>
<div class="modal fade" id="getEmailPreview" data-modal-color="" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="padding-top:4%; margin-bottom:2%;color: #444">
        <div class="modal-content">   
            <div class="modal-body" id="emailHtml" style="padding-top:4%;"></div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>            
        </div>
    </div>
</div>
<div class="modal fade" id="getSMSPreview" data-modal-color="" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="color: #444;padding-top:4%; margin-bottom:2%;color: #444">   
            <div class="modal-body" id="smsHtml" style="padding-top:4%;"></div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>            
        </div>
    </div>
</div>
<?PHP
function strip_tags_content($text) {

    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);

 }
 ?>