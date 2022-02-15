<?php 
require('../db_config.php');

$uid=$_POST['userid'];

$ans=$_POST['ans'];


$status="";
$res='';
if($ans == "accept"){
	 
	mysqli_query($db,"UPDATE user_id SET binary_activated='1' WHERE uid='".$uid."' ");
	$res="suceess";
}else{
	$query=mysqli_query($db,"UPDATE purchase SET binary_activated='2' WHERE uid='".$uid."' ");
		$res="fail";
}
echo json_encode(array("res" => $res));
?>