<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>My Commisions</h1>  
	</header>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel"> 
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>My Current Commision</strong> <!-- panel title -->
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
	                            <th  class="">Self Commisions</th>
								<!-- <th  class="">Password</th> -->
								<th  class="">Team Commisons</th>
								<th  class="">Active / Inactive</th>
								<th  class="">Date Time</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
						$pai = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `pairing` WHERE `uid` = $mlmid"));
						$sql=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$mlmid' && status=0");
						while($row=mysqli_fetch_array($sql)){
						?>
						<tr>
						  <td><?= $i++; ?></td>
						  <td><?= $row['self_commision']; ?></td>
						  <td><?= $row['rank_commision']; ?></td>
						  <td><?php if($pai['is_active']==1){ echo"Active"; }else{ echo"Inactive"; } ?></td>
						  <td><?= $row['datetime']; ?></td>
						  
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			
			<!-- /panel content -->

		</div>
	</div>
	
	
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>My Commision History</strong> <!-- panel title -->
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
	                            <th  class="">Self Commisions</th>
								<!-- <th  class="">Password</th> -->
								<th  class="">Team Commisons</th>
								<th  class="">Date Time</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
						$pai = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `pairing` WHERE `uid` = $mlmid"));
						$sql=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$mlmid' && status=1");
						while($row=mysqli_fetch_array($sql)){
						?>
						<tr>
						  <td><?= $i++; ?></td>
						  <td><?= $row['self_commision']; ?></td>
						  <td><?= $row['rank_commision']; ?></td>
						  <td><?= $row['updates_at']; ?></td>
						  
						</tr>
						<?php } ?>
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