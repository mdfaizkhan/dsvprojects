<?php include("header.php");
if(!isset($_POST['filter']))
{
if(isset($_SESSION['views'])){
     $_SESSION['views'] = $_SESSION['views']+ 1;
     unset($_SESSION['views'] );
     echo "<script>window.location.href='index';</script>";
  }else{
     $_SESSION['views'] = 1;
  }
}
?>


<section id="middle">
    <header id="page-header">
        <h1>Transfer Pin</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>Filter</strong> <!-- panel title -->
				</span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <form name="bulk_action" action="" method="post"/>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="fancy-form fancy-form-select">
                                <select class = "form-control select2" name = "user" >
                                    <option value = "" selected disabled>Select User</option>
                                    <?php
                                    
                                    $sql=mysqli_query($db,"SELECT t1.*,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid != $mlmid and t1.uid!=1");
                                    while($row1 = mysqli_fetch_assoc($sql))
                                    {
                                        ?>
                                        <option value = "<?php echo $row1["uid"];?>"><?php echo $row1["first_name"]." ".$row1["last_name"]." (".$row1["uname"].")";?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control datepicker" name = "sdate" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" placeholder = "Start Date">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control datepicker" name = "edate" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" placeholder = "End Date">
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-info" name="filter" value="Filter"/>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Transfer Pin</strong> <!-- panel title -->
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
                            <td align="center"> <!-- <input type="checkbox" name="checkedall" id = "bump-offer" onClick = "check();"/> --></td>
                            <th  class="">PIN</th>
                            <th  class="">Package Amount</th>
                            <th  class="">Alloted_By</th>
                            <th  class="">Alloted_Sponser</th>
                            <th  class="">Transfer Date</th>
                            <th  class="">Used</th>
                            <th  class="">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        if(isset($_POST['filter']))
                        {
                            $suid = $_POST["user"];
                            $sdate = date('Y-m-d',strtotime($_POST["sdate"]));
                            $edate = date('Y-m-d',strtotime($_POST["edate"]));
                            if(empty($suid) && empty($_POST["sdate"]))
                            {
                                $myquery = "SELECT t1.*,t2.pin_id,t2.pin_code,t2.status,t3.plan_id,t3.plan_amount FROM transferpin t1 join transpin t2 on t1.pin_id = t2.pin_id join plans t3 on t2.plan_id = t3.plan_id order by date ";
                            }
                            elseif(!empty($suid) && !empty($_POST["sdate"]))
                            {
                                //Date(date) between '$sdate' and '$edate'
                                $myquery = "SELECT t1.*,t2.pin_id,t2.pin_code,t2.status,t3.plan_id,t3.plan_amount FROM transferpin t1 join transpin t2 on t1.pin_id = t2.pin_id join plans t3 on t2.plan_id = t3.plan_id and t1.allot_to = '$suid' and Date(date) between '$sdate' and '$edate' order by date ";
                            }
                            elseif(!empty($suid))
                            {
                                $myquery = "SELECT t1.*,t2.pin_id,t2.pin_code,t2.status,t3.plan_id,t3.plan_amount FROM transferpin t1 join transpin t2 on t1.pin_id = t2.pin_id join plans t3 on t2.plan_id = t3.plan_id and t1.allot_to = '$suid' order by date ";
                            }
                            else
                            {
                                $myquery = "SELECT t1.*,t2.pin_id,t2.pin_code,t2.status,t3.plan_id,t3.plan_amount FROM transferpin t1 join transpin t2 on t1.pin_id = t2.pin_id join plans t3 on t2.plan_id = t3.plan_id and Date(date) between '$sdate' and '$edate' order by date ";
                            }
                        }
                        else
                        {
                            $myquery = "SELECT t1.*,t2.pin_id,t2.pin_code,t2.status,t3.plan_id,t3.plan_amount FROM transferpin t1 join transpin t2 on t1.pin_id = t2.pin_id join plans t3 on t2.plan_id = t3.plan_id order by date ";
                        }
                        //echo $myquery;
                        $sql = mysqli_query($db,$myquery);
                        while($row = mysqli_fetch_assoc($sql))
                        {
                            ?>
                            <tr class="odd gradeX" <?php if($row['status'] == 1) echo 'style="background-color:rgba(94, 199, 94, 0.59);"'?>>
                                <td align="center">
                                    <?php /*if($row['status'] == 1)
                                    {
                                        echo "X";
                                    }
                                    else
                                    {*/
                                        echo $i++;
                                        ?>
                                        <!-- <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php //echo $row['pin_id']; ?>"/> -->
                                    <?php //}?>
                                </td>
                                <td><?php echo $row['pin_code'];?></td>
                                <td><?php echo "Rs.".$row['plan_amount'];?></td>
                                <td><?php
                                    if(!empty($row["allot_by"]))
                                    {
                                        $uid = $row["allot_by"];
                                        $r2 = mysqli_fetch_assoc(mysqli_query($db,"select t1.uid,t1.uname,t3.uname as suname from user_id t1 left join pairing t2 on t1.uid=t2.uid left join user_id t3 on t2.sponsor_id=t3.uid where t1.uid = $uid"));
                                        echo $r2['uname']." (SPonsor : ".$r2['suname'].")";
                                    }
                                    ?></td>
                                <td><?php
                                    if($row["allot_to"] !=0)
                                    {
                                        $auid = $row["allot_to"];
                                        
                                        $r3 = mysqli_fetch_assoc(mysqli_query($db,"select t1.uid,t1.uname,t3.uname as suname from user_id t1 left join pairing t2 on t1.uid=t2.uid left join user_id t3 on t2.sponsor_id=t3.uid where t1.uid = $auid"));
                                        echo $r3['uname']." (SPonsor : ".$r3['suname'].")";
                                    }
                                    ?></td>

                                <td><?php echo date('d/m/Y',strtotime($row['date']));?></td>
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
                    <!-- <button type="button" class="btn btn-danger RemoveSelectedTransPin" >Remove</button> -->
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
                <h4 class="modal-title" id="myModalLabel">Transfer Pin</h4>
            </div>

            <form id="ManageTransPin" action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label>Sponsor*</label>
                                <div class="fancy-form fancy-form-select">
                                    <select class = "form-control select2" name = "sponser" id="sponser" style="width:100%;" required>
                                        <option value = "" selected disabled>Select Sponsor</option>
                                        <?php

                                        $sql=mysqli_query($db,"SELECT t1.*,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid != $mlmid and t1.uid!=1");
                                        while($row = mysqli_fetch_assoc($sql))
                                        {
                                            ?>
                                            <option value = "<?php echo $row["uid"];?>"><?php echo $row["first_name"]." ".$row["last_name"]." (".$row["uname"].")";?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
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
                    <input type="hidden" id="user_id" value="<?php echo $mlmid; ?> ">
                    <input type ="hidden" name = "type" value="ManageTransPin">
                    <input type="submit"  id="formvalidate" data-form="ManageTransPin"  class="btn btn-info btn-md btn-submit"  value="Add PIN">
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>
<?php include("footer.php");?>

