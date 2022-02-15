<?php include("db_config.php");?>
<!DOCTYPE html>
<html lang="en" class="">
   <head>
      <title>Admin Panel</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 5.0, user-scalable = yes">
      <link rel="shortcut icon" type="image/png" href="new_assets/uploads/images/logos/favicon.png" />
      <link rel="stylesheet" href="new_assets/theme/libs/assets/animate.css/animate.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/libs/assets/font-awesome/css/font-awesome.min.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/libs/assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/libs/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/css/font.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/libs/jquery/zebra-datepicker/css/metallic/zebra_datepicker.min.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/libs/jquery/autocomplete/jquery.autocomplete.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/css/app.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/css/custom.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/css/user_theme.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/libs/jquery/tooltipster/css/tooltipster.bundle.min.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/theme/libs/jquery/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css" type="text/css" />
      <link rel="stylesheet" href="new_assets/plugins/select2/dist/css/select2.min.css" type="text/css" />
      <link rel="stylesheet" type="text/css" href="new_assets/css/bootstrap-slider.css">
      <link rel="stylesheet" type="text/css" href="new_assets/css/bootstrap-slider.min.css">


      <link href="assets1/css/layout-datatables.css" rel="stylesheet" type="text/css" />
<?php
$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$page = end($link_array);
if($page=='dashboard.php'){}else{
?>
 <link href="assets1/css/essentials.css" rel="stylesheet" type="text/css" />
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
        html,body {
            background: linear-gradient(to top right, darkred 0%, #6c4079 100%);
        }
        .login_btn{
            width: 130px;
            background: #800000;
            color: #ffffff;
        }

        .login_btn:hover{
            font-weight: bold;
            color: #ffffff;
        }
    </style>
   </head>
   <body>         
    <section id="middle">
        <header id="page-header">
            <h1>Users</h1>
        </header>
        <div id="content" class="padding-20  bg-gra-02 p-t-130 p-b-100 font-poppins">
            <div class="row" style="padding-top:30px;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="panel panel-default mypanel ">
                        <div class="panel-heading panel-heading-transparent" style="border-radius:10px 10px 0px 0;">
                            <strong>Register Here</strong> 
                        </div>
                        <div class="panel-body" style="border-radius:0 0 10px 10px;">
                            <form id="formaddedituser" action="#" method="post">
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group">
                                            <?php if(!isset($data['user_id'])){
                                                $uriSegments = $_SERVER['REQUEST_URI'];
                                                $uri_segment = explode('=', $uriSegments);
                                                ?>
                                            <div class="col-md-4 col-sm-4">
                                                <label>Sponsor Id<span style="color:red;">*</span></label>
                                                <div class="fancy-form">
                                                    <i class="fa fa-percent"></i>
                                                    <?php if(isset($uri_segment[1]))
                                                    {
                                                    ?>
                                                        <input type="text" placeholder="Sponsor Id" name = "sponsor_id" id = "sponsor_id" class="form-control getSponsordetail" value="<?php echo $uri_segment[1] ?>" readonly required>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <input type="text" placeholder="Sponsor Id" name = "sponsor_id" id = "sponsor_id" class="form-control getSponsordetail" value="<?php echo isset($data['sponsor_id'])?$data['sponsor_id']:''; ?>" required>
                                                    <?php }?>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4">
                                                <label>Sponsor Name</label><br>
                                                <label style="border: 1px solid #dddddd; padding: 8px; width: 100%; height: 40px;    background: #f5f9fc;"><b id="Sponsordetail"><span style="color:red;">Please Enter Sponsor Id*</span></b></label>
                                            </div>

                                            <div class="col-md-4 col-sm-4">
                                                <label>Select Package</label>
                                                <div class="fancy-form">
                                                    <div class="fancy-form fancy-form-select">
                                                     <select class="form-control select2" name="package" required="">
                                                     <?php
                                                     $getPackage=mysqli_query($db,"SELECT * FROM `plans`");
                                                     while($package = mysqli_fetch_array($getPackage)){
                                                     ?>
                                                       <option value="<?= $package['plan_id'] ?>"><?= $package['plan_name'] ?> RM <?= $package['plan_amount'] ?></option>
                                                     <?php } ?>
                                                     </select>
                                                    <i class="fancy-arrow"></i>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <label>First name<span style="color:red;">*</span></label>
                                                <div class="fancy-form"><!-- input -->
                                                    <i class="fa fa-percent"></i>
                                                    <input type="text"  placeholder = "First name" class = "form-control" name = "fname" id = "fname" value="<?php echo isset($data['first_name'])?$data['first_name']:''; ?>" title="It must contain only letters and a length of minimum 3 characters!"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Last name<span style="color:red;">*</span></label>
                                                <div class="fancy-form"><!-- input -->
                                                    <i class="fa fa-percent"></i>
                                                    <input type="text"  placeholder = "Last name" class = "form-control" name = "lname" id = "lname" value="<?php echo isset($data['last_name'])?$data['last_name']:''; ?>" title="It must contain only letters and a length of minimum 3 characters!"  required>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <label>Username<span style="color:red;">*</span>  <span id="usernameresp"></span></label>
                                                <div class="fancy-form">
                                                    <i class="fa fa-user"></i>
                                                 <?php
                                                 $sql1=mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(*) as un FROM `user_id` WHERE uid!=1"));
                                                 $tot=5000+$sql1['un'];
                                                 $unames="SL".$tot;
                                                 ?>
                                                    <input type="text"  placeholder = "Username" class = "form-control checkusername"  <?php echo isset($data['uname'])?'disabled':'name = "username" id = "plan_amount"'; ?> value="<?php echo isset($data['uname'])?$data['uname']:$unames; ?>" title = "Username should be Atleast 6 characters" minlength="6"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Password<span style="color:red;">*</span></label>
                                                <div class="fancy-form">
                                                    <i class="fa fa-key"></i>
                                                    <input type="password" placeholder = "Password" class = "form-control" name = "password" id = "password" value="<?php echo isset($data['password'])?$data['password']:''; ?>" title = "Enter Password here"  required>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group">
                                            <!-- <div class="col-md-6 col-sm-6">
                                                <label>PIN No<span style="color:red;">*</span></label>
                                                <?php if(isset($data['pin']) && !empty($data['pin'])){ ?>
                                                <div class="fancy-form">
                                                    <i class="fa fa-key"></i>
                                                    <input type="text" placeholder = "PIN No" class = "form-control checkValidPin" title="PIN Required!" <?php echo isset($data['pin'])?'disabled':' name = "pin_no" id = "pin_no"'; ?> value="<?php echo isset($data['pin'])?$data['pin']:''; ?>" <?php echo isset($data['pin'])?'required':''; ?>>
                                                </div>
                                                
                                                <?php } else { ?>
                                                <div class="fancy-form fancy-form-select">
                                                    <select class="form-control select2" name="pin_no"  <?php echo isset($data['pin'])?'':'required'; ?>>
                                                        <option value="">--- Select ---</option>
                                                        <?php
                                                            $sql=mysqli_query($db,"SELECT t1.*,t3.plan_id,t3.plan_amount,t3.plan_name FROM transpin t1 join plans t3 on t1.plan_id = t3.plan_id where t1.allot_uid=0 and t1.status=0 order by status");
                                                            while($row = mysqli_fetch_assoc($sql))
                                                            {
                                                        ?>
                                                        <option value="<?php echo $row['pin_code']; ?>" <?php echo isset($data['pin']) && $data['pin']==$row['pin_code']?'selected':''; ?>><?php echo $row['pin_code']; ?> - [<?php echo $row['plan_name']."-".$row['plan_amount']; ?>]</option>
                                                        <?php } ?>
                                                    </select>
                                                    <i class="fancy-arrow"></i>
                                                </div>
                                                
                                                <?php } ?>
                                            </div> -->
                                            <div class="col-md-6 col-sm-6">
                                                <label>Mobile No<span style="color:red;">*</span></label>
                                                <div class="fancy-form"><!-- input -->
                                                    <i class="fa fa-percent"></i>
                                                    <input type="text" placeholder="Mobile No" name="mobile_no" id="mobile_no" class="form-control" value="<?php echo isset($data['mobile'])?$data['mobile']:''; ?>" minlength="10" required>
                                                </div>   
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Email address<span style="color:red;">*</span></label>
                                                <div class="fancy-form">
                                                    <i class="fa fa-envelope"></i>
                                                    <input type="email" placeholder = "Email address" class = "form-control" name = "email" id = "email" value="<?php echo isset($data['email'])?$data['email']:''; ?>" title = "It must contain a valid email address e.g. 'someone@provider.com' !"  >
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <label>Gender</label>
                                                    <div class="fancy-form fancy-form-select">
                                                        <select class="form-control select2" name="gender" required="">
                                                            <option value="male" <?php echo isset($data['gender']) && $data['gender']=='male'?'selected':''; ?>>Male</option>
                                                            <option value="female" <?php echo isset($data['gender']) && $data['gender']=='female'?'selected':''; ?>>Female</option>
                                                            <option value="other" <?php echo isset($data['gender']) && $data['gender']=='other'?'selected':''; ?>>Other</option>
                                                        </select>
                                                        <i class="fancy-arrow"></i>
                                                    </div>
                                            </div>
                                            <?php if(!isset($data['user_id'])){ ?>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Choose Position</label>
                                                <div class="fancy-form">
                                                    <select class="form-control" name="position" style="border: 2px solid #dedede;">
                                                        <option value="">Please Select</option>
                                                        <option value="L" <?php echo isset($pos) && $pos=='L'?'selected':''; ?>>Left</option>
                                                        <option value="R" <?php echo isset($pos) && $pos=='R'?'selected':''; ?>>Right</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                            <div class="col-md-6 col-sm-6">
                                                <label>Position</label>
                                                <div class="fancy-form">
                                                    <i class="fa fa-percent"></i>
                                                    <input type="text" placeholder="Position" name = "position" id = "position" class="form-control" value="<?php echo isset($data['position'])?$data['position']:''; ?>" readonly>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row">
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <div class="col-md-12 col-sm-12 text-center">
                                                <input type="hidden" name="type" value="AddEditUser" >
                                                <!-- <input type="hidden" name="parent_id" value="<?php echo isset($data['parent_id'])?$data['parent_id']:$mlmid; ?>" > -->
                                                <input type="hidden" name="txtid" value="<?php echo isset($userid)?$userid:''; ?>" >
                                                <button type="submit" id="formvalidate" class="btn btn__bg btn__sqr btn-outline-danger float-right login_btn formaddedituser" data-form="formaddedituser">Register</button>
                                            </div>
                                            <div class="clearfix"></div><br/>
                                            <div class="row">
                                                <center>Have already an account? <a href="login.php" class="ml-2">Login Here</a></center>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>

                        </div>

                    </div>
                    

                </div>
                <div class="col-md-2"></div>


            </div>                  
        </div>
  <script type="text/javascript">var plugin_path = 'assets1/plugins/';</script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
  <script type="text/javascript" src="assets1/plugins/jquery/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="assets1/js/app.js"></script>
  <script type="text/javascript" src="includes/function.js"></script>

  <script src="new_assets/theme/js/jquery.min.js"></script>
      <script>
        
            loadScript(plugin_path + "datatables/js/jquery.dataTables.min.js", function()
            {
                loadScript(plugin_path + "datatables/js/dataTables.tableTools.min.js", function()
                {
                    loadScript(plugin_path + "datatables/dataTables.bootstrap.js", function()
                    {
                        loadScript(plugin_path + "select2/js/select2.full.min.js", function(){

                            var table = jQuery('.sample_5');

                            /* Set tabletools buttons and button container */

                            jQuery.extend(true, jQuery.fn.DataTable.TableTools.classes, {
                                "container": "btn-group pull-right tabletools-topbar",
                                "buttons": {
                                    "normal": "btn btn-sm btn-default",
                                    "disabled": "btn btn-sm btn-default disabled"
                                },
                                "collection": {
                                    "container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
                                }
                            });

                            var oTable = table.dataTable({
                                "order": [
                                    [0, 'desc']
                                ],
                                "lengthMenu": [
                                    [10, 15, 20, -1],
                                    [10, 15, 20, "All"] // change per page values here
                                ],
                                "pageLength": 10, // set the initial value,
                                "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                                "tableTools": {
                                    "sSwfPath": plugin_path + "datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                                    "aButtons": [{
                                        "sExtends": "pdf",
                                        "sButtonText": "PDF"
                                    }, {
                                        "sExtends": "csv",
                                        "sButtonText": "CSV"
                                    }, {
                                        "sExtends": "xls",
                                        "sButtonText": "Excel"
                                    }, {
                                        "sExtends": "print",
                                        "sButtonText": "Print",
                                        "sInfo": 'Please press "CTR+P" to print or "ESC" to quit',
                                        "sMessage": "Generated by DataTables"
                                    }]
                                }
                            });

                            var tableWrapper = jQuery('#sample_5_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
                            tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

                        });
                    });
                });
            });
        
      </script>
      <script src="new_assets/theme/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
      <script src="new_assets/theme/js/ui-load.js"></script>
      <script src="new_assets/theme/js/ui-jp.config.js"></script>
      <script src="new_assets/theme/js/ui-jp.js"></script>
      <script src="new_assets/theme/js/ui-nav.js"></script>
      <script src="new_assets/theme/js/ui-toggle.js"></script>
      <script src="new_assets/theme/js/ui-client.js"></script>
      <script src="new_assets/theme/js/wizard.js"></script>
      <!-- <script src="new_assets/theme/js/theme-setting.js" type="text/javascript"></script> -->
      <script src="new_assets/theme/libs/jquery/zebra-datepicker/zebra_datepicker.min.js" type="text/javascript"></script>
      <script src="new_assets/theme/libs/jquery/autocomplete/jquery.autocomplete.js" type="text/javascript"></script>
      <script src="new_assets/theme/libs/jquery/ckeditor/ckeditor.js"></script>
      <script src="new_assets/theme/js/custom.js" type="text/javascript"></script>
      <script src="new_assets/theme/libs/jquery/tooltipster/js/tooltipster.bundle.min.js" type="text/javascript"></script>
    <!--   <script src="new_assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> -->
      <script src="new_assets/plugins/select2/dist/js/select2.min.js"></script>
      <script src="new_assets/javascript/main.js"></script>
      <!-- <script src="new_assets/javascript/demo_popup.js"></script> -->
      <script src="new_assets/javascript/copy_to_clip_board.js" type="text/javascript" ></script>
      <style type="text/css">
         .margin-zero
         {
         margin-left: unset !important;
         }
      </style>
      <!-- <script src="new_assets/javascript/chart/chart.min.js"></script> -->
      <!-- <script src="new_assets/javascript/ajax-dynamic-dashboard-user.js" type="text/javascript"></script> -->
      <!-- <script src="new_assets/javascript/user_dashboard.js"></script> -->
      <link rel="stylesheet" href="new_assets/css/owl.carousel.min.css"/>
      <link rel="stylesheet" href="new_assets/theme/css/dashboard_profile.css"/>
      <script type="text/javascript" src="includes/webscript.js"></script>
      <script type="text/javascript">
        var sponsor_id = $('.getSponsordetail').val();
        var slen = sponsor_id.length;
        if (slen>0)
        {
            $elm = $('.submit-loading1');
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
            $.ajax({
                type : 'POST',
                url : "includes/webfunction",
                data :  {
                    sponsor_id : sponsor_id,
                    type : "getSponsordetail"
                },
                success : function(data)
                {
                    $(".submit-loading").remove();
                    $elm.show();
                    var data = jQuery.parseJSON(data);
                    if(data.valid)
                    {
                        $("#Sponsordetail").html(data.name);
                        return false;
                    }
                    else
                    {
                        $("#notification").css("display","block");
                            $("#notification").html(data.message);
                        $('#sponsor_id').focus();
                        return false;
                    }
                    return false;
                }
            });
        }
      </script>
   </body>
</html>
