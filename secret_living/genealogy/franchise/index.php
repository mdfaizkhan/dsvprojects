<?php
session_start();
if(isset($_SESSION["franchiseid"]) && $_SESSION['franchiseid']>0)
{
	$role = 'franchise';
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