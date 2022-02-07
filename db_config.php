<?php
ini_set('max_execution_time', 120000); //300 seconds = 5 minutes
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/
error_reporting(E_ALL);
if(isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=="127.0.0.1"  || $_SERVER['HTTP_HOST']=="192.168.1.1")){
    $dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "secret_living";
    $baseurl = "http://localhost/secret_living/";

    //mail setting
     $mailsetting = array(
        "Host"              =>  "smtp.gmail.com",
        "Port"              =>  587,
        "SMTPSecure"        =>  "tls",
        "SMTPAuth"          =>  true,
        "gmail_username"    =>  "dsvmailer@gmail.com",
        "gmail_password"    =>  "Dsvinfo@vin@y@321",
        "defaultfromemail"  =>  "dsvmailer@gmail.com",
        "defaultfromname"   =>  "Varietiz Pharma Pvt. Ltd. ",
        "defaulttoemail"    =>  "dsvinfosolutions@gmail.com",
        "defaulttoname"     =>  "Varietiz Pharma Pvt. Ltd. ",
        "defaultccemail"    =>  "dsvinfosolutions@gmail.com",
        "defaultccname"     =>  "Varietiz Pharma Pvt. Ltd. "
    );
    
}
else{
    /*$dbservername = "localhost";
    $dbusername = "frentic_mlm";
    $dbpassword = "latest@123";
    $dbname = "frentic_mlm";
    $baseurl = "https://frentic.in/";*/
    
    $dbservername = "localhost";
    $dbusername = "dsvinfo_varietiz_binary";
    $dbpassword = "latest@123";
    $dbname = "dsvinfo_varietiz_binary";
    $baseurl = "https://mlmsoft.dsvinfo.online/mlmdemo/varietiz_binary/";
    $mailsetting = array(
            "Host"              =>  "smtp.gmail.com",
            "Port"              =>  587,
            "SMTPSecure"        =>  "tls",
            "SMTPAuth"          =>  true,
            "gmail_username"    =>  "dsvmailer@gmail.com",
             "gmail_password"    =>  "Dsvinfo@vin@y@321",
            "defaultfromemail"  =>  "dsvmailer@gmail.com",
            "defaultfromname"   =>  "Varietiz Pharma Pvt. Ltd. ",
            "defaulttoemail"    =>  "dsvinfosolutions@gmail.com",
            "defaulttoname"     =>  "Varietiz Pharma Pvt. Ltd. ",
            "defaultccemail"    =>  "dsvinfosolutions@gmail.com",
            "defaultccname"     =>  "Varietiz Pharma Pvt. Ltd. "
        );
}


// Create connection
$db = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
//$db = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

mysqli_set_charset($db,"utf8");
$webname = "varietiz Pharma Pvt. Ltd.";
$webtitle = "Varietiz Pharma Pvt. Ltd.";

define("ACTIVEICON","../assets/images/active.png");
define("INACTIVEICON","../assets/images/inactive.png");

$LevelPercentNo=1;

//include function
include_once "function.php";
include_once "mlmfunction.php";
// include_once "/home/dsvinfo/public_html/mlmsoft.dsvinfo.online/mlmdemo/varietiz_binary/function.php";
// include_once "/home/dsvinfo/public_html/mlmsoft.dsvinfo.online/mlmdemo/varietiz_binary/mlmfunction.php";


define("ACTIVEICON_female","../assets/images/active_female.jpg");
define("INACTIVEICON_female","../assets/images/inactive_female.jpg");
//echo "Faiz khan--".GetMonthlyPurchaseStatus($db,45);
// UpdateRank($db);
// achieve_rank($db);
// checkAppreciationFortNightly($db);
?>