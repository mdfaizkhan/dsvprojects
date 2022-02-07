<?php include("header.php");?>
			
<section id="middle">
	<header id="page-header">
		<h1>Purchased Member</h1>  
	</header>
	<div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>Position</strong> <!-- panel title -->
				</span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <form name="bulk_action" action="" method="post"/>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="fancy-form fancy-form-select">
                                <select class = "form-control select2" name = "pos" >
                                    <option value = "L" <?php echo isset($_POST['pos']) && $_POST['pos']=='L'?'selected':''; ?>>Left</option>
                                    <option value = "R" <?php echo isset($_POST['pos']) && $_POST['pos']=='R'?'selected':''; ?>>Right</option>
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
					<strong>Purchased Member List</strong> <!-- panel title -->
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
	                            <th  class="">Username</th>
								<!-- <th  class="">Password</th> -->
								<th  class="">Name</th>
								<th  class="">Sponsor</th>
								<th  class="">Email</th>
								<th  class="">Mobile</th>
								<th  class="">State</th>
								<th  class="">Package</th>
								<th  class="">Rank</th>
	                            <th  class="">Date</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
						if(isset($_POST['pos']) && !empty($_POST['pos']))
						{
							$pos=$_POST['pos'];
							$users = GetUserByPos($db,$mlmid,$pos);
						}
						else
						{
							$users = GetUserByPos($db,$mlmid,'L');
						}
						//var_dump($users);
						if(!empty($users[0])){
				            $uids = "'".implode("','",$users)."'";
				            $sql1 = "SELECT t1.*,t2.*,t3.*,t4.uname as suname from pairing t1 join user_id t2 on t1.uid = t2.uid join user_detail t3 on t1.uid=t3.uid left join user_id t4 on t1.sponsor_id=t4.uid  WHERE t1.uid IN($uids)";
				            $query1 = mysqli_query($db,$sql1);
				            
				        
					        if(mysqli_num_rows($query1) > 0)
					        {
						        while($row = mysqli_fetch_assoc($query1))
			                    {
			                        
			                        $uid1 = $row["uid"];
            						  $check_purchased=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `checkout` WHERE `uid`='$uid1'"));
            						  if($check_purchased==1){
			                    
			                    ?>
			                        <tr class="odd gradeX">
			                            <td align="center">
			                                    <?php echo $i++;?>
			                            </td>
			                           <td><?php echo $row['uname'];?></td>
										<!-- <td><?php //echo $row['password'];?></td> -->
										<td><?php echo $row['first_name']." ".$row["last_name"];?></td>
										<td><?php echo $row['suname'];?></td>
										<td><?php echo $row['email'];?></td>
										<td><?php echo $row['mobile'];?></td>
										<td><?php echo $row['state'];?></td>
										<!--<td><a href="welcomeletter?id=<?php echo $row['uid']; ?>" target="_blank" class="btn btn-xs btn-success" title="Welcome Letter"><i class="fa fa-eye"></i> View</a> </td>-->
										<td><?php
										if(!empty($row['pin']))
										{
											$uid = $row["uid"];
											$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from transpin t1 join plans t2 on t1.plan_id =t2.plan_id and t1.uid = '$uid'"));
											echo $q1['plan_amount'];
										}
										else
										{
											echo "--";
										}
										?></td>	
										<td>
										    <?php   
										    $uids=$row['uid'];
										    $r1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT t2.name as rank_name,t1.rank FROM `pairing` t1 left join rank_detail t2 on t1.`rank`= t2.id  where t1.uid='$uids'"));
										        $try1=mysqli_query($db,"SELECT * FROM `userachieverank` WHERE uid=$uids ORDER BY rank_id desc limit 1"); 
								                $tycount=mysqli_num_rows($try1);
										        $ty=mysqli_fetch_assoc($try1);
									            $ids=$ty['rank_id'];
            									if($tycount>0){
            									 $rows=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `rank_detail` WHERE id=$ids "));
            									 echo $rows['name']; 
            									}
            									else{
            									    if(!isset($r1['achieve_rank']) || empty($r1['achieve_rank']))
            										{
            											$chk_pur=IsDistributor($db,$uids);
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
			                            <td><?php echo date('d/m/Y',strtotime($row['date']));?></td>
			                            
			                            
			                        </tr><!--#31708F-->
			                    <?php 
			                    }
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