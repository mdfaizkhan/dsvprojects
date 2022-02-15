<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>InActive Users</h1>  
	</header>
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>InActive Users</strong> <!-- panel title -->
					
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
								<!-- <td align="center"> <input type="checkbox" name="checkedall" id = "bump-offer" onClick = "check();"/></td> -->
								
								<!-- <th  class="">UID</th>
								<th  class="">SID</th> -->
								<th  class="">Username</th>
								<th  class="">Password</th>
								<th  class="">Trans Password</th>
								<th  class="">Name</th>
								<th  class="">Parent</th>
								<th  class="">Sponser</th>
								<th  class="">Welcome Letter</th>
								<!-- <th  class="">Plan</th>
								<th  class="">Bank Detail</th>
								<th  class="">Pan Card</th>
								<th  class="">Rank</th> -->
								<!-- <th  class="">Product</th> -->
								<th  class="">Wallet Balance</th>
								<th  class="">Rank</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
						$left=array();
                   		$right=array();
                       
						$sql=mysqli_query($db,"SELECT t1.uid as ttid,t1.*,t2.*,t3.parent_id,t3.sponsor_id,t4.first_name as pfname,t4.last_name as plname,t5.uname as puname,ub.bank_name,ub.acnumber from user_id t1 LEFT join user_detail t2 on t1.uid =t2.uid LEFT join user_bank ub on t1.uid=ub.uid join pairing t3 on t1.uid=t3.uid left join user_detail t4 on t3.sponsor_id=t4.uid left join user_id t5 on t3.sponsor_id=t5.uid where t1.role = 'user' AND t3.is_active=0 order by t1.uid");
						while($row = mysqli_fetch_assoc($sql))
						{	
							$uid1 = $row["ttid"];
							$r1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT t2.name as rank_name,t1.rank FROM `pairing` t1 left join rank_detail t2 on t1.`rank`= t2.id  where t1.uid='$uid1'"));

						?>
							<tr class="odd gradeX">
								<td><?php echo $i++; ?></td>
								<!-- <td align="center">
									<input type="checkbox" name="checked_id[]" class="checkbox" value="<?php //echo $row['uid']; ?>"/>
									
								</td> -->
								
								<!-- <td><?php echo $uid1;?></td>
								<td><?php echo $row['sponsor_id'];?></td> -->
								<td><?php echo $row['uname'];?></td>
								<td><?php echo $row['password'];?></td>
								<td><?php echo $row['tpassword'];?></td>
								<td><?php echo $row['first_name']." ".$row["last_name"];?></td>
								<td>
								    <?php
								        $sql1 = mysqli_query($db,"SELECT uname FROM user_id WHERE uid='$row[parent_id]'") or die(mysqli_error($db));
								        $row1 = mysqli_fetch_assoc($sql1);
								        echo $row1['uname'];
								    ?>
								</td>
								<td><?php echo $row['pfname']." ".$row["plname"]." (".$row["puname"].")";?></td>
								
								<td><a href="welcomeletter?id=<?php echo $row['uid']; ?>" target="_blank" class="btn btn-xs btn-success" title="Welcome Letter"><i class="fa fa-eye"></i> View</a> </td>
								<!-- <td><?php
								if(!empty($row['pin']))
								{
									$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from transpin t1 join plans t2 on t1.plan_id =t2.plan_id and t1.uid = '$uid1'"));
									echo $plan_amount=$q1['plan_amount'];
								}
								else
								{
									echo "--";
								}
								?></td> -->
								
								<!-- <td><?php if(isset($row['bank_name']) && !empty($row['bank_name']) && isset($row['acnumber']) && !empty($row['acnumber']))
										{ echo "YES"; } else { echo "NO"; } ?></td>
								<td><?php echo $row['pan_no'];?></td> -->
								
								<!-- <td>
									<?php if($row['prod_status'] == '0'){?>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-success ProductStatus" data-id="<?php echo $row['uid'];?>" data-value="1" title="Click To Receive Product"><i class="fa fa-check"></i> Receive</a>
                                    <?php } else {?>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger" data-id="<?php echo $row['uid'];?>" data-value="0" title="" disabled><i class="fa fa-check-square"></i> Received</a>
                                    <?php } ?>
								</td> -->
								<td><?php echo $row['balance'];?></td>
								<td>
									<?php
									$uids=$row['uid'];
									$try1=mysqli_query($db,"SELECT * FROM `userachieverank` WHERE uid=$uids ORDER BY rank_id desc limit 1"); 
									$tycount=mysqli_num_rows($try1);
									$ty=mysqli_fetch_assoc($try1);
									$ids=$ty['rank_id'];
									if($tycount>0){
									 $rows=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `rank_detail` WHERE id=$ids "));
									 echo $rows['name']; 
									}
									else{
									    if(!isset($r1['rank']) || empty($r1['rank']))
										{
											$chk_pur=IsDistributor($db,$uid1);
								            if($chk_pur > 0)
								            {
								                echo "Distributor";
								            }
										}
										else
										{
											echo $r1['rank_name'];
										}
									}									
									?>
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