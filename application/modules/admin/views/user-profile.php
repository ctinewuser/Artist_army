<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User Profile Edit</h1>
  </div>
  <!-- Content Row -->
  <div class="row">
    <!-- Project Card Example -->
    <div class="card shadow mb-4 col-md-12">
      <div class="card-header">
        <h5 class="pt-3 text-uppercase"><i class="fa fa-user-circle mr-1"></i> Personal User Info</h5>
      </div>
      <div class="card-body">

          <form method="POST" action="<?php if(!empty($admin)){ echo base_url('admin/edit_admin_profile/'.$admin['id']);}else{echo base_url('admin/add_admin_profile');}?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" name="first_name" id="firstname" value="<?php echo $admin['first_name'];?>" placeholder="Enter first name" required>
                 <?php echo form_error('first_name', '<span for="first_name" generated="true" class="error_msg">', '</span>'); ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" value="<?php echo $admin['last_name'];?>" name="last_name" id="lastname" placeholder="Enter last name" required>
                 <?php echo form_error('last_name', '<span for="last_name" generated="true" class="error_msg">', '</span>'); ?>
              </div>
              </div> <!-- end col -->
              </div> <!-- end row -->
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="userbio">Bio</label>
                    <textarea class="form-control" name="bio" id="userbio" rows="4" placeholder="Write something..." required><?php echo $admin['bio'];?></textarea>
                  </div>
                  </div> <!-- end col -->
                  </div> <!-- end row -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="useremail">Email Address</label>
                        <input type="email" name="email" class="form-control" id="useremail" placeholder="Enter email" value="<?php echo $admin['email'];?>" maxlength="30" required>
                         <?php echo form_error('email', '<span for="email" generated="true" class="error_msg">', '</span>'); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="userpassword">Password</label>
                        <input type="password" class="form-control" name="password" id="userpassword"  placeholder="Enter password" value="" >
                         <?php echo form_error('password', '<span for="password" generated="true" class="error_msg">', '</span>'); ?>
                      </div>
                      </div> <!-- end col -->
                      </div> <!-- end row -->
                      <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="useremail">Location</label>
                        <input type="text" name="location" class="form-control" id="useremail" placeholder="Enter Location" value="<?php echo $admin['location'];?>" required>
                      </div>
                    </div>
                  <!--   <div class="col-md-6">
                      <div class="form-group">
                        <label for="userpassword">Language</label>
                 
                              <select name="language" id="userpassword" class="form-control" >
                          <option value=""  >Select your language</option> 
                           <option value="English" <?php if($admin['language']=="English") echo "selected='selected'"; ?> >English</option>
                          <option value="Hindi" <?php if($admin['language']=="Hindi") echo "selected='selected'"; ?>>Hindi</option>
                          </select>

                      </div>
                      </div>  -->
                      
                         <div class="col-md-3">
                      <div class="form-group">
                        <label for="useremail">Country code</label>
                            <select   name="country_code"  class=" form-control" data-flag="true"  id="country_code">
                               <?php 
                               $sql   = "SELECT * from country";
                                $query = $this->db->query($sql);
                                if($query->num_rows() > 0) {
                                    $row = $query->result_array();


                                     foreach ($row as $key => $value) { 

                                       // if($value['phonecode'] == "1"){
                                       //   $s = 'selected="selected"';
                                       // }else{
                                       //  $s = "";
                                       // }
                                      ?>

                                       <option  value="<?php echo $value['id'];?>" class="mr-1"><?php echo $value['nicename'];?></option>
                                    <?php } }?>
                            </select> 
                        </div>
                      </div> 

                      <div class="col-md-3">
                      <div class="form-group">
                        <label for="useremail">Mobile number</label>
                                  
                        <input type="text" name="mobile_number" class="form-control" id="" placeholder="Enter Mobile number" value="<?php echo $admin['mobile_number'];?>" maxlength="10" required>
                        
                      </div>
                    </div>

                      </div> <!-- end row -->


                  <div class="row">
                 

                    
                    <?php if(!empty($admin['image'])){?>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="userpassword">Image</label>
                        <input type="file" class="form-control" name="image" id="" >
                        
                      </div>
                      </div> <!-- end col -->
                      <?php } else{?>  
                          <div class="col-md-3">
                      <div class="form-group">
                        <label for="userpassword">Image</label>
                        <input type="file" class="form-control" name="image" id="" required>
                        
                      </div>
                      </div> <!-- end col -->
                       <?php } ?>  
                      <?php if(!empty($admin['image'])){?>
                          <div class="col-md-3">
                            <div class="form-group">
                           <img src="<?php echo base_url(); ?>/assets/userfile/profile/<?php echo $admin['image']; ?>" width="100" height="100">
                                                
                            </div>
                          </div> <!-- end col -->
                       <?php } ?>   
                   </div> <!-- end row -->


     <div class="text-right">
            <?php if(!empty($admin)){ ?>
                <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                <input type="submit" name="submit" value="Edit" class="btn btn-success mt-2">
                <?php } else { ?>
                <input type="submit" name="submit" value="Save" class="btn btn-success mt-2">
                <?php } ?>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>
                                <!-- /.container-fluid -->
                            