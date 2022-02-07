<?php include("header.php");?>

    <section id="middle">
        <header id="page-header">
            <h1>Generated Payout</h1>
        </header>

        <div id="content" class="padding-20">


            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="title elipsis">
                        <strong>Generated Payout</strong> <!-- panel title -->
                         <a href="neft" class="btn btn-success btn-xs pull-right" id="exporttable"><i class = "fa fa-file"></i> Export NEFT</a>
                        <!--<a href="javascript:void(0)" class="btn btn-success btn-xs pull-right" id="exporttable"><i class = "fa fa-file"></i> Export NEFT</a>-->
                    </span>
                </div>
                <div class="panel-body ">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                            <thead>
                            <tr>
                                <th  class="">SR No</th>                               
                                <th  class="">User</th>
                                <th  class="">Matching Payout</th>
                                <th  class="">Total Payout<!-- [A+C+R+S] -->(T)</th>
                                <th  class="">Admin Charges [-5%](E)</th>
                                <th  class="">TDS(F)</th>
                                <th  class="">Deduction Charge[E+F] (D)</th>
                                <th  class="">Total (T-D)</th>
                                <th  class="">Bank Detail</th>
                                <th  class="">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $i = 1;
                            
                            $myquery = "SELECT 
                            t1.uname,t1.uid as ttid,
                            t2.first_name,
                            t2.last_name,
                            t2.pan_no,
                            t3.*,
                            (SELECT IFNULL(SUM(`gtb`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a
                           
                            FROM user_id t1 
                            LEFT JOIN user_bank t3 ON t1.uid =t3.uid 
                            LEFT JOIN user_detail t2 ON t1.uid =t2.uid AND t1.uid!=1 
                            where t1.uid!=1 and (
                                (SELECT IFNULL(SUM(`gtb`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0
                            )";
                            $sql = mysqli_query($db,$myquery) or die(mysqli_error($db));
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
                                $s=$row['a'];
                                $e = ($s*5/100);
                                $amount_tds=$s-$e;
                                if($amount_tds<300000){
                                    $f = (($s-$e)*5/100);
                                }
                                elseif($amount_tds>=300000 && $amount_tds<=500000){
                                    $f = (($s-$e)*12/100);
                                }
                                elseif($amount_tds>=500000 && $amount_tds<=1000000){
                                    $f = (($s-$e)*22/100);                                  
                                }                               
                                elseif($amount_tds>=1000000){
                                    $f = (($s-$e)*32/100);                                  
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $row['first_name']." ".$row['last_name']."(".$row['uname'].")";?></td>                
                                    <td><?php echo $row['a'];?></td>
                                    <td><?php echo number_format((float)$s, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$e, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$f, 2, '.', '');?></td>
                                    <td><?php $d = $e+$f+$g;
                                        echo number_format((float)$d, 2, '.', '');
                                    ?></td>
                                    <td><?php echo $sum = number_format((float)$s-$d, 2, '.', '');?></td>
                                    <td><?php echo $bank_detail;?></td>
                                    <td>
                                        <input type="button" class="btn btn-success btn-xs PayoutMarkAsPaid" id="makepayment" data-id="<?php echo $row['ttid'];?>"  value="Mark As Paid"/>
                                    </td>
                                </tr><!--#31708F-->
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    
                        <input type="button" class="btn btn-alert AllPayoutPaid" id="allpayoutpaid" value="Mark All As Paid"/>
                   </div>
                </div>

            </div>
            
        </div>

        <div id="content1" class="padding-20">


            <!-- <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="title elipsis">
                        <strong>Due Payout</strong> 
                    </span>
                </div>
                <div class="panel-body ">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                            <thead>
                            <tr>
                                <th  class="">SR No</th>
                                <th  class="">Sponsor</th>
                                <th  class="">Payout</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $i = 1;
                            
                            $myquery = "SELECT  
                                        t1.uid as uid1,t1.uname,
                                        t2.*,
                                        t3.first_name,
                                        t3.last_name 
                                        FROM user_id t1 
                                        JOIN direct_payment t2 ON t1.uid=t2.uid 
                                        JOIN user_detail t3 on t1.uid=t3.uid 
                                        WHERE 
                                        t1.uid !='1' AND 
                                        (
                                            SELECT 
                                            IFNULL(SUM(`due_amount`),0) 
                                            FROM 
                                            `direct_payment` 
                                            WHERE `uid` = t1.uid
                                        ) >0";
                            //echo $myquery;
                            //and ((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 )
                            $sql = mysqli_query($db,$myquery);
                            while($row = mysqli_fetch_assoc($sql))
                            {
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $row['first_name']." ".$row['last_name']."(".$row['uname'].")";?></td>
                                    
                                    <td><?php echo round($row['due_amount'],2);?></td>
                                    
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    
                   </div>
                </div>

            </div> -->
            
        </div>

    </section>
    <!-- /MIDDLE -->
 

<?php include("footer.php");?>
