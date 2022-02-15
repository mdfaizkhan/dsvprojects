<?php
//if (session_status() == PHP_SESSION_NONE) {
    session_start();
//}
include 'db_config.php';
$uid= $_SESSION['mlmid'];
$status_id= $_GET['status_id'];
$billcode= $_GET['billcode'];
$order_id= $_GET['order_id'];
$transaction_id= $_GET['transaction_id'];
$qurey=mysqli_query($db,"insert into order_status(uid,order_id,transaction_id,billcode,status_id)values('$uid','$status_id','$transaction_id','$billcode','$status_id')");
if($qurey)
{
	$success = false;
    $message = "";
    $url = 'checkouts?checkout=manual';
	if($status_id==3)
	{
        $last_id=$_SESSION['last_id'];
        $checkout_pending=mysqli_query($db,"select * From checkout_pending where id='$last_id' && uid='$uid'");
        $checkoutresult=mysqli_fetch_assoc($checkout_pending);
       // echo $checkoutresult['uid'];
         //if(!empty($checkout_result)){
          //  $checkout_result = rtrim($checkout_result,',');
       // }
        //print_r($checkout_result);
       // exit;
            $shipping_charge=isset($shipping_charge)?$shipping_charge:0;
            $uid=$checkoutresult['uid'];
            $user=$checkoutresult['user'];
            $product_ids=$checkoutresult['product_ids'];
            $amount=$checkoutresult['amount'];
            $pv=$checkoutresult['pv'];
            $fid=$checkoutresult['fid'];
            $fname=$checkoutresult['fname'];
            $lname=$checkoutresult['lname'];
            $email=$checkoutresult['email'];
            $cname=$checkoutresult['cname'];
            $country=$checkoutresult['country'];
            $street1=$checkoutresult['street1'];
            $street2=$checkoutresult['street2'];
            $city=$checkoutresult['city'];
            $postcode=$checkoutresult['postcode'];
            $phone=$checkoutresult['phone'];
            $shipping_charge=$checkoutresult['shipping_charge'];
            $pay_user=$checkoutresult['pay_user'];
            $status=$checkoutresult['status'];
		$q1=mysqli_query($db,"insert into checkout(uid,user,product_ids,amount,pv,fid,fname,lname,email,cname,country,street1,street2,city,postcode,phone,shipping_charge,pay_user,status)values('$uid','$user','$product_ids','$amount','$pv','$fid','$fname','$lname','$email','$cname','$country','$street1','$street2','$city','$postcode','$phone','$shipping_charge','$pay_user','$status')");
        if($q1)
        {
            $transaction_id = mysqli_insert_id($db);
            mysqli_query($db,"UPDATE `cart` SET `transaction_id`='$transaction_id' WHERE `uid` ='$uid' and transaction_id IS null");
            $success = true;


            $user_id=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'0';
            $shipping_charge=isset($shipping_charge)?$shipping_charge:0;
            $puid=$uid;
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
        // $product_ids=implode(',', $products);
        //     unset($_POST['uid']);
        //     unset($_POST['type']);
        //     unset($_POST['puid']);
        //     //var_dump($data);die;
        //     $sql_str = "";
        //     foreach ($_POST as $key => $value) {
        //     if(is_array($value))
        //     {
        //         $value=implode(',', $value);
        //     }
        //     if($key=='pay_user')
        //     {
        //         $sql_str .= "`$key`='$value',";
        //     }
        //     else if(!empty($value))
        //     {
        //         $value=mysqli_real_escape_string($db,$value);
        //         $sql_str .= "`$key`='$value',";
        //     }
            
            
        // }



           /* $transaction_id = encrypt_decrypt('encrypt',$transaction_id);
            $url = 'processpayment1.php?id='.$transaction_id;
            $message = "Please Wait while we Process Your Order";*/
            
            $chkamount=$amount+$shipping_charge;
           // $bal=$wamount-$chkamount;
            $upv=$ex_pv+$pv;
            $plan_date=date("Y-m-d H:i:s");
            // if(isset($_SESSION['mlmid']) && !empty($_SESSION['mlmid']))
            // {
            //     $mlmid=isset($_SESSION['mlmid'])?$_SESSION['mlmid']:'0';
            //     //echo "UPDATE user_id SET balance='$bal' WHERE uid='$mlmid'";
            //     mysqli_query($db,"UPDATE user_id SET balance='$bal' WHERE uid='$mlmid'") or die(mysqli_error($db));                
            // }           


            PVCount_parent_repurchase($db,$puid,$pv);  

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
	else if($status_id==2)
    {
        $message = "Transaction Failed !";
    }
    else
    {
        $message = "Transaction Failed !";
    }
     
	$daatamessage= json_encode(array(
        'success'=>$success,
        'message'=>$message,
        //'url'=>$url
    ));
    $_SESSION['message'] =$daatamessage;
    header("Location:".$url);
   
}

?>