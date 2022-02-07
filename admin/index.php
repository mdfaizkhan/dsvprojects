<?php
session_start();

if(isset($_SESSION["mlmrole"]))
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