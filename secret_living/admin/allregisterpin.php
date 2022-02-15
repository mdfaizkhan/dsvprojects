<?php include("header.php");?>


			<!-- 
				MIDDLE 
			-->
			<style>
			
			</style>
			<section id="middle">
				<header id="page-header">
					<h1>Generate Pin</h1>
				</header>
				<div id="content" class="padding-20">
					<div id="panel-1" class="panel panel-default mypanel">
						<div class="panel-heading">
							<span class="title elipsis">
								<strong>Generate Pin</strong> <!-- panel title -->
								<!-- <a href="#" class="opt pull-right"><i class = "fa fa-plus"></i></a> -->
							</span>
						</div>
						<!-- panel content -->
						<div class="panel-body ">
							<form  action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="col-md-8 col-sm-offset-2">
									<div class="row">
										<div class="form-group">
											
											<div class="col-md-6 col-sm-6">												
												<input type="radio" class = "mypin" name = "mypin" id = "registerpin" value="registerpin" onclick="mypin1();"> Register Pin
											</div>
											
											<div class="col-md-6 col-sm-6">												
												<input type="radio" class = "mypin" name = "mypin" id = "mypin" value="mypin" onclick="mypin1();"> Transaction Pin
											</div>
										</div>
									</div>
								</div>
								</fieldset>
							</form>
						</div>
						<!-- /panel content -->

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

		<?php }  
			else if($error != "")
			{ ?>
				<script>				
					_toastr("<?php echo $error; ?>","top-right","error",false);		
				</script>
							
		<?php } 
	}
?>
<script type="text/javascript">
function mypin1(){
    if ($('#registerpin').is(':checked')) {
        window.location.href="addregisterpin";
    }
    else if ($('#mypin').is(':checked')) {
        window.location.href="addtranspin";
    }
 }
</script>