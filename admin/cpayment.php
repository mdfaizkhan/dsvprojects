<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Confirm Payment</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Confirm Payment</strong>
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
                            <th  class="">ID</th>
                            <th  class="">Invoice No</th>
                            <th  class="">Username</th>
                            <th  class="">First Name</th>
                            <th  class="">Last Name</th>
                            <th  class="">Date</th>
                            <th  class="">Txn Id</th>
                            <th  class="">Note</th>
                            <th  class="">Image</th>
                            <th  class="">Payment Status</th>
                            <th  class="">Payment Date</th>
                            <th  class="">Confirmation</th>
                            <th  class="">Confirmation Date</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT t1.*,t2.uname,t3.first_name,t3.last_name FROM product_purchase t1 left join user_id t2 on t1.uid=t2.uid left join user_detail t3 on t1.uid=t3.uid order by t1.id ") or die(mysqli_error($db));
                    while($row = mysqli_fetch_assoc($sql))
                    {
                    ?>
                        <tr class="odd gradeX">
                            <!--<td align="center">
                                <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                            </td>-->
                            <td><?php echo $i++;?></td>
                            <td><?php echo "QTEG".leftpad($row['id'],6);?></td>
                            <td><?php echo $row['uname'];?></td>
                            <td><?php echo $row['first_name'];?></td>
                            <td><?php echo $row['last_name'];?></td>
                            <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
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
                            <td><?php if(isset($row['image']) && !empty($row['image']))
                                {
                                    echo '<img src="../upload/payment/'.$row['image'].'"  style="width:100px;height:auto;">';
                                }
                                ?>
                            </td>
                            <td><?php if($row['cleared'] == 1)
                                {
                                    echo '<i class = "fa fa-check-circle" style="color: green;"></i> Paid';
                                }
                                else
                                {
                                    echo 'Pending';
                                }

                                ?>
                            </td>
                            <td><?php echo isset($row['cleared_date']) && !empty($row['cleared_date'])?date("d-m-Y",strtotime($row['cleared_date'])):''; ?></td>
                            <<td><?php if($row['cleared'] == 2)
                                {
                                    echo '<i class = "fa fa-check-circle" style="color: green;"></i> Confirmed';
                                }
                                else
                                {
                                    echo 'Pending';
                                }

                                ?>
                            </td>
                            <td><?php echo isset($row['c_date']) && !empty($row['c_date'])?date("d-m-Y",strtotime($row['c_date'])):''; ?></td>
                            <td>
                                <a href="myinvoice?id=<?php echo $row['id'];?>" class="btn btn-info btn-xs" id="invoice" data-id="" />View Invoice</a>
                                <?php 
                                if($row['cleared'] == 2)
                                {
                                    echo '<a href="receipt?id=<?php echo $row[id];?>" class="btn btn-info btn-xs" id="receipt" data-id="" />View Receipt</a>';
                                }
                                else if($row['cleared'] == 1)
                                {
                                    ?>
                                        <input type="button" class="btn btn-success btn-xs OrdersMarkAsPaid" id="OrdersMarkAsPaid" data-id="<?php echo $row['id'];?>"  value="Confirm Payment"/> 
                                    <?php
                                    
                                }
                                else
                                { 
                                    //echo '<i class = "fa fa-check-circle" style="color: green;"></i> Pending';
                                 } ?>
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
