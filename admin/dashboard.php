<?php include("header.php");?>
<?php

$usercount1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT count(uid) as `totalcount` FROM `user_id` WHERE  `uid` !='1'"));
$usercount = $usercount1['totalcount'];
$plans = mysqli_num_rows(mysqli_query($db, "SELECT * from plans"));
$transpin = mysqli_num_rows(mysqli_query($db, "SELECT * from transpin"));
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


$sql1 = mysqli_query($db,"SELECT IFNULL(sum(level_comm),0) as level_comm, IFNULL(sum(direct_sponsor_comm),0) as direct_sponsor_comm FROM payout WHERE cleared !='1'") or die(mysqli_fetch_assoc($db));
$row1 = mysqli_fetch_assoc($sql1);
$total_payout = $row1['level_comm']+$row1['direct_sponsor_comm'];


$total_payout_after_admin_charge = ($total_payout*5)/100;
$total_payout_after_tds_charge = ($total_payout*5)/100;

$total_payout = $total_payout-($total_payout_after_admin_charge+$total_payout_after_tds_charge);


$sql0 = mysqli_query($db,"SELECT IFNULL(sum(level_comm),0) as level_comm, IFNULL(sum(direct_sponsor_comm),0) as direct_sponsor_comm  FROM payout") or die(mysqli_fetch_assoc($db));
$row0 = mysqli_fetch_assoc($sql0);
$all_payout = $row1['level_comm']+$row1['direct_sponsor_comm'];


$all_payout_after_admin_charge = ($all_payout*5)/100;
$all_payout_after_tds_charge = ($all_payout*5)/100;

$all_payout = $all_payout-($all_payout_after_admin_charge+$all_payout_after_tds_charge);

$pvs=mysqli_query($db,"select left_pv,right_pv from child_counter where uid=1");
$pvs1= mysqli_fetch_assoc($pvs);
$left_pv=$pvs1['left_pv'];
$right_pv=$pvs1['right_pv'];

?>
<!-- 
        MIDDLE 
-->
<section id="middle">
   <!-- main header -->
   <div class="bg-light lter b-b wrapper-md new-title-section">                 
      <div class="header-user-title">
         <h1 class="m-n font-thin h3">Overview</h1>
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
                              <div class="col-xs-12 col-sm-6  col-lg-6 " id="section_tile1">
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
                              <div class="col-xs-12 col-sm-6  col-lg-6" id="section_tile3">
                                 <div class="box2">
                                  
                                    <a href="">
                                       <div class="panel shadow padder-v item lg-panel">
                                          <span class="text-muted">Total Left PV</span>
                                          <div class=" font-thin h1 block1" id="total_payout"> <?php echo isset($left_pv)?$left_pv:0; ?> </div>
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
                                          <span class="text-muted">Total Right PV</span>
                                          <div class="font-thin  h1" id="mail_total"><?php echo isset($right_pv)?$right_pv:0; ?></div>
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
                              <div class="userprof-top profile_user" >
                                 <div class="panel-body profile-section">
                                    <div class="dashbord-profile">
                                       <div class="profile-avatar">
                                          <img class="" src="../new_assets/uploads/images/tree/tree_96353712.jpg">
                                          <h3 class="profile-name full_name" title="<?php echo $userdtl['first_name']." ".$userdtl['last_name']; ?>" >
                                             <?php echo $userdtl['first_name']." ".$userdtl['last_name']; ?>
                                          </h3>
                                          <h5 class="profile-name2 user_name2"><?php echo $user['uname']; ?></h5>

                                          <a href="profile"  class="btn btn-info btn-md btn-submit">View Profile</a>
                                      
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Start Promotion Tools html  -->
                                 <div class="Promotion-Tools" >
                                    <div class="row">
                    <div class="panel panel-default mypanel ">
                        <div class="panel-heading panel-heading-transparent">
                                <strong>Update Shipping Charge</strong> 
                        </div>

                     
                        <div class="panel-body">
                            <form  action="" id="UpdateShippingCharge" method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>Amount *</label>
                                                <div class="fancy-form"><!-- input -->
                                                    <input type="number"  placeholder = "Please Enter Amount" class = "form-control" name ="amount" id ="amount" title ="Enter Amount !" value="<?=isset($shipping_charge)?$shipping_charge:0; ?>" >
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12 text-center">
                                                <input type="hidden" name="type" value="UpdateShippingCharge">
                                                <button type="submit" name ="update"  class="btn btn-info btn-md btn-submit" >Update</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    
                </div>
                                 </div>
                                 <!-- Close Promotion Tools html -->
                              </div>
                           </div>
                           <!-- Profile/Promotion end -->
                        </div>
                     </div>
                    
                  </div>


        <div class="row">
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