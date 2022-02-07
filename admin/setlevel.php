<?php include("header.php");
if(isset($_GET['id']))
{
    $plan_id = $_GET['id'];
}

?>
<style>

</style>
<section id="middle">
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel col-md-12">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Levels</strong> <!-- panel title -->
                    
                </span>
            </div>
            <!-- panel content -->
            <form id="setLevelPer" action="" method="post"/>
	            <div class="panel-body ">
	               <?php
	               $r1=mysqli_fetch_assoc(mysqli_query($db,"select * from plans where plan_id='$plan_id'"));
	               $level=json_decode($r1['level_perc']);
	               $LevelPercentNo=$r1['levels']+1;
	               
						$i=1;$n=3;
						for ($k=0; $k < $LevelPercentNo; $k++)
						{
							if($i%$n==1)
							{
								echo '<div class="col-md-12"><div class="row">';
							}
							if($i==1){
							?>
							<div class="col-md-4">
								<div class="form-group">
		                        	<label>Direct Sponsor Commission *</label>
		                            <input type="number" class="form-control" name = "level[]" placeholder = "Level Percentage" value="<?php echo isset($level[$k])?$level[$k]:0 ; ?>" required>
		                            <div class = "clearfix"></div>
		                        </div>
	                        </div>

							<?php
							}
							else{
							?>
								<div class="col-md-4">
									<div class="form-group">
			                        	<label>Level <?php echo $i-1; ?> *</label>
			                            <input type="number" class="form-control" name = "level[]" placeholder = "Level Percentage" value="<?php echo isset($level[$k])?$level[$k]:0 ; ?>" required>
			                            <div class = "clearfix"></div>
			                        </div>
		                        </div>
							</a>
							<?php
							}	
							if($i%$n == 0)
							{
								echo '</div></div>
								<div class = "clearfix"></div>';
							}
							$i++;
						}
						if(($i-1)%$n != 0)
						{
							echo '</div></div>
							<div class = "clearfix"></div>';
						}?> 
						<div class="row">
		                    <div class="form-group"> 		                        
		                        <div class="col-md-12 text-center">
		                        	<input type="hidden" name="plan_id" value="<?php echo isset($plan_id)?$plan_id:'' ?>">
		                        	<input type="hidden" name="type" value="setLevelPercentage">
		                        	<input type="hidden" name="levelno" value="<?php echo $levelno; ?>">
		                            <input type="submit" class="btn btn-info" id="formvalidate" data-form="setLevelPer" value="Submit"/>
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

