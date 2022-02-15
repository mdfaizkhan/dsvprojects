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
                    <a href="javascript:void(0);" class="opt pull-right btn btn-xs btn-info request_for_withdraw">Request For Withdraw</a>
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
                                <th class="">Amount</th>
                                <th class="">Requested Date</th>
                                <th class="">Approved Date</th>
                                <th class="">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT * FROM withdraw_request WHERE uid = '$mlmid'");
                        while($row = mysqli_fetch_assoc($sql))
                        {
                            $status = 'Processing';
                            if($row['status'] == '1') $status = 'Completed';
                            if($row['status'] == '2') $status = 'Rejected';
                        ?>
                            <tr class="odd gradeX">
                                <td><?=$i;$i++;?></td>
                                <td><?=$row['payout_amount'];?></td>
                                <td><?=date('Y-m-d',strtotime($row['requested_date']));?></td>
                                <td><?=(!empty($row['responded_date']))?date('Y-m-d',strtotime($row['responded_date'])):'';?></td>
                                <td><?=$status;?></td>
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
