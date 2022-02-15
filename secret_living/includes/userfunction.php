<?php
session_start();
//Include database
include '../db_config.php';
$cdate=date("Y-m-d H:i");
/*
 * Change password
 */
if(isset($_POST['ajax_changepassword']))
{
    $adminid = $_SESSION['mlmid'];
    $current_password   = $_POST['ajax_current_password'] ;
    $new_password   = $_POST['ajax_new_password'];
    $confirm_password   = $_POST['ajax_confirm_password'];

    $new_password1 = encrypt_password($new_password);
    $data = mysqli_fetch_assoc(mysqli_query($db,"select * from user_id where `uid` = '$adminid'"));
    if ($current_password==$data['password'])
    {
        $query =  mysqli_query($db,"UPDATE `user_id` SET `password`= '$new_password' WHERE `uid` = '$adminid'");
        if($query)
        {  
            echo json_encode(array(
                "valid"=>1,
                "message" => "Password updated successfully"
            ));
        }
        else
        {
            echo json_encode(array(
                "valid"=>0,
                "message" => "Password Cannot be Updated."
            ));
        }

    }
    else
    {
        echo json_encode(array(
            "valid"=>0,
            "message" => "Current password is incorrect"
        ));
    }
}
if(isset($_POST['ajax_changetpassword']))
{
    $adminid = $_SESSION['mlmid'];
    $current_password   = $_POST['ajax_current_password'] ;
    $new_password   = $_POST['ajax_new_password'];
    $confirm_password   = $_POST['ajax_confirm_password'];
    $new_password1 = encrypt_password($new_password);
    $data = mysqli_fetch_assoc(mysqli_query($db,"select * from user_id where `uid` = '$adminid'"));

    if ($current_password==$data['tpassword'])
    {
        $query =  mysqli_query($db,"UPDATE `user_id` SET `tpassword`= '$new_password' WHERE `uid` = '$adminid'");
        if($query)
        {  
            echo json_encode(array(
                "valid"=>1,
                "message" => "Password updated successfully"
            ));
        }
        else
        {
            echo json_encode(array(
                "valid"=>0,
                "message" => "Password Cannot be Updated."
            ));
        }
    }
    else
    {
        echo json_encode(array(
            "valid"=>0,
            "message" => "Current password is incorrect"
        ));
    }
}
if(isset($_POST['ajax_fchangetpassword']))
{
    $adminid = $_SESSION['franchiseid'];
    $current_password   = $_POST['ajax_current_password'] ;
    $new_password   = $_POST['ajax_new_password'];
    $confirm_password   = $_POST['ajax_confirm_password'];
    $new_password1 = encrypt_password($new_password);
    $data = mysqli_fetch_assoc(mysqli_query($db,"select * from franchise where `id` = '$adminid'"));

    if ($current_password==$data['tpassword'])
    {
        $query =  mysqli_query($db,"UPDATE `franchise` SET `tpassword`= '$new_password' WHERE `id` = '$adminid'");
        if($query)
        {  
            echo json_encode(array(
                "valid"=>1,
                "message" => "Password updated successfully"
            ));
        }
        else
        {
            echo json_encode(array(
                "valid"=>0,
                "message" => "Password Cannot be Updated."
            ));
        }
    }
    else
    {
        echo json_encode(array(
            "valid"=>0,
            "message" => "Current password is incorrect"
        ));
    }
}
if(isset($_POST["type"]) && $_POST["type"] == "GeneratePassword")
{
    $success = false;
    $message = "";
    $url="";
    $user_id = $_POST['id'];

    $query = $db->query("select * from users where user_id = '$user_id'");
    $q = $query->num_rows;
    if($q>0)
    {
        $data = mysqli_fetch_assoc($query);
        $userid = $data['user_id'];
        $tokentime = strtotime(date('Y-m-d H:i:s', strtotime('+1 day', time())));
        $token = encrypt_decrypt('encrypt',$userid."_".$tokentime);
        $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $loginurl = str_replace("includes/adminfunction","reset?token=$token",$loginurl);
        ini_set("SMTP", "smtpout.secureserver.net");//confirm smtp
        $to = $username;
        $from = "";
        $subject = "$webtitle - Password Reset Link";
        $body="
            <b style='text-transform:capitalize;'>Dear ".$data['first_name']." ".$data['last_name'].", </b>
            <br>
            <p> Please <a href='$loginurl'> Click Here To Reset Password</a>, Link is valid for 24 hours </a></p>
            <br>
            <p>Thank You</p>
            <img alt=\"$webname\" border=\"0\" width=\"250\" style=\"display:block\"  src=\"cid:logo_2u\"><br>
        ";
        //send_mail( $to, $from, $subject, $body );
        send_phpmail( $data['first_name']." ".$data['last_name'], $to ,"", "" , $subject, $body );
        $success = true;
        $message = "A Mail has been Sent to Reset Password";

    }
    else
    {
        $message = "User is not Registered";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $message
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "UserStatus")
{
    $success = false;
    $msg = "";
    $url="";
    $user_id = $_POST['id'];
    $status = $_POST['status'];
    if($status == 1){ $msg = "Account Activated";}
    else { $msg = "Account Deactivated";}
    $query = $db->query("update users set status = '$status' where user_id = '$user_id'");
    if($query)
    {
        $success = true;
        if($status == 1){ $msg = "Account Activated";}
        else { $msg = "Account Deactivated";}
    }
    else
    {
        $msg = "Status cannot be updated";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $msg
    ));
    
}

if(isset($_POST["type"]) && $_POST["type"] == "RemoveSelectedPin")
{
    $success = false;
    $message = "";
    if(count($_POST['pin_id'])>0)
    {
        $pin_id = implode(",",$_POST['pin_id']);
        $delrecord = mysqli_query($db,"DELETE FROM transpin WHERE pin_id in($pin_id)");
        //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
        if($delrecord)
        {
            $success = true;
            $message = "Pin Deleted Successfully";
        }
        else
        {
            $message = "Some Problem Occur, While Deleting.";

        }
    }
    else
    {
        $message = "Select Atleast one pin to delete";

    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}



/*
 * Check Valid Pin
 */
if(isset($_POST["type"]) && $_POST["type"] == "checkValidPin")
{
    $success = false;
    $message = "";
    $username="";
    $url="";
    $pin_no = $_POST['pin_no'];
    if(isset($pin_no))
    { 
        $msg=checkTransPin($db,$pin_no);
        if($msg==1)
        {
            $success = true;
        }
        else
        {
            $message=$msg;
        }
       
    }
    else
    {
        $message = "Enter PIN No";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $message
    ));
}


/* add / Edit User */
if(isset($_POST["type"]) && $_POST["type"]== 'AddEditUser_vk')
{
    $success = false;
    $msg = "";
    $url="";
    //print_r($_POST);
    extract($_POST);    
    $id=$txtid; 

    
        if($id=='')
        {
           if(isset($parent_id) && !empty($parent_id) && isset($pin_no) && !empty($pin_no) && isset($sponsor_id) && !empty($sponsor_id))
            {
                $sp1=mysqli_query($db,"select uid,paired from user_id where uname='$parent_id'");
                $spno=mysqli_num_rows($sp1);
                if($spno > 0)
                {
                    $sqry=mysqli_query($db,"select uid from user_id where uname='$sponsor_id'");
                    $spno1=mysqli_num_rows($sqry);
                    if($spno1 > 0)
                    {
                        $userid=mysqli_fetch_assoc($sp1);
                        $parent_id=$userid['uid'];
                        $paired=$userid['paired']+1;
                        $chkqry=mysqli_num_rows(mysqli_query($db,"select uid from pairing where parent_id='$parent_id'"));
                        if($chkqry >= 5)
                        {
                            $msg = "You can not add User under this parent,Parent Already have 5 Childs.";
                        }
                        else
                        {
                            if($spno1 > 0)
                                {
                                    $sr1=mysqli_fetch_assoc($sqry);
                                    $sponsor_id=$sr1['uid'];
                                    $pay_parent_id=$sponsor_id;
                                    $is_sponsor=1;
                                }
                                else
                                {
                                    $msg = "Enter valid Parent Id!";
                                } 
                            
                            $userc=mysqli_num_rows(mysqli_query($db,"select uid from user_id where uname='$username'"));
                            
                            if($userc>0)
                            {
                                $msg = "Username is already taken";
                            }else if (preg_match('/[^a-z_\-0-9]/i', $username)) {
                                $msg = "Username should contain only character,number or underscore";
                            }
                            else
                            {  
                                $cpin=checkTransPin($db,$pin_no);
                                if($cpin==1)
                                {   
                                    $qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`, `pin`,`paired`) VALUES ('$username','$password',now(),now(),'$pin_no','$paired')";
                                    $q=mysqli_query($db,$qry) or die(mysqli_error($db));
                                    if($q)
                                    {
                                        $uid=mysqli_insert_id($db);
                                        $qry1="Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
                                        $q1=mysqli_query($db,$qry1);
                                        if($q1)
                                        {
                                            
                                            
                                           $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                           UserPairing($db,$uid,$parent_id,$sponsor_id);
                                            $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            $url = str_replace("includes/userfunction","member",$loginurl);
                                            ini_set("SMTP", "smtpout.secureserver.net");//confirm smtp
                                            $to = "$email";
                                            $from = "";
                                            $tname = $fname." ".$lname;
                                            $tuser_id = $username;
                                            $tpassword = $_POST["password"];
                                            $tsponserid = "";
                                            $tstatus = "Active";
                                            $date=date("Y-m-d H:i");
                                            ob_start();
                                            include_once ('../template.php');
                                            $content = ob_get_clean();
                                            $subject = "Welcome to $webname";
                                            $fpay=FirstRegisterPayment($db,$uid,$pay_parent_id,$is_sponsor);
                                            $pamount=getPinAmount($db,$uid);
                                            if(isset($email) && !empty($email))
                                            {
                                                $mail=send_phpmail($tname,$to,"","",$subject,$content);
                                            }
                                            $message = "Welcome to BRAND MAKERS. \n  Login Details: \n Username : $username \n password : $password \n Click Here To Login  $url";
                                            sendSMS($db,$uid,$message);
                                            //var_dump($fpay);
                                            //sendMultipleEmailAttachment($to,$fname." ".$lname,"",$subject,$content,array());
                                            //send_phpmail($to,$fname." ".$lname,"","",$subject,$content);
                                            $success = true;                
                                            $msg= "New user added successfully";
                                        }
                                        else
                                        {
                                            $msg= "Failed!";
                                        }
                                    }
                                    else{
                                        $msg= "New user not added successfully";
                                    }
                                }
                                else
                                {
                                    $msg=$cpin;
                                }  
                            }
                        }
                    }
                    else
                    {
                        $msg = "Enter valid Sponsor Id!";
                    }
                }
                else
                {
                    $msg = "Enter valid Parent Id!";
                } 
            }
            else if(isset($pin_no) && empty($pin_no))
            {
                $msg = "Pin No Is Required";
            }
            else if(isset($parent_id) && empty($parent_id))
            {
                $msg = "Parent Id Is Required";
            }
            else
            {
                $msg = "Sponser Id Is Required";
            }   
        }
        else  
        {  
            $qry="UPDATE `user_id` SET `password`='$password' WHERE `uid`=$id";
            $q1=mysqli_query($db,$qry);
            //echo $qry;
            if($q1)
            {       
                $qry="UPDATE `user_detail` SET `first_name`='$fname', `last_name`='$lname', `gender`='$gender', `email`='$email', `mobile`='$mobile_no', `pan_no`='$pan_no' WHERE `uid`=$id";
                $q1=mysqli_query($db,$qry); 
                $success = true;
                $msg = "User Updated Successfully";
            }
            else{
                 $msg= "Some Promlem Occur try after sometime";
            }
            
        }
    
            
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'msg'=>$msg
    ));
}
/* add / Edit User */
if(isset($_POST["type"]) && $_POST["type"]== 'AddEditUser_with_parent_id')
{
    $success = false;
    $msg = "";
    $url="";
    //print_r($_POST);
    extract($_POST);    
    $id=$txtid; 

    
        if($id=='')
        {
           if(isset($parent_id) && !empty($parent_id) && isset($pin_no) && !empty($pin_no) && isset($sponsor_id) && !empty($sponsor_id))
            {
                $sp1=mysqli_query($db,"select uid,paired from user_id where uname='$parent_id'");
                $spno=mysqli_num_rows($sp1);
                if($spno > 0)
                {
                    $sqry=mysqli_query($db,"select uid from user_id where uname='$sponsor_id'");
                    $spno1=mysqli_num_rows($sqry);
                    if($spno1 > 0)
                    {
                        $userid=mysqli_fetch_assoc($sp1);
                        $parent_id=$userid['uid'];
                        $paired=$userid['paired']+1;
                        $chkqry=mysqli_num_rows(mysqli_query($db,"select uid from pairing where parent_id='$parent_id'"));
                        if($chkqry >= 5)
                        {
                            $msg = "You can not add User under this parent,Parent Already have 5 Childs.";
                        }
                        else
                        {
                            $check_position = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
                            $chkqry2 = mysqli_num_rows($check_position);
                            if($chkqry2>0){
                                $msg = 'Already assiged a user to this side';
                            }
                            else{
                                if($spno1 > 0)
                                {
                                    $sr1=mysqli_fetch_assoc($sqry);
                                    $sponsor_id=$sr1['uid'];
                                    $pay_parent_id=$sponsor_id;
                                    $is_sponsor=1;
                                }
                                else
                                {
                                    $msg = "Enter valid Parent Id!";
                                } 
                                
                                $userc=mysqli_num_rows(mysqli_query($db,"select uid from user_id where uname='$username'"));
                                
                                if($userc>0)
                                {
                                    $msg = "Username is already taken";
                                }else if (preg_match('/[^a-z_\-0-9]/i', $username)) {
                                    $msg = "Username should contain only character,number or underscore";
                                }
                                else
                                {  
                                    $cpin=checkTransPin($db,$pin_no);
                                    if($cpin==1)
                                    {   
                                        $qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`, `pin`,`paired`) VALUES ('$username','$password',now(),now(),'$pin_no','$paired')";
                                        $q=mysqli_query($db,$qry) or die(mysqli_error($db));
                                        if($q)
                                        {
                                            $uid=mysqli_insert_id($db);
                                            $qry1="Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
                                            $q1=mysqli_query($db,$qry1);
                                            if($q1)
                                            {
                                                
                                                
                                               $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                               //UserPairing($db,$uid,$parent_id,$sponsor_id);
                                               UserPairing($db,$uid,$parent_id,$sponsor_id,$position);
                                                $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                $url = str_replace("includes/userfunction","member",$loginurl);
                                                ini_set("SMTP", "smtpout.secureserver.net");//confirm smtp
                                                $to = "$email";
                                                $from = "";
                                                $tname = $fname." ".$lname;
                                                $tuser_id = $username;
                                                $tpassword = $_POST["password"];
                                                $tsponserid = "";
                                                $tstatus = "Active";
                                                $date=date("Y-m-d H:i");
                                                ob_start();
                                                include_once ('../template.php');
                                                $content = ob_get_clean();
                                                $subject = "Welcome to $webname";
                                                $fpay=FirstRegisterPayment($db,$uid,$pay_parent_id,$is_sponsor);
                                                $pamount=getPinAmount($db,$uid);
                                                if(isset($email) && !empty($email))
                                                {
                                                    $mail=send_phpmail($tname,$to,"","",$subject,$content);
                                                }
                                                $message = "Welcome to RELICUS NETMART INDIA PVT LTD. \n  Login Details: \n Username : $username \n password : $password \n Click Here To Login  $url";
                                                sendSMS($db,$uid,$message);
                                                //var_dump($fpay);
                                                //sendMultipleEmailAttachment($to,$fname." ".$lname,"",$subject,$content,array());
                                                //send_phpmail($to,$fname." ".$lname,"","",$subject,$content);
                                                $success = true;                
                                                $msg= "New user added successfully";
                                            }
                                            else
                                            {
                                                $msg= "Failed!";
                                            }
                                        }
                                        else{
                                            $msg= "New user not added successfully";
                                        }
                                    }
                                    else
                                    {
                                        $msg=$cpin;
                                    }  
                                }
                            }
                        }
                    }
                    else
                    {
                        $msg = "Enter valid Sponsor Id!";
                    }
                }
                else
                {
                    $msg = "Enter valid Parent Id!";
                } 
            }
            else if(isset($pin_no) && empty($pin_no))
            {
                $msg = "Pin No Is Required";
            }
            else if(isset($parent_id) && empty($parent_id))
            {
                $msg = "Parent Id Is Required";
            }
            else
            {
                $msg = "Sponser Id Is Required";
            }   
        }
        else  
        {  
            $qry="UPDATE `user_id` SET `password`='$password' WHERE `uid`=$id";
            $q1=mysqli_query($db,$qry);
            //echo $qry;
            if($q1)
            {       
                $qry="UPDATE `user_detail` SET `first_name`='$fname', `last_name`='$lname', `gender`='$gender', `email`='$email', `mobile`='$mobile_no', `pan_no`='$pan_no' WHERE `uid`=$id";
                $q1=mysqli_query($db,$qry); 
                $success = true;
                $msg = "User Updated Successfully";
            }
            else{
                 $msg= "Some Promlem Occur try after sometime";
            }
            
        }
    
            
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'msg'=>$msg
    ));
}
/* add / Edit User */
if(isset($_POST["type"]) && $_POST["type"]== 'AddEditUser')
{
    $success = false;
    $msg = "";
    $url = "";
    
    $date = date("Y-m-d H:i");
    extract($_POST);
    $p_count = mysqli_num_rows(mysqli_query($db, "SELECT * FROM transpin  WHERE plan_id='$package' && status=0"));
    if($p_count>0){
        $p = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM transpin  WHERE plan_id='$package' && status=0"));
        $pin_no = $p['pin_code'];

        $id = $txtid;
        if ($id == '')
        {
            if (!isset($parent_id) || empty($parent_id))
            {
                $parent_id = GetValidParentId($db, $sponsor_id, $position);
            }
            if (isset($parent_id) && !empty($parent_id) && isset($sponsor_id) && !empty($sponsor_id))
            {
                $sp1 = mysqli_query($db, "select uid,paired from user_id where uname='$parent_id'");
                $spno = mysqli_num_rows($sp1);
                if ($spno > 0)
                {
                    $sqry = mysqli_query($db, "select uid from user_id where uname='$sponsor_id'");
                    $spno1 = mysqli_num_rows($sqry);
                    if ($spno1 > 0)
                    {
                        $userid = mysqli_fetch_assoc($sp1);
                        $parent_id = $userid['uid'];
                        $paired = $userid['paired'] + 1;
                        $chkqry = mysqli_num_rows(mysqli_query($db, "select uid from pairing where parent_id='$parent_id'"));
                        if ($chkqry >= 2)
                        {
                            $msg = "You can not add User under this parent,Parent Already have 2 Childs.";
                        }
                        else
                        {
                            $check_position = mysqli_query($db, "SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
                            $chkqry2 = mysqli_num_rows($check_position);
                            if ($chkqry2 > 0)
                            {
                                $msg = 'Already assiged a user to this side';
                            }
                            else
                            {
                                if ($spno1 > 0)
                                {
                                    $sr1 = mysqli_fetch_assoc($sqry);
                                    $sponsor_id = $sr1['uid'];
                                    $pay_parent_id = $sponsor_id;
                                    $is_sponsor = 1;
                                }
                                else
                                {
                                    $msg = "Enter valid Parent Id!";
                                }
                                $userc = mysqli_num_rows(mysqli_query($db, "select uid from user_id where uname='$username'"));
                                if ($userc > 0)
                                {
                                    $msg = "Username is already taken";
                                }
                                else if (preg_match('/[^a-z_\-0-9]/i', $username))
                                {
                                    $msg = "Username should contain only character,number or underscore";
                                }
                                else
                                {
                                    $cpin = checkTransPin($db, $pin_no);
                                    if ($cpin == 1)
                                    {
                                        $qry = "INSERT INTO `user_id`(`uname`, `password`, `register_date`, `pin`,`paired`,`package`) VALUES ('$username','$password','$date','$pin_no','$paired','$package')";
                                        $q = mysqli_query($db, $qry) or die(mysqli_error($db));
                                        if ($q)
                                        {
                                            $uid = mysqli_insert_id($db);
                                            $qry1 = "Insert into user_detail(uid,first_name,last_name,gender,email,mobile) values($uid,'$fname','$lname','$gender','$email','$mobile_no')";
                                            $q1 = mysqli_query($db, $qry1);
                                            if ($q)
                                            {
                                                $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                                UserPairing($db, $uid, $parent_id, $sponsor_id, $position);

                                                $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                $url = str_replace("includes/adminfunction", "member", $loginurl);
                                                ini_set("SMTP", "smtpout.secureserver.net"); //confirm smtp
                                                $to = "$email";
                                                $from = "";
                                                $tname = $fname . " " . $lname;
                                                $tuser_id = $username;
                                                $tpassword = $_POST["password"];
                                                $tsponserid = "";
                                                $tstatus = "Active";
                                                $date = date("Y-m-d H:i");
                                                ob_start();
                                                include_once ('../template.php');
                                                $content = ob_get_clean();
                                                $subject = "Welcome to $webname";
                                                $fpay=FirstRegisterPayment($db,$uid,$pay_parent_id,$is_sponsor);
                                                if (isset($email) && !empty($email))
                                                {
                                                    $mail = send_phpmail($tname, $to, "", "", $subject, $content);
                                                }
                                                $userfname = GetUserflname($db, $uid);
                                                $message = "Dear $userfname, Welcome to SECRET LIVING. with Login ID: $username ,Login PW: $password,Transaction PW: 123456. .Login to www.demo.in";
                                                sendSMS($db, $uid, $message);
                                                //var_dump($fpay);
                                                //sendMultipleEmailAttachment($to,$fname." ".$lname,"",$subject,$content,array());
                                                //send_phpmail($to,$fname." ".$lname,"","",$subject,$content);
                                                $success = true;
                                                $msg = "New user added successfully";
                                            }
                                            else
                                            {
                                                $msg = "Failed!";
                                            }
                                        }
                                        else
                                        {
                                            $msg = "New user not added successfully";
                                        }
                                    }
                                    else
                                    {
                                        $msg = $cpin;
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $msg = "Enter valid Sponsor Id!";
                    }
                }
                else
                {
                    $msg = "Enter valid Parent Id!";
                }
            }
            /*else if(isset($pin_no) && empty($pin_no))
            {
            $msg = "Pin No Is Required";
            }*/
            else if (isset($parent_id) && empty($parent_id))
            {
                $msg = "Parent Id Is Required";
            }
            else
            {
                $msg = "Sponser Id Is Required";
            }
        }
        else
        {
            $qry = "UPDATE `user_id` SET `password`='$password' WHERE `uid`=$id";
            $q1 = mysqli_query($db, $qry);
            //echo $qry;
            if ($q1)
            {
                $qry1 = "UPDATE `user_detail` SET `first_name`='$fname', `last_name`='$lname', `gender`='$gender', `email`='$email', `mobile`='$mobile_no', `pan_no`='$pan_no' WHERE `uid`=$id";
                $qry2 = "UPDATE `user_id` SET `balance`='$balance' WHERE `uid`=$id";
                $q2 = mysqli_query($db, $qry1);
                $q2 = mysqli_query($db, $qry2);
                $success = true;
                $msg = "User Updated Successfully";
            }
            else
            {
                $msg = "Some Promlem Occur try after sometime";
            }
        }
    }
    else{
       $msg = "This package pin is not available.";
    }
    echo json_encode(array(
        'valid' => $success,
        'url' => $url,
        'msg' => $msg
    ));
}
/* Change password User */
if(isset($_POST['changeUserpassword']))
{
    $success = false;
    $msg = "";
    $url="";
    //print_r($_POST);
    extract($_POST); 

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    

    $q  =   mysqli_fetch_assoc( mysqli_query($db, "SELECT t1.uname,t2.`mobile` FROM `user_id` t1 join user_detail t2 on t1.uid = t2.uid WHERE t1.uid = $uid"));
    $password =  $_POST['new_password'];

    if($new_password == $confirm_password)
    {
        $query =  mysqli_query($db,"UPDATE `user_id` SET `password`= '$confirm_password' WHERE `uid` = $uid");
        if($query)
        {
           /* $message = "DSV Marketing Level New Password Login Details: Username : ".$q['uname']."password : ".$_POST['new_password'];
            sendSMS($db,$uid,$message);*/
            $success=true;
            $msg = " Password Updated successfully. ";
        }
        else
        {
            $msg =" Password Cannot be Updated. ";
        }
    }
    else
    {
        $msg = " Password is not match. ";
    }

            
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'msg'=>$msg
    ));
}
//Transfer Pin
if(isset($_POST["type"]) && $_POST["type"] == "TransferPinToUser")
{
    $success = false;
    $message = "";
    $url="";
    $mlmid = $_SESSION['mlmid'];
    $pin_id = isset($_POST['checked_id'])?$_POST['checked_id']:'';
    $uid = $_POST['sponser'];
    if(!empty($uid))
    {
        if(!empty($pin_id))
        {
           
            $x = transferpin($db,$mlmid,$uid,$pin_id);
            if($x == 1)
            {
                $success = true;
                $message = "Pin has been transfer.";
            }
            else
            {
                $message = "Some of the pin cannot be transfer.";
            }
        }
        else
        {
            $message = "Select atleast one Transaction Pin.";
        }
    }
    else
    {
        $message = "Select user to transfer.";
    }

    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}
//Update Profile
if(isset($_POST["type"]) && $_POST["type"] == "UpdateProfile_old")
{
    $success = false;
    $msg = "";
    $url="";
    extract($_POST);
    $mlmid = $_SESSION['mlmid'];
    $address=mysqli_real_escape_string($db,$_POST["address"]);
    
    $q1 = $db->query("UPDATE `user_detail` SET `first_name`=  '$first_name',`last_name`= '$last_name',`gender`= '$gender',`mobile`= '$mobile', `phone`= '$phone', `pan_no`= '$pan_no',  `state`= '$state', `city`= '$city', `zip`= '$zip', `address`= '$address', `relation`= '$relation', `country`= '$country',`beneficiary`= '$beneficiary' WHERE  uid = '$mlmid'");
    if($q1)
    {
        $q2 = $db->query("UPDATE `user_bank` SET `bank_name`= '$bank_name',`branch_name`= '$branch_name',`acnumber`= '$account_number',`bankholder`= '$holder_name',`swiftcode`= '$swift_code' where uid = '$mlmid'");
        if($q2)
        {
            $success = true;
            $msg = "Profile & Bank details Updated Successfully";
        }
        else
        {
            $msg = "Profile Updated, Bank Details cannot update";
        }
    }
    else
    {
        $msg = "Profile cannot be updated";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $msg
    ));
    
}
if(isset($_POST["type"]) && $_POST["type"] == "UpdateProfile")
{
    $success = false;
    $msg = "";
    $url="";
    extract($_POST);
    $stm_update='';
    unset($_POST['type']);
    unset($_POST['info']);
    $mlmid = isset($_SESSION['franchiseid'])?$_SESSION['franchiseid']:$_SESSION['mlmid'];
    foreach ($_POST as $key=>$val) 
    {
        $val = mysqli_real_escape_string($db,$val);
        $stm_update.="".$key."='$val',";
    }
    $stm_update=substr($stm_update, 0, -1);
    //echo "update `$info` set $stm_update where `uid`=$mlmid";
    if(isset($_SESSION['franchiseid'])){
      $query = mysqli_query($db, "update `$info` set $stm_update where `id`=$mlmid");
    }
    else{
      $query = mysqli_query($db, "update `$info` set $stm_update where `uid`=$mlmid");  
    }
    
    if ($query)
    {
        $success = true;
        $msg = "Profile Updated Successfully";
    } 
    else
    {
        $msg = "Profile cannot be updated";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $msg
    ));
}
if(isset($_POST["type"]) && $_POST["type"] == "UpdateProfile4")
{
    $success = false;
    $msg = "";
    $url="";
    $stm_update = ''; //Image
    $uploadOk = 1;
    extract($_POST);

    $mlmid = isset($_SESSION['franchiseid'])?$_SESSION['franchiseid']:$_SESSION['mlmid'];
    if (isset($_FILES['pan_card_image']) && $_FILES['pan_card_image']['name'] != "")
    {
            $target_dir = "../upload/kyc/";
            $target_file = $target_dir . basename($_FILES["pan_card_image"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $filename = uniqid() . "." . $imageFileType;
            $filepath = $target_dir . $filename;
            if ($_FILES["pan_card_image"]["size"] > 10 * MB) {
                $msg = "Sorry, Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg", "jpeg", "png");
            if (!in_array(strtolower($imageFileType), $extallowed)) {
                $msg = "Sorry,For Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            if ($uploadOk != 0) {
                if (move_uploaded_file($_FILES["pan_card_image"]["tmp_name"], $filepath)) {
                    $stm_update .= ", `pan_card_image`='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, image was not uploaded.";
                }
            }
    }
    if (isset($_FILES['adhar_card_image_front']) && $_FILES['adhar_card_image_front']['name'] != "")
    {
            $target_dir = "../upload/kyc/";
            $target_file = $target_dir . basename($_FILES["adhar_card_image_front"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $filename = uniqid() . "." . $imageFileType;
            $filepath = $target_dir . $filename;
            if ($_FILES["adhar_card_image_front"]["size"] > 10 * MB) {
                $msg = "Sorry, Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg", "jpeg", "png");
            if (!in_array(strtolower($imageFileType), $extallowed)) {
                $msg = "Sorry,For Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            if ($uploadOk != 0) {
                if (move_uploaded_file($_FILES["adhar_card_image_front"]["tmp_name"], $filepath)) {
                    $stm_update .= ", `adhar_card_image_front`='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, image was not uploaded.";
                }
            }
    }
    if (isset($_FILES['adhar_card_image_back']) && $_FILES['adhar_card_image_back']['name'] != "")
    {
            $target_dir = "../upload/kyc/";
            $target_file = $target_dir . basename($_FILES["adhar_card_image_back"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $filename = uniqid() . "." . $imageFileType;
            $filepath = $target_dir . $filename;
            if ($_FILES["adhar_card_image_back"]["size"] > 10 * MB) {
                $msg = "Sorry, Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg", "jpeg", "png");
            if (!in_array(strtolower($imageFileType), $extallowed)) {
                $msg = "Sorry,For Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            if ($uploadOk != 0) {
                if (move_uploaded_file($_FILES["adhar_card_image_back"]["tmp_name"], $filepath)) {
                    $stm_update .= ", `adhar_card_image_back`='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, image was not uploaded.";
                }
            }
    }
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
    {
            $target_dir = "../upload/kyc/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $filename = uniqid() . "." . $imageFileType;
            $filepath = $target_dir . $filename;
            if ($_FILES["image"]["size"] > 10 * MB) {
                $msg = "Sorry, Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg", "jpeg", "png");
            if (!in_array(strtolower($imageFileType), $extallowed)) {
                $msg = "Sorry,For Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            if ($uploadOk != 0) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
                    $stm_update .= ", `image`='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, image was not uploaded.";
                }
            }
    }
        if($uploadOk == 1)
        {
            //echo "UPDATE `user_bank` SET uid = '$mlmid'$stm_update where uid = '$mlmid'";
           if(isset($_SESSION['franchiseid'])){
             $q2 = $db->query("UPDATE `franchise` SET id = '$mlmid'$stm_update where id = '$mlmid'");
           }
           else{
             $q2 = $db->query("UPDATE `user_bank` SET uid = '$mlmid'$stm_update where uid = '$mlmid'");
           }
            
            if($q2)
            {
                $success = true;
                $msg = "KYC Updated Successfully";
            }
            else
            {
                $msg = "KYC Details cannot update";
            }
        }
        else
        {
            $msg = "Failed!";
        }
    echo json_encode(array(
        "success"=>$success,
        "message" => $msg
    ));
}
/*
 * Repurchase plan
 */
if(isset($_POST["type"]) && $_POST["type"] == "PlanPurchase")
{
    $success = false;
    $message = "";
    $plan_id = $_POST['plan_id'];
    $mlmid = $_SESSION['mlmid'];
    $amount = $_POST['amount'];
    if(isset($plan_id) && !empty($plan_id) && isset($mlmid) && !empty($mlmid))
    {
        $plans=mysqli_fetch_assoc(mysqli_query($db,"select * from rplans where plan_id='$plan_id'"));
        $amount=$plans['plan_amount'];
        $sql="INSERT INTO `purchase` SET `plan_id`='$plan_id',`amount`='$amount',`uid`='$mlmid',`date`='$cdate'";
        $qry = mysqli_query($db,$sql) or die(mysqli_error($db));
        if($qry)
        {
            //RepurchaseDownline($db,$mlmid);
            $success = true;
            $message = "Plan Purchased Successfully";
        }
        else
        {
            $message = "Some Problem Occur, While Purchasing.";

        }
    }
    else
    {
        $message = "Some Problem Occur, While Purchasing.";

    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}

//Request Pin
if(isset($_POST["type"]) && $_POST["type"] == "ManageRequestPin")
{
    $success = false;
    $message = "";
    $url="";
    $mlmid = $_SESSION['mlmid'];
    $no_of_pin = isset($_POST['no_of_pin'])?$_POST['no_of_pin']:'';
    $plan_id = isset($_POST['plan_id'])?$_POST['plan_id']:'';
    if(!empty($plan_id))
    {
        if(!empty($no_of_pin))
        {
            $sql="INSERT INTO `reqpin` SET `plan_id`='$plan_id',`no_of_pin`='$no_of_pin',`uid`='$mlmid',`date`='$cdate'";
            $qry = mysqli_query($db,$sql) or die(mysqli_error($db));
            if($qry)
            {
                $success = true;
                $message = "Pin Request has been sent.";
            }
            else
            {
                $message = "Some Problem Occur while sending request.";
            }
        }
        else
        {
            $message = "Enter Number of Transaction Pin.";
        }
    }
    else
    {
        $message = "Select Plan to request pin.";
    }

    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}

if(isset($_POST["type"]) && $_POST["type"] == "deleteRequest")
{
    $success = false;
    $message = "";
    $req_id = $_POST['req_id'];
    $delrecord = mysqli_query($db,"DELETE FROM reqpin WHERE id = '$req_id'");
    //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
    if($delrecord)
    {
        $success = true;
        $message = "Request Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";

    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}
/*
 * Repurchase plan
 */
/*if(isset($_POST["type"]) && $_POST["type"] == "ProductPurchase")
{
    $success = false;
    $message = "";
    $product_id = $_POST['product_id'];
    $mlmid = $_SESSION['mlmid'];
    $price1 = $_POST['price'];
    $qty = $_POST['qty'];
    if(isset($product_id) && !empty($product_id) && isset($mlmid) && !empty($mlmid))
    {
        $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `products` where product_id='$product_id'"));
        $price=$r1['mrp'];
        $bv=$r1['bv'];
        $sql="INSERT INTO `product_purchase` SET `product_id`='$product_id',`price`='$price',`bv`='$bv',`qty`='$qty',`uid`='$mlmid',`date`='$cdate'";
        $qry = mysqli_query($db,$sql) or die(mysqli_error($db));
        if($qry)
        {
            $success = true;
            $message = "Product Purchased Successfully";
        }
        else
        {
            $message = "Some Problem Occur, While Purchasing.";

        }
    }
    else
    {
        $message = "Some Problem Occur, While Purchasing.";

    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}*/
//Transfer Pin
if(isset($_POST["type"]) && $_POST["type"] == "ManageTransPin")
{
    $success = false;
    $message = "";
    $url="";
    $plan_id = $_POST["plan_id"];
    $no_of_pin = $_POST["no_of_pin"];
    $uid = $_POST["sponser"];
    $mlmid = $_SESSION['mlmid'];
    $x = addtransferpin($db,$mlmid,$uid,$plan_id,$no_of_pin);
    if($x == 1)
    {
        $success = true;
        $message = "Pin has been transfer.";
    }
    else
    {
        $message = "Some of the pin cannot be transfer.";
    }

    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}


// **************************************  ACTIVATE BINARY ******************************


if(isset($_POST["type"]) && $_POST["type"] == "activatebinary")
{
    $success = false;
    $message = "";
   
    $mlmid = $_SESSION['mlmid'];

    
 $result=mysqli_query($db,"UPDATE user_id SET binary_activated =0 , binary_date = '$cdate' WHERE uid='".$mlmid."' ") or die (mysqli_error($db));

    if($result){

        $success = true;
        $message = "Request Successfully Sent";
    }
    else
    {
        $message = "Some Problem Occur, While Sending Request.";

    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
    exit;

}

if(isset($_POST["type"]) && $_POST["type"] == "ReqUpgradePlan")
{
    $success = false;
    $message = "";
    extract($_POST);
    $mlmid = $_SESSION['mlmid'];

    $q1=mysqli_query($db,"SELECT * from `reqplan` where uid ='$mlmid' AND plan_id ='$plan_id' AND (status=0 or status=1)");
    if(mysqli_num_rows($q1) > 0)
    {
        $message = "Request Already Sent";
    }
    else
    {
        $result=mysqli_query($db,"INSERT INTO `reqplan` SET uid ='$mlmid' ,plan_id ='$plan_id' , date = '$cdate'") or die (mysqli_error($db));
        if($result)
        {
            $success = true;
            $message = "Request Successfully Sent";
        }
        else
        {
            $message = "Some Problem Occur, While Sending Request.";
        }
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}



if(isset($_POST["type"]) && $_POST["type"] == "RequestForWithdraw")
{
    $success = false;
    $message = "";
    $mlmid = $_SESSION['mlmid'];
    $sql1 = mysqli_query($db,"SELECT (comission_amount+bonus_amount+roi_amount) as payout_of_today FROM payout WHERE uid='$mlmid' AND cleared!='1'") or die(mysqli_error($db));
    $row1 = mysqli_fetch_assoc($sql1);
    $payout_of_today = $row1['payout_of_today'];
    $admin_charge = 5;
    $tds_charge = 5;

    $total_payout_after_admin_charge = ($payout_of_today*$admin_charge)/100;
    $total_payout_after_tds_charge = ($payout_of_today*$tds_charge)/100;
    $total_deduction = $total_payout_after_admin_charge+$total_payout_after_tds_charge;
    $payout_of_today = $payout_of_today-$total_deduction;

    $sql2 = mysqli_query($db,"SELECT IFNULL(sum(payout_amount),0) as already_requested_amount FROM withdraw_request WHERE uid='$mlmid' AND status='0'") or die(mysqli_error($db));
    $row2 = mysqli_fetch_assoc($sql2);
    $already_requested_amount = $row2['already_requested_amount'];
    $payout_of_today = $payout_of_today-$already_requested_amount;
    // echo $payout_of_today.' '.$already_requested_amount;die;
    if($payout_of_today>500){
        $sql3 = "INSERT INTO withdraw_request(`uid`,`payout_amount`,`requested_date`) VALUES('$mlmid','$payout_of_today','$cdate')";
        $query3 = mysqli_query($db,$sql3) or die(mysqli_error($db));
        if($query3){
            $success = true;
            $message = "Request submitted successfully";
        }
        else{
            $message = "Problem occure while submitting request";
        }
    }
    else{
        $message = 'Payout amount must be greater than 500 Rs';
    }

    echo json_encode(array(
        "success"=>$success,
        "message"=>$message
    ));
}

if(isset($_POST['type']) && $_POST['type'] == 'SubmitPinVerify'){
    $success = false;
    $message = "";

    if(isset($_POST['pin_no']) && !empty($_POST['pin_no'])){
        $pin_no = $_POST['pin_no'];
        $uid = $_SESSION['mlmid'];
        $cpin=checkTransPin($db,$pin_no);
        if($cpin==1)
        {   
            $query1 = mysqli_query($db,"SELECT 
                                        t2.parent_id,
                                        t2.sponsor_id 
                                        FROM user_id t1 
                                        INNER JOIN pairing t2 ON t2.uid = t1.uid 
                                        WHERE t1.uid='$uid'") or die(mysqli_error($db));
            $row1 = mysqli_fetch_assoc($query1);
            $sponsor_id = $row1['sponsor_id'];
            $parent_id = $row1['parent_id'];



            $sql2 = "UPDATE user_id SET pin='$pin_no' WHERE uid='$uid'";
            $query2 = mysqli_query($db,$sql2) or die(mysqli_error($db));

            $query3 = mysqli_query($db,"UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'") or die(mysqli_error($db));
            UserPairing($db,$uid,$parent_id,$sponsor_id);
            $success = true;
            $message = "Pin assigned successfully";
        }
        else{
            $message = "Incorrect Pin Number";
        }
    }
    else{
        $message = "Enter Pin Number";
    }

    echo json_encode(array(
        "success"=>$success,
        "message"=>$message
    ));
}
if(isset($_POST['type']) && $_POST['type'] == 'ChecktPassword')
{
    $success = false;
    $message = "";
    $uid    = isset($_POST['uid'])?$_POST['uid']:'';
    $password    = isset($_POST['password'])?$_POST['password']:'';

    if(isset($uid) && !empty($uid) && isset($password) && !empty($password))
    {
        $r1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid='$uid'"));
        //echo $r1['password'];
        if ($password==$r1['tpassword'])
        {
            $success=true;
        }
        else
        {
            $message = "Incorrect Password!";
        }
        
    }
    else
    {
        $message = "Enter Password.";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "UpgradeTopup")
{
    $success = false;
    $msg = "";
    $url="";
    $date1=date("Y-m-d H:i:s");
    extract($_POST);
    
        
        if(isset($pin_no) && !empty($pin_no) && isset($uid) && !empty($uid))
        {

             $newq=mysqli_query($db,"SELECT t2.plan_amount FROM transpin t1 left join plans t2 on t1.plan_id=t2.plan_id WHERE t1.pin_code = '$pin_no' and uid IS NULL and status=0");
            if(mysqli_num_rows($newq) > 0)
            {
                $newdata=mysqli_fetch_assoc($newq);
                $newplan_amount=$newdata['plan_amount'];
                $oldq=mysqli_query($db,"SELECT t2.plan_amount FROM transpin t1 left join plans t2 on t1.plan_id=t2.plan_id WHERE t1.uid = '$uid'");
                $olddata=mysqli_fetch_assoc($oldq);
                $oldplan_amount=$olddata['plan_amount'];
                if($newplan_amount > $oldplan_amount)
                {
                    $res=UpgradeUserPin($db,$uid,$pin_no);
                    if($res==true)
                    {
                        $success = true;
                        $msg = "Plan Upgraded Successfully";
                    }
                    else
                    {
                         $msg = "No Pin Assigned Ti the User";
                    }
                }
                else
                {
                    $msg = "Enter Valid Pin,Select PIN For Greater Plan";
                }
            }
            else
            {
                 $msg = "Enter Valid Pin";
            }
        }
        else
        {
            $msg = "Some Problem Occur, While Sending Request.";
        }
    
    echo json_encode(array(
        "valid"=>$success,
        "message" => $msg
    ));
}


/*********************************  Purchase producr ************************************/

//Serch product

if(isset($_POST['ProductFetch']) && !empty($_POST['ProductFetch'])) {

    $success = false;
    $data = $prate = '';
    $msg = 'Type something to search';
    $string = $ratecolumn = '';
    $cat_id = $_POST['cat_id'];
    
    
    //$qry="SELECT DISTINCT * FROM `products` WHERE  name LIKE '$q%'";
    $qry="SELECT DISTINCT * FROM `products` WHERE cat_id='$cat_id' ";
    //echo $qry;
    $product = mysqli_query($db,$qry);
    $data = array();
    while($row = mysqli_fetch_assoc($product))
    {
        $name=$row['name']." [MRP - ".$row['mrp']." / BV - ".$row['bv']."]";
        $data[] = array(
            "id"=> $row['product_id'],
            "name"=> $name,
            );
    }
    //print_r($prate);
    if ($data){
        $msg= "Your search result";
        $success = true;
    }
    echo json_encode(array(
        'data'=>$data,
        'valid'=>$success,
        'msg'=>$msg
    ));

}

//Product Order paid
if(isset($_POST["type"]) && $_POST["type"] == "PaidProductOrders")
{
    $success = false;
    $message = "";
    $url="";
    $id = $_POST['id'];
    $q2 = mysqli_query($db,"UPDATE `product_purchase` SET `cleared`= 1,`cleared_date`= '$cdate' WHERE `id` = $id");
    if($q2)
    {
        $success = true;
        $message = "Payment has been cleared";
    }
    else
    {
        $message = "Some Problem Occure, payment did not clear";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}
//add Ordre
if(isset($_POST["type"]) && $_POST["type"]== 'AddOrder')
{
    $success = false;
    $msg = "";
    $url="";      
    $lid="";      
    extract($_POST);
    $status=0;    
    $mlmid = $_SESSION['mlmid'];
    $price=0;
    $bv=0;
    foreach ($products as $key => $value) {
        $pid=$value['name'];
        $r=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `products` WHERE product_id='$value[name]'"));
        $total=isset($value['qty']) && isset($r['mrp'])?$value['qty']*$r['mrp']:0;
        $total1=isset($value['qty']) && isset($r['bv'])?$value['qty']*$r['bv']:0;
        $price=$price+$total;
        $bv=$bv+$total1;
    }
    $product=json_encode($products , true);
        if($txtid=='')
        {
            $sql="INSERT INTO `product_purchase` SET `cat_id`='$cat_id',`product`='$product',`price`='$price',`bv`='$bv',`uid`='$mlmid',`date`='$cdate'";
            $q1=mysqli_query($db,$sql);
            if($q1)
            {
                $success = true;
                $msg= "Order Generated successfully";
                $lid=mysqli_insert_id($db);
            }
            else{
                $msg= "Failed";
            }
        }else{
            $msg= "Some Problem Occure , Try After Sometime.";
        }
        
            
     echo json_encode(array(
        'id'=>$lid,
        'valid'=>$success,
        'url'=>$url,
        'msg'=>$msg
    ));
}

//delete Order
if(isset($_POST["type"]) && $_POST["type"] == "DeleteOrder")
{
    $id = $_POST['id'];
    
    
    $delrecord = mysqli_query($db,"DELETE FROM product_purchase WHERE id = '$id'");
    if($delrecord)
    {
        echo json_encode(array(
            "valid"=>true,
            "message" => "Order Deleted successfully"
        ));
    }
    else
    {
        echo json_encode(array(
            "valid"=>false,
            "message" => "Some Problem Occur, While Deleting."
        ));
    }

}
if(isset($_POST["type"]) && $_POST["type"] == "ManagePaymentDetails")
{
    $success = false;
    $message = "";
    $uploadOk = 1;
    $stm_update="";
    extract($_POST);
    unset($_POST['type']);
    unset($_POST['purchase_id']);
    $_POST['cleared_date']=$cdate;
    $_POST['cleared']=1;
    foreach ($_POST as $key=>$val){
        $stm_update.="".$key."='$val',";
    }
    $stm_update=substr($stm_update, 0, -1);
    
        if(isset($_FILES['image']) && $_FILES['image']['name'] != "")
        {
            $target_dir = "../upload/payment/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($_FILES["image"]["size"] > 10*MB) {
                $msg=  "Sorry, your Logo Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg","jpeg","png");
            if (!in_array(strtolower($imageFileType),$extallowed)){
                $msg = "Sorry,For Logo Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            $filename=uniqid().".".$imageFileType;
            $filepath=$target_dir.$filename;
            if ($uploadOk != 0)
            {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
                {
                    $stm_update.=",image='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, your file was not uploaded.";
                }
            }
        }
        if ($uploadOk == 0) {
            $success=false;
        }
        else
        {
            //echo "UPDATE `product_purchase` SET $stm_update WHERE `id`=$purchase_id";
            $query = mysqli_query($db, "UPDATE `product_purchase` SET $stm_update WHERE `id`=$purchase_id") or die(mysqli_error($db));
            if ($query) {
                $msg = "Detail Updated Sucessfully";
                $success = true;
            } else {
                $msg = "Detail Not Updated";
            }
        }
    
    echo json_encode(array(
        'success'=>$success,
        'msg'=>$msg
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "ManageBalReq")
{
    $success = false;
    $message = "";
    $uploadOk = 1;
    $stm_update="";
    extract($_POST);
    unset($_POST['type']);
    unset($_POST['req_id']);
    $_POST['uid']=$_SESSION['mlmid'];
    $_POST['date']=date("Y-m-d H:i:s");
    foreach ($_POST as $key=>$val){
        $stm_update.="".$key."='$val',";
    }
    $stm_update=substr($stm_update, 0, -1);
    if(isset($amount) && $amount > 0)
    {
        if(isset($_FILES['image']) && $_FILES['image']['name'] != "")
        {
            $target_dir = "../upload/payment/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($_FILES["image"]["size"] > 10*MB) {
                $msg=  "Sorry, your Logo Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg","jpeg","png");
            if (!in_array(strtolower($imageFileType),$extallowed)){
                $msg = "Sorry,For Logo Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            $filename=uniqid().".".$imageFileType;
            $filepath=$target_dir.$filename;
            if ($uploadOk != 0)
            {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
                {
                    $stm_update.=",image='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, your file was not uploaded.";
                }
            }
        }
        if ($uploadOk == 0) {
            $success=false;
        }
        else
        {
            //echo "UPDATE `product_purchase` SET $stm_update WHERE `id`=$purchase_id";
            if(isset($_FILES['image']) && $_FILES['image']['name'] != "")
            {
                $query = mysqli_query($db, "INSERT INTO `bal_req` SET $stm_update ") or die(mysqli_error($db));
                if ($query) {
                    $msg = "Request Added Sucessfully";
                    $success = true;
                } else {
                    $msg = "Request Not Added";
                }
            } else {
                $msg = "Receipt image is required!";
            }
        }
    } else 
    {
        $msg = "Please Enter Amount";
    }
    
    echo json_encode(array(
        'success'=>$success,
        'msg'=>$msg
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "DeleteWBReq")
{
    $success = false;
    $message = "";
    $req_id = $_POST['req_id'];
    $delrecord = mysqli_query($db,"DELETE FROM bal_req WHERE req_id = '$req_id'");
    if($delrecord)
    {
        $success = true;
        $message = "Request Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";

    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}


if(isset($_POST["type"]) && $_POST["type"] == "ManageFBalReq")
{
    $success = false;
    $message = "";
    $uploadOk = 1;
    $stm_update="";
    extract($_POST);
    unset($_POST['type']);
    unset($_POST['req_id']);
    $_POST['fid']=$_SESSION['franchiseid'];
    $_POST['date']=date("Y-m-d H:i:s");
    foreach ($_POST as $key=>$val){
        $stm_update.="".$key."='$val',";
    }
    $stm_update=substr($stm_update, 0, -1);
    if(isset($amount) && $amount > 0)
    {
        if(isset($_FILES['image']) && $_FILES['image']['name'] != "")
        {
            $target_dir = "../upload/payment/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($_FILES["image"]["size"] > 10*MB) {
                $msg=  "Sorry, your Logo Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg","jpeg","png");
            if (!in_array(strtolower($imageFileType),$extallowed)){
                $msg = "Sorry,For Logo Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            $filename=uniqid().".".$imageFileType;
            $filepath=$target_dir.$filename;
            if ($uploadOk != 0)
            {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
                {
                    $stm_update.=",image='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, your file was not uploaded.";
                }
            }
        }
        if ($uploadOk == 0) {
            $success=false;
        }
        else
        {
            //echo "UPDATE `product_purchase` SET $stm_update WHERE `id`=$purchase_id";
            if(isset($_FILES['image']) && $_FILES['image']['name'] != "")
            {
                $query = mysqli_query($db, "INSERT INTO `fbal_req` SET $stm_update ") or die(mysqli_error($db));
                if ($query) {
                    $msg = "Request Added Sucessfully";
                    $success = true;
                } else {
                    $msg = "Request Not Added";
                }
            } else {
                $msg = "Receipt image is required!";
            }
        }
    } else 
    {
        $msg = "Please Enter Amount";
    }
    
    echo json_encode(array(
        'success'=>$success,
        'msg'=>$msg
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "DeleteFWBReq")
{
    $success = false;
    $message = "";
    $req_id = $_POST['req_id'];
    $delrecord = mysqli_query($db,"DELETE FROM fbal_req WHERE req_id = '$req_id'");
    if($delrecord)
    {
        $success = true;
        $message = "Request Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";

    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));

}


if(isset($_POST["type"]) && $_POST["type"] == "DispatchOrder")
{
    $success = false;
    $message = "";
    $date=date("Y-m-d H:i:s");
    $order_id = $_POST['order_id'];
    $c1=mysqli_query($db,"SELECT fid,amount FROM `checkout` WHERE id = '$order_id' and status=0");
    $chk=mysqli_num_rows($c1);
    if($chk > 0)
    {
        $q1 = mysqli_query($db,"UPDATE checkout SET status=1,sdate='$date' WHERE id = '$order_id'");
        if($q1)
        {
            $d1=mysqli_fetch_assoc($c1);
            $fid=$d1['fid'];
            $balance=$d1['amount'];
           // echo "UPDATE franchise SET balance=balance+$balance WHERE id='$fid' ";
            mysqli_query($db,"UPDATE franchise SET balance=balance+$balance WHERE id='$fid'");
            $success = true;
            $message = "Order Dispatched Successfully";
        }
        else
        {
            $message = "Some Problem Occur, While Processing.";
        }
    }
    else
    {
        $message = "Order is already dispatched";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}