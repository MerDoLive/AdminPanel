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
                            <?php 
                               if(count($this->session->userdata('msg')))
                               {
                            ?>
                            <span id="hide"><?php echo $this->session->userdata('msg') <> '' ? $this->session->userdata('msg') : ''; ?></span>          
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Deal Name<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="dealsName" placeholder="Name" id="dealsName" value="<?= $dealsName ?>">
                                    </div>
                                    <div><?= form_error('dealName') ?></div>
                                </div>
                            </div>
                        </div>
                 
                        <?php if($button=='Update') { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <select name="status" class="form-control">
                                                <option value="LIVE" <?php if($status=='LIVE'){ ?> selected="selected" <?php  } ?>>LIVE</option>
                                                <option value="PNDG" <?php if($status=='PNDG'){ ?> selected="selected" <?php  } ?>>PNDG</option>
                                                <option value="REJ" <?php if($status=='REJ'){ ?> selected="selected" <?php  } ?>>REJ</option>
                                            </select>
                                        </div>
                                        <div><?= form_error('dealsName') ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div id="date-section">
                        <div class="col-md-12 col-sm-12 col-xs-12" id="start">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date<span class="err"></span></label>
                                    <div class="fg-line">
                                    <input type="text"  class="form-control input-sm" name="startdate" placeholder=" start date" id="startdate" row="6" value="<?= $startdate ?>">
                                    </div>
                                     
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text"  class="form-control input-sm" name="enddate" placeholder=" End Date" id="enddate" row="6" value="<?= $enddate ?>" >
                                    </div>
                                    <div><?= form_error('dealsName') ?></div>
                                </div>
                            </div>
                        </div>
                        </div>        

                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deal Type<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <select name="dealtype" id="dealtype" class="form-control">
                                                <option value="Select Deal Type">Select Deal Type</option>
                                                <option value="TIME" <?php if($dealtype=='TIME'){ ?> selected="selected" <?php  } ?>>TIME</option>
                                                <option value="DAILY" <?php if($dealtype=='DAILY'){ ?> selected="selected" <?php  } ?>>DAILY</option>
                                            </select>
                                        </div>
                                        <div><?= form_error('dealsName') ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="time-section" style="display : none;"> 
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Time<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <input type="time"  class="form-control input-sm" name="starttime" placeholder="Select Start Time" id="starttime" row="6" value="<?= $starttime ?>" >
                                        </div>
                                        <div><?= form_error('dealsName') ?></div>
                                    </div>
                                </div>
                            </div>  

                            

                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Time<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <input type="time"  class="form-control input-sm" name="endtime" placeholder="Select End Time" id="endtime" row="6" value="<?= $endtime ?>" >
                                        </div>
                                        <div><?= form_error('dealsName') ?></div>
                                    </div>
                                </div>
                            </div>
                           
                            </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label>Discount<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text"  class="form-control input-sm ckeditor" name="discount" placeholder="Discount" id="discount" row="6" value="<?= $discount ?>" >
                                    </div>
                                    <div><?= form_error('dealsName') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Description<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <textarea type="text"  class="form-control input-sm ckeditor" name="desc" placeholder=" Description" id="desc" row="6"><?= $desc ?></textarea>
                                    </div>
                                    <div><?= form_error('desc') ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Deals') ?>'" >Back</button>
                                    <a class="btn btn-sm btn-primary" href='<?= site_url('Deals/upload_image')?>' >Upload Image</a>
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
            "dealsName": {
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

    <script type="text/javascript">
        $(function () {
            var date = new Date();
            date.setDate(date.getDate());

            $("#startdate").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,  
                startDate: date,
                changeMonth: true,
                changeYear: true,
            });
             
             var dateend = new Date();
             dateend.setDate(date.getDate()+1);

            $("#enddate").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,  
                startDate: dateend,
                changeMonth: true,
                changeYear: true
            });

           $("#dealtype").change(function(){
               var sel =$(this).val(); 
               if(sel == "TIME")
               {
                    $("#time-section").show();
               }else{
                   $("#time-section").hide();
               }
               if(sel=="Select Deal Type")
               {

               }
           });
        });

</script>


