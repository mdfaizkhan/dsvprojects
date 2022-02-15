<?php include("header.php");
if(isset($_GET['id']))
{
    $plan_id = $_GET['id'];
    $q1 = mysqli_query($db,"SELECT `royal_amount` FROM plans where plan_id='$plan_id'");
    $data = mysqli_fetch_assoc($q1);
}

?>
<style>

</style>
<section id="middle">
    <header id="page-header">
        <h1>Set Royalty Plan Amount</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel col-md-6">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Royalty Plan Amount</strong> <!-- panel title -->
                    
                </span>
            </div>
            <!-- panel content -->
            <form id="setRoyaltyAmount" action="" method="post"/>
	            <div class="panel-body ">
						<div class="row">
		                    <div class="form-group"> 
			                    <div class="col-md-12">
								    <label>Royalty Plan Amount*</label>
								    <div class="fancy-form">
								        <i class="fa fa-inr"></i>
								        <input type="number"  placeholder = "Enter Royalty Plan Amount" value="<?php echo isset($data['royal_amount'])?$data['royal_amount']:''?>" class = "form-control" name = "royal_amount" id = "royal_amount" title = "Enter Royalty Plan Amount!" required>
								    </div>
								</div>		                        
		                       <div class="clearfix"></div>
		                    </div>
		                </div>
		                <div class="row">
		                    <div class="form-group">       
		                        <div class="col-md-12 text-center">
		                        	<input type="hidden" name="plan_id" value="<?php echo isset($plan_id)?$plan_id:'' ?>">
		                        	<input type="hidden" name="type" value="setRoyaltyAmount">
		                            <input type="submit" class="btn btn-info" id="formvalidate" data-form="setRoyaltyAmount" value="Submit"/>
		                        </div>
		                        <div class="clearfix"></div>
		                    </div>
		                </div>
	            </div>
            </form>
            <!-- /panel content -->

        </div>
    </div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>

