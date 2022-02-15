<?php include("header.php");
if(isset($_GET['id']) && !empty($_GET['id'])){
    $fid = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `franchise` WHERE `id` = '$fid'"));
}
?>
<style>
.box label
{ 
	color:#000;
}
</style>			
	<section id="middle">
		<header id="page-header">
			<h1>Franchise</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong><?php echo isset($data['user_id'])?'Edit Franchise':'Add New Franchise'; ?></strong> 
						</div>
						<div class="panel-body">
							<form id="ManageFranchise"  action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
												<label>Username* <!--  <span id="usernameresp"></span> --></label>
												<div class="fancy-form">
													<i class="fa fa-user"></i>
													<input type="text"  placeholder = "Username" class = "form-control"  <?php echo isset($data['uname'])?'disabled':'name = "username" id = "username"'; ?> value="<?php echo isset($data['uname'])?$data['uname']:''; ?>" title = "Username should be unique"  required>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<label>Password*</label>
												<div class="fancy-form">
													<i class="fa fa-key"></i>
													<input type="password" placeholder = "Password" class = "form-control" name = "password" id = "password" value="<?php echo isset($data['password'])?$data['password']:''; ?>" title = "Enter Password here"  required>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
												<label>name*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-percent"></i>
													<input type="text"  placeholder = "Name" class = "form-control" name = "name" id = "name" value="<?php echo isset($data['name'])?$data['name']:''; ?>" title="It must contain only letters and a length of minimum 3 characters!"  required>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<label>Address*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-percent"></i>
													<input type="text"  placeholder = "Address" class = "form-control" name = "address" id = "address" value="<?php echo isset($data['address'])?$data['address']:''; ?>" title="It must contain only letters and a length of minimum 3 characters!"  required>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
												<label>Email*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-percent"></i>
													<input type="text"  placeholder = "Email" class = "form-control" name = "email" id = "email" value="<?php echo isset($data['email'])?$data['email']:''; ?>" title="Email Is Required"  required>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<label>Mobile*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-percent"></i>
													<input type="text"  placeholder = "Mobile Number" class = "form-control" name = "mobile" id = "mobile" value="<?php echo isset($data['mobile'])?$data['mobile']:''; ?>" title="Mobile Number Is Required"  required>
												</div>
											</div>
											
											<div class="clearfix"></div>
										</div>
									</div>
									<?php if(isset($data['id']) && !empty($data['id'])){ ?>
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
											
											<label>Wallet Balance *</label>
			                                <input type="number" name="balance" id="balance" class="form-control" value="<?php echo isset($data['balance'])?$data['balance']:''; ?>" required>
			                            	</div>
			                            	<div class="col-md-6 col-sm-6">
											
											<label>Commision Percentage *</label>
			                                <input type="number" name="com_per" id="com_per" class="form-control" value="<?php echo isset($data['com_per'])?$data['com_per']:''; ?>" required>
			                            	</div>
											
											<div class="clearfix"></div>
											
											<div class="clearfix"></div>
										</div>
									</div>
									<?php } ?>
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12 text-center">
												<input type="hidden" name="type" value="ManageFranchise" >
												<input type="hidden" name="txtid" value="<?php echo isset($data['id'])?$data['id']:''; ?>" >
												<button type="submit" id="formvalidate" data-form="ManageFranchise" name = "addusers"  class="btn btn-info btn-md btn-submit"><?php echo isset($data['id'])?'Update Franchise':'Add New Franchise'; ?></button>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</fieldset>
							</form>

						</div>

					</div>
					

				</div>



			</div>					
		</div>
	</section>

<?php include("footer.php");?>
