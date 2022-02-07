<?php include 'db_config.php'; 
UpdateBv($db);

die;

/*$usr=array('FRENTIC57',
'FRENTIC53',
'BHARTI27',
'MALTI21',
'NEELU9',
'KHARAT',
'GAWLI',
'SUMIT',
'RAMAKANT',
'JABER',
'ASHOK',
'SKENTERPRISES',
'NEERAJ',
'SUBHASH14');
foreach ($usr as $key => $value) {
	$p1=mysqli_fetch_assoc(mysqli_query($db,"select uid from user_id where uname='$value'"));
    $uid=$p1['uid'];
    echo "UPDATE `pairing` SET `rank` = '8' WHERE `uid` = '$uid';";
    mysqli_query($db,"UPDATE `pairing` SET `rank` = '8' WHERE `uid` = '$uid'");
    echo "UPDATE `child_counter` SET `right_bv` = '10000000' WHERE `uid` = '$uid';";
    mysqli_query($db,"UPDATE `child_counter` SET `right_bv` = '10000000' WHERE `uid` = '$uid'");
}*/
//sendSMS1($db);


$i = 1;
    if (($handle = fopen('DB/active.csv', "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {
        if($i > 0)
        {
            //print_r($data[0]);
            
            $uid= $data[1];
            //echo $uid= $data[2];
            /*$username = $data[2];
            $position = $data[5];*/
            
            /*$prr=mysqli_fetch_assoc(mysqli_query($db,"select uid,paired from user_id where uname='$parent_id'"));
            
            $uid=$prr['uid'];*/

            
           mysqli_query($db,"UPDATE `user_id` SET `bv` = `bv`+'500' WHERE `uname` = '$uid'")or die(mysqli_error($db));
        }
            
      }
      fclose($handle);
    }

?>