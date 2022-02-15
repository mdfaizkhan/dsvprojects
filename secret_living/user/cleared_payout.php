<?php include("header.php");?>
    <section id="middle">
        <header id="page-header">
            <h1>Cleared Payout</h1>
        </header>

        <div id="content" class="padding-20">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="title elipsis">
                        <strong>Cleared Payout</strong> <!-- panel title -->
                    </span>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                            <thead>
                            <tr>
                                <th  class="">SR No</th>                               
                                <th  class="">User</th>
                                <th  class="">Direct Sponsor Bonus</th>
                                <th  class="">Unilevel Bonus</th>
                                <th  class="">Double Pairing Bonus</th>
                                <th  class="">Repurchase Double Pairing Bonus</th>
                                <th  class="">Total Payout<!-- [A+C+R+S] -->(T)</th>
                                <th  class="">Admin Charges [-5%](E)</th>
                                <th  class="">TAX(F)</th>
                                <th  class="">Deduction Charge[E+F] (D)</th>
                                <th  class="">Total (T-D)</th>
                                <th  class="">Payout Date</th>
                                <th  class="">Cleared Date</th>
                                <th  class="">Bank Detail</th>
                                <!-- <th  class="">Pan Card No</th> -->
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $i = 1;
                            $myquery = "SELECT p.*, t1.uname, t1.uid as ttid, t2.first_name, t2.last_name, t2.pan_no, t3.* FROM payout p LEFT JOIN user_id t1 on p.uid=t1.uid JOIN user_bank t3 on t1.uid =t3.uid JOIN user_detail t2 on t1.uid =t2.uid where p.cleared=1 and ((p.direct_sponsor_comm > 0) OR (p.level_comm > 0) OR (p.double_pairing_bonus > 0) OR (p.repurchase_double_pairing_bonus > 0)) and p.uid='$mlmid'";
                            $sql = mysqli_query($db,$myquery);
                            while($row = mysqli_fetch_assoc($sql))
                            {
                                $bank_detail='';
                                $e=0;
                                $g=0;
                                $ttid= $row['ttid'];
                                if(!empty($row['bank_name']) && !empty($row['acnumber']))
                                {
                                    $bank_detail=$row['bank_name'].", ".$row['branch_name']."(AC- ".$row['acnumber'].")"."(IFSC- ".$row['swiftcode'].")";
                                }
                                $s=$row['direct_sponsor_comm']+$row['level_comm']+$row['double_pairing_bonus']+$row['repurchase_double_pairing_bonus'];
                                $e = ($s*5/100);
                                $f = ($s*5/100);
                                
                            ?>
                                <tr class="odd gradeX">
                                    <td align="center">
                                        <?php echo $i++;?>
                                    </td>
                                    <td><?php echo $row['first_name']." ".$row['last_name']."(".$row['uname'].")";?></td>
                                    <td><?php echo $row['direct_sponsor_comm'];?></td>
                                    <td><?php echo $row['level_comm'];?></td>
                                    <td><?php echo $row['double_pairing_bonus'];?></td>
                                    <td><?php echo $row['repurchase_double_pairing_bonus'];?></td>
                                    <td><?php echo $s;?></td>
                                    <td><?php echo $e ;?></td>
                                    <td><?php echo $f ;?></td>
                                    <td><?php echo $d = $e+$f;?></td>
                                    <td><?php echo $sum = $s-$d;?></td>
                                    <td><?php echo date('d/m/Y',strtotime($row['date']));?></td>
                                    <td><?php echo date('d/m/Y',strtotime($row['cleared_date']));?></td>
                                    <td><?php echo $bank_detail;?></td>
                                </tr><!--#31708F-->
                                <?php
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
