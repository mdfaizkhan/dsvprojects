<?php include("header.php");
$data1=mysqli_fetch_assoc(mysqli_query($db,"select * from plans"));
$amounts=json_decode($data1['level_perc']);
$data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uname,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid = $mlmid"));
?>
			
<section id="middle">
	<header id="page-header">
		<h1>Royalty History</h1>  
	</header>
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Royalty History [<?php echo $data["first_name"]." ".$data["last_name"]." (".$data["uname"].")";?>]</strong> <!-- panel title -->
				</span>
				<!-- <a href="addusers" class="opt pull-right"><i class = "fa fa-plus"></i></a> -->
			</div>
			<!-- panel content -->
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
						  <tr>
							<tr>
	                            <th align="center">ID</th>
								<th  class="">Royalty Count</th>
	                            <th  class="">Amount</th>
	                            <th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
                        	$i=1;
							$sql = mysqli_query($db,"SELECT * FROM `rpayout_history` where uid='$mlmid' order by date desc");
							if(mysqli_num_rows($sql))
							{
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['total_count'];?></td>
			                            <td><?php  echo $row['b_amount'] ?></td>
			                            <td><?php  echo modifyDate($row['date']); ?></td>
										
			                        </tr>
		                    <?php
			                    } 
		                 }
	                     ?>    
						</tbody>
					</table>
				</div>
			</div>
			
			<!-- /panel content -->

		</div>
	</div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>