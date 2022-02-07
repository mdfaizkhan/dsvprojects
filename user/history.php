<?php include("header.php");
if(isset($_POST['filter']))
{
	//$user_id = $_POST["user"];
	$ptype = $_POST["ptype"];
	 
}
$data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uname,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid = $mlmid"));
?>
			
<section id="middle">
	<header id="page-header">
		<h1>History</h1>  
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
                        <div class="col-md-4">
                            
                        	<select class = "form-control select2" name = "ptype" required>
                            <option value = "" selected disabled>Select Type</option>
                            <option value = "gtb" <?php echo isset($ptype) && $ptype=='gtb'?'selected':'';  ?>>Group Turnover Bonus</option>
                            <option value = "dsb" <?php echo isset($ptype) && $ptype=='dsb'?'selected':'';  ?>>Direct Sponsor Bonus</option>
                            <option value = "eb" <?php echo isset($ptype) && $ptype=='eb'?'selected':'';  ?>>Executive Bonus</option>
                            <option value = "db" <?php echo isset($ptype) && $ptype=='db'?'selected':'';  ?>>Director Bonus</option>
                            <option value = "sdb" <?php echo isset($ptype) && $ptype=='sdb'?'selected':'';  ?>>Silver Director Bonus</option>
                            <option value = "gdb" <?php echo isset($ptype) && $ptype=='gdb'?'selected':'';  ?>>Gold Bonus</option>
                            <option value = "ddb" <?php echo isset($ptype) && $ptype=='ddb'?'selected':'';  ?>>Diamond Director Bonus</option>
                            <option value = "award" <?php echo isset($ptype) && $ptype=='award'?'selected':'';  ?>>Award	&	Reward	</option>
                           
                        </select>
                            
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
					<strong><?php echo isset($ptype)?$ptype:''; ?> History <?php if(isset($data['uname'])) echo "[ ".$data["first_name"]." ".$data["last_name"]." (".$data["uname"].") ]";?></strong> <!-- panel title -->
				</span>
			</div>
			<!-- panel content -->
			
			<div class="panel-body ">
				<?php if(isset($_POST['ptype']) && $_POST['ptype']=='gtb'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">GTB Point</th>
		                            <!--<th  class="">Turnover</th>-->
		                            <!--<th  class="">Total PV</th>-->
		                            <!--<th  class="">Percentage</th>-->
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username FROM `gtb_history` t1 left join user_id t2 on t1.uid=t2.uid where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           <td><?php echo $row['gtb_point'];?></td>
			                           <!--<td><?php echo $row['total_turnover'];?></td>-->
			                           <!--<td><?php echo $day=$row['total_pv'];?></td>-->
			                           <!--<td><?php echo $row['perc'];?></td>-->
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else if(isset($_POST['ptype']) && $_POST['ptype']=='dsb'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">Bonus Point</th>
		                            <!--<th  class="">Turnover</th>-->
		                            <!--<th  class="">Total PV</th>-->
		                            <!--<th  class="">Percentage</th>-->
		                            <!-- <th  class="">Left BV</th>
		                            <th  class="">Right BV</th> -->
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username FROM `dsb_history` t1 left join user_id t2 on t1.uid=t2.uid where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           <td><?php echo $row['bonus_point'];?></td>
			                           <!--<td><?php echo $row['total_turnover'];?></td>-->
			                           <!--<td><?php echo $day=$row['total_pv'];?></td>-->
			                           <!--<td><?php echo $row['perc'];?></td>-->
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else if(isset($_POST['ptype']) && $_POST['ptype']=='eb'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">Bonus Point</th>
		                            <!--<th  class="">Turnover</th>-->
		                            <!--<th  class="">Total PV</th>-->
		                            <!--<th  class="">Percentage</th>-->
		                            <!-- <th  class="">Left BV</th>
		                            <th  class="">Right BV</th> -->
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username FROM `eb_history` t1 left join user_id t2 on t1.uid=t2.uid where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           <td><?php echo $row['bonus_point'];?></td>
			                           <!--<td><?php echo $row['total_turnover'];?></td>-->
			                           <!--<td><?php echo $day=$row['total_pv'];?></td>-->
			                           <!--<td><?php echo $row['perc'];?></td>-->
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else if(isset($_POST['ptype']) && $_POST['ptype']=='db'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">Bonus Point</th>
		                            <!--<th  class="">Turnover</th>-->
		                            <!--<th  class="">Total PV</th>-->
		                            <!--<th  class="">Percentage</th>-->
		                            <!-- <th  class="">Left BV</th>
		                            <th  class="">Right BV</th> -->
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username FROM `db_history` t1 left join user_id t2 on t1.uid=t2.uid where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           <td><?php echo $row['bonus_point'];?></td>
			                           <!--<td><?php echo $row['total_turnover'];?></td>-->
			                           <!--<td><?php echo $day=$row['total_pv'];?></td>-->
			                           <!--<td><?php echo $row['perc'];?></td>-->
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else if(isset($_POST['ptype']) && $_POST['ptype']=='sdb'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">Bonus Point</th>
		                            <!--<th  class="">Turnover</th>-->
		                            <!--<th  class="">Total PV</th>-->
		                            <!--<th  class="">Percentage</th>-->
		                            <!-- <th  class="">Left BV</th>
		                            <th  class="">Right BV</th> -->
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username FROM `sdb_history` t1 left join user_id t2 on t1.uid=t2.uid where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           <td><?php echo $row['bonus_point'];?></td>
			                           <!--<td><?php echo $row['total_turnover'];?></td>-->
			                           <!--<td><?php echo $day=$row['total_pv'];?></td>-->
			                           <!--<td><?php echo $row['perc'];?></td>-->
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else if(isset($_POST['ptype']) && $_POST['ptype']=='gdb'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">Bonus Point</th>
		                            <!--<th  class="">Turnover</th>-->
		                            <!--<th  class="">Total PV</th>-->
		                            <!--<th  class="">Percentage</th>-->
		                            <!-- <th  class="">Left BV</th>
		                            <th  class="">Right BV</th> -->
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username FROM `gdb_history` t1 left join user_id t2 on t1.uid=t2.uid where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           <td><?php echo $row['bonus_point'];?></td>
			                           <!--<td><?php echo $row['total_turnover'];?></td>-->
			                           <!--<td><?php echo $day=$row['total_pv'];?></td>-->
			                           <!--<td><?php echo $row['perc'];?></td>-->
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else if(isset($_POST['ptype']) && $_POST['ptype']=='ddb'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">Bonus Point</th>
		                            <!--<th  class="">Turnover</th>-->
		                            <!--<th  class="">Total PV</th>-->
		                            <!--<th  class="">Percentage</th>-->
		                            <!-- <th  class="">Left BV</th>
		                            <th  class="">Right BV</th> -->
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username FROM `ddb_history` t1 left join user_id t2 on t1.uid=t2.uid where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           <td><?php echo $row['bonus_point'];?></td>
			                           <!--<td><?php echo $row['total_turnover'];?></td>-->
			                           <!--<td><?php echo $day=$row['total_pv'];?></td>-->
			                           <!--<td><?php echo $row['perc'];?></td>-->
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else if(isset($_POST['ptype']) && $_POST['ptype']=='award'){ ?>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
							<thead>
								<tr>
		                            <th align="center">ID</th>
		                            <th  class="">User</th>
		                            <th  class="">Rank</th>
		                            <th  class="">PV</th>
		                            
		                            <th  class="">Amount</th>
		                            <th  class="">Date</th>
								</tr>
							</thead>

							<tbody>
							<?php
							if(isset($_POST['filter']))
	                        {
	                        	$i=1;
	                        	$sql = mysqli_query($db,"SELECT t1.*,t2.uname as username ,t3.name as rank FROM `reward_history` t1 left join user_id t2 on t1.uid=t2.uid left join rank_detail t3 on t1.rank_id=t3.id where t1.uid='$mlmid'");
								
		                        while($row = mysqli_fetch_assoc($sql))
		                        {
			                    ?>
			                        <tr class="odd gradeX">
			                           <td align="center"><?php echo $i++;?></td>
			                           <td><?php echo $row['username'];?></td>
			                           <td><?php echo $row['rank'];?></td>
			                           <td><?php echo $row['pv'];?></td>
			                           
			                           <td><?php echo $row['amount'];?></td>
			                            <td><?php  echo modifyDateTime($row['date']); ?></td>
			                            
										
			                        </tr>
		                    <?php
			                     } 
		                     }
		                     ?>    
							</tbody>
						</table>
					</div>
				<?php }
				else { ?>
				<label class="alert alert-danger col-md-12">Select Payout Type !</label>
				<?php } ?>
			</div>
			
			<!-- /panel content -->

		</div>
	</div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>