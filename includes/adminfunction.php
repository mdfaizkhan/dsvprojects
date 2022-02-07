<?php
session_start();
//Include database
include '../db_config.php';
$cdate = date("Y-m-d H:i");
/*
 * Change password
*/
if (isset($_POST['ajax_changepassword']))
{
    $adminid = $_SESSION['mlmid'];
    $current_password = $_POST['ajax_current_password'];
    $new_password = $_POST['ajax_new_password'];
    $confirm_password = $_POST['ajax_confirm_password'];
    $new_password1 = encrypt_password($new_password);
    $data = mysqli_fetch_assoc(mysqli_query($db, "select * from user_id where `uid` = '$adminid'"));
    if ($current_password == $data['password'])
    {
        $query = mysqli_query($db, "UPDATE `user_id` SET `password`= '$new_password' WHERE `uid` = '$adminid'");
        if ($query)
        {
            echo json_encode(array(
                "valid" => 1,
                "message" => "Password updated successfully"
            ));
        }
        else
        {
            echo json_encode(array(
                "valid" => 0,
                "message" => "Password Cannot be Updated."
            ));
        }
    }
    else
    {
        echo json_encode(array(
            "valid" => 0,
            "message" => "Current password is incorrect"
        ));
    }
}

if (isset($_POST['ajax_changetpassword']))
{
    $adminid = $_SESSION['mlmid'];
    $current_password = $_POST['ajax_current_password'];
    $new_password = $_POST['ajax_new_password'];
    $confirm_password = $_POST['ajax_confirm_password'];
    $new_password1 = encrypt_password($new_password);
    $data = mysqli_fetch_assoc(mysqli_query($db, "select * from user_id where `uid` = '$adminid'"));
    //echo $current_password."_______".$data['tpassword'];
    if ($current_password == $data['tpassword'])
    {
        $query = mysqli_query($db, "UPDATE `user_id` SET `tpassword`= '$new_password' WHERE `uid` = '$adminid'");
        if ($query)
        {
            echo json_encode(array(
                "valid" => 1,
                "message" => "Password updated successfully"
            ));
        }
        else
        {
            echo json_encode(array(
                "valid" => 0,
                "message" => "Password Cannot be Updated."
            ));
        }
    }
    else
    {
        echo json_encode(array(
            "valid" => 0,
            "message" => "Current password is incorrect"
        ));
    }
}
if (isset($_POST["type"]) && $_POST["type"] == "GeneratePassword")
{
    $success = false;
    $message = "";
    $url = "";
    $user_id = $_POST['id'];
    $query = $db->query("select * from users where user_id = '$user_id'");
    $q = $query->num_rows;
    if ($q > 0)
    {
        $data = mysqli_fetch_assoc($query);
        $userid = $data['user_id'];
        $tokentime = strtotime(date('Y-m-d H:i:s', strtotime('+1 day', time())));
        $token = encrypt_decrypt('encrypt', $userid . "_" . $tokentime);
        $loginurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $loginurl = str_replace("includes/adminfunction", "reset?token=$token", $loginurl);
        ini_set("SMTP", "smtpout.secureserver.net"); //confirm smtp
        $to = $username;
        $from = "";
        $subject = "$webtitle - Password Reset Link";
        $body = "
            <b style='text-transform:capitalize;'>Dear " . $data['first_name'] . " " . $data['last_name'] . ", </b>
            <br>
            <p> Please <a href='$loginurl'> Click Here To Reset Password</a>, Link is valid for 24 hours </a></p>
            <br>
            <p>Thank You</p>
            <img alt=\"$webname\" border=\"0\" width=\"250\" style=\"display:block\"  src=\"cid:logo_2u\"><br>
        ";
        //send_mail( $to, $from, $subject, $body );
        send_phpmail($data['first_name'] . " " . $data['last_name'], $to, "", "", $subject, $body);
        $success = true;
        $message = "A Mail has been Sent to Reset Password";
    }
    else
    {
        $message = "User is not Registered";
    }
    echo json_encode(array(
        "valid" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "UserUpdate")
{
    $success = false;
    $message = "";
    $uploadOk = 1;
    $stm_update = "";
    $promoting_id = $_POST['user_id'];
    $email = $_POST['email'];
    unset($_POST['type']);
    unset($_POST['user_id']);
    foreach ($_POST as $key => $val)
    {
        $stm_update .= "" . $key . "='$val',";
    }
    $stm_update = substr($stm_update, 0, -1);
    $q1 = mysqli_num_rows(mysqli_query($db, "SELECT * FROM `users` WHERE `email` = '$email' and `user_id` != $promoting_id and `user_type` = (SELECT `user_type` FROM `users` WHERE `user_id` = $promoting_id )"));
    if ($q1 < 1)
    {
        if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
        {
            $target_dir = "../upload/logo/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if ($_FILES["image"]["size"] > 10 * MB)
            {
                $msg = "Sorry, your Logo Image is too large.";
                $uploadOk = 0;
            }
            $extallowed = array(
                "jpg",
                "jpeg",
                "png"
            );
            if (!in_array(strtolower($imageFileType) , $extallowed))
            {
                $msg = "Sorry,For Logo Image jpg & png extension files are allowed";
                $uploadOk = 0;
            }
            $filename = uniqid() . "." . $imageFileType;
            $filepath = $target_dir . $filename;
            if ($uploadOk != 0)
            {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
                {
                    $stm_col .= ",image";
                    $stm_val .= ",'" . $filename . "'";
                    $stm_update .= ",image='$filename'";
                }
                else
                {
                    $uploadOk = 0;
                    $msg = "Sorry, your file was not uploaded.";
                }
            }
        }
        if ($uploadOk == 0)
        {
            $success = false;
        }
        else
        {
            $query = mysqli_query($db, "update `users` set $stm_update where `user_id`=$promoting_id");
            if ($query)
            {
                $msg = "Profile Updated Sucessfully";
                $success = true;
            }
            else
            {
                $msg = "Profile Not Updated";
            }
        }
    }
    else
    {
        $msg = "Email id is already register with us";
    }
    echo json_encode(array(
        'success' => $success,
        'message' => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "UserStatus")
{
    $success = false;
    $msg = "";
    $url = "";
    $user_id = $_POST['id'];
    $status = $_POST['status'];
    if ($status == 1)
    {
        $msg = "Account Activated";
    }
    else
    {
        $msg = "Account Deactivated";
    }
    //echo "update user_id set status = '$status' where uid = '$user_id'";
    $query = $db->query("update user_id set status = '$status',status_desc='' where uid = '$user_id'");
    if ($query)
    {
        $success = true;
        if ($status == 1)
        {
            $msg = "Account Activated";
        }
        else
        {
            $msg = "Account Deactivated";
        }
    }
    else
    {
        $msg = "Status cannot be updated";
    }
    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "ManagePlan")
{
    $success = false;
    $message = "";
    $url = "";
    extract($_POST);

    $plan_desc = mysqli_escape_string($db, "$plan_desc");
    // echo $pb_amount_for_sponser_1.' '.$pb_amount_for_sponser_2.' '.$pb_amount_for_sponser_3.' '.$pb_amount_for_sponser_4.' '.$pb_amount_for_sponser_5.' '.$pb_amount_for_sponser_6;
    if (isset($plan_id) && !empty($plan_id))
    {
        //$binary_com_percentage = ($binary_com*$plan_amount)/100;
        $q1 = mysqli_query($db, "UPDATE `plans` SET  `title`='$title',`plan_name`='$plan_name',`plan_amount`='$plan_amount',`plan_desc`='$plan_desc',`levels`='$levels' WHERE `plan_id` = '$plan_id'");
        if ($q1)
        {
            $success = true;
            $message = "Plan Updated Successfully";
        }
        else
        {
            $message = "Failed to update";
        }
    }
    else
    {
        //$binary_com_percentage = ($binary_com*$plan_amount)/100;
        $q1 = mysqli_query($db, "INSERT INTO `plans` SET `title`='$title',`plan_name`='$plan_name',`plan_amount`='$plan_amount',`plan_desc`='$plan_desc',`levels`='$levels'") or die(myslqi_error($db));
        if ($q1)
        {
            $success = true;
            $message = "Plan Added Successfully";
        }
        else
        {
            $message = "Failed to Add";
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Delete Offer
*/
if (isset($_POST["type"]) && $_POST["type"] == "DelPlan")
{
    $success = false;
    $message = "";
    $plan_id = $_POST['plan_id'];
    $delrecord = mysqli_query($db, "DELETE FROM plans WHERE plan_id = '$plan_id'");
    //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Plan Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "ManagePin")
{
    $success = false;
    $message = "";
    $url = "";
    $plan_id = $_POST["plan_id"];
    $no_of_pin = $_POST["no_of_pin"];
    if (addnewpin($db, $plan_id, $no_of_pin) == 1)
    {
        $success = true;
        $message = "New Transaction Pin Added.";
    }
    else
    {
        $message = "Transaction Pin Not added.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "DelPin")
{
    $success = false;
    $message = "";
    $pin_id = $_POST['pin_id'];
    $delrecord = mysqli_query($db, "DELETE FROM transpin WHERE pin_id = '$pin_id'");
    //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Pin Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "RemoveSelectedPin")
{
    $success = false;
    $message = "";
    if (count($_POST['pin_id']) > 0)
    {
        $pin_id = implode(",", $_POST['pin_id']);
        $delrecord = mysqli_query($db, "DELETE FROM transpin WHERE pin_id in($pin_id)");
        //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
        if ($delrecord)
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
        "success" => $success,
        "message" => $message
    ));
}
//set level
if (isset($_POST["type"]) && $_POST["type"] == "setLevelPercentage")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    $level1 = json_encode($level, true);
    if (isset($plan_id) && !empty($plan_id))
    {
        $query = $db->query("update plans set level_perc = '$level1' where plan_id = '$plan_id'");
        if ($query)
        {
            $success = true;
            $msg = "Level Percentage Updated Successfully";
        }
        else
        {
            $msg = "Failed!";
        }
    }
    else
    {
        $msg = "Failed!";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
//set Royalty
if (isset($_POST["type"]) && $_POST["type"] == "setRoyaltyAmount")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    if (isset($plan_id) && !empty($plan_id))
    {
        $query = $db->query("update plans set royal_amount = '$royal_amount' where plan_id = '$plan_id'");
        if ($query)
        {
            $success = true;
            $msg = "Royalty Amount Updated Successfully";
        }
        else
        {
            $msg = "Failed!";
        }
    }
    else
    {
        $msg = "Failed!";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
//Remove selected user
if (isset($_POST["type"]) && $_POST["type"] == "RemoveSelecteduser")
{
    $success = false;
    $message = "";
    $user_ids = isset($_POST['user_id']) && !empty($_POST['user_id']) ? count($_POST['user_id']) : 0;
    if ($user_ids > 0)
    {
        $user_id = implode(",", $_POST['user_id']);
        $delrecord = mysqli_query($db, "DELETE FROM user_id WHERE uid in($user_id)");
        //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
        if ($delrecord)
        {
            $success = true;
            $message = "Users Deleted Successfully";
        }
        else
        {
            $message = "Some Problem Occur, While Deleting.";
        }
    }
    else
    {
        $message = "Select Atleast one user to delete";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Check Valid Pin
*/
if (isset($_POST["type"]) && $_POST["type"] == "checkValidPin")
{
    $success = false;
    $message = "";
    $username = "";
    $url = "";
    $pin_no = $_POST['pin_no'];
    if (isset($pin_no))
    {
        $msg = checkTransPin($db, $pin_no);
        if ($msg == 1)
        {
            $success = true;
        }
        else
        {
            $message = $msg;
        }
    }
    else
    {
        $message = "Enter PIN No";
    }
    echo json_encode(array(
        "valid" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "getParentId")
{
    $success = false;
    $message = "";
    $parent_id = "";
    $sponsor_id = $_POST['sponsor_id'];
    $position = $_POST['position'];
    if (isset($sponsor_id) && !empty($sponsor_id) && isset($position) && !empty($position))
    {
        $parent_id = GetValidParentId($db, $sponsor_id, $position);
        $success = true;

    }
    else if (!isset($position) || empty($position))
    {
        $message = "Select position";
    }
    else
    {
        $message = "No Sponsor Found!";
    }
    echo json_encode(array(
        "valid" => $success,
        "message" => $message,
        "parent_id" => $parent_id
    ));
}
/* add / Edit User */
/*if(isset($_POST["type"]) && $_POST["type"]== 'AddEditUser')
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
                    if($chkqry >= 2)
                    {
                        $msg = "You can not add User under this parent,Parent Already have 2 Childs.";
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
                                        $url = str_replace("includes/adminfunction","login",$loginurl);
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
                                        
                                        if(isset($email) && !empty($email))
                                        {
                                            $mail=send_phpmail($tname,$to,"","",$subject,$content);
                                        }
                                        $message = "Welcome to BRAND MAKERS. \n Login Details: \n Username : $username \n password : $password \n Click Here To Login  $url";
                                        //sendSMS($db,$uid,$message);
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
            $qry1="UPDATE `user_detail` SET `first_name`='$fname', `last_name`='$lname', `gender`='$gender', `email`='$email', `mobile`='$mobile_no', `pan_no`='$pan_no' WHERE `uid`=$id";
            $q2=mysqli_query($db,$qry1); 
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
}*/

if (isset($_POST["type"]) && $_POST["type"] == 'AddEditUser_old')
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    $id = $txtid;
    if ($id == '')
    {
        if (isset($parent_id) && !empty($parent_id) && isset($pin_no) && !empty($pin_no) && isset($sponsor_id) && !empty($sponsor_id))
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
                                    $qry = "INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`, `pin`,`paired`) VALUES ('$username','$password',now(),now(),'$pin_no','$paired')";
                                    $q = mysqli_query($db, $qry);
                                    if ($q)
                                    {
                                        $uid = mysqli_insert_id($db);
                                        $qry1 = "Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
                                        $q1 = mysqli_query($db, $qry1);
                                        if ($q)
                                        {
                                            $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                            UserPairing($db, $uid, $parent_id, $sponsor_id);

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
                                            $fpay = FirstRegisterPayment($db, $uid, $pay_parent_id, $is_sponsor);

                                            if (isset($email) && !empty($email))
                                            {
                                                $mail = send_phpmail($tname, $to, "", "", $subject, $content);
                                            }
                                            $message = "Welcome to BRAND MAKERS. \n Login Details: \n Username : $username \n password : $password \n Click Here To Login  $url";
                                            sendSMS($db, $uid, $message);
                                            //var_dump($fpay);
                                            //sendMultipleEmailAttachment($to,$fname." ".$lname,"",$subject,$content,array());
                                            send_phpmail($to, $fname . " " . $lname, "", "", $subject, $content);
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
        else if (isset($pin_no) && empty($pin_no))
        {
            $msg = "Pin No Is Required";
        }
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
            $q2 = mysqli_query($db, $qry1);
            $success = true;
            $msg = "User Updated Successfully";
        }
        else
        {
            $msg = "Some Promlem Occur try after sometime";
        }
    }
    echo json_encode(array(
        'valid' => $success,
        'url' => $url,
        'msg' => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == 'AddEditUser_with_parent_id')
{
    $success = false;
    $msg = "";
    $url = "";
    //print_r($_POST);
    extract($_POST);
    $id = $txtid;
    if ($id == '')
    {
        if (isset($parent_id) && empty($parent_id))
        {
            $res = GetUserCountPos($db, $sponsor_id, $position);
            $parent_id = end($res);
            $sp1 = mysqli_query($db, "select uname,paired from user_id where uid='$parent_id'");
            $spno = mysqli_num_rows($sp1);
            if ($spno > 0)
            {
                $userid = mysqli_fetch_assoc($sp1);
                $parent_id = $userid['uname'];
            }
            else
            {
                $msg = "Enter valid Parent Id!";
            }
        }
        if (isset($parent_id) && !empty($parent_id) && isset($pin_no) && !empty($pin_no) && isset($sponsor_id) && !empty($sponsor_id))
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
                                    $qry = "INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`, `pin`,`paired`) VALUES ('$username','$password',now(),now(),'$pin_no','$paired')";
                                    $q = mysqli_query($db, $qry);
                                    if ($q)
                                    {
                                        $uid = mysqli_insert_id($db);
                                        $qry1 = "Insert into user_detail(uid,first_name,last_name,gender,email,mobile,pan_no) values($uid,'$fname','$lname','$gender','$email','$mobile_no','$pan_no')";
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
                                            $fpay = FirstRegisterPayment($db, $uid, $pay_parent_id, $is_sponsor);

                                            if (isset($email) && !empty($email))
                                            {
                                                $mail = send_phpmail($tname, $to, "", "", $subject, $content);
                                            }
                                            $message = "Welcome to BRAND MAKERS. \n Login Details: \n Username : $username \n password : $password \n Click Here To Login  $url";
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
        else if (isset($pin_no) && empty($pin_no))
        {
            $msg = "Pin No Is Required";
        }
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
            $q2 = mysqli_query($db, $qry1);
            $success = true;
            $msg = "User Updated Successfully";
        }
        else
        {
            $msg = "Some Promlem Occur try after sometime";
        }
    }
    echo json_encode(array(
        'valid' => $success,
        'url' => $url,
        'msg' => $msg
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
if (isset($_POST['changeUserpassword']))
{
    $success = false;
    $msg = "";
    $url = "";
    //print_r($_POST);
    extract($_POST);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $q = mysqli_fetch_assoc(mysqli_query($db, "SELECT t1.uname,t2.`mobile` FROM `user_id` t1 join user_detail t2 on t1.uid = t2.uid WHERE t1.uid = $uid"));
    $password = $_POST['new_password'];
    if ($new_password == $confirm_password)
    {
        $query = mysqli_query($db, "UPDATE `user_id` SET `password`= '$confirm_password' WHERE `uid` = $uid");
        if ($query)
        {
            /* $message = "Global Rich Marketing New Password \n Login Details: \n Username : $q['uname'] \npassword : $_POST['new_password'] \n Click Here To Login  $url";
             sendSMS($db,$uid,$message);*/
            $success = true;
            $msg = " Password Updated successfully. ";
        }
        else
        {
            $msg = " Password Cannot be Updated. ";
        }
    }
    else
    {
        $msg = " Password is not match. ";
    }
    echo json_encode(array(
        'valid' => $success,
        'url' => $url,
        'msg' => $msg
    ));
}
//Transfer Pin
if (isset($_POST["type"]) && $_POST["type"] == "ManageTransPin")
{
    $success = false;
    $message = "";
    $url = "";
    $plan_id = $_POST["plan_id"];
    $no_of_pin = $_POST["no_of_pin"];
    $uid = $_POST["sponser"];
    $mlmid = $_SESSION['mlmid'];
    $x = addtransferpin($db, $mlmid, $uid, $plan_id, $no_of_pin);
    if ($x == 1)
    {
        $success = true;
        $message = "Pin has been transfer.";
    }
    else
    {
        $message = "Some of the pin cannot be transfer.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Payut Mark As paid
if (isset($_POST["type"]) && $_POST["type"] == "PayoutMarkPaid")
{
    $success = false;
    $message = "";
    $url = "";
    $x = clear_allpayout1($db, $_POST['uid']);
    if ($x == 1)
    {
        $success = true;
        $message = "Payment has been cleared";
    }
    else
    {
        $message = $x;
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "PayoutMarkPaid_rank")
{
    $success = false;
    $message = "";
    $url = "";
    $x = clear_allpayout1_rank($db, $_POST['uid']);
    if ($x == 1)
    {
        $success = true;
        $message = "Payment has been cleared";
    }
    else
    {
        $message = $x;
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Payut Mark All As paid
if (isset($_POST["type"]) && $_POST["type"] == "AllPayoutPaid")
{
    $success = false;
    $message = "";
    $url = "";
    $x = 0;
    $pay_id = implode(',', $_POST['uid']);
    $q1 = mysqli_query($db, "SELECT * FROM `payout` where FIND_IN_SET(`uid`,'$pay_id') AND cleared = 0 ");
    if (mysqli_num_rows($q1) > 0)
    {
        $date = date('Y-m-d G:i:s');
        while ($r1 = mysqli_fetch_assoc($q1))
        {
            $id = $r1["id"];
            $q3 = mysqli_query($db, "UPDATE `payout` SET `cleared`= 1,`cleared_date`= '$date' WHERE `id` = $id");
            if ($q3)
            {
                $c[] = 1;
            }
            else
            {
                $c[] = 0;
            }
        }
        if (in_array(0, $c))
        {
            $message = "Some of the payout not cleared";
        }
        else
        {
            $success = true;
            $message = "Payment has been cleared";
        }
    }
    else
    {
        return "No Payout to clear";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Update Profile
if (isset($_POST["type"]) && $_POST["type"] == "UpdateProfile_old")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    $pan_card_image = "";
    $adhar_card_image_front = "";
    $adhar_card_image_back = "";

    $mlmid = $_SESSION['mlmid'];
    $sql1 = mysqli_query($db, "SELECT * FROM user_bank WHERE uid = '$mlmid'") or die(mysqli_error($db));
    $row1 = mysqli_fetch_assoc($sql1);
    $pan_card_image = $row1['pan_card_image'];
    $adhar_card_image_front = $row['adhar_card_image_front'];
    $adhar_card_image_back = $row1['adhar_card_image_back'];

    if ($_FILES['pan_card_image']['error'] == 0)
    {
        $ext = explode('.', $_FILES['pan_card_image']['name']);
        $pan_card_image = time() . '.' . $ext[1];
        move_uploaded_file($_FILES['pan_card_image']['tmp_name'], '../upload/user_upload/' . $pan_card_image);
    }
    if ($_FILES['adhar_card_image_front']['error'] == 0)
    {
        $ext = explode('.', $_FILES['adhar_card_image_front']['name']);
        $adhar_card_image_front = time() . $ext[1];
        move_uploaded_file($_FILES['adhar_card_image_front']['tmp_name'], '../upload/user_upload/' . $adhar_card_image_front);
    }
    if ($_FILES['adhar_card_image_back']['error'] == 0)
    {
        $ext = explode('.', $_FILES['adhar_card_image_back']['name']);
        $adhar_card_image_back = time() . $ext[1];
        move_uploaded_file($_FILES['adhar_card_image_back']['tmp_name'], '../upload/user_upload/' . $adhar_card_image_back);
    }
    $address = mysqli_real_escape_string($db, $_POST["address"]);
    $q1 = $db->query("UPDATE `user_detail` SET `first_name`=  '$first_name',`last_name`= '$last_name',`gender`= '$gender',`mobile`= '$mobile', `phone`= '$phone', `pan_no`= '$pan_no',  `state`= '$state', `city`= '$city', `zip`= '$zip', `address`= '$address', `relation`= '$relation', `country`= '$country',`beneficiary`= '$beneficiary' WHERE  uid = '$mlmid'");
    if ($q1)
    {
        $q2 = $db->query("UPDATE `user_bank` SET `bank_name`= '$bank_name',`branch_name`= '$branch_name',`acnumber`= '$account_number',`bankholder`= '$holder_name',`swiftcode`= '$swift_code',`pan_card_image`='$pan_card_image',`adhar_card_image_front`='$adhar_card_image_front',`adhar_card_image_back`='$adhar_card_image_back' where uid = '$mlmid'");
        if ($q2)
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
        "success" => $success,
        "message" => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "UpdateProfile")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    $stm_update = '';

    unset($_POST['type']);
    unset($_POST['info']);
    $mlmid = $_SESSION['mlmid'];
    foreach ($_POST as $key => $val)
    {
        $val = mysqli_real_escape_string($db, $val);
        $stm_update .= "" . $key . "='$val',";
    }
    $stm_update = substr($stm_update, 0, -1);
    //echo "update `$info` set $stm_update where `uid`=$mlmid";
    $query = mysqli_query($db, "update `$info` set $stm_update where `uid`=$mlmid");
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
        "success" => $success,
        "message" => $msg
    ));
}
//Generate Payout for plan1
if (isset($_POST["type"]) && $_POST["type"] == "GenerateDirectPlan")
{
    $success = false;
    $message = "";
    $url = "";
    //$c=array();
    $c = Generatepayout($db);
    if (in_array(0, $c))
    {

        $message = "Some of the payout not generated";
    }
    elseif (in_array(1, $c))
    {
        $success = true;
        $message = "Payment Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }
    /*if($x == 1)
    {
        $success = true;
        $message = "Payment Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }*/
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Generate Payout for plan2
if (isset($_POST["type"]) && $_POST["type"] == "GenerateSingleLeg")
{
    $success = false;
    $message = "";
    $url = "";
    //$c1=$c=array();
    $c1 = Generateplan2payout($db);
    if (in_array(1, $c1))
    {
        $c = Generateplan3payout($db);
        if (in_array(0, $c))
        {
            $message = "Some of the payout not generated";
        }
        elseif (in_array(1, $c))
        {
            $success = true;
            $message = "Payment Generated Successfully";
        }
        else
        {
            $message = "No Payout to generate";
        }
    }
    else
    {
        $message = "No Payout to generate";
    }

    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

//Generate Payout for Binary
if (isset($_POST["type"]) && $_POST["type"] == "BinaryPayoutGenerate")
{
    $success = false;
    $message = "";
    $url = "";
    //$c1=$c=array();
    $c = GenerateBinaryPayout($db);
    if (in_array(0, $c))
    {
        $message = "Some of the payout not generated";
    }
    elseif (in_array(1, $c))
    {
        $success = true;
        $message = "Payment Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }

    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

// Generate Binary for Bonus
if (isset($_POST["type"]) && $_POST["type"] == "GenerateBonusPayout")
{
    $success = false;
    $message = "";
    $url = "";
    //$c1=$c=array();
    $c = GenerateBonusPayout($db);
    if (in_array(0, $c))
    {
        $message = "Some of the payout not generated";
    }
    elseif (in_array(1, $c))
    {
        $success = true;
        $message = "Payment Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }

    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "GenerateRoiPayout")
{
    $success = false;
    $message = "";
    $url = "";
    //$c1=$c=array();
    $c = GenerateRoiPayout($db);
    if (in_array(0, $c))
    {
        $message = "Some of the payout not generated";
    }
    elseif (in_array(1, $c))
    {
        $success = true;
        $message = "Payment Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }

    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Generate Payout for Binary
if (isset($_POST["type"]) && $_POST["type"] == "GenerateReferalPayout")
{
    $success = false;
    $message = "";
    $url = "";
    //$c1=$c=array();
    $c1 = GenerateRefPayout1($db);
    if (in_array(1, $c1))
    {
        $c = GenerateRefPayout2($db);
        if (in_array(0, $c))
        {
            $message = "Some of the payout not generated";
        }
        elseif (in_array(1, $c))
        {
            $success = true;
            $message = "Payment Generated Successfully";
        }
        else
        {
            $message = "No Payout to generate";
        }
    }
    else
    {
        $message = "No Payout to generate";
    }

    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Generate Payout for plan3
if (isset($_POST["type"]) && $_POST["type"] == "plan3")
{
    $success = false;
    $message = "";
    $url = "";
    /*$r1=RoyaltyUser($db);
    $r2=RoyaltyPayoutUser($db);
    $c = GenerateRoyaltyPayout($db);*/
    $c = RepurchasePayout($db);
    if (in_array(0, $c))
    {
        $message = "Some of the payout not generated";
    }
    elseif (in_array(1, $c))
    {
        $success = true;
        $message = "Payment Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST['type']) && $_POST['type'] == 'CheckPassword')
{
    $success = false;
    $message = "";
    $uid = isset($_POST['uid']) ? $_POST['uid'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (isset($uid) && !empty($uid) && isset($password) && !empty($password))
    {
        $r1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT * from user_id where uid='$uid'"));
        //echo $r1['password'];
        if ($password == $r1['password'])
        {
            $success = true;
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
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST['type']) && $_POST['type'] == 'ChecktPassword')
{
    $success = false;
    $message = "";
    $uid = isset($_POST['uid']) ? $_POST['uid'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (isset($uid) && !empty($uid) && isset($password) && !empty($password))
    {
        $r1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT * from user_id where uid='$uid'"));
        //echo $r1['password'];
        if ($password == $r1['tpassword'])
        {
            $success = true;
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
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["CheckSponser_old"]))
{
    $message = "User not found under this sponser";
    $status = false;
    $newid = "";
    $sid = $_SESSION['mlmid'];
    $cid = trim($_POST['id']);
    //$sql = "SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uname = '$cid'";
    $sql = "SELECT t1.*,t2.*,t3.parent_id,t3.pair_id from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t1.uname = '$cid'";
    $q1 = mysqli_query($db, $sql);
    if (mysqli_num_rows($q1) > 0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $cid = $r1['uid'];
        if ($cid == $sid)
        {
            $message = "User you searched is self sponser";
        }
        else if ($cid > $sid)
        {
            if ($r1["parent_id"] != '')
            {
                $parent_id = $r1['parent_id'];
                $back_id = isset($r1['pair_id']) && $r1['pair_id'] > 0 ? $r1['pair_id'] : $sid;
                $newid = $cid . "_" . $back_id;
            }
            else
            {
                $q3 = mysqli_query($db, "SELECT `pair_id` FROM `pairing` WHERE `uid` = '$cid' ");
                if (mysqli_num_rows($q3) > 0)
                {
                    $r3 = mysqli_fetch_assoc($q3);
                    $back_id = isset($r1['pair_id']) && $r1['pair_id'] > 0 ? $r1['pair_id'] : $sid;;
                }
                $newid = $r1["uid"] . "_" . $back_id;
            }
            $status = checkIsValidChild($db, $sid, $cid);
        }
    }
    else
    {
        $message = "User ID is not registered with us";
    }
    echo json_encode(array(
        "valid" => $status,
        "message" => $message,
        "id" => $newid
    ));
}
if (isset($_POST["CheckSponser"]))
{
    $message = "User not found under this sponser";
    $status = false;
    $newid = "";
    $sid = $_SESSION['mlmid'];
    $cid = $_POST['id'];
    //$sql = "SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uname = '$cid'";
    $sql = "SELECT t1.*,t2.*,t3.parent_id,t3.pair_id from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t1.uname = '$cid'";
    $q1 = mysqli_query($db, $sql);
    if (mysqli_num_rows($q1) > 0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $cid = $r1['uid'];
        if ($cid == $sid)
        {
            $message = "User you searched is self sponser";
        }
        else if ($cid > $sid)
        {
            if ($r1["parent_id"] != '')
            {
                $parent_id = $r1['parent_id'];
                //$back_id = isset($r1['pair_id']) && $r1['pair_id'] > 0?$r1['pair_id']:$sid;
                $back_id = isset($r1['parent_id']) && $r1['parent_id'] > 0 ? $r1['parent_id'] : $sid;
                $newid = $cid . "_" . $back_id;
            }
            else
            {
                $q3 = mysqli_query($db, "SELECT `parent_id` FROM `pairing` WHERE `uid` = '$cid' ");
                if (mysqli_num_rows($q3) > 0)
                {
                    $r3 = mysqli_fetch_assoc($q3);
                    $back_id = isset($r1['parent_id']) && $r1['parent_id'] > 0 ? $r1['parent_id'] : $sid;;
                }
                $newid = $r1["uid"] . "_" . $back_id;
            }
            $status = checkIsValidChild($db, $sid, $cid);
        }
    }
    else
    {
        $message = "User ID is not registered with us";
    }
    echo json_encode(array(
        "valid" => $status,
        "message" => $message,
        "id" => $newid
    ));
}
//set level
if (isset($_POST["type"]) && $_POST["type"] == "AddReward")
{
    $success = false;
    $msg = "";
    $url = "";
    $stm_update = ''; //Image
    $uploadOk = 1;
    extract($_POST);
    /*if(isset($plan_id) && !empty($plan_id))
     {*/
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
    {
        $target_dir = "../upload/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $imageFileType;
        $filepath = $target_dir . $filename;
        if ($_FILES["image"]["size"] > 10 * MB)
        {
            $msg = "Sorry, Image is too large.";
            $uploadOk = 0;
        }
        $extallowed = array(
            "jpg",
            "jpeg",
            "png"
        );
        if (!in_array(strtolower($imageFileType) , $extallowed))
        {
            $msg = "Sorry,For Image jpg & png extension files are allowed";
            $uploadOk = 0;
        }
        if ($uploadOk != 0)
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
            {
                $stm_update = ", `image`='$filename'";
            }
            else
            {
                $uploadOk = 0;
                $msg = "Sorry, image was not uploaded.";
            }
        }
    }
    if ($uploadOk == 1)
    {
        $rewards_desc = mysqli_real_escape_string($db, $_POST["rewards_desc"]);
        if (!empty($txtid))
        {
            $q1 = mysqli_query($db, "UPDATE `rewards_plans` SET `name` = '$name',`amount`='$amount',`ramount` = '$ramount',`rewards_desc`='$rewards_desc' $stm_update WHERE `id` = '$txtid'");
            if ($q1)
            {
                $success = true;
                $msg = "Reward Plan Updated Successfully";
            }
            else
            {
                $msg = "Failed to update";
            }
        }
        else
        {
            $q1 = mysqli_query($db, "INSERT INTO `rewards_plans` SET `name` = '$name',`amount`='$amount',`ramount` = '$ramount',`rewards_desc`='$rewards_desc' $stm_update") or die(mysqli_error($db));
            if ($q1)
            {
                $success = true;
                $msg = "Reward Plan Added Successfully";
            }
            else
            {
                $msg = "Failed to Add";
            }
        }
    }
    else
    {
        $msg = "Failed!";
    }
    /*}
    else
    {
        $msg = "Select Plan For Reward";
    }*/
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
/*
 * Delete Offer
*/
if (isset($_POST["type"]) && $_POST["type"] == "DelRewardPlan")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM rewards_plans WHERE id = '$id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Reward Plan Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "MarkRewardPaid")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $x = clear_reward($db, $id);
    if ($x == 1)
    {
        $success = true;
        $message = "Payment has been cleared";
    }
    else
    {
        $message = "Some Problem Occur, While Paying.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "MarkAllRewardPaid")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $x = clear_allreward($db);
    if ($x == 1)
    {
        $success = true;
        $message = "Payment has been cleared";
    }
    else
    {
        $message = "Some Problem Occur, While Paying.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//set level
if (isset($_POST["type"]) && $_POST["type"] == "EditPayoutDetail")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    //echo "<pre>";var_dump($payout);
    if (isset($payout) && !empty($payout))
    {
        foreach ($payout as $key => $value)
        {
            extract($value);
            $query = $db->query("update royalty_detail set amount = '$amount',unit_price = '$unit_price' where rid = '$rid'");
        }
        if ($query)
        {
            $success = true;
            $msg = "Payout Detail Updated Successfully";
        }
        else
        {
            $msg = "Failed!";
        }
    }
    else
    {
        $msg = "Failed!";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "DeactivateUser")
{
    $success = false;
    $msg = "";
    $url = "";
    $user_id = $_POST['id'];
    $status = 0;
    $status_desc = $_POST['status_desc'];
    if ($status == 1)
    {
        $msg = "Account Activated";
    }
    else
    {
        $msg = "Account Deactivated";
    }
    //echo "update user_id set status = '$status' where uid = '$user_id'";
    $query = $db->query("update user_id set status = '$status',status_desc = '$status_desc' where uid = '$user_id'");
    if ($query)
    {
        $success = true;
        if ($status == 1)
        {
            $msg = "Account Activated";
        }
        else
        {
            $msg = "Account Deactivated";
        }
    }
    else
    {
        $msg = "Status cannot be updated";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "UserRankPayout")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    $user_id = $_POST['user_id'];
    $cdate = date("Y-m-d H:i");
    $query = mysqli_query($db, "INSERT INTO `rank_payout` SET  `uid`='$user_id', `rank`='$rank_name', `amount`='$amount', `date`='$date', `cdate`='$cdate'");
    if ($query)
    {
        $success = true;
        $msg = "Paid Successfully";
    }
    else
    {
        $msg = "Failed!";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
//add news
if (isset($_POST["type"]) && $_POST["type"] == "AddNews")
{
    $success = false;
    $msg = "";
    $url = "";
    $stm_update = ''; //Image
    $uploadOk = 1;

    extract($_POST);
    $description = mysqli_real_escape_string($db, $_POST["description"]);
    if (!empty($txtid))
    {
        $q1 = mysqli_query($db, "UPDATE `news` SET `title` = '$title',`description`='$description',`date`='$cdate' WHERE `id` = '$txtid'");
        if ($q1)
        {
            $success = true;
            $msg = "News Updated Successfully";
        }
        else
        {
            $msg = "Failed to update";
        }
    }
    else
    {
        $q1 = mysqli_query($db, "INSERT INTO `news` SET `title` = '$title',`description`='$description',`date` = '$cdate'") or die(mysqli_error($db));
        if ($q1)
        {
            $success = true;
            $msg = "News Added Successfully";
        }
        else
        {
            $msg = "Failed to Add";
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
/*
 * Delete Offer
*/
if (isset($_POST["type"]) && $_POST["type"] == "DelNews")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM news WHERE id = '$id'");
    if ($delrecord)
    {
        $success = true;
        $message = "News Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//add news
if (isset($_POST["type"]) && $_POST["type"] == "AddWebNews")
{
    $success = false;
    $msg = "";
    $url = "";
    $stm_update = ''; //Image
    $uploadOk = 1;
    extract($_POST);
    $description = mysqli_real_escape_string($db, $_POST["description"]);

    if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
    {
        $target_dir = "../upload/webnews/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $imageFileType;
        $filepath = $target_dir . $filename;
        if ($_FILES["image"]["size"] > 10 * MB)
        {
            $msg = "Sorry, Image is too large.";
            $uploadOk = 0;
        }
        $extallowed = array(
            "jpg",
            "jpeg",
            "png"
        );
        if (!in_array(strtolower($imageFileType) , $extallowed))
        {
            $msg = "Sorry,For Image jpg & png extension files are allowed";
            $uploadOk = 0;
        }
        if ($uploadOk != 0)
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
            {
                $stm_update = ", `image`='$filename'";
            }
            else
            {
                $uploadOk = 0;
                $msg = "Sorry, image was not uploaded.";
            }
        }
    }
    if ($uploadOk == 1)
    {
        if (!empty($txtid))
        {
            $q1 = mysqli_query($db, "UPDATE `web_news` SET `title` = '$title',`description`='$description' $stm_update WHERE `id` = '$txtid'");
            if ($q1)
            {
                $success = true;
                $msg = "News Updated Successfully";
            }
            else
            {
                $msg = "Failed to update";
            }
        }
        else
        {
            $q1 = mysqli_query($db, "INSERT INTO `web_news` SET `title` = '$title',`description`='$description',`date` = '$cdate' $stm_update") or die(mysqli_error($db));
            if ($q1)
            {
                $success = true;
                $msg = "News Added Successfully";
            }
            else
            {
                $msg = "Failed to Add";
            }
        }
    }
    else
    {
        $msg = "Failed!";
    }

    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
/*
 * Delete Offer
*/
if (isset($_POST["type"]) && $_POST["type"] == "DelWebNews")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM web_news WHERE id = '$id'");
    if ($delrecord)
    {
        $success = true;
        $message = "News Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/************************************** Repurchase ***************************************/
//Manage Product
/************************************* Repurchase **************************************/
//Manage Product
if(isset($_POST["type"]) && $_POST["type"] == "ManageProduct")
{
    $success = false;
    $message = "";
    $url="";
    extract($_POST);
    $deal_of_day=isset($_POST['deal_of_day']) && $_POST['deal_of_day']==1?1:0;
    $trending=isset($_POST['trending']) && $_POST['trending']==1?1:0;
    $product_desc = mysqli_escape_string($db,"$product_desc");
        $update_str="";
        $filename="";
        $uploadOk = 1;
        if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
            $target_dir = "../upload/product/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($_FILES["image"]["size"] > 5000000) {
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

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
                    $update_str=",image='$filename'";
                } else {
                    $uploadOk = 0;
                    $msg = "Sorry, your file was not uploaded.";
                }
            }
        }
        $fileList = array();
        if (isset($_FILES["prdimage"]) && count($_FILES["prdimage"]["name"]) > 0 && $_FILES["prdimage"]["name"][0] !== "")
        {
            $ii=0;
            foreach ($_FILES["prdimage"]["name"] as $file){
                if (isset($file) && $file !== ""){
                    $msg = "Sorry, your file was not uploaded";
                    $status = false;
                    $target_dir = "../upload/product/";
                    $target_file = $target_dir . basename($file);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    $extallowed = array("jpg","jpeg","png","doc","docx","xls","xlsx","pdf");
                    if (!in_array(strtolower($imageFileType),$extallowed)){
                        $msg = "Sorry, this extension files are allowed";
                        $status = false;
                        $uploadOk = 0;
                    }
                    $file_id = uniqid() . "_$ii." . $imageFileType;
                    $fileList[] = $file_id;
                }
                $ii++;
            }
            foreach ($_FILES["prdimage"]["size"] as $file){
                if ($file > 10000000){
                    echo "Sorry, your file is too large.";
                    $msg = "Sorry, your file is too large";
                    $status = false;
                    $uploadOk = 0;
                }
            }

            $i=0;
            foreach ($_FILES["prdimage"]["tmp_name"] as $file) {

                if (!move_uploaded_file($file, $target_dir . $fileList[$i]))
                    $uploadOk = 0;

                $i++;
            }

        } /*else {
            $msg = "Please fill all required fields";
            $status = false;
        }*/

        if ($uploadOk == 0) {
            $success=false;
        }
        else 
        {

            if(isset($product_id) && !empty($product_id))
            {
                $q1 = mysqli_query($db,"UPDATE `products` SET `name`='$name',`plan_id`='$plan_id',`mrp`='$mrp',`pv`='$pv',`member_price`='$member_price',`selling_price`='$selling_price',`product_desc`='$product_desc',date='$cdate' $update_str WHERE `product_id` = '$product_id'") or die(mysqli_error($db));
                if($q1)
                {
                    foreach ($fileList as $fl){
                        $isql="INSERT INTO prd_images (image,product_id,date) VALUES ('$fl','$product_id','$cdate')";
                        $query = mysqli_query($db, $isql);
                    }
                    $success = true;
                    $message = "Product Updated Successfully";
                }
                else
                {
                    $message = "Failed to update";
                }
            }
            else
            {
                $q1 = mysqli_query($db,"INSERT INTO `products` SET `name`='$name',`plan_id`='$plan_id',`mrp`='$mrp',`pv`='$pv',`member_price`='$member_price',`selling_price`='$selling_price',`product_desc`='$product_desc',date='$cdate' $update_str") or die(mysqli_error($db));
                if($q1)
                { 
                    $product_id=mysqli_insert_id($db);
                    foreach ($fileList as $fl){
                        $query = mysqli_query($db, "INSERT INTO prd_images (image,product_id,date) VALUES ('$fl','$product_id','$cdate')");
                    }
                    $success = true;
                    $message = "Product Added Successfully";
                }
                else
                {
                    $message = "Failed to Add";
                }
            }
        }
    echo json_encode(array(
        "success"=>$success,
        "message" => $message
    ));
}
/*
/*
 * Delete Other Product
*/
if (isset($_POST["type"]) && $_POST["type"] == "deleteOtherProduct")
{
    $success = false;
    $message = "";
    $product_id = $_POST['product_id'];
    $delrecord = mysqli_query($db, "DELETE FROM products WHERE product_id = '$product_id'");
    //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Product Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Delete product Images
*/
if (isset($_POST['delbanqimg']))
{
    $image_id = $_POST["image_id"];
    $r1 = mysqli_fetch_assoc(mysqli_query($db, "select * from prd_images where id = '{$image_id}'"));
    $q1 = mysqli_query($db, "DELETE FROM `prd_images` WHERE `id` = '{$image_id}'");
    if ($q1)
    {
        if (unlink('../upload/product/' . $r1["image"]))
        {
            echo json_encode(array(
                "valid" => 1,
                "message" => "Image deleted successfully"
            ));
        }
        else
        {
            echo json_encode(array(
                "valid" => 0,
                "message" => "Image not found"
            ));
        }
    }
    else
    {
        echo json_encode(array(
            "valid" => 0,
            "message" => "Image cannot be deleted"
        ));
    }
}
if (isset($_POST["type"]) && $_POST["type"] == "ManagerPlan")
{
    $success = false;
    $message = "";
    $url = "";
    extract($_POST);
    $plan_desc = mysqli_escape_string($db, "$plan_desc");
    if (isset($plan_id) && !empty($plan_id))
    {
        $q1 = mysqli_query($db, "UPDATE `rplans` SET `plan_name`='$plan_name',`plan_amount`='$plan_amount',`plan_desc`='$plan_desc' WHERE `plan_id` = '$plan_id'");
        if ($q1)
        {
            $success = true;
            $message = "Re-purchase Plan Updated Successfully";
        }
        else
        {
            $message = "Failed to update";
        }
    }
    else
    {
        $q1 = mysqli_query($db, "INSERT INTO `rplans` SET `plan_name`='$plan_name',`plan_amount`='$plan_amount',`plan_desc`='$plan_desc'");
        if ($q1)
        {
            $success = true;
            $message = "Re-purchase Plan Added Successfully";
        }
        else
        {
            $message = "Failed to Add";
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Delete Repurchase plan
*/
if (isset($_POST["type"]) && $_POST["type"] == "DelrPlan")
{
    $success = false;
    $message = "";
    $plan_id = $_POST['plan_id'];
    $delrecord = mysqli_query($db, "DELETE FROM rplans WHERE plan_id = '$plan_id'");
    //$delrecord = mysqli_query($db,"UPDATE `offers` SET `offer_status`=2 WHERE `offer_id` = '$offer_id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Re-purchase Plan Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//set level
if (isset($_POST["type"]) && $_POST["type"] == "setLevelIncome")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    $level1 = json_encode($level, true);
    if (isset($plan_id) && !empty($plan_id))
    {
        $query = $db->query("update rplans set level_perc = '$level1' where plan_id = '$plan_id'");
        if ($query)
        {
            $success = true;
            $msg = "Level Income Updated Successfully";
        }
        else
        {
            $msg = "Failed!";
        }
    }
    else
    {
        $msg = "Failed!";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "RejectPINRequest")
{
    $success = false;
    $message = "";
    $req_id = $_POST['req_id'];
    $req = mysqli_query($db, "UPDATE `reqpin` SET `status`=2 WHERE `id` = '$req_id'");
    if ($req)
    {
        $success = true;
        $message = "Request Rejected Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Approve Pin Request
if (isset($_POST["type"]) && $_POST["type"] == "PINReqApprove")
{
    $success = false;
    $message = "";
    $url = "";
    $x = 0;
    $req_id = implode(',', $_POST['request']);
    $q1 = mysqli_query($db, "SELECT * FROM `reqpin` where FIND_IN_SET(`id`,'$req_id') AND status = 0 ");
    if (mysqli_num_rows($q1) > 0)
    {
        $date = date('Y-m-d G:i:s');
        while ($r1 = mysqli_fetch_assoc($q1))
        {
            $id = $r1["id"];
            $plan_id = $r1["plan_id"];
            $no_of_pin = $r1["no_of_pin"];
            $uid = $r1["uid"];
            $mlmid = $_SESSION['mlmid'];
            $x = addtransferpin($db, $mlmid, $uid, $plan_id, $no_of_pin);
            if ($x == 1)
            {
                $q3 = mysqli_query($db, "UPDATE `reqpin` SET `status`= 1,`approve_date`= '$date' WHERE `id` = $id");
                if ($q3)
                {
                    $c[] = 1;
                }
                else
                {
                    $c[] = 0;
                }
            }
            else
            {
                $c[] = 0;
            }
        }
        if (in_array(0, $c))
        {
            $message = "Some of the Request not approved";
        }
        else
        {
            $success = true;
            $message = "Request has been approved";
        }
    }
    else
    {
        return "No Request to approve";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Product Order paid
if (isset($_POST["type"]) && $_POST["type"] == "PaidProductOrders")
{
    $success = false;
    $message = "";
    $url = "";
    $id = $_POST['id'];
    $q2 = mysqli_query($db, "UPDATE `product_purchase` SET `cleared`= 2,`c_date`= '$cdate' WHERE `id` = $id");
    if ($q2)
    {
        $success = true;
        $message = "Payment has been cleared";
    }
    else
    {
        $message = "Some Problem Occure, payment did not clear";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Repurchase
if (isset($_POST["type"]) && $_POST["type"] == "RejectPurchaseReq")
{
    $success = false;
    $message = "";
    $req_id = $_POST['req_id'];
    $req = mysqli_query($db, "UPDATE `purchase` SET `status`=2 WHERE `id` = '$req_id'");
    if ($req)
    {
        $success = true;
        $message = "Request Rejected Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//Approve Pin Request
if (isset($_POST["type"]) && $_POST["type"] == "PurchaseReqApprove")
{
    $success = false;
    $message = "";
    $url = "";
    $x = 0;
    $req_id = implode(',', $_POST['request']);
    $q1 = mysqli_query($db, "SELECT * FROM `purchase` where FIND_IN_SET(`id`,'$req_id') AND status = 0 ");
    if (mysqli_num_rows($q1) > 0)
    {
        $date = date('Y-m-d G:i:s');
        while ($r1 = mysqli_fetch_assoc($q1))
        {
            $id = $r1["id"];
            $plan_id = $r1["plan_id"];
            $q3 = mysqli_query($db, "UPDATE `purchase` SET `status`= 1,`approve_date`= '$date' WHERE `id` = $id");
            if ($q3)
            {
                $c[] = 1;
            }
            else
            {
                $c[] = 0;
            }
        }
        if (in_array(0, $c))
        {
            $message = "Some of the Request not approved";
        }
        else
        {
            $success = true;
            $message = "Request has been approved";
        }
    }
    else
    {
        return "No Request to approve";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
//set level
if (isset($_POST["type"]) && $_POST["type"] == "EditSinglePayoutDetail")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    //echo "<pre>";var_dump($payout);
    if (isset($payout) && !empty($payout))
    {
        foreach ($payout as $key => $value)
        {
            extract($value);
            $q3 = mysqli_query($db, "UPDATE rpayout_detail set `income_perc` = '$income_perc' where id = '$id'") or die(mysqli_error($db));
        }
        if ($q3)
        {
            $success = true;
            $msg = "Payout Detail Updated Successfully";
        }
        else
        {
            $msg = "Failed!";
        }
    }
    else
    {
        $msg = "Failed!";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}
//set level
if (isset($_POST["type"]) && $_POST["type"] == "EditRefBonusDetail")
{
    $success = false;
    $msg = "";
    $url = "";
    extract($_POST);
    //echo "<pre>";var_dump($payout);
    if (isset($payout) && !empty($payout))
    {
        foreach ($payout as $key => $value)
        {
            extract($value);
            $q3 = mysqli_query($db, "UPDATE referel_bonus_detail set `income_perc` = '$income_perc' where id = '$id'") or die(mysqli_error($db));
        }
        if ($q3)
        {
            $success = true;
            $msg = "Payout Detail Updated Successfully";
        }
        else
        {
            $msg = "Failed!";
        }
    }
    else
    {
        $msg = "Failed!";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $msg
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "ChangeProductStatus")
{
    $success = false;
    $msg = "";
    $url = "";
    $user_id = $_POST['id'];
    $status = 1;

    $query = $db->query("update user_id set prod_status = '$status' where uid = '$user_id'");
    if ($query)
    {
        $success = true;
        $msg = "Product Received Successfully";
    }
    else
    {
        $msg = "Status cannot be updated";
    }
    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "PlanRequeststatus")
{
    $success = false;
    $msg = "";
    $url = "";
    $date1 = date("Y-m-d H:i:s");
    extract($_POST);
    if (isset($req_id) && !empty($req_id) && !empty($status))
    {
        if ($status == "accept")
        {
            $status = 1;
            $status_str = "Plan Upgraded";
        }
        else
        {
            $status = 2;
            $status_str = "Plan Request Rejected";
        }
        $query = $db->query("UPDATE reqplan SET status = '$status',approve_date='$date1' where id = '$req_id'");
        if ($query)
        {
            if ($status == 1)
            {
                $r1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT plan_id,uid FROM `reqplan` where id = '$req_id'"));

                $plan_id = $r1['plan_id'];
                $uid = $r1['uid'];
                $r2 = mysqli_fetch_assoc(mysqli_query($db, "SELECT sponsor_id FROM `pairing` where uid = '$uid'"));
                $sponsor_id = $r2['sponsor_id'];
                $old_plan_count = getPlanCount($db, $uid);
                $old_plan_bcount = get_plan_binary_count($uid);
                $levelPercent = getPlanPerc($db, $uid);
                $lper = $levelPercent[0];
                $query1 = $db->query("UPDATE transpin SET plan_id = '$plan_id' where uid = '$uid'") or die(mysqli_error($db));
                $fpay = UpgradeRegisterPayment($db, $uid, $sponsor_id, 1, $lper);
                $isPLanRB = IsPlanRoyaltyBinary($db, $uid);
                $new_plan_count = getPlanCount($db, $uid);
                $new_plan_bcount = get_plan_binary_count($uid);
                $plan_count = $new_plan_count - $old_plan_count;
                $plan_bcount = $new_plan_bcount - $old_plan_bcount;
                BinaryCount($db, $uid, $isPLanRB, $plan_count, $plan_bcount);
                UpgradeTotalcounter($db, $uid, $isPLanRB, $plan_count);
                UpgradeSponsorRoi($db, $uid);
                //updateLeftRighCounter($db,$sponsor_id,$uid);
                if ($isPLanRB == 1)
                {
                    ConfirmBinaryActivate($db, $uid);
                }
            }
            $success = true;
            $msg = "$status_str Successfully";
        }
        else
        {
            $msg = "Status cannot be updated";
        }
    }
    else
    {
        $msg = "Something Went Wrong,Try After Some Time";
    }
    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "UpgradeUserPlan")
{
    $success = false;
    $msg = "";
    $url = "";
    $date1 = date("Y-m-d H:i:s");
    extract($_POST);
    $q1 = mysqli_query($db, "SELECT * from `reqplan` where uid ='$uid' AND plan_id ='$plan_id' AND status=1");
    if (mysqli_num_rows($q1) > 0)
    {
        $msg = "Request Already Sent";
    }
    else
    {
        $q11 = mysqli_query($db, "SELECT * from `reqplan` where uid ='$uid' AND plan_id ='$plan_id' AND status!=1");
        if (mysqli_num_rows($q11) > 0)
        {
            $rr1 = mysqli_fetch_assoc($q11);
            $req_id = $rr1['id'];
            $result = mysqli_query($db, "UPDATE `reqplan` SET status ='1' , approve_date = '$cdate' WHERE uid ='$uid' AND plan_id ='$plan_id' AND id='$req_id'") or die(mysqli_error($db));
        }
        else
        {
            $result = mysqli_query($db, "INSERT INTO `reqplan` SET uid ='$uid' ,plan_id ='$plan_id',status ='1' , approve_date = '$cdate' , date = '$cdate'") or die(mysqli_error($db));
            $req_id = mysqli_insert_id($db);
        }
        if ($result && isset($req_id) && !empty($req_id))
        {
            $r1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT plan_id,uid FROM `reqplan` where id = '$req_id'"));

            $plan_id = $r1['plan_id'];
            $uid = $r1['uid'];
            $r2 = mysqli_fetch_assoc(mysqli_query($db, "SELECT sponsor_id FROM `pairing` where uid = '$uid'"));
            $sponsor_id = $r2['sponsor_id'];
            $old_plan_count = getPlanCount($db, $uid);
            $old_plan_bcount = get_plan_binary_count($uid);
            $levelPercent = getPlanPerc($db, $uid);
            $lper = $levelPercent[0];
            $query1 = $db->query("UPDATE transpin SET plan_id = '$plan_id' where uid = '$uid'") or die(mysqli_error($db));
            $qry01 = $db->query("UPDATE user_id SET plan_date = '$date1' where uid = '$uid'") or die(mysqli_error($db));
            $fpay = UpgradeRegisterPayment($db, $uid, $sponsor_id, 1, $lper);
            $isPLanRB = IsPlanRoyaltyBinary($db, $uid);
            $new_plan_count = getPlanCount($db, $uid);
            $new_plan_bcount = get_plan_binary_count($uid);
            $plan_count = $new_plan_count - $old_plan_count;
            $plan_bcount = $new_plan_bcount - $old_plan_bcount;
            //echo $new_plan_bcount."_____".$old_plan_bcount."======".$plan_bcount;
            BinaryCount($db, $uid, $isPLanRB, $plan_count, $plan_bcount);
            UpgradeTotalcounter($db, $uid, $isPLanRB, $plan_count);
            //updateLeftRighCounter($db,$sponsor_id,$uid);
            UpgradeSponsorRoi($db, $uid);
            if ($isPLanRB == 1)
            {
                ConfirmBinaryActivate($db, $uid);
            }
            $success = true;
            $msg = "Plan Upgraded Successfully";
        }
        else
        {
            $msg = "Some Problem Occur, While Sending Request.";
        }
    }

    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "UpdateRequestStatus")
{
    $success = false;
    $msg = "";

    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    if ($status == 1)
    {
        $message = "Approved Successfully";
    }
    if ($status == 2)
    {
        $message = "Rejected Successfully";
    }

    $query1 = mysqli_query($db, "UPDATE withdraw_request SET status ='$status',responded_date='$cdate' WHERE request_id='$request_id'") or die(mysqli_error($db));
    if ($query1)
    {
        $success = true;
    }
    else
    {
        $message = "Problem occure while updating";
    }

    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "UploadExcelFrom_rank")
{
    $success = false;
    $msg = "";

    // echo "<pre>";
    // print_r($_FILES);
    $i = 1;
    if (($handle = fopen($_FILES['users']['tmp_name'], "r")) !== false)
    {
        while (($data = fgetcsv($handle, 1000000, ",")) !== false)
        {
            if ($i > 0)
            {
                //print_r($data[0]);
                $username = $data[1];
                $rank = $data[3];
                $p1 = mysqli_fetch_assoc(mysqli_query($db, "select uid from user_id where uname='$username'"));
                $uid = $p1['uid'];

                if ($rank == 'EXECUTIVE DISTRIBUTOR')
                {
                    $rank = 1;
                    $tpv = 200;
                    mysqli_query($db, "UPDATE `pairing` SET `rank` = '1' WHERE `uid` = '$uid'");
                    //mysqli_query($db,"UPDATE `child_counter` SET `tpv` = '$tpv' WHERE `uid` = '$uid'");
                    
                }
                else
                {
                    mysqli_query($db, "UPDATE `user_id` SET `bv` = '500' WHERE `uid` = '$uid'");
                }

            }

        }
        fclose($handle);
    }

    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "UploadExcelFrom")
{
    $success = false;
    $msg = "";

    // echo "<pre>";
    // print_r($_FILES);
    $i = 1;
    if (($handle = fopen($_FILES['users']['tmp_name'], "r")) !== false)
    {
        while (($data = fgetcsv($handle, 1000000, ",")) !== false)
        {
            if ($i > 0)
            {
                //print_r($data[0]);
                $sponsor_id = $data[1];
                $username = $data[2];
                $position = $data[5];
                echo $parent_id = GetValidParentId($db, $sponsor_id, $position);
                $prr = mysqli_fetch_assoc(mysqli_query($db, "select uid,paired from user_id where uname='$parent_id'"));

                $parent_uid = $prr['uid'];

                $p1 = mysqli_fetch_assoc(mysqli_query($db, "select uid from user_id where uname='$username'"));
                $uid = $p1['uid'];
                echo "UPDATE `pairing` SET `position` = '$position',parent_id='$parent_uid' WHERE `pairing`.`uid` = '$uid'";
                echo "\n\n\n";
                mysqli_query($db, "UPDATE `pairing` SET `position` = '$position',parent_id='$parent_uid' WHERE `pairing`.`uid` = '$uid'") or die(mysqli_error($db));
            }

        }
        fclose($handle);
    }

    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "UploadExcelFrom_user")
{
    $success = false;
    $msg = "";

    // echo "<pre>";
    // print_r($_FILES);
    $i = 1;
    if (($handle = fopen($_FILES['users']['tmp_name'], "r")) !== false)
    {
        while (($data = fgetcsv($handle, 1000000, ",")) !== false)
        {
            if ($i > 0)
            {
                //print_r($data[0]);
                $uid['username'] = $username = $data[1];
                $detail['fname'] = $fname = $data[2];
                $detail['state'] = $state = $data[3];
                $detail['address'] = $address = $data[4];
                $detail['city'] = $city = $data[5];
                //var_dump($detail);die;
                $uid['register_date'] = $register_date = date('Y-m-d', strtotime($data[5]));
                $uid['plan_date'] = $plan_date = date('Y-m-d', strtotime($data[7]));
                $uid['password'] = $password = 'latest@123';
                $sponsor_id = (empty($data[5])) ? 'admin' : $data[8];
                $uid['sponsor_id'] = $sponsor_id;
                //$parent_id = (empty($data[6]))?'admin':$data[6];
                if ($i % 2 == 0)
                {
                    $position = 'R';
                }
                else
                {
                    $position = 'L';
                }
                //echo $position;die;
                $parent_id = GetValidParentId($db, $sponsor_id, $position);
                $prr = mysqli_fetch_assoc(mysqli_query($db, "select uid,paired from user_id where uname='$parent_id'"));
                $parent_uid = $prr['uid'];
                //echo $parent_id;die;
                /* $udata=json_encode($uid);
                $detail=json_encode($detail);
                $qq=mysqli_query($db,"INSERT INTO data SET parent_id='$parent_id', sponsor_id='$sponsor_id', position='$position',udata='$udata',detail='$detail'") or die(mysqli_error($db));*/
                echo "<br?<br>";
                echo "select uid from pairing where parent_id='$parent_uid' and position='L'";

                $qq1 = mysqli_num_rows(mysqli_query($db, "select uid from pairing where parent_id='$parent_uid' and position='L'"));
                if ($qq1 == 0)
                {
                    $position = 'L';
                }
                else
                {
                    $position = 'R';
                }
                //echo $qq1;echo $position;die;
                $p = mysqli_fetch_assoc(mysqli_query($db, "SELECT plan_id FROM plans  WHERE plan_amount=0 limit 1"));
                $plan_id = $p['plan_id'];
                $uid['$pin_no'] = addnewzeropin($db, $plan_id, 1);
                /*var_dump($detail);
                 var_dump($uid);*/

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
                                //echo "SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'";
                                $check_position = mysqli_query($db, "SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
                                $chkqry2 = mysqli_num_rows($check_position);
                                if ($chkqry2 > 0)
                                {
                                    $msg = 'Already assiged a user to this side';
                                }
                                else
                                {
                                    //echo "no of qry_____".$chkqry2; die;
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
                                        //echo $parent_id;
                                        $p = mysqli_fetch_assoc(mysqli_query($db, "SELECT t1.pin_code FROM `transpin` t1 left join plans t2 on t1.plan_id=t2.plan_id WHERE t1.`allot_uid` = '0' and t1.`status`='0' and t1.`allot_uid`='0' and t2.plan_amount=0 order by pin_id limit 1"));
                                        $pin_no = $p['pin_code'];
                                        if (isset($pin_no) && !empty($pin_no))
                                        {
                                            $cpin = checkTransPin($db, $pin_no);
                                            if ($cpin == 1)
                                            {
                                                //$qry="INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`,`paired`,`status`) VALUES ('$username','$password','$cdate','$cdate','$paired','2')";
                                                $qry = "INSERT INTO `user_id`(`uname`, `password`, `register_date`, `plan_date`, `pin`,`paired`) VALUES ('$username','$password','$cdate','$cdate','$pin_no','$paired')";
                                                $q = mysqli_query($db, $qry);
                                                if ($q)
                                                {
                                                    $uid = mysqli_insert_id($db);
                                                    $qry1 = "Insert into user_detail(uid,first_name,last_name,gender,email,mobile) values($uid,'$fname','$lname','$gender','$email','$mobile_no')";
                                                    $q1 = mysqli_query($db, $qry1);
                                                    if ($q)
                                                    {

                                                        $q8 = $db->query("UPDATE `transpin` SET `uid`='$uid',status='1' WHERE pin_code='$pin_no'");
                                                        UserPairing($db, $uid, $parent_id, $sponsor_id, $position);

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
                else if (isset($pin_no) && empty($pin_no))
                {
                    $msg = "Pin No Is Required";
                }
                else if (isset($parent_id) && empty($parent_id))
                {
                    $msg = "Parent Id Is Required";
                }
                else
                {
                    $msg = "Sponser Id Is Required";
                }
            }
            /*if($i == 4){
            // die;
            }*/
            $i++;
        }
        fclose($handle);
    }

    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "UpgradeTopup_old")
{
    $success = false;
    $msg = "";
    $url = "";
    $date1 = date("Y-m-d H:i:s");
    extract($_POST);

    if (isset($pin_no) && !empty($pin_no) && isset($uid) && !empty($uid))
    {
        $r1 = mysqli_fetch_assoc(mysqli_query($db, "SELECT plan_id,uid FROM `reqplan` where id = '$req_id'"));

        $plan_id = $r1['plan_id'];
        $uid = $r1['uid'];
        $r2 = mysqli_fetch_assoc(mysqli_query($db, "SELECT sponsor_id FROM `pairing` where uid = '$uid'"));
        $sponsor_id = $r2['sponsor_id'];
        $old_plan_count = getPlanCount($db, $uid);
        $old_plan_bcount = get_plan_binary_count($uid);
        $levelPercent = getPlanPerc($db, $uid);
        $lper = $levelPercent[0];
        $query1 = $db->query("UPDATE transpin SET plan_id = '$plan_id' where uid = '$uid'") or die(mysqli_error($db));
        $qry01 = $db->query("UPDATE user_id SET plan_date = '$date1' where uid = '$uid'") or die(mysqli_error($db));
        $fpay = UpgradeRegisterPayment($db, $uid, $sponsor_id, 1, $lper);
        $isPLanRB = IsPlanRoyaltyBinary($db, $uid);
        $new_plan_count = getPlanCount($db, $uid);
        $new_plan_bcount = get_plan_binary_count($uid);

        $plan_count = $new_plan_count - $old_plan_count;
        $plan_bcount = $new_plan_bcount - $old_plan_bcount;
        BinaryCount($db, $uid, $isPLanRB, $plan_count, $plan_bcount);
        UpgradeTotalcounter($db, $uid, $isPLanRB, $plan_count);
        //updateLeftRighCounter($db,$sponsor_id,$uid);
        if ($isPLanRB == 1)
        {
            ConfirmBinaryActivate($db, $uid);
        }
        $success = true;
        $msg = "Plan Upgraded Successfully";
    }
    else
    {
        $msg = "Some Problem Occur, While Sending Request.";
    }

    echo json_encode(array(
        "valid" => $success,
        "message" => $msg
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "UpgradeTopup")
{
    $success = false;
    $msg = "";
    $url = "";
    $date1 = date("Y-m-d H:i:s");
    extract($_POST);

    if (isset($pin_no) && !empty($pin_no) && isset($uid) && !empty($uid))
    {

        $newq = mysqli_query($db, "SELECT t2.plan_amount FROM transpin t1 left join plans t2 on t1.plan_id=t2.plan_id WHERE t1.pin_code = '$pin_no' and uid IS NULL and status=0");
        if (mysqli_num_rows($newq) > 0)
        {
            $newdata = mysqli_fetch_assoc($newq);
            $newplan_amount = $newdata['plan_amount'];
            $oldq = mysqli_query($db, "SELECT t2.plan_amount FROM transpin t1 left join plans t2 on t1.plan_id=t2.plan_id WHERE t1.uid = '$uid'");
            $olddata = mysqli_fetch_assoc($oldq);
            $oldplan_amount = $olddata['plan_amount'];
            if ($newplan_amount > $oldplan_amount)
            {
                $res = UpgradeUserPin($db, $uid, $pin_no);
                if ($res == true)
                {
                    $success = true;
                    $msg = "Plan Upgraded Successfully";
                }
                else
                {
                    $msg = "No Pin Assigned To the User";
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
        "valid" => $success,
        "message" => $msg
    ));
}
/*
 * Manage Category
*/

if (isset($_POST['type']) && $_POST['type'] == "ManageCategory")
{
    $success = false;
    $message = "";
    $stm_update = ''; //Image
    $uploadOk = 1;
    extract($_POST);

    /*if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
    {
        $target_dir = "../upload/category/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $imageFileType;
        $filepath = $target_dir . $filename;
        if ($_FILES["image"]["size"] > 10 * MB) {
            $message = "Sorry, Image is too large.";
            $uploadOk = 0;
        }
        $extallowed = array("jpg", "jpeg", "png");
        if (!in_array(strtolower($imageFileType), $extallowed)) {
            $message = "Sorry,For Image jpg & png extension files are allowed";
            $uploadOk = 0;
        }
    
    
        if ($uploadOk != 0) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
                $stm_update = "image='$filename'";
            } else {
                $uploadOk = 0;
                $message = "Sorry, image was not uploaded.";
            }
        }
    }*/
    if ($uploadOk == 1)
    {
        //var_dump($_POST);die();
        if (!empty($cat_id))
        {
            $q1 = mysqli_query($db, "UPDATE `product_category` SET $stm_update `cat_name`='$cat_name', `modify` = '$cdate' WHERE `cat_id` = '$cat_id'");
            if ($q1)
            {
                $success = true;
                $message = "Category Updated Successfully";
            }
            else
            {
                $message = "Failed to update Category";
            }
        }
        else
        {
            $q1 = mysqli_query($db, "INSERT INTO `product_category` SET $stm_update `cat_name`='$cat_name',`created`='$cdate',`modify`='$cdate',`status` = '1'");
            if ($q1)
            {
                $success = true;
                $message = "Category Added Successfully";
            }
            else
            {
                $message = "Failed to Add Category";
            }
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Delete Category
*/
if (isset($_POST["type"]) && $_POST["type"] == "DeleteCategory")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM product_category WHERE cat_id = '$id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Category Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";

    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "ReqMarkAsPaid")
{
    $success = false;
    $message = "";
    $url = "";
    $req_id = $_POST['req_id'];
    $q2 = mysqli_query($db, "UPDATE `bal_req` SET `status`= 1,`approve_date`= '$cdate' WHERE `req_id` = $req_id") or die(mysqli_error($db));
    if ($q2)
    {
        $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM bal_req WHERE `req_id` = $req_id"));
        $amount = $data['amount'];
        $uid = $data['uid'];
        mysqli_query($db, "UPDATE user_id SET balance=balance+$amount WHERE uid='$uid' ");
        $success = true;
        $message = "Balance Request Accepted";
    }
    else
    {
        $message = "Some Problem Occure, While Processing.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "RejectReq")
{
    $success = false;
    $message = "";
    $url = "";
    $req_id = $_POST['req_id'];
    $q2 = mysqli_query($db, "UPDATE `bal_req` SET `status`= 2,`approve_date`= '$cdate' WHERE `req_id` = $req_id") or die(mysqli_error($db));
    if ($q2)
    {

        $success = true;
        $message = "Balance Request Rejected";
    }
    else
    {
        $message = "Some Problem Occure, While Processing.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

//Generate GTB Payout
if (isset($_POST["type"]) && $_POST["type"] == "GenerateGTBPayout")
{
    $success = false;
    $message = "";
    $url = "";
    $c = array();
    $c1 = GenerateGTBPayout($db);
    $c = array_merge($c1);
    if (in_array(0, $c))
    {
        $message = "Some of the payout not generated";
    }
    elseif (in_array(1, $c))
    {
        $success = true;
        $message = "Payout Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }
    $cur_date = date("Y-m-d H:i:s");
    mysqli_query($db, "UPDATE `payout_date` SET `date`='$cur_date' WHERE id='1'") or die(mysqli_error($db));

    $curdate = date("d-m-Y");
    mysqli_query($db, "UPDATE `pairing` SET `active_validto`='',`is_active`='0' WHERE `active_validto`='$curdate'") or die(mysqli_error($db));
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

//Generate GTB Payout
if (isset($_POST["type"]) && $_POST["type"] == "GenerateRankayout")
{
    $success = false;
    $message = "";
    $url = "";
    $c = array();
    $c1 = getRankPayout($db);
    getRetailProfitkPayout($db);
    $c = array_merge($c1);
    if (in_array(0, $c))
    {
        $message = "Some of the payout not generated";
    }
    elseif (in_array(1, $c))
    {
        $success = true;
        $message = "Payout Generated Successfully";
    }
    else
    {
        $message = "No Payout to generate";
    }
    $cur_date = date("Y-m-d H:i:s");
    mysqli_query($db, "UPDATE `payout_date` SET `date`='$cur_date' WHERE id='1'") or die(mysqli_error($db));
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "ManageFranchise")
{
    $success = false;
    $message = "";
    $url = "";
    extract($_POST);
    //$plan_desc = mysqli_escape_string($db,"$plan_desc");
    if (isset($txtid) && !empty($txtid))
    {

        $q1 = mysqli_query($db, "UPDATE `franchise` SET `password`='$password',`name`='$name',`address`='$address',`email`='$email',`mobile`='$mobile',`balance`='$balance',`com_per`='$com_per' WHERE `id` = '$txtid'");
        if ($q1)
        {
            $success = true;
            $message = "Franchise Updated Successfully";
        }
        else
        {
            $message = "Failed to update";
        }
    }
    else
    {

        $userc = mysqli_num_rows(mysqli_query($db, "select id from franchise where uname='$username'"));
        if ($userc > 0)
        {
            $message = "Username is already taken";
        }
        else if (preg_match('/[^a-z_\-0-9]/i', $username))
        {
            $message = "Username should contain only character,number or underscore";
        }
        else
        {
            $date = date("Y-m-d H:i:s");
            $q1 = mysqli_query($db, "INSERT INTO `franchise` SET `uname`='$username',`password`='$password',`tpassword`='123456',`name`='$name',`address`='$address',`email`='$email',`mobile`='$mobile',`date`='$date'") or die(mysqli_error($db));
            if ($q1)
            {
                $success = true;
                $message = "Franchise Added Successfully";
            }
            else
            {
                $message = "Failed to Add";
            }
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Delete Repurchase plan
*/
if (isset($_POST["type"]) && $_POST["type"] == "DelFranchise")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM franchise WHERE id = '$id'");

    if ($delrecord)
    {
        $success = true;
        $message = "Franchise Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "FReqMarkAsPaid")
{
    $success = false;
    $message = "";
    $url = "";
    $req_id = $_POST['req_id'];
    $cdate = date("Y-m-d H:i:s");
    $q2 = mysqli_query($db, "UPDATE `fbal_req` SET `status`= 1,`approve_date`= '$cdate' WHERE `req_id` = $req_id") or die(mysqli_error($db));
    if ($q2)
    {
        $data = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM fbal_req WHERE `req_id` = $req_id"));
        $amount = $data['amount'];
        $fid = $data['fid'];
        //echo "UPDATE franchise SET balance=balance+$amount WHERE id='$fid' ";
        mysqli_query($db, "UPDATE franchise SET balance=balance+$amount WHERE id='$fid' ");
        $success = true;
        $message = "Balance Request Accepted";
    }
    else
    {
        $message = "Some Problem Occure, While Processing.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
if (isset($_POST["type"]) && $_POST["type"] == "FRejectReq")
{
    $success = false;
    $message = "";
    $url = "";
    $req_id = $_POST['req_id'];
    $q2 = mysqli_query($db, "UPDATE `fbal_req` SET `status`= 2,`approve_date`= '$cdate' WHERE `req_id` = $req_id") or die(mysqli_error($db));
    if ($q2)
    {

        $success = true;
        $message = "Balance Request Rejected";
    }
    else
    {
        $message = "Some Problem Occure, While Processing.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "DispatchOrder")
{
    $success = false;
    $message = "";
    $date = date("Y-m-d H:i:s");
    $order_id = $_POST['order_id'];
    $c1 = mysqli_query($db, "SELECT fid,amount FROM `checkout` WHERE id = '$order_id' and status=0");
    $chk = mysqli_num_rows($c1);
    if ($chk > 0)
    {
        $q1 = mysqli_query($db, "UPDATE checkout SET status=1,sdate='$date' WHERE id = '$order_id'");
        if ($q1)
        {
            $d1 = mysqli_fetch_assoc($c1);
            $fid = $d1['fid'];
            $balance = $d1['amount'];
            echo "UPDATE franchise SET balance=balance+$balance WHERE id='$fid' ";
            mysqli_query($db, "UPDATE franchise SET balance=balance+$balance WHERE id='$fid'");
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
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "UpdateShippingCharge")
{
    $success = false;
    $message = "";
    $url = "";
    extract($_POST);
    $q1 = mysqli_query($db, "UPDATE `home` SET  amount=$amount WHERE `id` = 1");
    if ($q1)
    {
        $success = true;
        $message = "Amount Updated Successfully";
    }
    else
    {
        $message = "Failed to update";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "UpgradeVPower")
{
    $success = false;
    $message = "";
    $url = "";
    extract($_POST);
    if (isset($uid) && !empty($uid) && isset($position) && !empty($position))
    {
        if (isset($position) && $position == 'L')
        {
            $q1 = mysqli_query($db, "UPDATE `child_counter` SET  `left_bv`='10000000' WHERE `uid` = '$uid'");
        }
        else
        {
            $q1 = mysqli_query($db, "UPDATE `child_counter` SET  `right_bv`='10000000' WHERE `uid` = '$uid'");
        }
        if ($q1)
        {
            $q2 = mysqli_query($db, "UPDATE `pairing` SET  `rank`=8 WHERE `uid` = '$uid'");
            $success = true;
            $message = "virtual Power Updated Successfully";
        }
        else
        {
            $message = "Failed to update";
        }
    }
    else
    {
        $message = "Select User and position";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

//delete Order
if (isset($_POST["type"]) && $_POST["type"] == "DeleteOrder")
{
    $success = true;
    $message = "Order Cancelled Successfully";
    $id = $_POST['id'];
    $sql = mysqli_fetch_assoc(mysqli_query($db, "select * from checkout where id='$id'"));
    DecreementBVCount_parent($db, $sql['uid'], $sql['bv']);
    BVCount($db, $sql['uid'], $sql['bv']);
    DecreementBVCount($db, $sql['uid'], $sql['bv']);
    $query = mysqli_query($db, "delete from checkout where id='$id'");
    $uid = $sql['uid'];
    $count_order = mysqli_num_rows(mysqli_query($db, "select * from checkout where uid='$uid'"));
    if ($count_order == 0)
    {
        mysqli_query($db, "UPDATE user_id SET plan_date=NULL WHERE uid=$uid");
    }

    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "hideOtherProduct")
{
    $success = false;
    $message = "";
    $product_id = $_POST['product_id'];
    $value = $_POST['value'];
    $delrecord = mysqli_query($db, "UPDATE products SET status='$value' WHERE product_id = '$product_id'");

    if ($delrecord)
    {
        $success = true;
        $message = "Product Hide Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Hiding.";
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

/*
 * Manage Slider
*/
if (isset($_POST['type']) && $_POST['type'] == "Manageslider")
{
    $success = false;
    $message = "";
    $stm_update = ''; //Image
    $uploadOk = 1;
    extract($_POST);

    if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
    {
        $target_dir = "../upload/slider/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $imageFileType;
        $filepath = $target_dir . $filename;
        if ($_FILES["image"]["size"] > 10 * MB)
        {
            $message = "Sorry, Image is too large.";
            $uploadOk = 0;
        }
        $extallowed = array(
            "jpg",
            "jpeg",
            "png"
        );
        if (!in_array(strtolower($imageFileType) , $extallowed))
        {
            $message = "Sorry,For Image jpg & png extension files are allowed";
            $uploadOk = 0;
        }

        if ($uploadOk != 0)
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
            {
                $stm_update = "image='$filename'";
            }
            else
            {
                $uploadOk = 0;
                $message = "Sorry, image was not uploaded.";
            }
        }
    }
    if ($uploadOk == 1)
    {
        //var_dump($_POST);die();
        if (!empty($slider_id))
        {
            $q1 = mysqli_query($db, "UPDATE `slider` SET $stm_update WHERE `slider_id` = '$slider_id'");
            if ($q1)
            {
                $success = true;
                $message = "Slider Updated Successfully";
            }
            else
            {
                $message = "Failed to update Slider";
            }
        }
        else
        {
            // echo "INSERT INTO `product_category` SET $stm_update `cat_name`='$cat_name',`created`='$cdate',`modify`='$cdate',`status` = '1'";
            $q1 = mysqli_query($db, "INSERT INTO `slider` SET $stm_update");
            if ($q1)
            {
                $success = true;
                $message = "Slider Added Successfully";
            }
            else
            {
                $message = "Failed to Add Slider";
            }
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Delete Slider
*/
if (isset($_POST["type"]) && $_POST["type"] == "deleteslider")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM slider WHERE slider_id = '$id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Slider Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";

    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}
/*
 * Manage Team
*/
if (isset($_POST['type']) && $_POST['type'] == "Manageteam")
{
    $success = false;
    $message = "";
    $stm_update = ''; //Image
    $uploadOk = 1;
    extract($_POST);

    if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
    {
        $target_dir = "../upload/slider/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $imageFileType;
        $filepath = $target_dir . $filename;
        if ($_FILES["image"]["size"] > 10 * MB)
        {
            $message = "Sorry, Image is too large.";
            $uploadOk = 0;
        }
        $extallowed = array(
            "jpg",
            "jpeg",
            "png"
        );
        if (!in_array(strtolower($imageFileType) , $extallowed))
        {
            $message = "Sorry,For Image jpg & png extension files are allowed";
            $uploadOk = 0;
        }

        if ($uploadOk != 0)
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
            {
                $stm_update = "image='$filename'";
            }
            else
            {
                $uploadOk = 0;
                $message = "Sorry, image was not uploaded.";
            }
        }
    }
    if ($uploadOk == 1)
    {
        //var_dump($_POST);die();
        if (!empty($team_id))
        {
            //echo "UPDATE `team` SET  `name` = '$name', `designation`= '$designation', `description`= '$description' $stm_update WHERE `team_id` = '$team_id'";
            $q1 = mysqli_query($db, "UPDATE `team` SET  `name` = '$name', `designation`= '$designation', `description`= '$description' $stm_update WHERE `team_id` = '$team_id'");
            if ($q1)
            {
                $success = true;
                $message = "Team Updated Successfully";
            }
            else
            {
                $message = "Failed to update Team";
            }
        }
        else
        {
            // echo "INSERT INTO `product_category` SET $stm_update `cat_name`='$cat_name',`created`='$cdate',`modify`='$cdate',`status` = '1'";
            $q1 = mysqli_query($db, "INSERT INTO `team` SET  `name` = '$name', `designation`= '$designation', `description`= '$description', $stm_update");
            if ($q1)
            {
                $success = true;
                $message = "Team Added Successfully";
            }
            else
            {
                $message = "Failed to Add Team";
            }
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

/*
 * Delete Team
*/
if (isset($_POST["type"]) && $_POST["type"] == "deleteteam")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM team WHERE team_id = '$id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Team Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";

    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

/*
 * Manage Slider
*/

if (isset($_POST['type']) && $_POST['type'] == "Managegallery")
{
    $success = false;
    $message = "";
    $stm_update = ''; //Image
    $uploadOk = 1;
    extract($_POST);

    if (isset($_FILES['image']) && $_FILES['image']['name'] != "")
    {
        $target_dir = "../upload/gallery/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $imageFileType;
        $filepath = $target_dir . $filename;
        if ($_FILES["image"]["size"] > 10 * MB)
        {
            $message = "Sorry, Image is too large.";
            $uploadOk = 0;
        }
        $extallowed = array(
            "jpg",
            "jpeg",
            "png"
        );
        if (!in_array(strtolower($imageFileType) , $extallowed))
        {
            $message = "Sorry,For Image jpg & png extension files are allowed";
            $uploadOk = 0;
        }

        if ($uploadOk != 0)
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $filepath))
            {
                $stm_update = "image='$filename'";
            }
            else
            {
                $uploadOk = 0;
                $message = "Sorry, image was not uploaded.";
            }
        }
    }
    if ($uploadOk == 1)
    {
        //var_dump($_POST);die();
        if (!empty($gallery_id))
        {
            $q1 = mysqli_query($db, "UPDATE `gallery` SET $stm_update WHERE `gallery_id` = '$gallery_id'");
            if ($q1)
            {
                $success = true;
                $message = "gallery Updated Successfully";
            }
            else
            {
                $message = "Failed to update gallery";
            }
        }
        else
        {
            // echo "INSERT INTO `product_category` SET $stm_update `cat_name`='$cat_name',`created`='$cdate',`modify`='$cdate',`status` = '1'";
            $q1 = mysqli_query($db, "INSERT INTO `gallery` SET $stm_update");
            if ($q1)
            {
                $success = true;
                $message = "gallery Added Successfully";
            }
            else
            {
                $message = "Failed to Add gallery";
            }
        }
    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

/*
 * Delete Slider
*/
if (isset($_POST["type"]) && $_POST["type"] == "block_user")
{
    $success = false;
    $message = "";
    $uid = $_POST['uid'];
    $record = mysqli_query($db, "update `user_id` set `is_active`='1' where `uid`='$uid'");
    if ($record)
    {
        $success = true;
        $message = "Blocked Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Blocking." . $uid;

    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "unblock_user")
{
    $success = false;
    $message = "";
    $uid = $_POST['uid'];
    $record = mysqli_query($db, "update `user_id` set `is_active`='0' where `uid`='$uid'");
    if ($record)
    {
        $success = true;
        $message = "Un Blocked Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Blocking." . $uid;

    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

if (isset($_POST["type"]) && $_POST["type"] == "deletegallery")
{
    $success = false;
    $message = "";
    $id = $_POST['id'];
    $delrecord = mysqli_query($db, "DELETE FROM gallery WHERE gallery_id = '$id'");
    if ($delrecord)
    {
        $success = true;
        $message = "Gallery Deleted Successfully";
    }
    else
    {
        $message = "Some Problem Occur, While Deleting.";

    }
    echo json_encode(array(
        "success" => $success,
        "message" => $message
    ));
}

