<?php include("header.php");
if(isset($_GET['id']))
{
    $setting_id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `setting` WHERE id =  '$setting_id'"));
}
else{
?>

 <script type="text/javascript">
   alert('You have not permission');
   window.location.href='dashboard';
 </script>

<?php
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
         <h1>Setting</h1>
      </header>
      <div id="content" class="padding-20">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default mypanel ">
                  <div class="panel-heading panel-heading-transparent">
                     <strong><?php echo isset($data['setting_id'])?'Setting':'Setting';?></strong>
                  </div>
                  <div class="panel-body">
                     <form id="Managesetting" action="" method="post" enctype="multipart/form-data">
                        <fieldset>
                        <div class="row">
                              <div class="col-md-3 col-sm-3">
                                
                                  <label>Board 1 double pairing bonus </label>
                                  <div class="fancy-file-upload fancy-file-primary">
                                      <i class="fa fa-percent"></i>
                                      <input type="text" class="form-control" name="pool1_double_pairing_bonus" value="<?php echo isset($data['pool1_double_pairing_bonus'])?$data['pool1_double_pairing_bonus']:''?>" required> >
                                  </div>
                              </div>
                              <div class="col-md-3 col-sm-3">
                                  <label>Board 2 double pairing bonus GENERAL </label>
                                  <div class="fancy-file-upload fancy-file-primary">
                                      <i class="fa fa-percent"></i>
                                      <input type="text" class="form-control" name="pool2_double_pairing_bonus1" value="<?php echo isset($data['pool2_double_pairing_bonus1'])?$data['pool2_double_pairing_bonus1']:''?>" required> >
                                  </div>
                              </div>

                              <div class="col-md-3 col-sm-3">
                                  <label>Board 2 double pairing bonus PREMIUM </label>
                                  <div class="fancy-file-upload fancy-file-primary">
                                      <i class="fa fa-percent"></i>
                                      <input type="text" class="form-control" name="pool2_double_pairing_bonus2" value="<?php echo isset($data['pool2_double_pairing_bonus2'])?$data['pool2_double_pairing_bonus2']:''?>" required> >
                                  </div>
                              </div>

                              <div class="col-md-3 col-sm-3">
                                  <label>Board 2 double pairing bonus EXCLUSIVE </label>
                                  <div class="fancy-file-upload fancy-file-primary">
                                      <i class="fa fa-percent"></i>
                                      <input type="text" class="form-control" name="pool2_double_pairing_bonus3" value="<?php echo isset($data['pool2_double_pairing_bonus3'])?$data['pool2_double_pairing_bonus3']:''?>" required> >
                                  </div>
                              </div>
                        </div>
                        <hr>
                         <div class="row">
                              <div class="col-md-3 col-sm-3">
                                  <label>Repurchased pairing bonus </label>
                                  <div class="fancy-file-upload fancy-file-primary">
                                      <i class="fa fa-percent"></i>
                                      <input type="text" class="form-control" name="repurchased_pairing_bonus" value="<?php echo isset($data['repurchased_pairing_bonus'])?$data['repurchased_pairing_bonus']:''?>" required> >
                                  </div>
                              </div>
                        </div>


                    <div class="col-md-12 col-sm-12 text-center margin-top-10">
                        <input type ="hidden" name = "type" value="Managesetting">
                        <input type ="hidden" name = "id" value="<?php echo isset($data['id'])?$data['id']:''?>">
                        <input type="submit"  id="formvalidate" data-form="Managesetting"  class="btn btn-info btn-md btn-submit"  value="<?php echo isset($data['id'])?'Update':'Update';?>">
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




