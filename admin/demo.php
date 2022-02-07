<?php
require_once("../db_config.php");
/*$uid='41';
RepurchaseDownline($db,$uid);*/
/*RepurchasePayout($db);*/
$sponsor_id=490;
$position='L';
//$res=GetUserByPos($db,$sponsor_id,$position);
$res1=GetUserByPos($db,$sponsor_id,$position);
//echo "<pre>"; print_r($res);
echo "<pre>"; print_r($res1);
echo implode(',', $res1);

/*$res=GetUids($db,$sponsor_id);
echo "<pre>"; print_r($res);
$res1=getLevelid($db,$res);
echo implode(',', $res1);
echo "<pre>"; print_r($res1);*/
?>