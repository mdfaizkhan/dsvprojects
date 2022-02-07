<?php include("header.php");?>			
			<section id="middle">
				<header id="page-header">
					<h1>Web News</h1>  
				</header>
				<div id="content" class="padding-20">
					<div id="panel-1" class="panel panel-default mypanel">
						<div class="panel-heading">
							<span class="title elipsis">
								<strong>Web News</strong> <!-- panel title -->
								<a href="mwnews" class="btn btn-info btn-xs pull-right"><i class = "fa fa-plus"></i> Add</a>
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
										<th  class="">Title</th>
										<th  class="">Image</th>
										<th  class="">Description</th>
										<th  class="">Date</th>
										<th  class="">Action</th>
									</tr>
								</thead>

								<tbody>
								<?php
								$i = 1;
								$sql=mysqli_query($db,"SELECT * FROM web_news order by id");
								while($row = mysqli_fetch_assoc($sql))
								{	
								?>
									<tr class="odd gradeX">
										<td><?php echo $i++;?></td>
										
										<td><?php echo $row['title'];?></td>
										<td><img src="<?php echo '../upload/webnews/'.$row['image'];?>" alt="<?php echo $row['title'];?>" width="80px" height="80"></td>
										<td><?php echo $row['description'];?></td>
										<td><?php echo date("Y-m-d", strtotime($row['date']));?></td>
										
										<td  class="">
											<a href="mwnews?id=<?php echo $row['id'];?>" class="btn btn-info btn-xs" title="Edit <?php echo "News ". $row['title'];?>"><i class="fa fa-pencil"></i> Edit</a> 
											
											<a class="btn btn-danger btn-xs deleteWEBNews" href="javascript:void(0);" data-id=<?php echo $row['id'];?>" title="Remove <?php echo "News ". $row['title'];?>"><i class="fa fa-trash"></i> Delete</a> 
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
