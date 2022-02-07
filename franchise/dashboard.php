<?php include("header.php");?>
<?php
/*$usercount1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT * from `child_counter` where `uid` = $mlmid"));
$usercount=$usercount1['count'];
$totalcount=$usercount1['totalcount'];
$leftcount=$usercount1['leftcount'];
$rightcount=$usercount1['rightcount'];
$min_count=$usercount1['leftcount'];
if($rightcount < $leftcount)
{
    $min_count=$rightcount;
}
$plans = mysqli_num_rows(mysqli_query($db, "SELECT * from plans"));
$transpin = mysqli_num_rows(mysqli_query($db, "SELECT * from transpin"));
$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `user_id` WHERE `uid` = $mlmid"));
$q1 = mysqli_query($db, "SELECT t1.*,t2.first_name,t2.last_name,t3.uname FROM `pairing` t1 left join user_detail t2 on t1.sponsor_id=t2.uid left join user_id t3 on t1.sponsor_id=t3.uid WHERE t1.`uid` = $mlmid");
if(mysqli_num_rows($q1)>0)
{
    $r1 = mysqli_fetch_assoc($q1);
    $direct = $r1['first_name']." ".$r1['last_name']." (".$r1['uname'].")";
}
$userdtl = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `user_detail` WHERE `uid` = $mlmid"));
$upayment = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `direct_payment` WHERE `uid` = $mlmid"));
$payamount=isset($upayment['amount']) && !empty($upayment['amount'])?$upayment['amount']:0;
$binary_payout=$min_count*$plans['binary_com'];*/
/*if($user['pin'] == null || empty($user['pin'])){
    echo '<div id="pinVerify" class="modal fade in" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                
                <h4 class="modal-title">Enter Your Pin</h4>
              </div>
              <div class="modal-body">
                <div class="col-md-12">   
                    <input type="text" name="pin_no" id="pin_no" class="form-control" value="" autocomplete="off" autocomplete="false">
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info SubmitPinVerify">Submit</button>
              </div>
            </div>

          </div>
        </div>';
    echo '<script>var pin_assigned = true;</script>';
    include('footer.php');
    die;
}*/
if($usercount >= 5)
{
    $payamount+=isset($upayment['due_amount']) && !empty($upayment['due_amount'])?$upayment['due_amount']:0;
}
/*if($user['binary_activated']==1)
{
    $binary_status='Active';
}
else
{
    $binary_status='Inactive';
}*/
/*$rank = mysqli_fetch_assoc(mysqli_query($db,"SELECT t2.name as rank_name FROM `pairing` t1 left join rank_detail t2 on t1.`rank`= t2.id  where t1.uid='$mlmid' ORDER BY t2.id DESC limit 1"));


$pay = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uname,t1.uid,t2.first_name,t2.last_name,t2.pan_no,t3.*,(SELECT IFNULL(SUM(`gtb`),0) FROM `payout` WHERE  `uid` = t1.uid) as a,(SELECT IFNULL(SUM(`dsb`),0) FROM `payout` WHERE `uid` = t1.uid) as b from user_id t1 join user_bank t3 on t1.uid =t3.uid join user_detail t2 on t1.uid =t2.uid and t1.uid!=1 where t1.uid='$mlmid' order by t1.uid"));
$e=0;
$g=0;

$s=$pay['a']+$pay['b'];
$e = ($s*5/100);
$f = ($s*5/100);

$d = $e+$f;
$payout = $s-$d;*/
/*
$this_payout=$payamount+$binary_payout+$royalty_payout;

$sql1 = mysqli_query($db,"SELECT 
                        t1.pin,
                        t3.plan_amount,
                        sum(t4.comission_amount) as binary_amount,
                        sum(t4.bonus_amount) as bonus_amount,
                        sum(t4.roi_amount) as roi_amount,
                        t5.total_left_count,
                        t5.total_right_count
                        FROM user_id t1 
                        LEFT JOIN transpin t2 ON t2.pin_code=t1.pin
                        LEFT JOIN plans t3 ON t3.plan_id = t2.plan_id
                        LEFT JOIN payout t4 ON t4.uid = t1.uid  
                        LEFT JOIN child_counter t5 ON t5.uid = t1.uid
                        WHERE t1.uid='$mlmid' 
                        GROUP BY 
                        t1.pin,
                        t3.plan_id,
                        t5.total_left_count,
                        t5.total_right_count") or die(mysqli_error($db));
$row1 = mysqli_fetch_assoc($sql1);
$total_cleared_payout = $row1['binary_amount']+$row1['roi_amount']+$row1['bonus_amount'];
$total_left_count = $row1['total_left_count'];
$total_right_count = $row1['total_right_count'];
*/

/*$sql2 = mysqli_query($db,"SELECT (gtb+dsb) as payout_of_today FROM payout WHERE uid='$mlmid' AND cleared!='1'") or die(mysqli_error($db));
$row2 = mysqli_fetch_assoc($sql2);
$payout_of_today = $row2['payout_of_today'];
$admin_charge = 5;
$tds_charge = 5;

$total_payout_after_admin_charge = ($payout_of_today*$admin_charge)/100;
$total_payout_after_tds_charge = ($payout_of_today*$tds_charge)/100;
$total_deduction = $total_payout_after_admin_charge+$total_payout_after_tds_charge;
$payout_of_today = $payout_of_today-$total_deduction;

*/

?>
<section id="middle">
    <header id="page-header">
            <h1>Dashboard</h1>
            <a class="btn btn-info btn-xs pull-right" href="../index"><i class = "fa fa-undo"></i> Main Site</a>
            <a class="btn btn-info btn-xs pull-right" href="../product"><i class = "fa fa-undo"></i> Products</a>
    </header>
    <div id="content" class="dashboard padding-20">
        <div class="row"  style="display: none;">
            <div class ="col-md-6 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Profile Details</strong>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered bordered-squared">
                            
                            <tr>
                                <th>Username</th>
                                <td><?php echo $user['uname']; ?></td>
                            </tr>
                            <tr>
                                <th>Sponsor Name</th>
                                <td><?php echo $direct; ?></td>
                            </tr>
                            <tr>
                                <th>Plan</th>
                                <td><?php echo getplanprice($db,$mlmid); ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo $userdtl['first_name']." ".$userdtl['last_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $userdtl['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile No</th>
                                <td><?php echo $userdtl['mobile']; ?></td>
                            </tr>
                            <tr>
                                <th>Pan Card</th>
                                <td><?php echo $userdtl['pan_no']; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo $userdtl['address']; ?></td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo $userdtl['city']; ?></td>
                            </tr>
                            <tr>
                                <th>Zip</th>
                                <td><?php echo $userdtl['zip']; ?></td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td><?php echo $userdtl['state']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class ="col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="box info">
                            <div class="box-title">
                                <h4>Registered Date</h4>
                                <big class="block"><?php echo date('d/m/Y h:i:s A',strtotime($user['register_date'])); ?></big>
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6 col-sm-6">
                        <div class="box success">
                            <div class="box-title">
                                <h4> Plan Activated </h4>
                                <big class="block"><?php if(empty($row1['pin'])) {echo "No Active Plan"; } else { echo $row1['plan_amount']; } ?></big>
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div> -->
                
                    <!-- <div class="col-md-6 col-sm-6">
                        <div class="box danger">
                            <div class="box-title">
                                <h4>Direct Count</h4>
                                <big class="block"><?php echo $usercount; ?></big>
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6 col-sm-6">
                        <div class="box primary">
                            <div class="box-title">
                                <h4>Total Payout</h4>
                                <big class="block"><?php echo isset($total_cleared_payout) && !empty($total_cleared_payout)?number_format($total_cleared_payout,2):number_format(0,2); ?></big>
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                   <!--  <div class="col-md-6 col-sm-6">
                        <div class="box warning">
                            <div class="box-title">
                                <h4>Royalty Count </h4>
                                <big class="block"><?php echo $totalcount; ?></big>
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>  -->
                
                    <!-- <div class="col-md-6 col-sm-6">
                        <div class="box primary">
                            <div class="box-title">
                                <h4>Payout of Today</h4>
                                <big class="block"><?php echo number_format($payout_of_today,2); ?></big>
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-6 col-sm-6">
                        <div class="box info">
                            <div class="box-title">
                                <h4>Binary Status</h4>
                                <big class="block"><?php echo $binary_status; ?></big>
                                <i class="fa fa-sitemap"></i>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <?php
                        $left_users = GetUserByPos($db,$mlmid,'L');
                        $left_user_business = get_total_businesss($left_users);

                        $right_users = GetUserByPos($db,$mlmid,'R');
                        $right_user_business = get_total_businesss($right_users);

                        $left_green_id1 = getGreenId($left_users);
                        $right_green_id1 = getGreenId($right_users);

                        $left_red_id1 = getRedId($left_users);
                        $right_red_id1 = getRedId($right_users);
                    ?>
                    <div class="col-md-6 col-sm-6">
                        <div class="box info">
                            <div class="box-title">
                                <h4> Total Left Business </h4>
                                <big class="block"><?php echo number_format($left_user_business,2); ?></big>
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="box info">
                            <div class="box-title">
                                <h4> Total Right Business </h4>
                                <big class="block"><?php echo number_format($right_user_business,2); ?></big>
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="box danger">
                            <div class="box-title">
                                <h4>Unpaid Count</h4>
                                <big class="block"><?php echo $left_red_id1+$right_red_id1; ?></big>
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="box success">
                            <div class="box-title">
                                <h4> Paid Count </h4>
                                <big class="block"><?php echo $left_green_id1+$right_green_id1; ?></big>
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($user['binary_activated']==1){ ?>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="box success">
                            <div class="box-title">
                                <h4>Left Count</h4>
                                <big class="block"><?php echo $total_left_count; ?></big>
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="box danger">
                            <div class="box-title">
                                <h4>Right Count</h4>
                                <big class="block"><?php echo $total_right_count; ?></big>
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?> -->
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="box warning">
                            <div class="box-title">
                                <h4>My Rank</h4>
                                <big class="block"><?php echo isset($rank['rank_name']) && !empty($rank['rank_name'])?$rank['rank_name']:' '; ?></big>
                                <i class="fa fa-arrow-circle-down"></i>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
        <div class="row">
            <?php
                $i = 1;
                $sql=mysqli_query($db,"SELECT * FROM news order by date desc");
                while($row = mysqli_fetch_assoc($sql))
                {   
            ?>
            <div class="col-md-4 col-sm-12">
                <div id="panel-3" class="panel panel-info">
                    <div class="panel-heading">
                        <span class="elipsis">
                                <strong><?php echo $row['title'];?></strong>
                                <small><?php echo date("Y-m-d", strtotime($row['date']));?></small>
                        </span>
                    </div>          
                    <div class="panel-body">
                        <h6><?php echo $row['description'];?></h6>
                    </div>
                </div>
            </div>
            <?php } ?>
            
        </div>
  

<?php 
$fr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `franchise` WHERE `id`='$mlmid'"));
$com=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(total_commision) as com FROM `frenchise_com_list` WHERE `fid`='$mlmid'"));
?>

  <div class="row">
    <div class="col-md-3 col-sm-3">
        <div class="box info">
            <div class="box-title">
                <h4>Join Date</h4>
                <big class="block"><?php echo date('d/m/Y h:i:s A',strtotime($fr['date'])); ?></big>
                <i class="fa fa-calendar"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        <div class="box info">
            <div class="box-title">
                <h4>Commision Percentage</h4>
                <big class="block"><?php echo $fr['com_per']; ?>%</big>
                <i class="fa fa-inr"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        <div class="box info">
            <div class="box-title">
                <h4>Wallet Balance</h4>
                <big class="block"><?php echo $fr['balance']; ?></big>
                <i class="fa fa-inr"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        <div class="box info">
            <div class="box-title">
                <h4>Total Earn Commision</h4>
                <big class="block"><?php echo $com['com']; ?></big>
                <i class="fa fa-inr"></i>
            </div>
        </div>
    </div>
   </div>



  </div>
    </div>
</section>
<!-- /MIDDLE -->
			
<?php include("footer.php");?>