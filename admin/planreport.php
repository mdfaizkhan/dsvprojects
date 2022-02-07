<?php include("header.php");
if(isset($_POST['filter']))
{
	$plan_id = $_POST["plan"];
	 //$data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uname,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid left join transpin t3 on t1.uid=t3.uid left join plans t4 on t3.plan_id=t4.plan_id WHERE t4.plan_id = $plan_id"));
}
?>
			
<section id="middle">
	<header id="page-header">
		<h1>Plan Report</h1>  
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
                                <select class = "form-control select2" name = "plan" >
                                    <option value = "" selected disabled>Select Plan</option>
                                    <?php
                                    $sql=mysqli_query($db,"SELECT * FROM plans");
                                    while($row1 = mysqli_fetch_assoc($sql))
                                    {
                                        ?>
                                        <option value = "<?php echo $row1["plan_id"];?>"><?php echo $row1["plan_name"]." (".$row1["plan_amount"].")";?></option>
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
					<strong>Binary History <?php if(isset($data['uname'])) echo "[ ".$data["first_name"]." ".$data["last_name"]." (".$data["uname"].") ]";?></strong> <!-- panel title -->
				</span>
			</div>
			<!-- panel content -->
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
							<tr>
	                            <th align="center">ID</th>
	                            <th  class="">Plan Name</th>
	                            <th  class="">Plan Amount</th>
	                            <th  class="">User</th>
	                            <th  class="">Sponsor</th>
	                            <th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
						if(isset($_POST['filter']))
                        {
                        	$i=1;
							$sql = mysqli_query($db,"SELECT t4.*,t1.uname,t2.first_name,t2.last_name,t1.plan_date,t6.uname as suname FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid left join transpin t3 on t1.uid=t3.uid left join plans t4 on t3.plan_id=t4.plan_id left join pairing t5 on t1.uid=t5.uid left join user_id t6 on t5.sponsor_id=t6.uid WHERE t4.plan_id = $plan_id");
	                        while($row = mysqli_fetch_assoc($sql))
	                        {
		                    ?>
		                        <tr class="odd gradeX">
		                           <td align="center"><?php echo $i++;?></td>
		                           <td><?php echo $row['plan_name'];?></td>
		                           <td><?php echo $row['plan_amount'];?></td>
		                           <td><?php echo $row["first_name"]." ".$row["last_name"]." (".$row["uname"].")";?></td>
		                           <td><?php echo $row['suname'];?></td>
		                            <td><?php  echo modifyDate($row['plan_date']); ?></td>
									
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