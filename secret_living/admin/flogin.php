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
                                <h2>Franchise Login</h2>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Franchise Login</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- login register wrapper start -->
        <div class="login-register-wrapper pt-60 pb-60" id="login">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row">
                        <!-- Login Content Start -->
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div class="login-reg-form-wrap  pr-lg-50">
                                <h2>Sign In</h2>
                                <form data-toggle="validator" id="FranchiseLogin" method="POST">
                                    <div class="single-input-item">
                                        <input type="text"  name="username" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="single-input-item">
                                        <input type="password" name="password" placeholder="Enter your Password" class="form-control">
                                    </div>
                                    <div class="single-input-item">
                                        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                             <a class="no-text-decoration size-16 margin-top-10 block" href="javascript:void(0);" id="showforget">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <input type="hidden" name="type" value="FranchiseLogin">
                                        <button type="submit" class="btn btn__bg btn__sqr">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">&nbsp;</div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="login-register-wrapper pt-60 pb-60" id="forget_pwd" style="display:none;">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row">
                        <!-- Login Content Start -->
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div class="login-reg-form-wrap  pr-lg-50">
                                <h2>Forgot Password</h2>
                                <form data-toggle="validator" id="ForgotFranchisePass" method="POST">
                                    <div class="single-input-item">
                                        <input type="text"  name="username" class="form-control" placeholder="Reset Password will be sent to your email">
                                    </div>
                                    
                                    <div class="single-input-item">
                                        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                            
                                             <a class="no-text-decoration size-13 margin-top-10 block" href="javascript:void(0);" id="showlogin">Click Here to Login</a>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <input type="hidden" name="type" value="ForgotFranchisePass">
                                        <button type="submit" class="btn btn__bg btn__sqr">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">&nbsp;</div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- login register wrapper end -->
    </main>
    <!-- main wrapper end -->
<?php include('footer.php'); ?>