<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Re-Purchase</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Re-Purchase Plans</strong>
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                      <tr>
                        <tr>
                            <th  class="">Plan ID</th>
                            <th  class="">Plan Name</th>
                            <th  class="">Plan Amount</th>
                            <th  class=""> Purchase Amount</th>
                            <!--<th  class="">Capping</th>-->
                            <th  class="">Description</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT * FROM rplans order by plan_id ");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                    ?>
                        <tr class="odd gradeX">
                            <!--<td align="center">
                                <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                            </td>-->
                            <td><?php echo $i++;?></td>
                            <td><?php echo $row['plan_name'];?></td>
                            <td><?php echo "Rs.".$row['plan_amount'];?></td>
                            <td><?php echo "Rs.".$row['ramount'];?></td>
                            <!--<td><?php //echo isset($row['capping']) && $row['capping']>0?AmountToPV($row['capping']):'Not Applicable';?></td>-->
                            <td><?php echo $row['plan_desc'];?></td>
                            <td  class="">
                                <a href="javascript:void(0);" title="Purchase <?php echo "Plan ". $row['plan_name'];?>" class="PurchasePlan btn btn-info btn-xs" data-id="<?php echo $row['plan_id'];?>" data-price="<?php echo $row['ramount'];?>"><i class="fa fa-shopping-cart"></i> Purchase</a>
                                
                                
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
