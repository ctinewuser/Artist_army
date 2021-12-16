

<div class="container-fluid">



          <!-- Page Heading -->

          <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

          <!-- DataTales Example -->

          <div class="card shadow mb-4">

            <div class="card-body">

<div class="col-md-12"> 

        <div class="alertfailurfile"></div>

    <?php echo $this->session->userdata('msg'); ?> 

<form class="form-horizontal" method="post"  action="<?php if(!empty($concert)){ echo site_url('admin/edit_concert/'.$this->uri->segment(3));}else{

          echo  base_url('admin/add_concert/'.$this->uri->segment(3));

        } ?>"  enctype="multipart/form-data" >

        <h3 class="text-center"><?= $title; ?></h3><br>


         <div class="form-group">

          <label class="col-sm-2 control-label">Title</label>

          <div class="col-sm-8">

            <input type="text" name="concert_title"  class="form-control"  placeholder="concert title" 

            value="<?php if(!empty($concert)){ echo $concert['concert_title']; } ?>"

            > 

             <p><?php echo form_error('concert_title', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>

          <div class="form-group">

          <label class="col-sm-2 control-label">Concert Date</label>

          <div class="col-sm-8">
            <?php 
              if(!empty($concert['concert_date'])){
                $date = date('d-m-Y',strtotime($concert['concert_date']));
              }else{
                $date = "";
              }
            ?>
            <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                 <input type="text" name="concert_date"  class="form-control"  placeholder="concert date" value="<?php echo $date; ?>"> 
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
             <p><?php echo form_error('concert_date', '<span class="error_msg">', '</span>'); ?></p> 
          </div>

        </div>

          <div class="form-group">

          <label class="col-sm-2 control-label">Concert Time</label>

          <div class="col-sm-8">
         <?php 
              if(!empty($concert['concert_time'])){
                $time = date('h:i A',strtotime($concert['concert_time']));
              }else{
                $time = "";
              }
            ?>
          <!--    <div id="timepicker" class="input-group time" data-date-format="dd-mm-yyyy">  -->

            <input type="time" name="concert_time"  class="form-control"  placeholder="concert title" 

            value="<?php if(!empty($concert)){ echo $concert['concert_time']; } ?>"

            >
             <p><?php echo form_error('concert_time', '<span class="error_msg">', '</span>'); ?></p> 

          </div>

        </div>


      <div class="form-group">

          <label class="col-sm-2 control-label">Venue</label>

          <div class="col-sm-8">

            <input type="text" name="concert_venue"  class="form-control"  placeholder="concert venue" 

            value="<?php if(!empty($concert)){ echo $concert['concert_venue']; } ?>"

            > 

          </div>


        </div>
   
       <div class="form-group">

          <label class="col-sm-2 control-label">Concert Detail</label>

          <div class="col-sm-8">

            <textarea name="description"  class="form-control"  placeholder="concert title" 

            value="<?php if(!empty($concert)){ echo $concert['description']; } ?>"

            ><?php if(!empty($concert)){ echo $concert['description']; } ?> </textarea>

           <!--   <p><?php echo form_error('description', '<span class="error_msg">', '</span>'); ?></p>  -->

          </div>

        </div>

        <div class="col-sm-offset-2">

          <?php if(!empty($concert)){ ?>

  <input type="hidden" name="concert_id" value="<?php echo $concert['concert_id']; ?>">

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







