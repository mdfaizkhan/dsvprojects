<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>Binary History</h1>  
	</header>
	
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Binary History [<?php echo $data["first_name"]." ".$data["last_name"]." (".$data["uname"].")";?>]</strong>
				</span>
				
			</div>
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
							<tr>
	                            <th align="center">ID</th>
								<th  class="">No Of Pair</th>
	                            <th  class="">Binary Commission</th>
	                            <th  class="">Amount</th>
	                            <th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
                        	$i=1;
							$sql = mysqli_query($db,"SELECT * FROM `binary_history` where uid='$mlmid' order by date desc");
	                        while($row = mysqli_fetch_assoc($sql))
	                        {
	                    ?>
		                        <tr class="odd gradeX">
									<td align="center"><?php echo $i++;?></td>
									<td><?php echo $row['count'];?></td>
									<td><?php echo $row['binary_com'];?></td>
									<td><?php echo $row['amount'] ?></td>
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