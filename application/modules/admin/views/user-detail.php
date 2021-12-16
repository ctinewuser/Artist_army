<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
<div class="card shadow mb-4">
            <div class="card-body">
<div class="table">
  
  <div class="row">
  	<div class="col-sm-12" style="background: #fff; padding-top: 35px;"><!--left col-->
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
    </div><!--/col-3-->
  	<div class="col-sm-12" style="background: #fff; padding-bottom: 35px">
      
            
      <div class="tab-content">
        <div class="tab-pane active" id="basic">
          <hr>
          <table class="table table-striped">
            <tr><?php if($user['user_type']==1) { ?>
              <th>Artist Name </th>
              <td><?= $user['artist_name']; ?></td>
              <?php } ?>
            </tr>
            <tr>
              <th>Country Code </th>
              <td><?= $user['country_code']; ?></td>
            </tr>
            <tr>
              <th>Mobile</th>
              <td><?= $user['mobile_number']; ?></td>
            </tr>
            <tr>
              <th>Date Of Birth</th>
              <td><?= $user['date_of_birth']; ?></td>
            </tr>
            <tr>
              <th>Address</th>
              <td><?= $user['address']; ?></td>
            </tr> 
             <tr>
              <th>Spotify</th>
              <td><?= $user['spotify']; ?></td>
            </tr>
             <tr>
              <th>YouTube</th>
              <td><?= $user['youtube']; ?></td>
            </tr>
             <tr>
              <th>Instagram</th>
              <td><?= $user['instagram']; ?></td>
            </tr>
             <tr>
              <th>Facebook</th>
              <td><?= $user['facebook']; ?></td>
            </tr>
            <tr><?php if($user['user_type']==1) { ?>
              <th>Genre Category</th>
              <td>

               <?= gen_category($user['genre_cat']);?> 
               </td>
               <?php } ?>
            </tr>

             <tr>
              <th>Biography</th>
              <td><?= $user['biography']; ?></td>
            </tr>   
            <?php if($title=="Driver Profile" || $title=="Provider Profile"){?>
            <tr>
              <th>Checker Status</th>
              <td><?= $user['checker_status']; ?></td>
            </tr>
            
            <!-- <tr> 
              <th>Longitude</th>
              <td><?= $user['user_longitude']; ?></td>
            </tr>
            <tr>
              <th>Address</th>
              <td><?= $user['address']; ?></td>
            </tr>    -->
            <?php } ?>

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