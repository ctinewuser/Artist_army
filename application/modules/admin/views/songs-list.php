        <!-- Begin Page Content -->
        <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

        <?php echo $this->session->userdata('msg'); ?>    

        <div class="col-md-2 pl-0 mb-4 mt-3">
        <a href="<?php echo base_url('admin/uploadfolder')?>" id="" class="btn btn-success"><i class="plus"></i> Upload Images</a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

        <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>

         <th>S.No</th>
              <th>Song Name</th>
              <th>Singer Name</th>
             
              <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php 
          if (!empty($songs)){ 
           foreach ($songs as $key => $value) { ?>
            <tr>
               <td><?=  $key+1; ?></td>
                <td><?= $value['song_name']; ?></td>
                <td>
                     <?= $value['singer_name']; ?>
                </td>
                <td>
             <a href="<?= base_url('admin//'.$value['id'].'/'.'0'); ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="btn btn-danger" title="delete"><i class="fa fa-trash"></i></a> 
                </td>
            </tr>
          <?php } } ?>
        </tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
