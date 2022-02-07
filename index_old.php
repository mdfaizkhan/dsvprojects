<?php include('header.php'); ?>

    <!-- main wrapper start -->
    <main>
        <!-- hero slider area start -->
        <section class="hero-slider-area">
            <div class="hero-slider-active slider-arrow-style">
                <div class="single-slider">
                    <div class="hero-bg hero-bg__2 hero-bg__5" style="background-image:url(upload/slider/slider1.jpg)">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="content-inner">
                                        <!-- <div class="slider-content slider-content__style-2">
                                            <h1>Fresh Fruits and Vegetables Collection</h1>
                                            <p>We deliver organic fruits and vegetables fresh from<br> our fields to your doorstep </p>
                                            <a href="shop.html" class="btn btn__bg">shop now</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider">
                    <div class="hero-bg hero-bg__2 hero-bg__5" style="background-image:url(upload/slider/slider2.jpg)">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="content-inner">
                                        <!-- <div class="slider-content slider-content__style-2">
                                            <h1>Fresh Fruits and Vegetables Collection</h1>
                                            <p>We deliver organic fruits and vegetables fresh from<br> our fields to your doorstep </p>
                                            <a href="shop.html" class="btn btn__bg">shop now</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider">
                    <div class="hero-bg hero-bg__2 hero-bg__5" style="background-image:url(upload/slider/slider3.jpg)">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="content-inner">
                                        <!-- <div class="slider-content slider-content__style-2">
                                            <h1>Fresh Fruits and Vegetables Collection</h1>
                                            <p>We deliver organic fruits and vegetables fresh from<br> our fields to your doorstep </p>
                                            <a href="shop.html" class="btn btn__bg">shop now</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider">
                    <div class="hero-bg hero-bg__2 hero-bg__5" style="background-image:url(upload/slider/slider4.jpg)">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="content-inner">
                                        <!-- <div class="slider-content slider-content__style-2">
                                            <h1>Fresh Fruits and Vegetables Collection</h1>
                                            <p>We deliver organic fruits and vegetables fresh from<br> our fields to your doorstep </p>
                                            <a href="shop.html" class="btn btn__bg">shop now</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero slider area start -->

        <!-- banner statistic area start -->
        <!--<div class="banner-statistics pt-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="img-container mb-sm-30">
                            <a href="product-details.html">
                                <img src="assets/img/banner/banner-2.jpg" alt="banner-image">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="img-container mb-sm-30">
                            <a href="product-details.html">
                                <img src="assets/img/banner/banner-1.jpg" alt="banner-image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- banner statistic area end -->

        <!-- daily deals area start -->
        <section class="daily-deal-area pt-60 pt-sm-30 pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2>Deal of the Month</h2>
                        </div>
                    </div>
                </div>
                <div class="row deal-carousel-active--2 slick-arrow-style">
                    <?php
                        $sql="SELECT t1.*,t2.cat_name FROM products t1 left join product_category t2 on t1.cat_id=t2.cat_id where t1.deal_of_day=1 AND t1.status=0 order by product_id";
                            $q1=mysqli_query($db,$sql);
                        while($r1=mysqli_fetch_assoc($q1))            
                        {
                            $prd_id=$r1['product_id'];
                            $all_rat=0;
                            $avg_rating=0;
                            /*$rat_q=mysqli_query($db,"SELECT rating FROM `review` WHERE product_id='$prd_id'");
                            $rat_no=mysqli_num_rows($rat_q);
                            while ($rat_data=mysqli_fetch_assoc($rat_q)) {
                              $all_rat+=$rat_data['rating'];
                            }
                            if(isset($rat_no) && $rat_no > 0)
                            {
                              $avg_rating=$all_rat/$rat_no;
                            }*/
                    ?>
                    <div class="col">
                        <div class="product-item mb-50">
                            <div class="product-thumb">
                                <a href="product_detail?id=<?=$r1['product_id']; ?>">
                                    <img src="upload/product/<?=$r1['image']; ?>" alt="">
                                </a>
                                <div class="quick-view-link">
                                    <a href="product_detail?id=<?=$r1['product_id']; ?>"> <span data-toggle="tooltip"
                                            title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                </div>
                            </div>
                            <div class="product-content text-center">
                                <!--<div class="ratings">
                                    <span><i class="ion-android-star"></i></span>
                                    <span><i class="ion-android-star"></i></span>
                                    <span><i class="ion-android-star"></i></span>
                                    <span><i class="ion-android-star"></i></span>
                                    <span><i class="ion-android-star"></i></span>
                                </div>-->
                                <div class="product-name">
                                    <h4 class="h5">
                                        <a href="product_detail"><?=$r1['name']; ?></a>
                                    </h4>
                                </div>
                                <div class="price-box">
                                    <?php
                                  $prd_price=$r1['mrp'];

                                  if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
                                  {
                                    $prd_price=$r1['fp'];
                                  }
                                  else if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
                                  {
                                    $chk_pur=IsDistributor($db,$_SESSION['mlmid']);
                                    if($chk_pur > 0)
                                    {
                                      $prd_price=$r1['dp'];
                                    }
                                  }
                                ?>
                                 <span class="regular-price">₹<?=$prd_price; ?></span>
                                    
                                </div>
                                <!--<div class="product-countdown deal-timer" data-countdown="2020/05/01"></div>-->
                                <div class="product-action-link">
                                    <!--<a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>-->
                                    <a href="javascript:void(0);" class="AddToCart" onclick="Add_cart(<?=$r1['product_id']; ?>,<?=$prd_price; ?>,'1')" data-toggle="tooltip" title="Add to cart"><i class="ion-bag"></i></a>
                                   <!-- <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </section>
        <!-- daily deals area end -->

        <!-- popular category start -->
        <!-- <section class="popular-category bg-gray pb-60 pb-md-30 pb-sm-30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center pt-62">
                            <h2>Popular Categories</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="category-single-item mb-md-30 mb-sm-30">
                            <div class="category-item-inner color1 text-center">
                                <div class="category-content">
                                    <h2><a href="product-details.html">vegetables</a></h2>
                                    <p>2 product</p>
                                </div>
                                <div class="category-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/category/cat-1.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="category-single-item mb-md-30 mb-sm-30">
                            <div class="category-item-inner color2 text-center">
                                <div class="category-content">
                                    <h2><a href="product-details.html">fruits</a></h2>
                                    <p>2 product</p>
                                </div>
                                <div class="category-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/category/cat-2.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="category-single-item mb-md-30 mb-sm-30">
                            <div class="category-item-inner color3 text-center">
                                <div class="category-content">
                                    <h2><a href="product-details.html">juice</a></h2>
                                    <p>2 product</p>
                                </div>
                                <div class="category-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/category/cat-3.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="category-single-item mb-md-30 mb-sm-30">
                            <div class="category-item-inner color4 text-center">
                                <div class="category-content">
                                    <h2><a href="product-details.html">meats</a></h2>
                                    <p>2 product</p>
                                </div>
                                <div class="category-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/category/cat-4.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </section> -->
        <!-- popular category end -->

        <!-- product tab area start -->
        <section class="trending-product pt-60 pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2>Trending Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- product tab menu start -->
                        <!--<div class="product-tab-menu pb-30">
                            <ul class="nav justify-content-center">
                                <li>
                                    <a class="active" data-toggle="tab" href="#tab_one">mango</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_two">vegetables</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_three">fruits</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_four">juice</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_five">meats</a>
                                </li>
                            </ul>
                        </div>-->
                        <!-- product tab menu end -->
                         <div class="product-tab-wrapper">
                            <div class="row">
                                <?php
                                $req='';
                                $sql1="SELECT t1.*,t2.cat_name FROM products t1 left join product_category t2 on t1.cat_id=t2.cat_id WHERE trending=1 AND t1.status=0 order by product_id";
                                $q11=mysqli_query($db,$sql1);
                                while($r1=mysqli_fetch_assoc($q11))            
                                {
                                    $prd_id=$r1['product_id'];
                                    $all_rat=0;
                                    $avg_rating=0;
                                    /*$rat_q=mysqli_query($db,"SELECT rating FROM `review` WHERE product_id='$prd_id'");
                                    $rat_no=mysqli_num_rows($rat_q);
                                    while ($rat_data=mysqli_fetch_assoc($rat_q)) {
                                      $all_rat+=$rat_data['rating'];
                                    }
                                    if(isset($rat_no) && $rat_no > 0)
                                    {
                                      $avg_rating=$all_rat/$rat_no;
                                    }*/
                                 ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="product-item mb-50">
                                        <div class="product-thumb">
                                            <a href="product_detail?id=<?=$r1['product_id']; ?>">
                                                <img src="upload/product/<?=$r1['image']; ?>" alt="">
                                            </a>
                                            <div class="quick-view-link">
                                                <a href="product_detail?id=<?=$r1['product_id']; ?>"><span
                                                data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-content text-center">
                                            
                                            <div class="product-name">
                                                <h4 class="h5">
                                                    <a href="product_detail"><?=$r1['name']; ?></a>
                                                </h4>
                                            </div>
                                            <div class="price-box">
                                                <?php
                                                    $prd_price=$r1['mrp'];
                                                    if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
                                                  {
                                                    $prd_price=$r1['fp'];
                                                  }
                                                  else if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
                                                    {
                                                        $chk_pur=IsDistributor($db,$_SESSION['mlmid']);
                                                    if($chk_pur > 0)
                                                    {
                                                        $prd_price=$r1['dp'];
                                                    }
                                                    }
                                                    ?>
                                                <span class="regular-price">₹<?=$prd_price; ?></span>
                                                
                                            </div>
                                            <div class="product-action-link">
                                                
                                                <a href="javascript:void(0);" class="AddToCart" onclick="Add_cart(<?=$r1['product_id']; ?>,<?=$prd_price; ?>,'1')" data-toggle="tooltip" title="Add to cart"><i class="ion-bag"></i></a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </section>
        <!-- product tab area end -->

        <!-- choose us and testimonial area start -->
        <section class="bg-gray pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-title text-center">
                                    <h2>why choose us</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="choose-us-wrapper">
                                    <div class="accordion" id="choose-us">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="accordio-heading" type="button" data-toggle="collapse"
                                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="ion-ribbon-b"></i>
                                                        100% fresh organic food
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#choose-us">
                                                <div class="card-body">
                                                    This is our motto and we are experts in delivering the best 100%
                                                    organicfoods on the market. We work with more than 60 farms all
                                                    over the country. We’re a locally owned business with staff that
                                                    has decades of experiencein the field of health and firm roots in
                                                    the health food industry
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <button class="accordio-heading" type="button" data-toggle="collapse"
                                                        data-target="#collapseTwo" aria-controls="collapseTwo">
                                                        <i class="ion-android-car"></i>
                                                        Fast Free Delivery
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                data-parent="#choose-us">
                                                <div class="card-body">
                                                    This is our motto and we are experts in delivering the best 100%
                                                    organicfoods on the market. We work with more than 60 farms all
                                                    over the country. We’re a locally owned business with staff that
                                                    has decades of experiencein the field of health and firm roots in
                                                    the health food industry
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingThree">
                                                <h5 class="mb-0">
                                                    <button class="accordio-heading" type="button" data-toggle="collapse"
                                                        data-target="#collapseThree" aria-controls="collapseThree">
                                                        <i class="ion-university"></i>
                                                        Rich Experience
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                                data-parent="#choose-us">
                                                <div class="card-body">
                                                    This is our motto and we are experts in delivering the best 100%
                                                    organicfoods on the market. We work with more than 60 farms all
                                                    over the country. We’re a locally owned business with staff that
                                                    has decades of experiencein the field of health and firm roots in
                                                    the health food industry
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-lg-6 col-md-12 pt-md-60 pt-sm-60">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-title text-center">
                                    <h2>What People Say</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="testimonial-wrapper">
                                    <div class="testimonial-tab-menu">
                                        <ul class="nav">
                                            <li>
                                                <a data-toggle="tab" href="#testimonial_one">
                                                    <img class="testimonial-thumb" src="assets/img/testimonial/team-member-1.jpg"
                                                        alt="">
                                                </a>
                                            </li>
                                            <li>
                                                <a class="active" data-toggle="tab" href="#testimonial_two">
                                                    <img class="testimonial-thumb" src="assets/img/testimonial/team-member-2.jpg"
                                                        alt="">
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#testimonial_three">
                                                    <img class="testimonial-thumb" src="assets/img/testimonial/team-member-3.jpg"
                                                        alt="">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="testimonial-tab-wrapper">
                                        <div class="tab-content">
                                            <div class="tab-pane fade" id="testimonial_one">
                                                <div class="testimonial-content-inner">
                                                    <p>“ Great theme, excellent support. We had a few small issues with
                                                        getting the dropdown menus to work and support fixed them and
                                                        let us know which files were changed so that we could replicate
                                                        from dev to production. Very happy both with the theme and the
                                                        company. Highly recommended. ”</p>
                                                    <div class="ratings">
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                    </div>
                                                    <div class="designation">
                                                        Raju Ahammad / <span>developer of HT</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade active show" id="testimonial_two">
                                                <div class="testimonial-content-inner">
                                                    <p>“ Great theme, excellent support. We had a few small issues with
                                                        getting the dropdown menus to work and support fixed them and
                                                        let us know which files were changed so that we could replicate
                                                        from dev to production. Very happy both with the theme and the
                                                        company. Highly recommended. ”</p>
                                                    <div class="ratings">
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                    </div>
                                                    <div class="designation">
                                                        Jenifer brown / <span>manager of HT</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="testimonial_three">
                                                <div class="testimonial-content-inner">
                                                    <p>“ Great theme, excellent support. We had a few small issues with
                                                        getting the dropdown menus to work and support fixed them and
                                                        let us know which files were changed so that we could replicate
                                                        from dev to production. Very happy both with the theme and the
                                                        company. Highly recommended. ”</p>
                                                    <div class="ratings">
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                        <span><i class="ion-android-star"></i></span>
                                                    </div>
                                                    <div class="designation">
                                                        erik jhonson / <span>designer of HT</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </section>
        <!-- choose us and testimonial area start -->

        <!-- best sellers area start -->
        <!--<section class="best-sellers pt-60 pb-60 pb-lg-30 pb-md-30 pb-sm-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="best-sellers-banner">
                            <img src="assets/img/banner/best-sellers.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="best-sellers-content pt-md-60 pt-sm-60">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section-title section-title__2">
                                        <h2>best sellers</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="single-item mb-30">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-1.jpg" alt="">
                                            </a>
                                            <div class="quick-view-link">
                                                <a href="#" data-toggle="modal" data-target="#quick_view"> <span
                                                        data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="tag-cate">
                                                <a href="product-details.html">fruits</a>
                                            </div>
                                            <div class="product-name">
                                                <h4 class="h5">
                                                    <a href="product-details.html">Condimentum food</a>
                                                </h4>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">$160.00</span>
                                                <span class="old-price"><del>$180.00</del></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-item mb-30">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-2.jpg" alt="">
                                            </a>
                                            <div class="quick-view-link">
                                                <a href="#" data-toggle="modal" data-target="#quick_view"> <span
                                                        data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="tag-cate">
                                                <a href="product-details.html">fruits</a>
                                            </div>
                                            <div class="product-name">
                                                <h4 class="h5">
                                                    <a href="product-details.html">Tincidunt malesuada</a>
                                                </h4>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">$130.00</span>
                                                <span class="old-price"><del>$140.00</del></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-item mb-30">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-3.jpg" alt="">
                                            </a>
                                            <div class="quick-view-link">
                                                <a href="#" data-toggle="modal" data-target="#quick_view"> <span
                                                        data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="tag-cate">
                                                <a href="product-details.html">fruits</a>
                                            </div>
                                            <div class="product-name">
                                                <h4 class="h5">
                                                    <a href="product-details.html">100% organic food</a>
                                                </h4>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">$99.00</span>
                                                <span class="old-price"><del></del></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>-->
        <!-- best sellers area end -->

        <!-- product tab area start -->
        <section class="our-product pt-60">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2>Our Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row product-carousel-active--4 slick-arrow-style">
                    <?php
                        $req='';
                        $sql2="SELECT t1.*,t2.cat_name FROM products t1 left join product_category t2 on t1.cat_id=t2.cat_id order by product_id";
                        $q2=mysqli_query($db,$sql2);
                        while($r2=mysqli_fetch_assoc($q2))            
                        {
                            $prd_id=$r2['product_id'];
                            $all_rat=0;
                            $avg_rating=0;
                            /*$rat_q=mysqli_query($db,"SELECT rating FROM `review` WHERE product_id='$prd_id'");
                            $rat_no=mysqli_num_rows($rat_q);
                            while ($rat_data=mysqli_fetch_assoc($rat_q)) {
                              $all_rat+=$rat_data['rating'];
                            }
                            if(isset($rat_no) && $rat_no > 0)
                            {
                              $avg_rating=$all_rat/$rat_no;
                            }*/
                        ?>
                    <div class="col">
                        <div class="product-item mb-50">
                            <div class="product-thumb">
                                <a href="product_detail?id=<?=$r2['product_id']; ?>">
                              <img src="upload/product/<?=$r2['image']; ?>" alt="">
                                </a>
                                <div class="quick-view-link">
                                    <a href="product_detail?id=<?=$r2['product_id']; ?>"> <span
                                    data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                                 </a>
                                </div>
                            </div>
                            <div class="product-content text-center">
                                
                                <div class="product-name">
                                    <h4 class="h5">
                                        <a href="product_detail"><?=$r2['name']; ?></a>
                                    </h4>
                                </div>
                                <div class="price-box">
                                    <?php
                                      $prd_price=$r2['mrp'];
                                      if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
                                      {
                                        $prd_price=$r2['fp'];
                                      }
                                      else if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
                                      {
                                        $chk_pur=IsDistributor($db,$_SESSION['mlmid']);
                                        if($chk_pur > 0)
                                        {
                                          $prd_price=$r2['dp'];
                                        }
                                      }
                                    ?>
                                     <span class="regular-price">₹<?=$prd_price; ?></span>
                                    
                                </div>
                                <div class="product-action-link">
                                    
                                    <a href="javascript:void(0);" class="AddToCart" onclick="Add_cart(<?=$r2['product_id']; ?>,<?=$prd_price; ?>,'1')" data-toggle="tooltip" title="Add to cart"><i class="ion-bag"></i></a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </section>
        <!-- product tab area end -->

        <!-- latest news area start -->
        <!--<section class="latest-news-area latest-news-area__style1 fix pt-30 pb-60 pt-sm-30">
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2>from the blogs</h2>
                        </div>
                    </div>
                </div> 
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="blog-slider slick-padding">
                            <div class="blog-item">
                                <div class="single-blog-item bg-gray">
                                    <div class="blog-img-container">
                                        <a href="blog-details.html" class="blog-img-holder blog-img-holder__1"></a>
                                    </div>
                                    <div class="post-info">
                                        <div class="post-date">
                                            <i class="ion-ios-calendar-outline"></i>
                                            <span>01 Jan 2019</span>
                                        </div>
                                        <h5 class="post-title"><a href="blog-details.html">post with audio format</a></h5>
                                        <p>Aliquam et metus pharetra, bibendum massa nec, fermentum odio. Nunc id leo
                                            ultrices, mollis ligula in, finibus tortor. Mauris eu dui ut lectus
                                            fermentum eleifend</p>
                                        <a href="blog-details.html" class="read-more">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-item">
                                <div class="single-blog-item bg-gray">
                                    <div class="blog-img-container">
                                        <a href="blog-details.html" class="blog-img-holder blog-img-holder__2"></a>
                                    </div>
                                    <div class="post-info">
                                        <div class="post-date">
                                            <i class="ion-ios-calendar-outline"></i>
                                            <span>01 Jan 2019</span>
                                        </div>
                                        <h5 class="post-title"><a href="blog-details.html">post with audio format</a></h5>
                                        <p>Aliquam et metus pharetra, bibendum massa nec, fermentum odio. Nunc id leo
                                            ultrices, mollis ligula in, finibus tortor. Mauris eu dui ut lectus
                                            fermentum eleifend</p>
                                        <a href="blog-details.html" class="read-more">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-item">
                                <div class="single-blog-item bg-gray">
                                    <div class="blog-img-container">
                                        <a href="blog-details.html" class="blog-img-holder blog-img-holder__3"></a>
                                    </div>
                                    <div class="post-info">
                                        <div class="post-date">
                                            <i class="ion-ios-calendar-outline"></i>
                                            <span>01 Jan 2019</span>
                                        </div>
                                        <h5 class="post-title"><a href="blog-details.html">post with audio format</a></h5>
                                        <p>Aliquam et metus pharetra, bibendum massa nec, fermentum odio. Nunc id leo
                                            ultrices, mollis ligula in, finibus tortor. Mauris eu dui ut lectus
                                            fermentum eleifend</p>
                                        <a href="blog-details.html" class="read-more">read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>-->
        <!-- latest news area end -->

        <!-- brand area start -->
        <!--<div class="brand-area">
            <div class="container">
                <div class="brand-inner bdr-top pt-30 pb-30">
                    <div class="brand-active slick-padding">
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/br1.png" alt="brand image">
                            </a>
                        </div>
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/br2.png" alt="brand image">
                            </a>
                        </div>
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/br3.png" alt="brand image">
                            </a>
                        </div>
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/br4.png" alt="brand image">
                            </a>
                        </div>
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/br5.png" alt="brand image">
                            </a>
                        </div>
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/br6.png" alt="brand image">
                            </a>
                        </div>
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/br3.png" alt="brand image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- brand area end -->

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
                                            
                                        </div>
                                       <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue
                                            nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi
                                            ornare lectus quis justo gravida semper.</p>-->
                                        <div class="action-link mb-20">
                                            <a href="#" data-toggle="tooltip" title="Add to cart" class="add-to-cart">add
                                                to cart</a>
                                            
                                        </div>
                                        <div class="quantity mb-20">
                                            <div class="pro-qty"><input type="text" value="1"></div>
                                        </div>
                                       <!-- <div class="availability mb-20">
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