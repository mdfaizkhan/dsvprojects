<?php include("header.php");
$data=mysqli_fetch_assoc(mysqli_query($db,"select * from plans"));
$amounts=json_decode($data['level_perc']);
if(isset($_POST['filter']))
{
	$user_id = $_POST["user"];
	 $data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uname,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid = $user_id"));
}
?>
			
<section id="middle">
	<header id="page-header">
		<h1>Downline Income</h1>  
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
					<strong>Downline Income [<?php echo isset($data["first_name"])? $data["first_name"]." ".$data["last_name"]." (".$data["uname"].")":'' ?>]</strong> <!-- panel title -->
				</span>
				<!-- <a href="addusers" class="opt pull-right"><i class = "fa fa-plus"></i></a> -->
			</div>
			<!-- panel content -->
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover " id="">
						<thead>
						  <tr>
							<tr>
	                            <th align="center"> Level</th>
								<th  class="">Count</th>
	                            <th  class="">Income</th>
							</tr>
						</thead>

						<tbody>
						<?php
						if(isset($_POST['filter']))
                        {
							for ($i=0; $i < 7; $i++) {
								$j=$i+1; 
								if($i==0)
								{
									$res=GetUids($db,$user_id);
									$uids_str=implode(',', $res);
									$sql1= "SELECT sum(`amount`) as amount FROM `child_earning` where parent_id='$user_id' and FIND_IN_SET(`uid`,'$uids_str')";
									$q1=mysqli_query($db,$sql1);
									$r1=mysqli_fetch_assoc($q1);

								}
								else
								{
									$res1=GetUids($db,$user_id);
									$funname="getLevel$j";
									$res=$funname($db,$res1);
									$uids_str=implode(',', $res);
									$sql1= "SELECT sum(`amount`) as amount FROM `child_earning` where parent_id='$user_id' and FIND_IN_SET(`uid`,'$uids_str')";
									$q1=mysqli_query($db,$sql1);
									$r1=mysqli_fetch_assoc($q1);

								}
								$ucount=count($res);
		                    ?>
		                        <tr class="odd gradeX">
		                            <td align="center">
		                                    <?php echo "Level ".$j;?>
		                            </td>
		                           <td><?php  echo $ucount ?></td>
		                           <td><?php echo isset($r1['amount']) && !empty($r1['amount'])?$r1['amount']:0;?></td>
									
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