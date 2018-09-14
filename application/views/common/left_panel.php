<?php
    $page = $this->uri->segment(1);
    $pageAction = $this->uri->segment(2);
    $id = ($_SESSION['tbsCampaign']['id']);
        $con = "USER_MSTR_USER_ID='$id'";
        $row = $this->Crud_model->GetData('USER_MSTR','',$con,'','','','single');
?>
<section id="main">
<aside id="sidebar" class="sidebar c-overflow">
    <div class="s-profile">
        <a href="#" data-ma-action="profile-menu-toggle">
            <div class="sp-pic">
            </div>
            <div class="sp-info">
                <?= ucfirst($row->USER_MSTR_USER_NAME); ?>
                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>
        <ul class="main-menu">            
            <li>
                <a href="<?= site_url('Login/profile') ?>"><i class="zmdi zmdi-settings"></i> Change Profile</a>
            </li>
            <li>
                <a href="<?= site_url('Login/change_password') ?>"><i class="zmdi zmdi-settings"></i> Change Password</a>
            </li>
            <li>
                <a href="<?= site_url('Login/logout') ?>"><i class="zmdi zmdi-time-restore"></i> Logout</a>
            </li>
        </ul>
    </div>

    <ul class="main-menu">
        <li <?php if($page=='Dashboard') { ?> class="active" <?php } ?> >
            <a href="<?= site_url('Dashboard/index') ?>"><i class="zmdi zmdi-home"></i>Dashboard</a>
        </li>
        <li <?php if($page=='Categories_type') { ?> class="active" <?php } ?> ><a href="<?= site_url('Categories_type/index/LIVE') ?>"><i class="zmdi zmdi-city-alt"></i> Category Type Management</a></li>
        <li class="sub-menu <?php if(($page=='Categories') || ($page=='Categories_level2') || ($page=='Categories_level2')) { ?> active <?php } ?>">
            <a  data-ma-action="submenu-toggle"><i class="zmdi zmdi-view-compact"></i> Category Management</a>
                <ul>
                    <li <?php if($page=='Categories') { ?> class="active" <?php } ?>><a href="<?= site_url('Categories/index/LIVE') ?>">Category Level 1</a></li>
                    <li <?php if($page=='Categories_level2') { ?> class="active" <?php } ?>><a href="<?= site_url('Categories_level2/index/LIVE') ?>">Category Level 2</a></li>
                    <li <?php if($page=='Categories_level3') { ?> class="active" <?php } ?>><a href="<?= site_url('Categories_level3/index/LIVE') ?>">Category Level 3</a></li>
                </ul>
        </li>
        
        <li <?php if($page=='Brands') { ?> class="active" <?php } ?> ><a href="<?= site_url('Brands/index/LIVE') ?>"><i class="zmdi zmdi-city-alt"></i> Brand Management</a></li>
	    <li <?php if($page=='Deals') { ?> class="active" <?php } ?> ><a href="<?= site_url('Deals/index/LIVE') ?>"><i class="zmdi zmdi-city-alt"></i> Deals Management</a></li>
        <li <?php if($page=='Products') { ?> class="active" <?php } ?> ><a href="<?= site_url('Products/index/LIVE') ?>"><i class="zmdi zmdi-city-alt"></i> Products Management</a></li>

        <li <?php if($page=='Attr_Masters') { ?> class="active" <?php } ?> ><a href="<?= site_url('Attr_Masters/index/LIVE') ?>"><i class="zmdi zmdi-city-alt"></i> Attributes Managment</a></li>
        <!-- <li class="sub-menu <?php if(($page=='Attr_Masters') || ($page=='AttrValues')) { ?> active <?php } ?>">
            <a  data-ma-action="submenu-toggle"><i class="zmdi zmdi-view-compact"></i> Attributes Managment</a>
                <ul>
                    <li <?php if($page=='Attr_Masters') { ?> class="active" <?php } ?>><a href="<?= site_url('Attr_Masters') ?>">Attributes Master</a></li>
                    <li <?php if($page=='Attr_Values') { ?> class="active" <?php } ?>><a href="<?= site_url('Attr_Values') ?>">Attributes Values</a></li>
                </ul>
        </li> -->

        <li class="sub-menu <?php if(($page=='Image_Masters') || ($page=='Image_Values')) { ?> active <?php } ?>">
            <a  data-ma-action="submenu-toggle"><i class="zmdi zmdi-view-compact"></i> Image Managment</a>
                <ul>
                    <li <?php if($page=='Image_Masters') { ?> class="active" <?php } ?>><a href="<?= site_url('Image_Masters/index/LIVE') ?>">Image Group Master</a></li>
                    <li <?php if($page=='Image_Values') { ?> class="active" <?php } ?>><a href="<?= site_url('Image_Values/index/LIVE') ?>">Upload Images</a></li>
                </ul>
        </li>

        <li class="sub-menu <?php if(($page=='Seller_Request') || ($page=='Sellers')) { ?> active <?php } ?>">
            <a  data-ma-action="submenu-toggle"><i class="zmdi zmdi-view-compact"></i> Seller Management</a>
                <ul>
                    <li <?php if($page=='Seller_Request') { ?> class="active" <?php } ?>><a href="<?= site_url('Seller_Request') ?>">Seller Requests</a></li>
                    <li <?php if($page=='Sellers') { ?> class="active" <?php } ?>><a href="<?= site_url('Sellers') ?>">Sellers</a></li>
                </ul>
        </li>


	 <li <?php if($page=='Users') { ?> class="active" <?php } ?> ><a href="<?= site_url('Users') ?>"><i class="zmdi zmdi-city-alt"></i>User Management</a></li>

        
        <!-- <li <?php if($page=='ContactUs') { ?> class="active" <?php } ?> ><a href="<?= site_url('ContactUs') ?>"><i class="zmdi zmdi-city-alt"></i> Seller Requests</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Sellers</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Customers</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Customers Quiries</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Reports</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Products</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Seller Products</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Image</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Sellers Promotion</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Orders</a></li>
        <li <?php if($page=='CMS') { ?> class="active" <?php } ?> ><a href="<?= site_url('CMS') ?>"><i class="zmdi zmdi-city-alt"></i> Deals</a></li> -->

        
    </ul>
</aside>
