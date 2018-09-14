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
                    <form method="post" action="<?= site_url('Brands/bulkdelete'); ?>">            
                    <div class="col-md-4 text-right">
                        <a class="btn btn-primary" href="<?= site_url('Brands/create/'.$cond2) ?>">Add</a>|
                        <button class="btn btn-sm btn-danger waves-effect">Delete Multiple</button>
                        
                   
                        <!-- kailash code -->
                     <!-- <a class="btn btn-danger det-btn" id="delete_brand" >Delete </a>
                        <a class="btn btn-danger det-btn" id="delete_confirm" style="display:none"  >Delete Selected </a>
                        <a class="btn btn-info det-btn" id="delete_cancel" style="display:none" >Cancel </a>-->
                        <!-- kailash code end -->
                       
                      
                    </div>
                    <br><br><br><br><br><br><br>

                    <div class="col-md-12 text-left">    
                        <a class="btn btn-secondary" href="<?= site_url('Brands/index/ALL') ?>">ALL(<?= $all?>) </a>
                        <a class="btn btn-secondary" href="<?= site_url('Brands/index/LIVE') ?>">LIVE(<?= $live?>) </a>
                        <a class="btn btn-secondary" href="<?= site_url('Brands/index/PNDG') ?>">PENDING(<?= $pndg?>)</a>
                        <a class="btn btn-secondary" href="<?= site_url('Brands/index/REJ') ?>">REJECTED(<?= $rej?>)</a>
                        <a class="btn btn-secondary" href="<?= site_url('Brands/index/DLTD') ?>">DELETED(<?= $deleted?>)</a> 
                    </div>
                <div class="col-md-12 text-right">
                            <a class="btn btn-secondary" href="<?= site_url('Brands/export') ?>">EXPORT
                </a></div>
                
                <div class="table-responsive" style="padding: 20px">
                <input type='hidden' name='$cond2' value='<?php echo $cond2;?>'>
                    <table id="server_table" class="table table-bordered table-hover" class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr class='info'>

                                <td class="no_sort">
                                    <input type="checkbox" id="checkall">
                                </td>
                                <th><b class="text-primary">Sr No</b></th>
                                <th><b class="text-primary">Brand ID</b></th>
                                <th><b class="text-primary">Brand Name</b></th>
                                <th><b class="text-primary">Category Level 1</b></th>
                                <th><b class="text-primary">Description</b></th>
                                <th><b class="text-primary">Status</b></th>
                                <th><b class="text-primary">Action</b></th>                                
                            </tr>
                        </thead>                       
                        <tbody>                                               
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </section>
</section>
<script>
    var url = '<?= site_url('Brands/ajax_manage_page/'.$cond2)?>';
    var actioncolumn=3;
</script>
<?php $this->load->view('common/footer');  ?>
<script type="text/javascript">    
    $('#checkall').change(function() {
        $('.checkitems').prop("checked", $(this).prop("checked"));
    })
</script>
<!--div class="modal fade" id="checkStatus" data-modal-color="white" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">   
            <form method="post" action="<?= site_url('Brands/changeStatus') ?>">       
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
            <form method="post" action="<?= site_url('Brands/delete') ?>">       
                <div class="modal-body" style="height: 120px;padding-top: 3%">
                    <center>
                        <input type="hidden" name="id" id="deleteId" style="display: none;">
                        <span style="font-size: 16px; color: black">If you want delete this Brands, all associated things will be deleted permanently. Are you sure?</span>
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
 
-->