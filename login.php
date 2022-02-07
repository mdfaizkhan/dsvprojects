<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="meta description">
    <title>Secrets Living &#8211; For A Better Life</title>

    <!--=== Favicon ===-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon" />

    <!--=== All Plugins CSS ===-->
    <link href="assets/css/plugins.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <!--=== All Vendor CSS ===-->
    <link href="assets/css/vendor.css" rel="stylesheet">
    <!--=== Main Style CSS ===-->
    <link href="assets/css/style.css" rel="stylesheet">


    <!-- Modernizer JS -->
    <script src="assets/js/modernizr-2.8.3.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <style>
                body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(to top right, red 0%, #6c4079 100%);
        }
        .user_card {
            height: 400px;
            width: 50%;
            margin-top: auto;
            margin-bottom: auto;
            background: #ffffff;
            position: relative;
            display: flex;
            justify-content: center;
            flex-direction: column;
            padding: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;

        }
        .brand_logo_container {
            position: absolute;
            height: 170px;
            width: 170px;
            top: -75px;
            border-radius: 50%;
            background: linear-gradient(to top right, red 0%, #6c4079 100%);
            padding: 10px;
            text-align: center;
        }
        .brand_logo {
            height: 150px;
            width: 150px;
            border-radius: 50%;
            border: 2px solid white;
        }
        .form_container {
            margin-top: 100px;
        }
        .login_btn {
            width: 100%;
            background: #c0392b !important;
            color: white !important;
        }
        .login_btn:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }
        .login_container {
            padding: 0 2rem;
        }
        .input-group-text {
            background: #c0392b !important;
            color: white !important;
            border: 0 !important;
            border-radius: 0.25rem 0 0 0.25rem !important;
        }
        .input_user,
        .input_pass:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }
        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: #c0392b !important;
        }
        @media only screen and (max-width: 600px) {
            .user_card {
                 width: 100% !important;

            }
        }
        
    </style>
</head>
<!--Coded with love by Mutiullah Samim-->
<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="wp-content/uploads/2019/01/Secrets-Living-Logo-Official-3-e1552468575764-150x150.png" class="brand_logo" alt="Logo">
                    </div>
                </div>
                <div class="form_container">
                    <form data-toggle="validator" id="AffiliateLogin" method="POST">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text"  name="username" class="form-control" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="password" name="password" placeholder="Enter your Password" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                        <input type="hidden" name="type" value="AffiliateLogin">
                                        <button type="submit" class="btn btn__bg btn__sqr btn-outline-danger float-right login_btn">Login</button>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                            
                    </form>
                </div>
        
                <div class="mt-4">
                    <div class="d-flex justify-content-center links">
                        Don't have an account? <a href="register.php" class="ml-2">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- <div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <span> <img src="wp-content/uploads/2019/01/Secrets-Living-Logo-Official-3-e1552468575764-150x150.png" class="w-75" alt="Logo"> </span><br/>
        </div>
        <div class="card-body">
            <form data-toggle="validator" id="AffiliateLogin" method="POST">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text"  name="username" class="form-control" placeholder="Username">
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" placeholder="Enter your Password" class="form-control">
                </div>

                <div class="form-group">
                    <input type="hidden" name="type" value="AffiliateLogin">
                    <button type="submit" class="btn btn__bg btn__sqr btn-outline-danger float-right login_btn">Login</button>
                </div>

            </form>
        </div>
        <p style="color:white;">Don't have an Account? <a href="register.php"> Register Now!</a></p>
    </div>
</div> -->
<script>
    <!--=======================Javascript============================-->
    <!--=== All Vendor Js ===-->
    <script src="assets/js/vendor.js"></script>
    <!--=== All Plugins Js ===-->
    <script src="assets/js/plugins.js"></script>

    <!--=== Active Js ===-->
    <script src="assets/js/active.js"></script>

    <script type="text/javascript" src="customjs/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="assets1/plugins/jqueryvalidate/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script type="text/javascript" src="includes/function.js"></script>
    <script type="text/javascript" src="includes/webscript.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('nav a').each(function(index)
            {
                
                if(this.href.trim() == window.location)
                {
                    $("nav li.active").removeClass("active");
                    $(this).closest('li').addClass('active');
                }

            });
            $(".user-li").click(function(){
              $(".dropdown-ul").toggle();
             // $(".dropdown-ul").css("display","block");
            });
            
        });
        /*$(window).bind("load", function() {
        $(".slick-slide").css("width","100% !important")
    });*/
</script>
</body>