<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Other Products</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Other Products</strong> <!-- panel title -->
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
                            <th  class="">Category</th>
                            <th  class="">MRP</th>
                            <th  class="">BV</th>
                            <th  class="">Image</th>
                            <th  class="">Description</th>
                            <th  class="">Date</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT t1.*,t2.cat_name FROM products t1 left join product_category t2 on t1.cat_id=t2.cat_id order by product_id");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                    ?>
                        <tr class="odd gradeX">
                           
                            <td><?php echo $i++;?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['cat_name'];?></td>
                            <td><?php echo "Rs.".$row['mrp'];?></td>
                            <td><?php echo $row['bv'];?></td>
                            <td><?php 
                                if(isset($row['image']) && !empty($row['image']))
                                {
                                    echo "<img src='../upload/product/".$row['image']."' height='100px' width='100px'>";
                                }
                            ?></td>
                            
                            <td><?php echo $row['product_desc'];?></td>
                            <td><?php echo date("d/m/Y",strtotime($row['date']));?></td>
                            <td  class="">
                                <a href="javascript:void(0);" title="Purchase <?php echo "Product ". $row['name'];?>" class="ProductPurchase btn btn-info btn-xs" data-id="<?php echo $row['product_id'];?>" data-price="<?php echo $row['mrp'];?>"><i class="fa fa-shopping-cart"></i> Purchase</a>
                            </td>
                        </tr>
                    <?php
                    }
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
<?php include("footer.php");?>
