<?php include("header.php");?>			
			<section id="middle">
				<header id="page-header">
					<h1>Rewards Plans</h1>  
				</header>
				<div id="content" class="padding-20">
					<div id="panel-1" class="panel panel-default mypanel">
						<div class="panel-heading">
							<span class="title elipsis">
								<strong>Rewards Plans</strong> <!-- panel title -->
								<a href="addrewards" class="btn btn-info btn-xs pull-right"><i class = "fa fa-plus"></i> Add</a>
							</span>
						</div>
						<!-- panel content -->
						<form name="bulk_action_form" action="" method="post"/>
						<div class="panel-body ">
							<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
								<thead>
								  <tr>
									<tr>
										<th  class="">ID</th>
										<!-- <th  class="">Plan Amount</th> -->
										<th  class="">Title</th>
										<th  class="">Amount</th>
										<th  class="">Reward Amount</th>
										<th  class="">Image</th>
										<th  class="">Description</th>
										<th  class="">Action</th>
									</tr>
								</thead>

								<tbody>
								<?php
								$i = 1;
								$sql=mysqli_query($db,"SELECT * FROM rewards_plans order by id");
								while($row = mysqli_fetch_assoc($sql))
								{	
								?>
									<tr class="odd gradeX">
										<td><?php echo $i++;?></td>
										<!-- <td>
											<?php //$plan_id = $row['plan_id'];
												//$q= mysqli_fetch_assoc ( mysqli_query($db,"SELECT * FROM  plans WHERE plan_id = $plan_id ") );
												echo $q['plan_amount'];
											?>
										
										</td> -->
										<td><?php echo $row['name'];?></td>
										<td><?php echo $row['amount'];?></td>
										<td><?php echo $row['ramount'];?></td>
										<td><?php 
												if(isset($row['image']) && !empty($row['image']))
												{
													echo "<img src='../upload/".$row['image']."' height='100px' width='100px'>";
												}
											?></td>
										<td><?php echo truncate( $row['rewards_desc'], 20 ) ;?></td>
										
										<td  class="">
											<a href="addrewards?id=<?php echo $row['id'];?>" class="btn btn-info btn-xs" title="Edit <?php echo "Rewards Plan ". $row['amount'];?>"><i class="fa fa-pencil"></i> Edit</a> 
											
											<a class="btn btn-danger btn-xs deleterewardplan" href="javascript:void(0);" data-id=<?php echo $row['id'];?>" title="Remove <?php echo "Rewards Plan ". $row['amount'];?>"><i class="fa fa-trash"></i> Delete</a> 
										</td>
									</tr><!--#31708F-->
								<?php 
								}
								?>
								</tbody>
							</table>
							 
						</div>
						</form>
						<!-- /panel content -->

					</div>
				</div>
			</section>

<?php include("footer.php");?>
