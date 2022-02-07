<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>My Purchase Order</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>My Purchase Order</strong>
                    <a href="javascript:void(0);" class="pull-right btn btn-xs btn-success ApprovePurchaseReq"><i class = "fa fa-check"></i> Approve</a>
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                      <tr>
                        <tr>
                            <th  class="">ID</th>
                            <td align="center"> <input type="checkbox" name="checkedall" id = "bump-offer" /></td>
                            <th  class="">User</th>
                            <th  class="">Plan Name</th>
                            <th  class="">Plan Amount</th>
                            <th  class="">Date</th>
                            <th  class="">Status</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT t1.*,t2.*,t3.uname,t4.first_name,t4.last_name FROM purchase t1 join rplans t2 on t1.plan_id=t2.plan_id join user_id t3 on t1.uid=t3.uid join user_detail t4 on t1.uid=t4.uid order by t1.id ");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                        if(isset($row['status']) && $row['status']==1)
                        {
                            $status="Approved";
                        }
                        else if(isset($row['status']) && $row['status']==2)
                        {
                            $status="Rejected";
                        }
                        else
                        {
                            $status="Pending";
                        }
                    ?>
                        <tr class="odd gradeX">
                            <td><?php echo $i++;?></td>
                            <td align="center">
                                <?php if(isset($row['status']) && $row['status']==0){ ?>
                                <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row['id']; ?>"/>
                            <?php } else { echo "<i class='fa fa-times'></i>"; } ?>
                            </td>
                            <td><?php echo $row['first_name']." ".$row['last_name']." (".$row['uname'].")";?></td>
                            <td><?php echo $row['plan_name'];?></td>
                            <td><?php echo "Rs.".$row['plan_amount'];?></td>
                            <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
                             <td><?php echo isset($status)?$status:'';?></td>
                            <td>
                                <?php if(isset($row['status']) && $row['status']==0){ ?>
                                <a href="javascript:void(0);" title="Reject Request" class="RejectPurchaseReq btn btn-danger btn-xs" data-id="<?php echo $row['id'];?>"><i class="fa fa-times"></i> Reject</a>
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
