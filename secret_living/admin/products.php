<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Products</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Products</strong> <!-- panel title -->
                    <a href="addproduct" class="btn btn-info btn-xs opt pull-right"><i class = "fa fa-plus"></i> Add </a>
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                            <tr>
                                <th  class="">Product ID</th>
                                <th  class="">Product Name</th>
                                 <th  class="">Package</th>
                                <th  class="">MRP</th>
                                <th  class="">PV</th>
                                <th  class="">Member Price</th>
                                <th  class="">Selling Price</th>
                                <th  class="">Image</th>
                                <th  class="">Description</th>
                                <!-- <th  class="">Date</th> -->
                                <th  class="">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT t1.*,t2.plan_name FROM products t1 left join plans t2 on t1.plan_id=t2.plan_id order by product_id");
                        //$sql=mysqli_query($db,"SELECT t1.* FROM products t1  order by product_id");
                        if(mysqli_num_rows($sql) > 0)
                        {
                        while($row = mysqli_fetch_assoc($sql))
                        {
                        ?>
                            <tr class="odd gradeX">
                                <!--<td align="center">
                                    <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['product_id']; */?>"/>
                                </td>-->
                                <td><?php echo $i++;?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['plan_name'];?></td>
                                <td><?php echo "RM.".$row['mrp'];?></td>
                                <td><?php echo $row['member_price'];?></td>
                                <td><?php echo $row['selling_price'];?></td>
                                <td><?php echo $row['pv'];?></td>
                                <td><?php 
                                    if(isset($row['image']) && !empty($row['image']))
                                    {
                                    ?>
                                    <img src='../upload/product/<?= $row['image']; ?>' height='47px' width='50px' onError="this.onerror=null; this.src='../new_assets/uploads/images/logos/no_image.png'">
                                    <?php
                                    }

                                ?></td>
                                
                                <td><span title="<?php echo "Description Of ". $row['name'];?>" class="btn btn-info btn-xs" onclick="showDescription(this)"  showDescription="<?php echo $row['product_desc'];?>"><i class="fa fa-eye" ></i> Show Description</span></td>
                                <!-- <td><?php echo date("d/m/Y",strtotime($row['date']));?></td> -->
                                <td  class="">
                                    <a href="addproduct?id=<?php echo $row['product_id'];?>" title="<?php echo "Edit Plan ". $row['name'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="javascript:void(0);" title="Delete <?php echo "Plan ". $row['name'];?>" class="deleteProduct btn btn-danger btn-xs" data-id="<?php echo $row['product_id'];?>"><i class="fa fa-trash"></i> Delete</a>
                                    <?php if($row['status']==0){  ?>
                                    <a href="javascript:void(0);" title="Hide <?php echo "Plan ". $row['name'];?>" class="HideProduct btn btn-success btn-xs" data-id="<?php echo $row['product_id'];?>" data-value="1"><i class="fa fa-success"></i>Hide</a>
                                    <?php } if($row['status']==1){  ?>
                                    <a href="javascript:void(0);" title="Hide <?php echo "Plan ". $row['name'];?>" class="HideProduct btn btn-primary btn-xs" data-id="<?php echo $row['product_id'];?>" data-value="0"><i class="fa fa-primary"></i>UnHide</a>
                                    <?php }  ?>
                                    
                                </td>
                            </tr>
                        <?php
                        } }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            <!-- /panel content -->
        </div>
    </div>
</section>


<!-- Modal -->
<div id="description" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%">

    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body" style="height:400px">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
    function showDescription(e){
         $('.modal-body').html($(e).attr('showDescription'));
         $('.modal-title').html($(e).attr('title'));
        $(e).attr("data-toggle","modal")
        $(e).attr("data-target","#description")
    }
</script>   
<?php include("footer.php");?>
