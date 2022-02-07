<?php include("header.php");?>
<?php
$q1 = mysqli_fetch_assoc($db->query("select * from user_detail where uid = '$mlmid'"));
$q2 = mysqli_fetch_assoc($db->query("select * from user_bank where uid = '$mlmid'"));
?>
<style type="text/css">

</style> 
<section id="middle">
	<header id="page-header">
		<h1>Profile</h1>  
	</header>
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Profile</strong> <!-- panel title -->
					
				</span>
			</div>
			<div class="panel-body ">

			  <div class="col-md-7 col-md-offset-2 m-b-xxl" id="msform">
			    <fieldset class="active" id="fieldset1">
					<center>
						<div class="stepwizard" >
						<div class="stepwizard-row setup-panel">
							<div class="stepwizard-step">
								<a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
								<p>User information</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-2" type="button" class="btn btn-default btn-circle">2</a>
								<p>Address information</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-3" type="button" class="btn btn-default btn-circle">3</a>
								<p>Bank information</p>
							</div>
						</div>
					</div>
					</center>
				
					<div class="row setup-content" id="step-1">
						<form id="UpdateProfile1" role="form" action="" method="post">
							<div class="col-xs-12">
								<div class="col-md-12">
									<h3 class="fs-title">User information</h3>
									<div class="form-group">
										<label class="control-label">First Name</label>
										<input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" name = "first_name" value = "<?php echo $q1["first_name"];?>"/>
									</div>
									<div class="form-group">
										<label class="control-label">Last Name</label>
										<input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" name = "last_name" value = "<?php echo $q1["last_name"];?>" />
									</div>
									<div class="form-group">
										<label class="control-label">Gender</label>
										<select name = "gender" class="form-control" required="required">
											<option value="" selected disabled>Gender</option>
											<option value="male" <?php if($q1["gender"]== 'male') echo "selected";?>>Male</option>
											<option value="female" <?php if($q1["gender"]== 'female') echo "selected";?>>Female</option>
											<option value="other" <?php if($q1["gender"]== 'other') echo "selected";?>>Other</option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label">Relation</label>
										<input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Relation e.g. : Friend, Brother, Sisters, Etc" name = "relation" value = "<?php echo $q1["relation"];?>"/>
									</div>
									<div class="form-group">
										<label class="control-label">Beneficiary</label>
										<input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Beneficiary" name = "beneficiary" value = "<?php echo $q1["beneficiary"];?>"/>
									</div>
									<div class="form-group">
										<label class="control-label">Mobile</label>
										<input maxlength="100" type="number" required="required" class="form-control" placeholder="Enter Mobile" name = "mobile" value = "<?php echo $q1["mobile"];?>"/>
									</div>
									<div class="form-group">
										<label class="control-label">Phone</label>
										<input maxlength="100" type="number" required="required" class="form-control" placeholder="Enter Phone" name = "phone" value = "<?php echo $q1["phone"];?>"/>
									</div>
									<div class="form-group">
										<label class="control-label">PAN Card No</label>
										<input maxlength="100" type="text" class="form-control" placeholder="Enter PAN Card No" name = "pan_no" value = "<?php echo $q1["pan_no"];?>"/>
									</div>
									<!-- <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button> -->
									<input type="hidden" name="type" value="UpdateProfile">
									<input type="hidden" name="info" value="user_detail">
									<button class="btn btn-success btn-md pull-right" id="formvalidate" data-form="UpdateProfile1" type="submit">Submit</button>
								</div>
							</div>
						</form>
					</div>
					<div class="row setup-content" id="step-2">
						<form id="UpdateProfile2" role="form" action="" method="post">
							<div class="col-xs-12">
								<div class="col-md-12">
									<h3 class="fs-title">Address information</h3>
									<div class="form-group">
										<label class="control-label">Address</label>
										<textarea required="required" class="form-control" placeholder="Enter your address" name = "address"><?php echo $q1["address"];?></textarea>
									</div>
									<div class="form-group">
										<label class="control-label">City</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter City" name = "city" value = "<?php echo $q1["city"];?>" />
									</div>
									<div class="form-group">
										<label class="control-label">Zip</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Zip" name = "zip" value = "<?php echo $q1["zip"];?>"/>
									</div>
									<div class="form-group">
										<label class="control-label">State</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter state" name = "state" value = "<?php echo $q1["state"];?>" />
									</div>
									<div class="form-group">
										<label class="control-label">Country</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Country" name = "country" value = "<?php echo $q1["country"];?>" />
									</div>
									<!-- <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button> -->
									<input type="hidden" name="type" value="UpdateProfile">
									<input type="hidden" name="info" value="user_detail">
									<button class="btn btn-success btn-md pull-right" id="formvalidate" data-form="UpdateProfile2" type="submit">Submit</button>
								</div>
							</div>
							<div class ="clearfix"></div>
						</form>
					</div>
					<div class="row setup-content" id="step-3">
						<form id="UpdateProfile3" role="form" action="" method="post">
							<div class="col-xs-12">
								<div class="col-md-12">
									<h3 class="fs-title"> Bank information</h3>
									<div class="form-group">
										<label class="control-label">Bank Name</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Bank Name" name = "bank_name" value = "<?php echo $q2["bank_name"];?>"/>
									</div>
									<div class="form-group">
										<label class="control-label">Branch Name</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Branch Name" name = "branch_name" value = "<?php echo $q2["branch_name"];?>" />
									</div>
									<?php if(!isset($q2["bankholder"])){?>
									<div class="form-group">
										<label class="control-label">Holder Name</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Holder Name" name = "bankholder" value = "<?php echo $q2["bankholder"];?>" />
									</div>
									<?php } ?>
									<div class="form-group">
										<label class="control-label">Account Number</label>
										<input maxlength="20" type="number" required="required" class="form-control" placeholder="Enter Account Number" name = "acnumber" value = "<?php echo $q2["acnumber"];?>" />
									</div>
									<div class="form-group">
										<label class="control-label">IFSC Code</label>
										<input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter IFSC Code" name = "swiftcode" value = "<?php echo $q2["swiftcode"];?>" />
									</div>
									<input type="hidden" name="type" value="UpdateProfile">
									<input type="hidden" name="info" value="user_bank">
									<button class="btn btn-success btn-md pull-right" id="formvalidate" data-form="UpdateProfile3" type="submit">Submit</button>
								</div>
							</div>
						</form>
					</div>
				<!-- </form> -->
				</fieldset>
			 </div>

			</div>
		</div>
	</div>
</section>
<?php include("footer.php");?>
