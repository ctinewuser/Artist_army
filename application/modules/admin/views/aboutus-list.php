<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
<div class="card shadow mb-4">
            <div class="card-body">
<div class="table">
  
  <div class="row">
    <!-- <div class="col-sm-12" style="background: #fff; padding-top: 35px;">left col
      <div class="text-center">
        <?php if($user['profile_image']){
          $image = base_url('assets/userfile/profile/').$user['profile_image'];
        }else{
          $image = base_url('assets/userfile/profile/dummy.png');
        } ?>
         <img style="width: 140px; height:140px; object-fit: cover;" src="<?= $image; ?>" class="avatar img-circle img-thumbnail" alt="avatar">    
      </div>
      <div class="text-center">
        <?= $user['full_name']; ?>
      </div>
      <hr><br>
             
      <h3 class="panel-heading">Email :
        <span><?= $user['email']; ?></span>
      </h3>
    </div>/col-3-->
    <div class="col-sm-12">
      
            
      <div class="tab-content">
        <div class="tab-pane active" id="basic">
          <hr>
          <table class="table table-striped">
         
            
             <tr>
              <th>About</th>
              <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. </td>
            </tr> 
             
           
          </table>                  
          <hr>          
        </div>
       
        <div class="tab-pane" id="upload">
          <hr>
          <div class="row">
            <div class="col-md-6">
              <?php if ($user['driving_license_image']) {  ?>
                <h3>Government Id</h3>
                <img src="<?= base_url('assets/userfile/profile/'.$user['driving_license_image']); ?>" style="width:50%">
              <?php } ?>
            </div>
            <div class="col-md-6">
              <?php if ($user['passport_image']) {  ?>
                <h3>Certificate </h3>
                <img src="<?= base_url('assets/userfile/profile/'.$user['passport_image']); ?>" style="width:50%">
              <?php } ?>
            </div>
          </div>       
        </div>
      </div>
      <?php if($user['user_type'] == 'Provider' || $user['user_type'] == 'Driver'){ ?>
      <!--   <a href="<?= base_url('admin/provderServices/'.$user['id']); ?>" class="btn btn-success user-request">My Services</a> -->
           <a href="<?= base_url('admin/paymentHistory_provider_year/'.$user['id'].'?type=1'); ?>" class="btn btn-warning user-pym-hist">Payment History</a>

            <a href="<?= base_url('admin/ongoing_services/'.$user['id']); ?>" class="btn btn-warning user-pym-hist">Ongoing Services</a>
      
      
       
        <?php }else{ ?>
        
         <!-- <a href="<?= base_url('admin/userRequest/'.$user['id']); ?>" class="btn btn-success user-request">Requested Service</a>  
        <a href="<?= base_url('admin/paymentHistory/'.$user['id'].'?type=0'); ?>" class="btn btn-warning user-pym-hist">Payment History</a>   -->
        
        
        
        <?php } ?>

<!--
         <a href="<?= base_url('admin/send_single_mail/'.$user['id']); ?>" class="btn btn-warning user-pym-hist">Send mail</a>-->
    </div><!--/col-9-->
  </div>
</div>
</div>
</div>
</div>
<script>
    
    
    
    
    
</script>