

<div class="container-fluid">



          <!-- Page Heading -->

          <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

          <!-- DataTales Example -->

          <div class="card shadow mb-4">

            <div class="card-body">

<div class="col-md-12">	

        <div class="alertfailurfile"></div>

    <?php echo $this->session->userdata('msg'); ?> 

<form class="form-horizontal" method="post"  action="<?php if(!empty($cat)){ echo site_url('admin/editcategory/'.$this->uri->segment(3));}else{

        	echo  base_url('admin/addcategory/'.$this->uri->segment(3));

        } ?>"  enctype="multipart/form-data" >

				<h3 class="text-center">Category Details</h3><br>





         <div class="form-group">

          <label class="col-sm-2 control-label"> Category Name</label>

          <div class="col-sm-8">

            <input type="text" name="name" maxlength="10" class="form-control"  placeholder="category name" 

            value="<?php if(!empty($cat)){ echo $cat['name']; } ?>"

            > 

            <input type="hidden" name="service_id"  class="form-control"  placeholder="service id" 

            value="<?php if(!empty($cat)){ echo $cat['service_id']; } else{echo $this->uri->segment(3);}?>"

            >

            <p><?php echo form_error('name', '<span class="error_msg">', '</span>'); ?></p>

          </div>

        </div>

         <div class="form-group">

          <label class="col-sm-2 control-label"> Category Image</label>

          <div class="col-sm-8">

            <input type="file" name="image">

             <?php if(!empty($cat)){ ?>

                     

                    

                    

                    <br/><br/>

                 <img class="img-responsive" src="<?php echo base_url('/assets/images/'.$cat['image']); ?>" height="250px" width="200px">

                    <?php }?>

          </div>

        </div>

        

        <div class="col-sm-offset-2">

					<?php if(!empty($cat)){ ?>

  <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">

                <input type="submit" name="submit" value="Update" class="btn btn-success">

                <?php } else { ?>

                <input type="submit" name="submit" value="Add" class="btn btn-success">

                <?php } ?>

            </div>

       

			</form>

</div>

</div>

        </div>

        </div>







