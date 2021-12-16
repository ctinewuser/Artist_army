

        <!-- Begin Page Content -->



        <div class="container-fluid">

          <!-- Page Heading -->



          <div class="d-sm-flex align-items-center justify-content-between mb-4">



            <h1 class="h3 mb-0 page-title">Dashboard</h1>



            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->



          </div>


          <!-- Content Row -->



          <div class="row dash-boxes">


            <!-- Earnings (Monthly) Card Example -->



            <div class="col-xl-3 col-md-6 mb-4">



              <div class="card border-left-primary shadow">



                <div class="card-body">



                  <div class="row no-gutters align-items-center">



                    <div class="col mr-2">



                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total (Users)</div>



                      <div class="h5 mb-0 title-md"><?php echo $user;?></div>



                    </div>



                    <div class="col-auto">

                      <i class="fa fa-user fa-2x color-1"></i>
                        <!--   <i class="fa fa-user" aria-hidden="true"></i> -->
                     <!--  <i class="fas fa-calendar fa-2x color-1"></i> -->



                    </div>



                  </div>



                </div>



              </div>



            </div>







            <!-- Earnings (Monthly) Card Example -->



            <div class="col-xl-3 col-md-6 mb-4">



              <div class="card border-left-success shadow">



                <div class="card-body">



                  <div class="row no-gutters align-items-center">



                    <div class="col mr-2">



                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total (Fans)</div>



                      <div class="h5 mb-0 title-md"><?php echo $follower;?></div>



                    </div>



                    <div class="col-auto">

                     <i class="fa fa-star  fa-2x color-2"></i>
                   <!--  <i class="fa fa-smile-o  fa-2x color-2"></i> -->
                     <!--  <i class="fas fa-dollar-sign fa-2x color-2"></i> -->



                    </div>



                  </div>



                </div>



              </div>



            </div>







            <!-- Earnings (Monthly) Card Example -->



            <div class="col-xl-3 col-md-6 mb-4">



              <div class="card border-left-info shadow">



                <div class="card-body overflow-h">



                  <div class="row no-gutters align-items-center">



                    <div class="col mr-2">



                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Concerts</div>



                      <div class="row no-gutters align-items-center">



                        <div class="col-auto">



                          <div class="h5 mb-0 title-md"><?php echo $concerts; ?></div>



                        </div>



                        <div class="col ml-2">



                         <!--  <div class="progress progress-sm mr-2">



                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>



                          </div>
 -->


                        </div>



                      </div>



                    </div>



                    <div class="col-auto">

                    <i class='fa fa-microphone fa-2x color-3'></i>  
                  <!-- <i class="fa fa-cog fa-2x color-3"></i>
 -->
                      <!-- <i class="fas fa-clipboard-list fa-2x color-3"></i> -->



                    </div>



                  </div>



                </div>



              </div>



            </div>







            <!-- Pending Requests Card Example -->



            <div class="col-xl-3 col-md-6 mb-4">



              <div class="card border-left-warning shadow">



                <div class="card-body">



                  <div class="row no-gutters align-items-center">



                    <div class="col mr-2">



                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Credit Goals</div>



                      <div class="h5 mb-0 title-md"><?php echo $goals; ?></div>



                    </div>



                    <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x color-2"></i>
                     <!--  <i class='fa fa-dollar fa-2x color-4'></i> -->
                      <!-- <i class="fa fa-film fa-2x color-4"></i> -->
                     <!--  <i class="fas fa-comments fa-2x color-4"></i>
 -->


                    </div>



                  </div>



                </div>



              </div>



            </div>



          </div>







          <!-- Content Row -->







          <div class="row">







            <!-- Area Chart -->



            <div class="col-xl-8 col-lg-7">



              <div class="card shadow">



                <!-- Card Header - Dropdown -->



                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">



                  <h6 class="m-0 font-weight-bold text-theme">Overview</h6>

                
                </div> 



                <!-- Card Body  myAreaChart-->



                <div class="card-body">



                  <div class="chart-area">



                  <!--   <canvas id="myAreaChart"></canvas> -->

                
                      <!--Test Graph -->

                      <div id="chart_div" style="width: 630px; height: 340px;"></div>
            

                  </div>

                </div>

              </div>

            </div>
         <div class="col-xl-4 col-lg-5">

              <div class="card shadow h-100">

                <!-- Card Header - Dropdown -->

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-theme">Revenue Sources</h6>
                </div>
                <!-- Card Body -->

                <div class="card-body">

                  <div class="chart-pie pt-4 pb-2 overflow-h">
                       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      
                      <div id="piechart" style="width: 300px; height: 300px;"></div> 

                  </div>

                 <!--  <div class="mt-4 text-center small">

                    <span class="mr-2">

                      <i class="fas fa-circle text-primary"></i> Customer

                    </span>

                    <span class="mr-2">

                      <i class="fas fa-circle text-success"></i> Provider

                    </span>

                    <span class="mr-2">

                      <i class="fas fa-circle text-info"></i> Driver

                    </span>

                  </div> -->

                </div>



              </div>

            </div>



            <!-- Pie Chart -->

<!--<div class="col-lg-12 mb-4">-->







              <!-- Project Card Example -->









        

<!--              <div class="card shadow mb-4">-->



<!--                <div class="card-header py-3">-->



<!--                  <h6 class="m-0 font-weight-bold text-theme">Products</h6>-->



<!--                </div>-->



<!--                <div class="card-body">-->



<!--                  <h4 class="small font-weight-bold">Vendor products <span class="float-right"><?php echo $normal_product; ?></span></h4>-->



<!--                  <div class="progress mb-4">-->



<!--                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>-->



<!--                  </div>-->



          <!--        <h4 class="small font-weight-bold">Elite products<span class="float-right"><?php echo $elite_product; ?></span></h4>



                 <div class="progress mb-4">-->



<!--                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>-->



<!--                  </div>-->



<!--                  <h4 class="small font-weight-bold">Customer <span class="float-right"><?php echo $user; ?></span></h4>-->

<!--                    <div class="progress mb-4">-->



<!--                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>-->



<!--                  </div>-->



<!--                  <h4 class="small font-weight-bold">Drivers<span class="float-right"><?php echo $driver; ?></span></h4>-->

<!--                  <div class="progress mb-4">-->



<!--                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>-->



<!--                  </div>-->



<!--                  <h4 class="small font-weight-bold">Providers <span class="float-right"><?php echo $provider; ?></span></h4>-->



<!--                  <div class="progress mb-4">-->



<!--                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>-->



<!--                  </div>-->





<!--                  <h4 class="small font-weight-bold">Vendor <span class="float-right"><?php echo $vendor; ?></span></h4>-->

                  

<!--                  <div class="progress mb-4">-->

                    

<!--                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>-->



<!--                  </div>-->



         



<!--                </div>-->



<!--              </div>-->

<!--    </div>-->

          </div>







          <!-- Content Row -->



          <div class="row">







            <!-- Content Column -->



            <div class="col-lg-6 mb-4">







              <!-- Project Card Example -->









            </div>







            <div class="col-lg-6 mb-4">







              <!-- Illustrations -->



             <!--  <div class="card shadow mb-4">



                <div class="card-header py-3">



                  <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>



                </div>



                <div class="card-body">



                  <div class="text-center">



                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="">



                  </div>



                  <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>



                  <a target="_blank" rel="nofollow" href="">Browse Illustrations on unDraw &rarr;</a>



                </div>



              </div> -->

       <!-- Color System -->



         <!--      <div class="row">



                <div class="col-lg-6 mb-4">



                  <div class="card bg-primary text-white shadow">



                    <div class="card-body">



                      Primary



                      <div class="text-white-50 small">#4e73df</div>



                    </div>



                  </div>



                </div>



                <div class="col-lg-6 mb-4">



                  <div class="card bg-success text-white shadow">



                    <div class="card-body">



                      Success



                      <div class="text-white-50 small">#1cc88a</div>



                    </div>



                  </div>



                </div>



                <div class="col-lg-6 mb-4">



                  <div class="card bg-info text-white shadow">



                    <div class="card-body">



                      Info



                      <div class="text-white-50 small">#36b9cc</div>



                    </div>



                  </div>



                </div>



                <div class="col-lg-6 mb-4">



                  <div class="card bg-warning text-white shadow">



                    <div class="card-body">



                      Warning



                      <div class="text-white-50 small">#f6c23e</div>



                    </div>



                  </div>



                </div>



                <div class="col-lg-6 mb-4">



                  <div class="card bg-danger text-white shadow">



                    <div class="card-body">



                      Danger



                      <div class="text-white-50 small">#e74a3b</div>



                    </div>



                  </div>



                </div>



                <div class="col-lg-6 mb-4">



                  <div class="card bg-secondary text-white shadow">



                    <div class="card-body">



                      Secondary



                      <div class="text-white-50 small">#858796</div>



                    </div>



                  </div>



                </div>



              </div> -->





              <!-- Approach -->



           <!--    <div class="card shadow mb-4">



                <div class="card-header py-3">



                  <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>



                </div>



                <div class="card-body">



                  <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.</p>



                  <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.</p>



                </div>



              </div> -->







            </div>



          </div>







        </div>



        <!-- /.container-fluid -->







      </div>



      <!-- End of Main Content -->











