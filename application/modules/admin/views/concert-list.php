<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
   <?php echo $this->session->userdata('msg'); ?>    
          
            <div class="col-md-2 pl-0 mb-4 mt-3">
             <a href="<?= base_url('admin/add_concert'); ?>" class="btn btn-info pull-right "><i class="fa fa-plus mr-2"></i>Add</a>
            </div> 
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
  <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                   <th>S.No.</th>
                  <!-- <th>Artist Name </th> -->
                   <th>Ttitle</th>
                    <th>Concert Venue</th>
                     <th>Date</th>
                      <th>Time</th>   
                      <th style="width: 80px;">Action</th> 
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($concert)){ 

                foreach ($concert as $key => $value) { ?>
                  <tr>
                      <td><?= $key+1; ?></td>
                   <!--  <td>
                      <?= user_full_name($value['user_id']); ?>
                    </td> -->
                    <td>
                      <?= $value['concert_title']; ?>
                    </td>
                    <td>
                      <?= $value['concert_venue']; ?>
                    </td>
                    <td>
                      <?= $value['concert_date']; ?>
                    </td>
                     <td>
                      <?= $value['concert_time']; ?>
                    </td>
                   
                    <td>   
                      

                <a href="<?php echo base_url('admin/edit_concert/'.$value['concert_id']); ?>"  class="btn btn-warning ml-0" title="" ><i class="fa fa-edit"></i></a>  

              <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_concertdata(this,'<?php echo $value['concert_id'];?>')"><i class="fa fa-trash"></i></a>

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
  function delete_concertdata(t,id){

    if (confirm('Are you sure you want to delete this Concert ?')) {
        $.ajax({
            type: "POST",     
            url:"<?php echo base_url('admin/delete_concert');?>",
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