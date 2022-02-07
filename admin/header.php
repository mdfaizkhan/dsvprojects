<?php
session_start();
if(($_SESSION["mlmrole"] != "admin"))
{
	$url = "index";
	header("location: ".$url);	
}
else
{
	error_reporting(E_ERROR | E_PARSE);
	include("../db_config.php");
	$mlmid = $_SESSION['mlmid'];
	$role = $_SESSION["mlmrole"];
	$usename = $_SESSION['mlmusername'];
    $viewpin=0;
}
?>

<!DOCTYPE html>
<html lang="en" class="">
   <head>
      <title>Admin Panel</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 5.0, user-scalable = yes">
      <link rel="shortcut icon" type="image/png" href="../new_assets/uploads/images/logos/favicon.png" />
      <link rel="stylesheet" href="../new_assets/theme/libs/assets/animate.css/animate.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/libs/assets/font-awesome/css/font-awesome.min.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/libs/assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/libs/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/css/font.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/libs/jquery/zebra-datepicker/css/metallic/zebra_datepicker.min.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/libs/jquery/autocomplete/jquery.autocomplete.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/css/app.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/css/custom.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/css/user_theme.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/libs/jquery/tooltipster/css/tooltipster.bundle.min.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/theme/libs/jquery/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css" type="text/css" />
      <link rel="stylesheet" href="../new_assets/plugins/select2/dist/css/select2.min.css" type="text/css" />
      <link rel="stylesheet" type="text/css" href="../new_assets/css/bootstrap-slider.css">
      <link rel="stylesheet" type="text/css" href="../new_assets/css/bootstrap-slider.min.css">


      <link href="../assets1/css/layout-datatables.css" rel="stylesheet" type="text/css" />
      
<?php
$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$page = end($link_array);
if($page=='dashboard.php'){}else{
?>
 <link href="../assets1/css/essentials.css" rel="stylesheet" type="text/css" />
<?php } ?>

       <style type="text/css">
        #aside nav ul li a:active, #aside nav ul li.menu-open, #aside nav ul li.always-open, #aside nav>ul>li>a:hover, #aside nav>ul>li>a:focus, #aside nav ul li.active, .fancy-file-upload.fancy-file-primary>span.button, .datepicker table tr td.active.active, .btn-primary, #header, .popular .plan-title, body.min #aside ul.nav>li>ul li, body.min #aside ul.nav li.menu-open, body.min #aside ul.nav>li:hover>ul, #aside nav ul li a.dashboard, #aside .logo, body.min #asidesize, #aside, #asidebg {
            background-color: #36484b;
        }
        .stepwizard-step p {
            margin-top: 10px;
        }
        .stepwizard-row {
            display: table-row;
        }
        .stepwizard {
            display: table;
            width: 100%;
            margin-top:20px;
            position: relative;
        }
        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }
        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;
        }
        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }
        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 0px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 0px;
        }
    </style>
    <style type="text/css">
        .tabletools-topbar{
            display: none;
        }
        .fancy-form>i {
            position: absolute;
            top: 50%;
            left: 9px;
            margin-top: -7px;
            z-index: 10;
            width: 14px;
            height: 14px;
            color: #888;
        }
        #page-header{
            display: none;
        }
    </style>
   </head>
   <body>
      <div class="app app-header-fixed  ">
      <!-- header -->
      <header id="header" class="app-header navbar" role="menu">
         <!-- navbar header -->
         <div class="navbar-header bg-black">
            <button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse">
            <i class="glyphicon glyphicon-cog"></i>
            </button>
            <button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app">
            <i class="glyphicon glyphicon-align-justify"></i>
            </button>
            <!-- brand -->
            <a href="#" class="navbar-brand text-lt">
            <img src="../new_assets/uploads/images/logos/logo_default.png" alt="." class="" style="width: 200px;     max-height: 98px;">
            <img src="../new_assets/uploads/images/logos/favicon.png" alt="logo" class="logo-shrink">
            </a>
            <!-- / brand -->
         </div>
         <!-- / navbar header -->
         <!-- navbar collapse -->
         <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
            <!-- buttons -->
            <div class="nav navbar-nav hidden-xs">
               <a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app">
               <i class="fa fa-dedent fa-fw text"></i>
               <i class="fa fa-indent fa-fw text-active"></i>
               </a>
               <!--<a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="show" target="#aside-user">
                  <i class="icon-user fa-fw"></i>
                  </a> -->
            </div>
            <!-- / buttons -->
            <!-- navbar right -->
            <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown"  onclick="$('.dropdown-menu').toggle('slow')">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle clear">
                                        <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                        <img src="../new_assets/uploads/images/tree/tree_96353712.jpg" alt="...">
                        <i class="on md b-white bottom"></i>
                    </span>
                                        <span class="hidden-sm hidden-md">Admin</span>
                    <b class="caret"></b>
                </a>
                <!-- dropdown -->
                <ul class="dropdown-menu animated fadeInRight w">
                                        <li>
                        <a  href="profile">
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="changepass">
                            <span>Change Password</span>
                        </a>
                    </li>
                   <li class="divider"></li>
                    <li>
                        <a href="../logout">
                            <span>Logout</span>
                        </a>
                    </li>

                </ul>
                <!-- / dropdown -->

            </li>

        </ul>
            <!-- / navbar right -->

         </div>
         <!-- / navbar collapse -->
      </header>
      <!-- / header -->


	<aside id="aside" class="app-aside hidden-xs bg-black">
     <div class="aside-wrap">
       <div class="navi-wrap">
		<nav ui-nav class="navi clearfix"><!-- MAIN MENU -->
           <ul class="nav" style="margin-top: 66px;">
                <li  class="active" ><!-- dashboard -->
                    <a href="dashboard">
                        <i class="main-icon fa fa-dashboard"></i><span>Dashboard</span>
                    </a>
                </li>

              <!--   <li >
                    <a href="vpower">
                        <i class="main-icon fa fa-inr"></i><span>Virtual Power</span>
                    </a>
                </li> -->
                <li>
                    <a href="plans">
                        <i class="main-icon fa fa-cart-plus"></i><span>Packages</span>
                    </a>
                </li>
               <!-- <li >
                    <a href="activateplan">
                        <i class="main-icon fa fa-inr"></i><span>Topup</span>
                    </a>
                </li> -->
                <li>
                      <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>E-pin</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="javascript:void(0);" class="changemenu" data-href="transpin" data-uid="<?php echo $mlmid; ?>">Transaction PIN</a></li>
                        <li><a href="javascript:void(0);" class="changemenu" data-href="transferpin" data-uid="<?php echo $mlmid; ?>">Transferred PIN</a></li>
                        <li><a href="javascript:void(0);" class="changemenu" data-href="pinreq" data-uid="<?php echo $mlmid; ?>">PIN Request</a></li>
                        <li class="">
                              <a href="javascript:void(0);" class="auto" target="">
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                <i class="fa fa-sitemap"></i>
                                <span>My Pin</span>         
                            </a>
                            <ul class="nav nav-sub dk">
                                <li>
                                    <a href="javascript:void(0);" class="changemenu" data-href="used_pin" data-uid="<?php echo $mlmid; ?>">My Used Pin</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="changemenu" data-href="unused_pin" data-uid="<?php echo $mlmid; ?>">My Unused Pin</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- <li >
                    <a href="setlevel">
                        <i class="main-icon fa fa-level-up"></i><span>Set Level</span>
                    </a>
                </li> -->
                 

               <!--  <li>
                    <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>Manage Payout</span>         
                    </a>
                    <ul class="nav nav-sub dk"> -->
                        <!-- <li><a href="editpayout">Payout Detail</a></li>
                        <li><a href="editrefbonus">Referal Bonus Detail</a></li> -->
                       <!--  <li><a href="generate_payout">Generate Payout</a></li>
                        <li><a href="complete_payout">Generated Payout</a></li>
                        <li><a href="complete_rank_payout">Generated Rank Payout</a></li>
                        <li><a href="cleared_payout">Cleared Payout</a></li>
                        <li><a href="cleared_complete_rank_payout">Cleared Rank Payout</a></li> -->
                       <!--  <li><a href="hold">Pending Payout</a></li> -->
                        <!-- <li><a href="week_payout_history">Previous Payout</a></li>
                        <li><a href="pending_week_payout_history">Pending Previous Payout</a></li> -->
                        <!-- <li><a href="payout_history">Payout History</a></li> -->
                  <!--   </ul>
                </li> -->

              

                <li>
                    <a href="addusers">
                        <i class="main-icon fa fa-user"></i><span>New User</span>
                    </a>
                </li>
                <li>
                    <a href="user">
                        <i class="main-icon fa fa-users"></i><span>Users</span>
                    </a>
                </li>
              <!--   <li>
                    <a href="franchise">
                        <i class="main-icon fa fa-bars"></i><span>Franchise</span>
                    </a>
                </li> -->
                <li>
                     <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>Manage Distributor</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="direct_child">Direct Distributor</a></li>
                        <li><a href="downline">Downline Distributor</a></li>
                        <li><a href="new_distributor">New Distributor</a></li>
                        
                    </ul>
                </li>
                <!-- <li>
                    <a href="contact">
                        <i class="main-icon fa fa-envelope"></i><span>Contact</span>
                    </a>
                </li> -->
                <li>
                    <a href="genealogy">
                        <i class="main-icon fa fa-sitemap"></i><span>My Tree</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="history">
                        <i class="main-icon fa fa-inr"></i> <span>Income Detail</span>
                    </a>
                </li> -->

                <li>
                      <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa ">RM</i>
                        <span>Income Detail</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="downincome">Level Income</a></li>
                       <!--  <li><a href="royalty_history">Royalty Income</a></li>
                        <li><a href="royalty_income">Royalty Report</a></li> -->
                        <!-- <li><a href="binary_history">Binary Income</a></li> -->
                         <li><a href="direct_history">Direct Income</a></li>
                        <!--<li><a href="roi_history">ROI Income</a></li> -->



                       <!--  <li><a href="ref_history">Referal Bonus Income</a></li>
                        <li><a href="ref_report">Referal Bonus Report</a></li> -->
                        <!-- <li><a href="rank_report">Rank Detail</a></li>
                        <li><a href="rank_user">Rank Achievers</a></li> -->
                    </ul>
                </li>
                
                <!-- <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-inr"></i> <span>Reward</span>
                    </a>
                    <ul>
                        <li><a href="rewardplans">Reward Plans</a></li>
                        <li><a href="reward">Reward</a></li>
                    </ul>
                </li> -->
                 <li>
                    <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>Marquee</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="news">Marquee</a></li>
                        <!--<li><a href="wnews">Web News</a></li>-->
                    </ul>
                </li>
               <!-- <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-inr"></i> <span>Re-Purchase</span>
                    </a>
                    <ul>
                        <li><a href="rplans">Plans</a></li>
                        <li><a href="orders">Orders</a></li>
                    </ul>
                </li>  -->
                <li>
                    <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>Products</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <!-- <li><a href="category">Category</a></li> -->
                        <li><a href="products">Products</a></li>
                        <li><a href="order">Orders </a></li>
                        <!-- <li><a href="forder">Franchise Orders </a></li> -->
                        
                    </ul>
                </li>
             <!--    <li>
                    <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>E-Wallet Debit/Credit</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="e-debit">DEBIT</a></li>
                        <li><a href="e-credit">CREDIT</a></li>
                    </ul>
                </li> -->
                <!--<li>-->
                <!--    <a href="bv-track-record">-->
                <!--        <i class="main-icon fa fa-bars"></i><span>BV Track Record</span>-->
                <!--    </a>-->
                <!--</li>-->
             <!--    <li>
                    <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>Wallet Balance</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="balance">User Request</a></li>
                        <li><a href="fbalance">Franchise Request</a></li>
                        
                    </ul>
                </li> -->
                <!-- <li> -->
        <!--            <a href="javascript:void(0);" class="auto" target="">
                    <span class="pull-right text-muted">
                        <i class="fa fa-fw fa-angle-right text"></i>
                        <i class="fa fa-fw fa-angle-down text-active"></i>
                    </span>
                        <i class="fa fa-sitemap"></i>
                        <span>CMS</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="slider">Slider</a></li>
                        <li><a href="team">My Team</a></li>
                        <li><a href="gallery">Gallery</a></li>
                        
                    </ul>
                </li> -->
                
            <!--     <li>
                       <a href="javascript:void(0);" class="auto" target="">
                        <span class="pull-right text-muted">
                            <i class="fa fa-fw fa-angle-right text"></i>
                            <i class="fa fa-fw fa-angle-down text-active"></i>
                        </span>
                        <i class="fa fa-sitemap"></i>
                        <span>Report</span>         
                    </a>
                    <ul class="nav nav-sub dk">
                        <li><a href="active_member">Active Members</a></li>
                        <li><a href="inactive_member">InActive Members</a></li>
                        <li><a href="purchased_member">Purchased</a></li>
                        <li><a href="repurchased_member">Re Purchased</a></li>
                        <li><a href="notpurchased_member">Not Purchased</a></li>
                        
                    </ul>
                </li> -->
                <li>
                    <a href="../logout">
                        <i class="main-icon fa fa-power-off"></i><span>Log Out</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="balance">
                        <i class="main-icon fa fa-inr"></i><span>Wallet Balance Request</span>
                    </a>
                </li> -->
                <!-- <li>
                    <a href="planreq">
                        <i class="main-icon fa fa-address-book-o"></i><span>Upgrade Request</span>
                    </a>
                </li> -->
                <!--<li>
                    <a href="planreport">
                        <i class="main-icon fa fa-file"></i><span>Plan Report</span>
                    </a>
                </li> -->
                <!-- <li>
                    <a href="withdraw">
                        <i class="main-icon fa fa-money"></i><span>Withdraw</span>
                    </a>
                </li> -->
            </ul>
        </nav>
       </div>
     </div>
	</aside>


			


 <div id="content"  class="app-content "  role="main">
         <div class="app-content-body ">
            <div class="hbox hbox-auto-xs hbox-auto-sm wrapper-md">