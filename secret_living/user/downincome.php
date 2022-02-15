<?php include("header.php");
$data=mysqli_fetch_assoc(mysqli_query($db,"select * from plans"));
$amounts=json_decode($data['level_perc']);
?>
			
<section id="middle">
	<header id="page-header">
		<h1>My Downline Income</h1>  
	</header>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>My Downline Income</strong> <!-- panel title -->
				</span>
				<!-- <a href="addusers" class="opt pull-right"><i class = "fa fa-plus"></i></a> -->
			</div>
			<!-- panel content -->
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover " id="">
						<thead>
						  <tr>
							<tr>
	                            <th align="center"> Level</th>
								<th  class="">Count</th>
	                            <th  class="">Income</th>
							</tr>
						</thead>

						<tbody>
						<?php
							for ($i=0; $i < $LevelPercentNo; $i++) {
								$j=$i+1; 
								if($i==0)
								{
									$res=GetUids($db,$mlmid);
									$uids_str=implode(',', $res);
									$sql1= "SELECT sum(`amount`) as amount FROM `child_earning` where parent_id='$mlmid' and FIND_IN_SET(`uid`,'$uids_str')";
									$q1=mysqli_query($db,$sql1);
									$r1=mysqli_fetch_assoc($q1);

								}
								else
								{
									$res1=GetUids($db,$mlmid);
									$funname="getLevel$j";
									$res=$funname($db,$res1);
									$uids_str=implode(',', $res);
									$sql1= "SELECT sum(`amount`) as amount FROM `child_earning` where parent_id='$mlmid' and FIND_IN_SET(`uid`,'$uids_str')";
									$q1=mysqli_query($db,$sql1);
									$r1=mysqli_fetch_assoc($q1);

								}
								$ucount=count($res);
		                    ?>
		                        <tr class="odd gradeX">
		                            <td align="center">
		                                    <?php echo "Level ".$j;?>
		                            </td>
		                           <td><?php  echo $ucount ?></td>
		                           <td><?php echo isset($r1['amount']) && !empty($r1['amount'])?$r1['amount']:0;?></td>
									
		                        </tr>
	                    <?php
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