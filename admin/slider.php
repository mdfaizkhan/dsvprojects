<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Slider</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Slider</strong> <!-- panel title -->
                    <a href="addslider" class="btn btn-info btn-xs opt pull-right"><i class = "fa fa-plus"></i> Add </a>
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                            <tr>
                                <th  class="">Slider ID</th>
                                <th  class="">Image</th>       
                                <th  class="">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT * FROM slider");
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
                                <td><?php 
                                    if(isset($row['image']) && !empty($row['image']))
                                    {
                                        echo "<img src='../upload/slider/".$row['image']."' height='100px' width='100px'>";
                                    }
                                ?></td>
                                
                                <td  class="">
                                    <a href="addslider?id=<?php echo $row['slider_id'];?>" title="" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="javascript:void(0);" title="Delete" class="deleteslider btn btn-danger btn-xs" data-id="<?php echo $row['slider_id'];?>"><i class="fa fa-trash"></i> Delete</a>
                                                                     
                                    
                                    <?php }  ?>
                                    
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
