<?php include('header.php'); ?>
<!-- Main content Start -->
<div class="main-content">
            <!-- Breadcrumbs Section Start -->
            <div class="rs-breadcrumbs bg-8">
                <div class="container">
                    <div class="content-part text-center">
                        <h1 class="breadcrumbs-title white-color mb-0">My Account</h1>
                    </div>
                </div>
            </div>
            <!-- Breadcrumbs Section End -->

            <!-- Account Login Start -->
            <div id="rs-my-account" class="rs-my-account pt-100 pb-100 md-pt-57 md-pb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 md-order-first md-mb-40 ">
                            <div class="login-side">
                                <div class="sec-title">
                                    <h2 class="title">Login</h2>
                                </div>
                                <form class="login-form">
                                    <label class="input-label">Username or email address <span>*</span></label>
                                    <input class="input-control" type="email" name="email" required>
                                    <label class="input-label">Password <span>*</span></label>
                                    <input class="input-control" type="password" name="password" required>
                                    <div class="login-control">
                                        <ul>
                                            <li><button type="submit" class="readon">Login</button></li>
                                            <li>
                                                <label class="checkbox">
                                                    <input type="checkbox" name="Remember"> Remember me
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <a class="psw-recover" href="#">Lost Your Password?</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Account Login End -->
        </div> 
        <!-- Main content End -->

<?php include('footer.php'); ?>