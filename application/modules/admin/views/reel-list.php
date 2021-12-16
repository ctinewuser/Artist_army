        <!--Begin Page Content -->
        <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
        <div class="card shadow mb-4">

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                  <th>S.No.</th>
                  <th>User Name</th>
                  <th>Decription</th>
                  <th>Total Comment</th>
                  <th>Total Like</th>
                  <th>Total Favourite</th>
                  <th>Image</th>  
                  <th style="min-width: 80px;">Created Date/Time</th> 
                  <th>Action</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($reel)){ 
                  foreach ($reel as $key => $value) { ?>
                    <tr>
                       <td><?= $key+1; ?></td>
                      <td>
                        <?= user_full_name($value['user_id']); ?>
                      </td>
                      <td>
                        <?= $value['reel_description']; ?>
                      </td>
                     <td>
                        <?= $value['total_comment']; ?>
                      </td>
                       <td>
                        <?= $value['total_like']; ?>
                      </td>
                       <td>
                        <?= $value['total_star']; ?>
                      </td>
                       
                   <td>  
                  
                       <img src="<?php echo base_url('/assets/reels/'); ?><?php echo $value['reel_image']; ?>" alt="" class="img-thumbnail"> 
                      
                  </td>  
                  <td>
                          <?= date('d-M-Y',strtotime($value['created_at'])); ?>
                        </td> 
                  <td>  
                    <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_reel(this,'<?php echo $value['id'];?>')"><i class="fa fa-trash"></i></a>
                  </td>
                        </tr>
                  <div id="test<?php echo $value['id']; ?>" class="modal fade">
                  <div class="modal-dialog">
                  <div class="modal-content">
                  <div class="modal-header">
                  <h4 class="modal-title">Play Reels </h4>
                  <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                  <iframe id="test2" width="450" height="350"
                        src ="<?php echo base_url('/assets/reels/').$value['reel_video']; ?>?autoplay=1"
                        frameborder="0" allowfullscreen>
                  </iframe>
                        </div>
                    </div>
                  </div>
                  </div>
                  </div>
                      <?php }

                  } ?>
                  </tbody>
                  </table>
                  </div>
                  </div>
                  </div>
                  </div>
                  <!-- /.container-fluid -->
                  </div>
                  <!-- End of Main Content -->

                  <script type="text/javascript">
                  function delete_reel(t,id){

                  if (confirm('Are you sure you want to delete this Reel?')) {
                  $.ajax({
                  type: "POST",     
                  url:"<?php echo base_url('admin/delete_reelist');?>",
                  data:{id:id},
                  success: function(data){

                    if(data){
                        $(t).closest('tr').remove();
                      
                    }else{
                        alert('failure');
                    }
                  }
                  });
                  }
                  else
                  { 
                  return false;
                  }
                  }
                  </script>
       