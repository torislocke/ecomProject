        <!-- footer start -->
        <footer className="border-t">
            <div className="flex-1 wrapper">
                <div className="pt-10 m-auto grid grid-cols-1 md:grid-cols-2 md:w-screen md:gap-30 lg:grid-cols-3 max-w-[1280px] gap-10">
                    <section className="basis-1/2 lg:basis-1/3">
                        <h3>Cypress Coffee Company</h3>
                        <address>
                            Address: 22310 NE Marketplace Dr # 102, Redmond, WA 98053
                        </address>
                        <span>Telephone: <a href="4253055977">(425) 305-5977</a></span>
                    </section>
                    <section className="basis-1/2 lg:basis-1/3">
                        <h4>Hours of Operation</h4>
                        <ul>
                            <li>Sunday 7AM-1PM</li>
                            <li>Mon - Fri 6AM-4PM</li>
                            <li>Saturday 7AM-4PM</li>
                        </ul>
                    </section>
                    <section className="basis-1/2 lg:basis-1/3 pl-10">
                        <p>
                            <span className="pr-10">
                                <a href="https://www.instagram.com/cypresscoffeecompany/?hl=en"
                                    target="blank">Instagram</a>    
                            </span>

                            <a href="https://www.facebook.com/cypresscoffeecompany/"
                                target="blank">Facebook</a>
                        </p>
                    </section>
                </div>
            </div>
        </footer>












        <footer class="mt-100 overflow-hidden footer-style-2">
            <div class="footer-bottom bg-5">
                <div class="container">
                    <div
                        class="footer-bottom-inner d-flex flex-wrap justify-content-md-between justify-content-center align-items-center">
                        <ul class="footer-bottom-menu list-unstyled d-flex flex-wrap align-items-center mb-0">
                            <li class="footer-menu-item"><a href="<?php echo BASE_URL; ?>privacy">Privacy policy</a></li>
                            <li class="footer-menu-item"><a href="<?php echo BASE_URL; ?>terms">Terms & Conditions</a></li>
                        </ul>
                        <p class="copyright footer-text"><?php echo $setting_data['copyright_text']; ?></p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end -->

        <!-- scrollup start -->
        <button id="scrollup">
            <i class="fas fa-chevron-up" style="color:#fff;"></i>
        </button>
        <!-- scrollup end -->


        <!-- drawer menu start -->
        <div class="offcanvas offcanvas-start d-flex d-lg-none" tabindex="-1" id="drawer-menu">
            <div class="offcanvas-wrapper">
                <div class="offcanvas-header border-btm-black">
                    <h5 class="drawer-heading">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0 d-flex flex-column justify-content-between">
                    <nav class="site-navigation">
                        <ul class="main-menu list-unstyled">
                            <li class="menu-list-item nav-item active">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
                            </li>
                            <li class="menu-list-item nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>shop.php">Shop</a>
                            </li>
                            <li class="menu-list-item nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>blog">Blog</a>
                            </li>

                            <li class="menu-list-item nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>contact">Contact Us</a>
                            </li>
                        </ul>
                    </nav>
                    <ul class="utility-menu list-unstyled">
                        <li class="utilty-menu-item">
                            <a class="announcement-text" href="tel:+4253055977">
                                <span class="utilty-icon-wrapper">
                                    <i class="fas fa-phone"></i>
                                </span>
                                (425) 305-5977
                            </a>
                        </li>
                        <li class="utilty-menu-item">
                            <a class="announcement-login announcement-text" href="<?php echo BASE_URL; ?>login">
                                <span class="utilty-icon-wrapper">
                                    <i class="far fa-user"></i>
                                </span>
                                <span>Login</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- drawer menu end -->


        <!-- all js -->
        <script src="<?php echo BASE_URL; ?>dist-front/js/vendor.js"></script>
        <script src="<?php echo BASE_URL; ?>dist-admin/js/iziToast.min.js"></script>
        <script src="<?php echo BASE_URL; ?>dist-front/js/main.js"></script>
        </div>

        <?php if (isset($error_message)): ?>
            <script>
                iziToast.error({
                    message: '<?php echo $error_message; ?>',
                    position: 'topRight',
                    timeout: 4000,
                    color: 'red',
                    icon: 'fa fa-times',
                });
            </script>
        <?php endif; ?>


        <?php if (isset($success_message)): ?>
            <script>
                iziToast.success({
                    message: '<?php echo $success_message; ?>',
                    position: 'topRight',
                    timeout: 3000,
                    color: 'green',
                    icon: 'fa fa-check',
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <script>
                iziToast.success({
                    message: '<?php echo $_SESSION['success_message']; ?>',
                    position: 'topRight',
                    timeout: 3000,
                    color: 'green',
                    icon: 'fa fa-check',
                });
            </script>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>


        <?php if (isset($_SESSION['error_message'])): ?>
            <script>
                iziToast.success({
                    message: '<?php echo $_SESSION['error_message']; ?>',
                    position: 'topRight',
                    timeout: 3000,
                    color: 'red',
                    icon: 'fa fa-times',
                });
            </script>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        </body>

        </html>