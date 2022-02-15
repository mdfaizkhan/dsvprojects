<?php include 'header.php';
if(isset($_GET['id']) && !empty($_GET['id']))
{
	
	$tid=$_GET['id'];
	$data=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `checkout` WHERE id='$tid'"));
    $uid=$data['uid'];
    $shipping_charge=$data['shipping_charge'];
    $udata=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.uid,t1.uname,t1.image,t2.* FROM user_id t1 LEFT JOIN user_detail t2 on t1.uid=t2.uid WHERE t1.uid='$uid' "));
	$result=mysqli_query($db,"SELECT * FROM `cart` WHERE transaction_id='$tid'");
	//echo isset($udata['first_name'])?$udata['first_name']:''; die;
//var_dump($udata);die;
}
?>
<main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h2>Order Summury</h2>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Order Summury</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Cart Table Area -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Thumbnail</th>
                                        <th class="pro-title">Product</th>
                                        <th class="pro-price">Price</th>
                                        <th class="pro-quantity">Quantity</th>
                                        <th class="pro-subtotal">Total</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	$subtotal=0;
                                		while ($cr=mysqli_fetch_assoc($result)) 
                                		{
                                			$pr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `products` WHERE product_id=".$cr['product_id']));
                                		
                                	?>
                                    <tr class="item">
                                        <td class="pro-thumbnail"><a href="prodyct_detail?id=<?=$pr['prodyct_id']; ?>"><img class="img-fluid" src="upload/product/<?=$pr['image']; ?>"
                                                    alt="Product" /></a></td>
                                        <td class="pro-title"><a href="prodyct_detail?id=<?=$pr['prodyct_id']; ?>"><?=$pr['name']; ?></a></td>
                                        <td class="pro-price"><span>₹<?=$cr['price']; ?></span></td>
                                        <td class="pro-quantity">
                                            <div><?=$cr['qty']; ?></div>
                                        </td>
                                        <td class="pro-subtotal"><span class="subtotal<?=$cr['product_id']; ?>">₹<?=$subtotal+=$cr['price']*$cr['qty']; ?></span></td>
                                       
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                        <!-- <div class="cart-update-option d-block d-md-flex justify-content-between">
                            <div class="apply-coupon-wrapper">
                                <form action="#" method="post" class=" d-block d-md-flex">
                                    <input type="text" placeholder="Enter Your Coupon Code" required />
                                    <button class="btn btn__bg btn__sqr">Apply Coupon</button>
                                </form>
                            </div>
                            <div class="cart-update mt-sm-16">
                                <a href="#" class="btn btn__bg btn__sqr">Update Cart</a>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 ml-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h3>Order Totals</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <?php if(isset($shipping_charge) && $shipping_charge > 0)
                                        { ?>
                                        <tr>
                                            <td>Shipping Charge</td>
                                            <td id="carttotal">₹<?=$shipping_charge; ?></td>
                                        </tr>
                                    <?php } ?>
                                        <tr>
                                            <td>Total</td>
                                            <td id="carttotal">₹<?=$subtotal; ?></td>
                                        </tr>
                                        <!-- <tr>
                                            <td>Shipping</td>
                                            <td>$70</td>
                                        </tr> -->
                                        <!-- <tr class="total">
                                            <td>Total</td>
                                            <td class="total-amount">$300</td>
                                        </tr> -->
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>
<?php include 'footer.php';  ?>
 <script type="text/javascript" src="customjs/sweetalert2.all.min.js"></script>
 <script>
var data=<?php echo $_SESSION['message']?>
   // swal(data.message);
     swal("Success!", data.message, "success")
     <?php unset($_SESSION['message']);?>
    </script>
    