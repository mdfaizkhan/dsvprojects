<?php include("header.php");?>
<section id="middle">
   
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Packages</strong> <!-- panel title -->
                    <a href="addplan" class="btn btn-info btn-xs pull-right"><i class = "fa fa-plus"></i>  Package</a>
                </span>
            </div>

            
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                      <tr>
                        <tr>
                            <th  class="">Title</th>
                            <th  class="">Package Name</th>
                            <th  class="">Package Amount</th>
                            <th  class="">PV</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT * FROM plans order by plan_id");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                    ?>
                        <tr class="odd gradeX">
                            <!--<td align="center">
                                <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                            </td>-->
                            <td><?php echo $row['title'];?></td>
                            <td><?php echo $row['plan_name'];?></td>
                            <td><?php echo "RM.".$row['plan_amount'];?></td>
                            <td><?php echo $row['pv'];?></td>
                            <!--<td><?php //echo isset($row['capping']) && $row['capping']>0?AmountToPV($row['capping']):'Not Applicable';?></td>-->
                            <!-- <td><?php echo "Rs.".$row['royal_amount'];?></td> -->
                            
                            <td  class="">
                                <a href="addplan?id=<?php echo $row['plan_id'];?>" title="<?php echo "Edit Plan ". $row['plan_name'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                <!-- <a href="javascript:void(0);" title="Delete <?php echo "Plan ". $row['plan_name'];?>" class="deleteplan btn btn-danger btn-xs" data-id="<?php echo $row['plan_id'];?>"><i class="fa fa-trash"></i> Delete</a>-->
                                <a href="setlevel?id=<?php echo $row['plan_id'];?>" title="<?php echo "Set Level Income For Plan ". $row['plan_name'];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Set Income</a>
                                <!--<?php if(isset($row['binary_royalty']) && $row['binary_royalty']==1){ ?>
                                    <a href="setroyalty?id=<?php echo $row['plan_id'];?>" title="<?php echo "Set Royalty Amount For Plan ". $row['plan_name'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Set Royalty</a> -->
                                <?php } ?>
                                
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>
            </form>
            <!-- /panel content -->

        </div>
    </div>
</section>
<?php include("footer.php");?>
