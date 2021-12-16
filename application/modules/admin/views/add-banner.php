

<div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Add Man Banner</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
<div class="col-md-12">	
        <div class="alertfailurfile"></div>
    <?php echo $this->session->userdata('msg'); ?> 
    <form class="form-horizontal" method="post" action="<?php if(!empty($category)){ echo site_url('admin/editBanner');}else{
          echo  base_url('admin/addBanner');
        } ?>" enctype='multipart/form-data'>
      <fieldset>
      
        <div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Banner</label>
          <div class="col-lg-10">
            <input type="text" class="form-control" name="banner_name" placeholder="Banner" <?php if(!empty($category)) echo 'value="'.$category['banner_name'].'"'; ?> required>
                  <input type="hidden" class="form-control" name="service_offer_category_id" placeholder="Service" <?php if(!empty($category)){ echo 'value="'.$category['service_offer_category_id'].'"';}else{echo 'value="1"';} ?> required>
          </div>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword" class="col-lg-2 control-label">Image</label>
          <div class="col-lg-10">
            <input type="file" id="i_file" class="form-control" name="image">        
          </div>
        </div> 
         <?php echo form_error('file','<p class="help-block">','</p>'); ?>
                 <?php if(!empty($category['image'])){?>
        <div class="form-group">
          <label for="inputPassword" class="col-lg-2 control-label">Image</label>
          <div class="col-lg-10">
           <img src="<?php echo base_url(); ?>assets/userfile/category/<?= $category['image']; ?>" width="100px" height="100px">
          </div>
        </div> 
       <?php }?>
       
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
           <?php if(!empty($category)){ ?>
  <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                <input type="submit" name="submit" value="Edit" class="btn btn-success">
                <?php } else { ?>
                <input type="submit" name="submit" value="Add" class="btn btn-success">
                <?php } ?>
          </div>
        </div>
      </fieldset>
    </form>
</div>
</div>
        </div>
        </div>
<script>
    
    document.getElementById("i_file").addEventListener("change", function () {
    var file = this.files[0];

    if (file) {
        var mbSize = file.size / 1024 / 1024;
        var fileIsMp4 = (file.type === "video/mp4");

        if (mbSize > 1 || fileIsMp4) {
            $('#i_file').val('');
            $('.alertfailurfile').html('<div class="alert alert-danger alert-dismissible" role="alert">Please select only gif/jpeg/jpg/png file.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            //alert("failure");
        } else {
            $('.alertfailurfile').html('');
            //alert("success");
        }
    }
});
</script>