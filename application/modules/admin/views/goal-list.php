<!-- Begin Page Content -->
<style type="text/css">
  .img-wrap {
    width: 50px;
    height: 50px;
    margin: 0 auto;
}

.img-wrap img {
    width: 100%;
    height: 100%;
}
</style>
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
  
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Credit By</th>
                  <th>Goal Name</th>
                  <th>Amount</th>
                  <th style="min-width: 80px;">Exp Date</th>
                  <th>Exp Time</th>
                  <th>Description</th>
                  <th>Created Date/Time</th>
                  <th>Redeem Members</th>
                   <th>Action</th> 
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($goal)){ 
                foreach ($goal as $key => $value) { ?>
                  <tr>
                        <td><?= $key+1; ?></td>
                    <td>
                      <?= user_full_name($value['user_id']); ?>
                    </td>
                    <td>
                      <?= $value['goal_name']; ?>
                    </td>
                    <td>
                      <?= '$'.$value['amount']; ?>
                    </td>
                    <td>
                      <?= $value['exp_date']; ?>
                    </td>
                <td>
                      <?= $value['exp_time']; ?>
                    </td>
                    <td>
                      <?= $value['description']; ?>
                    </td>
                    
                    <td>
                      <?= $value['created_at']; ?>
                    </td>
                    
                     <td>
                      <?php if(!empty($value['redeem_members'])){ ?>
                     <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal<?php echo $value['id']; ?>">See User</button>
                    
                  <?php }else{ ?>

                  <button type="button" class="btn btn-danger  btn-sm">No User</button>  

                <?php } ?>
              </td>
                 <td>
                 <a href="<?= base_url('admin/delete_goal/'.$value['id'].'/'.'0'); ?>" onclick="return confirm('Are you sure you want to delete this goal?');" class="btn btn-danger" title="delete"><i class="fa fa-trash"></i></a>
            </td>
                                  <!-- Modal -->

  <div class="modal fade" id="myModal<?php echo $value['id']; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Redeem Users</h4>
           <button type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <?php
         if(!empty($value['redeem_members']))
         {
          $profile_image = "";
          $test = explode(",", $value['redeem_members']);
          foreach ($test as $key => $value) {
              $userdetail = user_detail($value);
              if($userdetail['profile_image']){
                $profile_image = $userdetail['profile_image'];
              }else{
                  $profile_image = "dummy.png";
              }

            ?>
           
            <div class="row border-bottom pb-2 mb-2">
            <div class="col-lg-2">
              <div class="img-wrap">
                <img src="<?php echo base_url('/assets/userfile/profile/'); ?><?php echo $profile_image; ?>" alt="" class="rounded-circle img-thumbnail"> 
                </div>  


              </div>
              <div class="col-lg-10 d-flex align-items-center"><h6 class="text-dark m-0"><?php echo user_full_name($value); ?> </h6></div>
            </div>
            <?php }
           }
            ?>
          </div>
          </div>
          </div>
          </div>
                    </tr>

                  <?php }

            } ?>

         
              </tbody>
            </table>
            <!--Try Modal Code here-->

  
            <!--End-->
          </div>
        </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
  