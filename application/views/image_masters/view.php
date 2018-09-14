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
               <div class="card-body table-responsive">
                  <table class="table">
                     <tbody>
                        <tr>
                           <td>Image Group Name</td>
                           <td><?= $name ?></td>
                        </tr>
                        <tr>
                           <td>Image Group Size</td>
                           <td>
                              <?= $size; ?>
                           </td>
                        </tr>
                        <tr>
                           <td>Image Group Resolution</td>
                           <td><?= $resolution ?></td>
                        </tr>
                        <tr>
                           <td>Image Group Dimention</td>
                           <td><?= $dimention ?></td>
                        </tr>
                        <tr>
                           <td>Status</td>
                           <td>
                              <?= $status1 ?>
                           </td>
                        </tr>
                     </tbody>
                  </table>

                 
               </div>
            </div>

             <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                     
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Image_Masters') ?>'" >Back</button>
                                </div>
                            </div>
                        </div>
         </div>
      </div>
   </div>
</section>
</section>
<?php $this->load->view('common/footer');  ?>