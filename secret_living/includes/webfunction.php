<?php
session_start();
header('Content-type: text/plain; charset=utf-8');
//error_reporting(E_ERROR | E_PARSE);
//Start Session

//Include database
include '../db_config.php';
$cdate=date("Y-m-d H:i");
$imageurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$imageurl = str_replace("includes/webfunction","assets/images/cars/logo.png",$imageurl);
if(isset($_POST["type"]) && $_POST["type"] == "Subscribe")
{
    $success = false;
    $message = "";
    $name  = $_POST["name"];
    $email  = $_POST["email"];
    $q3 = mysqli_query($db,"SELECT * FROM `subscriber` WHERE `subscriber_email` = '$email'");
    if(mysqli_num_rows($q3)<1)
    {
        $q4 = mysqli_query($db,"INSERT INTO `subscriber`(`name`,`subscriber_email`) VALUES ('$name','$email')");
        if($q4)
        {
            $success = true;
            $message = "You have been subscribed to the newsletter";
        }
        else
        {
            $message = "Subscribe after few days";
        }
    }
    else
    {
        $message = "You have been already subscribe to our newsletter";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}
if(isset($_POST["type"]) && $_POST["type"] == "ContactSend1")
{
    $success = false;
    $message = "";
    $name  = $_POST["name"];
    $email  = $_POST["email"];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $body = mysqli_escape_string($db,$_POST['message']);
    $q4 = mysqli_query($db,"INSERT INTO `contact_form`(`contact_name`, `contact_email`, `contact_phone`, `contact_subject`, `contact_message`,`date`) VALUES ('$name','$email','$phone','$subject','$body',now())");
    if($q4)
    {
        $success = true;
        $subject = "$webtitle Contact : ".$subject;
        $body = "Name : $name <br> Email : $email <br> Contact : $phone<br>
        ".$body."
        <p>Thank You</p>
        <img alt=\"$webname\" border=\"0\" width=\"250\" style=\"display:block\"  src=\"cid:logo_2u\"><br>";
        //send_mail( $to, $from, $subject, $body );
        send_phpmail('', '', "", "", $subject, $body);
        $message = "Thank You contacting us, we will contact you in few days";
    }
    else
    {
        $message = "Server Busy try after sometime";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}
/*
 * Get state List
 */
if(isset($_POST['type']) && $_POST['type']=="GetState")
{
    $country=$_POST['id'];
    $success=false;
    $msg="";
    $data=array();
    if(isset($country) && !empty($country))
    {
        $result = mysqli_query($db, "SELECT DISTINCT(`name`) as name FROM `state` where `country` = '$country' order by name asc");
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $data[]=$row;
            }
            $msg="";
            $success=true;
        }else{
            $msg="no result found!";
            $success=false;
        }
    }else{
        $msg="Country is required!";
        $success=false;
    }
    echo json_encode(array(
        'success'=>$success,
        'msg'=>$msg,
        'data'=>$data
    ));
}

// Login Affliate
if(isset($_POST["type"]) && $_POST["type"] == "AffiliateLogin")
{
    $success = false;
    $message = "";
    $url="";
    $status=0;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($db,"select * from user_id where uname = '$username'");
    $q = mysqli_num_rows($query);
    if($q>0)
    {
        $row = mysqli_fetch_assoc($query);
        $status=$row['status'];
        if($row['is_active'] == 1){
           $message = "Your Are Blocked";
        }
        else
        {
            if($row['status'] == 1 || $row['status'] == 2)
            {
                if ($password == $row['password'])
                {
                    $_SESSION['mlmid'] = $row['uid'];
                    $_SESSION['mlmusername'] = $username;
                    $_SESSION['mlmrole'] = $row['role'];
                    $_SESSION['mlmstatus'] = $row['status'];
                    $role = $row['role'];
                    $url=$role;
                    
                     if(isset($_POST['rurl']) && !empty($_POST['rurl']))
                    {
                        $url=$_POST['rurl'];
                        $id = $row['uid'];
                        $ip = get_userip();
                        mysqli_query($db,"update cart set uid='$id' where ip='$ip' and uid='0' and fid='0'");
                        updateCartAfterLogin($db,$row['uid']);
                    }
                    else
                    {
                        $id = $row['uid'];
                        $ip = get_userip();
                        mysqli_query($db,"update cart set uid='$id' where ip='$ip' and uid='0' and fid='0'");
                    }
                    

                    $success = true;
                    $message = "Logged in successfully";
                }
                else
                {
                    $message = "Password Does Not Match Username";
                }
            }
            else if($row['status'] == 2)
            {
                if ($password == $row['password'])
                {
                    $_SESSION['mlmstatus'] = $row['status'];
                    $_SESSION['mlmusername'] = $username;
                    $url = $row['role'];
                    
                    $success = true;
                    $message = "Logged in successfully";
                }
                else
                {
                    $message = "Password Does Not Match Username";
                }
            }
            else
            {
                $message = "Account not active contact administrator";
            }
        }
    }
    else
    {
        $message = "User is not registered";
    }

    echo json_encode(array(
        "success"=>$success,
        "message" => $message,
        "status" => $status,
        "url"=>$url
    ));
}
// Login Affliate
if(isset($_POST["type"]) && $_POST["type"] == "FranchiseLogin")
{
    $success = false;
    $message = "";
    $url="";
    $status=0;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($db,"select * from franchise where uname = '$username'");
    $q = mysqli_num_rows($query);
    if($q>0)
    {
        $row = mysqli_fetch_assoc($query);
        if ($password == $row['password'])
        {
            $_SESSION['franchiseid'] = $row['id'];
            $_SESSION['franchiseusername'] = $username;
            $url='index';
            if(isset($_POST['rurl']) && !empty($_POST['rurl']))
            {
                $url=$_POST['rurl'];
                if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
                {
                    $uid=$_SESSION['mlmid'];
                    
                    $id = $row['id'];
                    $ip = get_userip();
                    mysqli_query($db,"update cart set uid='$id' where ip='$ip' and uid='0' and fid='0' and transaction_id IS null");
                    updateCartAfterLogin($db,$uid);
                }
                else 
                {
                    $id = $row['id'];
                    $ip = get_userip();
                    //echo "update cart set fid='$id' where ip='$ip' and uid='0' and fid='0'";
                    
                    mysqli_query($db,"update cart set fid='$id' where ip='$ip' and uid='0' and fid='0' and transaction_id IS null");
                }
            }
            $id = $row['id'];
            $ip = get_userip();
            mysqli_query($db,"update cart set fid='$id' where ip='$ip' and uid='0' and fid='0' and transaction_id IS null");

            $success = true;
            $message = "Logged in successfully";
        }
        else
        {
            $message = "Password Does Not Match Username";
        }
        
    }
    else
    {
        $message = "User is not registered";
    }

    echo json_encode(array(
        "success"=>$success,
        "message" => $message,
        "status" => $status,
        "url"=>$url
    ));
}
if(isset($_POST["type"]) && $_POST["type"] == "ActivateUserStatus")
{
    $success = false;
    $message = "";
    $url="";
    $status=0;
    $pin_no=$_POST['pin_no'];
    if($_SESSION['mlmstatus'] == 2)
    {
        $username=$_SESSION['mlmusername'];
        $q11=mysqli_query($db,"select * from user_id where uname='$username'");
        $row=mysqli_fetch_assoc($q11);
        $uid=$row['uid'];
        $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
        $q8 = $db->query("UPDATE `user_id` SET `pin`='$pin_no',status='1' WHERE uid='$uid'");
        ActivateUser($db,$uid,$pin_no);
        $_SESSION['mlmid'] = $row['uid'];
        $_SESSION['mlmrole'] = $row['role'];
        $_SESSION['mlmstatus'] =1;
        $url = "".$row['role'];
        $success = true;
        $message = "Your Account Is Activated Successfully";
    }
    
    else
    {
        $message = "User Is Not Registered Or Your Account Is Activated";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message,
        "url"=>$url
    ));
}
/*if(isset($_POST["type"]) && $_POST["type"] == "ForgotUserPass")
{
    $success = false;
    $message = "";
    $url="";
    $username = $_POST['username'];
    $query = $db->query("select * from user_id where uname = '$username' and status = 1");
    $q = $query->num_rows;
    if($q>0)
    {
        $data = mysqli_fetch_assoc($query);
        $userid = $data['uid'];
        $tokentime = strtotime(date('Y-m-d H:i:s', strtotime('+1 day', time())));
        $token = encrypt_decrypt('encrypt',$userid."_".$tokentime);
        $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $loginurl = str_replace("includes/webfunction","reset?token=$token",$loginurl);
        ini_set("SMTP", "smtpout.secureserver.net");//confirm smtp
        $to = $username;
        $from = "";
        $subject = "$webtitle - Password Reset Link";
        $body="
            <b style='text-transform:capitalize;'>Dear ".$username.", </b>
            <br>
           <p> Please <a href='$loginurl'> Click Here To Reset Password</a>, Link is valid for 24 hours </a></p>
            <br>
            <p>Thank You</p>
            <br>
        ";
        sendSMS($db,$userid,$body);
        //send_mail( $to, $from, $subject, $body );
        //send_phpmail( $data['first_name']." ".$data['last_name'], $to ,"", "" , $subject, $body );
        $success = true;
        $message = "A SMS has been Sent to Reset Password";
    }
    else
    {
        $message = "User is not Registered";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}*/
if(isset($_POST["type"]) && $_POST["type"] == "ForgotUserPass")
{
    $success = false;
    $message = "";
    $url="";
    $username = $_POST['username'];
    $query = $db->query("select * from user_id where uname = '$username' and status = 1");
    $q = $query->num_rows;
    if($q>0)
    {
        $data = mysqli_fetch_assoc($query);
        $userid = $data['uid'];
        $uname = $data['uname'];
        $password = $data['password'];
        $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $loginurl = str_replace("includes/webfunction","member",$loginurl);
        //$message1 = "Global Rich Marketing\n\n  Login Details: \n Username : $uname \n password : $password \n <a href='$loginurl'>Click Here To Login</a>";
        $message1 = "Frentic Retail & Marketing Pvt. Ltd.\n\n  Login Details: \n Username : $uname \n password : $password \n Click Here To Login : $loginurl";
        $res=sendSMS($db,$userid,$message1);
        $success = true;
        $message = "A SMS has been Sent to your Registered Number";
    }
    else
    {
        $message = "User is not Registered";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}
// Set Password Merchant
if(isset($_POST["type"]) && $_POST["type"] == "SetNewPassword")
{
    $success = false;
    $message = "";
    $url="";
    $redirect="login";
    $userid = $_POST['uid'];
    $password = $_POST['new_password'];
    $cpassword = $_POST['confirm_password'];
    if($password == $cpassword)
    {
        $query = mysqli_query($db,"SELECT t1.*,t2.email,t2.first_name,t2.last_name FROM `user_id` t1 left join user_detail t2 on t1.uid=t2.uid where t1.uid = '$userid'");
        $q = mysqli_num_rows($query);
        if($q>0)
        {
            $data = mysqli_fetch_assoc($query);
            //var_dump($data);die;
            //$e_password = encrypt_password($password);
            $q2 = mysqli_query($db,"UPDATE `user_id` SET `password` = '$password' where uid = '$userid'");
            if($q2)
            {
                $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $loginurl = str_replace("includes/webfunction",$redirect,$loginurl);
                ini_set("SMTP", "smtpout.secureserver.net");//confirm smtp
                $to = $data['email'];
                $from = "";
                $subject = "$webtitle - Password has been Reset";
                $body="
                <b style='text-transform:capitalize;'>Dear ".$data['first_name']." ".$data['last_name'].", </b>
                <br>
                <p> Your account password has been successfully reset .</p>
                <p> Username : $to</p>
                <p> Please <a href='$loginurl'> click here to login </a></p>
                <br>
                <p>Thank You</p>
                <img alt=\"$webname\" border=\"0\" width=\"250\" style=\"display:block\"  src=\"cid:logo_2u\"><br>
            ";
                //send_mail( $to, $from, $subject, $body );
                send_phpmail( $data['first_name']." ".$data['last_name'], $to ,"", "" , $subject, $body );
                $success = true;
                $message = "Password has been reset";
            }
            else
            {
                $message = "Server Busy try after sometime.";
            }
        }
        else
        {
            $message = "User is not registered";
        }
    }
    else
    {
        $message = "Password Mismatch";
    }
    echo json_encode(array(
        "success"=>$success,
        "url"=>$redirect,
        "message" => $message
    ));
}
/* add / Edit User */
if(isset($_POST["ajax_register_vk"]))
{
    $success = false;
    $msg = "";
    $url="";
    //print_r($_POST);
    extract($_POST);
    //$parent_id=$sponser;
    if(!isset($pin_no) || empty($pin_no)){
        $pin=addnewzeropin($db,1,1);
        $p=mysqli_fetch_assoc(mysqli_query($db,"SELECT plan_id FROM plans  WHERE plan_amount=0 limit 1"));
        $plan_id=$p['plan_id'];
        $pin_no=addnewzeropin($db,$plan_id,1);
        
    }
    if(isset($parent_id) && !empty($parent_id) && isset($sponsor_id) && !empty($sponsor_id))
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
                    $msg = "You can not add User under this parent.";
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
                        //echo $parent_id;
                        $cpin=checkTransPin($db,$pin_no);
                        if($cpin==1)
                        {   
                            $qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`,`paired`, `pin`) VALUES ('$username','$password',now(),now(),'$paired','$pin_no')";
                            $q=mysqli_query($db,$qry);
                            if($q)
                            {
                                $uid=mysqli_insert_id($db);
                                $qry1="Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
                                $q1=mysqli_query($db,$qry1);
                                if($q)
                                {
                                    
                                   $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                   UserPairing($db,$uid,$parent_id,$sponsor_id);
                                    $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    $url = str_replace("includes/adminfunction","member",$loginurl);
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
                                    //$fpay=FirstRegisterPayment($db,$uid,$pay_parent_id,$is_sponsor);
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
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'message'=>$msg
    ));
}
/* add / Edit User */
if(isset($_POST["ajax_register_with_parent_id"]))
{
    $success = false;
    $msg = "";
    $url="";
    //print_r($_POST);
    extract($_POST);
    //$parent_id=$sponser;
    if(isset($parent_id) && !empty($parent_id) && isset($sponsor_id) && !empty($sponsor_id))
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
                    $msg = "You can not add User under this parent.";
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
                            //echo $parent_id;
                            /*$cpin=checkTransPin($db,$pin_no);
                            if($cpin==1)
                            {   */
                                $qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`,`paired`) VALUES ('$username','$password','$cdate','$cdate','$paired')";
                                $q=mysqli_query($db,$qry);
                                if($q)
                                {
                                    $uid=mysqli_insert_id($db);
                                    $qry1="Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
                                    $q1=mysqli_query($db,$qry1);
                                    if($q)
                                    {
                                        
                                       /*$q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                       UserPairing($db,$uid,$parent_id,$sponsor_id);*/
                                        $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                        $url = str_replace("includes/adminfunction","member",$loginurl);
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
                                        send_phpmail($to,$fname." ".$lname,"","",$subject,$content);
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
                            /*}
                            else
                            {
                                $msg=$cpin;
                            }  */
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
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'message'=>$msg
    ));
}
/* add / Edit User */
if(isset($_POST["ajax_register_without_pin"]))
{
    $success = false;
    $msg = "";
    $url="";
    //print_r($_POST);die;
    extract($_POST);
    $sponsor_name=$sponsor_id;
    if(!isset($parent_id) || empty($parent_id))
    {
        //echo $sponsor_id."-----".$position;
        $res=GetUserCountPos($db,$sponsor_id,$position);
        $parent_id=end($res);
        $sp1=mysqli_query($db,"select uname,paired from user_id where uid='$parent_id'");
        $spno=mysqli_num_rows($sp1);
        if($spno > 0)
        {
            $userid=mysqli_fetch_assoc($sp1);
            $parent_id=$userid['uname'];
        }
        else
        {
            $msg = "Enter valid Parent Id!";
        }
    }
    // echo "Parent_____".$parent_id;die;
    if(isset($parent_id) && !empty($parent_id) && isset($sponsor_id) && !empty($sponsor_id))
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
                    $msg = "You can not add User under this parent.";
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
                            //echo $parent_id;
                            /*$cpin=checkTransPin($db,$pin_no);
                            if($cpin==1)
                            {   */
                                $qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`,`paired`,`status`) VALUES ('$username','$password','$cdate','$cdate','$paired','2')";
                                $q=mysqli_query($db,$qry);
                                if($q)
                                {
                                    $uid=mysqli_insert_id($db);
                                    $qry1="Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
                                    $q1=mysqli_query($db,$qry1);
                                    if($q)
                                    {
                                        
                                       /*$q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                       UserPairing($db,$uid,$parent_id,$sponsor_id);*/
                                        UserPairing_web($db,$uid,$parent_id,$sponsor_id,$position);
                                        $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                        $url = str_replace("includes/webfunction","member",$loginurl);
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
                                        $message = "Welcome to BRAND MAKERS. \n  Sponsor: $sponsor_name\n  Login Details: \n Username : $username \n password : $password \n Click Here To Login  $url";
                                        sendSMS($db,$uid,$message);
                                        //var_dump($fpay);
                                        //sendMultipleEmailAttachment($to,$fname." ".$lname,"",$subject,$content,array());
                                        send_phpmail($to,$fname." ".$lname,"","",$subject,$content);
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
                            /*}
                            else
                            {
                                $msg=$cpin;
                            }  */
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
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'message'=>$msg
    ));
}
/* add / Edit User */
if(isset($_POST["ajax_register"]))
{
    $success = false;
    $msg = "";
    $url="";
    //print_r($_POST);
    extract($_POST);
    $check_pan=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `user_detail` WHERE `pan_no`='$pan_no'"));

    if($pan_no==''){
        $msg = "Pan no error! Pan no is required."; 
    }else{
        if($check_pan>0){
         $msg = "Pan no error! This pan no is already available plz try diffrent.";  
        }
        else{   
    
    $sponsor_id=isset($sponsor_id) && !empty($sponsor_id)?$sponsor_id:'admin';
    $sponsor_name=$sponsor_id;
    /*$rr1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.position FROM `pairing` t1 LEFT JOIN user_id t2 on t1.uid=t2.uid WHERE t2.uname='$sponsor_name'"));
    $position=$rr1['position'];*/
    if(!isset($parent_id) || empty($parent_id))
    {
        $parent_id=GetValidParentId($db,$sponsor_id,$position);
        
    }
    $p=mysqli_fetch_assoc(mysqli_query($db,"SELECT plan_id FROM plans  WHERE plan_amount=0 limit 1"));
        $plan_id=$p['plan_id'];
        $pin_no=addnewzeropin($db,$plan_id,1);  
    //echo "Parent_____".$parent_id;
    if(isset($parent_id) && !empty($parent_id) && isset($sponsor_id) && !empty($sponsor_id))
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
          if($chkqry >= 2)
          {
            $msg = "You can not add User under this parent,Parent Already have 2 Childs.";
          }
          else
          {
            //echo "SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'";
            $check_position = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
            $chkqry2 = mysqli_num_rows($check_position);
            if($chkqry2>0){
                $msg = 'Already assiged a user to this side';
            }
            else
            {
              //echo "no of qry_____".$chkqry2; die;
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
                //echo $parent_id;
                $p=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.pin_code FROM `transpin` t1 left join plans t2 on t1.plan_id=t2.plan_id WHERE t1.`allot_uid` = '0' and t1.`status`='0' and t1.`allot_uid`='0' and t2.plan_amount=0 order by pin_id limit 1"));
                $pin_no=$p['pin_code'];
                if(isset($pin_no) && !empty($pin_no))
                {
                  $cpin=checkTransPin($db,$pin_no);
                  if($cpin==1)
                  {
                    //$qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`,`paired`,`status`) VALUES ('$username','$password','$cdate','$cdate','$paired','2')";
                    $qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`, `pin`,`paired`) VALUES ('$username','$password','$cdate','$cdate','$pin_no','$paired')";
                    $q=mysqli_query($db,$qry);
                    if($q)
                    {
                      $uid=mysqli_insert_id($db);
                      $qry1="Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
                      $q1=mysqli_query($db,$qry1);
                      if($q)
                      {
                          
                         $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                         UserPairing($db,$uid,$parent_id,$sponsor_id,$position);
                         
                          //UserPairing_web($db,$uid,$parent_id,$sponsor_id,$position);
                          $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                          $url = str_replace("includes/webfunction","login",$loginurl);
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
                          //$fpay=FirstRegisterPayment($db,$uid,$pay_parent_id,$is_sponsor);
                          $pamount=getPinAmount($db,$uid);
                          if(isset($email) && !empty($email))
                          {
                              $mail=send_phpmail($tname,$to,"","",$subject,$content);
                          }
                          $message = "Welcome to $webname. \n  Sponsor: $sponsor_name\n  Login Details: \n Username : $username \n password : $password \n Click Here To Login  $url";
                          sendSMS($db,$uid,$message);
                          //var_dump($fpay);
                          //sendMultipleEmailAttachment($to,$fname." ".$lname,"",$subject,$content,array());
                          send_phpmail($to,$fname." ".$lname,"","",$subject,$content);
                          $success = true;                
                          $msg= "New user added successfully";
                          if(isset($type) && $type=='checkoutregisterform')
                          {
                            $row=mysqli_fetch_assoc(mysqli_query($db,"SELECT uid,role,uname,status FROM user_id WHERE uid='$uid'"));
                            $_SESSION['mlmid'] = $row['uid'];
                            $_SESSION['mlmusername'] = $row['uname'];
                            $_SESSION['mlmrole'] = $row['role'];
                            $_SESSION['mlmstatus'] = $row['status'];
                            
                            $id = $row['uid'];
                            $ip = get_userip();
                            mysqli_query($db,"update cart set uid='$id' where ip='$ip' and uid='0'");
                            updateCartAfterLogin($db,$id);
                          }
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
                else
                {
                  $msg = "Pin Is Not Available, Please Contact Admin!";
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
   }
    
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'message'=>$msg
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

/*
 * Check Valid Username
 */
if(isset($_POST["type"]) && $_POST["type"] == "checkusername")
{
    $success = false;
    $message = "";
    $username="";
    $url="";
    $username = $_POST['username'];
    if(isset($username))
    { 
        $userc=mysqli_num_rows(mysqli_query($db,"select uid from user_id where uname='$username'"));
        if($userc>0)
        {
            $message = "Username is already taken";
        }else if (preg_match('/[^a-z_\-0-9]/i', $username)) {
            $message = "Username should contain only character,number or underscore";
        }
        else
        { 
            $success = true;
        }
    }
    else
    {
        $message = "Enter User Name";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $message
    ));
}
if(isset($_POST["type"]) && $_POST["type"] == "ContactSend")
{
    $success = false;
    $message = "";
    $name  = $_POST["name"];
    $email  = $_POST["email"];
    $phone = $_POST['number'];
    $subject = 'hii';
    $body = mysqli_escape_string($db,$_POST['comment']);
    //echo "INSERT INTO `contact`(`name`, `email`, `phone`, `message`) VALUES ('$name','$email','$phone','$body')";
    $q4 = mysqli_query($db,"INSERT INTO `contact`(`name`, `email`, `phone`, `message`) VALUES ('$name','$email','$phone','$body')");
    if($q4)
    {
        $success = true;
        $subject = "$webtitle Contact : ".$subject;
        $body = "Name : $name <br> Email : $email <br> Contact : $phone<br>
        ".$body."
        <p>Thank You</p>
        <img alt=\"$webname\" border=\"0\" width=\"250\" style=\"display:block\"  src=\"cid:logo_2u\"><br>";
        //send_mail( $to, $from, $subject, $body );
        send_phpmail('', '', "", "", $subject, $body);  
        $message = "Thank You contacting us, we will contact you in few days";
    }
    else
    {
        $message = "Server Busy try after sometime";
    }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}
/*
 * Check Valid Pin
 */
if(isset($_POST["type"]) && $_POST["type"] == "getSponsordetail")
{
    $success = false;
    $message = "";
    $username="";
    $name="";
    $uname = $_POST['sponsor_id'];
    if(isset($uname))
    { 
        $sql=mysqli_query($db,"SELECT first_name,last_name FROM `user_detail`  t1 left join user_id t2 on t1.uid=t2.uid WHERE t2.uname='$uname'");
        if(mysqli_num_rows($sql) > 0)
        {
            $data=mysqli_fetch_assoc($sql);
            $success = true;
            $name=$data['first_name']." ".$data['last_name'];
        }
    }
    else
    {
        $message = "No Sponsor Found!";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $message,
        "name" => $name
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "getUserdetail")
{
    $success = false;
    $message = "";
    $username="";
    $name="";
    $uid="";
    $isdp=0;
    $uname = $_POST['uid'];
    $mlmid = isset($_SESSION['mlmid'])?$_SESSION['mlmid']:0;
    $fid = isset($_SESSION['franchiseid'])?$_SESSION['franchiseid']:0;
    if(isset($uname))
    { 
        $sql=mysqli_query($db,"SELECT t1.first_name,t1.last_name,t1.uid FROM `user_detail`  t1 left join user_id t2 on t1.uid=t2.uid WHERE t2.uname='$uname'");
        if(mysqli_num_rows($sql) > 0)
        {
            $data=mysqli_fetch_assoc($sql);
            $success = true;
            $name=$data['first_name']." ".$data['last_name'];
            $uid=$data['uid'];
            $chk_pur=IsDistributor($db,$uid);
            if($chk_pur > 0)
            {
                $isdp=1;
            }
            ob_start();
            ?>
                <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th>Products</th>
                        <th>Total</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $total=0;
                     $userbv=0;
                     if(isset($mlmid) && $mlmid>0)
                     {
                        $q1=mysqli_query($db,"SELECT t1.*,t2.mrp,t2.dp ,t2.pv as pbv FROM cart t1 left join products t2 on t1.product_id=t2.product_id WHERE uid='$uid' and fid=0 and transaction_id IS null");
                    }
                    else if(isset($fid) && $fid > 0)
                     {
                        $q1=mysqli_query($db,"SELECT t1.*,t2.mrp,t2.dp ,t2.pv as pbv FROM cart t1 left join products t2 on t1.product_id=t2.product_id WHERE fid='$fid' and uid=0 and transaction_id IS null");
                    }
                    else
                    {
                        $ip = get_userip();
                        $q1=mysqli_query($db,"SELECT t1.*,t2.mrp,t2.dp ,t2.pv as pbv FROM cart t1 left join products t2 on t1.product_id=t2.product_id WHERE transaction_id IS null and ip='$ip'");

                    }
                     while ($r1=mysqli_fetch_assoc($q1)) {
                        $pv=0;
                        $price=$r1['mrp']*$r1['qty'];
                        $price1=$r1['mrp'];
                        $cart_id=$r1['cart_id'];
                        if(isset($isdp) && $isdp==1)
                        {
                            $price=$r1['dp']*$r1['qty'];
                            $price1=$r1['dp'];
                        }
                        //echo $price;
                        $total=$total+$price;
                        $pv=($r1['pbv']*$r1['qty']);
                        $userbv=$userbv+$pv;
                        mysqli_query($db,"update cart set price='$price1',total='$price' where cart_id='$cart_id'");
                     ?>
                     <tr>
                        <td><a href="javascript:void(0);"><?=$r1['name']; ?> <strong> × <?=$r1['qty']; ?></strong></a></td>
                        <td>₹<?=$price; ?></td>
                     </tr>
                  <?php } ?>
                  </tbody>
                  <tfoot>
                     <tr>
                        <td>Sub Total</td>
                        <td><strong>₹<?=$total; ?></strong></td>
                     </tr>
                     
                     <tr>
                        <td>Total Amount</td>
                        <td><strong>₹<?=$total; ?></strong></td>
                     </tr>
                  </tfoot>
               </table>
            <?php
            $data=ob_get_clean();
        }
    }
    else
    {
        $message = "No Sponsor Found!";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $message,
        "total" => $total,
        "data" => $data,
        "isdp" => $isdp,
        "name" => $name,
        "pv" => $userbv,
        "uid" => $uid
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "getDUserdetail")
{
    $success = false;
    $message = "";
    $username="";
    $name="";
    $uid="";
    $isdp=0;
    $total=0;
    $data='';
   $uname = $_POST['uid'];
    $mlmid=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'';
    $fid = isset($_SESSION['franchiseid'])?$_SESSION['franchiseid']:0;
    if(isset($uname) && !empty($mlmid))
    { 
        $left_users = GetUserByPos($db,$mlmid,'L');
        $right_users = GetUserByPos($db,$mlmid,'R');
        $uids=array_merge($left_users,$right_users);
       // $uids[]=$mlmid;
       // print_r($left_users);
       // print_r($right_users);
       // die();
        $uids1=implode(',', $uids);
        $sql=mysqli_query($db,"SELECT t1.first_name,t1.last_name,t1.uid FROM `user_detail`  t1 left join user_id t2 on t1.uid=t2.uid WHERE t2.uname='$uname' and t1.uid in($uids1)");
        if($sql)
        {
            if(mysqli_num_rows($sql) > 0)
            {
                $data=mysqli_fetch_assoc($sql);
                $success = true;
                $name=$data['first_name']." ".$data['last_name'];
                $uid=$data['uid'];
                $chk_pur=IsDistributor($db,$uid);
                if($chk_pur > 0)
                {
                    $isdp=1;
                }
                ob_start();
                ?>
                    <table class="table table-bordered">
                      <thead>
                         <tr>
                            <th>Products</th>
                            <th>Total</th>
                         </tr>
                      </thead>
                      <tbody>
                         <?php
                         $total=0;
                         $userbv=0;
                         
                         $q1=mysqli_query($db,"SELECT t1.*,t2.mrp,t2.dp ,t2.pv as pbv FROM cart t1 left join products t2 on t1.product_id=t2.product_id WHERE t1.uid='$mlmid' and t1.transaction_id IS null") or die(mysqli_error($db));
                         while ($r1=mysqli_fetch_assoc($q1)) {
                            $pv=0;
                            $price=$r1['mrp']*$r1['qty'];
                            $price1=$r1['mrp'];
                            $cart_id=$r1['cart_id'];
                            if(isset($isdp) && $isdp==1)
                            {
                                $price=$r1['dp']*$r1['qty'];
                                $price1=$r1['dp'];
                            }
                            $total=$total+$price;
                            $pv=($r1['pbv']*$r1['qty']);
                            $userbv=$userbv+$pv;
                            mysqli_query($db,"update cart set price='$price1',total='$price' where cart_id='$cart_id'");
                         ?>
                         <tr>
                            <td><a href="javascript:void(0);"><?=$r1['name']; ?> <strong> × <?=$r1['qty']; ?></strong></a></td>
                            <td>₹<?=$price; ?></td>
                         </tr>
                      <?php } ?>
                      </tbody>
                      <tfoot>
                         <tr>
                            <td>Sub Total</td>
                            <td><strong>₹<?=$total; ?></strong></td>
                         </tr>
                         
                         <tr>
                            <td>Total Amount</td>
                            <td><strong>₹<?=$total; ?></strong></td>
                         </tr>
                      </tfoot>
                   </table>
                <?php
                $data=ob_get_clean();
            }
            else
            {
                $message = "No User Found!";
            }
        }
        else
        {
            $message = "No User Found!";
        }
    }
    else
    {
        $message = "No User Found!";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $message,
        "total" => $total,
        "data" => $data,
        "isdp" => $isdp,
        "name" => $name,
        "uid" => $uid,
        "pv" => $userbv
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "getFranchisedetail")
{
    $success = false;
    $message = "";
    $username="";
    $name="";
    $uid="";
    $fid = $_POST['fid'];
    if(isset($fid) && !empty($fid))
    { 
        $sql=mysqli_query($db,"SELECT id,name FROM `franchise` WHERE uname='$fid'");
        if(mysqli_num_rows($sql) > 0)
        {
            $data=mysqli_fetch_assoc($sql);
            $success = true;
            $name=$data['name'];
            $uid=$data['id'];
        }
        else
        {
            $message = "No Franchise Found!";
        }
    }
    else
    {
        $message = "No Franchise Found!";
    }
    echo json_encode(array(
        "valid"=>$success,
        "message" => $message,
        "name" => $name,
        "uid" => $uid
    ));
}
/*********************** jinal code *******************/
if(isset($_POST["type"]) && $_POST["type"] == "ManageReview")
{
    $success = false;
    $message = "";
    extract($_POST);
    if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
    {
        $_POST['uid']=$_SESSION['mlmid'];
        $_POST['date']=date("Y-m-d H:i:s");
        unset($_POST['type']);
        $sql_str = "";
        foreach ($_POST as $key => $value) {
            if(is_array($value))
            {
                $value=implode(',', $value);
            }
            if(!empty($value))
            {
                $value=mysqli_real_escape_string($db,$value);
                $sql_str .= "`$key`='$value',";
            }
            
        }
        if(!empty($sql_str)){
            $sql_str = rtrim($sql_str,',');
        }
        $body = mysqli_escape_string($db,$review);
        //echo "INSERT INTO review SET $sql_str";
        $q4 = mysqli_query($db,"INSERT INTO review SET $sql_str");
        if($q4)
        {
            $success = true; 
            $message = "Thank You For Your Review.";
            ob_start();
                $rq=mysqli_query($db,"SELECT t1.*,t2.uname,t2.image FROM `review` t1 LEFT JOIN user_id t2 on t1.uid=t2.uid WHERE t1.product_id='$product_id' ") or die(mysqli_error($db));
                while ($rr=mysqli_fetch_assoc($rq)) {
                ?>
                <div class="total-reviews">
                   <div class="rev-avatar">
                    <?php if(isset($rr['image']) && file_exists("upload/profile".$rr['image']))
                    { ?>
                      <img src="upload/profile/<?=$rr['image']; ?>" alt="">
                    <?php } else { ?>
                      <img src="images/no-image.png" alt="">
                    <?php } ?>
                   </div>
                   <div class="review-box">
                      <div class="ratings">
                        <?php for($i=1;$i<6;$i++)
                        { 
                          if(isset($rr['rating']) && $rr['rating']>=$i)
                          {
                        ?>
                         <span><i class="ion-android-star"></i></span>
                       <?php } else { ?>
                         
                         <span><i class="ion-android-star-outline"></i></span>
                       <?php } } ?>
                      </div>
                      <div class="post-author">
                         <p><span><?=$rr['uname']; ?> -</span><?=date("d M, Y",strtotime($rr['date'])); ?> </p>
                      </div>
                      <p><?=$rr['review']; ?>
                      </p>
                   </div>
                </div> <?php 
            }
            $html=ob_get_clean();
        }
        else
        {
            $message = "Server Busy try after sometime";
        }
    }
    else
    {
        $message = "Please Login For Review.";
    }
    echo json_encode(array(
        "html"=>$html,
        "success"=>$success,
        "message" => $message
    ));
}
if(isset($_POST["type"]) && $_POST["type"] == "AddToCart")
{
    $success = false;
    $message = "";
    $id = $_POST["product_id"];
    $price = $_POST["price"];

    $product_dp=mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM products where product_id='$id'"));

    $qty=$_POST["qty"];
    $ip = get_userip();
    $date= date("Y-m-d H:i:s");
    if(isset($_SESSION['franchiseid']))
    {
        $uid=$_SESSION['franchiseid'];
        //echo "SELECT * FROM cart where product_id='$id' and fid='$uid' and transaction_id IS null";
        $result=mysqli_query($db, "SELECT * FROM cart where product_id='$id' and fid='$uid' and transaction_id IS null");
    }
    else if(isset($_SESSION['mlmid']))
    {
        $uid=$_SESSION['mlmid'];
        $result=mysqli_query($db, "SELECT * FROM cart where product_id='$id' and uid='$uid' and transaction_id IS null");
    }
    else
    {
        $result=mysqli_query($db, "SELECT * FROM cart where product_id='$id' and ip='$ip' and uid='0' and transaction_id IS null");
    }
    $num=mysqli_num_rows($result);
    $query = mysqli_fetch_array( mysqli_query($db, "SELECT * FROM products where product_id='$id'" ));
    if($num==0)
    {
        $total=$price*$qty;
        $uid=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:0;
        $fid=isset($_SESSION['franchiseid'])?$_SESSION['franchiseid']:0;
        $name=$query['name'];
        $pv=$query['pv']*$qty;
        $sql="INSERT INTO `cart` (`product_id`, `name`, `qty`, `price`,`pv`,`uid`,`total`,`date`) VALUES ('$id','$name','$qty','$price','$pv','$uid','$total','$date')";
        $q1=mysqli_query($db,$sql) or die(mysqli_error($db));

        if($q1)
        {
            $success = true;
            $message = "Product Added to the cart";
        }
        else
        {
            $message = "Product cannot be added";
        }
    }
    else
    {
        $row=mysqli_fetch_assoc($result);
        $cart_id=$row['cart_id'];
        $qty=$qty+$row['qty'];
        $total=$qty*$price;
        $qry=mysqli_query($db,"UPDATE cart SET qty='$qty',price='$price',total='$total' WHERE cart_id='$cart_id'");
        $success = true;
        $message = "Product Added to the cart";
        //$message = "Product Already in cart";
    }
    $ip = get_userip();
    $date= date("Y/m/d");
    if(isset($_SESSION['franchiseid']))
    {
        $uid=$_SESSION['franchiseid'];
        $result=mysqli_query($db, "SELECT * FROM cart where fid='$uid' and transaction_id IS null");
    }
    else if(isset($_SESSION['mlmid']))
    {
        $uid=$_SESSION['mlmid'];
        $result=mysqli_query($db, "SELECT * FROM cart where uid='$uid' and transaction_id IS null");
    }
    else
    {
        $result=mysqli_query($db, "SELECT * FROM cart where ip='$ip' and uid='0' and transaction_id IS null");
    }

    $numproducts=mysqli_num_rows($result);
    echo json_encode(array(
        'success'=>$success,        
        'cartcount'=>$numproducts,
        'message'=>$message
    ));
}
if(isset($_POST["type"]) && $_POST["type"] == "AddToCart2")
{
    $success = false;
    $message = "";
    $id = $_POST["product_id"];
    $price = $_POST["price"];
    $qty=$_POST["qty"];
    $ip = get_userip();
    $date= date("Y/m/d");
    $uid=$_SESSION['mlmid'];
    $result=mysqli_query($db, "SELECT * FROM cart where product_id='$id' and uid='$uid' and transaction_id IS null");
    
    $num=mysqli_num_rows($result);
    $query = mysqli_fetch_array( mysqli_query($db, "SELECT * FROM products where product_id='$id'" ));
    if($num==0)
    {
        $total=$price*$qty;
        $uid=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:0;
        $fid=isset($_SESSION['franchiseid'])?$_SESSION['franchiseid']:0;
        $name=$query['name'];
        $pv=$query['pv']*$qty;
        $sql="INSERT INTO `cart`(`product_id`, `name`, `qty`, `price`,`uid`,`total`,`pv`,`date`) VALUES ('$id','$name','$qty','$price','$uid','$total','$pv','date')";
        $q1=mysqli_query($db,$sql);

        if($q1)
        {
            $success = true;
            $message = "Product Added to the cart";
        }
        else
        {
            $message = "Product cannot be added";
        }
    }
    else
    {
        $row=mysqli_fetch_assoc($result);
        //echo $price."<br>";
        $cart_id=$row['cart_id'];
        $qty=$qty;
        $total=$qty*$price;
        $pv=$query['pv']*$qty;
        $qry=mysqli_query($db,"UPDATE cart SET qty='$qty', price='$price',total='$total',pv='$pv' WHERE cart_id='$cart_id'");
        $success = true;
        $message = "Cart updated.";
        //$message = "Product Already in cart";
    }
    $ip = get_userip();
    $date= date("Y/m/d");
    if(isset($_SESSION['franchiseid']))
    {
        $uid=$_SESSION['franchiseid'];
        $result=mysqli_query($db, "SELECT * FROM cart where fid='$uid' and transaction_id IS null");
    }
    else if(isset($_SESSION['mlmid']))
    {
        $uid=$_SESSION['mlmid'];
        $result=mysqli_query($db, "SELECT * FROM cart where uid='$uid' and transaction_id IS null");
        //$result1=mysqli_query($db, "SELECT * FROM cart where product_id='$id' and uid='$uid' and transaction_id IS null");
    }
    else
    {
        $result=mysqli_query($db, "SELECT * FROM cart where ip='$ip' and uid='0' and transaction_id IS null");
        //$result1=mysqli_query($db, "SELECT * FROM cart where product_id='$id' and ip='$ip' and uid='0' and transaction_id IS null");
    }
    //$cartr=mysqli_fetch_assoc($result1);
    //$total=$cartr['price']*$cartr['qty'];
    $carttotal=0;
    $numproducts=mysqli_num_rows($result);
    while ($cr=mysqli_fetch_assoc($result)) {
        $carttotal=$carttotal+$cr['total'];
    }
    echo json_encode(array(
        'success'=>$success,        
        'cartcount'=>$numproducts,
        'carttotal'=>$carttotal,
        'total'=>$total,
        'message'=>$message
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "RemoveFromCart")
{
    $success = false;
    $message = "";
    $cart_id = $_POST["cart_id"];
    $q1=mysqli_query($db,"DELETE from cart where cart_id='$cart_id'");
    if($q1)
    {
        $success=true;
        $message = "Product Removed From Cart";
    }
    else
    {
        $message = "Server Busy...";
    }

    $ip = get_userip();
    $date= date("Y/m/d");
    if(isset($_SESSION['mlmid']))
    {
        $uid=$_SESSION['mlmid'];
        $result=mysqli_query($db, "SELECT * FROM cart where uid='$uid' and transaction_id IS null");
    }
    else if(isset($_SESSION['franchiseid']))
    {
        $fid=$_SESSION['franchiseid'];
        $result=mysqli_query($db, "SELECT * FROM cart where fid='$fid' and transaction_id IS null");
    }
    else
    {
        $result=mysqli_query($db, "SELECT * FROM cart where ip='$ip' and uid='0' and transaction_id IS null");
    }
    $carttotal=0;
    $numproducts=mysqli_num_rows($result);
    while ($cr=mysqli_fetch_assoc($result)) {
        $carttotal=$carttotal+$cr['total'];
    }
$numproducts=mysqli_num_rows($result);
    echo json_encode(array(
        'success'=>$success,
        'cartcount'=>$numproducts,
        'carttotal'=>$carttotal,
        'message'=>$message
    ));
}

if(isset($_POST['type']) && $_POST['type'] == 'CheckPassword')
{
    $success = false;
    $message = "";
    $uid    = isset($_POST['uid'])?$_POST['uid']:'';
    $password    = isset($_POST['password'])?$_POST['password']:'';
    $table    = isset($_POST['table'])?$_POST['table']:'';

    if(isset($uid) && !empty($uid) && isset($password) && !empty($password))
    {
        if(isset($table) && $table=='user_id')
        {
            $r1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid='$uid'"));
        }
        else
        {
            $r1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * from franchise where id='$uid'"));
        }
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

if(isset($_POST["type"]) && $_POST["type"] == "OrderNow")
{
    $success = false;
    $message = "";
    $url = '';
    //extract($_POST);
    $data=array();
    foreach ($_POST['formData'] as $key => $value) {
       $data[$value['name']]=$value['value'];
    }
    extract($data);

    $user_id=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'0';    
    $shipping_charge=isset($shipping_charge)?$shipping_charge:0;
    
    $puid=isset($data['puid']) && !empty($data['puid'])?$data['puid']:$user_id;
    $sr=mysqli_fetch_assoc(mysqli_query($db,"select sponsor_id,parent_id,position,achieve_rank from pairing where uid='$puid'"));
    
        $sponsor_id=$sr['sponsor_id'];
        $parent_id=$sr['parent_id'];
        $position=$sr['position'];
        $rank=$sr['achieve_rank'];
       
        if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
        {
            $user_id1=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'0';
            //echo "select balance,pv from user_id where uid='$user_id'";
            $ur=mysqli_fetch_assoc(mysqli_query($db,"select balance,pv from user_id where uid='$user_id1'"));
            $wamount=$ur['balance'];
            $ur1=mysqli_fetch_assoc(mysqli_query($db,"select pv from user_id where uid='$puid'"));
            $ex_pv=$ur1['pv'];
            $pay_user=0;
        }

        $products=array();
        $cq1=mysqli_query($db, "SELECT product_id,qty,pv FROM cart where uid='$uid' and transaction_id IS null");
        $total_pv=0;
        $dp_amount=0;
        while ($cr1=mysqli_fetch_assoc($cq1)) {
            $products[]=$cr1['product_id'];
            //$bv1=$cr1['pv']*$cr1['qty'];
            $pv1=$cr1['pv'];
            $total_pv=$total_pv+$pv1;
            //$total_dp=($total_dp+($cr1['dp']*25/100))*$cr1['qty'];
        }

        //var_dump(($amount <= $wamount));
        $product_ids=implode(',', $products);
        if(($user_id > 0 || $fid>0) && $amount <= $wamount)
        //if(($user_id > 0 || $fid>0))
        {
        
        //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        
            unset($data['uid']);       
            
            $data['pv']=$total_pv;
            $data['user']=$user_id;
            $data['uid']=$puid;
            $data['product_ids']=$product_ids;
            $data['date']=date("Y-m-d H:i:s");
            $data['pay_user']=$pay_user;
            unset($data['type']);
            unset($data['puid']);
            //var_dump($data);die;
            $sql_str = "";
            foreach ($data as $key => $value) {
            if(is_array($value))
            {
                $value=implode(',', $value);
            }
            if($key=='pay_user')
            {
                $sql_str .= "`$key`='$value',";
            }
            else if(!empty($value))
            {
                $value=mysqli_real_escape_string($db,$value);
                $sql_str .= "`$key`='$value',";
            }
            
            
        }
        if(!empty($sql_str)){
            $sql_str = rtrim($sql_str,',');
        } 
        //echo "INSERT INTO checkout set $sql_str";
        $q1=mysqli_query($db,"INSERT INTO checkout set $sql_str");
        if($q1)
        {
            $transaction_id = mysqli_insert_id($db);
            mysqli_query($db,"UPDATE `cart` SET `transaction_id`='$transaction_id' WHERE `uid` ='$user_id' and transaction_id IS null");
            $success = true;
           /* $transaction_id = encrypt_decrypt('encrypt',$transaction_id);
            $url = 'processpayment1.php?id='.$transaction_id;
            $message = "Please Wait while we Process Your Order";*/
            
            $chkamount=$amount+$shipping_charge;
            $bal=$wamount-$chkamount;
            $upv=$ex_pv+$pv;
            $plan_date=date("Y-m-d H:i:s");
            if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
            {
                $mlmid=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'0';
                //echo "UPDATE user_id SET balance='$bal' WHERE uid='$mlmid'";
                mysqli_query($db,"UPDATE user_id SET balance='$bal' WHERE uid='$mlmid'") or die(mysqli_error($db));                
            }
            mysqli_query($db,"UPDATE user_id SET pv='$upv',plan_date='$plan_date' WHERE uid='$puid'") or die(mysqli_error($db));

            PVCount_parent($db,$puid,$pv);
             Is_userActive($db,$puid,$pv);
            unilevel_commission($db,$puid,$chkamount,$sponsor_id);
            //get_currentRankCommision($db,$rank,$puid,$pv);
            
            mysqli_query($db,"UPDATE child_counter SET retail_profit=retail_profit+$total_pv WHERE uid='$puid'");

            $userfname=GetUserflname($db,$uid);
            $order_id= "SL".leftpad($transaction_id,6);

            $msg = "Dear ".$userfname.",Thank you for Purchasing Rs $chkamount From varietiz.Order No:$order_id Generated Successfully.login. www.secretliving.com";
            if(isset($msg) && $msg!='' && !empty($msg))
            {
               sendSMS($db,$uid,$msg); 
            }
            $url="orders?id=$transaction_id";
            $message = "Your Order has been placed";
        }
        else
        {
            $message = "Some Problem Occur While Processing Payment";
        }
    }
    else if($amount > $wamount)
    {
        $message = "Please Check Your Wallet Balance";
    }
    else
    {
        $message = "Please Login first";
    }

    echo json_encode(array(
        'success'=>$success,
        'message'=>$message,
        'url'=>$url
    ));
}

if(isset($_POST["type"]) && $_POST["type"] == "CategoryFilter")
{
    $success = true;
    $message = "";
    $cat_id=$_POST['cat_id'];
    if($cat_id=='')
    {
        $sql="SELECT t1.*,t2.cat_name FROM products t1 left join product_category t2 on t1.cat_id=t2.cat_id WHERE t1.status=0 order by product_id";
    }
    else
    {
        $sql="SELECT t1.*,t2.cat_name FROM products t1 left join product_category t2 on t1.cat_id=t2.cat_id WHERE t1.cat_id='$cat_id' AND t1.status=0 order by product_id";
    }
    $q1=Pagination($db,$sql,'','','9');
    ob_start();
    while($r1=mysqli_fetch_assoc($q1['result']))            
    {
        $prd_id=$r1['product_id'];
        $all_rat=0;
        $avg_rating=0;
        $rat_q=mysqli_query($db,"SELECT rating FROM `review` WHERE product_id='$prd_id'");
        $rat_no=mysqli_num_rows($rat_q);
        while ($rat_data=mysqli_fetch_assoc($rat_q)) 
        {
          $all_rat+=$rat_data['rating'];
        }
        if(isset($rat_no) && $rat_no > 0)
        {
          $avg_rating=$all_rat/$rat_no;
        }
        ?>
        <div class="col-lg-4 col-md-4 col-sm-6">
                <!-- product grid item start -->
                <div class="product-item mb-50">
                   <div class="product-thumb">
                      <a href="product_detail?id=<?=$r1['product_id']; ?>">
                      <img src="upload/product/<?=$r1['image']; ?>" alt="">
                      </a>
                      <div class="quick-view-link">
                         <!-- <a href="#" data-toggle="modal" data-target="#quick_view"> -->
                         <a href="product_detail?id=<?=$r1['product_id']; ?>"> <span
                            data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                         </a>
                      </div>
                   </div>
                   <div class="product-content text-center">
                      <div class="ratings">
                         <?php for($i=1;$i<6;$i++)
                           { 
                             if(isset($avg_rating) && $avg_rating>=$i)
                             {
                           ?>
                            <span><i class="ion-android-star"></i></span>
                          <?php } else { ?>
                            
                            <span><i class="ion-android-star-outline"></i></span>
                         <?php } } ?>
                      </div>
                      <div class="product-name">
                         <h4 class="h5">
                            <a href="product_detail"><?=$r1['name']; ?></a>
                         </h4>
                      </div>
                      <div class="price-box">
                          <?php
                                  
                                  /*if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
                                  {
                                    $prd_price=$r1['fp'];
                                  }*/
                                  $prd_price=$r1['mrp'];
                                  if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
                                  {
                                    $chk_pur=IsDistributor($db,$_SESSION['mlmid']);
                                    if($chk_pur > 0)
                                    {
                                      $prd_price=$r1['dp'];
                                    }
                                    else
                                    {
                                      $prd_price=$r1['mrp'];
                                    }
                                  }
                                ?>
                         <span class="regular-price">₹ <?=$prd_price; ?></span>
                         <span class="old-price"><del></del></span>
                      </div>
                      <div class="product-action-link">
                         <!-- <a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a> -->
                         <a href="javascript:void(0);" class="AddToCart" onclick="Add_cart(<?=$r1['product_id']; ?>,<?=$prd_price; ?>,'1')" data-toggle="tooltip" title="Add to cart"><i class="ion-bag"></i></a>
                         <!-- <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a> -->
                      </div>
                   </div>
                </div>
                <!-- product grid item end -->
                <!-- product list item start -->
                <div class="product-list-item mb-30">
                   <div class="product-thumb">
                      <a href="product_detail?id=<?=$r1['product_id']; ?>">
                      <img src="upload/product/<?=$r1['image']; ?>" alt="">
                      </a>
                      <div class="quick-view-link">
                         <a href="product_detail?id=<?=$r1['product_id']; ?>" ><span data-toggle="tooltip" title="Quick view"><i class="ion-ios-eye-outline"></i></span>
                         </a>
                      </div>
                   </div>
                   <div class="product-content-list">
                      <div class="ratings">
                         <?php for($i=1;$i<6;$i++)
                           { 
                             if(isset($avg_rating) && $avg_rating>=$i)
                             {
                           ?>
                            <span><i class="ion-android-star"></i></span>
                          <?php } else { ?>
                            
                            <span><i class="ion-android-star-outline"></i></span>
                         <?php } } ?>
                      </div>
                      <div class="product-name">
                         <h4><a href="product_detail?id=<?=$r1['product_id']; ?>"><?=$r1['name']; ?></a></h4>
                      </div>
                      <div class="price-box">
                         <span class="regular-price">₹<?=$prd_price; ?></span>
                         <span class="old-price"><del></del></span>
                      </div>
                      <p><?=$r1['product_desc']; ?>
                      </p>
                      <div class="action-link">
                         <a href="javascript:void(0);" data-toggle="tooltip" title="Add to cart" class="add-to-cart" onclick="Add_cart(<?=$r1['product_id']; ?>,<?=$prd_price; ?>,'1')">add
                         to cart</a>
                         <!-- <a href="#" data-toggle="tooltip" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>
                         <a href="#" data-toggle="tooltip" title="Compare"><i class="ion-ios-shuffle"></i></a> -->
                      </div>
                   </div>
                </div>
                <!-- product list item start -->
             </div>
        <?php
    }
    $data=ob_get_clean();
    echo json_encode(array(
        "data"=>$data,
        "pagination"=>$q1['pagination'],
        "success"=>$success,
        "message" => $message
    ));
}



if(isset($_POST["type"]) && $_POST["type"]== 'ProfileUpdate')
{
    $success = false;
    $msg = "";
    $url="";
    extract($_POST);
    $date=date('Y-m-d H:i:s');
    unset($_POST['type']);
    if(isset($uid) && $uid!='')
    { 
        $update_str1="";
        $update_str="";

        $filename="";
        $uploadOk = 1;
        if(isset($_FILES['picture']) && $_FILES['picture']['name'] != ""){
            $target_dir = "../upload/profile/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($_FILES["picture"]["size"] > 1000000) {
                $msg=  "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            $extallowed = array("jpg","jpeg","png");
            if (!in_array(strtolower($imageFileType),$extallowed)){
                $msg = "Sorry,For jpg & png extension files are allowed";
                $status = false;
                $uploadOk = 0;
            }

            $filename=uniqid().".".$imageFileType;
            $filepath=$target_dir.$filename;
            if ($uploadOk != 0) {

                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $filepath)) {
                    $update_str="image='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, your file was not uploaded.";
                }
            }
        }
        if ($uploadOk == 0) {
            $success=false;
        } else {
            $userc=mysqli_num_rows(mysqli_query($db,"SELECT uid from user_id where uname='$uname' AND uid!='$uid'"));
            //$emailc=mysqli_num_rows(mysqli_query($db,"select id from users where email='$email'"));
            if($userc>0)
            {
                $msg = "Username is already taken";
            }else if (preg_match('/[^a-z_\-0-9]/i', $uname)) {
                $msg = "Username should contain only character,number or underscore";
            }
            else
            {
                $qry1=mysqli_query($db,"UPDATE `user_detail` SET first_name='$first_name',last_name='$last_name',gender='$gender',email='$email',mobile='$mobile' where `uid`='$uid'") or die(mysqli_error($db));
                if(isset($update_str) && !empty($update_str))
                {
                    $qry="UPDATE `user_id` SET $update_str $q1where `uid`='$uid'";
                    $q1=mysqli_query($db,$qry);
                }
                if($qry1)

                {
                    $success = true;                
                    $msg= "Profile Updated successfully";
                }
                else{
                    $msg= "Some Promlem Occur try after sometime";
                }
            }
        }
    }
    else
    {
       $msg= "Some Promlem Occur try after sometime";
    }    
       
         
     echo json_encode(array(
        'valid'=>$success,
        'url'=>$url,
        'msg'=>$msg
    ));
}


if (isset($_POST["type"]) && $_POST["type"] == 'AddEditUser')
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
    else{
       $msg = "This package pin is not available.";
    }
    echo json_encode(array(
        'valid' => $success,
        'url' => $url,
        'msg' => $msg
    ));
}


if (isset($_POST["type"]) && $_POST["type"] == "payments")
{
   // $some_data = array( 'catname' => 'toyyibPay General 2', //CATEGORY NAME 
   // 'catdescription' => 'toyyibPay General Category,
   //  For toyyibPay Transactions 2', //PROVIDE YOUR CATEGORY DESCRIPTION 
   //  'userSecretKey' => 'aov4fst8-9wzn-dgb5-7s47-ltl9ntil97mk' //PROVIDE USER SECRET KEY HERE
   //   );
   // $curl = curl_init();
   //  curl_setopt($curl, CURLOPT_POST, 1);
   //   curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createCategory'); //PROVIDE API LINK HERE 
   //   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
   //   curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
   //    $result = curl_exec($curl);
   //    $info = curl_getinfo($curl); curl_close($curl); $obj = json_decode($result); echo $result;
   //    exit;
     extract($_POST);
     $user_id=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'0';
     $shipping_charge=isset($shipping_charge)?$shipping_charge:0;
    
     $puid=isset($_POST['puid']) && !empty($_POST['puid'])?$_POST['puid']:$user_id;
     $sr=mysqli_fetch_assoc(mysqli_query($db,"select sponsor_id,parent_id,position,achieve_rank from pairing where uid='$puid'"));
    
        $sponsor_id=$sr['sponsor_id'];
        $parent_id=$sr['parent_id'];
        $position=$sr['position'];
        $rank=$sr['achieve_rank'];
       
         if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
        {
            $user_id1=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'0';
            //echo "select balance,pv from user_id where uid='$user_id'";
            $ur=mysqli_fetch_assoc(mysqli_query($db,"select balance,pv from user_id where uid='$user_id1'"));
            $wamount=$ur['balance'];
            $ur1=mysqli_fetch_assoc(mysqli_query($db,"select pv from user_id where uid='$puid'"));
            $ex_pv=$ur1['pv'];
            $pay_user=0;
        }

        $products=array();
        $cq1=mysqli_query($db, "SELECT product_id,qty,pv FROM cart where uid='$uid' and transaction_id IS null");
        $total_pv=0;
        $dp_amount=0;
        while ($cr1=mysqli_fetch_assoc($cq1)) {
            $products[]=$cr1['product_id'];
            //$bv1=$cr1['pv']*$cr1['qty'];
            $pv1=$cr1['pv'];
            $total_pv=$total_pv+$pv1;
            //$total_dp=($total_dp+($cr1['dp']*25/100))*$cr1['qty'];
        }

        //var_dump(($amount <= $wamount));
        $product_ids=implode(',', $products);
            unset($_POST['uid']);       
            
            $_POST['pv']=$total_pv;
            $_POST['user']=$user_id;
            $_POST['uid']=$puid;
            $_POST['product_ids']=$product_ids;
            $_POST['date']=date("Y-m-d H:i:s");
            $data['pay_user']=$pay_user;
            unset($_POST['type']);
            unset($_POST['puid']);
            //var_dump($data);die;
            $sql_str = "";
            foreach ($_POST as $key => $value) {
            if(is_array($value))
            {
                $value=implode(',', $value);
            }
            if($key=='pay_user')
            {
                $sql_str .= "`$key`='$value',";
            }
            else if(!empty($value))
            {
                $value=mysqli_real_escape_string($db,$value);
                $sql_str .= "`$key`='$value',";
            }
            
            
        }
        if(!empty($sql_str)){
            $sql_str = rtrim($sql_str,',');
        } 
        //echo $sql_str;
        //echo "INSERT INTO checkout set $sql_str";
        $q1=mysqli_query($db,"INSERT INTO checkout_pending set $sql_str");
        //$q1=mysqli_query($db,"INSERT INTO checkout set $sql_str");
        if($q1)
        {
             $last_id = mysqli_insert_id($db);
             $_SESSION['last_id']=$last_id;
            $fname=$_POST['fname'];
            $lname=$_POST['lname'];
            $email=$_POST['email'];
            $uid=$_POST['uid'];
            $phone=$_POST['phone'];
            $amount=$_POST['amount'];
            $amount100=($amount*100);
            $some_data = array(
                'userSecretKey'=> 'aov4fst8-9wzn-dgb5-7s47-ltl9ntil97mk',
                'categoryCode'=> 'buk1k5wq',
                'billName'=> 'Belian buku ebook',
                'billDescription'=> 'Belian buku ebook sebanyak RM',
                'billPriceSetting'=>1,
                'billPayorInfo'=>1,
                'billAmount'=>$amount100,
                'billReturnUrl'=>'https://localhost/secret_living/billurl',
                'billCallbackUrl'=>'https://localhost/secret_living/user/callbackurl',
                'billExternalReferenceNo'=>'',
                'billTo'=>$fname.' '.$lname,
                'billEmail'=>$email,
                'billPhone'=>$phone,
                'billSplitPayment'=>0,
                'billSplitPaymentArgs'=>'',
                'billPaymentChannel'=>0,
          );  
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');  
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
          $result = curl_exec($curl);
          $info = curl_getinfo($curl);  
          curl_close($curl);
          $obj = json_decode($result,true);

          $billcode=$obj[0]['BillCode'];
          echo $billcode;
    }

}