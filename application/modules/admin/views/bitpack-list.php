<!--Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

               <?php echo $this->session->userdata('msg'); ?>    
          
            <div class="col-md-2 pl-0 mb-4 mt-3">
             <a href="<?= base_url('admin/add_bitpack'); ?>" class="btn btn-info pull-right "><i class="fa fa-plus mr-2"></i>Add</a>
            </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
  
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <!--<th>Name</th>-->
                  <th>S.No.</th>
                  <th>Bit Packs</th>
               <!--     <th>Bit Type</th> -->
                    <th>Bit Amount  </th>
                     <th>Euro Amount  </th>
                     <th>Created Date/Time</th>  
                 <th>Action</th> 
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($bit)){ 

                foreach ($bit as $key => $value) { ?>
                  <tr>
                                 <td><?= $key+1; ?></td>
                    <td>
                      <?= $value['bit_name']; ?>
                    </td>
                  <!--   <td>
                      <?= $value['type']; ?>
                    </td> -->
                    <td>
                      <?= $value['bit_amount_d']; ?>
                    </td>
                    <td>
                      <?= $value['euro_amount_d']; ?>
                    </td>

                      <td>
                      <?= date('d-M-Y',strtotime($value['created_at'])); ?>
                    </td> 
                   
                    <td>   
                   
             <a href="<?php echo base_url('admin/edit_bitpack/'.$value['id']); ?>"  class="btn btn-warning ml-0" title="" ><i class="fa fa-edit"></i></a>  

              <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_bit(this,'<?php echo $value['id'];?>')"><i class="fa fa-trash"></i></a>

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