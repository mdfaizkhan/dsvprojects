<?php include("header.php");?>
<?php
if(isset($_POST['updatefaq']))
{
	$plan_amount = $_POST["plan_amount"];
	$no_of_pin = $_POST["no_of_pin"];
	$uid = $_POST["sponser"];
	$x = addtransferpin($db,$mlmid,$uid,$plan_amount,$no_of_pin);
	if($x == 1)
	{
		$success = "Pin has been transfer.";
	}
	else
	{
		$error = "Some of the pin cannot be transfer.";
	}
	
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
			<h1>Transfer Pin</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong>New Transfer Pin</strong> 
						</div>
						<div class="panel-body">
							<form  action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Sponsor*</label>
												<div class="fancy-form fancy-form-select"><!-- input -->
													<select class = "form-control select2" name = "sponser" id = "sponser" required>
													<option value = "" selected disabled>Select Sponsor</option>
													<?php
													$sql=mysqli_query($db,"SELECT * FROM `user_id` WHERE uid != $mlmid");
													while($row = mysqli_fetch_assoc($sql))
													{
													?>
													<option value = "<?php echo $row["uid"];?>"><?php echo $row["uname"];?></option>
													<?php
													}
													?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>No. of Transaction Pin*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-barcode"></i>
													<input type="number"  placeholder = "Enter No. of Transaction Pin" class = "form-control" name = "no_of_pin" id = "no_of_pin" title = "Enter No. of Transaction Pin!"  required>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Plan Amount*</label>
												<div class="fancy-form"><!-- input -->
													<select class = "form-control" name = "plan_amount" id = "plan_amount" required>
													<option value = "" selected disabled>Select Plan Amount</option>
													<?php
													$sql=mysqli_query($db,"SELECT * FROM `plans`");
													while($row = mysqli_fetch_assoc($sql))
													{
													?>
													<option value = "<?php echo $row["plan_id"];?>"><?php echo $row["plan_amount"];?></option>
													<?php
													}
													?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12 text-center">
												<button type="submit" name = "updatefaq"  class="btn btn-info btn-md" > Transfer Pin</button>
											</div>
										</div>
									</div>
								</fieldset>
							</form>

						</div>

					</div>
					<!-- /----- -->

				</div>



			</div>					
		</div>
	</section>
			<!-- /MIDDLE -->
<?php include("footer.php");?>
<?php 
	if(isset($success) || isset($error))
	{
		if( $success != "" ){ ?>
		<script>				
		
		_toastr("<?php echo $success; ?>","top-right","success",false);
		</script>
		
			<		
			
		<?php }  
			else if($error != "")
			{ ?>
				<script>				
					_toastr("<?php echo $error; ?>","top-right","error",false);		
				</script>
							
		<?php } 
	}
?>



