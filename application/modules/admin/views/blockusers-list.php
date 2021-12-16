<!--Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

               <?php echo $this->session->userdata('msg'); ?>    
      
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
  
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>  
                  <th>S.No.</th>
                  <th>Blocked By</th>
                 <th>Blocked To</th> 
                   <th>Action</th>      
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($report)){ 
                foreach ($report as $key => $value) { ?>
                  <tr>
                    <td><?= $key+1; ?></td>
                    <td>
                      <?= user_full_name($value['user_id']); ?>
                    </td>
                    <td>
                      <?= user_full_name($value['block_id']); ?>
                    </td>
                     <td>
                          <a href="<?= base_url('admin/unblock_report_user/'.$value['id'].'/'.$value['artist_report']); ?>" class="btn btn-danger" title="Unblock">Unblock</a>    
                        
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
