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
                                <label class="control-label" for="inputSuccess1">Category Type</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $categoryTypeName;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>  
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Category Level 1</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $categoryLevel1;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Category Level 2</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $categoryLevel2;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>  
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Category Description</label>
                                <?= html_entity_decode($desc) ?>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Category Level</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $level;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6">
                            <div class="form-group">
                            <div class="fg-line">
                                <label class="control-label" for="inputSuccess1">Category Position</label>
                                <input class="form-control" id="inputSuccess1" value="<?= $position;  ?>" type="text" disabled="">
                            </div>
                        </div>
                        </div>
                    </div>   
                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location='<?= site_url('Categories_level2/index/'.$cond2) ?>'" >Back</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
