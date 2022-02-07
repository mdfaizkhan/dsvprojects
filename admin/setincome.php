<?php include("header.php");
$LevelIncomeNo=3;
if(isset($_GET['id']))
{
    $plan_id = $_GET['id'];
}

?>
<style>

</style>
<section id="middle">
    <header id="page-header">
        <h1>Set Level</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Levels</strong> <!-- panel title -->
                    
                </span>
            </div>
            <!-- panel content -->
            <form id="setLevelIncome" action="" method="post"/>
	            <div class="panel-body ">
	               <?php
	               $r1=mysqli_fetch_assoc(mysqli_query($db,"select * from rplans where plan_id='$plan_id'"));
	               $level=json_decode($r1['level_perc']);
	               
						$i=1;$n=3;
						for ($k=0; $k < $LevelIncomeNo; $k++)
						{
							if($i%$n==1)
							{
								echo '<div class="col-md-12"><div class="row">';
							}
							?>
								<div class="col-md-4">
									<div class="form-group">
			                        	<label><?php echo isset($i) && $i==1?'My Income':'Level'.$i; ?> *</label>
			                            <input type="number" class="form-control" name = "level[]" placeholder = "Level Percentage" value="<?php echo isset($level[$k])?$level[$k]:0 ; ?>" required>
			                            <div class = "clearfix"></div>
			                        </div>
		                        </div>
							</a>
							<?php
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
		                        	<input type="hidden" name="type" value="setLevelIncome">
		                        	<input type="hidden" name="levelno" value="<?php echo $levelno; ?>">
		                            <input type="submit" class="btn btn-info" id="formvalidate" data-form="setLevelIncome" value="Submit"/>
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

