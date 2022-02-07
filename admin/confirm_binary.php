<?php 
require('../db_config.php');
$uid=$_POST['userid'];
$ans=$_POST['ans'];
$status="";
$res='Fail';
$date=date("Y-m-d H:i");
if($ans == "accept"){
	$result=mysqli_query($db,"UPDATE user_id SET binary_activated='1' WHERE uid='".$uid."' ");
	if($result){
		activatebinary($db,$uid);
		$q1=mysqli_query($db,"select * from rplans limit 2");
		while($plans=mysqli_fetch_assoc($q1))
		{
			$amount=$plans['plan_amount'];
	        $plan_id=$plans['plan_id'];
	        $sql="INSERT INTO `purchase` SET `plan_id`='$plan_id',`amount`='$amount',`uid`='$uid',`status`= 1,`approve_date`= '$date',`date`=now()";
	        $qry = mysqli_query($db,$sql) or die(mysqli_error($db));
		}
        
		$res="success";
	}
}else{
	$query=mysqli_query($db,"UPDATE user_id SET binary_activated='2' WHERE uid='".$uid."' ");
		$res="success";
}
echo json_encode(array("res" => $res));
?>