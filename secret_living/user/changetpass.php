<?php include("header.php");?>	
<style>
.box label
{
	color:#000;
}
</style>			
<section id="middle">
    <header id="page-header">
            <h1>Change Transaction Password</h1>
    </header>
    <div id="content" class="padding-20">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default mypanel ">
                    <div class="panel-heading panel-heading-transparent">
                            <strong>Change Transaction Password</strong> 
                    </div>
                    <div class="panel-body">
                        <form  action="" id="changetranspass" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>Current Transaction Password *</label>
                                            <div class="fancy-form"><!-- input -->
                                                <i class="fa fa-key"></i>
                                                <input type="password"  placeholder = "Please type your current password" class = "form-control" name ="current_password" id ="current_password" title ="Enter current password !" min="6">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>New Transaction Password *</label>
                                            <div class="fancy-form"><!-- input -->
                                                <i class="fa fa-key"></i>
                                                <input type="password"  placeholder = "Please enter your new password" class = "form-control" name ="new_password" id = "new_password"  title="Enter New Password">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>Confirm Transaction Password *</label>
                                            <div class="fancy-form"><!-- input -->
                                                <i class="fa fa-key"></i>
                                                <input type="password"  placeholder = "Please retype your new password" class = "form-control" name = "confirm_password" id ="rpassword">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 text-center">
                                            <button type="submit" name ="updatetpassword"  class="btn btn-info btn-md btn-submit" >Update Password</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>					
    </div>
</section>
<?php include("footer.php");?>