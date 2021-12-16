
                  <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                      <h1 class="h3 mb-0 text-gray-800">Add Profile </h1>
                      
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                      <!-- Project Card Example -->
                      <div class="card shadow mb-4 col-md-12">
                        <div class="card-header">
                          <h5 class="pt-3 text-uppercase"><i class="fa fa-user-circle mr-1"></i> Personal Info</h5>
                        </div>
                        <div class="card-body">
                          <form method="POST" action="<?php if(!empty($admin)){ echo base_url('admin/edit_admin_profile');}else{echo base_url('admin/add_admin_profile');}?>" enctype="multipart/form-data">
                            
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="firstname">First Name</label>
                                  <input type="text" class="form-control" name="first_name" id="firstname" value="<?php echo $admin['first_name'];?>" placeholder="Enter first name">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="lastname">Last Name</label>
                                  <input type="text" class="form-control" value="<?php echo $admin['last_name'];?>" name="last_name" id="lastname" placeholder="Enter last name">
                                </div>
                                </div> <!-- end col -->
                                </div> <!-- end row -->
                                
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label for="userbio">Bio</label>
                                      <textarea class="form-control" name="bio" id="userbio" rows="4" placeholder="Write something..."><?php echo $admin['bio'];?></textarea>
                                    </div>
                                    </div> <!-- end col -->
                                    </div> <!-- end row -->
                                    
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="useremail">Email Address</label>
                                          <input type="email" name="email" class="form-control" id="useremail" placeholder="Enter email" value="<?php echo $admin['email'];?>">
                                          
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="userpassword">Password</label>
                                          <input type="password" class="form-control" name="password" id="userpassword"  placeholder="Enter password" value="<?php echo $admin['password'];?>">
                                         
                                        </div>
                                        </div> <!-- end col -->


                                        </div> <!-- end row -->
                                        <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="useremail">Location</label>
                                          <input type="text" name="location" class="form-control" id="useremail" placeholder="Enter Location" value="<?php echo $admin['location'];?>">
                                          
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="userpassword">Language</label>
                                          <input type="text" class="form-control" name="language" id="userpassword"  placeholder="Enter Language" value="<?php echo $admin['language'];?>">
                                          
                                        </div>
                                        </div> <!-- end col -->


                                        </div> <!-- end row -->
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="useremail">Mobile number</label>
                                          <input type="text" name="mobile_number" class="form-control" id="" placeholder="Enter Mobile number" value="<?php echo $admin['mobile_number'];?>">
                                          
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label for="userpassword">Image</label>
                                          <input type="file" class="form-control" name="image" id="">
                                          
                                        </div>
                                        </div> <!-- end col -->
                                        <div class="col-md-3">
                                        <div class="form-group">
                                      <!--  <img src="<?php echo base_url(); ?>/assets/userfile/profile/<?php echo $admin['image']; ?>" width="100" height="100"> -->
                                          
                                        </div>
                                        </div> 
        <!-- chandni -->                                <!-- end col -->
      <h3 class="font-weight-bold">Permissions</h3>
        <div class="col-md-12 mb-3 border shadow">
          <?php 
          foreach ($allroles as $value) { 
            $allrolesperm = getallrolespermission($value['role_id']);
            ?>
           <h5 class="font-weight-bold"><?php echo $value['role_name'];?></h5>
           <div class="row"> 
              <?php 
              if($allrolesperm!=false){
              foreach ($allrolesperm as $roledata) { ?>
                <div class="col-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permission_id[]" value="<?php echo $value['role_id']."-".$roledata['permission_id'];?>" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                      <?php echo $roledata['name'];?>
                    </label>
                  </div>              
                </div>
            <?php } }?>
          </div>
          <?php echo "<hr><br>";} ?>
        </div>

                                        </div> <!-- end row -->



                                            <div class="text-right">
                                                          <input  type="submit" name="submit" class="btn btn-success mt-2" value="Save">
                                                        </div>
                                        </form>
                                        </div>
                                      </div>
                          
                                                       
                                                    
                                                </div>
                                              </div>
                                              <!-- /.container-fluid -->
                                          