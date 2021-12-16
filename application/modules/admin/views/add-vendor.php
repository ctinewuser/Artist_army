<style type="text/css">
	div#state_chosen, div#city_chosen {
    width: 100% !important;
    height: 35px;
}
.vndr-cat{
	height: 65px;
}
.vndr-cat .chosen-container.chosen-container-single{
	width: 100% !important;
}
div#state_chosen a.chosen-single, div#city_chosen a.chosen-single, .vndr-cat a.chosen-single{
    height: 35px;
}

div#state_chosen a.chosen-single span, div#city_chosen a.chosen-single span, .vndr-cat a.chosen-single span{
    line-height: 35px;
}

.chosen-container-single .chosen-single div b {background-position: 0 7px !important;}
</style>
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 page-title"><?= $title; ?></h1>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="col-md-12">
				<div class="alertfailurfile"></div>
				<?php echo $this->session->userdata('msg'); ?>
					<form class="form-horizontal" method="post" action="<?php if(!empty($vendor)){ echo site_url('admin/editVendor');}else{        	echo  base_url('admin/addVendor');        } ?>" enctype="multipart/form-data" autocomplete="off">
						<h5 class="text-theme mb-3"> Vendor Detail</h5>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label"> Full Name</label>
							<div class="col-sm-8">
								<input type="text" name="full_name" class="form-control" placeholder=" Full Name" <?php if(!empty($vendor)) echo 'value="'.$vendor['full_name']. '"'; ?>>
								<?php echo form_error('full_name', '<span class="error_msg">', '</span>'); ?> </div>
						</div>
						 <div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label"> Buisness Name</label>
							<div class="col-sm-8">
								<input type="text" name="buisness_name" class="form-control" placeholder=" Buisness Name" <?php if(!empty($vendor)) echo 'value="'.$vendor['buisness_name']. '"'; ?>>
								<?php echo form_error('buisness_name', '<span class="error_msg">', '</span>'); ?> 
							</div>
						</div>

						
						<!-- 	<div class="form-group">
								<label for="focusedinput" class="col-sm-12 control-label">Name of the registered firm:</label>
								<div class="col-sm-8">
									<input type="text" name="registered_firm" class="form-control" placeholder="Name of the registered firm" <?php if(!empty($vendor)) echo 'value="'.$vendor['registered_firm'].'"'; ?>>
									<?php echo form_error('registered_firm', '<span class="error_msg">', '</span>'); ?> </div>
							</div> -->
								<div class="form-group vndr-cat">
								<label for="focusedinput" class="col-sm-2 control-label">Vendor Category</label>
								<div class="col-sm-8">
									<select id="" class="form-control mb-0" placeholder="" name="vendor_category">
								
									<?php foreach($cat as $k=>$val){ ?>

								<option value="<?php echo $val['id']; ?>" <?php if($val['id']==$vendor['vendor_category'])
									{ echo "selected='selected'";} ?>>
									<?php echo $val['category']; ?></option>
								<?php }?>
								
								</select>
								<?php echo form_error('vendor_category', '<span class="error_msg">', '</span>'); ?> 
								</div>
							</div>
							<!-- <div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Shop brand:</label>
								<div class="col-sm-8">
									<input type="text" name="store_brand" class="form-control" placeholder="Shop brand" <?php if(!empty($vendor)) echo 'value="'.$vendor['store_brand'].'"'; ?>>
									<?php echo form_error('store_brand', '<span class="error_msg">', '</span>'); ?> </div>
							</div>


							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">EIN Number:</label>
								<div class="col-sm-8">
									<input type="text" name="EIN_number" class="form-control" placeholder="EIN number" <?php if(!empty($vendor)) echo 'value="'.$vendor['EIN_number'].'"'; ?>>
									<?php echo form_error('EIN_number', '<span class="error_msg">', '</span>'); ?> </div>
							</div> -->
							<div class="form-group">
									<label for="focusedinput" class="col-sm-6 control-label">Email</label>
									<div class="col-sm-8">
										<input type="text" name="email" class="form-control" placeholder="Email" <?php if(!empty($vendor)) echo 'value="'.$vendor[ 'email']. '"'; ?>>
										<?php echo form_error('email', '<span class="error_msg">', '</span>'); ?> </div>
								</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-8">
									<input type="password" name="password" class="form-control" placeholder="Password" value="">
									<?php echo form_error('password', '<span class="error_msg">', '</span>'); ?> </div>
							</div>


						
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Phone Number</label>
									<div class="col-sm-6 d-flex">
										<div class="mr-3">
										<input type="number" min="0" name="country_code"class="form-control"  placeholder="+1" value="+1" readonly="readonly" >
										 </div>
									<div class="col-sm-6">
										<input type="number" min="0" name="phone_number" class="form-control mb-0" placeholder="Phone Number" <?php if(!empty($vendor)) echo 'value="'.$vendor[ 'phone_number']. '"'; ?>>
										<?php echo form_error('phone_number', '<span class="error_msg">', '</span>'); ?> </div>
								</div>
							</div>
							<div class="form-group ml-2">
								<label for="focusedinput" class="col-sm-4 control-label">Select State</label>

								<label for="focusedinput" class="col-sm-4 control-label">Select City</label>

								
								<div class="row">
								<div class="col-sm-4">
                                   <!--Required Select State-->
									<select id="state" class="form-control" name="state" required>
                                   <option value="">Select State*</option>
                                  <?php foreach ($state as $key => $value) {
                                  	if($value['id'] == $vendor['state']){
                                  		$s = 'selected="selected"';
                                  	}else{
                                  		$s = "";
                                  	}
                                    
                                  ?>
                                    <option  <?php echo $s; ?> value="<?php echo $value['id'];  ?>"><?php echo $value['name'];  ?></option>
                                    <?php } ?>
                                </select>
                            	</div>

                            	<div class="col-sm-4">
                            	<?php if(!empty($vendor['city'])){?>	
                            	<select id="city" class="form-control" name="city">
                                 <option value="">Select City*</option>
                                  <?php foreach ($city as $key => $value) {
                                  	if($value['id'] == $vendor['city']){
                                  		$s = 'selected="selected"';
                                  	}else{
                                  		$s = "";
                                  	}
                                    
                                  ?>
                                    <option  <?php echo $s; ?> value="<?php echo $value['id'];  ?>"><?php echo $value['name'];  ?></option>
                                    <?php } ?>
                                </select>

                               
                            	<?php }else {?>
                              	 <!-- City dropdown -->
                                <select id="city" class="form-control" name="city" >
                                    <option value="">Select City*</option>
                                </select>

                                <?php } ?>
                            </div>

                            <div class="col-sm-4">

                                 <input name="pincode" class="form-control" autocomplete="off" type="text" placeholder="ZIP Code*"  >
									 </div>
								</div>	 
							</div>          



						<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Description</label>
								<div class="col-sm-8"><textarea name="description" autocomplete="off" placeholder="Description Of Your Business & Any Additional Details *" class="d-block py-2"  ><?php if(!empty($vendor['description'])){ echo $vendor['description'];}else{echo "";}  ?></textarea>
                                </div>
							</div>



								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Address</label>
											
									<div class="col-sm-8"><textarea name="address" autocomplete="off" placeholder="Address " class="d-block py-2" ><?php if(!empty($vendor['address'])){ echo $vendor['address'];}else{echo "";}  ?></textarea>
			                         </div>
								</div>

							
								<!-- <div class="form-group mb-n">
									<label class="col-sm-2 control-label label-input-lg">Document Image</label>
									<div class="col-sm-8">
										<input type="file" name="document_image">
										<?php if(!empty($vendor)){ ?>
											<br/>
											<br/> <img class="img-responsive" src="<?php echo base_url('/assets/userfile/profile/'.$vendor['document_image']); ?>" height="250px" width="200px">
											<?php }                    ?>
									</div>
								</div> -->
								<div class="text-right">
									<?php if(!empty($vendor)){ ?>
										<input type="hidden" name="vendor_id" value="<?php echo $vendor['vendor_id']; ?>">
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
</div>