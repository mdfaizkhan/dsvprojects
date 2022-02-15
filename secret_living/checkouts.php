<?php include('header.php');
 require('config.php');
require('razorpay-php/Razorpay.php');
//session_start();
// Create the Razorpay Order
use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);
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
                     <h2>Checkout</h2>
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
                                        <div class="col-sm-6">
                                         <label>If you have sponsor select Yes else select NO</label>
                                          <select class="form-control" onchange="yeornosponsor(this.value)">
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                          </select>
                                         </div>
                                        <div class="col-lg-6 va_hide">
                                            <div class="single-input-item">
                                                <input type="text" placeholder="Sponsor Id" id="sponsor_id" value="<?php echo isset($_GET['username'])?$_GET['username']:''; ?>" class="form-control getSponsordetail" required>
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
                                            <?php
												 $sql1=mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(*) as un FROM `user_id` WHERE uid!=1"));
												 $tot=(5000+$sql1['un'])-1;
												 $unames="VP-".$tot;
											?>
                                            <div class="single-input-item">
                                                <input type="text" placeholder="Username" id="username" value="<?php echo isset($data['uname'])?$data['uname']:$unames; ?>" class="form-control" readonly required >
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
                                     <div class="row va_hide">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                              <label>Select Position</label>
                                               <select class="form-control" id="position" required>
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
            <form id="payments" method="POST">
            <div class="row">
               <!-- Checkout Billing Details -->
               <div class="col-lg-6">
                  <div class="checkout-billing-details-wrap">
                     <h2>Billing Details</h2>
                     <div class="billing-form-wrap">
                        <form id="OrderNow" method="POST">
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
                           <div class="single-input-item">
                              <label for="town" class="required">Country</label>
                              
                             <select class="form-control select2" name="country" required="">
                              <?php
                                 $sqldata=mysqli_query($db,"select * from country");
                                  
                                 while ($con=mysqli_fetch_assoc($sqldata)){
                                    echo '<option value="'.$con['name'].'">'.$con['name'].'</option>';
                                 }
                              ?>
                            </select>
                           </div>
                           <!-- <div class="single-input-item">
                              <label for="com-name">Company Name</label>
                              <input type="text" id="com-name" placeholder="Company Name" name="cname" value="" />
                           </div> -->
                           <!-- <input type="hidden" name="cname" id="cname" value=""> -->
                           <!-- <input type="hidden" name="country" id="country" value="India"> -->
                           <!-- <div class="single-input-item">
                              <label for="country" class="required">Country</label>
                              <select name="country" id="country">
                                 <option value="India">India</option>
                              </select>
                           </div> -->
                           <div class="single-input-item">
                              <label for="street-address" class="required mt-20">Street address</label>
                              <input type="text" id="street-address" placeholder="Street address Line 1" value="<?=isset($data['address'])?$data['address']:''; ?>" name="street1" 
                                 required />
                           </div>
                           <div class="single-input-item">
                              <input type="text" placeholder="Street address Line 2 (Optional)" name="street2" />
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
                                 $userpv=0;
                                 if(isset($_SESSION['mlmid']))
                                  {
                                    $uid=$_SESSION['mlmid'];
                                    $q1=mysqli_query($db,"SELECT t1.*,t2.pv as pv FROM cart t1 left join products t2 on t1.product_id=t2.product_id WHERE t1.uid='$uid' and t1.transaction_id IS null");
                                 }
                                 // print_r(mysqli_fetch_array($q1));die;
                                 while ($r1=mysqli_fetch_assoc($q1)){
                                    $pv=0;
                                    $total=$total+$r1['total'];
                                    $pv=($r1['pv']*$r1['qty']);
                                    //$bv=($r1['bv']);
                                    
                                    
                                    $userpv=$userpv+$pv;
                                    //echo "<br>".$bv."---".$r1['pbv']."===".$r1['qty']."----".$userbv;
                                 ?>
                                 <tr>
                                    <td><a href="javascript:void(0);"><?=$r1['name']; ?> <strong> × <?=$r1['qty']; ?></strong></a></td>
                                    <td>RM <?=$r1['price']; ?> <?php echo "---".$r1['pv']."---".$pv; ?></td>
                                 </tr>
                              <?php }  ?>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <td>Sub Total</td>
                                    <td><strong>RM <?=$total; ?></strong></td>
                                 </tr>
                                 
                                 <tr>
                                    <td>Total Amount</td>
                                    <td><strong>RM <?=$total; ?></strong></td>
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
                                 <input type="checkbox" class="custom-control-input " id="HomeDelivery" name="shipping_charge" value="<?=isset($total) && $total>500?$shipping_charge:$shipping_charge; ?>" />
                                 <label class="custom-control-label" for="HomeDelivery">Home Delivery ?</label>
                              </div>
                              <div class="custom-control custom-checkbox mb-14 ShippingCharge" style="display: none;">
                                 <label class="control-label" >Home Delivery Charge Rs : <?=isset($total) && $total>500?$shipping_charge:$shipping_charge; ?></label>
                              </div>
                            </div>
                              <input type="hidden" name="amount" id="ctotal" value="<?=$total; ?>">
                              <input type="hidden" name="pv" value="<?=$userpv; ?>" id="userpv">
                              <input type="hidden" name="uid" value="<?=$mlmid; ?>">
                              <!-- <input type="hidden" name="fid" value="<?=isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid'])?$_SESSION['franchiseid']:''; ?>"> -->
                              <input type="hidden" name="type" value="payments">
                              <button type="submit" class="btn btn__bg" data-form="payments" id="OrderNowBtn">Place Ordear</button>
                              
                       
                        <?php    
                            
                            // $orderData = [ 
                            //   'receipt'         => 3456,
                            //   'amount'          => $total * 100, // 2000 rupees in paise
                            //   'currency'        => 'INR',
                            //   'payment_capture' => 1 // auto capture
                            // ];
                            // $razorpayOrder = $api->order->create($orderData);
                            // $razorpayOrderId = $razorpayOrder['id'];
                            // $_SESSION['razorpay_order_id'] = $razorpayOrderId;
                            // $displayAmount = $amount = $orderData['amount'];
                            // if ($displayCurrency !== 'INR')
                            // {
                            //     $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                            //     $exchange = json_decode(file_get_contents($url), true);
                            //     $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
                            // }
                            // $checkout = 'automatic';
                            // if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
                            // {
                            //     $checkout = $_GET['checkout'];
                            // }
                            // $data = [
                            //             "key"               => $keyId,
                            //             "amount"            => $amount,
                            //             "name"              => $data['first_name']." ".$data['last_name'],
                            //             "description"       => "Varietiz Pharma PVT. LTD.",
                            //             "image"             => "http://varietiz.com/images/logo.jpeg",
                            //             "prefill"           => [
                            //             "name"              => $data['first_name']." ".$data['last_name'],
                            //             "email"             => $data['email'],
                            //             "contact"           => $data['phone'],
                            //             ],
                            //             "notes"             => [
                            //             "address"           => $data['address'],
                            //             "merchant_order_id" => "123123211",
                            //             ],
                            //             "theme"             => [
                            //             "color"             => "#62d2a2"
                            //             ],
                            //             "order_id"          => $razorpayOrderId,
                            //         ];
                            // if ($displayCurrency !== 'INR')
                            // {
                            //     $data['display_currency']  = $displayCurrency;
                            //     $data['display_amount']    = $displayAmount;
                            // }
                            // $json = json_encode($data);
                            
                        ?>
                    
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
<?php include('linkfooter.php'); ?>

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
  <?php
  $data= $_SESSION['message'];
  echo  $data;
  ?>
</div>

  <script>
     function yeornosponsor(val){
        if(val==1){
          $('.va_hide').css('display','block');
          $('.getSponsordetail').val('');
        }
        else{
            $('.va_hide').css('display','none');
            $('.getSponsordetail').val('admin');
        }
     } 
      var data=<?php echo $_SESSION['message']?>
   // swal(data.message);
     swal("FAIL!", data.message, "error")
     <?php unset($_SESSION['message']);?>
    </script>
    
    