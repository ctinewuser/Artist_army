

<div class="container-fluid">



          <!-- Page Heading -->

          <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

          <!-- DataTales Example -->

          <div class="card shadow mb-4">

            <div class="card-body">

<div class="col-md-12"> 

        <div class="alertfailurfile"></div>

    <?php echo $this->session->userdata('msg'); ?> 

<form class="form-horizontal" method="post"  action="<?php if(!empty($cat)){ echo site_url('admin/edit_genrecategory/'.$this->uri->segment(3));}else{

          echo  base_url('admin/add_genrecat/');

        } ?>"  enctype="multipart/form-data" >

        <h3 class="text-center"><?= $title; ?></h3><br>


         <div class="form-group">

          <label class="col-sm-2 control-label"> Genre Name</label>

          <div class="col-sm-8">

            <input type="text" name="genre_name"  class="form-control"  placeholder="genre name" 

            value="<?php if(!empty($cat)){ echo $cat['genre_name']; } ?>"

            > 

           <!--  <input type="hidden" name="service_id"  class="form-control"  placeholder="service id" 

            value="<?php if(!empty($cat)){ echo $cat['service_id']; } else{echo $this->uri->segment(3);}?>"

            > -->

         <p><?php echo form_error('genre_name', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>

      
        <div class="col-sm-offset-2">

          <?php if(!empty($cat)){ ?>

  <input type="hidden" name="genre_id" value="<?php echo $cat['genre_id']; ?>">

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







