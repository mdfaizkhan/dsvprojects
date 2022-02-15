<?php include("header.php");?>
<?php

$usercount1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT count(uid) as `totalcount` FROM `user_id` WHERE  `uid` !='1'"));
$usercount = $usercount1['totalcount'];
$plans = mysqli_num_rows(mysqli_query($db, "SELECT * from plans"));
$transpin = mysqli_num_rows(mysqli_query($db, "SELECT * from transpin WHERE uid='$mlmid'"));

$my_pack_details=mysqli_fetch_assoc(mysqli_query($db,"SELECT transpin.*,plans.*,packages.* FROM transpin inner join plans plans on transpin.plan_id=plans.plan_id inner join packages on packages.id=plans.pack_id WHERE transpin.uid='$mlmid'"));

$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `user_id` WHERE `uid` = $mlmid"));
$q1 = mysqli_query($db, "SELECT t1.*,t2.first_name,t2.last_name,t3.uname FROM `pairing` t1 left join user_detail t2 on t1.parent_id=t2.uid left join user_id t3 on t1.parent_id=t3.uid WHERE t1.`uid` = $mlmid"); 
if(mysqli_num_rows($q1)>0)
{
    $r1 = mysqli_fetch_assoc($q1);
    $direct = $r1['first_name']." ".$r1['last_name']." (".$r1['uname'].")";
}
else
{
    $direct="Admin";
}
$userdtl = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `user_detail` WHERE `uid` = $mlmid"));
$admin_charge = 5;
$tds_charge = 5;


$sql1 = mysqli_query($db,"SELECT IFNULL(sum(level_comm),0) as level_comm, IFNULL(sum(direct_sponsor_comm),0) as direct_sponsor_comm , IFNULL(sum(double_pairing_bonus),0) as double_pairing_bonus FROM payout WHERE cleared !='1' and `uid`='$mlmid'") or die(mysqli_fetch_assoc($db));
$row1 = mysqli_fetch_assoc($sql1);
$total_payout = $row1['level_comm']+$row1['direct_sponsor_comm']+$row1['double_pairing_bonus'];


$total_payout_after_admin_charge = ($total_payout*5)/100;
$total_payout_after_tds_charge = ($total_payout*5)/100;

$total_payout = $total_payout-($total_payout_after_admin_charge+$total_payout_after_tds_charge);


$sql0 = mysqli_query($db,"SELECT IFNULL(sum(level_comm),0) as level_comm, IFNULL(sum(direct_sponsor_comm),0) as direct_sponsor_comm , IFNULL(sum(double_pairing_bonus),0) as double_pairing_bonus FROM payout where `uid`='$mlmid'") or die(mysqli_fetch_assoc($db));
$row0 = mysqli_fetch_assoc($sql0);
$all_payout = $row1['level_comm']+$row1['direct_sponsor_comm']+$row1['double_pairing_bonus'];


$all_payout_after_admin_charge = ($all_payout*5)/100;
$all_payout_after_tds_charge = ($all_payout*5)/100;

$all_payout = $all_payout-($all_payout_after_admin_charge+$all_payout_after_tds_charge);

$pvs=mysqli_query($db,"select * from child_counter where uid='$mlmid'");
$pvs1= mysqli_fetch_assoc($pvs);
$left_pv=$pvs1['left_pv'];
$right_pv=$pvs1['right_pv'];
$rright_pv=$pvs1['rright_pv'];
$rleft_pv=$pvs1['rleft_pv'];

$Joinings = mysqli_query($db,"select year(register_date),month(register_date),COUNT(*) from `user_id` WHERE register_date group by month(register_date)");
 
 $data=[];
 $m_name=[];
 while($week=mysqli_fetch_array($Joinings)){
   $year='20'.date("y");
   $years=$week['year(register_date)'];
   if($years>=$year)
   {
      array_push($data,$week['COUNT(*)']);
      $month_name = date("F", mktime(0, 0, 0, $week['month(register_date)'], 10));
      array_push($m_name,$years.' '.$month_name);
   }
 }
 
 $datas=json_encode($data);
 $m_name=json_encode($m_name);

 $order = mysqli_query($db,"select count(user) as count from `checkout` where uid='$mlmid'");

 $ordercounts=mysqli_fetch_assoc($order);

 $my_left_user=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` where `parent_id`='$mlmid' and `position`='L'"));
 $my_right_user=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` where `parent_id`='$mlmid' and `position`='R'"));
 $leftUserID= $my_left_user['uid'];
 $rightUserID= $my_right_user['uid'];



 // if($pvs['total_left_count'])

 //  $minimumchild='';
 //  if($leftcount > $rightcount)
 //  {
 //      $minimumchild=$rightcount;
 //  }
 //  else if($leftcount < $rightcount)
 //  {
 //      $minimumchild=$leftcount;
 //  }
 //  else if($leftcount == $rightcount)
 //  {
 //      $minimumchild=$leftcount-1;
 //  }

?>
<!-- 
        MIDDLE 
-->
<section id="middle">
   <!-- main header -->
   <div class="bg-light lter b-b wrapper-md new-title-section">                 
      <div class=" row">
         <div class="m-n font-thin h3">Overview  <a href="../index" class="btn m-b-xs btn-sm btn-primary add-btn" style="float: right;">Go To Home</a></div>
         
      </div>
   </div>
   <!-- / main header -->
      <div id="content" class="dashboard padding-20">
         <div class="row">
            <div class="col-lg-5 col-md-12 padding-zero">
               <div class="col-lg-12 col-md-12" id="section_tile">
                  <div class="row row-sm text-center">
                     <!-- Ewallet -->
                     <div class="col-xs-12 col-sm-6  col-lg-6" id="section_tile1">
                        <div class="box">
                           <a href="#">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">My Wallet Balance</span>
                                 <div class="h1  font-thin h1"> <?php echo $user['balance']; ?></div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <!-- Ewallet end -->
                     <!-- Commission earned -->
                     <div class="col-xs-12 col-sm-6  col-lg-6 " id="section_tile1">
                        <div class="box1">
                           <a href="order">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">My Orders</span>
                                 <div class="h1  font-thin h1" id="total_commission">
                                    <?php echo $ordercounts['count'] ?>
                                 </div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <!-- Commission earned end -->
                     <!-- Payout released -->
                     <div class="col-xs-12 col-sm-6  col-lg-6" id="section_tile3">
                        <div class="box2">
                         
                           <a href="">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">Repurchase</span>
                                 <div class=" font-thin h1 block1" id="total_payout"> 0 </div>
                              </div>
                           </a>
                        </div>
                     </div>

                     <!-- Payout released end -->
                     <!-- Payout pending -->
                     <div class="col-xs-12 col-sm-6 col-lg-6" id="section_tile4">
                        <div class="box3">
                           <a href="">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">Reward</span>
                                 <div class="font-thin  h1" id="mail_total">0</div>
                              </div>
                           </a>
                        </div>
                     </div>

                     <!-- Payout pending end -->
                     <!--END DONATION TILE-->
                  </div>
               </div>
            </div>
            <div class="col-lg-7 col-md-12">
               <div class="graph-profile-grid padding-zero">
                  <!-- Profile/Promotion -->
                  <div class="panel item">
                     <div class="userprof-top profile_user">
                        <div class="panel-body profile-section">
                           <div class="dashbord-profile">
                              <div class="profile-avatar">
                                 <img class="" src="../new_assets/uploads/images/tree/tree_96353712.jpg">
                                 <h3 class="profile-name full_name" title="<?php echo $userdtl['first_name']." ".$userdtl['last_name']; ?>" >
                                    <?php echo $userdtl['first_name']." ".$userdtl['last_name']; ?>
                                 </h3>
                                 <h5 class="profile-name2 user_name2"><?php echo $user['uname']; ?></h5>
                                 <h5 class="profile-name2 user_name2">Package : <strong><?= $my_pack_details['plan_name'] ?></strong></h5>
                                 <a href="profile"  class="btn btn-info btn-md btn-submit">View Profile</a>
                             
                              </div>
                           </div>
                        </div>
                        <!-- Start Promotion Tools html  -->
                        <div class="Promotion-Tools" >
                           <div class="row">
                              <label class="col-sm-12">Referral link *</label>
                              <div class="col-md-9 col-sm-9">
                                 <div class="fancy-form"><!-- input -->
                                     <input type="text"  class="form-control" id ="referrallink" value="<?php echo "http://" . $_SERVER['SERVER_NAME'] .'/secret_living/register?username='.$user['uname']  ?>" >
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-3">
                                 <label> </label>
                                 <button type="submit" name ="update"  class="btn btn-info btn-md btn-submit" onclick="copyFunction()">Copy</button>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                        </div>
                        <!-- Close Promotion Tools html -->
                     </div>
                  </div>
                  <!-- Profile/Promotion end -->
               </div>
            </div>
               <div class="col-lg-12 col-md-12" id="section_tile">
                  <div class="row row-sm text-center">
                     <!-- Ewallet -->
                     <div class="col-xs-12 col-sm-3  col-lg-3" id="section_tile1">
                        <div class="box">
                           <a href="https://backoffice.infinitemlmsoftware.com/backoffice/user/ewallet">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">Total Payout</span>
                                 <div class="h1  font-thin h1"> <?php echo number_format($all_payout,2); ?></div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <!-- Ewallet end -->
                     <!-- Commission earned -->
                     <div class="col-xs-12 col-sm-3  col-lg-3 " id="section_tile1">
                        <div class="box1">
                          
                           <a href="https://backoffice.infinitemlmsoftware.com/backoffice/user/ewallet">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">Balance Amount</span>
                                 <div class="h1  font-thin h1" id="total_commission">
                                    <?php echo number_format($total_payout,2); ?>
                                 </div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <!-- Commission earned end -->
                     <!-- Payout released -->
                     <div class="col-xs-12 col-sm-3  col-lg-3" id="section_tile3">
                        <div class="box2">
                         
                           <a href="">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">Current Left PV</span>
                                 <div class=" font-thin h1 block1" id="total_payout"> <?php echo isset($left_pv)?$left_pv:0; ?> </div>
                              </div>
                           </a>
                        </div>
                     </div>

                     <!-- Payout released end -->
                     <!-- Payout pending -->
                     <div class="col-xs-12 col-sm-3 col-lg-3" id="section_tile4">
                        <div class="box3">
                           <a href="">
                              <div class="panel shadow padder-v item lg-panel">
                                 <span class="text-muted">Current Right PV</span>
                                 <div class="font-thin  h1" id="mail_total"><?php echo isset($right_pv)?$right_pv:0; ?></div>
                              </div>
                           </a>
                        </div>
                     </div>

                     <!-- Payout pending end -->
                     <!--END DONATION TILE-->
                  </div>
               </div>
                     <div class="col-lg-12 ">
                        <div class="panel-body panel">
                           <!-- referal-link -->
                           <!-- Lead Capture-link -->
                           <div class="user-det">
                              <div class=" grid  grid-four  grid_three">
                                 <div class="sponsor-details vertical_line">
                                    <span class="extra_data_title">Sponsor Name</span>
                                    <div class="extra_data"><?=$direct?></div>
                                 </div>
                                 <div class="sponsor-details vertical_line">
                                    <div class="sponsor-details-icon">
                                       <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                    </div>
                                    <span class="extra_data_title">Total Repurchase Left PV</span>
                                    <div class="extra_data"><?=$rleft_pv?></div>
                                 </div>   
                                 <div class="sponsor-details vertical_line">
                                      <div class="sponsor-details-icon">
                                       <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                    </div>
                                      <span class="extra_data_title">Total Repurchase Right PV</span>
                                      <div class="extra_data"><?=$rright_pv?></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                    <div class="col-lg-5 col-md-12" id="section_tile"> 
            <div class="new-members panel">   
               <h4>New members</h4>   
               <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><div ui-jq="slimScroll" style="overflow: hidden; width: auto; height: 250px;">
                  <ul class="list-group list-group-lg no-bg auto">
                    <?php 
                          $user_detail12 = mysqli_query($db, "SELECT * from user_detail INNER JOIN user_id ON user_detail.uid=user_id.uid ORDER BY user_id.uid DESC limit 5"); 
                          while($rowdata=mysqli_fetch_array($user_detail12))
                          {
                    ?> 
                     <li class="list-group-item clearfix no-shadows">   
                        <div class="col-lg-12 padding-15">
                           <div class="col-lg-2 col-xs-2 padding-zero ">  
                              <span class="thumb-sm avatar ">   
                                 <img src="https://backoffice.infinitemlmsoftware.com/uploads/images/profile_picture/nophoto.jpg">  
                                 <i class="on b-white bottom"></i>   
                              </span>   
                           </div> 
                           <div class="col-lg-10 col-xs-10 padding-zero"> 
                             <div class="col-lg-8 pull-left">  
                                 <div class="member-full-name"><?php echo $rowdata['first_name'].' '.$rowdata['last_name'];?></div>   
                                 <span class="member-user-name"><?php echo $rowdata['uname'];?></span>
                             </div> 
                             <div class="col-lg-4 pull-right padding-zero">   
                                 <div class="member-package"> 
                                    <small class="text-msuted clear text-ellipsis" style="font-weight: 300;"><?php
                                    echo date('d-M-Y', strtotime($rowdata['register_date']));
                                    ?>
                                       
                                    </small>   
                                 </div>   
                              </div> 
                           </div>                            
                        </div>   
                     </li>   
                    <?php }?>           
                  </ul>
               </div>
               <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 250px;"></div>
               <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
            </div>                     
         </div>            
      </div>
      <div class="col-lg-7 col-md-12">
                    <div class="panel hbox hbox-auto-xs no-border member_joinings-graph">
                        <div class="col wrapper ">
                           
                            <h4 class="font-thin m-t-none m-b-none">Joinings</h4>
                            <span class="m-b block text-sm text-muted"></span>
                            <canvas id="join_chart" style="height: 263px; width: 100%"></canvas>
                        </div>
                    </div>
                </div>          
                  </div>


        <div class="row">
          <div class="col-md-12">
         <div class="dashbord-tab-section">
            <div class="panel dashbord-tab">
               <div class="wrapper"><h4 class="font-thin m-t-none m-b-none">Earnings &amp; Payout Status</h4></div>
                  <div class="tabsy">
                     <input type="radio" id="tab1" name="tab" checked="">
                        <label class="tabButton" for="tab1">Earnings</label>
                           <div class="tab" id="personal_info">
                              <div class="table-responsive">
                                 <table class="table user-tale">
                                    <tbody>
                                       <?php 
                                          $payout = mysqli_query($db, "SELECT sum(level_comm) as level_comm, sum(direct_sponsor_comm) as direct_sponsor_comm from payout where uid='$mlmid';"); 
                                             while($payouts=mysqli_fetch_array($payout))
                                             {
                                             ?> 
                                       
                                       <tr>
                                          <td valign="v-middle">UNILEVEL COMMISSION</td>
                                          <td>
                                            <span class="text-md text-success"><?php echo isset($payouts['level_comm'])?$payouts['level_comm']:0?> </span>
                                          </td>
                                          <td>
                                            <span class="comm-type btn btn-info">LC</span>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td valign="v-middle">DIRECT SPONSOR COMMISSIONS BONUS</td>
                                          <td>
                                            <span class="text-md text-success"><?php echo isset($payouts['direct_sponsor_comm'])?$payouts['direct_sponsor_comm']:0?> </span>
                                          </td>
                                          <td>
                                            <span class="comm-type btn btn-info"> RSCB</span>
                                          </td>
                                       </tr>
                                       
                                    <?php }?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        
                           <input type="radio" id="tab3" name="tab">
                                 <label class="tabButton" for="tab3">Payout Status</label>
                                 <div class="tab" id="social_profiles">
                                    <div class="table-responsive">
                                       <table class="table user-tale">
                                          <tbody>
                                             <tr>
                                                <td class="v-middle">REQUESTED</td>
                                                <td>
                                                   <span class="text-md text-default">$ 0.00 </span>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="v-middle">APPROVED</td>
                                                <td>
                                                   <span class="text-md text-primary">$ 0.00 </span>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="v-middle">PAID</td>
                                                <td>
                                                   <span class="text-md text-success">$ 30.00 </span> 
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="v-middle">REJECTED</td>
                                                <td>
                                                   <span class="text-md text-danger">$ 0.00 </span>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="panel dashbord-tab">
                              <div class="wrapper"><h4 class="font-thin m-t-none m-b-none ">Team Performance</h4></div> 
                              <div class="tabsy2">
                                 <input type="radio" id="tab4" name="tab2" checked="">
                                    <label class="tabButton2" for="tab4">Top Earners</label>
                                       <div class="tab2 top-earners-scroll" id="personal_info2">
                                          <div class="table-responsive">
                                             <table class="table user-tale top-earners-table">
                                                <tbody>
                                                   
                                                   <tr>
                                                      <?php 
                                                      $top_earners = mysqli_query($db, "SELECT * from user_detail INNER JOIN user_id ON user_detail.uid=user_id.uid where user_id.balance>0 ORDER BY user_id.balance DESC"); 
                                                         while($top_earners_rowdata=mysqli_fetch_array($top_earners))
                                                         {
                                                         
                                                      ?> 
                                                      <td valign="v-middle" class="grid-1">
                                                         <div class="col-lg-12">
                                                            <div class="col-lg-2 col-xs-2 padding-zero ">
                                                               <span class="thumb-sm avatar ">
                                                               <img src="https://backoffice.infinitemlmsoftware.com/uploads/images/profile_picture/nophoto.jpg">
                                                               <i class="on b-white bottom"></i>
                                                               </span>
                                                            </div>
                                                            <div class="col-lg-10 col-xs-10 padding-zero">
                                                               <div class="col-lg-8 pull-left">
                                                                  <div class="member-full-name"><?php echo $top_earners_rowdata['first_name'].' '.$top_earners_rowdata['last_name'];?></div>
                                                                  <span class="user-name"><?php echo $top_earners_rowdata['uname'];?></span>
                                                               </div>
                                                               <div class="col-lg-4 text-center padding-zero member-package-Center">
                                                                  <div class="member-package">
                                                                  <?php echo $top_earners_rowdata['balance'];?>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </td>
                                                      <?php }?>   
                                                   </tr> 
                                                                                         
                                                </tbody>
                                            </table>
                                          </div>
                                       </div>
                                       <input type="radio" id="tab5" name="tab2">
                                       <label class="tabButton2" for="tab5">Top Recruiters</label>
                                       <div class="tab2 top-earners-scroll" id="personal_info2">
                                          <div class="table-responsive">
                                            <table class="table table-hover user-tale top-earners-table">
                                                <tbody>
                                                   <tr>
                                                      <?php 
                                                      $top_recruiter = mysqli_query($db, "SELECT user_id.uname,user_detail.first_name,user_detail.last_name,count(pairing.parent_id) from pairing INNER JOIN user_id ON pairing.parent_id=user_id.uid INNER JOIN user_detail ON pairing.parent_id=user_detail.uid GROUP BY pairing.parent_id;"); 
                                                         while($top_recruiter_rowdata=mysqli_fetch_array($top_recruiter))
                                                         {
                                                        // echo "<pre>";
                                                        // print_r($top_recruiter_rowdata);
                                                      ?> 
                                                      <td valign="v-middle" class="grid-1">
                                                         <div class="col-lg-12">
                                                            <div class="col-lg-2 col-xs-2 padding-zero ">
                                                               <span class="thumb-sm avatar ">
                                                                   <img src="https://backoffice.infinitemlmsoftware.com/uploads/images/profile_picture/nophoto.jpg">
                                                                   <i class="on b-white bottom"></i>
                                                               </span>
                                                            </div>
                                                            <div class="col-lg-10 col-xs-10 padding-zero">
                                                               <div class="col-lg-8 pull-left">
                                                                   <div class="member-full-name"><?php echo $top_recruiter_rowdata['first_name'].' '.$top_recruiter_rowdata['last_name'];?></div>
                                                                   <span class="user-name"><?php echo $top_recruiter_rowdata['uname'];?></span>
                                                               </div>
                                                               <div class="col-lg-4 text-center padding-zero member-package-Center">
                                                                   <div class="member-package">
                                                                     <?php echo $top_recruiter_rowdata['count(pairing.parent_id)'];?>
                                                                   </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </td>
                                                   <?php }?>                                                
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                       <input type="radio" id="tab6" name="tab2">
                                       <label class="tabButton2" for="tab6">Repurchase</label>
                                       <div class="tab2" id="contact_info2">
                                          <table class="table user-tale">
                                             <tbody>
                                                 <?php 
                                                   $top_recruiter = mysqli_query($db, "SELECT user_id.uname,user_detail.first_name,user_detail.last_name,count(pairing.parent_id) from pairing INNER JOIN user_id ON pairing.parent_id=user_id.uid INNER JOIN user_detail ON pairing.parent_id=user_detail.uid GROUP BY pairing.parent_id;"); 
                                                      while($top_recruiter_rowdata=mysqli_fetch_array($top_recruiter))
                                                      {
                                                     // echo "<pre>";
                                                     // print_r($top_recruiter_rowdata);
                                                   ?> 
                                                <tr>
                                                   <td valign="v-middle" class="grid-1">
                                                      <div class="col-lg-12">
                                                         <div class="col-lg-2 col-xs-2 padding-zero ">
                                                            <span class="thumb-sm avatar ">
                                                                <img src="https://backoffice.infinitemlmsoftware.com/uploads/images/profile_picture/nophoto.jpg">
                                                                <i class="on b-white bottom"></i>
                                                            </span>
                                                         </div>
                                                         <div class="col-lg-10 col-xs-10 padding-zero">
                                                            <div class="col-lg-8 pull-left">
                                                                <div class="member-full-name"><?php echo $top_recruiter_rowdata['first_name'].' '.$top_recruiter_rowdata['last_name'];?></div>
                                                                <span class="user-name"><?php echo $top_recruiter_rowdata['uname'];?></span>
                                                            </div>
                                                            <div class="col-lg-4 text-center padding-zero member-package-Center">
                                                                <div class="member-package">
                                                                  <?php echo $top_recruiter_rowdata['count(pairing.parent_id)'];?>
                                                                </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </td>                                                
                                                </tr>

                                                <?php }?>
                                             </tbody>  
                                          </table>
                                       </div>
                                 </div>
                              </div>
                           </div>
                        </div>
        </div>
        <div id="uploadexcel" class="modal fade in" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
        <form id="UploadExcelFrom">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Upload Excel(.csv)</h4>
              </div>
              <div class="modal-body">
                <div class="col-md-12">   
                    <input type="file" name="users" id="users" class="form-control">
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="type" value="UploadExcelFrom">
                <button type="submit" class="btn btn-info UploadExcelFrom">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        </form>
      </div>
    </div>   


    </div>
                <!-- /BOXES -->
</section>
<!-- /MIDDLE -->
            
<?php include("footer.php");?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> 
<script>
     
       var ctx = document.getElementById('join_chart').getContext('2d');
      var join_chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: <?=$m_name?>,
            datasets: [{ 
                data: <?=$datas?>,
                label: "Joinings",
                borderColor: "rgb(62,149,205)",
                backgroundColor: "rgb(62,149,205,0.1)",
              }
            ]
          },
          barDatasetSpacing : 1,
        });
      function copyFunction() {
         var copyText = document.getElementById("referrallink");
         copyText.select();
         copyText.setSelectionRange(0, 99999);
         navigator.clipboard.writeText(copyText.value);
      }
    </script>