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
                            <th  class="">Plan Name</th>
                            <th  class="">Amount</th>
                            <th  class="">Date</th>
                            <th  class="">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT t1.*,t2.* FROM purchase t1 join rplans t2 on t1.plan_id=t2.plan_id where uid='$mlmid' order by t1.id ");
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
                            <td><?php echo $row['plan_name'];?></td>
                            <td><?php echo "Rs.".$row['plan_amount'];?></td>
                            <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
                            <td><?php echo isset($status)?$status:'';?></td>
                            
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
