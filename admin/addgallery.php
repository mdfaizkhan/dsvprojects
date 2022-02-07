<?php include("header.php");
if(isset($_GET['id']))
{
    $gallery_id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `gallery` WHERE gallery_id =  '$gallery_id'"));
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
         <h1>Gallery</h1>
      </header>
      <div id="content" class="padding-20">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default mypanel ">
                  <div class="panel-heading panel-heading-transparent">
                     <strong><?php echo isset($data['gallery_id'])?'Edit gallery':'Add gallery';?></strong>
                  </div>
                  <div class="panel-body">
                     <form id="Managegallery" action="" method="post" enctype="multipart/form-data">
                        <fieldset>
                  <div class="row">
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
                        <input type ="hidden" name = "type" value="Managegallery">
                        <input type ="hidden" name = "gallery_id" value="<?php echo isset($data['gallery_id'])?$data['gallery_id']:''?>">
                        <input type="submit"  id="formvalidate" data-form="Managegallery"  class="btn btn-info btn-md btn-submit"  value="<?php echo isset($data['gallery_id'])?'Update gallery':'Add gallery';?>">
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




