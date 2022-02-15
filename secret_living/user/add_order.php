<?php include("header.php");
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `orders` WHERE `id` = '$id'"));
}
 ?>
<section id="middle">
    <header id="page-header"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <h1>Orders</h1>
    </header>
    <div id="content" class="dashboard padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo isset($data['id'])?'Edit order':'Add order';?></h2>
            </div>
            <div class="panel-body">
                <form action="" id = "formaddorder" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4 col-sm-4">
                                    <label>Category</label><br>
                                    <select  name="cat_id" id="cat_id" width=300 style="width: 350px" title="Category Required!" class="productFetch" required="required">
									 <option value="">Select Category</option> 
									<?Php 
									$q1 = mysqli_query($db,"SELECT * FROM `product_category`");
									while($r1 = mysqli_fetch_assoc($q1))
									{ ?>
                                        <option value="<?php echo $r1['cat_id'];?>"><?php echo $r1['cat_name'];?></option>                                        
									<?php } ?>
                                        </select>
                                </div>
                                <!-- <div class="col-md-4 col-sm-4">
                                    <label>Date</label>
                                    <input type="text" style="width: 350px"  placeholder = "Date" class = "form-control" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" name = "date" id = "datetimepicker" value="<?php echo isset($data['date'])?$data['date']:''?>" title = "Date Required!" required >                                    
                                </div>	 -->							
                               
								<div class="clearfix"></div>
								
							</div>
						</div>
						<div class ="inside_div margin-bottom-10">
                            <div class="col-md-12"><span class="btn btn-info btn-xs button-color add_field_button pull-right"><i class="fa fa-plus"></i> Add More</span></div><div class="clearfix"></div>
                            <div class="row bx1">
                                <div class="form-group" style="padding-left:10px; padding-right:10px;">
									<div class="col-md-4 col-sm-6">
										<label>Products</label>
										<select placeholder = "Products" class = "form-control select2 ProductsSel" name = "products[1][name]" id = "products1" title = "Enter Product.!" required="required" >
                                            <option value=''>Select Product</option>
                                        </select>
                                        <!-- <datalist id="productSearch">
                                            <option></option>
                                        </datalist> -->
									</div>
                                    
									<div class="col-md-4 col-sm-6">
										<label>Quantity</label>
										<input type="text"  placeholder = "Quantity" class = "form-control qty" name = "products[1][qty]"  id = "quantity1" title = "Enter Quantity" data-total="total1" data-amount="amount1" required="required">
									</div>									
									
									<div class="clearfix"></div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
                        <div class="additionc margin-bottom-10"></div>
                         
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 text-center">
                                    <input type ="hidden" name = "txtid" id="txtid" value="<?php echo isset($data['id'])?$data['id']:'';?>">
                                    <input type ="hidden" name = "type" value="AddOrder">
                                    <input type="submit"  id="formvalidate" data-form="formaddorder"  class="btn btn-info btn-md btn-submit"  value="<?php echo isset($data['id'])?'Update order':'Add Order';?>">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        
    </div>
</section>
<?php include("footer.php"); ?>
