<?php include("header.php");
   if(isset($_GET['id']))
   {
       $team_id = $_GET['id'];
       $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `team` WHERE team_id =  '$team_id'"));
   }
   ?>
<style>
   .box label
   {
   color:#000;
   }
</style>
<section id="middle">
   <header id="page-header">
      <h1>Team</h1>
   </header>
   <div id="content" class="padding-20">
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-default mypanel">
               <div class="panel-heading panel-heading-transparent">
                  <strong><?php echo isset($data['team_id'])?'Edit team':'Add Team';?></strong>
               </div>
               <div class="panel-body">
                  <form id="Manageteam" action="" method="post" enctype="multipart/form-data">
                     <fieldset>
                        <div class="row">
                           <div class="form-group">
                              <div class="col-md-6">
                                 <label>Name*</label>
                                 <div class="fancy-form">
                                    <!-- input -->
                                    <input type="text"  placeholder = "Enter Name" value="<?php echo isset($data['name'])?$data['name']:''?>" class = "form-control" name = "name" id = "name" title = "Enter Name!"  required>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <label>Designation*</label>
                                 <div class="fancy-form">
                                    <!-- input -->
                                    <input type="text"  placeholder = "Enter Designation" value="<?php echo isset($data['designation'])?$data['designation']:''?>" class = "form-control" name = "designation" id = "designation" title = "Enter Designation!"  required>
                                 </div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                                 <label>Discription*</label>
                                 <div class="fancy-form">
                                    <!-- input -->
                                    <textarea rows="5" placeholder = "Enter Discription" value="" class = "form-control" name = "description" id = "description" title = "Enter Discription!"  required><?php echo isset($data['description'])?$data['description']:''?></textarea>
                                 </div>
                              </div>
                           <div class="col-md-6 col-sm-6">
                              <label>Image </label>
                              <div class="fancy-file-upload fancy-file-primary">
                                 <i class="fa fa-upload"></i>
                                 <input type="file" class="form-control" name="image" onchange="jQuery(this).next('input').val(this.value);"  accept="image/jpeg, image/png">
                                 <input type="text" class="form-control" placeholder="No file selected" readonly="" value="<?php echo isset($data['image'])?$data['image']:''?>" required> >
                                 <span class="button">Choose File</span>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 text-center margin-top-10">
                           <input type ="hidden" name = "type" value="Manageteam">
                           <input type ="hidden" name = "team_id" value="<?php echo isset($data['team_id'])?$data['team_id']:''?>">
                           <input type="submit"  id="formvalidate" data-form="Manageteam"  class="btn btn-info btn-md btn-submit"  value="<?php echo isset($data['team_id'])?'Update Team':'Add Team';?>">
                           <div class="clearfix"></div>
                        </div>
                     </fieldset>
                  </form>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
      </div>
   </div>
</section>
<!-- /MIDDLE -->
<?php include("footer.php");?>