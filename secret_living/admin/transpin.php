<?php include("header.php");
if(isset($_SESSION['views'])){
     $_SESSION['views'] = $_SESSION['views']+ 1;
     unset($_SESSION['views'] );
     echo "<script>window.location.href='index';</script>";
  }else{
     $_SESSION['views'] = 1;
  }
?>


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
								<strong>Transaction Pin</strong> <!-- panel title -->
								<button class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class = "fa fa-plus"></i> Add</button>
							</span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                         <tr>
                            <td align="center"> <input type="checkbox" name="checkedall" id = "bump-offer"/></td>
                            <th  class="">PIN</th>
                            <th  class="">Package Amount</th>
                            <th  class="">User</th>
                            <th  class="">Sponsor</th>
                            <th  class="">Used</th>
                            <th  class="">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        //echo "SELECT t1.*,t3.plan_id,t3.plan_amount FROM transpin t1 join plans t3 on t1.plan_id = t3.plan_id order by status desc";
                        $sql=mysqli_query($db,"SELECT t1.*,t3.plan_id,t3.plan_amount FROM transpin t1 join plans t3 on t1.plan_id = t3.plan_id order by status ");
                        while($row = mysqli_fetch_assoc($sql))
                        {
                            ?>
                            <tr class="odd gradeX" <?php if($row['status'] == 1) echo 'style="background-color:rgba(94, 199, 94, 0.59);"'?>>
                                <td align="center">
                                    <?php if($row['status'] == 1)
                                    {
                                        echo "X";
                                    }
                                    else
                                    {?>
                                        <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row['pin_id']; ?>"/>
                                    <?php }?>
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
                                <td  class="">
                                    <?php if($row['status'] == 1)
                                    {
                                        echo "--";
                                    }
                                    else
                                    {?>
                                        <a href="javascript:void(0);" title="Delete <?php echo "PIN ". $row['pin_code'];?>" class="deletepin btn btn-danger btn-xs" data-id="<?php echo $row['pin_id'];?>"><i class="fa fa-trash"></i> Delete</a>
                                    <?php }?>
                                </td>
                            </tr><!--#31708F-->
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-danger RemoveSelectedPin" >Remove</button>
                </div>
            </div>
            <!-- /panel content -->

        </div>
    </div>
</section>
<!-- /MIDDLE -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Transaction PIN</h4>
            </div>

            <form id="ManagePin" action="" method="post" enctype="multipart/form-data">
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
                                <label>Package*</label>
                                <div class="fancy-form"><!-- input -->
                                    <select class = "form-control" name = "plan_id" id = "plan_id" required>
                                        <option value = "" selected disabled>Select Package Amount</option>
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
                    <input type ="hidden" name = "type" value="ManagePin">
                    <input type="submit"  id="formvalidate" data-form="ManagePin"  class="btn btn-info btn-md btn-submit"  value="Add PIN">
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>
<?php include("footer.php");?>

