<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
   

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
                        <!-- <a class="btn btn-primary dropdown-toggle" id="filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter</a>
                            <ul class="dropdown-menu" aria-labelledby="filter">
                                <li><a href="<?php echo base_url()?>Users/filter/live" value="live" <?php echo "live"?"selected":"";?>>Live</a></li>
                                <li><a href="#">Pending</a></li>
                                <li><a href="">Deleted</a></li>
                                <li><a href="">Rejected</a></li>
                            </ul> -->
                        <a class="btn btn-primary" href="<?= site_url('Users/create') ?>">Add User</a>
                    </div>   

                    <br><br><br><br><br><br><br>

                    <div class="col-md-12 text-left">    
                        <a class="btn btn-secondary" href="<?= site_url('Users/') ?>">ALL </a>
                        <a class="btn btn-secondary" href="<?= site_url('Users/index/LIVE') ?>">LIVE </a>
                        <a class="btn btn-secondary" href="<?= site_url('Users/index/PNDG') ?>">PENDING</a>
                        <a class="btn btn-secondary" href="<?= site_url('Users/index/REJ') ?>">REJECTED</a>
                        <a class="btn btn-secondary" href="<?= site_url('Users/index/DLTD') ?>">DELETED</a> 
                    </div>

               
                <div class="table-responsive" style="padding : 20px">
                    <table id="server_table" class="table table-bordered table-hover  ">
                        <thead> 
                            <tr class="info">
                                <th><b class="text-primary">Sr No</b></th>
                                <th><b class="text-primary">User ID</b></th>
				                <th><b class="text-primary">User Type Id</b></th>
                                <th><b class="text-primary">User Password</b></th>
                                <th><b class="text-primary">User Name</b></th>
                                <th><b class="text-primary">Description</b></th>
                                <th><b class="text-primary">Status</b></th>
				                <!-- <th><b class="text-primary">Sub Status</b></th> -->
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
    var url = '<?= site_url('Users/ajax_manage_page/'.$cond2)?>';
    var actioncolumn=3;
</script>
<?php $this->load->view('common/footer');  ?>