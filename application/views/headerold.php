<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="icon" href="<?php echo base_url(); ?>assets/fav-icon.png" sizes="16x16" />
        <title>Artist Army</title>
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Artist Army"/>
        <meta property="og:description" content="Artist Army"/>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <!--  <link rel="manifest" href="site.webmanifest"> -->
        <!-- CSS here -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/flaticon.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slicknav.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/themify-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slick.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/nice-select.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/aos.css">
    </head>
    <body>
        <header>
            <!-- Header Start -->
            <div class="header-area header-transparrent ">
                <div class="main-header header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2 col-md-2">
                                <div class="logo">
                                    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/logo.png" alt="" class="w-100"></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-xl-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li class="active"><a href="<?php echo base_url(); ?>"> Home</a></li>
                                            <li><a href="<?php echo base_url(); ?>home/aboutus">About Us</a></li>
                                            <li><a href="<?php echo base_url(); ?>home/features">Features</a></li>
                                            <li><a href="#">Our Services</a>
                                            <ul class="submenu">
                                                <li><a href="<?php echo base_url(); ?>home/customer">Customer</a></li>
                                                <li><a href="<?php echo base_url(); ?>home/driver">Driver</a></li>
                                                <li><a href="<?php echo base_url(); ?>home/serviceprovider">Service Provider</a></li>
                                            </ul>
                                            <li><a href="<?php echo base_url(); ?>home/contact">Contact Us</a></li>
                                            
                                            <?php $user = $this->session->userdata('user');
                                            
                                            if (!empty($user)){?>
  
                                         <li><div class="app-btn mt-4" style="display: contents;">
                                           <!--  <a href="<?php echo base_url(); ?>home/signin" class="app-btn1 btn radius-btn py-3">SignIn</a> -->
                                           <a href="#" class="app-btn2 btn radius-btn py-md-3 py-3 px-3"><?php echo $user['full_name']; ?></a>
                                            </div>
                                            <ul class="submenu rgster-before mt-2 ml-0">
                                                <li><a href="<?php echo base_url('home/profile_update/').$user['id'].'/'.$user['user_type'] ?>">Profile</a></li>
                                                <li><a href="<?php echo base_url(); ?>home/logout">Logout</a></li>
                                            </li>
                                        <?php  
                                        }
                                        else
                                        {

                                        ?>  
                                                <li style="padding-bottom: 20px;" class="mt-3">
                                                <div class="app-btn mt-4" style="display: contents;">
                                                <a href="#" class="app-btn2 btn radius-btn py-md-3 px-3 py-3">Register</a>
                                                </div>
                                                <ul class="submenu rgster-before mt-2 ml-0">
                                                <li><a href="<?php echo base_url(); ?>home/register_customer">Customer</a></li>
                                                <li><a href="<?php echo base_url(); ?>home/register_driver">Driver</a></li>
                                                <li><a href="<?php echo base_url(); ?>home/register_provider">Service Provider</a></li>
                                                </ul>
                                                </li>


                                        
                                                <li style="padding-bottom: 20px;"> <div class="app-btn mt-4" style="display: contents;">

                                                <a href="#" class="app-btn2 btn radius-btn py-md-3 py-3 px-3">Login</a>
                                                </div>
                                                <ul class="submenu rgster-before mt-2 ml-0">
                                                <li><a href="<?php echo base_url(); ?>home/login_customer">Customer</a></li>
                                                <li><a href="<?php echo base_url(); ?>home/login_driver">Driver</a></li>
                                                <li><a href="<?php echo base_url(); ?>home/login_provider">Service Provider</a></li>
                                                </ul>
                                                </li>
                                            <?php }?>
                                            </ul>
                                         </nav>
                                    </div>
                                </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-xl-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>