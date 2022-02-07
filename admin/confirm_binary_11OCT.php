<?php 
error_reporting(1);
require('../db_config.php');

$uid=$_POST['userid'];

$ans=$_POST['ans'];


$status="";
$res='success';
if($ans == "accept"){
	 
	$result=mysqli_query($db,"UPDATE user_id SET binary_activated='1' WHERE uid='".$uid."' ");
	if(mysqli_num_rows($result)>0){
		activatebinary($db,$uid);
		$res="success";
	}
	


}else{
	$query=mysqli_query($db,"UPDATE user_id SET binary_activated='2' WHERE uid='".$uid."' ");
		$res="success";
}
echo json_encode(array("res" => $res));
?>