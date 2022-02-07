<?php include("header.php");
if(isset($_GET['id']))
{
    $plan_id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `plans` WHERE plan_id =  '$plan_id'"));
}
?>
<style>
.box label
{
	color:#000;
}
</style>			
	<section id="middle">
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong><?php echo isset($data['plan_id'])?'Edit Package':'Add Package';?></strong>
						</div>
						<div class="panel-body">
							<form id="ManagePlan" action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label>Title*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-gift"></i>
													<input type="text"  placeholder = "Enter Title Name" value="<?php echo isset($data['title'])?$data['title']:''?>" class = "form-control" name = "title" id = "plan_name" title = "Enter Title Name!"  required>
												</div>
											</div>
											<div class="col-md-3">
												<label>Package Name*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-gift"></i>
													<input type="text"  placeholder = "Enter Package Name" value="<?php echo isset($data['plan_name'])?$data['plan_name']:''?>" class = "form-control" name = "plan_name" id = "plan_name" title = "Enter Package Name!"  required>
												</div>
											</div>
                                            <div class="col-md-3">
                                                <label>Package Amount*</label>
                                                <div class="fancy-form"><!-- input -->
                                                    <i class="fa" style="font-size: 13px;">RM</i>
                                                    <input type="number"  placeholder = "Enter Package Amount" value="<?php echo isset($data['plan_amount'])?$data['plan_amount']:''?>" class = "form-control" name = "plan_amount" id = "plan_amount" title = "Enter Package Amount!"  required>
                                                </div>
                                            </div>

                                             <div class="col-md-3">
                                                <label>Levels*</label>
                                                <div class="fancy-form"><!-- input -->
                                                    <i class="fa fa-users"></i>
                                                    <input type="number"  placeholder = "Enter Levels" value="<?php echo isset($data['levels'])?$data['levels']:''?>" class = "form-control" name = "levels" id = "levels" title = "Enter Levels!"  required>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-3">
                                                <label>Capping Amount*</label>
                                                <div class="fancy-form">
                                                    <i class="fa fa-inr"></i>
                                                    <input type="number"  placeholder = "Enter Capping Amount" value="<?php echo isset($data['capping'])?$data['capping']:''?>" class = "form-control" name = "capping" id = "capping" title = "Enter Capping Amount!" required>
                                                </div>
                                            </div>-->
                                         
                                            <div class="clearfix"></div>
										</div>
									</div>
									
								
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Plan Description *</label>
												<textarea name = "plan_desc" class="ckeditor form-control" data-height="200" data-lang="en-US"><?php echo isset($data['plan_desc'])?$data['plan_desc']:''?></textarea>
											</div>
                                            <div class="clearfix"></div>
										</div>
									</div>
                                    <div class="col-md-12 col-sm-12 text-center margin-top-10">
                                        <input type ="hidden" name = "type" value="ManagePlan">
                                        <input type ="hidden" name = "plan_id" value="<?php echo isset($data['plan_id'])?$data['plan_id']:''?>">
                                        <input type="submit"  id="formvalidate" data-form="ManagePlan"  class="btn btn-info btn-md btn-submit"  value="<?php echo isset($data['plan_id'])?'Update Plan':'Add Plan';?>">
                                        <div class="clearfix"></div>
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



