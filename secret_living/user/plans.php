<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Plans</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Plans</strong> <!-- panel title -->
                    <a href="addplan" class="opt pull-right"><i class = "fa fa-plus"></i></a>
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                          <tr>
                            <tr>
                                <th  class="">Plan ID</th>
                                <th  class="">Plan Name</th>
                                <th  class="">Plan Amount</th>
                                <th  class="">Capping</th>
                                <th  class="">Description</th>
                                <th  class="">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT * FROM plans");
                        while($row = mysqli_fetch_assoc($sql))
                        {
                        ?>
                            <tr class="odd gradeX">
                                <!--<td align="center">
                                    <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                                </td>-->
                                <td><?php echo $row['plan_id'];?></td>
                                <td><?php echo $row['plan_name'];?></td>
                                <td><?php echo "Rs.".$row['plan_amount'];?></td>
                                <td><?php echo isset($row['capping']) && $row['capping']>0?AmountToPV($row['capping']):'Not Applicable';?></td>
                                <td><?php echo $row['plan_desc'];?></td>
                                <td  class="">
                                    <a href="addplan?id=<?php echo $row['plan_id'];?>" title="<?php echo "Edit Plan ". $row['plan_name'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="javascript:void(0);" title="Delete <?php echo "Plan ". $row['plan_name'];?>" class="deleteplan btn btn-danger btn-xs" data-id="<?php echo $row['plan_id'];?>"><i class="fa fa-trash"></i> Delete</a>
                                    <a href="setlevel?id=<?php echo $row['plan_id'];?>" title="<?php echo "Set Level Percentage For Plan ". $row['plan_name'];?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Set Percentage</a>
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
