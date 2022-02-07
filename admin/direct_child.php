<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>Direct Distributor</h1>  
	</header>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Direct Distributor List</strong> <!-- panel title -->
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
	                            <th align="center"> Sr.no</th>
	                            <th  class="">Username</th>
								<!-- <th  class="">Password</th> -->
								<th  class="">Name</th>
								<th  class="">Sponsor</th>
								<th  class="">Email</th>
								<th  class="">Welcome Letter</th>
								<th  class="">Package</th>
	                            <th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
						$myquery = "SELECT t1.*,t2.*,t3.*,t4.uname as suname from pairing t1 join user_id t2 on t1.uid = t2.uid join user_detail t3 on t1.uid=t3.uid left join user_id t4 on t1.sponsor_id=t4.uid where t1.sponsor_id = $mlmid and t2.uid!=1 order by t1.uid ";
						
						$sql = mysqli_query($db,$myquery);
	                    while($row = mysqli_fetch_assoc($sql))
	                    {	
	                    ?>
	                        <tr class="odd gradeX">
	                            <td align="center">
	                                    <?php echo $i++;?>
	                            </td>
	                           <td><?php echo $row['uname'];?></td>
								<!-- <td><?php //echo $row['password'];?></td> -->
								<td><?php echo $row['first_name']." ".$row["last_name"];?></td>
								<td><?php echo $row['suname'];?></td>
								<td><?php echo $row['email'];?></td>
								<td><a href="welcomeletter?id=<?php echo $row['uid']; ?>" target="_blank" class="btn btn-xs btn-success" title="Welcome Letter"><i class="fa fa-eye"></i> View</a> </td>
								<td><?php
								if(!empty($row['pin']))
								{
									$uid = $row["uid"];
									$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from transpin t1 join plans t2 on t1.plan_id =t2.plan_id and t1.uid = '$uid'"));
									echo $q1['plan_amount'];
								}
								else
								{
									echo "--";
								}
								?></td>	
	                            <td><?php echo date('d/m/Y',strtotime($row['date']));?></td>
	                            
	                            
	                        </tr><!--#31708F-->
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