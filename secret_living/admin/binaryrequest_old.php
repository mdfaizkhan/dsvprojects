<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>My Purchase Order</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>My Purchase Order</strong>
                </span>
            </div>
            <!-- panel content -->
            <!-- <form name="bulk_action_form" action="" method="post"/> -->
            <div class="panel-body ">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                      <tr>
                        <tr>
                            <!-- <th  class="">Plan ID</th> -->
                            <!-- <th  class="">Plan Name</th>
                            <th  class="">Plan Amount</th> -->
                            <th  class="">Full Name</th>
                          <!--   <th  class="">User ID</th> -->
                          <!--   <th  class=""> Purchase Amount</th> -->
                            <!--<th  class="">Capping</th>-->
                            <th  class="">Date</th>
                            <th  class="">Action</th>
                           
                            <!-- <th  class="">Action</th> -->
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT  * FROM user_id WHERE binary_activated >=0 ");
                    while($row = mysqli_fetch_assoc($sql))
                    {
// $userdetails=mysqli_fetch_assoc(mysqli_query($db,"SELECT UI.uname,UD.first_name,UD.last_name FROM user_id UI INNER JOIN user_detail UD ON UI.uid=UD.uid WHERE UI.uid = '".$row['uid']."'"));
                    ?>
                        <tr class="odd gradeX">
                            <!--<td align="center">
                                <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                            </td>-->
                           <!--  <td><?php echo $i++;?></td> -->
                        <!--     <td><?php echo $row['plan_name'];?></td>
                            <td><?php echo "Rs.".$row['plan_amount'];?></td> -->
                            <!-- <td><?php echo $row['first_name']."  ".$row['last_name'] ;?></td> -->
                            <td><?php echo $row['uname'];?></td>
                           <!--  <td><?php echo "Rs.".$row['ramount'];?></td> -->
                            <!--<td><?php //echo isset($row['capping']) && $row['capping']>0?AmountToPV($row['capping']):'Not Applicable';?></td>-->
                            <td><?php echo isset($row['binary_date']) && !empty($row['binary_date'])?date("d-m-Y",strtotime($row['binary_date'])):''; ?></td>



      <?php if($row['binary_activated'] == 0){ ?>                     
        <td>
            <button class="btn btn-success btn-xs confirmcancel"  data-userid="<?php echo $row['uid'];?>" value="accept">Accept</button>

            <button class="btn btn-danger btn-xs confirmcancel"  data-userid="<?php echo $row['uid'];?>" value="reject">Reject</button>
        </td>
    </tr>

         <?php }


else if($row['binary_activated']==1){
    echo "<td><span class='label label-success'>Accepted</span><td></tr>";
}else{
    echo "<td><span class='label label-danger'>Rejected</span><td></tr>";
}



          ?>              
                    <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>
            <!-- </form> -->
            <!-- /panel content -->

        </div>
    </div>
</section>
<?php include("footer.php");?>
