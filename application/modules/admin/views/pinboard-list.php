<!-- Begin Page Content -->
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
                  <th>Post Id  </th>
                   <th>User Name</th>
                     
                     
               <th>Action</th> 
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($pin)){ 

                foreach ($pin as $key => $value) { ?>
                  <tr>
                                 <td><?= $key+1; ?></td>
                    <td>
                      <?= $value['post_id']; ?>
                    </td>
                    <td>
                      <?= user_full_name($value['user_id']); ?>
                    </td>
                     
                   <td>
                     <a href="<?= base_url('admin/show_postlist/'.$value['user_id']); ?>" class="btn btn-success" target="_blank"><i class="plus"></i>View Post</a>
                    
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

<script type="text/javascript">
  function delete_genrecategory(t,id){

    if (confirm('Are you sure you want to delete this Category ?')) {
        $.ajax({
            type: "POST",     
            url:"<?php echo base_url('admin/delete_gencategory');?>",
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