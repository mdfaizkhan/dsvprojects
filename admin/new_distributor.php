<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>New Distributor</h1>  
	</header>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>New Distributor List</strong> <!-- panel title -->
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
	                            <th  class="">User ID</th>
								<!-- <th  class="">Password</th> -->
								<th  class="">Name</th>
								<th  class="">Mobile No</th>
								<th  class="">State Name</th>
	                            <th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
						    $i = 1;
				            $sql1 = "SELECT t1.*,t2.*,t3.*,t4.uname as suname from pairing t1 join user_id t2 on t1.uid = t2.uid join user_detail t3 on t1.uid=t3.uid left join user_id t4 on t1.sponsor_id=t4.uid";
				            $query1 = mysqli_query($db,$sql1);
					        if(mysqli_num_rows($query1) > 0)
					        {
						        while($row = mysqli_fetch_assoc($query1))
			                    {
			                     $uid = $row["uid"];
			                     $sql_checkout=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `checkout` WHERE `uid`='$uid'"));
			                     if($sql_checkout==0){
			             ?>
			                        <tr class="odd gradeX">
			                            <td align="center">
			                                    <?php echo $i++;?>
			                            </td>
			                           <td><?php echo $row['uname'];?></td>
										<!-- <td><?php //echo $row['password'];?></td> -->
										<td><?php echo $row['first_name']." ".$row["last_name"];?></td>
										<td><?php echo $row['mobile'];?></td>
										<td><?php echo $row['state'];?></td>
										
			                            <td><?php echo date('d/m/Y',strtotime($row['date']));?></td>
			                            
			                           
			                        </tr><!--#31708F-->
			                    <?php 
			                     }
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