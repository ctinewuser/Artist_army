<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->

  <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">

  <div class="card-body">
          <div class="table-responsive">

            <a href="<?php echo base_url()?>admin/show_pinboard" class="btn btn-info mb-3">Back</a>
            
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                   <th>S.NO.</th>
                  <th>Created By </th>
                   <th>Post Type</th>
                    <th>Description</th>
                    <th>Comments</th>
                 <th>Likes</th>
                <th> Created Time/Date</th>
                    
                      <th>Action</th> 
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($postlist)){ 

                foreach ($postlist as $key => $value) { ?>
                  <tr>
                     <td><?= $key+1; ?></td>
                    <td>
                      <?= user_full_name($value['user_id']); ?>
                    </td>
                    <td>
                      <?= $value['post_type']; ?>
                    </td>
                    <td>
                      <?= $value['description']; ?>
                    </td>
                    <td>
                      <?= $value['total_comment']; ?>
                    </td>
                     <td>
                      <?= $value['total_like']; ?>
                    </td>
                     <td>
                      <?= $value['created_at']; ?>
                    </td>
                 
                    <td>   
                <a href="<?= base_url('admin/showImage/'.$value['id']); ?>" class="btn btn-success" target="_blank"><i class="plus"></i>View Image</a>

             <!--  <a href="<?= base_url('admin/delete_concert/'.$value['concert_id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="btn btn-danger" title="delete"><i class="fa fa-trash"></i></a> -->

            </td> 
                    </tr>
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
