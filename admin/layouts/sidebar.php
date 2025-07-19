<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo ADMIN_URL; ?>dashboard.php">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo ADMIN_URL; ?>dashboard.php"></a>
        </div>

        <ul class="sidebar-menu">

            
            <li class="<?php if($cur_page == 'dashboard.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>

            <li class="nav-item dropdown <?php if($cur_page == 'setting-logo.php' || $cur_page == 'setting-favicon.php' || $cur_page == 'setting-top-bar.php' || $cur_page == 'setting-footer.php' || $cur_page == 'setting-theme-color.php') {echo 'active';} ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-folder"></i><span>Website Settings</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if($cur_page == 'setting-logo.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>setting-logo.php"><i class="fas fa-angle-right"></i> Logo</a></li>
                    <li class="<?php if($cur_page == 'setting-favicon.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>setting-favicon.php"><i class="fas fa-angle-right"></i> Favicon</a></li>
                    <li class="<?php if($cur_page == 'setting-top-bar.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>setting-top-bar.php"><i class="fas fa-angle-right"></i> Top Bar</a></li>
                    <li class="<?php if($cur_page == 'setting-footer.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>setting-footer.php"><i class="fas fa-angle-right"></i> Footer</a></li>
                    <li class="<?php if($cur_page == 'setting-theme-color.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>setting-theme-color.php"><i class="fas fa-angle-right"></i> Theme Color</a></li>
                </ul>
            </li>

            <li class="<?php if($cur_page == 'product-category-view.php' || $cur_page == 'product-category-create.php' || $cur_page == 'product-category-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>product-category-view.php"><i class="far fa-file"></i> <span>Product Category</span></a></li>

            <li class="<?php if($cur_page == 'product-view.php' || $cur_page == 'product-create.php' || $cur_page == 'product-edit.php' || $cur_page == 'product-photo-gallery.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>product-view.php"><i class="far fa-file"></i> <span>Product</span></a></li>

            <li class="<?php if($cur_page == 'coupon-view.php' || $cur_page == 'coupon-create.php' || $cur_page == 'coupon-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>coupon-view.php"><i class="far fa-file"></i> <span>Coupon</span></a></li>

            <li class="<?php if($cur_page == 'area-view.php' || $cur_page == 'area-create.php' || $cur_page == 'area-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>area-view.php"><i class="far fa-file"></i> <span>Area</span></a></li>

            <li class="<?php if($cur_page == 'customer-view.php' || $cur_page == 'customer-create.php' || $cur_page == 'customer-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>customer-view.php"><i class="far fa-file"></i> <span>Customer</span></a></li>

            <li class="<?php if($cur_page == 'order-view.php' || $cur_page == 'order-invoice.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>order-view.php"><i class="far fa-file"></i> <span>Order</span></a></li>

            <li class="<?php if($cur_page == 'post-category-view.php' || $cur_page == 'post-category-create.php' || $cur_page == 'post-category-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>post-category-view.php"><i class="far fa-file"></i> <span>Post Category</span></a></li>

            <li class="<?php if($cur_page == 'post-view.php' || $cur_page == 'post-create.php' || $cur_page == 'post-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>post-view.php"><i class="far fa-file"></i> <span>Post</span></a></li>

            <li class="<?php if($cur_page == 'comment-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>comment-view.php"><i class="far fa-file"></i> <span>Comment</span></a></li>

            <li class="<?php if($cur_page == 'subscriber-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>subscriber-view.php"><i class="far fa-file"></i> <span>Subscriber</span></a></li>

            <li class="<?php if($cur_page == 'slider-view.php' || $cur_page == 'slider-create.php' || $cur_page == 'slider-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>slider-view.php"><i class="far fa-file"></i> <span>Slider</span></a></li>

            <li class="<?php if($cur_page == 'faq-view.php' || $cur_page == 'faq-create.php' || $cur_page == 'faq-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>faq-view.php"><i class="far fa-file"></i> <span>FAQ</span></a></li>

            <li class="<?php if($cur_page == 'terms-privacy-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>terms-privacy-view.php"><i class="far fa-file"></i> <span>Terms & Privacy Page</span></a></li>

            

        </ul>
    </aside>
</div>