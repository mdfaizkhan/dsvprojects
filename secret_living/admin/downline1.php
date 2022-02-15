<?php include("header.php");
$getpair=mysqli_fetch_assoc(mysqli_query($db,"select * from user_id where uid='$mlmid'"));
$mpair=$getpair['paired'];
if(isset($_GET['level']) && !empty($_GET['level']))
{
	$id = $_GET['level'];
	$i = 1;
	$sql="SELECT t1.*,t2.* from pairing t1 join user_id t2 on t1.uid=t2.uid where t2.paired='$id'";
	$sql=mysqli_query($db,$sql);
}
else
{
	$sql="SELECT t1.*,t2.* from pairing t1 join user_id t2 on t1.uid=t2.uid where t2.paired='1'";
	$sql=mysqli_query($db,$sql);
}
?>
		
<section id="middle">
	<header id="page-header">
		<h1>Downline Distributor</h1>  
	</header>
	<div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>Filter</strong> <!-- panel title -->
				</span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <form name="LevelFilter" action="" method="get"/>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="fancy-form fancy-form-select">
                                <select class = "form-control select2" name = "level" id = "level" required>
                                    <option value = "" disabled selected>Select Level</option>
                                    <?php
                                    for ($x = 1; $x < 16; $x++)
                                	{
                                		$levelid=$mpair+$x;
                                        ?>
                                    	<option value ="<?php echo $levelid; ?>" <?php echo isset($x) && $x==1?'selected':'';  ?> <?php echo isset($id) && $levelid==$id?'selected':'';  ?>><?php echo "Level ".$x; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-info" id="LevelFilter" data-form="LevelFilter" value="Filter"/>
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
					<strong>Downline Distributor</strong>
				</span>
			</div>
			<!-- panel content -->
			<form name="bulk_action_form" action="" method="post"/>
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
						  <tr>
							<tr>
								<th align="center">ID</th>
								<th class=""> Parent</th>
								<th class="">Distributor</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i=1;
						while($row = mysqli_fetch_assoc($sql))
						{	
						?>
							<tr class="odd gradeX">
								<td align="center">
									<?php echo $i;?>
								</td>
								<td><?php 
								$parent_id = $row['parent_id'];
								$p = mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = '$parent_id'"));
								echo $p["uname"];
								?></td>
								<td><?php 
								$child = $row['uid'];
								$l = mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = '$child'"));
								echo $l["uname"];
								?></td>
						<?php 
						$i++;
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
			</form>
			<!-- /panel content -->

		</div>
	</div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>
