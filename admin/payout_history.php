<?php include("header.php");?>


    <section id="middle">
        <header id="page-header">
            <h1>Payout History</h1>
        </header>

        <div id="content" class="padding-20">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="title elipsis">
                        <strong>Payout History</strong> <!-- panel title -->
                    </span>
                </div>
                <div class="panel-body">
                            <div class="row">
                                <?php
                                $query = "SELECT 
                                        DISTINCT payout.uid,
                                        user_id.* 
                                        FROM payout 
                                        LEFT JOIN user_id on payout.uid=user_id.uid 
                                        INNER JOIN user_detail ON user_id.uid=user_detail.uid";
                                $result = mysqli_query($db,$query);
                                ?>
                                 <div class="col-md-6">
                                    <div class="fancy-form fancy-form-select">
                                        <select class="form-control select2" name="username" id="user_id" >
                                            <option value="">Select</option>
                                            <?php
                                            if(mysqli_num_rows($result)>0){
                                                while($Resultrow=mysqli_fetch_assoc($result)){
                                                    ?>

                                                <option value="<?php echo $Resultrow['uid'] ;?>">
                                                    <?php echo $Resultrow['uname']?>
                                                </option>

                                                    <?php

                                                }
                                            }
                                            ?>
                                        </select>
                                           
                                    </div>

                                </div>
                                
                                  <div class="col-md-6">
                                    <input type="date" class="form-control" id="payoutdate"/>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                        <tr>
                            <th align="center"> Sr.no</th>
                            <th  class="">User Name</th>
                            <th  class="">Full Name</th>
                            <th  class="">User ID</th>
                            <th  class="">Amount</th>
                            <th  class="">Date</th>
                       
                        </tr>
                        </thead>

                        <tbody class="showdata">
                        <?php
                        $i = 1;
                        $myquery = "SELECT * FROM payout LEFT JOIN user_id on payout.uid=user_id.uid INNER JOIN user_detail ON user_id.uid=user_detail.uid";
                        //echo $myquery;
						//((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0)
                        $sql = mysqli_query($db,$myquery);
                        while($row = mysqli_fetch_assoc($sql))
                        {

                            if($row['amount']>0){
                               
                              
                            ?>
                            <tr class="odd gradeX">
                                <td align="center">
                                    <?php echo $i++;?>
                                </td>
                                <td><?php echo $row['uname'] ;?></td>
                                <td><?php echo $row['first_name']." ".$row['last_name'] ;?></td>
                                <td><?php echo $row['uid'] ;?></td>
                                <td><?php echo $row['amount'];?></td>
                                <td><?php echo $row['date'];?></td>
 
             
                            </tr><!--#31708F-->
                            <?php
                        }
                    }
                        ?>
                        </tbody>
                    </table>

                </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /MIDDLE -->

<?php include("footer.php");?>

<?php
if(isset($success) || isset($error))
{
    if( $success != "" ){ ?>
        <script>

            _toastr("<?php echo $success; ?>","top-right","success",false);

        </script>

    <?php }
    else if($error != "")
    { ?>
        <script>
            _toastr("<?php echo $error; ?>","top-right","error",false);
        </script>

    <?php }
}
?>


<script>
    
$(document).ready(function(){
    $("#user_id").change(function(){
        var userid=$(this).val();
        var payoutdate=$("#payoutdate").val();

        $.ajax({
            type :"POST",
            url  : "payoutdetails",
            data : {userid : userid,
                    payoutdate : payoutdate },

            success : function(data){
                $(".showdata").html(data);
            },
            // error : function(data){

            // }

        });
    });
    
       $("#payoutdate").change(function(){
        var payoutdate=$(this).val();
        var userid=$("#user_id").val();

        $.ajax({
            type :"POST",
            url  : "payoutdetails",
            data : {payoutdate : payoutdate,
                    userid : userid},

            success : function(data){
                $(".showdata").html(data);
            },
            // error : function(data){

            // }

        });
    });
});

</script>