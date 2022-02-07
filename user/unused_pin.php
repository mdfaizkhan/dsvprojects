<?php include("header.php");?>

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
                    <strong>Unused Transaction Pin</strong> <!-- panel title -->
                   
                </span>
            </div>
            <!-- panel content -->
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                        <tr>
                        <tr>   
                            <th  class="">SR NO</th>                     
                            <th  class="">PIN</th>                        
                            <th  class="">Plan Amount</th>
                            <th  class="">Used</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql1="SELECT t1.*,t3.plan_id,t3.plan_amount FROM transpin t1 join plans t3 on t1.plan_id = t3.plan_id where status='0' AND t1.allot_uid='$mlmid' order by status ";
                        $sql=mysqli_query($db,$sql1);
                        while($row = mysqli_fetch_assoc($sql))
                        {
                            ?>
                            <tr class="odd gradeX" <?php if($row['status'] == 1) echo 'style="background-color:rgba(94, 199, 94, 0.59);"'?>>
                                
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['pin_code'];?></td>
                                <td><?php echo "Rs.".$row['plan_amount'];?></td>
                                <td><?php if($row['status'] == 1)
                                        echo '<i class = "fa fa-check-circle" style="color: green;"></i>';
                                    else
                                        echo '<i class = "fa fa-times-circle" style="color: red;"></i>';

                                    ?></td>
                                
                            </tr><!--#31708F-->
                            <?php $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /panel content -->

        </div>
    </div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>

