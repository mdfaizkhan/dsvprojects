<?php include('header.php'); ?>
<!-- main wrapper start -->
    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h2>Register</h2>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- login register wrapper start -->
        <div class="login-register-wrapper pt-60 pb-60">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row">
                        <div class="col-md-2">&nbsp;</div>
                        <!-- Register Content Start -->
                        <div class="col-lg-8">
                            <div class="login-reg-form-wrap mt-md-60 mt-sm-60">
                                <h2>Singup Form</h2>
                                <form id="registerform" action="#" method="post">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <input type="text" placeholder="Sponsor Id" id="sponsor_id" class="form-control getSponsordetail" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                               Sponsor Name : <span id="Sponsordetail"></span>
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
                                        <button class="btn btn__bg btn__sqr formvalidate" data-form="registerform">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Register Content End -->
                        <div class="col-md-2">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login register wrapper end -->
    </main>
    <!-- main wrapper end -->
<?php include('footer.php'); ?>