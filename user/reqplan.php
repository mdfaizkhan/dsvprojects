<?php include("header.php");?>

<section id="middle">

    <header id="page-header">

        <h1>plans</h1>

    </header>

    <div id="content" class="padding-20">

        <div id="panel-1" class="panel panel-default mypanel">

            <div class="panel-heading">

                <span class="title elipsis">

                    <strong>Plans</strong>

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

                            <th  class="">Description</th>

                            <th  class="">Action</th>

                        </tr>

                    </thead>



                    <tbody>

                    <?php

                    $i = 1;
                    $r2=mysqli_fetch_assoc(mysqli_query($db,"SELECT t3.plan_amount from transpin t2 join plans t3 on t2.plan_id = t3.plan_id where t2.uid='$mlmid'"));
                    $plan_amount=$r2['plan_amount'];
                    $sql=mysqli_query($db,"SELECT * from plans ORDER BY plan_amount");

                    while($row = mysqli_fetch_assoc($sql))
                    {
                        $planid=$row['plan_id'];

                    ?>

                        <tr class="" id="plan_<?php echo $row['plan_id'];?>">

                            <!--<td align="center">

                                <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>

                            </td>-->

                            <td><?php echo $i++;?></td>

                            <td><?php echo $row['plan_name'];?></td>
                            <td><?php echo "Rs.".$row['plan_amount'];?></td>

                            <td><?php echo $row['plan_desc'];?></td>

                            <td  class="">
                                <?php
                                $result=mysqli_query($db,"SELECT * FROM `reqplan` WHERE uid='$mlmid' and plan_id='$planid'");
                                 if(mysqli_num_rows($result) > 0)
                                {
                                    echo "<span class='label label-warning'>Request Sent</span>";
                                }
                                else
                                {
                                    if($plan_amount<$row['plan_amount']){
                                ?>
                                    <a href="javascript:void(0);" title="Purchase <?php echo "Plan ". $row['plan_name'];?>" class="ReqUpgradePlan btn btn-info btn-xs" data-id="<?php echo $row['plan_id'];?>" data-price="<?php echo $row['ramount'];?>"><i class="fa fa-shopping-cart"></i>Upgrade</a>
                                <?php } } ?>
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

