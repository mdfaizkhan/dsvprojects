<?php
session_start();
if(($_SESSION["mlmrole"] != "user"))
{
	$url = "index";
	header("location: ".$url);	
}
else if($_SESSION['mlmstatus']==2)
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
}
?>
<!doctype html>
<!DOCTYPE html>
<html lang="en" class="">
   <head>
      <title>User Panel</title>
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
            
            <li class="dropdown" onclick="$('.dropdown-menu').toggle('slow')">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle clear">
                                        <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                        <img src="../new_assets/uploads/images/tree/tree_96353712.jpg" alt="...">
                        <i class="on md b-white bottom"></i>
                    </span>
                                        <span class="hidden-sm hidden-md"><?= $_SESSION['mlmusername']; ?></span>
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


      <aside id="aside" class="app-aside hidden-xs bg-black">
     <div class="aside-wrap">
       <div class="navi-wrap">
        <nav ui-nav class="navi clearfix"><!-- MAIN MENU -->
            <ul class="nav nav-list" style="margin-top: 66px;">
                        <li><!-- dashboard -->
                            <a href="dashboard">
                                <i class="main-icon fa fa-dashboard"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <!-- <li class="active">
                            <a href="activateplan">
                                <i class="main-icon fa fa-inr"></i><span>Topup</span>
                            </a>
                        </li> -->
                        <li>
                            <a href="addusers">
                                <i class="main-icon fa fa-user"></i><span>New User</span>
                            </a>
                        </li>
                        <li >
                            <a href="welcomeletter?id=<?php echo $mlmid; ?>" target="_blank">
                                <i class="main-icon fa fa-envelope"></i><span>Welcome Letter</span>
                            </a>
                        </li>
                        
                        <li >
                            <a href="id_card?id=<?php echo $mlmid; ?>" target="_blank">
                                <i class="main-icon fa fa-envelope"></i><span>Id Card</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="myinvoice">
                                <i class="main-icon fa fa-file"></i><span>Invoice</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon fa fa-barcode"></i><span>Pin Management</span>
                            </a>
                            <ul>
                                <li><a href="javascript:void(0);" class="changemenu" data-href="transpin" data-uid="<?php echo $mlmid; ?>">Transaction PIN</a></li>
                                <li><a href="javascript:void(0);" class="changemenu" data-href="transferpin" data-uid="<?php echo $mlmid; ?>">Transferred PIN</a></li>
                                <li><a href="javascript:void(0);" class="changemenu" data-href="pinreq" data-uid="<?php echo $mlmid; ?>">PIN Request</a></li>
                                <li class="active">
                                    <a href="#">
                                        <i class="fa fa-menu-arrow pull-right"></i>
                                        <i class="fa fa-key"></i>
                                        My PIN
                                    </a>

                                    <ul>
                                        <li>
                                            <a href="javascript:void(0);" class="changemenu" data-href="used_pin" data-uid="<?php echo $mlmid; ?>">My Used Pin</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="changemenu" data-href="unused_pin" data-uid="<?php echo $mlmid; ?>">My Unused Pin</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                        <!-- <li >
                            <a href="setlevel">
                                <i class="main-icon fa fa-level-up"></i><span>Set Level</span>
                            </a>
                        </li> -->
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
                                <span>Manage Payout</span>         
                            </a>
                            <ul class="nav nav-sub dk">

                                <li><a href="complete_payout">Generated Payout</a></li>
                                <li><a href="complete_rank_payout">Generated Commision Payout</a></li>
                               
                                <li><a href="cleared_payout">Cleared Payout</a></li>
                                 <li><a href="cleared_complete_rank_payout">Cleared Generated Commision Payout</a></li>
                               <!--  <li><a href="hold">Pending Payout</a></li> -->
                            </ul>
                        </li>
                        
                        <li>
                            <a href="javascript:void(0);" class="auto" target="">
                                <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                </span>
                                <i class="fa fa-sitemap"></i>
                                <span>Reports</span>         
                            </a>
                            <ul class="nav nav-sub dk">

                                <li><a href="active_member">Active Members</a></li>
                                <li><a href="inactive_member">In Active Members</a></li>
                                <li><a href="purchased_member">Purchased</a></li>
                                <li><a href="repurchased_member">Re Purchased</a></li>
                                <li><a href="notpurchased_member">Not Purchased</a></li>
                                <li><a href="not_complete_kyc">Not Completed KYC</a></li>
                            </ul>
                        </li>
                        <!-- <li>
                            <a href="direct_child">
                                <i class="main-icon fa fa-arrow-circle-down"></i><span>Direct Distributor</span>
                            </a>
                        </li> -->
                        
                        <!-- <li>
                            <a href="#">
                                 <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon fa fa-arrow-circle-down"></i> <span>Manage Distributor</span>
                            </a>
                            <ul>
                                <li><a href="direct_child">Direct Distributor</a></li>
                                <li><a href="downline">Downline Distributor</a></li>
                            </ul>
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
                                <!-- <li><a href="freedownline">Add Free Downline Child</a></li>-->
                            </ul>
                        </li>
                        <li>
                            <a href="genealogy">
                                <i class="main-icon fa fa-sitemap"></i><span>My Tree</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="commision">
                                <i class="main-icon fa fa-inr"></i><span>Commisions</span>
                            </a>
                        </li>
                       <!--  <li>
                            <a href="history">
                                <i class="main-icon fa fa-inr"></i><span>My Income Detail</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="#">
                                 <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon fa fa-inr"></i> <span>My Income Detail</span>
                            </a>
                            <ul> -->
                                <!-- <li><a href="downincome">Level Income</a></li>
                                <li><a href="royalty_history">Royalty Income</a></li>
                                <li><a href="royalty_income">Royalty Report</a></li> -->
                                <!-- <li><a href="binary_history">Binary Income</a></li> -->
                                <!-- <li><a href="direct_history">Direct Income</a></li>
                                <li><a href="roi_history">ROI Income</a></li> -->
                               <!--  <li><a href="ref_report">Referal Bonus Report</a></li>
                                <li><a href="rank_report">Rank Detail</a></li> -->
                            <!-- </ul>
                        </li> -->
                        <!-- <li>
                            <a href="reward">
                                <i class="main-icon fa fa-inr"></i><span>My Reward</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon fa fa-inr"></i> <span>Order</span>
                            </a>
                            <ul>
                                <li><a href="order">Order</a></li>
                                <li><a href="cpayment">Confirm Payment</a></li>
                            </ul>
                        </li> -->
                        <li>
                            <a href="order">
                                <i class="main-icon fa fa-shopping-cart"></i><span>Order</span>
                            </a>
                        </li>
                        <li>
                            <a href="balance">
                                <i class="main-icon fa fa-inr"></i><span>Wallet Balance Request</span>
                            </a>
                        </li>
                         <li>
                            <a href="goal">
                                <i class="main-icon fa fa-file"></i><span>My Next Goal</span>
                            </a>
                        </li>
                        <li>
                            <a href="../logout">
                                <i class="main-icon fa fa-power-off"></i><span>Log Out</span>
                            </a>
                        </li>
                       
                        <!-- <li>
                            <a href="fbalance">
                                <i class="main-icon fa fa-inr"></i><span>Wallet Balance Request</span>
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