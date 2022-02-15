<?php include("header.php");?>
<?php $new_user=getRefNUser($db);
$planamount=getRefPlanAmount($db); ?>
<section id="middle">
    <header id="page-header">
        <h1>Payout Detail</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel col-md-8">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Edit Payout Detail</strong> <!-- panel title -->
                    <a href="javascript:void(0);" class="pull-right">Payout Amount : <?php echo $new_user * $planamount; ?> </a>
                </span>
            </div>
            <!-- panel content -->
            <form id="EditRefBonusDetail" action="" method="post" enctype="multipart/form-data">
	            <div class="panel-body ">
	            	<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label><b>No Of Child</b></label>
				                        </div>
			                        </div>
			                        <div class="col-md-3">
										<div class="form-group">
											<label><b>No Of User Eligible</b></label>
				                        </div>
			                        </div>
									<div class="col-md-3">
										<div class="form-group">
				                            <label><b>Income Percentage</b></label>
				                            <div class = "clearfix"></div>
				                        </div>
			                        </div>
			                        
			                        <div class="col-md-3">
										<div class="form-group">
				                            <label><b>Capping</b></label>
				                            <div class = "clearfix"></div>
				                        </div>
			                        </div>
			                        
			                    </div>
			                </div>
	               <?php
	               $k=0;
	               $q1=mysqli_query($db,"select * from referel_bonus_detail");
						while($r1=mysqli_fetch_assoc($q1))
						{
							?>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" class="form-control" name = "payout[<?php echo $k; ?>][mem_count]" value="<?php echo isset($r1['mem_count'])?$r1['mem_count']:0 ; ?>" disabled>
				                        	
				                        </div>
			                        </div>
			                        <div class="col-md-3">
										<div class="form-group">
											<?php
											$mcnt=$r1['mem_count'];
												$sql=mysqli_query($db,"SELECT * FROM `refpayout` where status=1 and total_count=$mcnt");
												$no_user=mysqli_num_rows($sql);
											?>
											<a href="refuser.php?cnt=<?php echo $mcnt; ?>"><input type="text" class="form-control" name = "" value="<?php echo isset($no_user)?$no_user:0 ; ?>" disabled></a>
				                        	
				                        </div>
			                        </div>
									<div class="col-md-3">
										<div class="form-group">
				                            <input type="number" class="form-control" name = "payout[<?php echo $k; ?>][income_perc]" placeholder = "Percentage" value="<?php echo isset($r1['income_perc'])?$r1['income_perc']:0 ; ?>" required>
				                            <input type="hidden" class="form-control" name = "payout[<?php echo $k; ?>][id]" value="<?php echo isset($r1['id'])?$r1['id']:0 ; ?>" >
				                            <div class = "clearfix"></div>
				                        </div>
			                        </div>
			                        <div class="col-md-3">
										<div class="form-group">
				                            <input type="number" class="form-control" name = "payout[<?php echo $k; ?>][capping]" placeholder = "Capping" value="<?php echo isset($r1['capping'])?$r1['capping']:0 ; ?>" disabled>
				                            <div class = "clearfix"></div>
				                        </div>
			                        </div>
			                    </div>
			                </div>
								<div class = "clearfix"></div>
						<?php $k++; } ?> 
						<div class="row">
		                    <div class="form-group"> 		                        
		                        <div class="col-md-12 text-center">
		                        	<input type="hidden" name="type" value="EditRefBonusDetail">
		                            <input type="button" class="btn btn-info btn-md btn-submit " id="formvalidate" data-form="EditRefBonusDetail" value="Submit"/>
		                        </div>
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

