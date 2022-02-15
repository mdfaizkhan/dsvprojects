<?php include("header.php");?>

<section id="middle">
    <header id="page-header">
        <h1> PIN Request</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>Filter</strong>
				</span>
            </div>
            
            <div class="panel-body ">
                <form name="TransferPinToUser" action="" method="post"/>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="fancy-form fancy-form-select">
                                <select class = "form-control select2" name = "sponser" id = "sponser">
                                    <option value = "" selected disabled>Select User</option>
                                    <?php
                                    $sql=mysqli_query($db,"SELECT t1.*,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid WHERE t1.uid != $mlmid and t1.uid!=1");
                                    while($row1 = mysqli_fetch_assoc($sql))
                                    {
                                        ?>
                                        <option value = "<?php echo $row1["uid"];?>"><?php 
                                        echo $row1["first_name"]." ".$row1["last_name"]." (".$row1["uname"].")";?></option>
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
                    <strong>Requested Pin</strong>
                    <button class="btn btn-success btn-xs pull-right ApprovePINReq"><i class = "fa fa-check"></i> Approve</button>
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                    <tr>
                        
                        <th  class="">SR No</th>
                        <td align="center"> <input type="checkbox" name="checkedall" id = "bump-offer" /></td>
                        <th  class="">User</th>
                        <th  class="">Sponsor</th>
                        <th  class="">Number Of PIN</th>
                        <th  class="">Package</th>
                        <th  class="">Requested Date</th>
                        <th  class="">Status</th>
                        <th  class="">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    if(isset($_POST['filter']))
                    {
                        $suid = $_POST["sponser"];
                        $sdate = date('Y-m-d',strtotime($_POST["sdate"]));
                        $edate = date('Y-m-d',strtotime($_POST["edate"]));
                        if(empty($suid) && empty($_POST["sdate"]))
                        {
                            $myquery = "SELECT t1.*,t2.plan_name,t2.plan_amount,t3.uname,t4.first_name,t4.last_name from reqpin t1  join plans t2 on t1.plan_id=t2.plan_id left join user_id t3 on t1.uid=t3.uid left join user_detail t4 on t1.uid=t4.uid order by date ";
                        }
                        elseif(!empty($suid) && !empty($_POST["sdate"]))
                        {
                            //Date(date) between '$sdate' and '$edate'
                            $myquery = "SELECT t1.*,t2.plan_name,t2.plan_amount,t3.uname,t4.first_name,t4.last_name from reqpin t1  join plans t2 on t1.plan_id=t2.plan_id left join user_id t3 on t1.uid=t3.uid left join user_detail t4 on t1.uid=t4.uid where t1.uid='$suid' and Date(t1.date) between '$sdate' and '$edate' order by date ";
                        }
                        elseif(!empty($suid))
                        {
                            $myquery = "SELECT t1.*,t2.plan_name,t2.plan_amount,t3.uname,t4.first_name,t4.last_name from reqpin t1  join plans t2 on t1.plan_id=t2.plan_id left join user_id t3 on t1.uid=t3.uid left join user_detail t4 on t1.uid=t4.uid where t1.uid='$suid' order by date ";
                        }
                        else
                        {
                            $myquery = "SELECT t1.*,t2.plan_name,t2.plan_amount,t3.uname,t4.first_name,t4.last_name from reqpin t1  join plans t2 on t1.plan_id=t2.plan_id left join user_id t3 on t1.uid=t3.uid left join user_detail t4 on t1.uid=t4.uid where Date(t1.date) between '$sdate' and '$edate' order by date ";
                        }
                    }
                    else
                    {
                        $myquery = "SELECT t1.*,t2.plan_name,t2.plan_amount,t3.uname,t4.first_name,t4.last_name from reqpin t1  join plans t2 on t1.plan_id=t2.plan_id left join user_id t3 on t1.uid=t3.uid left join user_detail t4 on t1.uid=t4.uid order by date ";
                        //echo $myquery;
                    }
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
                            <td align="center"> 
                                <?php if($row['status'] == 1)
                                {
                                    echo '<i class = "fa fa-check-circle" style="color: green;"></i>';
                                }
                                else if($row['status'] == 2)
                                {
                                    echo '<i class = "fa fa-times-circle" style="color: red;"></i>';
                                }
                                else
                                {
                                ?><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row['id'];?>"/>
                                <?php } ?>
                                </td>
                            <td><?php echo $row['first_name']." ".$row['last_name']." (".$row['uname'].")";?></td>
                            <td>
                                <?php 
                                    $uid=$row['uid']; 
                                    $r3 = mysqli_fetch_assoc(mysqli_query($db,"select t3.uname as suname from  pairing t2 left join user_id t3 on t2.sponsor_id=t3.uid where t2.uid = $uid"));
                                        echo $r3['suname'];
                                ?>
                            </td>
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
                                <a href="javascript:void(0);" title="Reject Request" class="RejectRequest btn btn-danger btn-xs" data-id="<?php echo $row['id'];?>"><i class="fa fa-times"></i> Reject</a>
                            </td>
                            
                        </tr><!--#31708F-->
                    <?php $i++; } ?>
                    </tbody>
                </table>
                </div>
            </div>
            </form>
            
        </div>
    </div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>

