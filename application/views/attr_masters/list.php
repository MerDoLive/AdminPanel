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
                        <a class="btn btn-primary" href="<?= site_url('Attr_Masters/create') ?>">Add </a>
                    </div>

                       <br><br><br><br><br><br>

                    <div class="col-md-6 text-left">
                            <a class="btn btn-secondary" href="<?= site_url('Attr_Masters/') ?>">ALL</a>
                            <a class="btn btn-secondary" href="<?= site_url('Attr_Masters/index/LIVE') ?>">LIVE</a>
                            <a class="btn btn-secondary" href="<?= site_url('Attr_Masters/index/PNDG') ?>">PENDING</a>
                            <a class="btn btn-secondary" href="<?= site_url('Attr_Masters/index/REJ') ?>">REJECTED</a>
                            <a class="btn btn-secondary" href="<?= site_url('Attr_Masters/index/DLTD') ?>">DELETED</a>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="table-responsive" style="padding : 20px">
                    <table id="server_table" class="table table-bordered table-hover">
                        <thead>
                            <tr class='info'>
                                <!-- <th>ChecKBox</th> -->
                                <th><b class="text-primary">Sr No</b></th>
                                <th><b class="text-primary">Attr ID</b></th>
                                <th><b class="text-primary">Attr Name</b></th>
                                <th><b class="text-primary">Attr Category</b></th>
                                <th><b class="text-primary">Attr Value</b></th>
                                <th><b class="text-primary">Status</b></th>
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
    var url = '<?= site_url('Attr_Masters/ajax_manage_page/'.$cond2)?>';
    var actioncolumn=5;
</script>
 

 <script type="text/javascript">
    function delfunction(id)
    {        alert(id);
    
    }
</script>
<?php $this->load->view('common/footer');  ?>