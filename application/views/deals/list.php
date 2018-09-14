<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>
    <section id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-account"></i>&nbsp;<?= $heading ?></h3></div>
                    <div class="col-md-4 text-center">
                        <?php 
                           if(count($this->session->userdata('message')))
                           {
                        ?>
                        <span id="hide"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></span>          
                        <?php } ?>
                    </div>                    
                    <div class="col-md-4 text-right">
                        <a class="btn btn-primary" href="<?= site_url('Deals/create') ?>">Add </a>
                       

                        
                    </div>

                    <br><br><br><br><br><br>
                
                     <div class="col-md-12 text-left">    
                        <a class="btn btn-secondary" href="<?= site_url('Deals/') ?>">ALL </a>
                        <a class="btn btn-secondary" href="<?= site_url('Deals/index/LIVE') ?>">LIVE</a>
                        <a class="btn btn-secondary" href="<?= site_url('Deals/index/PNDG') ?>">PENDING</a>
                        <a class="btn btn-secondary" href="<?= site_url('Deals/index/REJ') ?>">REJECTED</a>
                         
                    </div>


                    <div style="clear:both"></div>
                </div>

                <div class="table-responsive" style="padding: 20px">
                    <table id="server_table" class="table table-bordered table-hover" >
                        <thead>
                            <tr class='info'>
                                <th><b class="text-primary">Sr No</b></th>
                                <th><b class="text-primary">Deal ID</b></th>
                                <th><b class="text-primary">Deal Name</b></th>
                                <th><b class="text-primary">Description</b></th>
                                <th><b class="text-primary">Status</b></th>
                                <th><b class="text-primary">Start Date</b></th>
                                <th><b class="text-primary">End Date</b></th>
                                <th><b class="text-primary">Deal Type</b></th>
                                <th><b class="text-primary">Discount</b></th>
                                <th><b class="text-primary">Created By</b></th>
                                <th><b class="text-primary">Modified By</b></th>
                                <th><b class="text-primary">Position</b></th>
                                <th><b class="text-primary">Action</b></th>                          
                            </tr>
                        </thead>                       
                        <tbody>                                               
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</section>
<script>
    var url = '<?= site_url('Deals/ajax_manage_page/'.$cond2)?>';
    var actioncolumn=5;
</script>
<?php $this->load->view('common/footer');  ?>




<!-- <div class="modal fade" id="checkStatus" data-modal-color="white" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">   
            <form method="post" action="<?= site_url('Deals/changeStatus') ?>">       
                <div class="modal-body" style="height: 100px;padding-top: 10%">
                    <center>
                        <input type="hidden" name="id" id="statusId" style="display: none;">
                        <span style="font-size: 16px; color: black;">Are you sure to change the status?</span>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteData" data-modal-color="white" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">   
            <form method="post" action="<?= site_url('Deals/delete') ?>">       
                <div class="modal-body" style="height: 120px;padding-top: 3%">
                    <center>
                        <input type="hidden" name="id" id="deleteId" style="display: none;">
                        <span style="font-size: 16px; color: black">If you want delete this Deal, all associated things will be deleted permanently. Are you sure?</span>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> -->
