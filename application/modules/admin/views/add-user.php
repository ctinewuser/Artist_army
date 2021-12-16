


<div class="container-fluid">

          <!-- Page Heading -->

          <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

          <!-- DataTales Example -->

          <div class="card shadow mb-4">

            <div class="card-body">

<div class="col-md-12"> 

        <div class="alertfailurfile"></div>

    <?php echo $this->session->userdata('msg'); ?> 

<form class="form-horizontal" method="post"  action="<?php if(!empty($user)){ echo site_url('admin/edit_user/'.$this->uri->segment(3));}else{

          echo  base_url('admin/add_user/');

        } ?>"  enctype="multipart/form-data" >

        <h3 class="text-center"><?= $title; ?></h3><br>
         <div class="form-group">

          <label class="col-sm-2 control-label"> Fan Name</label>

          <div class="col-sm-8">

            <input type="text" name="full_name"  class="form-control"  placeholder="user name" 

            value="<?php if(!empty($user)){ echo $user['full_name']; } ?>"

            > 
         <p><?php echo form_error('full_name', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>
       <!--Date of Birth Add-->
          <div class="form-group">

          <label class="col-sm-2 control-label">Date Of Birth</label>

          <div class="col-sm-8">

           <?php 
              if(!empty($user['date_of_birth'])){
              $date = date('d-m-Y',strtotime($user['date_of_birth']));
              }else{
                $date = "";
              }
            ?>
               <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">

            <input type="text" name="date_of_birth"  class="form-control"  placeholder="date of birth" value="<?php echo $date; ?>"> 
             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>

             <p><?php echo form_error('date_of_birth', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div> 
         <!---->
         
         
          <div class="form-group">

          <label class="col-sm-2 control-label">Country Code</label>

          <div class="col-sm-8">

            <input type="text" name="country_code"  class="form-control"  placeholder="country code" 

            value="<?php if(!empty($user)){ echo $user['country_code']; } ?>"

            > 
         <p><?php echo form_error('country_code', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>
        <div class="form-group">

          <label class="col-sm-2 control-label">Mobile No.</label>

          <div class="col-sm-8">
            <input type="text" name="mobile_number"  class="form-control"  placeholder="mobile number" 

            value="<?php if(!empty($user)){ echo $user['mobile_number']; } ?>"
            > 
         <p><?php echo form_error('mobile_number', '<span class="error_msg">', '</span>'); ?></p> 

          </div>


        </div>

       
              <div class="form-group">

          <label class="col-sm-2 control-label">Password</label>

          <div class="col-sm-8">

            <input type="password" name="password"  class="form-control"  placeholder="Enter password" 

            value=""

            > 
         <p><?php echo form_error('password', '<span for="password" generated="true" class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>

         <div class="form-group">

          <label class="col-sm-2 control-label">Address</label>

          <div class="col-sm-8">

            <input type="text" name="address"  class="form-control"  placeholder="address" 

            value="<?php if(!empty($user)){ echo $user['address']; } ?>"

            > 
         <p><?php echo form_error('address', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>

        <!--   <div class="form-group">
          <label class="col-sm-2 control-label">Fan Name</label>
          <div class="col-sm-8">
            <input type="text" name="full_name"  class="form-control"  placeholder="Enter Fan Name" 
            value="<?php if(!empty($user)){ echo $user['full_name']; } ?>"
            > 
         <p><?php echo form_error('full_name', '<span class="error_msg">', '</span>'); ?></p>  -->

       <!--  <select id="select_user"  name="user_type" class="form-control">
           <option <?php if(!empty($user['user_type'] =="0")){ echo 'selected="selected"'; } ?> value="0">Fan</option>
           <option <?php if(!empty($user['user_type'] =="1")){ echo 'selected="selected"'; } ?> value="1">Artist</option>
        </select> -->
         <!-- </div>
        </div> -->
<!-- 

    <?php 
        $style = "";
      if($user['user_type']=="1"){

          $style = "display: block;";
        }else{
          $style = "display: none;";
        }
      ?>
 -->
     <!--  <div class="artistclass"> 

            <div class="form-group">

            <label class="col-sm-2 control-label">Artist Name</label>

            <div class="col-sm-8">

            <input type="text" name="artist_name"  class="form-control"  placeholder="artist name" 

            value="<?php if(!empty($user)){ echo $user['artist_name']; } ?>"

            > 
            <p><?php echo form_error('artist_name', '<span class="error_msg">', '</span>'); ?></p> 

            </div>

            </div> 

            <div class="form-group">

            <label class="col-sm-2 control-label">Genre Category</label>

            <div class="col-sm-8">

            <input type="text" name="genre_cat"  class="form-control"  placeholder="genre cat" 

            value="<?php if(!empty($user)){ echo $user['genre_cat']; } ?>"

            > 
            <p><?php echo form_error('genre_cat', '<span class="error_msg">', '</span>'); ?></p> 

            </div>

            </div>                    

         </div>-->

            <div class="form-group">

            <label class="col-sm-2 control-label">Biography</label>

            <div class="col-sm-8">
          <textarea name="biography"  class="form-control"  placeholder="biography" 

            value="<?php if(!empty($user)){ echo $user['biography']; } ?>"

            ><?php if(!empty($user)){ echo $user['biography']; } ?> </textarea>
          
            </div>

            </div> 

        <div class="col-sm-offset-2">
          <?php if(!empty($user)){ ?>
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <input type="submit" name="submit" value="Update" class="btn btn-success">
                <?php } else { ?>
                <input type="submit" name="submit" value="Add" class="btn btn-success">
                <?php } ?>
            </div>
      </form>
     </div>
    </div>
        </div>

        </div>







