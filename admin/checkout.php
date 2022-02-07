<?php include('header.php');
$mlmid=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'';
if(isset($mlmid) && !empty($mlmid))
{
   $data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t2.* FROM user_id t1 left join user_detail t2 on t1.uid=t2.uid where t1.uid=$mlmid"));
    $q11=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(total) as total FROM cart WHERE uid='$mlmid' and transaction_id IS null"));
    if(!isset($q11['total']) || $q11['total'] <=0)
    {
      echo "<script>window.location='cart';</script>";
    }
}
$spr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `home` WHERE id=1"));
$shipping_charge=$spr['amount'];
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
                        <li class="breadcrumb-item active" aria-current="page">checkout</li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- breadcrumb area end -->
   <!-- checkout main wrapper start -->
   <div class="checkout-page-wrapper pt-60 pb-54">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <!-- Checkout Login Coupon Accordion Start -->
               <div class="checkoutaccordion" id="checkOutAccordion">
                <?php if(!isset($_SESSION['mlmid']) && !isset($_SESSION['franchiseid'])){ ?>
                  <div class="card">
                     <h3>Not Register Yet ? <span data-toggle="collapse" data-target="#registeraccordion">Click
                        Here To Register</span>
                     </h3>
                     <div id="registeraccordion" class="collapse show" data-parent="#checkOutAccordion">
                        <div class="card-body">
                           <!-- <p>Please Register Here 
                           </p> -->
                           <div class="login-reg-form-wrap mt-20">
                              <div class="row">
                                 <div class="col-lg-7 m-auto">
                                    <form id="checkoutregisterform" action="#" method="post">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <input type="text" placeholder="Sponsor Id" id="sponsor_id" class="form-control getSponsordetail" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                               Name : <span id="Sponsordetail"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <input type="text" placeholder="First name" id="fname" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                               <input type="text" placeholder="Last name" id="lname" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!-- <div class="row">
                                                <div class="col-md-8">
                                                    <div class="single-input-item">
                                                        
                                                        <input type="text" placeholder="Username" id="dusername" class="form-control" required readonly>           
                                                        <input type="hidden" placeholder="Username" id="username" class="form-control" required readonly>           
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="padding-top: 21px;">
                                                    <a href="javascript:void(0);" class=" btn-info btn-xs generatebtn" onclick="getUname()" style="padding:7px;">Generate</a>
                                                </div>
                                            </div> -->
                                            <div class="single-input-item">
                                                <input type="text" placeholder="Username" id="username" class="form-control" required >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                               <input type="email" placeholder="Email address" id="email" class="form-control" >   
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <input type="password" placeholder="Password" id="password" class="form-control" required> 
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                               <input type="password" placeholder="Confirm password" id="rpassword" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <input type="text" placeholder="Mobile No" id="mobile_no" class="form-control" required> 
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                               <select class="form-control" id="gender" required>
                                                <option value="" selected="" disabled="">Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                               <select class="form-control" id="position" required>
                                                <option value="" selected="" disabled="">Select Position</option>
                                                <option value="L">Left</option>
                                                <option value="R">Right</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <div class="login-reg-form-meta">
                                            <div class="remember-meta">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checked-agree" id="subnewsletter">
                                                    <label class="custom-control-label" for="subnewsletter">agree to the Terms of Service</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <button type="submit" class="btn btn__bg btn__sqr formvalidate" data-form="checkoutregisterform">Register</button>
                                    </div>
                                </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <h3>Returning Customer? <span data-toggle="collapse" data-target="#logInaccordion">Click
                        Here To Login</span>
                     </h3>
                     <div id="logInaccordion" class="collapse" data-parent="#checkOutAccordion">
                        <div class="card-body">
                           <p>If you have shopped with us before, please enter your details in the boxes
                              below. If you are a new customer, please register with us.
                           </p>
                           <div class="login-reg-form-wrap mt-20">
                              <div class="row">
                                 <div class="col-lg-7 m-auto">
                                    <form id="AffiliateLogin" method="POST">
                                       <div class="row">
                                          <div class="col-md-12">
                                             <div class="single-input-item">
                                                <input type="text"  name="username" placeholder="Enter your username"
                                                   required />
                                             </div>
                                          </div>
                                          <div class="col-md-12">
                                             <div class="single-input-item">
                                                <input type="password" name="password" placeholder="Enter your Password"
                                                   required />
                                             </div>
                                          </div>
                                       </div>
                                       <div class="single-input-item">
                                          <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                             <div class="remember-meta">
                                                <!-- <div class="custom-control custom-checkbox">
                                                   <input type="checkbox" class="custom-control-input"
                                                      id="rememberMe" required />
                                                   <label class="custom-control-label" for="rememberMe">Remember
                                                   Me</label>
                                                </div> -->
                                             </div>
                                             <!-- <a href="#" class="forget-pwd">Forget Password?</a> -->
                                          </div>
                                       </div>
                                       <div class="single-input-item">
                                        <input type="hidden" name="type" value="AffiliateLogin">
                                        <input type="hidden" name="rurl" value="checkout">
                                          <button class="btn btn__bg">Login</button>
                                       </div>
                                    <!-- </form> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                <?php } ?>
                  <!-- <div class="card">
                     <h3>Have A Coupon? <span data-toggle="collapse" data-target="#couponaccordion">Click
                             Here To Enter Your Code</span></h3>
                     <div id="couponaccordion" class="collapse" data-parent="#checkOutAccordion">
                         <div class="card-body">
                             <div class="cart-update-option">
                                 <div class="apply-coupon-wrapper">
                                     <form action="#" method="post" class=" d-block d-md-flex">
                                         <input type="text" placeholder="Enter Your Coupon Code" required />
                                         <button class="btn btn__bg">Apply Coupon</button>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                     </div> -->
               </div>
               <!-- Checkout Login Coupon Accordion End -->
            </div>
         </div>
         <?php if((isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid'])) || (isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))){ ?>
            <form id="OrderNow" method="POST">
            <div class="row">
               <!-- Checkout Billing Details -->
               <div class="col-lg-6">
                  <div class="checkout-billing-details-wrap">
                     <h2>Billing Details</h2>
                     <div class="billing-form-wrap">
                        <!-- <form id="OrderNow" method="POST"> -->
                           <div class="row">
                              
                                <?php
                                  if((!isset($_SESSION['franchiseid']) || empty($_SESSION['franchiseid'])) && (isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid'])))
                                  {
                                  ?>
                                  <div class="col-md-6">
                                    <div class="single-input-item">
                                      <label for="user" class="required">Franchise</label>
                                      <input type="text" placeholder="Franchise" id="fid1" class="form-control getFranchisedetail">
                                      <!-- <select name="fid" id="fid" class="form-control select2">
                                        <option value=''>Select Franchise</option>
                                        <?php
                                          $fq=mysqli_query($db,"SELECT * FROM `franchise`");
                                          while ($fr=mysqli_fetch_assoc($fq)) {
                                        ?>
                                         <option value="<?=$fr['id']; ?>"><?=$fr['uname']; ?></option>
                                       <?php } ?>
                                      </select> -->
                                   </div>
                                 </div>
                                 <div class="col-md-6">
                                       <div class="single-input-item">
                                        Franchise Name : <span id="Franchisedetail"></span>
                                        <input type="hidden"  name="fid" id="fid">
                                      </div>
                                    </div>
                                  <?php
                                  
                                  /*$left_users = GetUserByPos($db,$mlmid,'L');
                                  $right_users = GetUserByPos($db,$mlmid,'R');
                                  $uids=array_merge($left_users,$right_users);
                                  $uids[]=$mlmid;
                                  $uids1=implode(',', $uids);*/

                                  //$uq=mysqli_query($db,"SELECT uid,uname FROM `user_id` WHERE FIND_IN_SET(uid,'$uids1')");
                                  ?>
                                    <div class="col-md-6">
                                      <div class="single-input-item">
                                        <label for="user" class="required">Downline User</label>
                                        <input type="text" placeholder="Downline User" id="dsponsor_id" class="form-control getDUserdetail" >
                                        <!-- <select name="puid" id="puid" class="form-control select2">
                                          <option value="">Select User</option>
                                          <?php
                                            while ($ur=mysqli_fetch_assoc($uq)) {
                                          ?>
                                           <option value="<?=$ur['uid']; ?>"><?=$ur['uname']; ?></option>
                                         <?php } ?>
                                        </select> -->
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="single-input-item">
                                        Name : <span id="DSponsordetail"></span>
                                        <input type="hidden"  name="puid" id="dpuid">
                                      </div>
                                    </div>
                                  <?php

                                  } else {

                                    //$uq=mysqli_query($db,"SELECT uid,uname FROM `user_id` WHERE uid!=1");
                                  

                                  ?>
                                  <input type="hidden" name="fid" value="<?=isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid'])?$_SESSION['franchiseid']:''; ?>">
                                  
                                <div class="col-md-6">
                                 <div class="single-input-item">
                                  <label for="user" class="required">Downline User</label>
                                  <input type="text" placeholder="Downline User" id="sponsor_id" class="form-control getUserdetail" >
                                  
                                  <!-- <select name="puid" id="puid" class="form-control select2">
                                    <option value="">Select User</option>
                                    <?php
                                      while ($ur=mysqli_fetch_assoc($uq)) {
                                    ?>
                                     <option value="<?=$ur['uid']; ?>"><?=$ur['uname']; ?></option>
                                   <?php } ?>
                                  </select> -->
                               </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="single-input-item">
                                  Sponsor Name : <span id="Sponsordetail"></span>
                                  <input type="hidden"  name="puid" id="puid">
                                </div>
                              </div>
                              <?php
                                }
                                ?>
                              
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="single-input-item">
                                    <label for="f_name" class="required">First Name</label>
                                    <input type="text" id="f_name" name="fname" placeholder="First Name" value="<?=isset($data['first_name'])?$data['first_name']:''; ?>"required />
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="single-input-item">
                                    <label for="l_name" class="required">Last Name</label>
                                    <input type="text" id="l_name" name="lname"placeholder="Last Name"  value="<?=isset($data['last_name'])?$data['last_name']:''; ?>" required />
                                 </div>
                              </div>
                           </div>
                           <div class="single-input-item">
                              <label for="email" class="required">Email Address</label>
                              <input type="email" id="email" placeholder="Email Address" name="email" value="<?=isset($data['email'])?$data['email']:''; ?>" required />
                           </div>
                           <!-- <div class="single-input-item">
                              <label for="com-name">Company Name</label>
                              <input type="text" id="com-name" placeholder="Company Name" name="cname" value="" />
                           </div> -->
                           <input type="hidden" name="cname" id="cname" value="">
                           <input type="hidden" name="country" id="country" value="India">
                           <!-- <div class="single-input-item">
                              <label for="country" class="required">Country</label>
                              <select name="country" id="country">
                                 <option value="India">India</option>
                              </select>
                           </div> -->
                           <div class="single-input-item">
                              <label for="street-address" class="required mt-20">Street address</label>
                              <input type="text" id="street-address" placeholder="Street address Line 1" name="street1" 
                                 required />
                           </div>
                           <div class="single-input-item">
                              <input type="text" placeholder="Street address Line 2 (Optional)" name="street2" />
                           </div>
                           <div class="single-input-item">
                              <label for="town" class="required">Town / City</label>
                              <input type="text" id="town" placeholder="Town / City" name="city" value="<?=isset($data['city'])?$data['city']:''; ?>" required />
                           </div>
                           <!-- <div class="single-input-item">
                              <label for="state">State / Divition</label>
                              <input type="text" id="state" placeholder="State / Divition" name="state" value="<?=isset($data['state'])?$data['state']:''; ?>" />
                           </div> -->
                           <div class="single-input-item">
                              <label for="state" class="required">State / Divition</label>
                              <select name="state" id="state" class="form-control select2">
                                <option value="">Select State</option>
                                <?php 
                                $sq=mysqli_query($db,"SELECT * FROM `states`");
                                while ($sr=mysqli_fetch_assoc($sq)) {
                                  ?>
                                 <option value="<?=$sr['name']; ?>"><?=$sr['name']; ?></option>
                               <?php } ?>
                              </select>
                           </div>
                           <div class="single-input-item">
                              <label for="postcode" class="required">Postcode / ZIP</label>
                              <input type="text" id="postcode" placeholder="Postcode / ZIP"  name="postcode" value="<?=isset($data['zip'])?$data['zip']:''; ?>"required />
                           </div>
                           <div class="single-input-item">
                              <label for="phone">Phone</label>
                              <input type="text" id="phone" placeholder="Phone" name="phone" value="<?=isset($data['mobile'])?$data['mobile']:''; ?>" />
                           </div>
                           
                        </form>
                     </div>
                  </div>
               </div>
               <!-- Order Summary Details -->
               <div class="col-lg-6">
                  <div class="order-summary-details mt-md-50 mt-sm-50">
                     <h2>Your Order Summary</h2>
                     <div class="order-summary-content">
                        <!-- Order Summary Table -->
                        
                        <div class="order-summary-table table-responsive text-center OrderDetail">
                           <table class="table table-bordered">
                              <thead>
                                 <tr>
                                    <th>Products</th>
                                    <th>Total</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $total=0;
                                 $bv=0;
                                 
                                 $q1=mysqli_query($db,"SELECT * FROM cart WHERE uid='$mlmid' and transaction_id IS null");
                                 while ($r1=mysqli_fetch_assoc($q1)) {
                                    $total=$total+$r1['total'];
                                    $bv=$bv+($r1['bv']*$r1['qty']);
                                 ?>
                                 <tr>
                                    <td><a href="javascript:void(0);"><?=$r1['name']; ?> <strong> × <?=$r1['qty']; ?></strong></a></td>
                                    <td>₹<?=$r1['price']; ?></td>
                                 </tr>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <td>Sub Total</td>
                                    <td><strong>₹<?=$total; ?></strong></td>
                                 </tr>
                                 
                                 <tr>
                                    <td>Total Amount</td>
                                    <td><strong>₹<?=$total; ?></strong></td>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                        <!-- Order Payment Method -->
                        <div class="order-payment-method">
                           
                           <div class="summary-footer-area">
                             
                              <div class="custom-control custom-checkbox mb-14">
                                 <input type="checkbox" class="custom-control-input checked-agree" id="terms" required />
                                 <label class="custom-control-label" for="terms">I have read and agree to
                                 the website <a href="termsandconditions.php">terms and conditions.</a></label>
                              </div>
                              <?php if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid'])){ $style='display: none;'; } else { $style=''; } ?>
                              <div class="HomeDelivery" style="<?=$style; ?>">
                              <div class="custom-control custom-checkbox mb-14" >
                                 <input type="checkbox" class="custom-control-input " id="HomeDelivery" name="shipping_charge" value="<?=isset($total) && $total>500?$shipping_charge:$shipping_charge; ?>" required />
                                 <label class="custom-control-label" for="HomeDelivery">Home Delivery ?</label>
                              </div>
                              <div class="custom-control custom-checkbox mb-14 ShippingCharge" style="display: none;">
                                 <label class="control-label" >Home Delivery Charge Rs : <?=isset($total) && $total>500?$shipping_charge:$shipping_charge; ?></label>
                              </div>
                            </div>
                              <input type="hidden" name="amount" id="ctotal" value="<?=$total; ?>">
                              <input type="hidden" name="bv" value="<?=$bv; ?>">
                              <input type="hidden" name="uid" value="<?=$mlmid; ?>">
                              <!-- <input type="hidden" name="fid" value="<?=isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid'])?$_SESSION['franchiseid']:''; ?>"> -->
                              <input type="hidden" name="type" value="OrderNow">
                              <!-- <button type="button" class="btn btn__bg formvalidate" data-form="OrderNow" id="OrderNowBtn">Place Order</button> -->
                              <button type="button" class="btn btn__bg" data-form="OrderNow" id="OrderNowBtn">Place Order</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      <?php } ?>
      </div>
   </div>
   <!-- checkout main wrapper end -->
</main>
<!-- main wrapper end -->
<?php include('footer.php'); ?>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Enter Your Password</h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12"> 
        <?php
          if(isset($_SESSION['franchiseid']) && $_SESSION['franchiseid'] > 0)
          {
            $userid=$_SESSION['franchiseid'];
          }
          else if(isset($_SESSION['mlmid']) && $_SESSION['mlmid'] > 0)
          {
            $userid=$_SESSION['mlmid'];
          }
          else
          {
            $userid=0;
          }
        ?>  
            <input type="hidden" name="user_id" id="user_id" value="<?=$userid; ?>">      
            <input type="hidden" name="table" id="table" value="<?=isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid'])?'franchise':'user_id'; ?>">      
            <input type="password" name="tpassword" id="tpassword" class="form-control" value="" autocomplete="off" autocomplete="false">
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info SubmitPassword">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>