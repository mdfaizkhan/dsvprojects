<?php include("header.php");
if(isset($_POST['filter']))
{
	$user_id = $_POST["user"];
	 $data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uname,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid = $user_id"));
}
?>
<section id="middle">
	<header id="page-header">
		<h1>Rank Report</h1>  
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
					<strong>Rank Report [<?php echo $data["first_name"]." ".$data["last_name"]." (".$data["uname"].")";?>]</strong> <!-- panel title -->
				</span>
			</div>
			<!-- panel content -->
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover " id="">
						<thead>
						  <tr>
							<tr>
	                            <th align="center">ID</th>
								<th  class="">Rank Name</th>
								<th  class="">Required Team A BV</th>
								<th  class="">Required Team B BV</th>
								<th  class="">Actual Team A BV</th>
								<th  class="">Actual Team B BV</th>
								<th  class="">Amount</th>
								<th  class="">Date</th>
								
							</tr>
						</thead>

						<tbody>
						<?php
						if(isset($_POST['filter']))
                        {
                        	$i=1;
                        	$j=0;
                        	$check=0;
                        	$r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT uleftcount,urightcount FROM child_counter where uid='$user_id'"));
							$sql = mysqli_query($db,"SELECT * FROM `rank_detail` order by id");
	                        while($row = mysqli_fetch_assoc($sql))
	                        {
	                        	$left=0;
                           		$right=0;

	                        	if($r1['uleftcount'] >=$row['leftcount'] && $r1['urightcount'] >=$row['rightcount'])
	                           	{
	                           		$left=$row['leftcount'];
	                           		$right=$row['rightcount'];
	                           	}
	                           	else if($check==0)
	                           	{
	                           		$left=$r1['uleftcount'];
	                           		$right=$r1['urightcount'];
	                           		$check=1;
	                           		/*if($r1['uleftcount'] >=$row['leftcount'])
		                           	{
		                           		$left=$row['leftcount'];
		                           	}
		                           	else if($r1['urightcount'] >=$row['rightcount'])
		                           	{
		                           		$left=$row['rightcount'];
		                           	}*/
	                           		
	                           	}
	                           	$rank_name=$row['name'];
	                           	$rq=mysqli_query($db,"SELECT * FROM `rank_payout` where `rank`='$rank_name' and uid='$user_id'");
                           		$rr1=mysqli_fetch_assoc($rq);
	                        	
		                    ?>
		                        <tr class="odd gradeX">
		                           <td align="center"><?php echo $i++; ?></td>
		                           <td><?php echo $rank_name;?></td>
		                           <td><?php echo $row['leftcount'];?></td>
		                           <td><?php echo $row['rightcount'];?></td>
		                           <td>
		                           	<?php echo $left; ?>
		                           </td>
		                           <td>
		                           	<?php echo $right; ?>
		                           	</td>
		                           	<td><?php echo $rr1['amount']; ?></td>
									<td><?php echo isset($rr1['date']) && !empty($rr1['date'])?date('d/m/Y',strtotime($rr1['date'])):'';?></td>
		                        </tr>
	                    <?php
	                    	$j++;
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