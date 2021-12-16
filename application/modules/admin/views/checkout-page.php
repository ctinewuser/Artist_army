
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
                  <th>Goal Name</th>
                        <th>Redeem Members</th>
                     <th>Email</th>
                     <th>Full name</th>
                    <th>Phone Number</th>
                     <th>Country</th>
                     <th>Address</th>
                       <th>City</th>
                     <th>State</th>
                     <th>Post Code</th>  
                       <th>Created Date/Time</th>  
               <!--   <th>Action</th>  -->
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($check)){ 

                foreach ($check as $key => $value) { ?>
                  <tr>
                                 <td><?= $key+1; ?></td>
                                  <td>
                      <?php
                        if(goal_name($value['goal_id']) != false){
                          echo goal_name($value['goal_id']);
                        }else{
                          echo "";
                        }
                        ?>
                    </td>
                                  <td>
                      <?php
                        if(user_full_name($value['user_id']) != false){
                          echo user_full_name($value['user_id']);
                        }else{
                          echo "";
                        }
                        ?>              
                   
                    </td>
                  
                     <td>
                      <?= $value['email']; ?>
                    </td>
                    <td>
                      <?= $value['full_name']; ?>
                    </td>
                   
                    <td>
                      <?= $value['phone_number']; ?>
                    </td>
                    <td>
                      <?= $value['country']; ?>
                    </td>

                      <td>
                      <?= $value['address1']; ?>
                    </td> 
                      <td>
                      <?= $value['city']; ?>
                    </td>
                      <td>
                      <?= $value['state']; ?>
                    </td>
                      <td>
                      <?= $value['postcode']; ?>
                    </td>
                      <td>
                      <?= $value['created_at']; ?>
                    </td>
                   <!-- 
                    <td>   
                   

              <a href="<?php echo base_url('admin/edit_bitpack/'.$value['id']); ?>"  class="btn btn-warning ml-0" title="" ><i class="fa fa-edit"></i></a>  

              <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_bit(this,'<?php echo $value['id'];?>')"><i class="fa fa-trash"></i></a>

            </td>  -->
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
<!-- 
<script type="text/javascript">
  function delete_bit(t,id){

    if (confirm('Are you sure you want to delete this Pack ?')) {
        $.ajax({
            type: "POST",     
            url:"<?php echo base_url('admin/delete_bitpack');?>",
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