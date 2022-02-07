<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>Franchise</h1>  
	</header>
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Franchise</strong> <!-- panel title -->
					<a href="addfranchise" class="btn btn-info btn-xs pull-right"><i class = "fa fa-plus"></i>Add Franchise</a>
				</span>
			</div>
			<!-- panel content -->
			<form name="bulk_action_form" action="" method="post"/>
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
							<tr>
								<th  class="">SR No</th>
								
								<th  class="">Username</th>
								<th  class="">Password</th>
								<th  class="">Trans Password</th>
								<th  class="">Name</th>
								<th  class="">Address</th>
								<th  class="">Email</th>
								<th  class="">Mobile</th>
								<th  class="">Wallet Balance</th>
								<th  class="">Commision Percentage</th>
								<th  class="">Action</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
                       
						$sql=mysqli_query($db,"SELECT * FROM `franchise`");
						while($row = mysqli_fetch_assoc($sql))
						{	
						?>
							<tr class="odd gradeX">
								<td><?php echo $i++; ?></td>								
								<td><?php echo $row['uname'];?></td>
								<td><?php echo $row['password'];?></td>
								<td><?php echo $row['tpassword'];?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $row['address'];?></td>
								<td><?php echo $row['email'];?></td>
								<td><?php echo $row['mobile'];?></td>
								<td><?php echo $row['balance'];?></td>
								<td><?php echo $row['com_per'];?></td>
								<td  class="">
									<a href="addfranchise?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-info" title="Edit User"><i class="fa fa-pencil"></i> Edit</a>
									<a href="javascript:void(0);" title="Delete Franchise" class="DelFranchise btn btn-danger btn-xs" data-id="<?php echo $row['id'];?>"><i class="fa fa-trash"></i> Delete</a>
									
								</td>
							</tr><!--#31708F-->
						<?php 
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
<?php include("footer.php");?>
<div id="UserDeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Deactivation Note</h4>
            </div>

            <form id="DeactiveUser" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label>Deactivation Note*</label>
                                <div class="fancy-form">
                                    <textarea  placeholder = "Enter Reason For Deactivate" class = "form-control" name = "status_desc" id = "status_desc" title = "Enter Reason For Deactivate" row="8" required></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type ="hidden" name = "type" value="DeactivateUser">
                    <input type ="hidden" name = "id" id="userid" value="">
                    <input type="button"  id="formvalidate" data-form="DeactiveUser"  class="btn btn-info btn-md btn-submit"  value="Deactive User">
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>