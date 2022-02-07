<?php include("header.php");
if(isset($_GET['cnt']))
{
	$cnt=$_GET['cnt'];
}
?>
<section id="middle">
    <header id="page-header">
        <h1>Referal Users</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Referal Users [Count : <?php echo $cnt; ?>]</strong>
                </span>
            </div>
            <!-- panel content -->
            <!-- <form name="bulk_action_form" action="" method="post"/> -->
            <div class="panel-body ">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                        <tr>
                            <th  class="">SR NO</th>
                            <th  class="">Full Name</th>
                            <th  class="">Username</th>
                            <th  class="">Capping</th>
                            <th  class="">Amount</th>
                            <th  class="">Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT id,capping FROM referel_bonus_detail where mem_count='$cnt'"));
                    
                    $sql=mysqli_query($db,"SELECT t1.uid as tuid,t3.first_name,t3.last_name,t2.uname,t4.* FROM `refpayout` t1 left join `ref_bonus` t4 on t1.uid=t4.uid left join user_id t2 on t1.uid=t2.uid left join user_detail t3 on t1.uid=t3.uid where t1.status=1 and t1.total_count=$cnt");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                        $col_name="amount".$r1['id'];
                        $amount=isset($row[$col_name]) && !empty($row[$col_name])?$row[$col_name]:0;
                    ?>
                        <tr class="odd gradeX">
                        	<td><?php echo $i++; ?></td>
                            <td><?php echo $row['first_name']."  ".$row['last_name'] ;?>
                            <td><?php echo $row['uname'];?>
                            <td><?php echo $r1['capping'];?>
                            <td><?php echo $amount;?>
                            <td><?php echo $r1['capping']-$amount;?>
                   
                        </tr>
                     <?php } ?>      
                    </tbody>
                </table>
            </div>
            <!-- </form> -->
            <!-- /panel content -->
        </div>
    </div>
</section>
<?php include("footer.php");?>
