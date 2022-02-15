<?php include("header.php");
if(isset($_GET['no']))
{
    $levelno = $_GET['no'];
}

?>

<!--
    MIDDLE
-->
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
								<strong>No Of Level</strong> <!-- panel title -->
							</span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <form action="" method="GET"/>
	                <div class="row">
	                    <div class="form-group">                       
	                       
	                        <div class="col-md-4">
	                        	<label>No Of Level*</label>
	                            <input type="number" class="form-control" name = "no" placeholder = "No Of Level" value="<?php echo isset($levelno)?$levelno:''; ?>">
	                        </div>
	                        <div class="col-md-8" style="padding-top:27px;">
	                            <input type="submit" class="btn btn-info" value="Submit"/>
	                        </div>
	                    </div>
	                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Levels</strong> <!-- panel title -->
                    
                </span>
            </div>
            <!-- panel content -->
            <form id="setLevelPer" action="" method="post"/>
	            <div class="panel-body ">
	               <?php
	               $r1=mysqli_fetch_assoc(mysqli_query($db,"select * from set_level where lid='1'"));
	               $level=json_decode($r1['level']);
	               $levelno=isset($levelno)?$levelno:$r1['levelno'];
						$i=1;$n=3;
						ob_start();
						for ($k=0; $k < $levelno; $k++)
						{
							if($i%$n==1)
							{
								echo '<div class="col-md-12"><div class="row">';
							}
							?>
								<div class="col-md-4">
									<div class="form-group">
			                        	<label>Level <?php echo $i; ?> *</label>
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

