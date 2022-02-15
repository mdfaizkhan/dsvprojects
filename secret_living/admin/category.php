<?php include_once "header.php";
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `product_category` WHERE cat_id =  '$id'"));
}
?>
    <section id="middle">
        <header id="page-header">
            <h1>Category</h1>
        </header>
        <div id="content" class="padding-20">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default mypanel ">
                        <div class="panel-heading panel-heading-transparent">
                            <strong><?php echo isset($data['cat_id'])?'Edit Category':'Add Category';?></strong>
                        </div>
                        <div class="panel-body">
                            <form  class="form-horizontal" method = "post" id='ManageCategory' action = ""  enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label ">Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="cat_name" required id="catname" placeholder="Category Name" class="form-control"  value="<?php echo isset($data['cat_name']) && !empty($data['cat_name'])?$data['cat_name']:''; ?>" />
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="hidden" name="type" value="ManageCategory">
                                            <input type="hidden" name="cat_id"  value="<?php echo $data['cat_id']; ?>">
                                            <button name = "submit" type = "submit"  class="btn btn-info btn-sm btn-submit btn1" >Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h2 class="panel-title">Category</h2>
                        
                        </div>
                        <div class="panel-body">
                        
                            <div class="table-responsive">
                                <table class="table table-bordered dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <!-- <th>Image</th> -->
                                            <th>Category Name</th>
                                            <th>Created</th>                                       
                                            <!-- <th>Last Modify</th> -->                                       
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sr=1;
                                   $q1=mysqli_query($db,"SELECT * FROM `product_category`");
                                   if(mysqli_num_rows($q1)>0)
                                   {
                                    while($r1=mysqli_fetch_assoc($q1))
                                    {
                                    ?>
                                    <tr>     
                                            <td><?php echo $sr++;?>.</td>                               
                                           <!-- <td>
                                              <img src="../upload/category/<?php //echo $r1["image"]; ?>"  style="width:40px;padding-right:6px">
                                            </td> -->
                                            <td>                                        
                                            <?php echo $r1["cat_name"]; ?>
                                            </td>
                                            <td><?php echo modifyDate($r1['created']);?></td>
                                            <!-- <td><?php //echo modifyDate($r1['modify']);?></td> -->                                        
                                            <td>
                                            <a href="?id=<?php echo $r1['cat_id'];?>" title="<?php echo "Edit Product ". $r1['cat_name'];?>" data-id="<?php echo $r1['cat_id'];?>" class="btn btn-info btn-xs EditCat"><i class="fa fa-pencil"></i> Edit</a>
                                            <a href="javascript:void(0);" title="Delete <?php echo "Product ". $r1['cat_name'];?>" class="DeleteCat btn btn-danger btn-xs" data-id="<?php echo $r1['cat_id'];?>"><i class="fa fa-trash"></i> Delete</a>
                                           </td>
                                          
                                        </tr>
                                    <?php }
                                    }else { ?>
                                     <tr>                                      
                                            <td colspan="6" class="text-center"> No Category found </td>
                                          
                                        </tr>
                                    <?php } ?>
                                  
                                    
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            </div>                  
        </div>
    </section>
      
<?php include_once "footer.php";?>

