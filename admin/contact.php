<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>Contact</h1>  
	</header>
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Contact</strong> <!-- panel title -->
					
				</span>
			</div>
			<!-- panel content -->
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
						  <tr>
							<tr>
								<th  class="">ID</th>
								<th  class="">Name</th>
								<th  class="">Email</th>
								<th  class="">Phone</th>
								<th  class="">Subject</th>
								<th  class="">Message</th>
								<th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
						$sql=mysqli_query($db,"SELECT * from contact_form order by date desc");
						while($row = mysqli_fetch_assoc($sql))
						{	
						?>
							<tr class="odd gradeX">
								
								<td><?php echo $i++;?></td>
								<td><?php echo $row['contact_name'];?></td>
								<td><?php echo $row['contact_email'];?></td>
								<td><?php echo $row['contact_phone'];?></td>
								<td><?php echo $row['contact_subject'];?></td>
								<td><?php echo $row['contact_message'];?></td>
								<td><?php echo modifyDate($row['date']);?></td>
							</tr>
								
						<?php 
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include("footer.php");?>
