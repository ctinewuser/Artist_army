<?php  if(!isset($_GET['token'])){ ?>
<div class="container stickyfooter sky-blue">
    <div class="row py-5">
      <div class="col-md-6 mx-auto my-5 boxclass py-5">
          <?= $this->session->flashdata('msg'); ?>  
      	<form class="form-signin py-5 register" method="post" action="<?= base_url('home/forgetPassword'); ?>">
        
          <!-- <h1 class="h3 mb-1 font-weight-bold text-center color01">Forgot Password</h1> -->
          <h4 class="text-center mb-4">Forgot Password ?</h4>

          <div class="cnt-block border rounded bg-white">
           <label for="inputEmail" class="sr-only ">Email</label>
          <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Please enter your registered email address" autofocus>
          <input name="user_type"  type="hidden" class="user_type" placeholder="First Name" value="<?php echo $user_type;?>">
         <?php echo form_error('email', '<span for="email" generated="true" class="error_msg">', '</span>'); ?>            
          <button class="btn btn-lg btn-transparent btn-block bg01 text-white mt-3" type="submit">SUBMIT</button>
        </div>
        </form>
       </div>
    </div>
</div>
<?php } ?>
<?php if(isset($_GET['token'])){ 
    $user_type=$_GET['user_type'];
?>
<div class="container stickyfooter sky-blue">
    <div class="row py-5">
         
      <div class="col-md-6 mx-auto my-5 boxclass py-5">
         <?= $this->session->flashdata('msg'); ?>  
        <form class="form-signin py-5 register" method="post"  action="<?= base_url('home/resetPassword?token='.$_GET['token']); ?>">
         
          <h4 class="text-center mb-4">Reset Password</h4>
          <div class="cnt-block border rounded bg-white">
            <p class="my-3 text-muted text-center">Enter your New Password</p>
            <label for="inputEmail" class="sr-only">New Password</label>
            <input type="password" name="password" id="inputEmail" class="form-control" placeholder="New Password"  autofocus>
            <?php echo form_error('password', '<span for="password" generated="true" class="error_msg">', '</span>'); ?>  
            <input name="user_type"  type="hidden" class="user_type" placeholder="First Name" value="<?php echo $user_type;?>">
            <label for="inputEmail" class="sr-only">Confirm Password</label>
            <input type="password" name="confPassword" id="inputEmail" class="form-control mt-3" placeholder="Confirm Password"  autofocus>
            <?php echo form_error('confPassword', '<span for="confPassword" generated="true" class="error_msg">', '</span>'); ?>  

            <button class="btn btn-lg btn-transparent btn-block bg01 text-white mt-3" type="submit">SUBMIT</button>
          </div>
        </form>
       </div>
    </div>
</div>
<?php } ?>