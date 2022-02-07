<?php
session_start();
//Include database
include '../db_config.php';
header("Content-Type: application/vnd.ms-excel");    
header("Content-Disposition: attachment; filename=varietiz_rank_payout.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");


echo '<table border="1">';
echo '<tr>
        <th>Name</th>
        <th>IFSC</th>
        <th>Account No.</th>
        <th>Amount</th>
        
    </tr>';

    $i = 1;
    $myquery = "SELECT 
        t1.uname,t1.uid as ttid,
        t2.first_name,
        t2.last_name,
        t2.pan_no,
        t3.*,
        (SELECT IFNULL(SUM(`sd`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a , (SELECT IFNULL(SUM(`rd`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as b , (SELECT IFNULL(SUM(`ad`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as c , (SELECT IFNULL(SUM(`co`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as d , (SELECT IFNULL(SUM(`retail_profit`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as e , (SELECT IFNULL(SUM(`appriciation_amnt`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as f , (SELECT IFNULL(SUM(`sco`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as g , (SELECT IFNULL(SUM(`cco`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as h , (SELECT IFNULL(SUM(`se`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as i ,(SELECT IFNULL(SUM(`ge`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as j , (SELECT IFNULL(SUM(`pe`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as k , (SELECT IFNULL(SUM(`do`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as l , (SELECT IFNULL(SUM(`bdo`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as n , (SELECT IFNULL(SUM(`bldo`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as m , (SELECT IFNULL(SUM(`ra`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as o , (SELECT IFNULL(SUM(`ia`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as p , (SELECT IFNULL(SUM(`ca`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as q , (SELECT IFNULL(SUM(`royalty`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as r
       
        FROM user_id t1 
        LEFT JOIN user_bank t3 ON t1.uid =t3.uid 
        LEFT JOIN user_detail t2 ON t1.uid =t2.uid AND t1.uid!=1 
        where t1.uid!=1 and (
            (SELECT IFNULL(SUM(`sd`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`rd`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ad`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`co`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`retail_profit`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`appriciation_amnt`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`sco`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`cco`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`se`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ge`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`pe`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`do`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`bdo`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`bldo`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ra`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ia`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`ca`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 OR (SELECT IFNULL(SUM(`royalty`),0) FROM `rank_payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0
        )";
        $sql = mysqli_query($db,$myquery) or die(mysqli_error($db));
        while($row = mysqli_fetch_assoc($sql))
        {
            $acnumber='';
            $swiftcode='';
            $e=0;
            $g=0;
            $f=0;
            $ttid= $row['ttid'];
            if(isset($row['acnumber']) && !empty($row['acnumber']))
            {
                $acnumber=$row['acnumber'];
            }
            if(isset($row['swiftcode']) && !empty($row['swiftcode']))
            {
                $swiftcode=$row['swiftcode'];
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
        $d = $e+$f+$g;
        $sum = number_format((float)$s-$d, 2, '.', '');
            echo "<tr>
                <td>".$row['first_name']." ".$row['last_name']."</td>
                <td>".$swiftcode."</td>
                <td>"."AC NO:- ".$acnumber."</td>
                <td>".$sum."</td>
            </tr>";
        
    }
    echo '</table>';
?>
