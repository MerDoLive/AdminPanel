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

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Deal Name</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $dealsName;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>  

                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Description</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $desc;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Start Date</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $startdate;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">End Date</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $enddate;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Deal Type</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $dealtype;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Discount</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $discount;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Deals') ?>'" >Back</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
