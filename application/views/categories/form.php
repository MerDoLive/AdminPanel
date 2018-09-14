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
                            <?php 
                               if(count($this->session->userdata('message')))
                               {
                            ?>
                            <span id="hide"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></span>          
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Type<span class="err">*</span></label>
                                    <div class="fg-line">
                                       <select name="categoryId" id="categoryId" class="form-control input-sm">
                                        <option value="">Select Category Type</option>
                                          <?php foreach($categories as $designation){ ?>
                                              <option value="<?php echo $designation->CATG_TYPE_MSTR_CATEGORY_TYPE_ID ?>" <?php if($designation->CATG_TYPE_MSTR_CATEGORY_TYPE_ID==$categoryId){ echo 'selected'; } ?>> <?php echo $designation->CATG_TYPE_MSTR_CATEGORY_TYPE ?>
                                              </option>
                                           <?php } ?>                                          
                                       </select>
                                    <div><span class="err"><?= form_error('categoryId') ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Level 1<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control input-sm" name="name" placeholder="Name" id="name" value="<?= $name ?>">
                                    </div>
                                    <div><span class="err"><?= form_error('name') ?></span></div>
                                </div>
                            </div>
                         </div>   
                         <?php if($button=='Update') { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Position<span class="err">*</span></label>
                                        <div class="fg-line">
                                             <input type="text" class="form-control input-sm" name="position" placeholder="position" id="position" value="<?= $position ?>">
                                        </div>
                                        <div><?= form_error('position') ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status<span class="err">*</span></label>
                                        <div class="fg-line">
                                            <select name="status" class="form-control">
                                                <option value="LIVE" <?php if($status=='LIVE'){ ?> selected="selected" <?php  } ?>>LIVE</option>
                                                <option value="PNDG" <?php if($status=='PNDG'){ ?> selected="selected" <?php  } ?>>PNDG</option>
                                                <option value="REJ" <?php if($status=='REJ'){ ?> selected="selected" <?php  } ?>>REJ</option>
                                                <option value="DLTD" <?php if($status=='DLTD') { echo "selected"; } ?>>DLTD</option>
                                            </select>
                                        </div>
                                        <div><?= form_error('status') ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                          
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description<span class="err">*</span></label>
                                    <div class="fg-line">
                                        <textarea type="text"  class="form-control input-sm ckeditor" name="desc" placeholder="Description" id="desc" row="6"><?= $desc ?></textarea>   </div>
                                    <div><span class="err"><?= form_error('desc') ?></span></div>
                                </div>
                            </div>
                          </div>  
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="cond2" value="<?= $cond2 ?>">
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $button ?></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Categories/index/'.$cond2) ?>'" >Back</button>
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
<script src="<?= base_url(); ?>assets/editor/ckeditor.js"></script>
<script>
$(function () {
  CKEDITOR.replace('desc');
});
</script>
<?php $this->load->view('common/footer');  ?>
