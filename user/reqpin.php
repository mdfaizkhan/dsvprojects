<?php include("header.php");?>

<section id="middle">
    <header id="page-header">
        <h1>Request Pin</h1>
    </header>
    
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Requested Pin</strong>
                    <button class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class = "fa fa-plus"></i> Add</button>
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
                        <th  class="">SR No</th>
                        <th  class="">Number Of PIN</th>
                        <th  class="">Plan</th>
                        <th  class="">Requested Date</th>
                        <th  class="">Status</th>
                        <th  class="">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $myquery = "SELECT t1.*,t2.plan_name,t2.plan_amount from reqpin t1 left join plans t2 on t1.plan_id=t2.plan_id where t1.uid=$mlmid order by date ";
                    //echo $myquery;
                    $sql = mysqli_query($db,$myquery);
                    while($row = mysqli_fetch_assoc($sql))
                    {
                        $style='';
                        if($row['status'] == 1){ 
                            $style= 'style="background-color:rgba(94, 199, 94, 0.59);"';
                        }
                        else if($row['status'] == 2){
                            $style= 'style="background-color:rgba(236, 121, 40, 0.33);"';
                        }
                        ?>
                        <tr class="odd gradeX" <?php echo $style; ?> >
                            
                            <td><?php echo $i;?></td>
                            <td><?php echo $row['no_of_pin'];?></td>
                            <td><?php echo $row['plan_name']."(".$row['plan_amount'].")";?></td>
                            
                            <td><?php echo date('d/m/Y',strtotime($row['date']));?></td>
                            <td><?php if($row['status'] == 1)
                                {
                                    echo '<i class = "fa fa-check-circle" style="color: green;"></i>';
                                }
                                else if($row['status'] == 2)
                                {
                                    echo '<i class = "fa fa-times-circle" style="color: red;"></i>';
                                }
                                else
                                {
                                    echo 'Pending';
                                }

                                ?>
                            </td>
                            <td>                               
                                <a href="javascript:void(0);" title="Delete Request" class="deleteRequest btn btn-danger btn-xs" data-id="<?php echo $row['id'];?>"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                            
                        </tr><!--#31708F-->
                        <?php $i++;
                    }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
            </form>
            
        </div>
    </div>
</section>
<!-- /MIDDLE -->
<div id="myModal" class="modal fade"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Request Pin</h4>
            </div>

            <form id="ManageRequestPin" action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label>No. of Transaction Pin*</label>
                                <div class="fancy-form"><!-- input -->
                                    <i class="fa fa-barcode"></i>
                                    <input type="number"  placeholder = "Enter No. of Transaction Pin" class = "form-control" name = "no_of_pin" id = "no_of_pin" title = "Enter No. of Transaction Pin!"  required>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label>Plan*</label>
                                <div class="fancy-form"><!-- input -->
                                    <select class = "form-control" name = "plan_id" id = "plan_id" required>
                                        <option value = "" selected disabled>Select Plan Amount</option>
                                        <?php
                                        $sql=mysqli_query($db,"SELECT * FROM `plans`");
                                        while($row = mysqli_fetch_assoc($sql))
                                        {
                                            ?>
                                            <option value = "<?php echo $row["plan_id"];?>"><?php echo $row["plan_name"] ." (".$row["plan_amount"].")";?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type ="hidden" name = "type" value="ManageRequestPin">
                    <input type="submit"  id="formvalidate" data-form="ManageRequestPin"  class="btn btn-info btn-md btn-submit"  value="Request PIN">
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>
<?php include("footer.php");?>

