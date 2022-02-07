<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>My Invoice</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>My Invoicer</strong>
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
                            <th  class="">User</th>
                            <th  class="">Product Name</th>
                            <th  class="">MRP</th>
                            <th  class="">BV</th>
                            <th  class="">qty</th>
                            <th  class="">Date</th>

                            <th  class="">Payment Date</th>
                            <th  class="">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT t1.*,t2.*,t3.uname FROM product_purchase t1 join products t2 on t1.product_id=t2.product_id left join user_id t3 on t1.uid=t3.uid order by t1.id ");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                    ?>
                        <tr class="odd gradeX">
                            <!--<td align="center">
                                <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                            </td>-->
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['uname']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo "Rs.".$row['mrp']; ?></td>
                            <td><?php echo $row['bv']; ?></td>
                            <td><?php echo $row['qty']; ?></td>
                            <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
                            
                            <td><?php echo isset($row['cleared_date']) && !empty($row['cleared_date'])?date("d-m-Y",strtotime($row['cleared_date'])):''; ?></td>
                            <td>
                                
                                <?php if($row['cleared'] == 1)
                                {
                                    echo '<i class = "fa fa-check-circle" style="color: green;"></i> Paid';
                                }
                                else
                                { ?>
                                   <input type="button" class="btn btn-success btn-xs OrdersMarkAsPaid" id="OrdersMarkAsPaid" data-id="<?php echo $row['id'];?>"  value="Mark As Paid"/> 
                                <?php } ?>
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
