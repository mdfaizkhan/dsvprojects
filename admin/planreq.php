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
            <!-- <form name="bulk_action_form" action="" method="post"/> -->
            <div class="panel-body ">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                        <tr>
                            <th  class="">Full Name</th>
                            <th  class="">Plan Name</th>
                            <th  class="">Date</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT  t1.*,t2.first_name,t2.last_name,t3.uname,t4.plan_name FROM reqplan t1 join user_detail t2 on t1.uid=t2.uid join user_id t3 on t1.uid=t3.uid join plans t4 on t1.plan_id=t4.plan_id");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                    ?>
                        <tr class="odd gradeX">
                            <td><?php echo $row['first_name']."  ".$row['last_name']." (".$row['uname'].")" ;?></td>
                            <td><?php echo $row['plan_name'];?></td>
                            <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
                                               
                            <td>
                                <?php if($row['status'] == 0){ ?>
                                <button class="btn btn-success btn-xs PlanRequeststatus"  data-id="<?php echo $row['id'];?>" value="accept">Accept</button>
                                <button class="btn btn-danger btn-xs PlanRequeststatus"  data-id="<?php echo $row['id'];?>" value="reject">Reject</button>
                                <?php }
                                else if($row['status']==1){
                                    echo "<span class='label label-success'>Upgraded</span>";
                                }else{
                                    echo "<span class='label label-danger'>Rejected</span>";
                                } ?>
                            </td>
                             
                   <?php }?>
                        </tr>
                            
                    </tbody>
                </table>
            </div>
            <!-- </form> -->
            <!-- /panel content -->
        </div>
    </div>
</section>
<?php include("footer.php");?>
