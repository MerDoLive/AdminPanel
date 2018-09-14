 
<?php $this->load->view('common/header');  
//print_r("expression"); exit;
?>
<?php $this->load->view('common/left_panel');  ?>

    <section id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-city-alt"></i>&nbsp;<?= $heading ?></h3></div>
                    <div class="col-md-4 text-center">
                        <?php 
                           if(count($this->session->userdata('message')))
                           {
                        ?>
                        <span class="alert"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></span>          
                        <?php } ?>
                    </div>
                   <div class="col-md-4 text-right">
                        <a class="btn btn-primary" href="<?= site_url('Categories_type/createMasterType') ?>">Add </a>
                    </div>

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <div class="col-md-12 text-left">
                            <a class="btn btn-secondary" href="<?= site_url('Categories_type/index/ALL') ?>">ALL(<?= $all?>)<a>
                            <a class="btn btn-secondary" href="<?= site_url('Categories_type/index/LIVE') ?>">LIVE(<?= $live?>)</a>
							<a class="btn btn-secondary" href="<?= site_url('Categories_type/index/DLTD')?>">DELETED(<?= $deleted?>)</a>
                    <div style="clear:both"></div>
                </div>
<div class="col-md-12 text-right">
                            <a class="btn btn-secondary" href="<?= site_url('Categories_type/export') ?>">EXPORT
                </a></div>
                <div class="table-responsive"  style="padding: 20px">
                    <table id="server_table" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr class='info'>
                                <th><b class="text-primary">Sr No</b></th>
                                <th><b class="text-primary">Category Type Id</b></th>
                                <th><b class="text-primary">Category Type Name</b></th>
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

    var url = '<?= site_url('Categories_type/ajax_manage_page/'.$cond2)?>';
    var actioncolumn=3;
</script>
<?php $this->load->view('common/footer');  ?>
