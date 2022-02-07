<?php include("header.php");?>

    <section id="middle">
        <header id="page-header">
            <h1>Pending Previous Payout</h1>
        </header>

        <div id="content" class="padding-20">


            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="title elipsis">
                        <strong>Pending Previous Payout</strong> <!-- panel title -->
                        <!-- <a href="exportexcel" class="btn btn-success btn-xs pull-right"><i class = "fa fa-file"></i> Export Bulk</a>-->
                        <!-- <a href="neft" class="btn btn-success btn-xs pull-right"><i class = "fa fa-file"></i> Export NEFT</a> -->
                    </span>
                </div>
                <div class="panel-body ">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                            <thead>
                            <tr>
                                <th  class="">SR No</th>
                                <!-- <td align="center"> <input type="checkbox" name="checkedall" id = "bump-offer" /></td> -->
                                <th  class="">Sponsor</th>
                                <th  class="">GTB Payout</th>
                                <th  class="">Direct Sponsor Bonus</th>
                                <th  class="">Executive Bonus</th>
                                <th  class="">Director Bonus</th>
                                <th  class="">Silver Director Bonus</th>
                                <th  class="">Gold Director Bonus</th>
                                <th  class="">Diamond Director Bonus</th>
                                <th  class="">Platinum Director Bonus</th>
                                <th  class="">Crown Director Bonus</th>
                                <th  class="">Award & Reward</th>
                                
                                <th  class="">Total Payout<!-- [A+C+R+S] -->(T)</th>
                                <th  class="">Admin Charges [-5%](E)</th>
                                <th  class="">TDS [-5%](F)</th>
                                <th  class="">Deduction Charge[E+F] (D)</th>
                                <th  class="">Total (T-D)</th>
                                <th  class="">Bank Detail</th>
                                <!-- <th  class="">Pan Card No</th> -->
                                
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
                            (SELECT IFNULL(SUM(`gtb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as a,
                            (SELECT IFNULL(SUM(`dsb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as b,

                            (SELECT IFNULL(SUM(`eb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as c,
                            (SELECT IFNULL(SUM(`db`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as d,
                            (SELECT IFNULL(SUM(`sdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as e,
                            (SELECT IFNULL(SUM(`gdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as f,
                            (SELECT IFNULL(SUM(`ddb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as g,
                            (SELECT IFNULL(SUM(`reward`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as h,
                            
                            (SELECT IFNULL(SUM(`pdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as i,
                            (SELECT IFNULL(SUM(`cdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) as j

                            FROM user_id t1 
                            LEFT JOIN user_bank t3 ON t1.uid =t3.uid 
                            LEFT JOIN user_detail t2 ON t1.uid =t2.uid AND t1.uid!=1 
                            where t1.uid!=1 and (
                                (SELECT IFNULL(SUM(`gtb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0 OR
                                (SELECT IFNULL(SUM(`dsb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0 OR
                                (SELECT IFNULL(SUM(`eb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0 OR
                                (SELECT IFNULL(SUM(`db`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0 OR
                                (SELECT IFNULL(SUM(`sdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0 OR
                                (SELECT IFNULL(SUM(`gdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0 OR
                                (SELECT IFNULL(SUM(`ddb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0  OR
                                (SELECT IFNULL(SUM(`pdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0  OR
                                (SELECT IFNULL(SUM(`cdb`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0  OR
                                (SELECT IFNULL(SUM(`reward`),0) FROM `payout_history` WHERE `cleared` = 2 and  `uid` = t1.uid) >0 
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
                                $s=$row['a']+$row['b']+$row['c']+$row['d']+$row['e']+$row['f']+$row['g']+$row['h'];
                                $e = ($s*5/100);
                                $f = (($s-$e)*5/100);
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i++;?></td>
                                    <!-- <td align="center">
                                        <?php //echo $i++;?>
                                        <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php //echo $row['ttid'];?>"/>
                                    </td> -->
                                    <td><?php echo $row['first_name']." ".$row['last_name']."(".$row['uname'].")";?></td>
                                                                       
                                    <td><?php echo $row['a'];?></td>
                                    <td><?php echo $row['b'];?></td>
                                    <td><?php echo $row['c'];?></td>
                                    <td><?php echo $row['d'];?></td>
                                    <td><?php echo $row['e'];?></td>
                                    <td><?php echo $row['f'];?></td>
                                    <td><?php echo $row['g'];?></td>
                                    <td><?php echo $row['i'];?></td>
                                    <td><?php echo $row['j'];?></td>
                                    <td><?php echo $row['h'];?></td>
                                    <td><?php echo number_format((float)$s, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$e, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$f, 2, '.', '');?></td>
                                    <td><?php $d = $e+$f+$g;
                                        echo number_format((float)$d, 2, '.', '');
                                    ?></td>
                                    <td><?php echo $sum = number_format((float)$s-$d, 2, '.', '');?></td>
                                    <td><?php echo $bank_detail;?></td>
                                    
                                    
                                </tr><!--#31708F-->
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    
                        <input type="button" class="btn btn-alert AllPayoutPaid" id="allpayout_historypaid" value="Mark All As Paid"/>
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
                            //and ((SELECT IFNULL(SUM(`amount`),0) FROM `payout_history` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 )
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
