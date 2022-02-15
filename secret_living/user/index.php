<?php
session_start();
if(isset($_SESSION["mlmrole"]) && $_SESSION['mlmstatus']==1)
{
	$role = $_SESSION["mlmrole"];
	$url = "../".$role."/dashboard";
	header("location: ".$url);
}
else
{
	session_destroy();
	$url = "../index";
	header("location: ".$url);		
}
?>