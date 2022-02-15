<?php include('header.php');

   if(empty($_SESSION["mlmrole"]))
   {
     session_destroy();
      echo '<script>location.href="login"</script>';
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
                     <h2>Product</h2>
                     <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product</li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- breadcrumb area end -->
   <!-- page main wrapper start -->
   <div class="shop-main-wrapper pt-60 pb-60">
      <div class="container">
         <div class="row">
            <!-- shop main wrapper start -->
            <div class="col-lg-12 order-1 order-lg-2">
               <div class="shop-product-wrapper">
                  <!-- shop product top wrap start -->
                  <div class="shop-top-bar">
                     <div class="row">
                        <div class="col-xl-5 col-lg-4 col-md-3 order-2 order-md-1">
                           <div class="top-bar-left">
                              <div class="product-view-mode">
                                 <a class="active" href="#" data-target="grid-view"><i class="fa fa-th"></i></a>
                                 <a href="#" data-target="list-view"><i class="fa fa-list"></i></a>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="col-xl-7 col-lg-8 col-md-9 order-1 order-md-2">
                           <div class="top-bar-right">
                              <div class="product-short">
                                 <p>Sort By : </p>
                                 <select class="nice-select" name="sortby">
                                    <option value="trending">Relevance</option>
                                    <option value="sales">Name (A - Z)</option>
                                    <option value="sales">Name (Z - A)</option>
                                    <option value="rating">Price (Low &gt; High)</option>
                                    <option value="date">Rating (Lowest)</option>
                                       <option value="price-asc">Model (A - Z)</option>
                                       <option value="price-asc">Model (Z - A)</option>
                                 </select>
                              </div>
                              <div class="product-amount">
                                 <p>Showing 1–16 of 21 results</p>
                              </div>
                           </div>
                        </div> -->
                     </div>
                  </div>
                  <!-- shop product top wrap start -->
                  <!-- product item list start -->
                  <div class="shop-product-wrap grid-view row">
                     <?php
                        $req='';
                            $sql="select * from  products";
                            $q1=Pagination($db,$sql,'',$req,'9');
                            while($r1=mysqli_fetch_assoc($q1['result']))            
                            {
                                $prd_id=$r1['product_id'];
                                $all_rat=0;
                                $avg_rating=0;
                                $rat_q=mysqli_query($db,"SELECT rating FROM `review` WHERE product_id='$prd_id'");
                                $rat_no=mysqli_num_rows($rat_q);
                                while ($rat_data=mysqli_fetch_assoc($rat_q)) {
                                  $all_rat+=$rat_data['rating'];
                                }
                                if(isset($rat_no) && $rat_no > 0)
                                {
                                  $avg_rating=$all_rat/$rat_no;
                                }
                        ?>
                     <div class="col-lg-3 col-md-3 col-sm-6">
                        <!-- product grid item start -->
                        <div class="product-item mb-50">
                           <div class="product-thumb">
                              <a href="product_detail?id=<?=$r1['product_id']; ?>">
                              <img src="upload/product/<?=$r1['image']; ?>" alt="" style="height:100% !important;width:60%">
                              </a>
                              <div class="quick-view-link">
                                 <!-- <a href="#" data-toggle="modal" data-target="#quick_view"> -->
                                 <a href="product_detail?id=<?=$r1['product_id']; ?>"> <span
                                    data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                                 </a>
                              </div>
                           </div>
                           <div class="product-content text-center">
                              <div class="ratings">
                                 <?php for($i=1;$i<6;$i++)
                                   /*{ 
                                     if(isset($avg_rating) && $avg_rating>=$i)
                                     {
                                   ?>
                                    <span><i class="ion-android-star"></i></span>
                                  <?php } else { ?>
                                    
                                    <span><i class="ion-android-star-outline"></i></span>
                                 <?php } }*/ ?>
                              </div>
                              <div class="product-name">
                                 <h4 class="h5">
                                    <a href="product_detail"><?=$r1['name']; ?></a>
                                 </h4>
                              </div>
                              <div class="price-box">
                                <?php
                                  
                                  if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
                                  {
                                    $prd_price=$r1['fp'];
                                  } 
                                  else{
                                    $prd_price=$r1['mrp'];
                                  }                                  
                                  if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
                                  {
                                    $chk_pur=IsDistributor($db,$_SESSION['mlmid']);
                                    // if($chk_pur > 0)
                                    // {
                                    //   $prd_price=$r1['dp'];
                                    // }
                                    // else
                                    // {
                                      $prd_price=$r1['mrp'];
                                    //}
                                  }
                                ?>
                                 <span class="regular-price">RM <?=$prd_price; ?></span>
                                 
                              </div>
                              <div class="product-action-link">
                                 <!-- <a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a> -->
                                 <a href="javascript:void(0);" class="AddToCart" onclick="Add_cart(<?=$r1['product_id']; ?>,<?=$prd_price; ?>,'1')" data-toggle="tooltip" title="Add to cart"><i class="ion-bag"></i></a>
                                 <!-- <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a> -->
                              </div>
                           </div>
                        </div>
                        <!-- product grid item end -->
                        <!-- product list item start -->
                        <div class="product-list-item mb-30">
                           <div class="product-thumb">
                              <a href="product_detail?id=<?=$r1['product_id']; ?>">
                              <img src="upload/product/<?=$r1['image']; ?>" alt="" style="height:100% !important;width:60%">
                              </a>
                              <div class="quick-view-link">
                                 <a href="product_detail?id=<?=$r1['product_id']; ?>" ><span data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                                 </a>
                              </div>
                           </div>
                           <div class="product-content-list">
                              <div class="ratings">
                                 <?php for($i=1;$i<6;$i++)
                                  /* { 
                                     if(isset($avg_rating) && $avg_rating>=$i)
                                     {
                                   ?>
                                    <span><i class="ion-android-star"></i></span>
                                  <?php } else { ?>
                                    
                                    <span><i class="ion-android-star-outline"></i></span>
                                 <?php } } */?>
                              </div>
                              <div class="product-name">
                                 <h4><a href="product_detail?id=<?=$r1['product_id']; ?>"><?=$r1['name']; ?></a></h4>
                              </div>
                              <div class="price-box">
                                 <span class="regular-price"> RM <?=$prd_price; ?></span>
                                 
                              </div>
                              <p><?=$r1['product_desc']; ?>
                              </p>
                              <div class="action-link">
                                 <a href="javascript:void(0);" data-toggle="tooltip" title="Add to cart" class="add-to-cart" onclick="Add_cart(<?=$r1['product_id']; ?>,<?=$prd_price; ?>,'1')">add
                                 to cart</a>
                                 <!-- <a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>
                                 <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a> -->
                              </div>
                           </div>
                        </div>
                        <!-- product list item start -->
                     </div>
                     <?php } ?>
                  </div>
                  <!-- product item list end -->
                  <!-- start pagination area -->
                  <div class="paginatoin-area text-center mt-30" >
                     <!-- <ul class="pagination-box">
                        <li><a class="Previous" href="#"><i class="ion-ios-arrow-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a class="Next" href="#"><i class="ion-ios-arrow-right"></i></a></li>
                        </ul> -->
                     <div class="text-center prdpage">
                        <?php echo $q1['pagination']; ?>
                     </div>
                  </div>
                  <!-- end pagination area -->
               </div>
            </div>
            <!-- shop main wrapper end -->
         </div>
      </div>
   </div>
   <!-- page main wrapper end -->
</main>
<!-- main wrapper end -->
<!-- Quick view modal start -->
<div class="modal" id="quick_view">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <!-- product details inner end -->
            <div class="product-details-inner">
               <div class="row">
                  <div class="col-lg-5 col-md-6">
                     <div class="product-large-slider mb-20 slider-arrow-style slider-arrow-style__style-2">
                        <div class="pro-large-img">
                           <img src="assets/img/product/product-details-img1.jpg" alt="" />
                        </div>
                        <div class="pro-large-img">
                           <img src="assets/img/product/product-details-img2.jpg" alt="" />
                        </div>
                        <div class="pro-large-img">
                           <img src="assets/img/product/product-details-img3.jpg" alt="" />
                        </div>
                        <div class="pro-large-img">
                           <img src="assets/img/product/product-details-img4.jpg" alt="" />
                        </div>
                     </div>
                     <div class="pro-nav slick-padding_2 slider-arrow-style slider-arrow-style__style-2">
                        <div class="pro-nav-thumb"><img src="assets/img/product/product-details-img1.jpg"
                           alt="" /></div>
                        <div class="pro-nav-thumb"><img src="assets/img/product/product-details-img2.jpg"
                           alt="" /></div>
                        <div class="pro-nav-thumb"><img src="assets/img/product/product-details-img3.jpg"
                           alt="" /></div>
                        <div class="pro-nav-thumb"><img src="assets/img/product/product-details-img4.jpg"
                           alt="" /></div>
                     </div>
                  </div>
                  <div class="col-lg-7 col-md-6">
                     <div class="product-details-des">
                        <div class="product-content-list">
                           
                           <div class="product-name">
                              <h4><a href="product_detail">Organic vegetables</a></h4>
                           </div>
                           <div class="price-box">
                              <span class="regular-price">RM 160.00</span>
                              
                           </div>
                           <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue
                              nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi
                              ornare lectus quis justo gravida semper.
                           </p>-->
                           <div class="action-link mb-20">
                              <a href="#" data-toggle="tooltip" title="Add to cart" class="add-to-cart">add
                              to cart</a>
                              
                           </div>
                           <div class="quantity mb-20">
                              <div class="pro-qty"><input type="text" value="1"></div>
                           </div>
                           <!--<div class="availability mb-20">
                              <h5>Availability:</h5>
                              <span>10 in stock</span>
                           </div>-->
                           <div class="share-icon">
                              <h5>share:</h5>
                              <a href="#"><i class="fa fa-facebook"></i></a>
                              <a href="#"><i class="fa fa-twitter"></i></a>
                              <a href="#"><i class="fa fa-pinterest"></i></a>
                              <a href="#"><i class="fa fa-google-plus"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- product details inner end -->
         </div>
      </div>
   </div>
</div>
<!-- Quick view modal end -->
<?php include('footer.php'); ?>
<?php include('linkfooter.php'); ?>
  
