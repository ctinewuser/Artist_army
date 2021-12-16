

<div class="container-fluid">

          <!-- Page Heading -->

          <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

          <!-- DataTales Example -->

          <div class="card shadow mb-4">

            <div class="card-body">

<div class="col-md-12"> 

        <div class="alertfailurfile"></div>

    <?php echo $this->session->userdata('msg'); ?> 

<form class="form-horizontal" method="post"  action="<?php if(!empty($bit)){ echo site_url('admin/edit_bitpack/'.$this->uri->segment(3));}else{

          echo  base_url('admin/add_bitpack/');

        } ?>"  enctype="multipart/form-data" >

        <h3 class="text-center"><?= $title; ?></h3><br>


         <div class="form-group">

          <label class="col-sm-2 control-label">Bit Pack Name</label>

          <div class="col-sm-8">

            <input type="text" name="bit_name"  class="form-control"  placeholder="bit name" 

            value="<?php if(!empty($bit)){ echo $bit['bit_name']; } ?>"

            > 


         <p><?php echo form_error('bit_name', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>
     <!--  <div class="form-group">

          <label class="col-sm-2 control-label">Bit Type</label>

          <div class="col-sm-8">

            <input type="text" name="type"  class="form-control"  placeholder="bit type" 

            value="<?php if(!empty($bit)){ echo $bit['type']; } ?>"

            > 
         <p><?php echo form_error('type', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div> -->
        <div class="form-group">

          <label class="col-sm-2 control-label">Bit Amount</label>

          <div class="col-sm-8">

            <input type="number" name="amount_in_bit"  class="form-control"  placeholder="bit amount" 

            value="<?php if(!empty($bit)){ echo $bit['amount_in_bit']; } ?>"

            > 
         <p><?php echo form_error('amount_in_bit', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>
        <div class="form-group">

          <label class="col-sm-2 control-label">Euro Amount</label>

          <div class="col-sm-8">

            <input type="number" name="amount_in_euro"  class="form-control"  placeholder="euro amount" 

            value="<?php if(!empty($bit)){ echo $bit['amount_in_euro']; } ?>"

            > 

         <p><?php echo form_error('amount_in_euro', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>
      
        <div class="col-sm-offset-2">

          <?php if(!empty($bit)){ ?>

  <input type="hidden" name="id" value="<?php echo $bit['id']; ?>">

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







