     <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-10">
              <h1 class="h3 mb-2 text-gray-800 pt-2"> <?= $title; ?>
             
              </h1>
               <?php echo $this->session->userdata('msg'); ?>    
            </div>
            <div class="col-md-2">
             <a href="<?= base_url('admin/addMenCategory'); ?>" class="btn btn-primary pull-right "><i class="fa fa-plus mr-2"></i>Add</a>
            </div>
           </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                  
                  
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>S.No.</th>
          <th>Service Name</th>      
          <th>Service Price</th>      
          <th>Service Image</th>      
          <th>Action</th>     
                    </tr>
                  </thead>
         <!--          <tfoot>
                    <tr>
                      <th>S.No.</th>
          <th>Service Name</th>      
          <th>Service Price</th>      
          <th>Service Image</th>      
          <th>Action</th>     
                    </tr>
                  </tfoot> -->
                  <tbody>
             <?php if(!empty($category)){
          foreach ($category as $key => $value) {  ?>
            <tr>
              <td><?= $key+1; ?></td>
              <td><?= $value['service_offer_subcategory_name']; ?></td>
              <td><?= $value['sevice_price']; ?></td>
              <td><img src="<?php echo base_url();?>/assets/userfile/category/<?= $value['service_offer_subcategory_image']; ?>" width="100px" height="100px"></td>
              <td>
                 <button class="btn btn-info"><a class="text-white" href="<?= base_url('admin/deleteMenCategory/'.$value['service_offer_subcategory_id']); ?>">Delete</a></button>

              <button class="btn btn-warning"><a class="text-white" href="<?= base_url('admin/editMenCategory/'.$value['service_offer_subcategory_id']); ?>">Edit</a></button>

              <?php if($value['user_type']=='user'){?>
              <button class="btn btn-info"><a class="text-white" href="<?= base_url('admin/elite_mensservice/'.$value['service_offer_subcategory_id']); ?>">Make Elite</a></button>
            <?php }else{?>
               <button class="btn btn-primary"><a class="text-white" href="<?= base_url('admin/user_mensservice/'.$value['service_offer_subcategory_id']); ?>">Elite</a></button>
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

