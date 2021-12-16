<div class="container-fluid">
<div class="height20 clear"></div>
<div class="col-sm-12">	
    <?php echo $this->session->userdata('msg'); ?> 
 	
    <form class="form-horizontal" method="post" action="<?php if(!empty($terms)){ echo base_url('admin/termServices');}else{
          echo  base_url('admin/addcategory');
        } ?>" >
      <fieldset>
        <h1 class="h3 mb-2 page-title">Update Terms and Services</h1>
        <div class="form-group" id="main">
          <textarea class="form-control ckeditor" rows="20" name="editor" required><?php echo $terms['data']; ?></textarea>
        </div>
        
       
        <div class="form-group">
          <div class="text-right">
           <?php if(!empty($terms)){ ?>
  				<input type="hidden" name="id" value="<?php echo $terms['id']; ?>">
                <input type="submit" name="submit" value="Update" class="btn btn-success" style="min-width: 180px;">
                <?php } else { ?>
                <input type="submit" name="submit" value="Add" class="btn btn-success" style="min-width: 180px;">
                <?php } ?>
          </div>
        </div>
      </fieldset>
    </form>
</div>
</div>
</div>