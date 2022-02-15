<?php include("header.php");

?>
<section id="middle">
    <header id="page-header">
        <h1>Waallet Balance Request</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Waallet Balance Request</strong>
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
                                <th  class="">Image</th>
                                <th  class="">Date</th>
                                <th  class="">Confirmation</th>
                                <th  class="">Confirmation Date</th>
                                <th  class="">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT t1.*,t2.uname FROM fbal_req t1 left join franchise t2 on t1.fid=t2.id order by t1.req_id ") or die(mysqli_error($db));
                        while($row = mysqli_fetch_assoc($sql))
                        {
                        ?>
                            <tr class="odd gradeX">
                               
                                <td><?php echo $i++;?></td>
                                
                                <td><?php echo $row['uname'];?></td>
                                <td><?php echo $row['amount'];?></td>
                                <?php  
                                    $total_amount += $row['amount']

                                ?>
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
                                <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
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
                                <td><?php echo isset($row['approve_date']) && !empty($row['approve_date'])?date("d-m-Y",strtotime($row['approve_date'])):''; ?></td>
                                <td>
                                    
                                <?php if($row['status'] == 0)
                                {
                                    ?>
                                        <input type="button" class="btn btn-success btn-xs FReqMarkAsPaid" data-id="<?php echo $row['req_id'];?>"  value="Confirm"/> 
                                        <input type="button" class="btn btn-danger btn-xs FRejectReq" data-id="<?php echo $row['req_id'];?>"  value="Reject"/>
                                    <?php } ?> 
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td>Total :</td>
                            <td><?php echo "Rs.".$total_amount;?></td>
                            <td></td>
                            <td></td>
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
<div id="pay-modal" class="modal fade bs-example-modal-md pay-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- header modal -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Add wallet</h4>
            </div>

            <!-- body modal -->
            <div class="modal-body">
                <form id="ManageBalReq" action="" method="post">
                    <div class="row ">
                        <div class="form-group">
                        <div class="col-md-12">
                                <label>Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        
                    </div>
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
                                <input type="hidden" name="type" value="ManageBalReq">
                                <input type="hidden" name="req_id" id="req_id" value="<?php echo isset($data1['id'])?isset($data1['id']):''; ?>">
                                <input type="submit"  data-form="ManageBalReq"  class="btn btn-info btn-md btn-submit formvalidate"  value="Save">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
                
            </div>

        </div>
    </div>
</div>
