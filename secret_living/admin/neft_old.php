<?php
session_start();
//Include database
include '../db_config.php';
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=arrowlee_payout.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");


echo '<table border="1">';
echo '<tr>
        <th>PAYSYS ID(RTGS/NEFT)</th>
        <th>DEBIT ACCOUNT</th>
        <th>TRAN AMOUNT</th>
        <th>BENEFICIARY ACCOUNT</th>
        <th>BENEFICIARY ACCOUNT TYPE</th>
        <th>BENEFICIARY NAME</th>
        <th>BENEFICIARY ADD1</th>
        <th>BENEFICIARY ADD2</th>
        <th>BENEFICIARY IFSC</th>
        <th>SENDER TO RECEIVER INFO</th>
    </tr>';

    $i = 1;
    $myquery = "SELECT t1.uname,t1.uid as ttid,t2.first_name,t2.last_name,t2.pan_no,t3.*,(SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a,(SELECT IFNULL(SUM(`b_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as b,(SELECT IFNULL(SUM(`r_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as c from user_id t1 join user_bank t3 on t1.uid =t3.uid join user_detail t2 on t1.uid =t2.uid and t1.uid!=1 where ((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0) order by t1.uid desc";
    $sql = mysqli_query($db,$myquery);
    while($row = mysqli_fetch_assoc($sql))
    {
        $acnumber='';
        $e=0;
        $g=0;
        $f=0;
        $ttid= $row['ttid'];
        if(isset($row['acnumber']) && !empty($row['acnumber']))
        {
            $acnumber=$row['acnumber'];
        }
        $s=$row['a'];
        if(isset($row['pan_no']) && !empty($row['pan_no']))
        {
            $e = ($s*5/100);
        }
        else
        {
             $g = ($s*20/100);
        }
        $f = ($s*5/100);
        $d = $e+$f+$g;
        $sum = $s-$d;
            echo "<tr>
                <td>".$acnumber."</td>
                <td>".$sum."</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
        
    }
    echo '</table>';
?>
