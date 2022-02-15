<?php include("header.php");?>
<?php 
    $mlmid = isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'';
?>
<section id="middle">
    <header id="page-header">
        <h1>Withdraw</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Withdraw</strong> <!-- panel title -->
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
                                <th class="">Requested ID</th>
                                <th class="">Full Name</th>
                                <th class="">Username</th>
                                <th class="">Amount</th>
                                <th class="">Requested Date</th>
                                <th class="">Approved Date</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT 
                                                t1.request_id,
                                                t1.payout_amount,
                                                t1.status,
                                                t1.requested_date,
                                                t1.status,
                                                t1.responded_date,
                                                t2.uname,
                                                concat(t3.first_name,' ',t3.last_name) as name
                                                FROM withdraw_request t1 
                                                INNER JOIN user_id t2 ON t2.uid = t1.uid
                                                INNER JOIN user_detail t3 ON t3.uid = t1.uid
                                                ");
                        //WHERE t1.status = '0'
                        while($row = mysqli_fetch_assoc($sql))
                        {
                            $status = 'Processing';
                            if($row['status'] == '1') $status = 'Completed';
                            if($row['status'] == '2') $status = 'Rejected';
                        ?>
                            <tr class="odd gradeX">
                                <td><?=$i;$i++;?></td>
                                <td><?=$row['name'];?></td>
                                <td><?=$row['uname'];?></td>
                                <td><?=$row['payout_amount'];?></td>
                                <td><?=date('Y-m-d',strtotime($row['requested_date']));?></td>
                                <td><?php echo isset($row['status']) && $row['status']==1?date('Y-m-d',strtotime($row['responded_date'])):'';?></td>
                                <td>
                                    <?php if(isset($row['status']) && $row['status']==0)
                                    { ?>
                                    <a href="javascript:void(0);" class="btn btn-xs btn-info Approve" data-id="<?=$row['request_id'];?>" data-status="1">Approve</a>
                                    <a href="javascript:void(0);" class="btn btn-xs btn-danger Reject" data-id="<?=$row['request_id'];?>" data-status="2">Reject</a>
                                    <?php } else { echo "Approved"; } ?>
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
<script type="text/javascript">
    var uid = <?=$mlmid;?>;
</script>
<?php include("footer.php");?>
