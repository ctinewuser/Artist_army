     <style type="text/css">
         
.bg-primary {
    background-color: #21323a!important
}

     </style>
        <div class="container-fluid">
          <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Profile</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 


                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Profile -->
                                <div class="card bg-primary">
                                    <div class="card-body profile-user-box">

                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="media">
                                                    <span class="float-left m-2 mr-4"><img src="<?php echo base_url(); ?>/assets/userfile/profile/<?php echo $admin['image']; ?>" style="height: 100px;" alt="" class="rounded-circle img-thumbnail"></span>
                                                    <div class="media-body">

                                                        <h4 class="mt-1 mb-1 text-white"><?php echo $admin['first_name'].' '.$admin['last_name'];?></h4>
                                                     

                                                        <!--<ul class="mb-0 list-inline text-light">-->
                                                        <!--    <li class="list-inline-item mr-3">-->
                                                        <!--        <h5 class="mb-1">USD 0</h5>-->
                                                        <!--        <p class="mb-0 font-13 text-white-50">Total Revenue</p>-->
                                                        <!--    </li>-->
                                                        <!--    <li class="list-inline-item">-->
                                                        <!--        <h5 class="mb-1">0</h5>-->
                                                        <!--        <p class="mb-0 font-13 text-white-50">Number of Bookings</p>-->
                                                        <!--    </li>-->
                                                        <!--</ul>-->
                                                    </div> <!-- end media-body-->
                                                </div>
                                            </div> <!-- end col-->

                                            <div class="col-sm-4">
                                                <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                                    <a href="<?php echo base_url('admin/admineditprofile/').$admin_id;?>" class="btn btn-light">
                                                        <i class="fa fa-user-edit mr-1"></i> Edit Profile
                                                    </a>
                                                </div>
                                            </div> <!-- end col-->
                                        </div> <!-- end row -->

                                    </div> <!-- end card-body/ profile-user-box-->
                                </div><!--end profile/ card -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->


                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <!-- Personal-Information -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mt-0 mb-3">Information</h4>
                                        <p class="text-muted font-13">
                                            <?php echo $admin['bio']; ?>
                                        </p>

                                        <hr/>

                                        <div class="text-left">
                                            <p class="text-muted"><strong>Full Name :</strong> <span class="ml-2"><?php echo $admin['first_name'].' '.$admin['last_name'];?></span></p>

                                            <p class="text-muted"><strong>Mobile :</strong><span class="ml-2"><?php echo $admin['mobile_number'];?></span></p>

                                            <p class="text-muted"><strong>Email :</strong> <span class="ml-2"><?php echo $admin['email'];?></span></p>

                                            <p class="text-muted"><strong>Location :</strong> <span class="ml-2"><?php echo $admin['location'];?></span></p>

                                            <p class="text-muted"><strong>Languages :</strong>
                                                <span class="ml-2"> <?php echo $admin['language'];?> </span>
                                            </p>
                                   

                                        </div>
                                    </div>
                                </div>
                                <!-- Personal-Information -->

                                <!-- Messages-->
      

                            </div> <!-- end col-->

                            <div class="col-lg-8">

                                <!-- Chart-->
                             <!--   <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Orders & Revenue</h4>
                                        <div class="chart-area">
                                          <canvas id="myAreaChart"></canvas>
                                        </div>       
                                    </div>
                                </div>-->
                                <!-- End Chart-->

                                <!--<div class="row mt-4">-->
                                <!--    <div class="col-sm-6">-->
                                <!--        <div class="card tilebox-one">-->
                                <!--            <div class="card-body">-->
                                <!--                <i class="dripicons-basket float-right text-muted"></i>-->
                                <!--                <h6 class="text-muted text-uppercase mt-0">Bookings</h6>-->
                                <!--                <h2 class="m-b-20">0</h2>-->
                                                
                                <!--            </div> <!-- end card-body-->
                                <!--        </div> <!--end card-->
                                <!--    </div><!-- end col -->

                                <!--    <div class="col-sm-6">-->
                                <!--        <div class="card tilebox-one">-->
                                <!--            <div class="card-body">-->
                                <!--                <i class="dripicons-box float-right text-muted"></i>-->
                                <!--                <h6 class="text-muted text-uppercase mt-0">Revenue</h6>-->
                                <!--                <h2 class="m-b-20">USD<span>0</span></h2>-->
                                               
                                <!--            </div> <!-- end card-body-->
                                <!--        </div> <!--end card-->
                                <!--    </div><!-- end col -->

                   

                                <!--</div>-->
                                <!-- end row -->


<!--                                <div class="card mt-4">-->
<!--                                    <div class="card-body">-->
<!--                                        <h4 class="header-title mb-3">Services</h4>-->

<!--                                        <div class="table-responsive">-->
<!--                                            <table class="table table-hover table-centered mb-0">-->
<!--                                                <thead>-->
<!--                                                    <tr>-->
<!--                                                        <th>Service</th>-->
<!--                                                        <th>Price</th>-->
<!--                                                    </tr>-->
<!--                                                </thead>-->
<!--                                                <tbody>-->
<!--<?php foreach($services as $key => $value){ ?>-->
<!--                                                    <tr>-->
<!--                                                        <td><?php echo $value['service_offer_subcategory_name']; ?></td>-->
<!--                                                        <td>USD <?php echo $value['sevice_price']; ?></td>-->
                                                        
<!--                                                    </tr>-->
<!--                                              <?php }?>-->
<!--                                                </tbody>-->
<!--                                            </table>-->
<!--                                        </div> -->
<!--                                    </div>-->
<!--                                </div> -->

                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->

        </div>
        <!-- /.container-fluid -->

