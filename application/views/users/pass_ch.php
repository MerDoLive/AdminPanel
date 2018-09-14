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
                    <!--<pre><?php print_r($usertype); ?></pre> -->
                        <?php 
                            if(!empty($id) && isset($id)) {
                        ?>
                        <input type="hidden"  class="form-control input-sm" name="USER_MSTR_ID"  id="USER_MSTR_ID" value="<?= $id ?>">
                        <?php   
                            }
                        ?>

                        <!-- <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>R<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <select id="userRole" name="userRole" class="form-control input-sm">
                                            <option value="0">Select Role of the User</option>
                                            <?php 
                                            foreach($usertype as $role){ ?>
                                            <option value="<?php echo $role->USER_ROLE_MSTR_TYPE_ID ?>" <?php if($role->USER_ROLE_MSTR_TYPE_ID==$usertype){ echo 'selected'; } ?>> <?php echo $role->USER_ROLE_MSTR_NAME ?>
                                            </option>
                                            <?php } ?>                                          
                                        </select>
                                        <div><?= form_error('userRole') ?></div>
                                    </div>
                                </div> -->

                             <!--    <div class="form-group">
                                    <label>Enter Current Password</label>
                                    <div class="fg-line">
                                        <input type="password" class="form-control input-sm" name="currentpass" placeholder="Current password" id="currentpasss" >
                                    </div>
                                    <div class="text-danger"><?= form_error('userName') ?></div>
                                </div>
 -->
                                     <div class="form-group">
                                    <label>Enter New Password</label>
                                    <div class="fg-line">
                                        <input type="password" class="form-control input-sm" name="newpass" placeholder="New Password" id="newpass" >
                                    </div>
                                    <div class="text-danger"><?= form_error('pass') ?></div>
                                </div>





                                      <div class="form-group">
                                    <label>Confrom password<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="password" class="form-control input-sm" name="conpass" placeholder="Confrom Password" id="conpass" >
                                    </div>
                                    <div class="text-danger"><?= form_error('pass') ?></div>
                                </div>



                              <!--   <?php 
                            if(empty($id)) {
                        ?>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="fg-line">
                                        <input type="password" class="form-control input-sm" name="pass" placeholder="Password" id="pass" value="">
                                    </div>
                                    <div class="text-danger"><?= form_error('pass') ?></div>
                                </div><?php
                            }
                                ?> -->
                      <!--           <div class="form-group">
                                    <label>DESCRIPTION<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <textarea class="form-control input-sm" name="desc" placeholder="Description" id="desc"><?= $desc ?></textarea>
                                    </div>
                                    <div class="text-danger"><?= form_error('desc') ?></div>
                                </div>
                                <?php
                                if(!empty($id))
                                {
                                ?>
                                <div class="form-group">
                                    <label>Status <span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="status" name="status" class="form-control input-sm">
                                            <option value="0">Select Status</option>
                                            <option value="LIVE" <?php if($status=='LIVE'){ ?> selected="selected" <?php  } ?>>LIVE</option>
                                                <option value="PNDG" <?php if($status=='PNDG'){ ?> selected="selected" <?php  } ?>>PNDG</option>
                                                <option value="REJ" <?php if($status=='REJ'){ ?> selected="selected" <?php  } ?>>REJ</option>
                                                <option value="DLTD" <?php if($status=='DLTD') { echo "selected"; } ?>>DLTD</option>                              
                                       </select>
                                       <div><?= form_error('status') ?></div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>  -->  
                         
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <button type="submit" id="btnSubmit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Users') ?>'" >Back</button>
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
            "userName": {
                validators: {
                    notEmpty: {
                        message: 'Type name is required.'
                    },
                    "pass": {
                validators: {
                    notEmpty: {
                        message: 'PASSWORD is required.'
                }
            },
        }
        "userRole": {
            validators:{
                notEmpty:{
                    message: 'ROLE OF THE USER IS REQUIRES.'
                }
            }
        }
    });
 });
</script>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#btnSubmit").click(function () {
            var password = $("#newpass").val();
            var confirmPassword = $("#conpass").val();
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        });
    });
</script>