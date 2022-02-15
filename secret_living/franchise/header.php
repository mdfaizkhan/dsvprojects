<?php
session_start();
if(!isset($_SESSION["franchiseid"]))
{
	$url = "index";
	header("location: ".$url);	
}
else
{
	error_reporting(E_ERROR | E_PARSE);
    include("../db_config.php");
    $mlmid = $_SESSION['franchiseid'];
    $usename = $_SESSION['franchiseusername'];
}
?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Varitiz Pharma Pvt. Ltd. </title>
		<meta name="description" content="" />
		<meta name="Author" content="Dorin Grigoras [www.stepofweb.com]" />

        <!-- mobile settings -->
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
        <!-- <a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=brandmaker.org.in','SiteLock','width=600,height=600,left=160,top=170');" ><img class="img-responsive" alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/brandmaker.org.in" /></a> -->
        <!-- WEB FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

        <!-- CORE CSS -->
        <link href="../assets1/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets1/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
        <link href="../assets1/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <!-- THEME CSS -->
        <link href="../assets1/css/essentials.css" rel="stylesheet" type="text/css" />
        <link href="../assets1/css/layout.css" rel="stylesheet" type="text/css" />

        <link href="../assets1/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
        <link href="../customcss/usercustom.css" rel="stylesheet" type="text/css"  />


        <!-- PAGE LEVEL STYLES -->
        <link href="../assets1/css/layout-datatables.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

	</head>
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
            width: 50%;
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
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
    </style>
	<body>


		<!-- WRAPPER -->
        <div id="wrapper">
        	<aside id="aside">
        		<nav id="sideNav"><!-- MAIN MENU -->
                    <ul class="nav nav-list">
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
                        <!-- <li>
                            <a href="addusers">
                                <i class="main-icon fa fa-user"></i><span>New User</span>
                            </a>
                        </li>
                        <li >
                            <a href="welcomeletter?id=<?php echo $mlmid; ?>" target="_blank">
                                <i class="main-icon fa fa-envelope"></i><span>Welcome Letter</span>
                            </a>
                        </li> -->
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

                        <!-- <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon fa fa-inr"></i> <span>Manage Payout</span>
                            </a>
                            <ul>

                                <li><a href="complete_payout">Generated Payout</a></li>
                                <li><a href="cleared_payout">Cleared Payout</a></li>
                            </ul>
                        </li> -->
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
                        <!-- <li>
                            <a href="#">
                                 <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon fa fa-arrow-circle-down"></i> <span>Manage Distributor</span>
                            </a>
                            <ul>
                                <li><a href="direct_child">Direct Distributor</a></li>
                                <li><a href="downline">Downline Distributor</a></li>
                                
                            </ul>
                        </li>
                        <li>
                            <a href="genealogy">
                                <i class="main-icon fa fa-sitemap"></i><span>My Tree</span>
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
                            <a href="fbalance">
                                <i class="main-icon fa fa-inr"></i><span>Wallet Balance Request</span>
                            </a>
                        </li>
                        <li>
                            <a href="commision_list">
                                <i class="main-icon fa fa-inr"></i><span>Commision List</span>
                            </a>
                        </li>
                        <li>
                            <a href="../logout">
                                <i class="main-icon fa fa-power-off"></i><span>Log Out</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="withdraw">
                                <i class="main-icon fa fa-money"></i><span>Withdraw</span>
                            </a>
                        </li> -->

                    </ul>
        		</nav>
        		<span id="asidebg"><!-- aside fixed background --></span>
        	</aside>
        	<header id="header">
        		<button id="mobileMenuBtn"></button>
        		<span class="logo pull-left">
        			<H3 alt="logo" style = "height:35px;color:#fff;margin-top:4%;" /><?php echo $role; ?></h3>
        		</span>
        		
        		<nav>
        			<!-- OPTIONS LIST -->
        			<ul class="nav pull-right">

        				<!-- USER OPTIONS -->
        				<li class="dropdown pull-left">
        					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        						<img class="user-avatar" alt="" src="../assets1/images/noavatar.jpg" height="34" />
        						<span class="user-name">
        							<span class="hidden-xs"> 
        							<?php echo $usename; ?> <i class="fa fa-angle-down"></i>
        							</span>
        						</span>
        					</a>
        					<ul class="dropdown-menu hold-on-click">
        						<li>
        							<a href="profile">
        								<i class=" fa fa-edit"></i> <span>Profile</span>
        							</a>
        						</li>
        						<li>
        							<a href="changepass">
        								<i class=" fa fa-key"></i> <span>Change Password</span>
        							</a>
        						</li>
                                <li>
                                    <a href="changetpass">
                                        <i class=" fa fa-key"></i> <span>Change Transaction Password</span>
                                    </a>
                                </li>
        						<li><!-- logout -->
        							<a href="../logout"><i class="fa fa-power-off"></i> Log Out</a>
        						</li>
        						
        					</ul>
        				</li>
        				<!-- /USER OPTIONS -->

        			</ul>
        			<!-- /OPTIONS LIST -->

        		</nav>
        	</header>
        	<!-- /HEADER -->
