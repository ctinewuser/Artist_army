<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 page-title"><?= $title; ?></h1>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="col-md-12">
        <div class="alertfailurfile"></div>
        <?php echo $this->session->userdata('msg'); ?>
          <form class="form-horizontal" method="post" action="<?php echo base_url('admin/uploadfolder_songs')?>" enctype="multipart/form-data" autocomplete="off">
            <h5 class="pt-3 text-theme">Upload Images</h5>
            <br>
          
            <div class="form-group">
              
                  <div class="dropzone" id="my-dropzone" name="mainFileUploader">
                      <div class="fallback">
                          <input name="file" type="file"  multiple />
                      </div>
                  </div>
                   <p><?php echo form_error('file', '<span class="error_msg">', '</span>'); ?></p>
             </div>
             </form>
          
              <div class="col-sm-offset-2">
                
                    
              <input type="submit" id="submit-all" value="Upload" class="btn btn-success">
                    
                    
            </div>
          
      </div>
    </div>
  </div>
</div>
