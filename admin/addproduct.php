<?php include("header.php");
if(isset($_GET['id']))
{
    $product_id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `products` WHERE product_id =  '$product_id'"));
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
			<h1>Products</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong><?php echo isset($data['product_id'])?'Edit Product':'Add Product';?></strong>
						</div>
						<div class="panel-body">
							<form id="ManageProduct" action="" method="post" enctype="multipart/form-data">
								<fieldset>
									<div class="row"> 
										<div class="form-group">
											<div class="col-md-4">
												<label>Product Name*</label>
												<div class="fancy-form"><!-- input -->
													<input type="text"  placeholder = "Enter Product Name" value="<?php echo isset($data['name'])?$data['name']:''?>" class = "form-control" name = "name" id = "name" title = "Enter Product Name!"  required>
												</div>
											</div>
											<div class="col-md-4">
												<label>Packages</label>
												<div class="fancy-form fancy-form-select">
													<select class="form-control select2" name="plan_id"  required>
														<option value="">Select Package</option>
														<?php
															$sql=mysqli_query($db,"SELECT * FROM plans");
											        while($row = mysqli_fetch_assoc($sql))
											        {
														?>
															<option value="<?php echo $row['plan_id']; ?>" <?php echo isset($data['plan_id']) && $data['plan_id']==$row['plan_id']?'selected':''; ?>><?php echo $row['title'].'('. $row['plan_name'].')'; ?></option>
														<?php } ?>
													</select>
													<i class="fancy-arrow"></i>
												</div>
											</div>
											<div class="col-md-4">
											   <label>MRP*</label>
											   <div class="fancy-form"><!-- input -->
											       <i class="">MR</i>
											       <input type="number"  placeholder = "Enter Product MRP" value="<?php echo isset($data['mrp'])?$data['mrp']:''?>" class = "form-control" name = "mrp" id = "mrp" title = "Enter Product MRP!"  	required>
											   </div>
											</div>
                      <div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											
											<!-- <div class="col-md-3">
											   <label>DP*</label>
											   <div class="fancy-form">
											       <i class="fa fa-inr"></i>
											       <input type="number"  placeholder = "Enter Product DP" value="<?php echo isset($data['dp'])?$data['dp']:''?>" class = "form-control" name = "dp" id = "dp" title = "Enter Product DP!"  required>
											   </div>
											</div> -->
											<!-- <div class="col-md-3">
											   <label>BV*</label>
											   <div class="fancy-form">
											       <i class="fa fa-inr"></i>
											       <input type="number"  placeholder = "Enter Product BV" value="<?php echo isset($data['bv'])?$data['bv']:''?>" class = "form-control" name = "bv" id = "bv" title = "Enter Product BV!"  required>
											   </div>
											</div> -->
											<div class="col-md-4">
											   <label>PV*</label>
											   <div class="fancy-form"><!-- input -->
											       <i class="">MR</i>
											       <input type="number"  placeholder = "Enter Product PV" value="<?php echo isset($data['pv'])?$data['pv']:''?>" class = "form-control" name = "pv" id = "pv" title = "Enter Product PV!"  required>
											   </div>
											</div>
											<div class="col-md-4">
											   <label>Member Price*</label>
											   <div class="fancy-form"><!-- input -->
											       <i class="">MR</i>
											       <input type="number"  placeholder = "Enter Member Price" value="<?php echo isset($data['member_price'])?$data['member_price']:''?>" class = "form-control" name = "member_price" id = "member_price" title = "Enter Member Price!"  required>
											   </div>
											</div>
											<div class="col-md-4">
											   <label>Selling Price*</label>
											   <div class="fancy-form"><!-- input -->
											       <i class="">MR</i>
											       <input type="number"  placeholder = "Enter Selling Price" value="<?php echo isset($data['selling_price'])?$data['selling_price']:''?>" class = "form-control" name = "selling_price" id = "selling_price" title = "Enter Selling Price"  required>
											   </div>
											</div>
                      <div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<!-- <div class="col-md-4">
											   <label>Franchise Price*</label>
											   <div class="fancy-form">
											       <i class="fa fa-inr"></i>
											       <input type="number"  placeholder = "Enter Product Franchise Price" value="<?php echo isset($data['fp'])?$data['fp']:''?>" class = "form-control" name = "fp" id = "fp" title = "Enter Product Franchise Price!"  required>
											   </div>
											</div> -->
											<!-- <div class="col-md-4">
											   <label style="padding-top:35px;"></label>
											  <label class="checkbox">
													Deal Of The Month ? <input type="checkbox" name="deal_of_day" id="deal_of_day" value="1" <?php echo isset($data['deal_of_day']) && $data['deal_of_day']==1?'checked':''; ?>>
													<i></i> 
												</label>
											</div>
											<div class="col-md-4">
											   <label style="padding-top:35px;"></label>
											  <label class="checkbox">
													Trending Product? <input type="checkbox" name="trending" id="trending" value="1" <?php echo isset($data['trending']) && $data['trending']==1?'checked':''; ?>>
													<i></i> 
												</label>
											</div> -->
                                			<div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label>Product Description *</label>
												<textarea name = "product_desc" class="ckeditor form-control" data-height="200" data-lang="en-US"><?php echo isset($data['product_desc'])?$data['product_desc']:''?></textarea>
											</div>
                                            <div class="clearfix"></div>
										</div>
									</div>
									<div class="row">
					                    <div class="form-group">  
					                        <div class="col-md-4 col-sm-4">
					                            <label>featured Image *</label>
					                            <!-- custom file upload -->
					                            <div class="fancy-file-upload fancy-file-primary">
					                                <i class="fa fa-upload"></i>
					                                <input type="file" class="form-control" name="image" onchange="jQuery(this).next('input').val(this.value);"  accept="image/jpeg, image/png" <?php echo isset($data['image'])?'':'required'; ?>>
					                                <input type="text" class="form-control" placeholder="No file selected" readonly="" >
					                                <span class="button">Choose File</span>
					                            </div>
					                            <!-- <small class="text-muted block" style="color:red;">Max file size: 10Mb</small> -->
					                        </div>
					                        <?php if(isset($data['image'])){ ?>
					                              <div class="col-sm-4 col-sm-4">
					                                  <img src="../upload/product/<?php echo $data['image']; ?>"  alt="Product Image" onError="this.onerror=null; this.src='../new_assets/uploads/images/logos/no_image.png'" style="width:100px;height:100px;">
					                              </div>
					                       <?php } ?> 
					                        
					                        <div class="clearfix"></div>
					                    </div>
				                	</div>
	                                
	        						
                  <div class="row">
                      <div class="form-group">                                
                          <div class="col-md-4">
                              <label>Product Image *</label>
                              <!-- custom file upload -->
                              <div class="fancy-file-upload fancy-file-primary">
                                  <i class="fa fa-upload"></i>
                                  <input type="file" class="form-control" name="prdimage[]" onchange="jQuery(this).next('input').val(this.value);"  accept="image/jpeg, image/png">
                                  <input type="text" class="form-control" placeholder="No file selected" readonly="" >
                                  <span class="button">Choose File</span>
                              </div>
                              <!-- <small class="text-muted block" style="color:red;">Max file size: 10Mb</small> -->
                          </div>
                          <div class="col-md-1 col-sm-1" style="padding-top:28px;">                                    
                              <span class="btn btn-sm btn-primary addprdimage"><i class="fa fa-plus"></i></span>
                          </div>                                
                          <div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="PrdImg"></div>


                    <div class="col-md-12 col-sm-12 text-center margin-top-10">
                        <input type ="hidden" name = "type" value="ManageProduct">
                        <input type ="hidden" name = "product_id" value="<?php echo isset($data['product_id'])?$data['product_id']:''?>">
                        <input type="submit"  id="formvalidate" data-form="ManageProduct"  class="btn btn-info btn-md btn-submit"  value="<?php echo isset($data['product_id'])?'Update Product':'Add Product';?>">
                        <div class="clearfix"></div>
                    </div>
								</fieldset>
							</form>

						</div>

					</div>
				</div>

				<div class="clearfix"></div>
		        <?php
		        if(isset($data['product_id']) && !empty($data['product_id']))
		        {
			        $result = mysqli_query($db, "select * from prd_images where product_id=".$data['product_id']);
			        if(mysqli_num_rows($result)>0)
			        {
			        ?>
			        <div class="col-md-12">
			            <div class="row">
			                <div class="panel panel-default mypanel ">
			                    <div class="panel-heading panel-heading-transparent">
			                            <strong>Product Images</strong>
			                    </div>
			                    <div class="panel-body">
			                        <table class="table table-bordered">
			                            <tr>
			                                <th>Image Name (Click to view or Download)</th>
			                                <th>Image</th>
			                                <th>Action</th>
			                            </tr>
			                            <?php
			                            $i = 1;
			                            while($row = mysqli_fetch_assoc($result))
			                            {
			                                ?>
			                                <tr id = "box_<?php echo $i;?>">
			                                    <td> <a href="<?php echo '../upload/product/'.$row['image']?>" target="_blank"><?php echo $row['image']; ?></a></td>
			                                    <td><?php 
					                                if(isset($row['image']) && !empty($row['image']))
					                                {
					                                    echo "<img src='../upload/product/".$row['image']."' height='40px' width='40px' alt=''>";
					                                }
					                            ?></td>
			                                    <td> <a href = "#" class="delprdimages btn btn-danger btn-xs" data-rowid = "box_<?php echo $i;?>" data-imageid="<?php echo $row["id"];?>" ><i class = "fa fa-trash"></i> Delete</a></td>
			                                </tr>
			                                <?php

			                                $i++;
			                            }
			                        ?>
			                        </table>
			                    </div>
			                </div>
			            </div>
			        </div>
			        <?php } 
			    }
			    ?> 

			</div>					
		</div>
	</section>
			<!-- /MIDDLE -->
<?php include("footer.php");?>




