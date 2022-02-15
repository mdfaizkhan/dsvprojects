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
                            <th  class="">Date</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT  t1.*,t2.first_name,t2.last_name FROM user_id t1 join user_detail t2 on t1.uid=t2.uid WHERE t1.binary_activated is not null ");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                    ?>
                        <tr class="odd gradeX">
                            <td><?php echo $row['first_name']."  ".$row['last_name']." (".$row['uname'].")" ;?></td>
                            <td><?php echo isset($row['binary_date']) && !empty($row['binary_date'])?date("d-m-Y",strtotime($row['binary_date'])):''; ?></td>
                                               
                            <td>
                                <?php if($row['binary_activated'] == 0){ ?>
                                <button class="btn btn-success btn-xs confirmcancel"  data-userid="<?php echo $row['uid'];?>" value="accept">Accept</button>
                                <button class="btn btn-danger btn-xs confirmcancel"  data-userid="<?php echo $row['uid'];?>" value="reject">Reject</button>
                                <?php }
                                else if($row['binary_activated']==1){
                                    echo "<span class='label label-success'>Accepted</span>";
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
