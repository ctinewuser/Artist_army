    <main>
        <?php 
        // $home1=home1();
        // $home2=home2();
        // $home3=home3();
        // $home4=home4();
        // $home5=home5();
        // $home6=home6();
        ?>
        <div class="slider-area">
            
            <!-- <video width="100%" height="auto" autoPlay muted loop playsinline class="embed-responsive embed-responsive-16by9 ftco-degree-bottom position-relative">
              <source
                class="embed-responsive-item"
                //src="https://web.shieldguardplus.com/uploads/1603176872646newvideo.mp4"
                src="https://web.shieldguardplus.com/uploads/banner-video.mp4"
                type="video/mp4"
              />
            </video> -->


            <div class="slider-active slick-initialized slick-slider">
                <div class="slick-list draggable">
                    <div class="slick-track" style="opacity: 1;">
                        <div class="single-slider slider-height slider-padding sky-blue d-flex mt-0 align-items-center slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 100%; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;">
                            <div class="container mt-5">
                                <div class="d-md-block d-none" style="position: absolute; bottom: -40px;">
                                    <lottie-player class="my-style" src="https://assets8.lottiefiles.com/packages/lf20_dn3xsjbz.json"  background="transparent" speed="1" style="width: 350px;" loop autoplay></lottie-player>
                                </div>
                                <div class="row d-flex mt-5">
                                    <div class="col-md-6 mt-5">
                                        <div class="hero__caption">
                                            <!-- <span data-animation="fadeInUp" data-delay=".4s" class="" style="animation-delay: 0.4s;">Our Customer App</span> -->
                                            <h1 data-delay=".2s" data-aos="fade-right" class="main-hding mt-4" style="animation-delay: 0.6s; font-weight: 900;"><?php echo $home1['heading1'];?></h1>
                                            <p data-aos="fade-left" data-delay=".4s" class="sm-hding" style="animation-delay: 0.8s; color: #000"><?php echo $home1['heading2'];?></p>
                                            <!-- Slider btn -->
                                            <div class="slider-btns">
                                                <!-- Hero-btn -->
                                               <!--  <a data-animation="fadeInLeft" data-delay="1.0s" href="industries.html" class="btn radius-btn shadow" tabindex="0" style="animation-delay: 1s;">Download</a> -->
                                                <!-- Video Btn -->
                                                <a data-animation="fadeInRight" data-delay="1.0s" class="popup-video video-btn ani-btn" href="https://www.youtube.com/watch?v=1aP-TXUpNoU" tabindex="0" style="animation-delay: 1s;"><i class="fas fa-play"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-5">
                                        <div class="hero__img f-right" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                            <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/hero/hero_right.png" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-md-none d-block">
                                    <lottie-player class="" src="https://assets8.lottiefiles.com/packages/lf20_dn3xsjbz.json"  background="transparent" speed="1" style="width: 100%;" loop autoplay></lottie-player>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="single-slider slider-height slider-padding sky-blue d-flex align-items-center slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" style="width: 1349px; position: relative; left: -1349px; top: 0px; z-index: 998; opacity: 0;">
                            <div class="container">
                                <div class="row d-flex align-items-center">
                                    <div class="col-lg-7 col-md-9 ">
                                        <div class="hero__caption">
                                            <span data-animation="fadeInUp" data-delay=".4s">App Landing Page</span>
                                            <h1 data-animation="fadeInUp" data-delay=".6s">Get things done<br>with Quick Kitty</h1>
                                            <p data-animation="fadeInUp" data-delay=".8s">Dorem ipsum dolor sitamet, consectetur adipiscing elit, sed do eiusm tempor incididunt ulabore et dolore magna aliqua.</p>
                                            
                                            <div class="slider-btns">
                                            
                                                <a data-animation="fadeInLeft" data-delay="1.0s" href="industries.html" class="btn radius-btn shadow" tabindex="-1">Download</a>
                                            
                                                <a data-animation="fadeInRight" data-delay="1.0s" class="popup-video video-btn ani-btn" href="https://www.youtube.com/watch?v=1aP-TXUpNoU" tabindex="-1"><i class="fas fa-play"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="hero__img d-none d-lg-block f-right" data-animation="fadeInRight" data-delay="1s">
                                            <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/hero/hero_right.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <section class="home_banner_area d-flex align-items-center" style="background: url(<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/home-banner.png) no-repeat right center; height: 534px; background-position: center; background-size: cover;">
            <div class="banner_inner">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 d-flex align-items-center">
                            <div class="banner_content">
                                <h2 class="text-white" data-aos="fade-up" data-aos-duration="1000">
                                <?php echo $home2['heading1'];?>
                                </h2>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                   <?php echo $home2['heading2'];?>
                                </p>
                                <div class="d-flex align-items-center" data-aos="fade-up" data-aos-duration="1000">
                                   <!--  <a class="btn radius-btn" href="#"><span>Get Started</span></a>
                                    <a class="video-play-button" data-toggle="modal" data-target="#staticBackdrop">
                                        <span></span>
                                    </a>
                                    <div class="watch_video text-uppercase">
                                        watch the video
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-5">
                            <div class="home_right_img" data-aos="fade-up" data-aos-duration="2000">
                                 <img class="img-fluid" src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/home-right.png" alt=""> 
                            </div>
                        </div> -->

                        <div class="col-xl-3 col-lg-2 col-md-2 d-lg-block d-none">
                            <div class="app-active owl-carousel">
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer1.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer2.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer3.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer4.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer5.png" alt="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>


        
        <section class="best-features-area section-padd4" style="padding-top: 0px; overflow: hidden;">
            <div class="position-absolute" style="left: -320px;">
                <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_XUAM0x.json" background="transparent" speed="1" style="width: 90%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <div class="position-absolute" style="margin: 0 auto; left: 0px; right: 0px;">
                <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_6UE5Th.json" background="transparent" speed="1" style="width: 90%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <div class="position-absolute" style="right: -350px;">
                <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_XUAM0x.json" background="transparent" speed="1" style="width: 90%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <div class="container">
                <div class="row justify-content-end" >
                    <div class="col-xl-3 col-lg-2 col-md-2  d-lg-block d-none" >
                        <div class="app-active owl-carousel">
                            <div class="single-cases-img">
                                <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer1.png" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer2.png" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer3.png" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer4.png" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer5.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 offset-md-1">
                        <!-- Section Tittle -->
                        <div class="row">
                            <div class="col-lg-10 col-md-10">
                                <div class="section-tittle mb-5" data-aos="fade-up" data-aos-duration="1000">
                                    <h2>Some of the best features Of Our App!</h2>
                                </div>
                            </div>
                        </div>
                        <!-- Section caption -->
                        
                        <div class="row">
                            
                                      <?php
                    $i=0;
                    $j=3;
                    $feature=feature(); 
                    foreach($feature as $k =>$val)
                    {
                      if($k>=$i && $k<=$j){  
                    ?>
                    
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="single-features mb-70">
                                        <div class="features-icon">
                                           <!--  <span class="flaticon-support" data-aos="fade-up" data-aos-duration="2000"></span> -->
                                            <img src="<?php echo base_url('assets/quickkitty-web/').$val['image']; ?>">
                                        </div>
                                        <div class="features-caption d-flex align-items-center">
                                            <h3 data-aos="fade-up" data-aos-duration="2000"><?php echo $val['heading1'];?></h3>
                                            <p data-aos="fade-up" data-aos-duration="1700"><?php echo $val['heading2'];?></p>
                                        </div>
                                    </div>
                                </div>
                          
                           <?php
                      }}  
                    ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Shpe -->
            <div class="features-shpae d-none d-lg-block">
                <!-- <img src="<?php echo base_url(); ?>assets/img/shape/best-features.png" alt=""> -->
            </div>
        </section>
        
        <section class="progress-area gray-bg position-relative pb-5 mb-0" id="progress_page">
            <div class="position-absolute d-lg-block d-none" style="bottom: -90px;">
                <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_WBZkw7.json" class="my-style" background="transparent"  speed="1"  style="width: 380px; transform: scaleX(-1);" loop autoplay></lottie-player>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-lg-6">
                        <div class="page-title section-padding" style="padding-top: 60PX;">
                            <h5 class="title" data-aos="fade-up" data-aos-duration="1000">Driver App</h5>
                            <div class="space-10"></div>
                            <h3 class="dark-color" data-aos="fade-up" data-aos-duration="1200"><?php echo $home3['heading1'];?></h3>
                            <div class="space-20"></div>
                            <div class="desc " data-aos="fade-up" data-aos-duration="1400">
                                <p class="sm-hding"><?php echo $home3['heading2'];?></p>
                            </div>
                            <div class="space-50"></div>
                            <a href="<?php echo base_url('home/driver')?>" class="btn radius-btn shadow btn-rspnsv" data-aos="fade-up" data-aos-duration="1600">Learn More</a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3 d-lg-block d-none offset-md-1">
                        <figure class="mobile-image">
                            <!-- <div class="col-xl-8 col-lg-8 col-md-col-md-7"> -->
                            <div class="app-active owl-carousel mobile-image">
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver0.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver1.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver2.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver3.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver4.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver5.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver6.png" alt="">
                                </div>
                            </div>
                            <!-- </div> -->
                        </figure>
                    </div>
                    <div class="col-xs-12">
                        <div class="d-lg-none d-block">
                            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_WBZkw7.json" class="" background="transparent"  speed="1"  style="width: 100%; transform: scaleX(-1);" loop autoplay></lottie-player>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="recent_update_area">
            <div class="container">
                <div class="recent_update_inner">
                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link border-left border-right border-top  active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <span class="fa fa-users fa-2x"></span>
                                <h6 class="font-weight-bold">Our Customer App</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-left border-right border-top " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <span class="fa fa-user fa-2x"></span>
                                <h6 class="font-weight-bold">Service Provider App</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-left border-right border-top" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                <span class="fa fa-truck fa-2x"></span>
                                <h6 class="font-weight-bold">Our Driver<br>App</h6>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show position-relative active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <div class="position-absolute d-lg-block d-none" style="right: -80px; transform: translateY(-50%); top: 70%;">
                                <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_thFEdV.json" background="transparent" speed="1" style="width: 370px;" loop autoplay></lottie-player>
                            </div>

                            <div class="row recent_update_text align-items-center">
                                <div class="col-lg-5">
                                    <div class="common_style">
                                        <p class="line">Our Customer App</p>
                                        <h3 data-aos="fade-up" data-aos-duration="1000"><?php echo $home4['heading1'];?></h3>
                                        <p data-aos="fade-up" data-aos-duration="1200"><?php echo $home4['heading2'];?></p>
                                        <div class="app-btn mt-4 d-md-block d-flex" data-aos="fade-up" data-aos-duration="1400">
                                            <a href="#" class="app-btn1 w-rsp100"><img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app_btn1.png" class="" alt=""></a>
                                            <a href="#" class="app-btn2 w-rsp100"><img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app_btn2.png" class="" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="d-lg-none d-block">
                                        <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_thFEdV.json" background="transparent" speed="1" style="width: 100%;" loop autoplay></lottie-player>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 d-lg-block d-none offset-md-1" >
                                    <div class="app-active owl-carousel">
                                        <div class="single-cases-img">
                                            <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer1.png" alt="">
                                        </div>
                                        <div class="single-cases-img">
                                            <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer2.png" alt="">
                                        </div>
                                        <div class="single-cases-img">
                                            <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer3.png" alt="">
                                        </div>
                                        <div class="single-cases-img">
                                            <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer4.png" alt="">
                                        </div>
                                        <div class="single-cases-img">
                                            <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/customer5.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade position-relative" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <div class="position-absolute d-lg-block d-none" style="right: -30px; transform: translateY(-50%); top: 70%;">
                                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_teqtg9.json" background="transparent" speed="1" style="width: 310px;" loop autoplay></lottie-player>
                            </div>


                            <div class="row recent_update_text align-items-center">
                                <div class="col-lg-5">
                                    <div class="common_style">
                                        <p class="line">Service Provider App</p>
                                        <h3 data-aos="fade-up" data-aos-duration="1000"><?php echo $home5['heading1'];?></h3>
                                        <p data-aos="fade-up" data-aos-duration="1200"><?php echo $home5['heading2'];?></p>
                                        <div class="app-btn mt-4" data-aos="fade-up" data-aos-duration="1400">
                                            <a href="#" class="app-btn1"><img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app_btn1.png" alt=""></a>
                                            <a href="#" class="app-btn2"><img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app_btn2.png" alt=""></a>
                                        </div>
                                    </div>

                                    <div class="d-lg-none d-block">
                                        <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_teqtg9.json" background="transparent" speed="1" style="width: 100%;" loop autoplay></lottie-player>
                                    </div>
                                    
                                </div>
                                <div class="col-xl-3 col-lg-2 col-md-2 offset-md-1 d-lg-block d-none" >
                                <div class="app-active owl-carousel">
                                    <div class="single-cases-img">
                                        <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/serviceprovider1.png" alt="">
                                    </div>
                                    <div class="single-cases-img">
                                        <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/serviceprovider2.png" alt="">
                                    </div>
                                    <div class="single-cases-img">
                                        <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/serviceprovider3.png" alt="">
                                    </div>
                                    <div class="single-cases-img">
                                        <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/serviceprovider4.png" alt="">
                                    </div>
                                    <div class="single-cases-img">
                                        <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/serviceprovider5.png" alt="">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade position-relative" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                            <div class="position-absolute d-lg-block d-none" style="right: -30px; transform: translateY(-50%); top: 70%;">
                                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_npaer5z7.json"  background="transparent"  speed="1"  style="width: 450px; transform: scaleX(-1)" loop autoplay></lottie-player>
                            </div>

                            <div class="row recent_update_text align-items-center">
                                <div class="col-lg-5">
                                    <div class="common_style">
                                        <p class="line">Our Driver App</p>
                                        <h3 data-aos="fade-up" data-aos-duration="1000"><?php echo $home6['heading1'];?></h3>
                                        <p data-aos="fade-up" data-aos-duration="1200"><?php echo $home6['heading2'];?></p>
                                        <div class="app-btn mt-4" data-aos="fade-up" data-aos-duration="1400">
                                            <a href="#" class="app-btn1"><img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app_btn1.png" alt=""></a>
                                            <a href="#" class="app-btn2"><img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app_btn2.png" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="d-lg-none d-block">
                                        <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_npaer5z7.json"  background="transparent"  speed="1"  style="width: 100%; transform: scaleX(-1)" loop autoplay></lottie-player>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right d-lg-block d-none offset-md-1">
                                    <div class="chart_img">
                                        <figure class="mobile-image">
                            <!-- <div class="col-xl-8 col-lg-8 col-md-col-md-7"> -->
                            <div class="app-active owl-carousel mobile-image" style="background: url(<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/phone.png) no-repeat right center;  background-repeat: no-repeat; background-size: contain; ">
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver0.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver1.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver2.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver3.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver4.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver5.png" alt="">
                                </div>
                                <div class="single-cases-img">
                                    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/driver6.png" alt="">
                                </div>
                            </div>
                            <!-- </div> -->
                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
