<?php include("header.php");?>

<!--
    MIDDLE
-->
<style>

</style>
<section id="middle">
    <header id="page-header">
        <h1>Transaction Pin</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Used Transaction Pin</strong> <!-- panel title -->
                    
                </span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                        <tr>
                        <tr>
                            <td align="center"> ID</td>
                            <th  class="">PIN</th>
                            <th  class="">Plan Amount</th>
                            <th  class="">User</th>
                            <th  class="">Sponsor</th>
                            <th  class="">Used</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        //echo "SELECT t1.*,t3.plan_id,t3.plan_amount FROM transpin t1 join plans t3 on t1.plan_id = t3.plan_id where status='1' and t1.allot_uid ='$mlmid' order by status";
                        $sql=mysqli_query($db,"SELECT t1.*,t3.plan_id,t3.plan_amount FROM transpin t1 join plans t3 on t1.plan_id = t3.plan_id where status='1' and t1.allot_uid ='$mlmid' order by status");
                        while($row = mysqli_fetch_assoc($sql))
                        {
                            ?>
                            <tr class="odd gradeX" <?php if($row['status'] == 1) echo 'style="background-color:rgba(94, 199, 94, 0.59);"'?>>
                                <td align="center">
                                    <?= $i++?>
                                </td>
                                <td><?php echo $row['pin_code'];?></td>
                                <td><?php echo "Rs.".$row['plan_amount'];?></td>
                                 <td><?php
                                    if(!empty($row["uid"]))
                                    {
                                        $uid = $row["uid"];

                                        $r2 = mysqli_fetch_assoc(mysqli_query($db,"select t1.uid,t1.uname,t3.uname as suname from user_id t1 left join pairing t2 on t1.uid=t2.uid left join user_id t3 on t2.sponsor_id=t3.uid where t1.uid = $uid"));
                                        echo $r2['uname'];
                                    }
                                    ?></td>
                                <td><?php echo isset($row['uid']) && isset($r2['suname'])?$r2['suname']:'';?></td>
                                <td><?php if($row['status'] == 1)
                                        echo '<i class = "fa fa-check-circle" style="color: green;"></i>';
                                    else
                                        echo '<i class = "fa fa-times-circle" style="color: red;"></i>';

                                    ?></td>
                            </tr><!--#31708F-->
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /panel content -->

        </div>
    </div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>

