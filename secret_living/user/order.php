<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Order</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Order</strong>
                    <!-- <a href="add_order" class="btn btn-info btn-xs pull-right"><i class = "fa fa-plus"></i> Add </a> -->
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
                                <th  class="">Invoice No</th>
                                <th  class="">Username</th>
                                <th  class="">First Name</th>
                                <th  class="">Last Name</th>
                                <th  class="">MRP</th>
                                <th  class="">PV</th>
                                <th  class="">Shipping Charge</th>
                                <!-- <th  class="">Date</th> -->
                                <th  class="">Payment Status</th>
                                <th  class="">Payment Date</th>
                                <th  class="">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $total_amount=0;
                        $sql=mysqli_query($db,"SELECT t1.*,t2.uname,t3.first_name,t3.last_name FROM checkout t1 left join user_id t2 on t1.uid=t2.uid left join user_detail t3 on t1.uid=t3.uid where t1.uid='$mlmid' order by t1.id ") or die(mysqli_error($db));
                        while($row = mysqli_fetch_assoc($sql))
                        {
                        ?>
                            <tr class="odd gradeX">
                                <!--<td align="center">
                                    <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                                </td>-->
                                <td><?php echo $i++;?></td>
                                <td><?php echo "SL".leftpad($row['id'],6);?></td>
                                <td><?php echo $row['uname'];?></td>
                                <td><?php echo $row['first_name'];?></td>
                                <td><?php echo $row['last_name'];?></td>
                                
                                <td><?php echo "RM.".$row['amount'];?></td>
                                <?php  
                                    $total_amount += $row['amount']
                                ?>
                                <td><?php echo $row['pv'];?></td>
                                <td><?php echo $row['shipping_charge'];?></td>
                                <!-- <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td> -->
                                <td><?php 
                                     echo '<i class = "fa fa-check-circle" style="color: green;"></i> Paid';
                                    ?>
                                </td>
                                <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
                                <td>
                                    <a href="myinvoice?id=<?php echo $row['id'];?>" class="btn btn-info btn-xs" id="invoice" data-id="" />View Invoice
                                       
                                       <!-- <input type="button" class="btn btn-danger btn-xs DeleteOrder" data-id="<?php echo $row['id'];?>"  value="Delete"/>  -->
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td>Total :</td>
                            
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo "Rs.".$total_amount;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tfoot>
                    </table>
                </div>

            </div>
            </form>
            <!-- /panel content -->

        </div>
    </div>
</section>
<?php include("footer.php");?>
