<?php
include('header.php'); ?>
<!-- main wrapper start -->
<link rel='dns-prefetch' href='http://s.w.org/' />
    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h2>Cart</h2>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">cart</li>
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
                                        <th class="pro-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	$subtotal=0;
                                		while ($cr=mysqli_fetch_assoc($result)) 
                                		{
                                			$pr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `products` WHERE product_id=".$cr['product_id']));
                                            $total_price=$cr['price']*$cr['qty'];
                                            $subtotal+=$total_price;
                                		
                                	?>
                                    <tr class="item">
                                        <td class="pro-thumbnail"><a href="prodyct_detail?id=<?=$pr['prodyct_id']; ?>"><img class="img-fluid" src="upload/product/<?=$pr['image']; ?>"
                                                    alt="Product" /></a></td>
                                        <td class="pro-title"><a href="prodyct_detail?id=<?=$pr['prodyct_id']; ?>"><?=$pr['name']; ?></a></td>
                                        <td class="pro-price"><span>RM <?=$cr['price']; ?></span></td>
                                        <td class="pro-quantity">
                                            <div><input type="number" min="1" id="qty<?=$cr['cart_id']; ?>" class="UpdateCart form-control" value="<?=$cr['qty']; ?>"data-id="<?=$cr['product_id']; ?>" data-price="<?=$cr['price']; ?>" data-qty="qty<?=$cr['cart_id']; ?>" style="width: 100px;"></div>
                                        </td>
                                        <td class="pro-subtotal"><span class="subtotal<?=$cr['product_id']; ?>">RM <?=$total_price; ?></span></td>
                                        <td class="pro-remove"><a href="javascript:void(0);" class="DeleteCart" data-id="<?=$cr['cart_id']; ?>"><i class="fa fa-trash-o"></i></a></td>
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
                                <h3>Cart Totals</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Total</td>
                                            <td id="carttotal">RM <?=$subtotal; ?></td>
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
                            <a href="checkouts?checkout=manual" class="btn btn__bg  GotoCheckout" style="width:100%;color: white;<?=isset($subtotal) && $subtotal > 0 ?'':'display: none;'?>">Proceed To Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>
    <!-- main wrapper end -->
<?php include('footer.php'); ?>
<?php include('linkfooter.php'); ?>
