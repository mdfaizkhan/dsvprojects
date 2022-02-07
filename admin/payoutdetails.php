<?php 
require('../db_config.php');
$userid=$_POST['userid'];
$date = isset($_POST['payoutdate']) && !empty($_POST['payoutdate'])?$_POST['payoutdate']:'';



/*$fromdate=isset($_POST['fromdate'])?$_POST['fromdate']:'';
$todate=isset($_POST['todate'])?$_POST['todate']:'';
*/
// if(empty($userid) && $fromdate !='' && $todate != ''){
//    $myquery = "SELECT * FROM payout LEFT JOIN user_id on payout.uid=user_id.uid INNER JOIN user_detail ON user_id.uid=user_detail.uid WHERE payout.date >= '".$fromdate."' AND  payout.date <= '".$todate."'"; 
// }
// else if(!empty($userid) && $fromdate !='' && $todate != ''){
//     $myquery = "SELECT * FROM payout LEFT JOIN user_id on payout.uid=user_id.uid INNER JOIN user_detail ON user_id.uid=user_detail.uid WHERE payout.date >= '".$fromdate."' AND  payout.date <= '".$todate."' AND payout.uid='".$userid."'";
// }
// else if(!empty($userid) && $fromdate =='' && $todate == ''){
//     $myquery = "SELECT * FROM payout LEFT JOIN user_id on payout.uid=user_id.uid INNER JOIN user_detail ON user_id.uid=user_detail.uid WHERE payout.uid='".$userid."'";
// }
// else{
//     $myquery = "SELECT * FROM payout LEFT JOIN user_id on payout.uid=user_id.uid INNER JOIN user_detail ON user_id.uid=user_detail.uid "; 
// }

if($date == ''){
    $sql1 = "SELECT 
                (t1.comission_amount+t1.bonus_amount+t1.roi_amount) as amount,
                t1.date,
                t2.uid,
                t2.uname,
                t3.first_name,
                t3.last_name
                FROM payout t1
                INNER JOIN user_id t2 ON t2.uid = t1.uid
                INNER JOIN user_detail t3 ON t3.uid = t2.uid
                WHERE t1.date <= now() AND t1.uid='$userid'";
}
else{
    $sql1 = "SELECT 
                (t1.comission_amount+t1.bonus_amount+t1.roi_amount) as amount,
                t1.date,
                t2.uid,
                t2.uname,
                t3.first_name,
                t3.last_name
                FROM payout t1
                INNER JOIN user_id t2 ON t2.uid = t1.uid
                INNER JOIN user_detail t3 ON t3.uid = t2.uid
                WHERE t1.date <= '$date' AND t1.uid='$userid'";
}
// echo $sql1;
$query1 = mysqli_query($db,$sql1) or die(mysqli_error($db));

?>

<?php
$i = 1;
while($row1 = mysqli_fetch_assoc($query1))
{
    if($row1['amount']>0){
    ?>
    <tr class="odd gradeX">
        <td align="center"><?php echo $i++;?></td>
        <td><?php echo $row1['uname'] ;?></td>
        <td><?php echo $row1['first_name']." ".$row1['last_name'] ;?></td>
        <td><?php echo $row1['uid'] ;?></td>
        <td><?php echo $row1['amount'];?></td>
        <td><?php echo $row1['date'];?></td>
    </tr>
    <?php 
    }
}
?>
                