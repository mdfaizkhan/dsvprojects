<?php include("header.php");?>

    <section id="middle">
        <header id="page-header">
            <h1>Generated Payout</h1>
        </header>

        <div id="content" class="padding-20">


            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="title elipsis">
                        <strong>Pending Payout</strong> <!-- panel title -->
                        <!-- <a href="exportexcel" class="btn btn-success btn-xs pull-right"><i class = "fa fa-file"></i> Export Bulk</a>
                        <a href="neft" class="btn btn-success btn-xs pull-right"><i class = "fa fa-file"></i> Export NEFT</a> -->
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
                                <th  class="">Binary Payout</th>
                                <th  class="">Direct Payout(A)</th>
                                <th  class="">ROI Payout</th>
                                <th  class="">Total Payout[A+C+R+S](E)</th>
                                <th  class="">Admin Charges [-10%](E)</th>
                                <th  class="">TDS [-5%](F)</th>
                                <th  class="">Deduction Charge[E+F+G] (D)</th>
                                <th  class="">Total (E-D)</th>
                                <th  class="">Bank Detail</th>
                                <th  class="">Pan Card No</th>
                                <th  class="">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $i = 1;
                            //$myquery = "SELECT t1.uname,t1.uid as ttid,t2.first_name,t2.last_name,(SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a from user_id t1 join user_detail t2 on t1.uid =t2.uid and ((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 )";
                            $myquery = "SELECT 
                                        t1.uname,t1.uid as ttid,
                                        t2.first_name,
                                        t2.last_name,
                                        t2.pan_no,
                                        t3.*,
                                        (SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a,
                                        (SELECT IFNULL(SUM(`b_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as b,
                                        (SELECT IFNULL(SUM(`r_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as c,
                                        (SELECT IFNULL(SUM(`re_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as d,
                                        (SELECT IFNULL(SUM(`comission_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as e,
                                        (SELECT IFNULL(SUM(`ref_amount`),0) FROM `payout` WHERE `cleared` = 0 AND  `uid` = t1.uid) as f, 
                                        (SELECT IFNULL(SUM(`bonus_amount`),0) FROM `payout` WHERE `cleared` = 0 AND  `uid` = t1.uid) as g,
                                        (SELECT IFNULL(SUM(`roi_amount`),0) FROM `payout` WHERE `cleared` = 0 AND  `uid` = t1.uid) as h
                                        FROM user_id t1 
                                        LEFT JOIN user_bank t3 ON t1.uid =t3.uid 
                                        LEFT JOIN user_detail t2 ON t1.uid =t2.uid AND t1.uid!=1 
                                        where (
                                            (SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR 
                                            (SELECT IFNULL(SUM(`b_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR 
                                            (SELECT IFNULL(SUM(`comission_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR 
                                            (SELECT IFNULL(SUM(`ref_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR
                                            (SELECT IFNULL(SUM(`bonus_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR
                                            (SELECT IFNULL(SUM(`roi_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0
                                        )";
                            //echo $myquery;
                            //and ((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 )
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
                                // $s=$row['a']+$row['b']+$row['e']+$row['f'];
                                $s=$row['e']+$row['f']+$row['g'];
                                $e = ($s*10/100);
                                $f = ($s*5/100);
                                /*if(isset($row['pan_no']) && !empty($row['pan_no']))
                                {
                                    $g = 0;
                                }
                                else
                                {
                                     $g = ($s*20/100);
                                }*/
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i++;?></td>
                                    <!-- <td align="center">
                                        <?php //echo $i++;?>
                                        <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php //echo $row['ttid'];?>"/>
                                    </td> -->
                                    <td><?php echo $row['first_name']." ".$row['last_name']."(".$row['uname'].")";?></td>
                                                                       
                                    <td><?php echo $row['e'];?></td>
                                    <td><?php echo $row['g'];?></td>
                                    <td><?=$row['h'];?></td>
                                    <td><?php echo $s;?></td>
                                    <td><?php echo $e ;?></td>
                                    <td><?php echo $f ;?></td>
                                    <td><?php echo $d = $e+$f+$g;?></td>
                                    <td><?php echo $sum = $s-$d;?></td>
                                    <td><?php echo $bank_detail;?></td>
                                    <td><?php echo $row['pan_no'];?></td>
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


            <div id="panel-1" class="panel panel-default">
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
