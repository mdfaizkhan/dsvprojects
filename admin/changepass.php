<?php include("header.php");?>
 
<section id="middle">
    <header id="page-header">
        <h1>Change Password</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    Change Password <!-- panel title -->
                    
                </span>
            </div>
            <div class="panel-body ">

              <div class="col-md-7 col-md-offset-2 m-b-xxl" id="msform">
                <fieldset class="active" id="fieldset1">
                    <center>
                       <form  action="" id="adminchangepass" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>Current Password *</label>
                                            <div class="fancy-form "><!-- input -->
                                                <input type="password"  placeholder = "Please type your current password" class = "form-control" name ="current_password" id ="current_password" title ="Enter current password !" min="6">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>New Password *</label>
                                            <div class="fancy-form"><!-- input -->
                                                <input type="password"  placeholder = "Please enter your new password" class = "form-control" name ="new_password" id = "new_password"  title="Enter New Password">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>Confirm Password *</label>
                                            <div class="fancy-form"><!-- input -->
                                                <input type="password"  placeholder = "Please retype your new password" class = "form-control" name = "confirm_password" id ="rpassword">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 text-center">
                                            <button type="submit" name ="updatepassword"  class="btn btn-info btn-md btn-submit" >Update Password</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div> 
                        </form>
                    </center>
                <!-- </form> -->
                </fieldset>
             </div>

            </div>
        </div>
    </div>
</section>
<?php include("footer.php");?>
