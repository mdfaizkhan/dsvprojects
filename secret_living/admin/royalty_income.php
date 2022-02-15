<?php include("header.php");
if(isset($_POST['filter']))
{
	$user_id = $_POST["user"];
	 $data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uname,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid = $user_id"));
}
?>
			
<section id="middle">
	<header id="page-header">
		<h1>Royalty History</h1>  
	</header>
	<div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>Filter</strong> <!-- panel title -->
				</span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <form name="bulk_action" action="" method="post"/>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="fancy-form fancy-form-select">
                                <select class = "form-control select2" name = "user" >
                                    <option value = "" selected disabled>Select User</option>
                                    <?php
                                    
                                    $sql=mysqli_query($db,"SELECT t1.*,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid!=1");
                                    while($row1 = mysqli_fetch_assoc($sql))
                                    {
                                        ?>
                                        <option value = "<?php echo $row1["uid"];?>"><?php echo $row1["first_name"]." ".$row1["last_name"]." (".$row1["uname"].")";?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-info" name="filter" value="Submit"/>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Royalty History</strong> <!-- panel title -->
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
								<th  class="">User</th>
								<th  class="">Slab Name</th>
								<th  class="">Business Required</th>
	                            <th  class="">Total Business</th>
	                            <th  class="">Required Purchase</th>
	                            <th  class="">Required Directs</th>
	                            <th  class="">Directs</th>
	                            <th  class="">Total Income</th>
	                            <th  class="">Credit Income</th>
	                            <th  class="">Remaining Income</th>
							</tr>
						</thead>

						<tbody>
						<?php
						if(isset($_POST['filter']) && !empty($user_id))
                        {
                        	$i=1;
                        	$r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.totalcount,t2.count FROM `bonus` t1 left join child_counter t2 on t1.uid=t2.uid where t1.uid='$user_id'"));
							$sql = mysqli_query($db,"SELECT * FROM `rpayout_detail` order by id desc");
	                        while($row = mysqli_fetch_assoc($sql))
	                        {
	                        	
	                        	
	                        	$col_name="amount".$row['id'];
		                    ?>
		                        <tr class="odd gradeX">
		                           <td align="center"><?php echo $i++;?></td>
		                           <td><?php echo $data["first_name"]." ".$data["last_name"]." (".$data["uname"].")";?></td>
		                           <td><?php echo "Slab ".$row['id'];?></td>
		                           <td><?php echo $row['mem_count'];?></td>
		                           <td><?php echo $r1['totalcount'];?></td>
		                           <td><?php echo $row['repurchase'];?></td>
		                           <td><?php echo $row['direct_count'];?></td>
		                           <td><?php echo $r1['count'];?></td>
		                            <td><?php  echo $row['capping']; ?></td>
		                            <td><?php  echo $r1[$col_name]; ?></td>
		                            <td><?php  echo $row['capping']-$r1[$col_name]; ?></td>
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