<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>
    <section id="content">
                <div class="container">
                    <div class="block-header">
                        <h2>Dashboard</h2>
					</div>
					<div class="mini-charts">
                        <div class="row">
                            <a href="<?= site_url('Categories_type') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-green">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Category Type</small>
                                                <h2><?= $countcategoryType; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="<?= site_url('Categories') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-orange">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Category</small>
                                                <h2><?= $countcategories; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="<?= site_url('Brands') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-green">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Brands</small>
                                                <h2><?= $countbrands; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="<?= site_url('Products') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-orange">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Products</small>
                                                <h2><?= $countproducts; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="<?= site_url('Users') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-green">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Users</small>
                                                <h2><?= $countusers; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- <a href="<?= site_url('Sellers') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-green">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Sellers</small>
                                                <h2><?= $countsellers; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a> -->

                            <a href="<?= site_url('Deals') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-orange">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Deals</small>
                                                <h2><?= $countdeals; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="<?= site_url('Attr_Masters') ?>">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mini-charts-item bgm-green">
                                        <div class="clearfix">
                                            <div class="chart stats-line-2"></div>
                                            <div class="count">
                                                <small>Total Attributes</small>
                                                <h2><?= $countattributes; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                    </div>
                 </div>
            </section>
</section>
<?php $this->load->view('common/footer');  ?>
