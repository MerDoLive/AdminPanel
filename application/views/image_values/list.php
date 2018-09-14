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
                        <a class="btn btn-primary" href="<?= site_url('Image_Values/create') ?>">Add </a>
                    </div>

                    <br><br><br><br><br><br><br>
                    
                    <div class="col-md-6 text-left">
                            <a class="btn btn-secondary" href="<?= site_url('Image_Values/') ?>">ALL</a>
                            <a class="btn btn-secondary" href="<?= site_url('Image_Values/index/LIVE') ?>">LIVE</a>
                            <a class="btn btn-secondary" href="<?= site_url('Image_Values/index/PNDG') ?>">PENDING</a>
                            <a class="btn btn-secondary" href="<?= site_url('Image_Values/index/REJ') ?>">REJECTED</a>
                            <a class="btn btn-secondary" href="<?= site_url('Image_Values/index/DLTD') ?>">DELETED</a>
                    </div>

                    <div style="clear:both"></div>
                </div>
                <form method="post" action="<?= site_url('Image_Values/bulkdelete'); ?>">
                <div class="table-responsive"  style="padding: 20px">
                    <table id="server_table" class="table table-bordered table-hover">
                        <thead>
                            <tr class='info'>
                                <th class="no_sort">
                                    <input type="checkbox" id="checkall">
                                </th>
                                <th><b class="text-primary">Sr No</b></th>
                                <th><b class="text-primary">Image ID</b></th>
                                <th><b class="text-primary">Image Name</b></th>
                                <th><b class="text-primary">Image Group</b></th>
                                <th><b class="text-primary">Image Group Category</b></th>
                                <th><b class="text-primary">Status</b></th>
                                <th><b class="text-primary">Action</b></th>                                
                            </tr>
                        </thead>                       
                        <tbody>                                               
                        </tbody>
                    <tfoot><td colspan="7"><button class="btn btn-sm btn-danger waves-effect">Delete Multiple</button></td></tfoot>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </section>
</section>

<script>
    var url = '<?= site_url('Image_Values/ajax_manage_page/'.$cond2)?>';
    var actioncolumn=3;
</script>
<?php $this->load->view('common/footer');  ?>
<script type="text/javascript">    
    $('#checkall').change(function() {
        $('.checkitems').prop("checked", $(this).prop("checked"));
    })
</script>