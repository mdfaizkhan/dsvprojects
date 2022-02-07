<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Waalet Balance</h1>
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
                        $sql=mysqli_query($db,"SELECT t1.*,t2.uname,t3.first_name,t3.last_name FROM product_purchase t1 left join user_id t2 on t1.uid=t2.uid left join user_detail t3 on t1.uid=t3.uid where t1.uid='$mlmid' order by t1.id ") or die(mysqli_error($db));
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
                                <td><?php if($row['cleared'] == 2)
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
                                        //echo '<i class = "fa fa-check-circle" style="color: green;"></i> Confirmed';
                                        echo '<a href="receipt?id=<?php echo $row[id];?>" class="btn btn-info btn-xs" id="invoice" data-id="" />View Receipt</a>';
                                    }
                                    else
                                    { ?>
                                       <br>
                                       <a class="btn btn-xs btn-success paymentDetail pull-right" href="javascript:void(0);" title="Add Payment Detail"  data-id="<?php echo isset($row['id'])?$row['id']:''; ?>" data-mid="pay-modal"><i class="fa fa-edit white"> Add Payment Detail</i></a>
                                    <?php } ?>
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
<div id="pay-modal" class="modal fade bs-example-modal-md pay-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- header modal -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Payment Detail</h4>
            </div>

            <!-- body modal -->
            <div class="modal-body">
                <form id="ManagePaymentDetails" action="" method="post">
                    
                    <div class="row ">
                        <div class="form-group">
                        <div class="col-md-12">
                                <label>Txn Id</label>
                                <input type="text" name="txnid" id="txnid" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group">
                        <div class="col-md-12">
                                <label>Note</label>
                                <textarea row="10" name="note" id="note" class="form-control"></textarea>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group">
                        <div class="col-md-12">
                            <label>Files</label>
                            <div class="fancy-file-upload fancy-file-primary">

                                <i class="fa fa-upload"></i>
                                <input type="file" class="form-control"  name="image" onchange="jQuery(this).next('input').val(this.value);" >
                                <input type="text" class="form-control" placeholder="No file selected" readonly=""  >
                                <span class="button">Choose File</span>
                                
                                
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row clearfix">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 text-center">
                                <input type="hidden" name="type" value="ManagePaymentDetails">
                                <input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo isset($data1['id'])?isset($data1['id']):''; ?>">
                                <input type="submit"  data-form="ManagePaymentDetails"  class="btn btn-info btn-md btn-submit formvalidate"  value="Save">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
                
            </div>

        </div>
    </div>
</div>
