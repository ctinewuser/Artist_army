<div class="footer set-bg w-100" style="background-color: #4EFFBB; margin-top: 50px;">
            <div class="container py-4">
               <div class="row d-flex align-items-center justify-content-center">
                  <div class="col-md-6 col-sm-6">
                     <div class=" text-md-left text-center">
                        <h5 class="text-dark mb-3">Follow us on Social Media</h5>
                        <div class="footer__social">
                           <a href="javascript:void(0)" target="_new" class="insta-color"><i class="fa fa-instagram"></i></a>
                           <a href="javascript:void(0)" class="fb-color" target="_new"><i class="fa fa-facebook"></i></a>
                           <a href="javascript:void(0)" target="_new" class="youtube-color"><i class="fa fa-youtube-play"></i></a>
                           <a href="javascript:void(0)" target="_new" class="twitter-color">
                              <i class="fa fa-twitter"></i>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 mt-md-0 mt-4">
                     <ul class="d-flex justify-content-between align-items-center footer-link" style="list-style: none;">
                        <li class="mr-lg-5 mr-1 ml-lg-0 ml-1 ml-lg-auto"><a href="<?php echo  base_url('home/terms')?>" class="text-dark font-14">Terms & Conditions</a></li>
                        <li class="mr-lg-5 mr-1 ml-lg-0 ml-1"><a href="<?php echo base_url('home/privacy')?>" class="text-dark font-14">Privacy Policy</a></li>
                        <li class="mr-lg-0 mr-1 ml-lg-0 ml-1"><a href="javascript:void(0)" class="font-14 text-dark">Contact Us</a></li>
                     </ul>    
                  </div>
               </div>
            </div>            
         </div>

      </section>
      
      <script src="<?php echo base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
      <script src="<?php echo base_url('assets/') ?>js/bootstrap.min.js"></script>
      <script src="<?php echo base_url('assets/') ?>js/owl.carousel.min.js"></script>
      <script src="<?php echo base_url('assets/') ?>js/main.js"></script>
      
      <script>

         $(document).ready(function(){
           $(".ticktok-color").hover(function(){
             $(".ticktok-color img").toggleClass('d-none');
           });
         });

        $('.owl-carousel').owlCarousel({
            loop:false,
            margin:0,
            autoplay:false,
             autoplayTimeout:2500,
             autoplayHoverPause:true,
            nav:false,
          dots: true,
            responsive:{
                0:{
                    items:1,
                  dots: true,
                },
                600:{
                    items:1,
                  dots: true,
                },
                1000:{
                    items:1,
                  dots: true,
                }
            }
        })
      </script>

   </body>
   
</html>