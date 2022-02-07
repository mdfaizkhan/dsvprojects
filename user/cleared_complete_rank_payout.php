<?php include("header.php");?>

    <section id="middle">
        <header id="page-header">
            <h1>Cleared Generated Commision Payout</h1>
        </header>

        <div id="content" class="padding-20">


            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                    <span class="title elipsis">
                        <strong>Cleared Generated Commision Payout</strong> <!-- panel title -->
                        <!-- <a href="exportexcel" class="btn btn-success btn-xs pull-right"><i class = "fa fa-file"></i> Export Bulk</a>-->
                        
                    </span>
                </div>
                <div class="panel-body ">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                            <thead>
                            <tr> 
                                <th  class="">SR No</th>
                                <th  class="">User</th>
                                <th  class="">SR. DISTRIBUTOR</th>
                                <th  class="">REGIONAL DIS. </th>
                                <th  class="">AREA DIS</th>
                                <th  class="">CO-ORD.</th>
                                <th  class="">SR.CO-ORD.</th>
                                <th  class="">CHIEF.CO-ORD.</th>
                                <th  class="">SILVER EX.</th>
                                <th  class="">GOLD EX.</th>
                                <th  class="">PLATINUM EX.</th>
                                <th  class="">DIAMOND OFF.</th>
                                <th  class="">BLUE DIAMOND OFF.</th>
                                <th  class="">BLACK DIAMOND OFF.</th>
                                <th  class="">ROYAL AMBASSDOR</th>
                                <th  class="">IMPERIAL AMBASSDOR</th>
                                <th  class="">CROWN AMBASSDOR</th>
                                <th  class="">Appriciation Amnt.</th>
                                <th  class="">Retail Profit .</th>
                                <th  class="">Royalty</th>
                                <th  class="">Reward</th>
                                <th  class="">Total Payout<!-- [A+C+R+S] -->(T)</th>
                                <th  class="">Admin Charges [-5%](E)</th>
                                <th  class="">TDS [-5%](F)</th>
                                <th  class="">Deduction Charge[E+F] (D)</th>
                                <th  class="">Total (T-D)</th>
                                <th  class="">Bank Detail</th>
                                <th  class="">Cleared Date</th>
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
                            t4.*,
                            (SELECT IFNULL(SUM(`sd`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as a , (SELECT IFNULL(SUM(`rd`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as b , (SELECT IFNULL(SUM(`ad`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as c , (SELECT IFNULL(SUM(`co`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as d , (SELECT IFNULL(SUM(`retail_profit`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as e , (SELECT IFNULL(SUM(`appriciation_amnt`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as f , (SELECT IFNULL(SUM(`sco`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as g , (SELECT IFNULL(SUM(`cco`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as h , (SELECT IFNULL(SUM(`se`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as i ,(SELECT IFNULL(SUM(`ge`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as j , (SELECT IFNULL(SUM(`pe`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as k , (SELECT IFNULL(SUM(`do`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as l , (SELECT IFNULL(SUM(`bdo`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as n , (SELECT IFNULL(SUM(`bldo`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as m , (SELECT IFNULL(SUM(`ra`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as o , (SELECT IFNULL(SUM(`ia`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as p , (SELECT IFNULL(SUM(`ca`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as q , (SELECT IFNULL(SUM(`royalty`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) as r
                           
                            FROM user_id t1 
                            LEFT JOIN rank_payout t4 ON t1.uid =t4.uid 
                            LEFT JOIN user_bank t3 ON t1.uid =t3.uid 
                            LEFT JOIN user_detail t2 ON t1.uid =t2.uid AND t1.uid!=1 
                            where t1.uid='$mlmid' and (
                                (SELECT IFNULL(SUM(`sd`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`rd`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ad`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`co`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`retail_profit`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`appriciation_amnt`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`sco`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`cco`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`se`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ge`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`pe`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`do`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`bdo`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`bldo`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ra`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ia`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ca`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`royalty`),0) FROM `rank_payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0
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
                                $s=$row['a']+$row['b']+$row['c']+$row['d']+$row['e']+$row['f']+$row['g']+$row['h']+$row['i']+$row['j']+$row['k']+$row['l']+$row['m']+$row['n']+$row['o']+$row['p']+$row['q']+$row['r'];
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
                                    <td><?php echo $row['b'];?></td>
                                    <td><?php echo $row['c'];?></td>
                                    <td><?php echo $row['d'];?></td>
                                    <td><?php echo $row['g'];?></td>
                                    <td><?php echo $row['h'];?></td>
                                    <td><?php echo $row['i'];?></td>
                                    <td><?php echo $row['j'];?></td>
                                    <td><?php echo $row['k'];?></td>
                                    <td><?php echo $row['l'];?></td>
                                    <td><?php echo $row['m'];?></td>
                                    <td><?php echo $row['n'];?></td>
                                    <td><?php echo $row['o'];?></td>
                                    <td><?php echo $row['p'];?></td>
                                    <td><?php echo $row['q'];?></td>
                                    <td><?php echo $row['f'];?></td>
                                    <td><?php echo $row['e'];?></td>
                                    <td><?php echo $row['r'];?></td>
                                    <td>
                                     <?php
                                      $Reward=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `rank_payout` where `uid`='$ttid'"));
                                      echo $Reward['reward'];
                                     ?>   
                                    </td>
                                    <td><?php echo number_format((float)$s, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$e, 2, '.', '');?></td>
                                    <td><?php echo number_format((float)$f, 2, '.', '');?></td>
                                    <td><?php $d = $e+$f+$g;
                                        echo number_format((float)$d, 2, '.', '');
                                    ?></td>
                                    <td><?php echo $sum = number_format((float)$s-$d, 2, '.', '');?></td>
                                    <td><?php echo $bank_detail;?></td>
                                    <td><?php echo $row['cleared_date'];?></td>
                                    
                                 
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
                            //and ((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 1 and  `uid` = t1.uid) >0 )
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
