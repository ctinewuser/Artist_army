<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

               <?php echo $this->session->userdata('msg'); ?>    
          
            <div class="col-md-2 pl-0 mb-4 mt-3">
             <a href="<?= base_url('admin/add_genrecat'); ?>" class="btn btn-info pull-right "><i class="fa fa-plus mr-2"></i>Add</a>
            </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
  
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
             
                  <th>S.No.</th>
                  <th>Genre Name </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($cat)){ 

                foreach ($cat as $key => $value) { ?>
                  <tr>
                     <td><?= $key+1; ?></td>
                    <td>
                      <?= $value['genre_name']; ?>
                    </td>
                   
                    <td>   
              <a class="text-white" href="<?= base_url('admin/edit_genrecategory/'.$value['genre_id']); ?>"><button class="btn btn-warning btn-sm">Edit</button> </a>
              <a class="text-white"  onclick="delete_genrecategory(this,'<?php echo $value['genre_id'];?>')"> <button class="btn btn-danger btn-sm">Delete</button> </a>
                               <?php if($value['status']==1){?> 
                          <a href="<?= base_url('admin/approve_cat/'.$value['genre_id']); ?>" class="btn btn-success  btn-sm" title="Not Approve">Active</a>
                            <?php } else{ ?> 
                          <a href="<?= base_url('admin/disapprove_cat/'.$value['genre_id']); ?>" class="btn btn-danger  btn-sm" title="Approve">Deactive</a>
                            <?php }?>
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