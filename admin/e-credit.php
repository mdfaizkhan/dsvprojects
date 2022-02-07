<?php include("header.php");

?>
<section id="middle">
    <header id="page-header">
        <h1>E-wallet credit</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>E-wallet credit</strong>
                    <!-- <a class="btn btn-xs btn-info pull-right" href="addbal" title="Add Wallet Balance Request" ><i class="fa fa-plus white"> Add</i></a> -->
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                            <tr>
                                <th  class="">ID</th>
                                <th  class="">Username</th>
                                <th  class="">Amount</th>
                                <th  class="">Txn Id</th>
                                <th  class="">Note</th>
                                <th  class="">Date</th>
                                <th  class="">Confirmation Date</th>
                                <th  class="">Confirmation</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT t1.*,t2.uname,t3.first_name,t3.last_name FROM bal_req t1 left join user_id t2 on t1.uid=t2.uid left join user_detail t3 on t1.uid=t3.uid where t1.status=1  order by t1.req_id ") or die(mysqli_error($db));
                        while($row = mysqli_fetch_assoc($sql))
                        {
                        ?>
                            <tr class="odd gradeX">
                               
                                <td><?php echo $i++;?></td>
                                
                                <td><?php echo $row['uname'];?></td>
                                <td><?php echo $row['amount'];?></td>
                                
                                <td><?php if(isset($row['txnid']) && !empty($row['txnid']))
                                    {
                                        echo $row['txnid'];
                                    }
                                    ?>
                                </td>
                                <td><?php if(isset($row['note']) && !empty($row['note']))
                                    {
                                        echo $row['note'];
                                    }
                                    ?>
                                </td>
                               
                                <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
                                <td><?php echo isset($row['approve_date']) && !empty($row['approve_date'])?date("d-m-Y",strtotime($row['approve_date'])):''; ?></td>
                                <td><?php if($row['status'] == 1)
                                    {
                                        echo '<i class = "fa fa-check-circle" style="color: green;"></i> Confirmed';
                                    }
                                    else  if($row['status'] == 2)
                                    {
                                        echo '<i class = "fa fa-ban" style="color: red;"></i> Rejected';
                                    }
                                    else
                                    {
                                        echo 'Pending';
                                    }

                                    ?>
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
