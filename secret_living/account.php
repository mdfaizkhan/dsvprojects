<?php include 'header.php'; 
$mlmid=$_SESSION['mlmid'];
$udata=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uid,t1.uname,t1.image,t2.* FROM user_id t1 LEFT JOIN user_detail t2 on t1.uid=t2.uid WHERE t1.uid='$mlmid' "));
//echo isset($udata['first_name'])?$udata['first_name']:''; die;
//var_dump($udata);die;
?>
<!-- main wrapper start -->
<main>
   <!-- breadcrumb area start -->
   <div class="breadcrumb-area">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="breadcrumb-wrap text-center">
                  <nav aria-label="breadcrumb">
                     <h2>shop</h2>
                     <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">my account</li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- breadcrumb area end -->
   <!-- my account wrapper start -->
   <div class="my-account-wrapper pt-60 pb-60">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <!-- My Account Page Start -->
               <div class="myaccount-page-wrapper">
                  <!-- My Account Tab Menu Start -->
                  <div class="row">
                     <div class="col-lg-3 col-md-4">
                        <div class="myaccount-tab-menu nav" role="tablist">
                           <!-- <a href="#dashboad" class="active" data-toggle="tab"><i class="fa fa-dashboard"></i>
                           Dashboard</a> -->
                           <a href="#orders" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i>
                           Orders</a>
                           <!-- <a href="#request" data-toggle="tab"><i class="fa fa-inr"></i>
                           Balance Request</a> -->
                           <!-- <a href="#download" data-toggle="tab"><i class="fa fa-cloud-download"></i>
                              Download</a>
                              <a href="#payment-method" data-toggle="tab"><i class="fa fa-credit-card"></i>
                              Payment
                              Method</a>
                              <a href="#address-edit" data-toggle="tab"><i class="fa fa-map-marker"></i>
                              address</a> -->
                           <!-- <a href="#account-info" data-toggle="tab"><i class="fa fa-user"></i> Account
                           Details</a> -->
                           <a href="logout"><i class="fa fa-sign-out"></i> Logout</a>
                        </div>
                     </div>
                     <!-- My Account Tab Menu End -->
                     <!-- My Account Tab Content Start -->
                     <div class="col-lg-9 col-md-8">
                        <div class="tab-content" id="myaccountContent">
                           <!-- Single Tab Content Start -->
                           <div class="tab-pane fade " id="dashboad" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Dashboard</h3>
                                 <div class="welcome">
                                    <p>Hello, <strong><?=isset($_SESSION['mlmusername'])?$_SESSION['mlmusername']:''; ?></strong> (If Not <strong> <?=isset($_SESSION['mlmusername'])?$_SESSION['mlmusername']:''; ?>!</strong><a
                                       href="logout" class="logout"> Logout</a>)</p>
                                 </div>
                                 <p class="mb-0">From your account dashboard. you can easily check &
                                    view your recent orders, manage your orders
                                    and edit your password and account details.
                                 </p>
                              </div>
                           </div>
                           <!-- Single Tab Content End -->
                           <!-- Single Tab Content Start -->
                           <div class="tab-pane fade show active" id="orders" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Orders</h3>
                                 <div class="myaccount-table table-responsive text-center">
                                    <table class="table table-bordered">
                                       <thead class="thead-light">
                                          <tr>
                                             <th>Order</th>
                                             <th>Date</th>
                                             <th>Status</th>
                                             <th>Total</th>
                                             <!-- <th>Action</th> -->
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php 
                                             $i=1;
                                             $mlmid=$_SESSION['mlmid'];
                                             $q11=mysqli_query($db,"SELECT * FROM `checkout` WHERE uid='$mlmid'");
                                             while ($r1=mysqli_fetch_assoc($q11)) {?>
                                          <tr>
                                             <td><?=$i++; ?></td>
                                             <td><?php echo date("M d,Y", strtotime($r1['date'])); ?></td>
                                             <td>Pending</td>
                                             <td>₹<?=$r1['amount']; ?></td>
                                             <!-- <td><a href="javascript:void(0);" class="btn btn__bg btn__sqr">Upload Detail</a></td> -->
                                          </tr>
                                          <?php } ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="request" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Balance Request</h3>
                                 <div class="myaccount-table table-responsive text-center">
                                    <table class="table table-bordered">
                                       <thead class="thead-light">
                                          <tr>
                                             <th>Id</th>
                                             <th>Amount</th>
                                             <th>File</th>
                                             <th>Transaction ID</th>
                                             <th>Date</th>
                                             <th>Status</th>
                                             <th>Updated Date</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php 
                                             $i=1;
                                             $mlmid=$_SESSION['mlmid'];
                                             $q11=mysqli_query($db,"SELECT * FROM `bal_req` WHERE uid='$mlmid'");
                                             while ($r1=mysqli_fetch_assoc($q11)) {?>
                                          <tr>
                                             <td><?=$i++; ?></td>
                                             <td>$<?=$r1['amount']; ?></td>
                                             <td><a href="upload/payment/<?=$r1['file']; ?>"> </td>
                                              <td>₹<?=$r1['amount']; ?></td>
                                             <td><?php echo date("M d,Y", strtotime($r1['date'])); ?></td>
                                             <td>Pending</td>
                                             <td><?php echo date("M d,Y", strtotime($r1['approve_date'])); ?></td>
                                             <td><a href="javascript:void(0);" class="btn btn__bg btn__sqr DeleteBalReq" data-id="<?php echo $r1['req_id']; ?>">Delete</a></td>
                                          </tr>
                                          <?php } ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <!-- Single Tab Content End -->
                           <!-- Single Tab Content Start -->
                           <div class="tab-pane fade" id="download" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Downloads</h3>
                                 <div class="myaccount-table table-responsive text-center">
                                    <table class="table table-bordered">
                                       <thead class="thead-light">
                                          <tr>
                                             <th>Product</th>
                                             <th>Date</th>
                                             <th>Expire</th>
                                             <th>Download</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>Haven - Free Real Estate PSD Template</td>
                                             <td>Aug 22, 2018</td>
                                             <td>Yes</td>
                                             <td><a href="#" class="btn btn__bg btn__sqr"><i class="fa fa-cloud-download"></i>
                                                Download File</a>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>HasTech - Profolio Business Template</td>
                                             <td>Sep 12, 2018</td>
                                             <td>Never</td>
                                             <td><a href="#" class="btn btn__bg btn__sqr"><i class="fa fa-cloud-download"></i>
                                                Download File</a>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <!-- Single Tab Content End -->
                           <!-- Single Tab Content Start -->
                           <div class="tab-pane fade" id="payment-method" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Payment Method</h3>
                                 <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                              </div>
                           </div>
                           <!-- Single Tab Content End -->
                           <!-- Single Tab Content Start -->
                           <div class="tab-pane fade" id="address-edit" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Billing Address</h3>
                                 <address>
                                    <p><strong>Alex Tuntuni</strong></p>
                                    <p>1355 Market St, Suite 900 <br>
                                       San Francisco, CA 94103
                                    </p>
                                    <p>Mobile: (123) 456-7890</p>
                                 </address>
                                 <a href="#" class="btn btn__bg btn__sqr"><i class="fa fa-edit"></i>
                                 Edit Address</a>
                              </div>
                           </div>
                           <!-- Single Tab Content End -->
                           <!-- Single Tab Content Start -->
                           <div class="tab-pane fade" id="account-info" role="tabpanel">
                              <div class="myaccount-content">
                                 <h3>Account Details</h3>
                                 <div class="account-details-form">
                                    <form method="POST" id="ProfileUpdate">
                                      <div class="row">
                                        <div class="col-lg-6">
                                           <div class="single-input-item">
                                              <label for="first-name" class="required">First Name</label>
                                              <input type="text" id="first-name" name="first_name" value="<?php echo isset($udata['first_name'])?$udata['first_name']:''; ?>" placeholder="First Name" />
                                           </div>
                                        </div>
                                        <div class="col-lg-6">
                                           <div class="single-input-item">
                                              <label for="last-name" class="required">Last Name</label>
                                              <input type="text" id="last-name" placeholder="Last Name" name="last_name" value="<?=isset($udata['last_name'])?$udata['last_name']:''; ?>"/>
                                           </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-lg-6">
                                           <div class="single-input-item">
                                              <label for="email" class="required">Email</label>
                                              <input type="email" id="email" placeholder="Email Address" name="email" value="<?=isset($udata['email'])?$udata['email']:''; ?>" />
                                           </div>
                                        </div>
                                        <div class="col-lg-6">
                                           <div class="single-input-item">
                                              <label for="last-name" class="required">Gender</label>
                                             
                                              <select class="form-control select2" name="gender">
                                                <option value="">--- Select ---</option>
                                                <option value="male" <?php echo isset($udata['gender']) && $udata['gender']=='male'?'selected':''; ?>>Male</option>
                                                <option value="female" <?php echo isset($udata['gender']) && $udata['gender']=='female'?'selected':''; ?>>Female</option>
                                                <option value="other" <?php echo isset($udata['gender']) && $udata['gender']=='other'?'selected':''; ?>>Other</option>
                                              </select>
                                           </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        
                                        <div class="col-lg-6">
                                          
                                           <div class="single-input-item">
                                              <label for="last-name" class="required">Profile Image</label>
                                              <input type="file" name="picture" id="file" onchange="this.parentNode.nextSibling.value = this.value">
                                           </div>
                                         </div>
                                           <?php if(isset($udata['image']) && file_exists("upload/profile/".$udata['image'] )) { ?>
                                           <div class="col-md-3">
                                             <img src="upload/profile/<?=$udata['image']; ?>">
                                           </div>
                                         <?php } ?>
                                           <div class="col-lg-3">
                                           <div class="single-input-item">
                                              <label for="mobile" class="required">Mobile</label>
                                              <input type="number" id="mobile" placeholder="Mobile" name="mobile" value="<?=isset($udata['mobile'])?$udata['mobile']:''; ?>" />
                                           </div>
                                        </div>
                                      </div>
                                       
                                       <div class="single-input-item">
                                        <input type="hidden" name="uid" value="<?=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:''; ?>">
                                        <input type="hidden" name="uname" value="<?=isset($udata['uname'])?$udata['uname']:''; ?>">
                                        <input type="hidden" name="type" value="ProfileUpdate">
                                          <button type="submit" class="btn btn__bg btn__sqr formvalidate" data-form="ProfileUpdate">Save Changes</button>
                                       </div>
                                       <br><br>
                                     </form>
                                     <form class="nomargin" method="POST" id="userChangePass" autocomplete="off">
                                       <fieldset>
                                          <legend>Password change</legend>
                                          <!-- <div class="single-input-item">
                                             <label for="current-pwd" class="required">Current
                                             Password</label>
                                             <input type="password" id="current-pwd" name="password" placeholder="Current Password" />
                                          </div> -->
                                          <div class="row">
                                             <div class="col-lg-6">
                                                <div class="single-input-item">
                                                   <label for="new-pwd" class="required">New
                                                   Password</label>
                                                   <input type="password" id="new-pwd" name="new_password" placeholder="New Password" />
                                                </div>
                                             </div>
                                             <div class="col-lg-6">
                                                <div class="single-input-item">
                                                   <label for="confirm-pwd" class="required">Confirm
                                                   Password</label>
                                                   <input type="password" id="confirm-pwd" name="confirm_password"
                                                      placeholder="Confirm Password" />
                                                </div>
                                             </div>
                                          </div>
                                       </fieldset>
                                       <div class="single-input-item">
                                        <input type="hidden" name="uid" value="<?=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:''; ?>">
                                        <input type="hidden" name="type" value="SetNewPassword">
                                          <button type="submit" class="btn btn__bg btn__sqr formvalidate" data-form="userChangePass">Change Password</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <!-- Single Tab Content End -->
                        </div>
                     </div>
                     <!-- My Account Tab Content End -->
                  </div>
               </div>
               <!-- My Account Page End -->
            </div>
         </div>
      </div>
   </div>
   <!-- my account wrapper end -->
</main>
<!-- main wrapper end -->
<?php include 'footer.php'; ?>