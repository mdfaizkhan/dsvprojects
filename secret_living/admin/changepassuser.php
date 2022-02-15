<?php include("header.php");
if(isset($_GET['id']) && !empty($_GET['id']))
{
	$uid = $_GET['id'];
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
			<h1>Change Password</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong>Change Password</strong> 
						</div>
						<div class="panel-body">
							<form id="userChangePass" method="post" enctype="multipart/form-data">
								<fieldset>

									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>New Password *</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-key"></i>
													<input type="password" placeholder = "Please enter your new password" class = "form-control" name = "new_password" id = "new_password" title = "Password should be at least 6 characters!" min="6" required>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Confirm Password *</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-key"></i>
													<input type="password"  placeholder = "Please retype your new password" class = "form-control" name = "confirm_password" id = "rpassword" title = "Enter same password you entered in password field!" min="6" required>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12 text-center">
												<input type="hidden" id="uid" value="<?php echo isset($uid)?$uid:''; ?>">
												<button type="submit" id="formvalidate" data-form="userChangePass" name = "updatepassword"  class="btn btn-info btn-md" >Update New Password</button>
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
			<!-- /MIDDLE -->
<?php include("footer.php");?>

