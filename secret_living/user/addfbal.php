<?php include("header.php");
/*if(isset($_GET['id']))
{
    $product_id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `products` WHERE product_id =  '$product_id'"));
}*/
?>
<style>
.box label
{
	color:#000;
}
</style>			
	<section id="middle">
		<header id="page-header">
			<h1>Add Balance Request</h1>
		</header>
		<div id="content" class="padding-20">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default mypanel ">
						<div class="panel-heading panel-heading-transparent">
							<strong><?php echo isset($data['req_id'])?'Edit Balance Request':'Add Balance Request';?></strong>
						</div>
						<div class="panel-body">
							<form id="ManageFBalReq" action="" method="post">
			                    <div class="row ">
			                        <div class="form-group">
			                        <div class="col-md-12">
			                                <label>Amount</label>
			                                <input type="number" name="amount" id="amount" class="form-control" required>
			                        </div>
			                        <div class="clearfix"></div>
			                        </div>
			                        
			                    </div>
			                    <div class="row ">
			                        <div class="form-group">
			                        <div class="col-md-12">
			                                <label>Txn Id</label>
			                                <input type="text" name="txnid" id="txnid" class="form-control" required>
			                        </div>
			                        <div class="clearfix"></div>
			                        </div>
			                        
			                    </div>
			                    <div class="row">
			                        <div class="form-group">
			                        <div class="col-md-12">
			                                <label>Note</label>
			                                <textarea row="10" name="note" id="note" class="form-control" ></textarea>
			                        </div>
			                        <div class="clearfix"></div>
			                        </div>
			                    </div>
			                    
			                    <div class="row">
			                        <div class="form-group">
			                        <div class="col-md-12">
			                            <label>Image</label>
			                            <div class="fancy-file-upload fancy-file-primary">

			                                <i class="fa fa-upload"></i>
			                                <input type="file" class="form-control"  name="image" onchange="jQuery(this).next('input').val(this.value);" >
			                                <input type="text" class="form-control" placeholder="No file selected" readonly=""  >
			                                <span class="button">Choose File</span>
			                                
			                                
			                            </div>
			                            
			                        </div>
			                        <div class="clearfix"></div>
			                        </div>
			                    </div>
			                    <div class="clearfix"></div>
			                    <div class="row clearfix">
			                        <div class="form-group">
			                            <div class="col-md-12 col-sm-12 text-center">
			                                <input type="hidden" name="type" value="ManageFBalReq">
			                                <input type="hidden" name="req_id" id="req_id" value="<?php echo isset($data['id'])?isset($data['id']):''; ?>">
			                                <input type="submit"  data-form="ManageFBalReq"  class="btn btn-info btn-md btn-submit formvalidate"  value="Save">
			                            </div>
			                            <div class="clearfix"></div>
			                        </div>
			                    </div>
			                </form>

						</div>

					</div>
				</div>

				

			</div>					
		</div>
	</section>
			<!-- /MIDDLE -->
<?php include("footer.php");?>




