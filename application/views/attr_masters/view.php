 <?php $this->load->view('common/header'); ?>
<?php $this->load->view('common/left_panel'); ?>
<section id="content">
   <div class="container">
      <div class="card">
         <div class="card-header">
            <div class="col-md-4" style="padding: 0">
               <h3><i class="zmdi zmdi-account"></i>&nbsp;<?= $subheading ?></h3>
            </div>
            <div style="clear:both"></div>
         </div>
         <div class="container">
            <div class="card">
               <div class="card-body table-responsive col-md-9" >
                  <table class="table">
                     <tbody>
                        <tr>
                           <td class="col-md-3">Name</td>
                           <td class="col-md-6"><?= $name ?></td>
                        </tr>

                         <tr>
                           <td class="col-md-3">Category</td>
                           <td class="col-md-6">
                              <?php $b=0; foreach ($categories as $key => $category)   { 
                                  $getCategory = $this->Crud_model->GetData('CATG_MSTR','',"CATG_MSTR_CATEGORY_ID='".$category->CATG_ATTR_MAP_CATEGORY_ID."'",'','','','single');
                               ?>
                              <span > <?php echo ++$b.")   ".$getCategory->CATG_MSTR_CATEGORY_NAME; ?></span><br>
                              <?php } ?>
                           </td>
                        </tr>
                        <tr>
                           <td class="col-md-3">Value</td>
                           <td class="col-md-6">
                              <?php $i=0; foreach ($values as $key => $value)   {  ?>
                              <span > <?php echo ++$i.")   ".$value->ATTR_VALUES_ATTR_VALUES; ?></span><br>
                              <?php } ?>
                           </td>
                        </tr>

                        <tr>
                           <td class="col-md-3">Descripation</td>
                           <td class="col-md-6"><?= $desc ?></td>
                        </tr>
                        <tr>
                           <td class="col-md-3">Status</td>
                           <td class="col-md-6">
                              <?= $status ?>
                           </td>
                        </tr>
                     </tbody>
                  </table>

                 
               </div>
            </div>

             <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Attr_Masters') ?>'" >Back</button>
                                </div>
                            </div>
                        </div>
         </div>
      </div>
   </div>
</section>
</section>
<?php $this->load->view('common/footer');  ?>