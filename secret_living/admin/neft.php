<?php
session_start();
//Include database
include '../db_config.php';
header("Content-Type: application/vnd.ms-excel");    
header("Content-Disposition: attachment; filename=varietiz_matching_payout.xls");  
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
            (SELECT IFNULL(SUM(`gtb`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a
           
            FROM user_id t1 
            LEFT JOIN user_bank t3 ON t1.uid =t3.uid 
            LEFT JOIN user_detail t2 ON t1.uid =t2.uid AND t1.uid!=1 
            where t1.uid!=1 and (
                (SELECT IFNULL(SUM(`gtb`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0
            )";
    $sql = mysqli_query($db,$myquery);
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
        $d = $e+$f+$g;
        $sum = number_format((float)$s-$d, 2, '.', '');
            echo "<tr>
                <td>".$row['first_name']." ".$row['last_name']."</td>
                <td>".$swiftcode."</td>
                <td>".$acnumber."</td>
                <td>".$sum."</td>
            </tr>";
        
    }
    echo '</table>';
?>
