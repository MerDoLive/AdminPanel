<?php $this->load->view('common/header'); ?>
<?php $this->load->view('common/left_panel'); ?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"/>
<style>
    #selectfont {
  font-family: 'FontAwesome', 'sans-serif';
}
</style>
    <section id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-account"></i>&nbsp;<?= $subheading ?></h3></div>                    
                    <div style="clear:both"></div>
                </div>
                <div class="table-responsive">
                    <form method="post" action="<?= $action ?>" id="uploadForm" enctype="multipart/form-data" >
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php 
                                $imgMSpos=array();
                                $imgMSgrp=array();
                                foreach ($imgmstr as $usersData) 
                                {
                                    $imgMSpos[]=$usersData->IMAGE_MSTR_POSITION;
                                    $imgMSgrp[]=$usersData->IMAGE_MSTR_IMAGE_GROUP;
                                }
                                // print_r($imgMSpos);
                                // print_r($imgMSgrp); exit;
                               if(count($this->session->userdata('message')))
                               {
                            ?>
                            <span id="hide"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></span>          
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group" id="pcat">
                                    <label>Product Name <span class="err">*</span></label>
                                    <div class="fg-line">
                                      <?= $product_name ?>
                                    <input type="hidden" name="entityId" value="<?= $entityId?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Group<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select id="grp" name="group" class="form-control input-sm">
                                            <option value="0">Select Image Group</option>
                                          <?php foreach($atribute as $groups){ ?>
                                              <option value="<?php echo $groups->IMAGE_GROUP_MSTR_GROUP.'/'.$groups->IMAGE_GROUP_SQL ?>" <?php if($groups->IMAGE_GROUP_MSTR_GROUP.'/'.$groups->IMAGE_GROUP_SQL==$group.'/'.$type){ echo 'selected'; } ?>> <?php echo $groups->IMAGE_GROUP_MSTR_GROUP ?>
                                              </option>
                                           <?php } ?>                                          
                                       </select>
                                    <div><?= form_error('categoryId') ?></div>
                                    </div>
                                </div>
                            </div>
                             
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6" id="diamention">

                            </div>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group" id="uploadfile">
                                    <label>Upload File<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="file" class="form-control input-sm" name="filename" placeholder="Name" id="name" value="<?= $filename; ?>">
                                        <input type="hidden"  id="old"  name="old"  value="<?php echo $filename; ?>">
                                    </div>
                                    <div><?= form_error('name') ?></div>
                                </div>
                                
                            </div>
                         </div>   
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <select name="status" class="form-control">
                                                <option value="LIVE" <?php if($status=='LIVE'){ ?> selected="selected" <?php } ?>>LIVE</option>
                                                <option value="PNDG" <?php if($status=='PNDG'){ ?> selected="selected" <?php } ?>>PNDG</option>
                                                <option value="REJ" <?php if($status=='REJ'){ ?> selected="selected" <?php  } ?>>REJ</option>
                                            </select>
                                        </div>
                                        <div><?= form_error('brandName') ?></div>
                                    </div>
                                </div>
                            </div>

                        <div class="col-md-12 col-sm-12 col-xs-12" id="pos">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Priority of Image<span class="err"></span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="position" placeholder="Priority for Product image" id="position" value="<?= $position; ?>">
                                        
                                    </div>
                                     
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12" id="start">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date<span class="err"></span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="startBNR" placeholder="Select Start Date" id="startbnr" value="<?= $startBNR; ?>">
                                        
                                    </div>
                                     
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12" id="end">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date<span class="err"></span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="endBNR" placeholder="Select End Date" id="endbnr" value="<?= $endBNR; ?>">
                                        
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
    var url = '<?= site_url('Campaigns/ajax_manage_page')?>';
    var actioncolumn=3;
</script>
<!-- Ckeditor -->

<?php $this->load->view('common/footer');  ?>
<script type="text/javascript">
   $("#validation").click(function(){

        var name = $("#name").val();
        var desc = $('desc').val();
        var attr_value = document.getElementsByName('attr_value[]');
        var pattern_name = /^[A-Za-z ]{0,50}$/i;
        if(name.trim()=='')
        { 
            $("#ename").fadeIn().html("Attr name is required");
            setTimeout(function(){$("#ename").html("&nbsp;");},4000)
            $("#name").focus();
            return false;
        } 
        else if(!pattern_name.test(name))
        {
            $("#ename").fadeIn().html("Only alphabet are allowed");
            setTimeout(function(){$("#ename").html("&nbsp;");},4000)
            $("#name").focus();
            return false;
        }

          
        if (attr_value.value == "")
        {
            $("#eattr_value").fadeIn().html("Attr value is required");
            setTimeout(function(){$("#eattr_value").html("&nbsp;");},4000)
            $("#attr_value").focus();
            return false;
        }

        if(desc.trim()=='')
        {
            $("#edesc").fadeIn().html("Description is required");
            setTimeout(function(){$("#edesc").html("&nbsp;");},4000)
            $("#desc").focus();
            return false;
        }
    });

   $(document).ready(function(){
        $('#start').css('display','none');
        $('#end').css('display','none');
        $('#pos').css('display','none');
                
        $('#grp').change(function(){
            var arr=$(this).val();
            var id=arr.split('/');
            $.ajax({
                type:"POST",
                datatype:"json",
                url:"<?php echo site_url();?>/Image_Values/fetchGRPdata",
                data:
                    {
                        categoryid:id[0],
                    },
                }).done(function(grpdata){
                    $('#diamention').html(grpdata);                               
                });

            if(id[1]=="Product"){
                $('#pcat').css('display','none');
                $('#start').css('display','block');
                $('#end').css('display','block');
                $('#pos').css('display','none');
            }
            else if(id[1]=="Promo"){
                $('#pcat').css('display','none');
                $('#start').css('display','none');
                $('#end').css('display','none');
                $('#pos').css('display','none');
            }
            else{
                $('#pcat').css('display','block');
                $('#start').css('display','none');
                $('#end').css('display','none');
                $('#pos').css('display','none');
        
                <?php if($entityId==""){$entityId="0";}?>
                var ent="<?= $entityId;?>";
                $.ajax({
                type:"POST",
                url:"<?php echo site_url();?>/Image_Values/fetchdata",
                data:
                    {
                        categoryid:id[0],
                        entity:ent
                    },
                }).done(function(rdata){
                    $('#categoryId').html(rdata);                               
                });
            }
            // if(id[1]=="Product"){
            //     $('#diamention').html("<p class='text-danger'>Image Diamention Should be 850px(width) X 400px(height)</p>")
            // }
            // else if(id[1]=="Category"){
            //     $('#diamention').html("<p class='text-danger'>Image Diamention Should be 800px(width) X 360px(height)</p>")
            // }
            // else if(id[1]=="Cat-Icon"){
            //     $('#diamention').html("<p class='text-danger'>Image Diamention Should be 50px(width) X 50px(height)</p>")
            // }
        });

        <?php if($group!=""){ ?>
            var typeid="<?= $type;?>";
            var grpid="<?= $group;?>";
                $('#uploadForm').after('<div class="col-md-12"><h1>PREVIEW:</h1> <br><embed style="max-width:100%; max-height:500;" id="preview" src="<?= base_url();?>uploads/images/<?= $filename;?>"></div>');
           
            if(typeid=="Product"){
                $('#pcat').css('display','none');
                $('#start').css('display','block');
                $('#end').css('display','block');
                $('#pos').css('display','none');
            }
            else if(typeid=="Promo"){
                $('#pcat').css('display','none');
                $('#start').css('display','none');
                $('#end').css('display','none');
                $('#pos').css('display','none');
            }
            else{
                $('#pcat').css('display','block');
                $('#start').css('display','none');
                $('#end').css('display','none');
                $('#pos').css('display','none');
                <?php if($entityId==""){$entityId="0";}?>
                var ent="<?= $entityId;?>";
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url();?>/Image_Values/fetchdata",
                    data:
                        {
                            categoryid:grpid,
                            entity:ent
                        },
                }).done(function(rdata){
                    $('#categoryId').html(rdata);                               
                });
            }

        <?php } ?>

        function filePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').remove();
                    $('#uploadForm').after('<div class="col-md-12"><h1>PREVIEW:</h1> <br><embed src="'+e.target.result+'" max-width="100%" id="preview" max-height="500"></div>');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#name").change(function () {
            filePreview(this);
        });
        var date = new Date();
date.setDate(date.getDate()-1);

        $("#startbnr").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,  
            startDate: date
      });
        $("#endbnr").datepicker({  
            format: 'dd-mm-yyyy',
            autoclose: true,
            startDate: date
      });
   });


</script>