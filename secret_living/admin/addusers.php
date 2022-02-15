<?php include("header.php");
if(isset($_GET['id']) && !empty($_GET['id'])){
    $userid = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT t1.*,t2.*,t1.uid,t3.parent_id as user_id FROM `user_id` t1 join user_detail t2 on t1.uid=t2.uid join pairing t3 on t1.uid=t3.uid WHERE t1.`uid` = '$userid'"));
}
if(isset($_GET['parentid']) && !empty($_GET['parentid'])){
    $parent_id = $_GET['parentid'];
    $pos = isset($_GET['pos'])?$_GET['pos']:'';
}
else if(isset($data['parent_id']) && !empty($data['parent_id']))
{
	$parent_id = $data['parent_id'];
}
else
{
	$parent_id ='';
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
			<h1>Users</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong><?php echo isset($data['user_id'])?'Edit User':'Add New User'; ?></strong> 
						</div>
						<div class="panel-body">
							<form id="formaddedituser"  action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="row">
										<div class="form-group">
											<?php if(!isset($data['user_id'])){ ?>
											<div class="col-md-4 col-sm-4">
												<label>Sponsor Id<span style="color:red;">*</span></label>
												<div class="fancy-form">
													<i class="fa fa-percent"></i>
													<input type="text" placeholder="Sponsor Id" name = "sponsor_id" id = "sponsor_id" class="form-control getSponsordetail" value="<?php echo isset($data['sponsor_id'])?$data['sponsor_id']:''; ?>" required>
												</div>
											</div>

											<div class="col-md-4 col-sm-4">
												<label>Sponsor Name</label><br>
												<label style="border: 1px solid #dddddd; padding: 8px; width: 100%; height: 40px;    background: #f5f9fc;"><b id="Sponsordetail"><span style="color:red;">Please Enter Sponsor Id*</span></b></label>
											</div>

											<div class="col-md-4 col-sm-4">
												<label>Select Package</label>
												<div class="fancy-form">
													<div class="fancy-form fancy-form-select">
													 <select class="form-control select2" name="package" required="">
													 <?php
													 $getPackage=mysqli_query($db,"SELECT * FROM `plans`");
													 while($package = mysqli_fetch_array($getPackage)){
													 ?>
													   <option value="<?= $package['plan_id'] ?>"><?= $package['plan_name'] ?> RM <?= $package['plan_amount'] ?></option>
													 <?php } ?>
													 </select>
													<i class="fancy-arrow"></i>
													</div>	
												</div>
											</div>
											<div class="clearfix"></div>
											<?php } ?>

										</div>
									</div>
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
												<label>First name<span style="color:red;">*</span></label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-percent"></i>
													<input type="text"  placeholder = "First name" class = "form-control" name = "fname" id = "fname" value="<?php echo isset($data['first_name'])?$data['first_name']:''; ?>" title="It must contain only letters and a length of minimum 3 characters!"  required>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<label>Last name<span style="color:red;">*</span></label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-percent"></i>
													<input type="text"  placeholder = "Last name" class = "form-control" name = "lname" id = "lname" value="<?php echo isset($data['last_name'])?$data['last_name']:''; ?>" title="It must contain only letters and a length of minimum 3 characters!"  required>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
												<label>Username<span style="color:red;">*</span>  <span id="usernameresp"></span></label>
												<div class="fancy-form">
													<i class="fa fa-user"></i>
												 <?php
												 $sql1=mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(*) as un FROM `user_id` WHERE uid!=1"));
												 $tot=5000+$sql1['un'];
												 $unames="SL".$tot;
												 ?>
													<input type="text"  placeholder = "Username" class = "form-control checkusername"  <?php echo isset($data['uname'])?'disabled':'name = "username" id = "plan_amount"'; ?> value="<?php echo isset($data['uname'])?$data['uname']:$unames; ?>" title = "Username should be Atleast 6 characters" minlength="6"  required>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<label>Password<span style="color:red;">*</span></label>
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
											<!-- <div class="col-md-6 col-sm-6">
												<label>PIN No<span style="color:red;">*</span></label>
												<?php if(isset($data['pin']) && !empty($data['pin'])){ ?>
												<div class="fancy-form">
													<i class="fa fa-key"></i>
													<input type="text" placeholder = "PIN No" class = "form-control checkValidPin" title="PIN Required!" <?php echo isset($data['pin'])?'disabled':' name = "pin_no" id = "pin_no"'; ?> value="<?php echo isset($data['pin'])?$data['pin']:''; ?>" <?php echo isset($data['pin'])?'required':''; ?>>
												</div>
												
												<?php } else { ?>
												<div class="fancy-form fancy-form-select">
													<select class="form-control select2" name="pin_no"  <?php echo isset($data['pin'])?'':'required'; ?>>
														<option value="">--- Select ---</option>
														<?php
															$sql=mysqli_query($db,"SELECT t1.*,t3.plan_id,t3.plan_amount,t3.plan_name FROM transpin t1 join plans t3 on t1.plan_id = t3.plan_id where t1.allot_uid=0 and t1.status=0 order by status");
								                            while($row = mysqli_fetch_assoc($sql))
								                            {
														?>
														<option value="<?php echo $row['pin_code']; ?>" <?php echo isset($data['pin']) && $data['pin']==$row['pin_code']?'selected':''; ?>><?php echo $row['pin_code']; ?> - [<?php echo $row['plan_name']."-".$row['plan_amount']; ?>]</option>
														<?php } ?>
													</select>
													<i class="fancy-arrow"></i>
												</div>
												
												<?php } ?>
											</div> -->
											<div class="col-md-6 col-sm-6">
												<label>Mobile No<span style="color:red;">*</span></label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-percent"></i>
													<input type="text" placeholder="Mobile No" name="mobile_no" id="mobile_no" class="form-control" value="<?php echo isset($data['mobile'])?$data['mobile']:''; ?>" minlength="10" required>
												</div>	 
											</div>
											<div class="col-md-6 col-sm-6">
												<label>Email address<span style="color:red;">*</span></label>
												<div class="fancy-form">
													<i class="fa fa-envelope"></i>
													<input type="email" placeholder = "Email address" class = "form-control" name = "email" id = "email" value="<?php echo isset($data['email'])?$data['email']:''; ?>" title = "It must contain a valid email address e.g. 'someone@provider.com' !"  >
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
												<label>Gender</label>
													<div class="fancy-form fancy-form-select">
														<select class="form-control select2" name="gender" required="">
															<option value="male" <?php echo isset($data['gender']) && $data['gender']=='male'?'selected':''; ?>>Male</option>
															<option value="female" <?php echo isset($data['gender']) && $data['gender']=='female'?'selected':''; ?>>Female</option>
															<option value="other" <?php echo isset($data['gender']) && $data['gender']=='other'?'selected':''; ?>>Other</option>
														</select>
														<i class="fancy-arrow"></i>
													</div>
											</div>
											<?php if(!isset($data['user_id'])){ ?>
											<div class="col-md-6 col-sm-6">
												<label>Choose Position</label>
												<div class="fancy-form">
													<select class="form-control" name="position" style="border: 2px solid #dedede;">
														<option value="">Please Select</option>
														<option value="L" <?php echo isset($pos) && $pos=='L'?'selected':''; ?>>Left</option>
														<option value="R" <?php echo isset($pos) && $pos=='R'?'selected':''; ?>>Right</option>
													</select>
												</div>
											</div>
											<?php } else { ?>
											<div class="col-md-6 col-sm-6">
												<label>Position</label>
												<div class="fancy-form">
													<i class="fa fa-percent"></i>
													<input type="text" placeholder="Position" name = "position" id = "position" class="form-control" value="<?php echo isset($data['position'])?$data['position']:''; ?>" readonly>
												</div>
											</div>
											<?php } ?>
											<div class="clearfix"></div>
										</div>
									</div>
									
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12 text-center">
												<input type="hidden" name="type" value="AddEditUser" >
												<!-- <input type="hidden" name="parent_id" value="<?php echo isset($data['parent_id'])?$data['parent_id']:$mlmid; ?>" > -->
												<input type="hidden" name="txtid" value="<?php echo isset($userid)?$userid:''; ?>" >
												<button type="submit" id="formvalidate" data-form="formaddedituser" name = "addusers"  class="btn btn-info btn-md btn-submit"><?php echo isset($data['uid'])?'Update User':'Add New User'; ?></button>
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
