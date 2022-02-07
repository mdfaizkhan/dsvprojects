<?php include('header.php'); 
   if(empty($_SESSION["mlmrole"]))
   {
     session_destroy();
      echo '<script>location.href="login"</script>';
   }
   if(isset($_GET['id']) && !empty($_GET['id']))
   {
       $product_id=$_GET['id'];
       $data=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `products` WHERE product_id='$product_id'"));
      if(isset($_SESSION['mlmid']))
      {
          $uid=$_SESSION['mlmid'];
          $result1=mysqli_query($db, "SELECT * FROM cart where uid='$uid' and product_id='$product_id' and transaction_id IS null");
      }
      
      $cart=mysqli_fetch_assoc($result1);
   }
   ?>
   <?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

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
                        <li class="breadcrumb-item active" aria-current="page">product details</li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- breadcrumb area end -->
   <!-- page main wrapper start -->
   <div class="product-details-wrapper pt-60 pb-60">
      <div class="container">
         <div class="row">
            <div class="col-lg-5 col-md-6">
               <div class="product-large-slider img-zoom mb-20 slider-arrow-style slider-arrow-style__style-2">
                  <div class="pro-large-img">
                     <img src="upload/product/<?=$data['image']; ?>" alt="" />
                  </div>
                  <?php
                     $result = mysqli_query($db, "SELECT * FROM prd_images WHERE product_id=".$product_id);
                     if(mysqli_num_rows($result)>0)
                     {
                         while ($r1=mysqli_fetch_assoc($result)) {
                     ?>
                  <div class="pro-large-img">
                     <img src="upload/product/<?=$r1['image']; ?>" alt="" />
                  </div>
                  <?php } } ?>
               </div>
               <div class="pro-nav slick-padding_2 slider-arrow-style slider-arrow-style__style-2">
                  <div class="pro-nav-thumb"><img src="upload/product/<?=$data['image']; ?>" alt="" /></div>
                  <?php
                     $result = mysqli_query($db, "SELECT * FROM prd_images WHERE product_id=".$product_id);
                     if(mysqli_num_rows($result)>0)
                     {
                         while ($r1=mysqli_fetch_assoc($result)) {
                     ?>
                  <div class="pro-nav-thumb"><img src="upload/product/<?=$r1['image']; ?>" alt="" /></div>
                  <?php } } ?>
               </div>
            </div>
            <div class="col-lg-7 col-md-6">
               <div class="product-details-des">
                  <div class="product-content-list">
                     <div class="ratings">
                        <?php
                          $prd_id1=$data['product_id'];
                          $all_rat1=0;
                          $avg_rating1=0;
                          $rat_q1=mysqli_query($db,"SELECT rating FROM `review` WHERE product_id='$prd_id1'");
                          $rat_no1=mysqli_num_rows($rat_q1);
                          while ($rat_data1=mysqli_fetch_assoc($rat_q1)) {
                            $all_rat1+=$rat_data1['rating'];
                          }
                          if(isset($rat_no1) && $rat_no1 > 0)
                          {
                            $avg_rating1=$all_rat1/$rat_no1;
                          }
                        ?>
                        <?php for($j=1;$j<6;$j++)
                         /* { 
                            if(isset($avg_rating1) && $avg_rating1>=$j)
                            {
                          ?>
                           <span><i class="ion-android-star"></i></span>
                         <?php } else { ?>
                           
                           <span><i class="ion-android-star-outline"></i></span>
                        <?php } } */?>
                     </div>
                     <div class="product-name">
                        <h4><a href="javascript:void(0);"><?=$data['name']; ?></a></h4>
                     </div>
                     <?php
                        $prd_price=$data['mrp'];
                        /*if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
                        {
                          $prd_price=$data['fp'];
                        }*/
                        if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
                        {
                          $chk_pur=IsDistributor($db,$_SESSION['mlmid']);
                          if($chk_pur > 0)
                          {
                            //$prd_price=$data['dp'];
                            $prd_price=$data['mrp'];
                          }
                        }
                      ?>
                     <div class="price-box">
                        <span class="regular-price">RM <?=$prd_price; ?></span>
                        
                     </div>
                     <p><?=$data['product_desc']; ?></p>
                     <div class="action-link mb-20">
                        <a href="javascript:void(0);" data-toggle="tooltip" title="Add to cart" class="add-to-cart" onclick="Add_cart1(<?=$data['product_id']; ?>,<?=$prd_price; ?>,'qty');">add to
                        cart</a>
                        <!-- <a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>
                           <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a> -->
                     </div>
                     <div class="quantity mb-20">
                        <div class="pro-qty"><input type="text" value="<?=isset($cart['qty'])?$cart['qty']:1; ?>" name="qty" id="qty"></div>
                     </div>
                     <!-- <div class="availability mb-20">
                        <h5>Availability:</h5>
                        <span>10 in stock</span>
                        </div> -->
                        
                     <div class="share-icon">
                        <h5>share:</h5>
                        <?php
                        //echo $actual_link;
                        echo'<a href="http://www.facebook.com/share.php?u='.$actual_link.'" target="_blank"><i class="fa fa-facebook"></i></a>';
                        echo '<a href="https://twitter.com/share?url='.$actual_link.'&amp;text=YOUR_TITLE&amp;hashtags=YOUR_HASHTAGS" target="_blank"><i class="fa fa-twitter"></i></a>';
                        echo '<a href="https://api.whatsapp.com/send?text='.$actual_link.'" target="_blank"><i class="fa fa-whatsapp"></i></a>';
                        echo '<a href="https://plus.google.com/share?url='.$actual_link.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
                        echo '<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$actual_link.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
                        ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <!-- product details reviews start -->
               <div class="product-details-reviews pt-60">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="product-review-info">
                           <div class="review-tab" >
                              <ul class="nav">
                                 <li>
                                    <a class="active" data-toggle="tab" href="#tab_one">description</a>
                                 </li>
                                 <li>
                                    <a data-toggle="tab" href="#tab_three">reviews</a>
                                 </li>
                              </ul>
                           </div>
                           <div class="tab-content reviews-tab" style="width:80%;">
                              <div class="tab-pane fade show active" id="tab_one">
                                 <div class="tab-one">
                                    <p><?=$data['product_desc']; ?></P>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="tab_three">
                                 <form id="ManageReview" class="review-form" method="POST">
                                  <?php
                                     $rq=mysqli_query($db,"SELECT t1.*,t2.uname,t2.image FROM `review` t1 LEFT JOIN user_id t2 on t1.uid=t2.uid WHERE t1.product_id='$product_id' ") or die(mysqli_error($db));
                                     $rno=mysqli_num_rows($rq);
                                  ?>
                                    <h5><?=$rno; ?> review for <span><?=$data['name']; ?></span></h5>
                                    <div class="all-review">
                                    <?php 
                                   
                                    while ($rr=mysqli_fetch_assoc($rq)) {
                                    ?>
                                    <div class="total-reviews">
                                       <div class="rev-avatar">
                                        <?php if(isset($rr['image']) && file_exists("upload/profile".$rr['image']))
                                        { ?>
                                          <img src="upload/profile/<?=$rr['image']; ?>" alt="">
                                        <?php } else { ?>
                                          <img src="images/no-image.png" alt="">
                                        <?php } ?>
                                       </div>
                                       <div class="review-box">
                                          <div class="ratings">
                                            <?php for($i=1;$i<6;$i++)
                                            { 
                                              if(isset($rr['rating']) && $rr['rating']>=$i)
                                              {
                                            ?>
                                             <span><i class="ion-android-star"></i></span>
                                           <?php } else { ?>
                                             
                                             <span><i class="ion-android-star-outline"></i></span>
                                           <?php } } ?>
                                          </div>
                                          <div class="post-author">
                                             <p><span><?=$rr['uname']; ?> -</span><?=date("d M, Y",strtotime($rr['date'])); ?> </p>
                                          </div>
                                          <p><?=$rr['review']; ?>
                                          </p>
                                       </div>
                                    </div>
                                  <?php } ?>
                                  </div>
                                    <div class="form-group row">
                                       <div class="col">
                                          <label class="col-form-label"><span class="text-danger">*</span>
                                          Your Name</label>
                                          <input type="text" class="form-control" name="name" id="name" required>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col">
                                          <label class="col-form-label"><span class="text-danger">*</span>
                                          Your Email</label>
                                          <input type="email" class="form-control" name="email" id="email" required>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col">
                                          <label class="col-form-label"><span class="text-danger">*</span>
                                          Your Review</label>
                                          <textarea class="form-control" name="review" id="review" required></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col">
                                          <label class="col-form-label"><span class="text-danger">*</span>
                                          Rating</label>
                                          &nbsp;&nbsp;&nbsp; Bad&nbsp;
                                          <input type="radio" value="1" name="rating" class="rating">
                                          &nbsp;
                                          <input type="radio" value="2" name="rating" class="rating">
                                          &nbsp;
                                          <input type="radio" value="3" name="rating" class="rating">
                                          &nbsp;
                                          <input type="radio" value="4" name="rating" class="rating">
                                          &nbsp;
                                          <input type="radio" value="5" name="rating" class="rating" checked>
                                          &nbsp;Good
                                       </div>
                                    </div>
                                    <div class="buttons">
                                      <input type="hidden" name="product_id" value="<?=$product_id; ?>">
                                      <input type="hidden" name="type" value="ManageReview">
                                       <button type="submit" class="btn btn__btn-gray formvalidate" data-form="" type="submit">Continue</button>
                                    </div>
                                 </form>
                                 <!-- end of review-form -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- product details reviews end -->
            </div>
         </div>
      </div>
   </div>
    <!-- page main wrapper end -->
   <!-- related product area start 
   <section class="related-product pb-30">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="section-title text-center">
                  <h2>related product</h2>
               </div>
            </div>
         </div>
         <div class="row related-product-active slick-arrow-style" >
          <?php
            $qry=mysqli_query($db,"SELECT * FROM `products` WHERE cat_id='$cat_id'");
            while($rr=mysqli_fetch_assoc($qry))
            {
              $prd_id=$rr['product_id'];
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
              $prd_price1=$rr['mrp'];
              /*if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
              {
                $prd_price1=$rr['fp'];
              }*/
              if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
              {
                $chk_pur=IsDistributor($db,$_SESSION['mlmid']);
                if($chk_pur > 0)
                {
                  //$prd_price1=$rr['dp'];
                  $prd_price1=$rr['mrp'];
                }
              }
          ?>
            <div class="col">
               <div class="product-item mb-50">
                  <div class="product-thumb">
                     <a href="product_detail?id=<?=$rr['product_id']; ?>">
                     <img src="upload/product/<?=$rr['image']; ?>" alt="<?=$rr['name']; ?>">
                     </a>
                     <div class="quick-view-link">
                        <a href="product_detail?id=<?=$rr['product_id']; ?>"> <span data-toggle="tooltip"
                           title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                     </div>
                  </div>
                  <div class="product-content text-center">
                     <div class="ratings">
                        <?php for($i=1;$i<6;$i++)
                         /* { 
                            if(isset($avg_rating) && $avg_rating>=$i)
                            {
                          ?>
                           <span><i class="ion-android-star"></i></span>
                         <?php } else { ?>
                           
                           <span><i class="ion-android-star-outline"></i></span>
                        <?php } } */ ?>
                     </div>
                     <div class="product-name">
                        <h4 class="h5">
                         <a href="product-details?id=<?=$prd_id; ?>"><?=$rr['name']; ?></a>
                           <a href="product_detail?id=<?=$rr['product_id']; ?>"><?=$rr['name']; ?></a>
                        </h4>
                     </div>
                     <div class="price-box">
                        <span class="regular-price">₹<?=$prd_price1; ?></span>
                        
                     </div>
                     <div class="product-action-link">
                       <a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a> 
                        <a href="javascript:void(0);" class="AddToCart" onclick="Add_cart(<?=$rr['product_id']; ?>,<?=$prd_price1; ?>,'1')" data-toggle="tooltip" title="Add to cart"><i class="ion-bag"></i></a>
                         <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a> 
                     </div>
                  </div>
               </div>
            </div>
          <?php } ?> 
         </div>
      </div>
   </section> -->
   <!-- related product area end -->
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
                              <h4><a href="product-details.html">Organic vegetables</a></h4>
                           </div>
                           <div class="price-box">
                              <span class="regular-price">$160.00</span>
                              >
                           </div>
                           <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue
                              nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi
                              ornare lectus quis justo gravida semper.
                           </p>-->
                           <div class="action-link mb-20">
                              <a href="#" data-toggle="tooltip" title="Add to cart" class="add-to-cart">add
                              to cart</a>
                             <!-- <a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>
                              <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a>-->
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
                                <?php
                                //echo $actual_link;
                                echo'<a href="http://www.facebook.com/share.php?u='.$actual_link.'" target="_blank"><i class="fa fa-facebook"></i></a>';
                                echo '<a href="https://twitter.com/share?url='.$actual_link.'&amp;text=YOUR_TITLE&amp;hashtags=YOUR_HASHTAGS" target="_blank"><i class="fa fa-twitter"></i></a>';
                                echo '<a href="https://web.whatsapp.com/send?text='.$actual_link.'" target="_blank"><i class="fa fa-whatsapp"></i></a>';
                                echo '<a href="https://plus.google.com/share?url='.$actual_link.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
                                echo '<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$actual_link.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
                                ?>
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