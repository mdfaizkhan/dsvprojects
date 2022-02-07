<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>ROI History</h1>  
	</header>
	
	<?php 
		$mlmid = $_SESSION['mlmid'];
		$sql1 = mysqli_query($db,"SELECT
									t1.uname,
									t2.first_name,
									t2.last_name
									FROM user_id t1
									INNER JOIN user_detail t2 
									WHERE t2.uid = '$mlmid'") or die(mysqli_error($db));
		$row1 = mysqli_fetch_assoc($sql1);
	?>
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>ROI History [<?php echo $row1["first_name"]." ".$row1["last_name"]." (".$row1["uname"].")";?>]</strong>
				</span>
				
			</div>
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
							<tr>
	                            <th align="center">ID</th>
	                            <th  class="">ROI Amount</th>
	                            <th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
                        	$i=1;
							$sql = mysqli_query($db,"SELECT * FROM `v2_roi_history` where uid='$mlmid' order by date desc");
	                        while($row = mysqli_fetch_assoc($sql))
	                        {
	                    ?>
		                        <tr class="odd gradeX">
									<td align="center"><?php echo $i++;?></td>
									<td><?php echo $row['roi_amount'];?></td>
									<td><?php echo modifyDate($row['date']); ?></td>
		                        </tr>
	                    <?php } ?>    
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include("footer.php");?>