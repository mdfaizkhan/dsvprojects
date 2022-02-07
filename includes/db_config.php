<?php
ini_set('max_execution_time', 120000); //300 seconds = 5 minutes
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
if(isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=="127.0.0.1"  || $_SERVER['HTTP_HOST']=="192.168.1.1")){
    $dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "frentic";
    $baseurl = "http://localhost/frentic/";

    //mail setting
    $mailsetting = array(
        "Host"              =>  "smtp.gmail.com",
        "Port"              =>  587,
        "SMTPSecure"        =>  "tls",
        "SMTPAuth"          =>  true,
        "gmail_username"    =>  "dsvmailer@gmail.com",
        "gmail_password"    =>  "latest@123",
        "defaultfromemail"  =>  "dsvmailer@gmail.com",
        "defaultfromname"   =>  "Frentic Retail & Marketing Pvt. Ltd. ",
        "defaulttoemail"    =>  "dsvinfosolutions@gmail.com",
        "defaulttoname"     =>  "Frentic Retail & Marketing Pvt. Ltd. ",
        "defaultccemail"    =>  "dsvinfosolutions@gmail.com",
        "defaultccname"     =>  "Frentic Retail & Marketing Pvt. Ltd. "
    );
    
}
else{
    /*$dbservername = "localhost";
    $dbusername = "frentic_mlm";
    $dbpassword = "latest@123";
    $dbname = "frentic_mlm";
    $baseurl = "https://frentic.in/";*/
    
    $dbservername = "localhost";
    $dbusername = "frentic_demo";
    $dbpassword = "latest@123";
    $dbname = "frentic_demo";
    $baseurl = "https://frentic.in/";
    $mailsetting = array(
            "Host"              =>  "smtp.gmail.com",
            "Port"              =>  587,
            "SMTPSecure"        =>  "tls",
            "SMTPAuth"          =>  true,
            "gmail_username"    =>  "dsvmailer@gmail.com",
            "gmail_password"    =>  "latest@123",
            "defaultfromemail"  =>  "dsvmailer@gmail.com",
            "defaultfromname"   =>  "Frentic Retail & Marketing Pvt. Ltd. ",
            "defaulttoemail"    =>  "dsvinfosolutions@gmail.com",
            "defaulttoname"     =>  "Frentic Retail & Marketing Pvt. Ltd. ",
            "defaultccemail"    =>  "dsvinfosolutions@gmail.com",
            "defaultccname"     =>  "Frentic Retail & Marketing Pvt. Ltd. "
        );
}


// Create connection
$db = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
//$db = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

mysqli_set_charset($db,"utf8");
$webname = "Frentic Retail & Marketing Pvt. Ltd.";
$webtitle = "Frentic Retail & Marketing Pvt. Ltd.";

define("ACTIVEICON","../assets/images/active.png");
define("INACTIVEICON","../assets/images/inactive.png");

$LevelPercentNo=1;

//include function
/*include_once "function.php";die;
include_once "mlmfunction.php";*/
include_once "/home/frentic/public_html/function.php";
include_once "/home/frentic/public_html/mlmfunction.php";
?>