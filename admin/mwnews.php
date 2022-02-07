<?php include("header.php");
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `web_news` WHERE id =  '$id'"));
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
			<h1>Web News</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong>New Web News</strong> 
						</div>
						<div class="panel-body">
							<form id="AddWebNews" action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Title*</label>
												<div class="fancy-form"><!-- input -->
													<i class="fa fa-user"></i>
													<input type="text"  placeholder = "Enter Title" class = "form-control" name = "title" id = "title" title = "Enter Title!" value="<?php echo isset($data['title'])?$data['title']:''; ?>"  required>
												</div>
											</div>
										<div class="clearfix"></div>
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
			                                    <div class="col-md-4"><img style="max-width: 60%;" src="<?php echo '../upload/webnews/'.$data['image']?>"><div class="clearfix"></div></div>
			                                <?php }?>
			                                <div class="clearfix"></div>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Description *</label>
												<textarea name = "description" class="form-control" data-height="200" data-lang="en-US"><?php echo isset($data['description'])?$data['description']:''; ?></textarea>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12 text-center">
												<input type="hidden" name="type" value="AddWebNews" >
												
												<input type="hidden" name="txtid" value="<?php echo isset($data['id'])?$data['id']:''; ?>" >
												<button type="submit" id="formvalidate" data-form="AddWebNews" class="btn btn-info btn-md btn-submit" >Add Web News</button>
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




