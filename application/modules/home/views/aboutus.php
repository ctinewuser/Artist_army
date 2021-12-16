<main>
<section class="services-padding sky-blue">
<div class="container">
    <div class="row recent_update_text align-items-center">
        <div class="col-lg-10 offset-lg-1 text-center">
            <div class="common_style">
                <h3 class="text-center after-line-hidden">About Us</h3>
               <?php // added by chandni on 05/02/2021
               $about_us1  = about_us1();
               $about_us2  = about_us2();

               if(!empty($about_us1)){
                $heading1 = $about_us1['heading1'];
                $heading2 = $about_us1['heading2'];
               }else{
                 $heading1 = "";
                 $heading2 = "";
               }

               if(!empty($about_us2)){
                $heading3 = $about_us2['heading1'];
                $heading4 = $about_us2['heading2'];
               }else{
                 $heading3 = "";
                 $heading4 = "";
               }
               ?> 
                <h5 class="font-weight-bold line-h-30 sm-hding" ddata-aos="fade-up" data-aos-duration="2000"><?php echo $heading1;?></h5>
                <br>
                <h6 data-aos="fade-up" class="font-weight-bold about-text-theme line-h-24 sm-hding" data-aos-duration="1200"><?php echo $heading2;?></h6>
                
            </div>
        </div>
        <!-- <div class="col-lg-6">
            <div class="chart_img" data-aos="fade-up" data-aos-duration="2000">
                <img class="img-fluid" src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/about_img_1.png" alt="">
            </div>
        </div> -->
    </div>
</div>
</section>

<!-- Available App  Start-->
<div class="available-app-area pt-lg-5 pt-0">
<div class="container pt-lg-5 pt-0 mt-lg-5 mt-0">
    <div class="row d-flex justify-content-between">
        <div class="col-xl-5 col-lg-5">
            <div class="app-img" data-aos="fade-up" data-aos-duration="1500">
                <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/gallery/about2image.png" alt="">
            </div>
        </div>
        <div class="col-xl-5 col-lg-6 mt-lg-0 mt-5">
            <div class="app-caption mt-lg-0 mt-5">
                <div class="section-tittle section-tittle3">
                    <p class="text-white sm-hding" data-aos="fade-up" data-aos-duration="2000"><?php echo $heading3;?></p>
                    <p class="sm-hding" data-aos="fade-up" data-aos-duration="1700"><?php echo $heading4;?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shape -->
<div class="app-shape">
    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app-shape-top.png" alt="" class="app-shape-top heartbeat d-none d-lg-block">
    <img src="<?php echo base_url(); ?>assets/quickkitty-web/img/shape/app-shape-left.png" alt="" class="app-shape-left d-none d-xl-block">
    <!-- <img src="assets/img/shape/app-shape-right.png" alt="" class="app-shape-right bounce-animate "> -->
</div>
</div>
<!-- Available App End-->
<!-- Our Customer Start -->
<!-- <div class="our-customer section-padd-top30 sky-blue">
<div class="container-fluid">
    <div class="our-customer-wrapper">
    
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8">
                <div class="section-tittle text-center">
                    <h2>What Our Customers<br> Have to Say</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="customar-active dot-style d-flex dot-style">
                    <?php
                    $testomonials=testomonials();
                    foreach($testomonials as $k =>$val)
                    {
                    
                    
                    ?>
                    
                    
                    
                    <div class="single-customer mb-100 shadow">
                        <div class="what-img">
                            <img src="<?php echo base_url(); ?>assets/images/<?php echo $val['image']; ?>" alt="">
                        </div>
                        <div class="what-cap">
                            <h4><a href="#"><?php echo $val['heading1']; ?></a></h4>
                            <p><?php echo $val['heading2']; ?></p>
                        </div>
                    </div>
            
                    <?php } ?>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div> -->
<!-- Our Customer End -->
</main>
