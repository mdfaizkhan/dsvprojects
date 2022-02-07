<?php include("header.php");
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `rewards_plans` WHERE id =  '$id'"));
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
			<h1>Rewards Plans</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong>New Plan</strong> 
						</div>
						<div class="panel-body">
							<form id="AddReward" action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="row">
										<div class="form-group">
											<!-- <div class="col-md-4 col-sm-12">
												<label>Plan Amount*</label>
												<div class="fancy-form">
													<select class = "form-control" name = "plan_id" id = "plan_id" required>
													<option value = "" selected disabled>Select Plan Amount</option>
													<?php
													$sql=mysqli_query($db,"SELECT * FROM  plans");
													while($row = mysqli_fetch_assoc($sql))
													{
													?>
													<option value = "<?php echo $row["plan_id"];?>"><?php echo $row["plan_name"] ." (".$row["plan_amount"].")";?></option>
													<?php
													}
													?>
													</select>
												</div>
											</div> -->
											<div class="col-md-4 col-sm-12">
												<label>Title*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-user"></i>
													<input type="text"  placeholder = "Enter Title" class = "form-control" name = "name" id = "name" title = "Enter Title!" value="<?php echo isset($data['name'])?$data['name']:''; ?>"  required>
												</div>
											</div>
											<div class="col-md-4 col-sm-12">
												<label>Amount*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-user"></i>
													<input type="number"  placeholder = "Enter Amount" class = "form-control" name = "amount" id = "amount" title = "Enter Pairs!" value="<?php echo isset($data['amount'])?$data['amount']:''; ?>" required>
												</div>
											</div>
											<div class="col-md-4 col-sm-12">
												<label>Rewards Amount*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-inr"></i>
													<input type="number"  placeholder = "Enter Rewards Amount" class = "form-control" name = "ramount" id = "ramount" title = "Enter Rewards Amount!" value="<?php echo isset($data['ramount'])?$data['ramount']:''; ?>"  required>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group">
											
											 <div class="col-md-4">
			                                    <label>Image </label>
			                                    <div class="fancy-file-upload fancy-file-primary">
			                                        <i class="fa fa-upload"></i>
			                                        <input type="file" class="form-control"  name="image" onchange="jQuery(this).next('input').val(this.value);"   accept="image/jpeg, image/png" <?php //echo isset($data['image'])?'':'required';?>>
			                                        <input type="text" class="form-control" placeholder="No file selected" readonly=""  >
			                                        <span class="button">Choose File</span>
			                                    </div>
			                                    <small class="text-muted block" style="color:red;">Max file size: 10Mb (jpg/png)</small>
			                                </div>
			                                <?php if(isset($data['image']) && !empty($data['image'])){?>
			                                    <div class="col-md-4"><img style="max-width: 100%;" src="<?php echo '../upload/'.$data['image']?>"><div class="clearfix"></div></div>
			                                <?php }?>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Rewards Description *</label>
												<textarea name = "rewards_desc" class="ckeditor form-control" data-height="200" data-lang="en-US"><?php echo isset($data['rewards_desc'])?$data['rewards_desc']:''; ?></textarea>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12 text-center">
												<input type="hidden" name="type" value="AddReward" >
												
												<input type="hidden" name="txtid" value="<?php echo isset($data['id'])?$data['id']:''; ?>" >
												<button type="submit" id="formvalidate" data-form="AddReward" class="btn btn-info btn-md btn-submit" >Add New Rewards</button>
											</div>
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




