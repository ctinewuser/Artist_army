

<div class="container-fluid">

          <a href="<?php echo base_url()?>admin/feedList" class="btn btn-info mb-3">Back</a>

          <!-- Page Heading -->

          <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

          <!-- DataTales Example -->

          <div class="card shadow mb-4">

            <div class="card-body">

<div class="col-md-12"> 

        <div class="alertfailurfile"></div>

    <?php echo $this->session->userdata('msg'); ?> 

<form class="form-horizontal" method="post"  action="<?php if(!empty($img)){ echo site_url('admin/showImage/'.$this->uri->segment(3));}else{

          echo  base_url('admin/add-genrecat/'.$this->uri->segment(3));

        } ?>"  enctype="multipart/form-data" >
     <!--     <a href="<?php echo base_url()?>admin/show_postlist" class="btn btn-info mb-3">Back</a> -->
        <h3 class="text-center">Feed Image </h3><br>
       
        <div class="form-group">
          <label class="col-sm-2 control-label">Image</label>
          <div class="col-sm-8">
           
             <?php if(!empty($img)){ ?>
                    <br/><br/>
                 <img class="img-responsive" src="<?php echo base_url('/assets/post/'.$img['image']); ?>" height="250px" width="200px">
                    <?php }?>
          </div>
        </div>



      </form>

</div>

</div>

        </div>

        </div>

