<?php
//get percentage value
/*$perqry=mysqli_fetch_assoc(mysqli_query($db,"select * from set_level where lid='1'"));
$levelPercent=json_decode($perqry['level']);
var_dump($levelPercent);
$LevelPercentNo=$perqry['levelno'];*/
/*
 * Amount to pv conversion
 */
$crdate=date("Y-m-d H:i");
function AmountToPV($amount)
{
    $pv_1 = 500;
    $converted = round($amount/$pv_1,2);
    return $converted ."PV";
}
function GetUname($db,$uid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT uname FROM user_id WHERE uid='$uid'"));
    return $r1['uname']; 
}
function GetUserflname($db,$uid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT first_name,last_name,gender FROM user_detail WHERE uid='$uid'"));
    /*if(isset($r1['gender']) && $r1['gender']=='male')
    {
        $name="Mr. ".$r1['first_name']." ".$r1['last_name'];
    }
    else
    {
        $name="Mrs. ".$r1['first_name']." ".$r1['last_name'];
    }*/
    $name=$r1['first_name']." ".$r1['last_name'];
    return $name;
}

function GetBankDetail($db,$uid)    
{
    $return=0;
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT pan_no FROM user_detail WHERE uid='$uid'"));
    $r2=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM user_bank WHERE uid='$uid'"));
    if(isset($r1['pan_no']) && !empty($r1['pan_no']) && isset($r2['acnumber']) && !empty($r2['acnumber']) && isset($r2['bank_name']) &&  !empty($r2['bank_name']))
    {
        $return=1;
    }
    return $return;
}

function UpdatePayout($db)
{

    $q1=mysqli_query($db,"SELECT * FROM `payout` WHERE cleared=2 ");
    while ($r1=mysqli_fetch_assoc($q1)) {
        $id=$r1['id'];
        $uid=$r1['uid'];
        $res=GetBankDetail($db,$uid);
        if(isset($res) && $res==1)
        {
            mysqli_query($db,"UPDATE `payout` SET cleared=0 WHERE id='$id' ");
        }
    }
}
function IsDistributor_old($db,$uid)
{
    $res=0;
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as tpv FROM checkout WHERE uid='$uid'"));
    if($r1['tpv'] >= 500)
    {
        $res=1;
    }
    return $res;
}

function IsDistributor($db,$uid)
{
    $res=0;
    if($uid==1978){
        $res=1;
    }
    else{
      $sql=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` WHERE uid='$uid'"));
      $is_active=$sql['is_active'];
      $active_validto=strtotime($sql['active_validto']);
      $cur_date=strtotime(date('d-m-Y'));
      if($is_active>0){
        if($active_validto>=$cur_date){
            $res=1;
        }
      }
    
    }
    
    return $res;
}


function countcheckout($db,$uid)
{
    $q1=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `checkout` WHERE uid='$uid'"));
    return $q;
}

function GetUserPurchase($db,$uid,$product_id)
{
    $r1=mysqli_query($db,"SELECT id FROM checkout WHERE uid='$uid' AND FIND_IN_SET('$product_id',$product_id)");
    return mysqli_num_rows($r1);
}
function IsUserActive($db,$uid)
{
    $date=date('Y-m-d');
    $res=false;
    //echo "SELECT plan_date FROM `user_id` WHERE uid='$uid'";
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT plan_date FROM `user_id` WHERE uid='$uid'"));
    //echo $r1['plan_date'];
    $plan_date=date("Y-m-d",strtotime("+1 months",strtotime($r1['plan_date'])));
    //echo "plan_date---".$$plan_date."----Date---".$date;
    if(strtotime($plan_date) > strtotime($date))
    {
        $res=true;
    }
    return $res;
}
function GetUserTotalBV($db,$uid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as tpv FROM checkout WHERE uid='$uid'"));
    return isset($r1['tpv']) && $r1['tpv'] > 0?$r1['tpv']:0;
}
function GetUserTotalPV($db,$uid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as tpv FROM checkout WHERE uid='$uid'"));
    $tpv=$r1['tpv']*50;
    return isset($r1['tpv']) && $r1['tpv'] > 0?$tpv:0;
}
function GetUserTotalPurchase($db,$uid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(amount) as amount FROM checkout WHERE uid='$uid'"));
    return isset($r1['amount']) && $r1['amount'] > 0?$r1['amount']:0;
}
function GetMyDownlineCount($db,$uid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT count(uid) as total FROM pairing WHERE sponsor_id='$uid'"));
    return isset($r1['total']) && $r1['total'] > 0?$r1['total']:0;
}
function GetUserBV($db,$uid)
{
    $rr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `payout_date` where id=1"));
    //$pdate=date("Y-m-d", strtotime($rr['date']));
    $pdate=$rr['date'];
    //echo "SELECT sum(pv) as tpv FROM checkout WHERE uid='$uid' and date > '$pdate'";
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as tpv FROM checkout WHERE uid='$uid' and date > '$pdate'"));
    return $r1['tpv'];
}
function GetUserRank($db,$uid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.rank,t2.pv FROM `pairing` t1 left join self_purchase t2 on t1.rank=t2.rank_id WHERE t1.uid='$uid'"));
    return array("rank"=>$r1['rank'],"pv"=>$r1['pv']);

}

// function GetMonthlyPurchaseStatus($db,$uid)
// {
//     $result=0;
//     $res=IsUserActive($db,$uid);
//     if($res)
//     {
//         $tpv=GetUserBV($db,$uid);
//         $res2=GetUserRank($db,$uid);
//         $rbv=$res2['pv'];
//         /*var_dump($res);
//         echo "tpv---".$tpv."-----rbv----".$rbv;*/
//         if(isset($tpv) && isset($rbv) && $tpv >= $rbv)
//         {
//             $result=1;
//         }
//     }
//     return $result;
// }

function GetMonthlyPurchaseStatus($db,$uid)
{
    $result=0;
 // FRENTIC57 and FRENTIC53 usre_id is 45 and 49 now this user has temperarly inactive update by Faiz 04-07-2020
  if($uid==45 || $uid==49){
   return $result;
  }
  else{
    $res=IsUserActive($db,$uid);
    if($res)
    {
        $tpv=GetUserBV($db,$uid);
        // $res2=GetUserRank($db,$uid);
        // $rbv=$res2['pv'];
        /*var_dump($res);
        echo "tpv---".$tpv."-----rbv----".$rbv;*/
        // if(isset($tpv) && isset($rbv) && $tpv >= $rbv)
        // {
        //     $result=1;
        // }
        $result=1;
    }
    return $result;
  }    
}
/*
 * get plan price
 */
function getplanprice($db,$uid)
{
    $q1 = mysqli_query($db,"SELECT t2.*,t3.* FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $plan_amount = $r1['plan_amount'];
        return "Plan: ".$plan_amount." Points";
    }
    else
    {
        return "No Active Plan";
    }
}

function getplanStatus($db,$uid)
{
    $q1 = mysqli_query($db,"SELECT t2.*,t3.* FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $plan_amount = $r1['plan_amount'];
        if($plan_amount > 0)
        {
           return 1; 
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 2;
    }
}
/*
 * Generate Transaction Pin With plan and pack
 */
function addnewpin($db,$plan_amount,$no_of_pin)
{
    for($i=1;$i<=$no_of_pin;$i++)
    {
        $pin_code = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,8);
        $q1 = mysqli_num_rows($db->query("SELECT * FROM `transpin` WHERE `pin_code` = '$pin_code'"));
        if($q1>0)
        {
            $i--;
        }
        else
        {
            $q2 = $db->query("INSERT INTO `transpin`(`pin_code`,`plan_id`) VALUES ('$pin_code','$plan_amount')");
            if($q2)
            {
                $c[] = 1;
            }
            else
            {
                $c[] = 0;
            }
        }
    }
    if(in_array(0, $c))
    {
        return 0;
    }
    else
    {
        return 1;
    }
}
function addnewzeropin($db,$plan_id,$no_of_pin)
{
    for($i=1;$i<=$no_of_pin;$i++)
    {
        $pin_code = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,8);
        $q1 = mysqli_num_rows($db->query("SELECT * FROM `transpin` WHERE `pin_code` = '$pin_code'"));
        if($q1>0)
        {
            $i--;
            //addnewzeropin($db,$plan_id,$no_of_pin);
        }
        else
        {
            $q2 = $db->query("INSERT INTO `transpin`(`pin_code`,`plan_id`) VALUES ('$pin_code','$plan_id')");
            if($q2)
            {
                $c[] = 1;
            }
            else
            {
                $c[] = 0;
            }
        }
    }
    if(in_array(0, $c))
    {
        return 0;
    }
    else
    {
        return $pin_code;
    }
}
/*
 * Generate and allot transfer pin to user by administrator
 */
function addtransferpin($db,$mlmid,$uid,$plan_id,$no_of_pin)
{
    global $crdate;
    for($i=1;$i<=$no_of_pin;$i++)
    {
        $pin_code = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,8);
        $q1 = mysqli_num_rows($db->query("SELECT * FROM `transpin` WHERE `pin_code` = '$pin_code'"));
        if($q1>0)
        {
            $i--;
        }
        else
        {
            $q2 = $db->query("INSERT INTO `transpin`(`pin_code`,`plan_id`,`allot_uid`) VALUES ('$pin_code','$plan_id','$uid')");
            if($q2)
            {
                $pin_id = mysqli_insert_id($db);
                $q2 = $db->query("INSERT INTO `transferpin`(`pin_id`, `allot_by`, `allot_to`, `date`) VALUES ($pin_id,$mlmid,$uid,'$crdate')");
                $c[] = 1;
            }
            else
            {
                $c[] = 0;
            }
        }
    }
    if(in_array(0, $c))
    {
        return 0;
    }
    else
    {
        return 1;
    }
}
/*
 Check Transaction pin
 */
function checkTransPin($db,$pin)
{
    $q1 = $db->query("SELECT * FROM `transpin` WHERE `pin_code` = '$pin'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        if($r1["status"] == 0)
        {
            return 1;
        }
        else
        {
            return "PIN is Already Used";
        }
    }
    else
    {
        return "Not A Valid Pin";
    }
}
function MatchPlanTransPin($db,$plan_id,$pin)
{
    $q1 = $db->query("SELECT * FROM `transpin` WHERE `pin_code` = '$pin' and plan_id= '$plan_id'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        if($r1["status"] == 0)
        {
     
            return 1;
        }
        else
        {
            return "PIN is Already Used";
        }
    }
    else
    {
        return "Package and Pin Does Not Match!";
    }
}

function get_plan_binary_count($uid){
    global $db;
    $binary_count  = 1;
    $q = mysqli_query($db,"SELECT 
                            t3.binary_count 
                            FROM user_id t1 
                            INNER JOIN transpin t2 ON t2.pin_code = t1.pin
                            INNER JOIN plans t3 ON t3.plan_id = t2.plan_id
                        WHERE t1.uid = '$uid'"
                    ) or die(mysqli_error($db));
    if(mysqli_affected_rows($db)>0){
        $r = mysqli_fetch_assoc($q);
        $binary_count = $r['binary_count'];
    }
    return $binary_count;
}


function UserPairing($db,$uid,$parent_id,$sponsor_id,$position=null)
{
    global $crdate;
    $plan_binary_count = get_plan_binary_count($uid);
    $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
    //$plan_count1=getPlanCount($db,$uid);
    $plan_count1 = getPlanCount($db,$uid);
    /*$check_position1 = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
    $chkqry21 = mysqli_num_rows($check_position1);*/
    //var_dump($parent_id);
    //echo "<br><br>4";
    /*if($chkqry21>0){
        $parent_id=GetValidParentUId($db,$parent_id,$sponsor_id,$position);
    }*/
    //var_dump($parent_id);
    //echo "<br><br>5";
    $pair=mysqli_query($db,"INSERT INTO `pairing`(`uid`, `parent_id`, `sponsor_id`, `position`, `date`) VALUES ('$uid','$parent_id','$sponsor_id','$position','$crdate')");    
    $q5 = mysqli_query($db,"INSERT INTO `user_bank`(`uid`) VALUES ($uid)");
    //echo "INSERT INTO `child_counter`(`uid`) VALUES ($uid)";
    $q6 = mysqli_query($db,"INSERT INTO `child_counter`(`uid`) VALUES ($uid)");
    $q7 = mysqli_query($db,"UPDATE `child_counter` SET `count`=`count`+$plan_count1 WHERE uid='$parent_id'");
    $q9 = mysqli_query($db,"UPDATE `user_id` SET `plan_date`=NULL WHERE uid='$parent_id'");
    
    //echo "INSERT INTO `direct_payment`(`uid`,`date`) VALUES ($uid,'$crdate')";
    $q8 = mysqli_query($db,"INSERT INTO `direct_payment`(`uid`,`date`) VALUES ($uid,'$crdate')");
    //$q9 = mysqli_query($db,"INSERT INTO `bonus`(`uid`,`date`) VALUES ($uid,'$crdate')");
    //$q9 = mysqli_query($db,"INSERT INTO `ref_bonus`(`uid`,`date`) VALUES ($uid,'$crdate')");

    //BinaryCount($db,$uid,$isPLanRB,$plan_count1,$plan_binary_count);
    //Totalcounter($db,$uid);
    //updateLeftRighCounter($db,$parent_id,$uid,$position);
    
    ConfirmBinaryActivate($db,$uid,$plan_binary_count);
    $q7 = mysqli_query($db,"UPDATE `child_counter` SET `sponsor_count`=`sponsor_count`+1 WHERE uid='$sponsor_id'");
    
    return;
}
function UserPairing_web($db,$uid,$parent_id,$sponsor_id,$position=null)
{
    global $crdate;
    $plan_binary_count = get_plan_binary_count($uid);
    $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
    //$plan_count1=getPlanCount($db,$uid);
    $plan_count1 = getPlanCount($db,$uid);
    $pair=mysqli_query($db,"INSERT INTO `pairing`(`uid`, `parent_id`, `sponsor_id`, `date`) VALUES ('$uid','$parent_id','$sponsor_id','$crdate')");    
    $q5 = mysqli_query($db,"INSERT INTO `user_bank`(`uid`) VALUES ($uid)");
    //echo "INSERT INTO `child_counter`(`uid`) VALUES ($uid)";
    $q6 = mysqli_query($db,"INSERT INTO `child_counter`(`uid`) VALUES ($uid)");
    //$q7 = mysqli_query($db,"UPDATE `child_counter` SET `count`=`count`+$plan_count1 WHERE uid='$parent_id'");
    
    //echo "INSERT INTO `direct_payment`(`uid`,`date`) VALUES ($uid,'$crdate')";
    $q8 = mysqli_query($db,"INSERT INTO `direct_payment`(`uid`,`date`) VALUES ($uid,'$crdate')");
    $q9 = mysqli_query($db,"INSERT INTO `bonus`(`uid`,`date`) VALUES ($uid,'$crdate')");
    $q9 = mysqli_query($db,"INSERT INTO `ref_bonus`(`uid`,`date`) VALUES ($uid,'$crdate')");
    Totalcounter($db,$uid);
    updateLeftRighCounter($db,$parent_id,$uid,$position);
    $q7 = mysqli_query($db,"UPDATE `child_counter` SET `sponsor_count`=`sponsor_count`+1 WHERE uid='$sponsor_id'");
    
    return;
}
function UserPairing_new1($db,$uid,$parent_id,$sponsor_id)
{
    global $crdate;
    $pair=mysqli_query($db,"INSERT INTO `pairing`(`uid`, `parent_id`, `sponsor_id`, `date`) VALUES ('$uid','$parent_id','$sponsor_id','$crdate')");
   
    return;
}
function ActivateUser($db,$uid,$pin_no)
{
    $ur1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.parent_id,t1.sponsor_id,t1.position FROM `pairing` t1  WHERE t1.`uid` = '$uid' and t1.uid!=1"));
    $parent_id=$ur1['parent_id'];
    $sponsor_id=$ur1['sponsor_id'];
    $position=$ur1['position'];
   // $q0 = mysqli_query($db,"UPDATE user_id set status=1 where uid='$uid'");
    $plan_binary_count = get_plan_binary_count($uid);
    $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
    //$plan_count1=getPlanCount($db,$uid);
    $plan_count1 = getPlanCount($db,$uid);
   
    $q7 = mysqli_query($db,"UPDATE `child_counter` SET `count`=`count`+$plan_count1 WHERE uid='$parent_id'");
    //BinaryCount($db,$uid,$isPLanRB,$plan_count1,$plan_binary_count);
    ConfirmBinaryActivate($db,$uid,$plan_binary_count);
   
    
    return;
}
function ActivateUser_old($db,$uid)
{
    global $crdate;
    $ur1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.parent_id,t1.sponsor_id FROM `pairing` t1  WHERE t1.`uid` = '$uid' and t1.uid!=1"));
    $parent_id=$ur1['parent_id'];
    $sponsor_id=$ur1['sponsor_id'];
    $q0 = mysqli_query($db,"UPDATE user_id set status=1 where uid='$uid'");
    $q5 = mysqli_query($db,"INSERT INTO `user_bank`(`uid`) VALUES ($uid)");
    //echo "INSERT INTO `child_counter`(`uid`) VALUES ($uid)";
    $q6 = mysqli_query($db,"INSERT INTO `child_counter`(`uid`) VALUES ($uid)");
    $q7 = mysqli_query($db,"UPDATE `child_counter` SET `count`=`count`+1 WHERE uid='$parent_id'");
    //echo "INSERT INTO `direct_payment`(`uid`,`date`) VALUES ($uid,'$crdate')";
    $q8 = mysqli_query($db,"INSERT INTO `direct_payment`(`uid`,`date`) VALUES ($uid,'$crdate')");
    $q9 = mysqli_query($db,"INSERT INTO `bonus`(`uid`,`date`) VALUES ($uid,'$crdate')");
    Totalcounter($db,$uid);
    updateLeftRighCounter($db,$parent_id,$uid);
    BinaryCount($db,$uid,$isPLanRB,$plan_count);
    
    $fpay=FirstRegisterPayment($db,$uid,$sponsor_id,1);
}

function UpgradeUserPin($db,$uid,$pin_no)
{
    $date1=date("Y-m-d H:i:s");
    $oldq=mysqli_query($db,"SELECT * FROM transpin WHERE uid = '$uid'");
    if(mysqli_num_rows($oldq) > 0)
    {
        $stm_update='';
        $olddata=mysqli_fetch_assoc($oldq);
        $old_pin=$olddata['pin_code'];
        $ur1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.parent_id,t1.sponsor_id,t1.position FROM `pairing` t1  WHERE t1.`uid` = '$uid' and t1.uid!=1"));
        $parent_id=$ur1['parent_id'];
        $sponsor_id=$ur1['sponsor_id'];
        $position=$ur1['position'];


        $old_plan_count=getPlanCount($db,$uid);
        $old_plan_bcount=get_plan_binary_count($uid);
        $levelPercent=getPlanPerc($db,$uid);
        $lper=$levelPercent[0];
    
        
        foreach ($olddata as $key=>$val)
        {
            $val = mysqli_real_escape_string($db,$val);
            $stm_update.="".$key."='$val',";
        }
        $stm_update=substr($stm_update, 0, -1);
        //echo "update `$info` set $stm_update where `uid`=$mlmid";
        $query = mysqli_query($db, "INSERT INTO `old_pin` SET $stm_update");
    

        $query0 = $db->query("DELETE FROM transpin where pin_code = '$old_pin' and uid = '$uid'") or die(mysqli_error($db));
        $query1 = $db->query("UPDATE transpin SET uid = '$uid',status=1 where pin_code = '$pin_no'") or die(mysqli_error($db));
        $query2 = $db->query("UPDATE user_id SET pin = '$pin_no',plan_date = '$date1' where uid = '$uid'") or die(mysqli_error($db));
        
        //$fpay=UpgradeRegisterPayment($db,$uid,$sponsor_id,1,$lper);
        $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
        $new_plan_count=getPlanCount($db,$uid);
        $new_plan_bcount=get_plan_binary_count($uid);
        
        $plan_count=$new_plan_count-$old_plan_count;
        $plan_bcount=$new_plan_bcount-$old_plan_bcount;
        //BinaryCount($db,$uid,$isPLanRB,$plan_count,$plan_bcount);
        //UpgradeTotalcounter($db,$uid,$isPLanRB,$plan_count);
        //updateLeftRighCounter($db,$sponsor_id,$uid);
        if($isPLanRB==1)
        {
            ConfirmBinaryActivate($db,$uid);
        }
        //UpgradeSponsorRoi($db,$uid);
        $msg=true;
    }
    else
    {
        $msg=false;
    }
   
    
    return $msg;
}

function SendRegSMS($db,$uid)
{

}
function UpdateDirectChildCount($db,$direct_sponser,$child)
{
    $q1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `child_counter` WHERE `parent_id` = $direct_sponser"));
    $directsponser1 = $q1['directsponser']+1;
    $q2 = mysqli_query($db,"UPDATE `child_counter` SET `sponser_count`= $directsponser1 WHERE `parent_id` = $direct_sponser");
    $q3 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` WHERE `parent_id` = $direct_sponser"));
    $directsponser2 = $q3['directsponser']+1;
    $q4 = mysqli_query($db,"UPDATE `pairing` SET `sponser_id`= $directsponser2 WHERE `parent_id` = $direct_sponser");
    $date = date('Y-m-d G:i:s');
   // $q5 = mysqli_query($db,"INSERT INTO `direct_child`(`parent_id`, `child_id`, `date`) VALUES ('$direct_sponser','$child','$date')");
    return true;
}
function getPinAmount($db,$uid)
{
    //echo "SELECT t2.*,t3.* FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'";
    $q1 = mysqli_query($db,"SELECT t2.*,t3.* FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $plan_amount = $r1['plan_amount'];
        return $plan_amount;
    }
    else
    {
        return 0;
    }
}
function getRPlanAmount($db)
{ 
    $q1 = mysqli_query($db,"SELECT royal_amount FROM `plans` where binary_royalty=1");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $plan_amount = $r1['royal_amount'];
        return $plan_amount;
    }
    else
    {
        return 0;
    }
}
function getRoyalNUser($db)
{ 
    $q1 = mysqli_query($db,"SELECT count(t1.uid) as nuser FROM `user_id` t1 join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id= t3.plan_id where t3.binary_royalty=1 and (t1.register_date > (SELECT `last_date` FROM `total_user`) OR t1.plan_date > (SELECT `last_date` FROM `total_user`))");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $nuser = $r1['nuser'];
        return $nuser;
    }
    else
    {
        return 0;
    }
}
function getRefPlanAmount($db)
{ 
    $q1 = mysqli_query($db,"SELECT pb_amount FROM `plans` where binary_royalty=1");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $plan_amount = $r1['pb_amount'];
        return $plan_amount;
    }
    else
    {
        return 0;
    }
}

function getRefNUser($db)
{ 
    $q1 = mysqli_query($db,"SELECT count(t1.uid) as nuser FROM `user_id` t1 join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id= t3.plan_id where t3.binary_royalty=1 and t1.register_date > (SELECT `ref_date` FROM `total_user`)");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $nuser = $r1['nuser'];
        return $nuser;
    }
    else
    {
        return 0;
    }
}

function getPlanCount($db,$uid)
{ 
    //echo "SELECT t3.count FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'";
    $q1 = mysqli_query($db,"SELECT t3.count FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $plan_count = $r1['count'];
        return $plan_count;
    }
    else
    {
        return 0;
    }
}

function IsPlanRoyaltyBinary($db,$uid)
{ 
    //echo "SELECT t3.binary_royalty FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'";
    $q1 = mysqli_query($db,"SELECT t3.binary_royalty FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $binary_royalty = $r1['binary_royalty'];
        return $binary_royalty;
    }
    else
    {
        return 0;
    }
}

function getPlanPerc($db,$uid)
{
    $q1 = mysqli_query($db,"SELECT t2.*,t3.* FROM transpin t2  join plans t3 on t2.plan_id = t3.plan_id and t2.uid = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $level_perc = json_decode($r1['level_perc']);
        return $level_perc;
    }
    else
    {
        return 0;
    }
}

function FirstRegisterPayment($db,$uid,$parent_id,$is_sponsor)
{
    global $crdate;
    $amount=getPinAmount($db,$uid);
    $levelPercent=getPlanPerc($db,$uid);
    if($amount > 0)
    {
        $lper=$levelPercent[0];
        //$pay_amount=($amount * $lper) / 100;
        $pay_amount=$lper;
        $q2 = $db->query("SELECT t1.* FROM `user_id` t1  WHERE t1.`uid` = '$parent_id' and t1.status=1 ");
        if(mysqli_num_rows($q2)>0)
        {
            $sql=mysqli_query($db,"INSERT INTO `child_earning`(`uid`, `parent_id`, `perc`, `amount`, `date`) VALUES ('$uid','$parent_id','$lper','$pay_amount','$crdate')");
            AddFinalAmount($db,$parent_id,$pay_amount,$is_sponsor);
        }
        $i=1;
        //AllParentAmount($db,$uid,$parent_id,$amount,$i,$levelPercent);
    }
    return;
}

function UpgradeRegisterPayment($db,$uid,$parent_id,$is_sponsor,$old_amount)
{
    global $crdate;
    $amount=getPinAmount($db,$uid);
    $levelPercent=getPlanPerc($db,$uid);
    if($amount > 0)
    {
        $lper=$levelPercent[0];
        //$pay_amount=($amount * $lper) / 100;
        //echo $lper."-------".$old_amount;
        $pay_amount=$lper-$old_amount;
        $q2 = $db->query("SELECT t1.* FROM `user_id` t1  WHERE t1.`uid` = '$parent_id' and t1.status=1 ");
        if(mysqli_num_rows($q2)>0)
        {
            $sql=mysqli_query($db,"INSERT INTO `child_earning`(`uid`, `parent_id`, `perc`, `amount`, `date`) VALUES ('$uid','$parent_id','$lper','$pay_amount','$crdate')");
            //AddFinalAmount($db,$parent_id,$pay_amount,$is_sponsor);
            $sql1=mysqli_fetch_assoc(mysqli_query($db,"select * from direct_payment where uid='$parent_id'"));
            $pamount=$sql1['amount']+$pay_amount;
            //echo "update direct_payment set amount='$pamount',date='$crdate' where uid='$parent_id'";
            $qry=mysqli_query($db,"update direct_payment set amount='$pamount',date='$crdate' where uid='$parent_id'") or die(mysqli_error($db));
        }
        $i=1;
        //AllParentAmount($db,$uid,$parent_id,$amount,$i,$levelPercent);
    }
    return;
}
function AllParentAmount($db,$uid,$parent_id,$amount,$i,$levelPercent)
{
    global $LevelPercentNo;
    global $crdate;
    //$q2 = $db->query("SELECT t1.* FROM `pairing` t1 join user_id t2 on t1.uid=t2.uid WHERE t1.`uid` = '$parent_id' and t2.`status`='1'");
    $q2 = $db->query("SELECT t1.* FROM `pairing` t1  WHERE t1.`uid` = '$parent_id' and t1.uid!=1");
    if(mysqli_num_rows($q2)>0)
    {
        if($i < $LevelPercentNo)
        {
            $r1=mysqli_fetch_assoc($q2);
            $parent_id1=$r1['parent_id'];
            $lper=$levelPercent[$i];
            //$pay_amount=($amount * $lper) / 100;
            $pay_amount=$lper;
            $q2 = $db->query("SELECT t1.* FROM `user_id` t1  WHERE t1.`uid` = '$parent_id1' and t1.status=1 ");
            if(mysqli_num_rows($q2)>0)
            {
                $sql=mysqli_query($db,"INSERT INTO `child_earning`(`uid`, `parent_id`, `perc`, `amount`, `date`) VALUES ('$uid','$parent_id1','$lper','$pay_amount','$crdate')");
                AddFinalAmount($db,$parent_id1,$pay_amount,0);
            }
            $i++;
            if($parent_id1!=1)
            {
                AllParentAmount($db,$uid,$parent_id1,$amount,$i,$levelPercent);
            }
        }
        else
        {
            return;
        }
    }
    else
    {
        return;
    }
}
function AddFinalAmount($db,$uid,$amount,$is_sponsor)
{
    global $crdate;
    $sql1=mysqli_fetch_assoc(mysqli_query($db,"select * from direct_payment where uid='$uid'"));
        $pamount=$sql1['amount']+$amount;
        $qry=mysqli_query($db,"update direct_payment set amount='$pamount',date='$crdate' where uid='$uid'");
    if($is_sponsor==1)
    {
        /*$sql1=mysqli_fetch_assoc(mysqli_query($db,"select * from direct_payment where uid='$uid'"));
        $pamount=$sql1['amount']+$amount;
        $qry=mysqli_query($db,"update direct_payment set amount='$pamount',date='$crdate' where uid='$uid'");*/
    }
    else
    {
        /*$sql1=mysqli_fetch_assoc(mysqli_query($db,"select * from direct_payment where uid='$uid'"));
        $pamount=$sql1['amount']+$amount;
        $due_amount=$sql1['due_amount']+$amount;
        $chk=mysqli_fetch_assoc(mysqli_query($db,"select t3.plan_amount from pairing t1 join transpin t2 on t1.uid = t2.uid join plans t3 on t2.plan_id = t3.plan_id where t1.uid='$uid'"));
        if($chk['plan_amount'] > 0)
        { 
            $amount_all=$pamount+$sql1['due_amount'];
            $due_amount1=0;
            $qry=mysqli_query($db,"update direct_payment set amount='$amount_all',due_amount='$due_amount1',date='$crdate' where uid='$uid'");
        }
        else
        {
            $qry=mysqli_query($db,"update direct_payment set due_amount='$due_amount',date='$crdate' where uid='$uid'");
        }*/
    }
    return;
}
//generate direct payout
function Generatepayout($db)
{
    global $crdate;
    $datetime = new DateTime('today');
    $date = $datetime->format('Y-m-d');
    /*$q1 = mysqli_query($db,"SELECT * FROM `payout` WHERE DATE(`date`) = '$date'");
    if(mysqli_num_rows($q1)<1)
    {*/
    $sql = "SELECT t1.*,t2.*,t3.* FROM `child_counter` t1 join transpin t2 on t1.uid = t2.uid join plans t3 on t2.plan_id = t3.plan_id join user_id t4 on t1.uid=t4.uid where t3.plan_amount > 0  order by t2.uid";
    $q1 = mysqli_query($db,$sql);
    $check = mysqli_num_rows($q1);
    //echo "Date :".date('d/m/Y H:i:s')." q1 : ".$sql." ($check)\n";
    if($check >0)
    {
        while($r1 = mysqli_fetch_assoc($q1))
        {
            if($r1["count"]>0 )
            {
                $date = date("Y-m-d G:i:s");
                $uid = $r1["uid"];
                $payout_days = $r1["payout_days"];
                $datetime = new DateTime('today');
                $datetime->modify($payout_days);
                $planday = $datetime->format('Y-m-d');
                $sql2 = "Select * from direct_payment where DATE(date) between DATE('$planday') and DATE('$crdate') and `uid` = $uid";
                $qry123=mysqli_query($db,$sql2);
                $check1 = mysqli_num_rows($qry123);
                // echo " q2 : ".$sql2." ($check1)\n";
                if($check1 > 0)
                {
                    $count = $r1["count"];
                    $capping = $r1["capping"];
                    $r12 = mysqli_fetch_assoc($qry123);
                    $chk=mysqli_query($db,"select * from pairing where parent_id='$uid'");
                    if(mysqli_num_rows($chk) >= 5)
                    { 
                        $useramount=$r12["amount"]+$r12['due_amount'];
                        $due_amount1=0;
                        $uqd=mysqli_query($db,"update direct_payment set due_amount='$due_amount1',date='$crdate' where uid='$uid'");
                    }
                    else
                    {
                        $useramount = $r12["amount"];
                    }
                    if($useramount>0 )
                    {
                        if($useramount > $capping)
                        {
                            $useramount = $capping;
                            $companyamnt = $useramount-$capping;
                            $q2 = mysqli_query($db,"INSERT INTO `payout`(`uid`,  `amount`, `date`) VALUES ('$uid','$useramount','$date')");
                            if($q2)
                            {
                                $message = "Payout Generated: ".date('d/m/Y H:i:s')."
                                     uid : $uid
                                     Pair : $count
                                     Amount : $useramount";
                                // echo $message."\n---------------------------\n";
                                $msg=getLevelPayoutDetail($db,$uid);
                                if(isset($msg) && $msg!='' && !empty($msg))
                                {
                                   sendSMS($db,$uid,$msg); 
                                }
                                 reward_payment($db,$uid,$useramount);
                                $q4 = mysqli_query($db,"INSERT INTO `company_payout`(`uid`, `amount`, `date`) VALUES ('$uid','$companyamnt','$date')");
                                $q3 = mysqli_query($db,"UPDATE `direct_payment` SET `amount`= 0 WHERE `uid` = '$uid'");
                                if($q3)
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
                        else
                        {
                            $q2 = mysqli_query($db,"INSERT INTO `payout`(`uid`,  `amount`, `date`) VALUES ('$uid','$useramount','$date')");
                            if($q2)
                            {   
                                $message = "Payout Generated: ".date('d/m/Y H:i:s')."
                                     uid : $uid
                                     Pair : $count
                                     Amount : $useramount";
                                //echo $message."\n---------------------------\n";
                                $msg=getLevelPayoutDetail($db,$uid);
                                if(isset($msg) && $msg!='' && !empty($msg))
                                {
                                   sendSMS($db,$uid,$msg); 
                                }
                                reward_payment($db,$uid,$useramount);
                                $q3 = mysqli_query($db,"UPDATE `direct_payment` SET `amount`= 0 WHERE `uid` = '$uid'");
                                if($q3)
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
                    }
                    else
                    {
                        $c[] = 2;
                    }
                }
            }
            else
            {
                $c[] = 2;
            }
        }
        /*if(in_array(0,$c))
        {
            //generate_direct_commission($db);
            //echo "\nSome of the payout not generated";
        }
        elseif(in_array(1,$c))
        {
            //generate_direct_commission($db);
            // echo "\n Payout Generated ";
        }
        else
        {
            //generate_direct_commission($db);
            //echo "\n No Payout to generate";
        }*/
    }
    return $c;
}
function clear_allpayout1($db,$id)
{
    $date = date('Y-m-d G:i:s');
    $q2 = mysqli_query($db,"UPDATE `payout` SET `cleared`= 1,`cleared_date`= '$date' WHERE `uid` = $id");
    if($q2)
    {
        return true;
    }
    else
    {
        return "Some Problem Occure, payment did not clear";
    }
}

function clear_allpayout1_rank($db,$id)
{
    $date = date('Y-m-d G:i:s');
    $q2 = mysqli_query($db,"UPDATE `rank_payout` SET `cleared`= 1,`cleared_date`= '$date' WHERE `uid` = $id");
    if($q2)
    {
        return true;
    }
    else
    {
        return "Some Problem Occure, payment did not clear";
    }
}
//Clear Payout
function clear_payout($db)
{
    $q1 = mysqli_query($db,"SELECT * FROM `payout` where cleared = 0 ");
    if(mysqli_num_rows($q1)>0)
    {
        $date = date('Y-m-d G:i:s');
        while($r1 = mysqli_fetch_assoc($q1))
        {
            $id = $r1["id"];
            $q3 = mysqli_query($db,"UPDATE `payout` SET `cleared`= 1,`cleared_date`= '$date' WHERE `id` = $id");
            if($q3)
            {
                $c[] = 1;
            }
            else
            {
                $c[] = 0;
            }
        }
        if(in_array(0,$c))
        {
            return "Some of the payout not cleared";
        }
        else
        {
            return 1;
        }
    }
    else
    {
        return "No Payout to clear";
    }
}
//Transfer pin from one sponser to another
function transferpin($db,$mlmid,$uid,$pin_id)
{
    global $crdate;
    foreach($pin_id as $pin)
    {
        $q1 = $db->query("UPDATE `transpin` SET `allot_uid` = $uid WHERE `pin_id` = $pin");
        if($q1)
        {
            $q2 = $db->query("INSERT INTO `transferpin`(`pin_id`, `allot_by`, `allot_to`, `date`) VALUES ($pin,$mlmid,$uid,'$crdate')");
            $c[] = 1;
        }
        else
        {
            $c[] = 0;
        }
    }
    if(in_array(0, $c))
    {
        return 0;
    }
    else
    {
        return 1;
    }
}

function Totalcounter($db,$uid1)
{
    $qry= mysqli_query($db,"SELECT * FROM `child_counter` where uid!='$uid1'");
    //echo "SELECT t1.uid as tuid,t1.*,t2.* from user_id as t1 join child_counter as t2 where t1.uid= t2.uid and t1.paired <= '$pid' and t1.uid != '$uid'";
    //$isPLanRB=IsPlanRoyaltyBinary($db,$uid1);
    //echo "Count__".$plan_count=getPlanCount($db,$uid1); 
    $plan_count = getPlanCount($db,$uid1);
    
    $q6 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` where uid= '$uid1'"));
    $parent_id=$q6['parent_id'];
    while($r1=mysqli_fetch_assoc($qry))
    {
        $tuid=$r1['uid'];
        if(isset($parent_id))
        {        
            $q2 = mysqli_fetch_assoc(mysqli_query($db,"select * from child_counter where uid = '$tuid'"));
            $totalcount = $q2['totalcount'] + $plan_count;
            //echo "\n"."Update child_counter set totalcount = '$totalcount' where uid = $tuid";
            $user_isPLanRB=IsPlanRoyaltyBinary($db,$tuid);
            if($user_isPLanRB == 1)
            {
                $r2 = mysqli_fetch_assoc(mysqli_query($db,"SELECT repurchase,direct_count FROM `rpayout_detail` WHERE `mem_count` > $totalcount limit 1"));
                if($r2['repurchase'] > 0)
                {
                    $rep=CheckRePurchase($db,$tuid,$r2['repurchase']);
                }
                else
                {
                    $rep=true;
                }
                if($rep)
                {
                    //echo "UPDTAE child_counter set totalcount = '$totalcount' where uid = $tuid";
                    /* $chk_qry=mysqli_num_rows(mysqli_query($db,"SELECT `uid` FROM `pairing` WHERE `parent_id`=$tuid"));
                        //echo "$chk_qry >= $direct_count";
                    if($chk_qry >= $r2['direct_count'])
                    {*/
                        //echo "\n $tuid"."Update child_counter set totalcount = '$totalcount' where uid = $tuid"."\n"."SELECT * FROM `rpayout_detail` WHERE `mem_count` > $totalcount limit 1";
                        $q11 = mysqli_query($db,"UPDATE child_counter set totalcount = '$totalcount' where uid = $tuid")or die(mysqli_error($db));
                    /*}*/
                }
            }
        }
    }
    return true;
}
function UpgradeTotalcounter($db,$uid1,$isPLanRB,$plan_count)
{
    //echo $uid1."___".$isPLanRB."_____".$plan_count;
   // echo "SELECT * FROM `child_counter` where uid!=$uid1";
    $qry= mysqli_query($db,"SELECT * FROM `child_counter` where uid!=$uid1");
    //echo "SELECT t1.uid as tuid,t1.*,t2.* from user_id as t1 join child_counter as t2 where t1.uid= t2.uid and t1.paired <= '$pid' and t1.uid != '$uid'";
    $q6 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` where uid= '$uid1'"));
    $parent_id=$q6['parent_id'];
    $sponsor_id=$q6['sponsor_id'];
    if($isPLanRB==1)
    {
        $q7 = mysqli_query($db,"UPDATE `child_counter` SET `count`=`count`+$plan_count,`sponsor_count`=`sponsor_count`+1 WHERE uid='$sponsor_id'");
    }
    else
    {
        $q7 = mysqli_query($db,"UPDATE `child_counter` SET `count`=`count`+$plan_count WHERE uid='$parent_id'");
    }
    while($r1=mysqli_fetch_assoc($qry))
    {
        //echo "<pre>".var_dump($r1);
        $tuid=$r1['uid'];
        //&& $parent_id!=$tuid
        if(isset($parent_id) )
        {        
            $q2 = mysqli_fetch_assoc(mysqli_query($db,"select * from child_counter where uid = '$tuid'"));
            $totalcount = $q2['totalcount'] + $plan_count;
            //echo "\n"."Update child_counter set totalcount = '$totalcount' where uid = $tuid";
            $user_isPLanRB=IsPlanRoyaltyBinary($db,$tuid);
            if($user_isPLanRB == 1)
            {
                $r2 = mysqli_fetch_assoc(mysqli_query($db,"SELECT repurchase,direct_count FROM `rpayout_detail` WHERE `mem_count` > $totalcount limit 1"));
                if($r2['repurchase'] > 0)
                {
                    $rep=CheckRePurchase($db,$tuid,$r2['repurchase']);
                }
                else
                {
                    $rep=true;
                }
                if($rep)
                {
                    //echo "Update child_counter set totalcount = '$totalcount' where uid = $tuid";
                    $q11 = mysqli_query($db,"Update child_counter set totalcount = '$totalcount' where uid = $tuid");
                }
            }
        }
    }
    return true;
}
function GetNoOfUsers($db)
{
    //echo "select uid from user_id where status=1 order by uid";
    $sql=mysqli_query($db,"select uid from user_id where status=1 order by uid");
    if($sql)
    {
        $nouser=mysqli_num_rows($sql);
    }
    else
    {
        $nouser=0;
    }
    return $nouser;
}
function Generateplan2payout($db)
{
    $date=date("Y-m-d H:i:s");
    $ch=array();
    //echo "UPDATE `rpayout` SET status=3 where status=2";
    //echo "UPDATE `rpayout` SET status=2 where status=1";
    //$q2=mysqli_query($db,"UPDATE `rpayout` SET status=3 where status=2");
    $q2=mysqli_query($db,"UPDATE `rpayout` SET status=2 where status=1");
    $sql=mysqli_query($db,"select * from rpayout_detail order by id");
    while($r0=mysqli_fetch_assoc($sql))
    {
        extract($r0);
        $qry="SELECT * from child_counter where totalcount >= $mem_count";
        $qry1= mysqli_query($db,$qry);
        if(mysqli_num_rows($qry1) > 0)
        {
            $planamount=getRPlanAmount($db);
            while($r1=mysqli_fetch_assoc($qry1))
            {
                //var_dump($r1);
                $uid=$r1['uid'];
                $tcount = $r1['totalcount'];
                $tt= $r1['count'];
                //$planamount=getPinAmount($db,$uid);
                $total_count=$mem_count;
                
                $bonus_amount=($planamount * $income_perc)/100;
                //$bonus_amount= $income_perc;
                $amount_col="amount".$r0['id'];
                $br1=mysqli_fetch_assoc(mysqli_query($db,"select `$amount_col` from `bonus` WHERE uid='$uid'"));
                $ebamount=$br1[$amount_col];
                //echo "$ebamount<$capping------$uid";
                if($ebamount<$capping)
                {
                    if($bonus_amount > $capping)
                    {
                        $total_amount = $capping;
                    }
                    else
                    {
                        $total_amount = $bonus_amount;
                    }
                    if($repurchase > 0)
                    {
                        $res=CheckRePurchase($db,$uid,$repurchase);
                    }
                    else
                    {
                        $res=true;
                    }
                    if($res)
                    {
                        $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
                        $chk_qry=mysqli_num_rows(mysqli_query($db,"SELECT `uid` FROM `pairing` WHERE `parent_id`=$uid"));
                        //echo "$chk_qry >= $direct_count";
                        if($chk_qry >= $direct_count && $isPLanRB==1)
                        {
                            //echo "\n<br>plan amount ".$planamount."_____prcentage ".$income_perc."____";
                            /*if($total_amount >0)
                            {
                             */   $qry2= mysqli_fetch_assoc(mysqli_query($db,"SELECT * from rpayout where uid='$uid' and total_count='$total_count' and status=1"));
                                if($qry2)
                                {
                                   //echo "\n UPDATE `rpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', direct_count= '$direct_count',status=1, perc='$income_perc', updated='$date' where uid='$uid' and total_count='$total_count'";
                                    $q1 = mysqli_query($db,"UPDATE `rpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', direct_count= '$direct_count',status=1, perc='$income_perc', updated='$date' where uid='$uid' and total_count='$total_count'");
                                }
                                else
                                {
                                  //echo "\n INSERT INTO `rpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', total_count='$total_count', direct_count= '$direct_count',uid ='$uid',status=1, perc='$income_perc',created='$date'";
                                    $q1 = mysqli_query($db,"INSERT INTO `rpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', total_count='$total_count', direct_count= '$direct_count',uid ='$uid',status=1, perc='$income_perc',created='$date'") or die(mysqli_error($db));
                                }
                                if($q1)
                                {
                                    $c[] = 1;
                                }
                                else
                                {
                                    $c[] = 0;
                                }
                            /*}
                            else
                            {
                                $c[] = 0;
                            }*/
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
                else
                {
                    $c[] = 0;
                }
            }
             if(in_array(1,$c))
            {
                $ch[] = 1;
            }
            else if(!in_array(1,$c))
            {
                $ch[] = 0;
            }
            else 
            {
                $ch[] = 0;
            }
        }
    }
    return $ch;
}
function Generateplan3payout($db)
{
    global $crdate;
    $amount=$amount1=$tot_amount=0;
    $date=date("Y-m-d H:i:s");
    $smsid=array();
    /*$luser=mysqli_fetch_assoc(mysqli_query($db,"select count from total_user"));
    $last_user_count=$luser['count'];
    $user_count=GetNoOfUsers($db);*/
    //$user_count=88;
    //echo "user_count__".$user_count."_________________last_user_count__".$last_user_count;
    //$nuser= ($user_count * 1)-($last_user_count * 1);
    $nuser=getRoyalNUser($db);
    $planamount=getRPlanAmount($db);
    $tot_amount=$nuser * $planamount;
     $q1 = mysqli_query($db,"UPDATE `total_user` SET `last_date` = '$crdate' WHERE `id` = 1");  
    /*if($nuser > 0 && $user_count > 0)
    {
        //echo "UPDATE `total_user` SET `count` = '$user_count' WHERE `id` = 1";
        $q1 = mysqli_query($db,"UPDATE `total_user` SET `count` = '$user_count' WHERE `id` = 1");
    }*/
    $sql=mysqli_query($db,"select `id`,`income_perc`,`capping`,`mem_count` from rpayout_detail order by id");
    while($r0=mysqli_fetch_assoc($sql))
    {    
        $perc=$r0['income_perc'];
        $mem_count=$r0['mem_count'];
        $capping=$r0['capping'];
        
        //$planamount=getPinAmount($db,'2');
        
        $amount_col="amount".$r0['id'];
        //echo "\n <br><br><br> user_".$nuser."_____prcentage__".$perc." _________tot_amount__".$tot_amount."_______planamount__".$planamount;
        //echo "select * from `rpayout` where status=2 and perc='$perc'";
        //$q1=mysqli_query($db,"select * from `rpayout` where status=2 and perc='$perc'");
        $q1=mysqli_query($db,"select * from `rpayout` where status=2 and total_count='$mem_count'");
        $q29=mysqli_query($db,"select DISTINCT uid from `rpayout` where status=2 and total_count='$mem_count'");
        $euser=mysqli_num_rows($q29);
        if($euser > 0)
        { 
            //echo $euser;
            $amount1=($tot_amount * $perc)/100;
            $amount=$amount1 / $euser;
            
                //echo "\n <br> user_".$euser."_____prcentage__".$perc."_________tot_amount__".$tot_amount."_______amount__".$amount;
                while($r1=mysqli_fetch_assoc($q1))
                {
                    $uid=$r1['uid'];
                    $direct_count=$r1['direct_count'];
                    $q5=mysqli_fetch_assoc(mysqli_query($db,"select `$amount_col` from `bonus` WHERE uid='$uid'"));
                    $ebamount=$q5[$amount_col];
                    $chkamount=$ebamount+$amount;
                    if($chkamount >= $capping)
                    {
                        $amountb=$capping-$ebamount;
                        $chkamount=$capping;
                    }
                    else{
                        $amountb=$amount;
                    }
                    //echo "\n <br> user_id____".$uid."______ user_".$euser."_____prcentage__".$perc."_________tot_amount__".$tot_amount."_______amount__".$amount."_______chkamount____".$chkamount."_______amountb____".$amountb;
                    
                    $chk_qry=mysqli_num_rows(mysqli_query($db,"SELECT `uid` FROM `pairing` WHERE `parent_id`=$uid"));
                    //echo "$chk_qry >= $direct_count";
                    $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
                    if($chk_qry >= $direct_count && $isPLanRB==1)
                    {
                        $bqry3=mysqli_query($db,"select id,uid,b_amount from `payout` WHERE uid='$uid' and cleared=0");
                        $qq_no=mysqli_num_rows($bqry3);
                        if($qq_no > 0)
                        {      
                            $brow=mysqli_fetch_assoc($bqry3);
                            //var_dump($brow);
                            $b_amount=$amountb+$brow['b_amount'];
                            $pid=$brow['id'];
                            //echo "\n <br><br> UPDATE `payout` SET `b_amount`= $b_amount WHERE uid='$uid' and id='$pid'";                          
                            $q2=mysqli_query($db,"UPDATE `payout` SET `b_amount`= $b_amount WHERE uid='$uid' and id='$pid'");
                        }
                        else
                        {
                            //echo "\n <br><br> INSERT INTO `payout` SET `uid`= $uid,`b_amount`= $amountb,`date`='$date'";
                            $q2=mysqli_query($db,"INSERT INTO `payout` SET `uid`= $uid,`b_amount`= $amountb,`date`='$date'");
                            // or die(mysqli_error($db))
                        }
                        if($q2)
                        {                              
                            $q6=mysqli_query($db,"UPDATE `bonus` SET `$amount_col`= $chkamount WHERE uid='$uid'");
                            //echo "INSERT INTO `rpayout_history` SET  `uid`= $uid,`b_amount`= $amountb,total_count='$mem_count',perc='$perc',`date`='$date' ";
                            $q7=mysqli_query($db,"INSERT INTO `rpayout_history` SET  `uid`= $uid,`b_amount`= $amountb,total_count='$mem_count',perc='$perc',`date`='$date' ") or die(mysqli_error($db));
                            $smsid[]=$uid;
                            //$msg=getRoyaltyPayoutDetail($db,$uid);
                            $c[] = 1;
                        }
                        else
                        {
                            $c[] = 0;
                        }
                    }
                    else
                    {
                        $c[] = 2;
                    }
                    
                }
                
            
        }
        else
        {
            $c[] = 2;
        }
       //echo "\n <br> UPDATE `rpayout` SET `status`=0,`updated='$date' where status=3 and total_count='$mem_count'";
        $q3=mysqli_query($db,"UPDATE `rpayout` SET status=0,updated='$date' where status=2 and total_count='$mem_count'");
    }
    
    $smsid=array_unique($smsid);

    /*echo "<br>After Uniqe_______________________________________________";
    var_dump($smsid);*/
    if(isset($smsid) && count($smsid) > 0)
    {
        foreach ($smsid as $key => $smsuid) {
            $msg=getRoyaltyPayoutDetail($db,$smsuid);
        }
                }
    return $c;
}
function Generateplan3payout_backup($db)
{
    $amount=$amount1=$tot_amount=0;
    $date=date("Y-m-d H:i:s");
    $luser=mysqli_fetch_assoc(mysqli_query($db,"select count from total_user"));
    $last_user_count=$luser['count'];
    $user_count=GetNoOfUsers($db);
    //$user_count=88;
    //echo "user_count__".$user_count."_________________last_user_count__".$last_user_count;
    $nuser= ($user_count * 1)-($last_user_count * 1);
    if($nuser > 0)
    {    
        if($user_count > 0)
        {
            //echo "UPDATE `total_user` SET `count` = '$user_count' WHERE `id` = 1";
            $q1 = mysqli_query($db,"UPDATE `total_user` SET `count` = '$user_count' WHERE `id` = 1");
        }
        $sql=mysqli_query($db,"select `id`,`income_perc`,`capping`,`mem_count` from rpayout_detail order by id");
        while($r0=mysqli_fetch_assoc($sql))
        {    
            $perc=$r0['income_perc'];
            $mem_count=$r0['mem_count'];
            $capping=$r0['capping'];
            $planamount=140;
            //$planamount=getPinAmount($db,'2');
            $tot_amount=$nuser * $planamount;
            $amount_col="amount".$r0['id'];
            //echo "\n <br><br><br> user_".$nuser."_____prcentage__".$perc." _________tot_amount__".$tot_amount."_______planamount__".$planamount;
            //echo "select * from `rpayout` where status=2 and perc='$perc'";
            //$q1=mysqli_query($db,"select * from `rpayout` where status=2 and perc='$perc'");
            $q1=mysqli_query($db,"select * from `rpayout` where status=2 and total_count='$mem_count'");
            $euser=mysqli_num_rows($q1);
            if($euser > 0)
            { 
                //echo $euser;
                $amount1=($tot_amount * $perc)/100;
                $amount=$amount1 / $euser;
                if($amount > 0)
                {
                    //echo "\n <br> user_".$euser."_____prcentage__".$perc."_________tot_amount__".$tot_amount."_______amount__".$amount;
                    while($r1=mysqli_fetch_assoc($q1))
                    {
                        $uid=$r1['uid'];
                        $direct_count=$r1['direct_count'];
                        $q5=mysqli_fetch_assoc(mysqli_query($db,"select `$amount_col` from `bonus` WHERE uid='$uid'"));
                        $ebamount=$q5[$amount_col];
                        $chkamount=$ebamount+$amount;
                        if($chkamount >= $capping)
                        {
                            $amountb=$capping-$ebamount;
                            $chkamount=$capping;
                        }
                        else{
                            $amountb=$amount;
                        }
                        //echo "\n <br> user_id____".$uid."______ user_".$euser."_____prcentage__".$perc."_________tot_amount__".$tot_amount."_______amount__".$amount."_______chkamount____".$chkamount."_______amountb____".$amountb;
                        if($amount > 0)
                        {
                            $chk_qry=mysqli_num_rows(mysqli_query($db,"SELECT `uid` FROM `pairing` WHERE `parent_id`=$uid"));
                            //echo "$chk_qry >= $direct_count";
                            if($chk_qry >= $direct_count)
                            {
                                $bqry3=mysqli_query($db,"select id,uid,b_amount from `payout` WHERE uid='$uid' and cleared=0");
                                $qq_no=mysqli_num_rows($bqry3);
                                if($qq_no > 0)
                                {      
                                    $brow=mysqli_fetch_assoc($bqry3);
                                    //var_dump($brow);
                                    $b_amount=$amountb+$brow['b_amount'];
                                    $pid=$brow['id'];
                                    //echo "\n <br><br>UPDATE `payout` SET `b_amount`= $b_amount WHERE uid='$uid' and id='$pid'";                          
                                    $q2=mysqli_query($db,"UPDATE `payout` SET `b_amount`= $b_amount WHERE uid='$uid' and id='$pid'");
                                }
                                else
                                {
                                    //echo "INSERT INTO `payout` SET `uid`= $uid,`b_amount`= $amountb,`date`='$date'";
                                    $q2=mysqli_query($db,"INSERT INTO `payout` SET `uid`= $uid,`b_amount`= $amountb,`date`='$date'");
                                    // or die(mysqli_error($db))
                                }
                                if($q2)
                                {                              
                                    $q6=mysqli_query($db,"UPDATE `bonus` SET `$amount_col`= $chkamount WHERE uid='$uid'");
                                    //echo "INSERT INTO `rpayout_history` SET  `uid`= $uid,`b_amount`= $amountb,total_count='$mem_count',perc='$perc',`date`='$date' ";
                                    $q7=mysqli_query($db,"INSERT INTO `rpayout_history` SET  `uid`= $uid,`b_amount`= $amountb,total_count='$mem_count',perc='$perc',`date`='$date' ") or die(mysqli_error($db));
                                    $msg=getPayoutDetail($db,$uid);
                                    if(isset($msg) && $msg!='' && !empty($msg))
                                    {
                                       sendSMS($db,$uid,$msg); 
                                    }
                                    $c[] = 1;
                                }
                                else
                                {
                                    $c[] = 0;
                                }
                            }
                            else
                            {
                                $c[] = 2;
                            }
                        }
                        else
                        {
                            $c[] = 2;
                        }
                    }
                }
                else
                {
                    $c[] = 2;
                }
            }
            else
            {
                $c[] = 2;
            }
           
            $q3=mysqli_query($db,"UPDATE `rpayout` SET status=0,updated='$date' where status=2 and total_count='$mem_count'");
        }
    }
    else
    {
        $c[] = 2;
    }
    return $c;
}
function Generateplan3payout_old($db)
{
    $amount=$amount1=$tot_amount=0;
    $date=date("Y-m-d H:i:s");
    $c=array();
    $last_user_count=mysqli_num_rows(mysqli_query($db,"select count from total_user"));
    $user_count=GetNoOfUsers($db);
    //var_dump($user_count);
    $nuser= ($user_count * 1)-($last_user_count * 1);
    if($nuser > 0)
    {        
        $planamount=1500;
        $tot_amount=$nuser * $planamount;
        $q1=mysqli_query($db,"select * from `rpayout` where status=2");
        if($euser=mysqli_num_rows($q1) > 0)
        { 
            $amount1=($tot_amount * 7)/100;
            $amount=$amount1 / $euser;
            if($amount > 0)
            {
                while($r1=mysqli_fetch_assoc($q1))
                {
                    $uid=$r1['uid'];
                    $direct_count=$r1['direct_count'];
                    $chk_qry=mysqli_num_rows(mysqli_query($db,"SELECT `uid` FROM `pairing` WHERE `parent_id`=$uid"));
                    if($chk_qry > $direct_count)
                    {
                        $qq_no=mysqli_num_rows(mysqli_query($db,"select uid from  `payout` WHERE uid='$uid'"));
                        if($qq_no > 0)
                        {
                            $q2=mysqli_query($db,"UPDATE `payout` SET `b_amount`= $amount WHERE uid='$uid'");
                        }
                        else
                        {
                            $q2=mysqli_query($db,"INSERT INTO `payout` SET `b_amount`= $amount,`date='$date'");
                        }
                        if($q2)
                        {
                            /*$msg=getPayoutDetail($db,$uid);
                            if(isset($msg) && $msg!='' && !empty($msg))
                            {
                               sendSMS($db,$uid,$msg); 
                            }*/
                            $c[] = 1;
                        }
                        else
                        {
                            $c[] = 0;
                        }
                    }
                    else
                    {
                        $c[] = 2;
                    }
                }
            }
            else
            {
                $c[] = 2;
            }
        }
        else
        {
            $c[] = 2;
        }
        $q3=mysqli_query($db,"UPDATE `rpayout` SET status=0 where status=2");
    }
    else
    {
        $c[] = 2;
    }
    return $c;
}
function Generatetotalpayout($db)
{
    $qry1= mysqli_query($db,"SELECT * from child_counter where totalcount >= 75");
    $tcount= mysqli_num_rows($qry1);
    $totalamount=0;
    $planamount=0;
    //$qry2= "SELECT * from child_counter where totalcount >= 50";
    $sql=mysqli_query($db,"SELECT * from child_counter where totalcount >= 50");
    while($t = mysqli_fetch_assoc($sql))
    {
        $id = $t['uid'];
        if($id != 0){
            $p1 = mysqli_query($db, "select t.plan_id as tpid,t.uid , p.* from transpin as t left join plans as p on t.plan_id = p.plan_id where t.uid='$id'");
            while($r1 = mysqli_fetch_assoc($p1)) {
                $planamount = $r1['plan_amount'];
                //echo "Planamount"."-".$planamount;
                $totalamount = ($tcount * $planamount) * 8 / 100;
                //echo "totalamount"."-".$totalamount;
                $actual= $totalamount/$tcount;
                //echo "actual"."-".$actual;
            }
        }
    }
}
//Tree Left & right childeren count
function total_child_count( $db, $id)
{
    $q =  mysqli_query( $db , "SELECT t1.*,t2.count FROM pairing t1 join child_counter t2 on t1.uid=t2.uid WHERE t1.uid = $id ");
    if(mysqli_num_rows($q)>0)
    {
        $r = mysqli_fetch_assoc($q);
        $totalcount = $r['count'];
    }
    else
    {
        $totalcount = 0;
    }
    return $totalcount ; 
}
/*function getPayoutDetail($db,$uid)
{
    $q =  mysqli_query( $db , "SELECT t1.uname,t1.uid as ttid,t2.first_name,t2.last_name,t2.pan_no,(SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a,(SELECT IFNULL(SUM(`b_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as b from user_id t1 join user_detail t2 on t1.uid =t2.uid and ((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 ) where t1.uid=$uid");
    if(mysqli_num_rows($q)>0)
    {
        $e=$g=0;
        $r = mysqli_fetch_assoc($q);
        $s=$r['a']+$r['b'];
        //$e = ($s*5/100);
        //$f = ($s*10/100);
        $istds=CheckTDSApply($db,$r['ttid']);
        if($istds)
        {
             $f = ($s*5/100);
        }
        else
        {
             $f=0;
        }
        if(isset($row['pan_no']) && !empty($row['pan_no']))
        {
            $e = ($s*5/100);
        }
        else
        {
             $g = ($s*20/100);
        }
        $d = $e+$f+$g;
        $sum = $s-$d;
        $msg = "Payout Generated \n  Username : $r[uname] \n Total Amount : $s \n TDS (5%) : $e \n Admin Charges (10%) : $f \n Pancard Charges (20 %) : $g \n Deduction Charge : $d \n Payout : $sum ";
    }
    else
    {
        $msg='';
    }
    return $msg;
}*/
function getLevelPayoutDetail($db,$uid)
{

    $q =  mysqli_query( $db , "SELECT t1.uname,t1.uid as ttid,t2.first_name,t2.last_name,t2.pan_no,t3.*,(SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as a from user_id t1 join user_bank t3 on t1.uid =t3.uid join user_detail t2 on t1.uid =t2.uid and t1.uid!=1 where ((SELECT IFNULL(SUM(`amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0)  and t1.uid=$uid");
    if($q)
    {
        if(mysqli_num_rows($q)>0)
        {
            $e=$g=0;

            while($r = mysqli_fetch_assoc($q))
            {
                $uid=$r['ttid'];
                $s=$r['a'];
                $e = ($s*5/100);
                $f = ($s*10/100);
                if(isset($r['pan_no']) && !empty($r['pan_no']))
                {
                    $g = 0;
                }
                else
                {
                     $g = ($s*20/100);
                }
                $d = $e+$f+$g;
                $sum = $s-$d;
                $msg = "Level Payout Generated \n  Username : $r[uname] \n Level Payout : $s \n TDS (5%) : $e \n Admin Charges (10%) : $f \n Pancard Charges (20 %) : $g \n Deduction Charge : $d \n Payout : $sum ";
                sendSMS($db,$uid,$msg); 
            }
        }
        else
        {
            $msg='';
        }
        //echo $msg."<br><br>";
    }
    return true;
}
function getRoyaltyPayoutDetail($db,$uid)
{
    $q =  mysqli_query( $db , "SELECT t1.uname,t1.uid as ttid,t2.first_name,t2.last_name,t2.pan_no,t3.*,(SELECT IFNULL(SUM(`b_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as b from user_id t1 join user_bank t3 on t1.uid =t3.uid join user_detail t2 on t1.uid =t2.uid and t1.uid!=1 where ((SELECT IFNULL(SUM(`b_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 ) and t1.uid=$uid");
    if($q)
    {
        if(mysqli_num_rows($q)>0)
        {
            $e=$g=0;

            $r = mysqli_fetch_assoc($q);
            $uid=$r['ttid'];
            $s=$r['b'];
            $e = ($s*5/100);
            $f = ($s*10/100);
            if(isset($r['pan_no']) && !empty($r['pan_no']))
            {
                $g = 0;
            }
            else
            {
                 $g = ($s*20/100);
            }
            $d = $e+$f+$g;
            $sum = $s-$d;
            $msg = "Royalty Payout Generated \n  Username : $r[uname] \n Royalty Payout : $r[b]  \n Total Amount : $s \n TDS (5%) : $e \n Admin Charges (10%) : $f \n Pancard Charges (20 %) : $g \n Deduction Charge : $d \n Payout : $sum ";
            //echo "\n\n".$msg;
            sendSMS($db,$uid,$msg);
        }
        else
        {
            $msg='';
        }
    }
    return true;
}
function getBinaryPayoutDetail($db,$uid)
{
    $q =  mysqli_query( $db , "SELECT t1.uname,t1.uid as ttid,t2.first_name,t2.last_name,t2.pan_no,t3.*,(SELECT IFNULL(SUM(`comission_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as e from user_id t1 join user_bank t3 on t1.uid =t3.uid join user_detail t2 on t1.uid =t2.uid and t1.uid!=1 where ((SELECT IFNULL(SUM(`comission_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0) and t1.uid=$uid");
    if($q)
    {
        if(mysqli_num_rows($q)>0)
        {
            $e=$g=0;

            $r = mysqli_fetch_assoc($q);
            $uid=$r['ttid'];
            $s=$r['e'];
            $e = ($s*5/100);
            $f = ($s*10/100);
            if(isset($r['pan_no']) && !empty($r['pan_no']))
            {
                $g = 0;
            }
            else
            {
                 $g = ($s*20/100);
            }
            $d = $e+$f+$g;
            $sum = $s-$d;
            $msg = "Payout Generated \n  Username : $r[uname] \n Binary Payout : $r[e] \n Total Amount : $s \n TDS (5%) : $e \n Admin Charges (10%) : $f \n Pancard Charges (20 %) : $g \n Deduction Charge : $d \n Payout : $sum ";
            sendSMS($db,$uid,$msg);
            //echo $msg;
        }
        else
        {
            $msg='';
        }
    }
    return true;
}

function getBonusPayoutDetail($db,$uid)
{
    $q =  mysqli_query( $db , "SELECT 
                                t1.uname,
                                t1.uid as ttid,
                                t2.first_name,
                                t2.last_name,
                                t2.pan_no,
                                t3.*,
                                (
                                    SELECT IFNULL(SUM(`comission_amount`),0) FROM `payout` 
                                    WHERE `cleared` = 0 and  `uid` = t1.uid
                                ) as e 
                                from user_id t1 
                                JOIN user_bank t3 on t1.uid = t3.uid 
                                JOIN user_detail t2 on t1.uid = t2.uid and t1.uid!=1 
                                where ((SELECT IFNULL(SUM(`comission_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0) and t1.uid=$uid");
    if($q)
    {
        if(mysqli_num_rows($q)>0)
        {
            $e=$g=0;

            $r = mysqli_fetch_assoc($q);
            $uid=$r['ttid'];
            $s=$r['e'];
            $e = ($s*5/100);
            $f = ($s*10/100);
            if(isset($r['pan_no']) && !empty($r['pan_no']))
            {
                $g = 0;
            }
            else
            {
                 $g = ($s*20/100);
            }
            $d = $e+$f+$g;
            $sum = $s-$d;
            $msg = "Payout Generated \n  Username : $r[uname] \n Binary Payout : $r[e] \n Total Amount : $s \n TDS (5%) : $e \n Admin Charges (10%) : $f \n Pancard Charges (20 %) : $g \n Deduction Charge : $d \n Payout : $sum ";
            sendSMS($db,$uid,$msg);
            //echo $msg;
        }
        else
        {
            $msg='';
        }
    }
    return true;
}


function getReferalPayoutDetail($db,$uid)
{
    $q =  mysqli_query( $db , "SELECT t1.uname,t1.uid as ttid,t2.first_name,t2.last_name,t2.pan_no,t3.*,(SELECT IFNULL(SUM(`ref_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) as b from user_id t1 join user_bank t3 on t1.uid =t3.uid join user_detail t2 on t1.uid =t2.uid and t1.uid!=1 where ((SELECT IFNULL(SUM(`ref_amount`),0) FROM `payout` WHERE `cleared` = 0 and  `uid` = t1.uid) >0 ) and t1.uid=$uid");
    if($q)
    {
        if(mysqli_num_rows($q)>0)
        {
            $e=$g=0;

            $r = mysqli_fetch_assoc($q);
            $uid=$r['ttid'];
            $s=$r['b'];
            $e = ($s*5/100);
            $f = ($s*10/100);
            if(isset($r['pan_no']) && !empty($r['pan_no']))
            {
                $g = 0;
            }
            else
            {
                 $g = ($s*20/100);
            }
            $d = $e+$f+$g;
            $sum = $s-$d;
            $msg = "Referal Payout Generated \n  Username : $r[uname] \n Referal Payout : $r[b]  \n Total Amount : $s \n TDS (5%) : $e \n Admin Charges (10%) : $f \n Pancard Charges (20 %) : $g \n Deduction Charge : $d \n Payout : $sum ";
            //echo "\n\n".$msg;
            sendSMS($db,$uid,$msg);
        }
        else
        {
            $msg='';
        }
    }
    return true;
}
/********************************** Referal Bonus Payout ******************************/
function GenerateRefPayout1($db)
{
    $date=date("Y-m-d H:i:s");
    $ch=array();
    //echo "UPDATE `refpayout` SET status=3 where status=2";
    //echo "UPDATE `refpayout` SET status=2 where status=1";
    //$q2=mysqli_query($db,"UPDATE `refpayout` SET status=3 where status=2");
    $q2=mysqli_query($db,"UPDATE `refpayout` SET status=2 where status=1");
    $sql=mysqli_query($db,"select * from referel_bonus_detail order by id");
    while($r0=mysqli_fetch_assoc($sql))
    {
        extract($r0);
        $qry="SELECT * from child_counter where sponsor_count >= $mem_count";
        $qry1= mysqli_query($db,$qry);
        if(mysqli_num_rows($qry1) > 0)
        {
            $planamount=getRefPlanAmount($db);
            $total_count=$mem_count;
            $bonus_amount=($planamount * $income_perc)/100;
            $amount_col="amount".$r0['id'];
            while($r1=mysqli_fetch_assoc($qry1))
            {
                //var_dump($r1);
                $uid=$r1['uid'];
                $tcount = $r1['sponsor_count'];
                $tt= $r1['count'];
                
                $br1=mysqli_fetch_assoc(mysqli_query($db,"select `$amount_col` from `ref_bonus` WHERE uid='$uid'"));
                $ebamount=$br1[$amount_col];
                //echo "$ebamount<$capping------$uid";
                if($ebamount<$capping)
                {
                    if($bonus_amount > $capping)
                    {
                        $total_amount = $capping;
                    }
                    else
                    {
                        $total_amount = $bonus_amount;
                    }
                    
                    $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
                    if($isPLanRB==1)
                    {
                        //echo "\n<br>plan amount ".$planamount."_____prcentage ".$income_perc."____";
                        /*if($total_amount >0)
                        {
                         */   $qry2= mysqli_fetch_assoc(mysqli_query($db,"SELECT * from refpayout where uid='$uid' and total_count='$total_count' and status=1"));
                            if($qry2)
                            {
                               //echo "\n UPDATE `refpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', direct_count= '$direct_count',status=1, perc='$income_perc', updated='$date' where uid='$uid' and total_count='$total_count'";
                                $q1 = mysqli_query($db,"UPDATE `refpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', direct_count= '$direct_count',status=1, perc='$income_perc', updated='$date' where uid='$uid' and total_count='$total_count'");
                            }
                            else
                            {
                              //echo "\n INSERT INTO `refpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', total_count='$total_count', direct_count= '$direct_count',uid ='$uid',status=1, perc='$income_perc',created='$date'";
                                $q1 = mysqli_query($db,"INSERT INTO `refpayout` SET bonus_amount='$bonus_amount', total_amount= '$total_amount', total_count='$total_count', direct_count= '$direct_count',uid ='$uid',status=1, perc='$income_perc',created='$date'") or die(mysqli_error($db));
                            }
                            if($q1)
                            {
                                $c[] = 1;
                            }
                            else
                            {
                                $c[] = 0;
                            }
                        /*}
                        else
                        {
                            $c[] = 0;
                        }*/
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
             if(in_array(1,$c))
            {
                $ch[] = 1;
            }
            else if(!in_array(1,$c))
            {
                $ch[] = 0;
            }
            else 
            {
                $ch[] = 0;
            }
        }
    }
    return $ch;
}
function GenerateRefPayout2($db)
{
    global $crdate;
    $amount=$amount1=$tot_amount=0;
    $date=date("Y-m-d H:i:s");
    $smsid=array();
    
    $nuser=getRefNUser($db);
    $planamount=getRefPlanAmount($db);
    $tot_amount=$nuser * $planamount;
     $q1 = mysqli_query($db,"UPDATE `total_user` SET `ref_date` = '$crdate' WHERE `id` = 1");  
    
    $sql=mysqli_query($db,"select * from referel_bonus_detail order by id");
    while($r0=mysqli_fetch_assoc($sql))
    {    
        $perc=$r0['income_perc'];
        $mem_count=$r0['mem_count'];
        $capping=$r0['capping'];
        $amount_col="amount".$r0['id'];
        //echo "\n <br><br><br> user_".$nuser."_____prcentage__".$perc." _________tot_amount__".$tot_amount."_______planamount__".$planamount;
        //echo "select * from `refpayout` where status=2 and perc='$perc'";
        //$q1=mysqli_query($db,"select * from `refpayout` where status=2 and perc='$perc'");
        $q1=mysqli_query($db,"select * from `refpayout` where status=2 and total_count='$mem_count'");
        $q29=mysqli_query($db,"select DISTINCT uid from `refpayout` where status=2 and total_count='$mem_count'");
        $euser=mysqli_num_rows($q29);
        if($euser > 0)
        { 
            //echo $euser;
            $amount1=($tot_amount * $perc)/100;
            $amount=$amount1 / $euser;
            
                //echo "\n <br> user_".$euser."_____prcentage__".$perc."_________tot_amount__".$tot_amount."_______amount__".$amount;
                while($r1=mysqli_fetch_assoc($q1))
                {
                    $uid=$r1['uid'];
                    $direct_count=$r1['direct_count'];
                    $q5=mysqli_fetch_assoc(mysqli_query($db,"select `$amount_col` from `ref_bonus` WHERE uid='$uid'"));
                    $ebamount=$q5[$amount_col];
                    $chkamount=$ebamount+$amount;
                    if($chkamount >= $capping)
                    {
                        $amountb=$capping-$ebamount;
                        $chkamount=$capping;
                    }
                    else{
                        $amountb=$amount;
                    }
                    //echo "\n <br> user_id____".$uid."______ user_".$euser."_____prcentage__".$perc."_________tot_amount__".$tot_amount."_______amount__".$amount."_______chkamount____".$chkamount."_______amountb____".$amountb;
                    
                    $chk_qry=mysqli_num_rows(mysqli_query($db,"SELECT `uid` FROM `pairing` WHERE `parent_id`=$uid"));
                    //echo "$chk_qry >= $direct_count";
                    $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
                    if($chk_qry >= $direct_count && $isPLanRB==1)
                    {
                        $bqry3=mysqli_query($db,"select id,uid,ref_amount from `payout` WHERE uid='$uid' and cleared=0");
                        $qq_no=mysqli_num_rows($bqry3);
                        if($qq_no > 0)
                        {      
                            $brow=mysqli_fetch_assoc($bqry3);
                            //var_dump($brow);
                            $b_amount=$amountb+$brow['b_amount'];
                            $pid=$brow['id'];
                            //echo "\n <br><br> UPDATE `payout` SET `ref_amount`= $b_amount WHERE uid='$uid' and id='$pid'";                          
                            $q2=mysqli_query($db,"UPDATE `payout` SET `ref_amount`= $b_amount WHERE uid='$uid' and id='$pid'");
                        }
                        else
                        {
                            //echo "\n <br><br> INSERT INTO `payout` SET `uid`= $uid,`ref_amount`= $amountb,`date`='$date'";
                            $q2=mysqli_query($db,"INSERT INTO `payout` SET `uid`= $uid,`ref_amount`= $amountb,`date`='$date'");
                            // or die(mysqli_error($db))
                        }
                        if($q2)
                        {                              
                            $q6=mysqli_query($db,"UPDATE `ref_bonus` SET `$amount_col`= $chkamount WHERE uid='$uid'");
                            //echo "INSERT INTO `ref_history` SET  `uid`= $uid,`b_amount`= $amountb,total_count='$mem_count',perc='$perc',`date`='$date' ";
                            $q7=mysqli_query($db,"INSERT INTO `ref_history` SET  `uid`= $uid,`b_amount`= $amountb,total_count='$mem_count',perc='$perc',`date`='$date' ") or die(mysqli_error($db));
                            $smsid[]=$uid;
                            //$msg=getRoyaltyPayoutDetail($db,$uid);
                            $c[] = 1;
                        }
                        else
                        {
                            $c[] = 0;
                        }
                    }
                    else
                    {
                        $c[] = 2;
                    }
                    
                }
                
            
        }
        else
        {
            $c[] = 2;
        }
       //echo "\n <br> UPDATE `refpayout` SET `status`=0,`updated='$date' where status=3 and total_count='$mem_count'";
        $q3=mysqli_query($db,"UPDATE `refpayout` SET status=0,updated='$date' where status=2 and total_count='$mem_count'");
    }
    
    $smsid=array_unique($smsid);

    /*echo "<br>After Uniqe_______________________________________________";
    var_dump($smsid);*/
    if(isset($smsid) && count($smsid) > 0)
    {
        foreach ($smsid as $key => $smsuid) {
            $msg=getReferalPayoutDetail($db,$smsuid);
        }
    }
    return $c;
}
/********************************** Royalty Payout ******************************/
function getNoChildu5($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$parent_id' and t3.plan_amount!=0");
    $no=mysqli_num_rows($q1);
    if($no >= 5)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $uids[]=$uid;
        }
    }
    return $uids;
}
function getNoChildu25($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$parent_id' and t3.plan_amount!=0");
    $no=mysqli_num_rows($q1);
    if($no >= 5)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $q2 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid' and t3.plan_amount!=0");
            if(mysqli_num_rows($q2)>5)
            {
                while ($r2 = mysqli_fetch_assoc($q1)){
                    $uid1=$r2['uid'];
                    $uids[]=$uid1;
                }
            }
            if(isset($uids) && count($uids) >= 5)
            {
                $uids[]=$uid;
            }
        }
    }
    return $uids;
}
function getNoChildu125($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$parent_id' and t3.plan_amount!=0");
    $no=mysqli_num_rows($q1);
    if($no >= 5)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $q2 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid' and t3.plan_amount!=0");
            if(mysqli_num_rows($q2)>5)
            {
                while ($r2 = mysqli_fetch_assoc($q1)){
                    $uid1=$r2['uid'];
                    $q2 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid1' and t3.plan_amount!=0");
                    if(mysqli_num_rows($q2)>5)
                    {
                        while ($r3 = mysqli_fetch_assoc($q1)){
                            $uids[]=$r3['uid'];
                        }
                    }
                    if(isset($uids) && count($uids) >= 5)
                    {
                        $uids[]=$uid1;
                    }
                }
            }
            if(isset($uids) && count($uids) >= 25)
            {
                $uids[]=$uid;
            }
        }
    }
    return $uids;
}
function getNoChildu625($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$parent_id' and t3.plan_amount!=0");
    $no=mysqli_num_rows($q1);
    if($no >= 5)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $q2 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid' and t3.plan_amount!=0");
            if(mysqli_num_rows($q2)>5)
            {
                while ($r2 = mysqli_fetch_assoc($q2)){
                    $uid1=$r2['uid'];
                    $q3 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid1' and t3.plan_amount!=0");
                    if(mysqli_num_rows($q3)>5)
                    {
                        while ($r3 = mysqli_fetch_assoc($q3)){
                                $uid2=$r2['uid'];
                                $q4 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid2' and t3.plan_amount!=0");
                                if(mysqli_num_rows($q4)>5)
                                {
                                    while ($r4 = mysqli_fetch_assoc($q4)){
                                        $uids[]=$r4['uid'];
                                    }
                                }
                                if(isset($uids) && count($uids) >= 5)
                                {
                                    $uids[]=$uid2;
                                }
                        }
                    }
                    if(isset($uids) && count($uids) >= 25)
                    {
                        $uids[]=$uid1;
                    }
                }
            }
            if(isset($uids) && count($uids) > 125)
            {
                $uids[]=$uid;
            }
        }
    }
    return $uids;
}
function getNoChildu3125($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$parent_id' and t3.plan_amount!=0");
    $no=mysqli_num_rows($q1);
    if($no >= 5)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $q2 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid' and t3.plan_amount!=0");
            if(mysqli_num_rows($q2)>5)
            {
                while ($r2 = mysqli_fetch_assoc($q2)){
                    $uid1=$r2['uid'];
                    $q3 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid1' and t3.plan_amount!=0");
                    if(mysqli_num_rows($q3)>5)
                    {
                        while ($r3 = mysqli_fetch_assoc($q3)){
                            $uid2=$r2['uid'];
                            $q4 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid2' and t3.plan_amount!=0");
                            if(mysqli_num_rows($q4)>5)
                            {
                                while ($r4 = mysqli_fetch_assoc($q4)){
                                        $uid3=$r4['uid'];
                                        $q5 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid3' and t3.plan_amount!=0");
                                        if(mysqli_num_rows($q5)>5)
                                        {
                                            while ($r5 = mysqli_fetch_assoc($q5)){
                                                $uids[]=$r5['uid'];
                                            }
                                        }
                                        if(isset($uids) && count($uids) >= 5)
                                        {
                                            $uids[]=$uid3;
                                        }
                                }
                            }
                            if(isset($uids) && count($uids) >= 25)
                            {
                                $uids[]=$uid2;
                            }
                        }
                    }
                    if(isset($uids) && count($uids) >= 125)
                    {
                        $uids[]=$uid1;
                    }
                }
            }
            if(isset($uids) && count($uids) >= 625)
            {
                $uids[]=$uid;
            }
        }
    }
    return $uids;
}
function getNoChildu15625($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$parent_id' and t3.plan_amount!=0");
    $no=mysqli_num_rows($q1);
    if($no >= 5)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $q2 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid' and t3.plan_amount!=0");
            if(mysqli_num_rows($q2)>5)
            {
                while ($r2 = mysqli_fetch_assoc($q2)){
                    $uid1=$r2['uid'];
                    $q3 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid1' and t3.plan_amount!=0");
                    if(mysqli_num_rows($q3)>5)
                    {
                        while ($r3 = mysqli_fetch_assoc($q3)){
                            $uid2=$r2['uid'];
                            $q4 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid2' and t3.plan_amount!=0");
                            if(mysqli_num_rows($q4)>5)
                            {
                                while ($r4 = mysqli_fetch_assoc($q4)){
                                    $uid3=$r4['uid'];
                                    $q5 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid3' and t3.plan_amount!=0");
                                    if(mysqli_num_rows($q5)>5)
                                    {
                                        while ($r5 = mysqli_fetch_assoc($q5)){
                                                $uid4=$r5['uid'];
                                                $q6 = mysqli_query($db,"select t1.*,IFNULL(t3.plan_amount,0) from pairing t1 left join transpin t2 on t1.uid=t2.uid left join plans t3 on t2.plan_id = t3.plan_id  where t1.parent_id = '$uid4' and t3.plan_amount!=0");
                                                if(mysqli_num_rows($q6)>5)
                                                {
                                                    while ($r6 = mysqli_fetch_assoc($q6)){
                                                        $uids[]=$r6['uid'];
                                                    }
                                                }
                                                if(isset($uids) && count($uids) >= 5)
                                                {
                                                    $uids[]=$uid4;
                                                }
                                        }
                                    }
                                    if(isset($uids) && count($uids) >= 25)
                                    {
                                        $uids[]=$uid3;
                                    }
                                }
                            }
                            if(isset($uids) && count($uids) >= 125)
                            {
                                $uids[]=$uid2;
                            }
                        }
                    }
                    if(isset($uids) && count($uids) >= 625)
                    {
                        $uids[]=$uid1;
                    }
                }
            }
            if(isset($uids) && count($uids) >= 3125)
            {
                $uids[]=$uid;
            }
        }
    }
    return $uids;
}
function getNoChild5($db,$parent_id)
{
    $q1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT `count` FROM `child_counter` where uid = '$parent_id'"));
    $norec=$q1['count'];
    if($norec >=5)
    {
       return true;
    }
    else
    {
        return false;
    }
}
function getNoChild25($db,$parent_id)
{
    $is_ch=array();
    $res=getNoChild5($db,$parent_id);
    //echo "<br>\n 5 Childs______".var_dump($res);
    if($res)
    {
        //echo "<br> \n"."select * from pairing where parent_id = '$parent_id'";
        $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
        if(mysqli_num_rows($q1)>0)
        {
            while ($r1 = mysqli_fetch_assoc($q1)){
                $uid=$r1['uid'];
                $res1=getNoChild5($db,$uid);
                if($res1)
                {
                    $is_ch[]=$res1;
                }
            }
        }
        //var_dump($is_ch);
        if(isset($is_ch) && count($is_ch) >= 5)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function getNoChild125($db,$parent_id)
{
    $is_ch=array();
    $res=getNoChild5($db,$parent_id);
    if($res)
    {
        //echo "select * from pairing where parent_id = '$parent_id'";
        $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
        if(mysqli_num_rows($q1)>0)
        {
            while ($r1 = mysqli_fetch_assoc($q1)){
                $uid=$r1['uid'];
                $res1=getNoChild25($db,$uid);
                if($res1)
                {
                    //echo "<br> \n"."select * from pairing where parent_id = '$uid'";
                    $q2 = mysqli_query($db,"select * from pairing where parent_id = '$uid'");
                    if(mysqli_num_rows($q2)>0)
                    {
                        while ($r2 = mysqli_fetch_assoc($q2)){
                            $uid2=$r2['uid'];
                            $res2=getNoChild25($db,$uid2);
                            //var_dump($res2);
                            if($res2)
                            {
                                $is_ch2[]=$res2;
                            }
                        }
                    }
                    //echo "<pre>";var_dump($is_ch2);
                    if(isset($is_ch2) && count($is_ch2) >= 5)
                    {
                        $is_ch[]=true;
                    }
                }
            }
        }
        //echo "<pre>";var_dump($is_ch);
        if(isset($is_ch) && count($is_ch) >= 5)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function IsManagerPayout($db,$parent_id)
{
    $res1=getNoChild125($db,$parent_id);
    if($res1)
    {
        $is_ch[]=$res1;
    }
    if(isset($is_ch) && count($is_ch) > 0)
    {
        return true;
    }
    else 
    {
        return false;
    }
}
function IsManagerPayout1($db,$parent_id)
{
    $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
    if(mysqli_num_rows($q1)>0)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $res1=getNoChild125($db,$uid);
            if($res1)
            {
                $is_ch[]=$res1;
            }
        }
        if(isset($is_ch) && count($is_ch) > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function IsAreaManagerPayout($db,$parent_id,$uids1)
{
    if(count($uids1)>0)
    {
        foreach ($uids1 as $key => $uid) {
            $res1=IsManagerPayout($db,$uid);
            if($res1)
            {
                $is_ch[]=$res1;
            }
        }
        if(isset($is_ch) && count($is_ch) > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function IsDistrictManagerPayout($db,$parent_id)
{
    $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
    if(mysqli_num_rows($q1)>0)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $res1=IsAreaManagerPayout($db,$uid);
            if($res1)
            {
                $is_ch[]=$res1;
            }
        }
        if(isset($is_ch) && count($is_ch) > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function IsResionalManagerPayout($db,$parent_id)
{
    $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
    if(mysqli_num_rows($q1)>0)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $res1=IsAreaManagerPayout($db,$uid);
            if($res1)
            {
                $is_ch[]=$res1;
            }
        }
        if(isset($is_ch) && count($is_ch) > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function IsDivisionalManagerPayout($db,$parent_id)
{
    $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
    if(mysqli_num_rows($q1)>0)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $res1=IsResionalManagerPayout($db,$uid);
            if($res1)
            {
                $is_ch[]=$res1;
            }
        }
        if(isset($is_ch) && count($is_ch) > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function getNoChild1551($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
    if(mysqli_num_rows($q1)>5)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $q2 = mysqli_query($db,"select * from pairing where parent_id = '$uid'");
            if(mysqli_num_rows($q2)>5)
            {
                while ($r2 = mysqli_fetch_assoc($q1)){
                    $uid1=$r2['uid'];
                    $q2 = mysqli_query($db,"select * from pairing where parent_id = '$uid1'");
                    if(mysqli_num_rows($q2)>5)
                    {
                        while ($r3 = mysqli_fetch_assoc($q1)){
                            $uids[]=$r3['uid'];
                        }
                    }
                    if(isset($uids) && count($uids) > 125)
                    {
                        $uids[]=$uid1;
                    }
                }
            }
            if(isset($uids) && count($uids) > 150)
            {
                $uids[]=$uid;
            }
        }
    }
    return $uids;
}
function getNoChild155($db,$parent_id)
{
    $uids=array();
    $q1 = mysqli_query($db,"select * from pairing where parent_id = '$parent_id'");
    if(mysqli_num_rows($q1)>2)
    {
        while ($r1 = mysqli_fetch_assoc($q1)){
            $uid=$r1['uid'];
            $q2 = mysqli_query($db,"select * from pairing where parent_id = '$uid'");
            if(mysqli_num_rows($q2)>2)
            {
                while ($r2 = mysqli_fetch_assoc($q1)){
                    $uid1=$r2['uid'];
                    $q2 = mysqli_query($db,"select * from pairing where parent_id = '$uid1'");
                    if(mysqli_num_rows($q2)>2)
                    {
                        while ($r3 = mysqli_fetch_assoc($q1)){
                            $uids[]=$r3['uid'];
                        }
                    }
                    if(isset($uids) && count($uids) > 8)
                    {
                        $uids[]=$uid1;
                    }
                }
            }
            if(isset($uids) && count($uids) > 12)
            {
                $uids[]=$uid;
            }
        }
    }
    return $uids;
}
function RoyaltyUser($db)
{
    global $crdate;
    $uq=mysqli_query($db,"select t1.uid from user_id t1 join transpin t2 on t1.uid=t2.uid join plans t3 on t2.plan_id = t3.plan_id where t3.plan_amount!=0 and t1.status =1");
    while($row=mysqli_fetch_assoc($uq))
    {
        $uid=$row['uid'];
        //5 condition
        $res5=getNoChildu5($db,$uid);
        //echo "<pre>";var_dump($res5);
        if($res5)
        {
            $uids=implode(',', $res5);
            $sql1="INSERT INTO `royalty_user` SET `uid`='$uid',`type`= 1,`uids`='$uids',`date`= '$crdate'";
            $q1=mysqli_query($db,$sql1);
        }
        //25 condition
        $res25=getNoChildu25($db,$uid);
        //echo "<pre>";var_dump($res25);
        if($res25)
        {
            $uids1=implode(',', $res25);
            $sql2="INSERT INTO `royalty_user` SET `uid`='$uid',`type`= 2,`uids`='$uids1',`date`= '$crdate'";
            $q2=mysqli_query($db,$sql2);
        }
         //125 condition
        $res125=getNoChildu125($db,$uid);
        //echo "<pre>";var_dump($res125);
        if($res125)
        {
            $uids2=implode(',', $res125);
            $sql3="INSERT INTO `royalty_user` SET `uid`='$uid',`type`= 3,`uids`='$uids2',`date`= '$crdate'";
            $q3=mysqli_query($db,$sql3);
        }
         //625 condition
        $res625=getNoChildu625($db,$uid);
        //echo "<pre>";var_dump($res625);
        if($res625)
        {
            $uids3=implode(',', $res625);
            $sql4="INSERT INTO `royalty_user` SET `uid`='$uid',`type`= 4,`uids`='$uids3',`date`= '$crdate'";
            $q3=mysqli_query($db,$sql4);
        }
         //3125 condition
        $res3125=getNoChildu3125($db,$uid);
        //echo "<pre>";var_dump($res3125);
        if($res3125)
        {
            $uids4=implode(',', $res3125);
            $sql5="INSERT INTO `royalty_user` SET `uid`='$uid',`type`= 5,`uids`='$uids4',`date`= '$crdate'";
            $q3=mysqli_query($db,$sql5);
        }
         //15625 condition
        $res15625=getNoChildu3125($db,$uid);
        //echo "<pre>";var_dump($res15625);
        if($res15625)
        {
            $uids6=implode(',', $res15625);
            $sql6="INSERT INTO `royalty_user` SET `uid`='$uid',`type`= 5,`uids`='$uids6',`date`= '$crdate'";
            $q3=mysqli_query($db,$sql6);
        }
    }
}
function RoyaltyPayoutUser($db)
{
    global $crdate;
    $uq=mysqli_query($db,"select uid from user_id where status =1");
    while($urow=mysqli_fetch_assoc($uq))
    {
        $uid=$urow['uid'];
        $sql="select * from royalty_user where uid=$uid and status=0";
        $q1=mysqli_query($db,$sql);
        if(mysqli_num_rows($q1) > 0)
        {
            while($row=mysqli_fetch_assoc($q1))
            {
                extract($row);
                //echo "<br>\n SELECT * FROM `royalty_detail` where rid = $type";
                $q2=mysqli_query($db,"SELECT * FROM `royalty_detail` where rid = $type");
                while($r1=mysqli_fetch_assoc($q2))
                {
                    $rid=$r1['rid'];
                    $amount=$r1['amount'];
                    $direct=$r1['direct_count'];
                    $payout_days = '-6 day';
                    $datetime = new DateTime('today');
                    $datetime->modify($payout_days);
                    $planday = $datetime->format('Y-m-d');
                        $chk = mysqli_query($db,"Select amount from royalty where `uid` = $uid");
                        if(mysqli_num_rows($chk) > 0)
                        {
                            $ex_r1=mysqli_fetch_assoc($chk);
                            $amount1=$ex_r1['amount']+$amount;
                            $sql1="UPDATE `royalty` SET `amount`=$amount1,`rid`=$rid,`status`=0,`updated`= '$crdate' where `uid` = $uid";
                            $q3=mysqli_query($db,$sql1);
                        }
                        else
                        {
                            $sql1="INSERT INTO `royalty` SET `uid`=$uid,`amount`=$amount,`rid`=$rid,`status`=0,`created`='$crdate'";
                            $q3=mysqli_query($db,$sql1);
                        }
                }
            }
        }
       $q11=mysqli_query($db,"update royalty_user set status=1 where uid=$uid");
    }
}
function GenerateRoyaltyPayout($db)
{
    global $crdate;
    $sql=mysqli_query($db,"select * from royalty");
    if(mysqli_num_rows($sql) > 0)
    {
        while ($r1=mysqli_fetch_assoc($sql))
        {
            $uid=$r1['uid'];
            $amount=$r1['amount'];
            $sql1=mysqli_query($db,"Select uid,r_amount from `payout` WHERE uid='$uid' and cleared=0");
            if(mysqli_num_rows($sql1) > 0)
            {
                $r2=mysqli_fetch_assoc($sql1);
                $amount=$r2['r_amount']+$amount;
                //echo "UPDATE `payout` SET `r_amount`= $amount WHERE uid='$uid' and cleared=0";
                $q2=mysqli_query($db,"UPDATE `payout` SET `r_amount`= $amount WHERE uid='$uid' and cleared=0");
            }
            else
            {
                //echo "INSERT INTO `payout` SET uid='$uid',`r_amount`= $amount";
                $q2=mysqli_query($db,"INSERT INTO `payout` SET uid='$uid',`r_amount`= $amount,`date`='$crdate'");
            }
            if($q2)
            {
                //reward_payment($db,$uid,$amount);
                $msg=getPayoutDetail($db,$uid);
                if(isset($msg) && $msg!='' && !empty($msg))
                {
                   sendSMS($db,$uid,$msg); 
                }
                $c[] = 1;
                $q3=mysqli_query($db,"UPDATE `royalty` SET `amount`= 0,`rid`=0 WHERE uid='$uid'");
            }
            else
            {
                $c[] = 0;
            }
        }
    }
    else
    {
        $c[] = 2;
    }
    return $c;
}
/******************************************* Downline ****************************************/
function getParentIds($db,$uid,$mlmid)
{
    $r1=mysqli_fetch_assoc(mysqli_query($db,"select parent_id from pairing where uid = '$uid'"));
    $pid=$r1['parent_id'];
    $r2=mysqli_fetch_assoc(mysqli_query($db,"select parent_id from pairing where uid = '$pid'"));
    $parent_id=$r1['parent_id'];
    if(isset($parent_id) && !empty($parent_id))
    {
        return $parent_id;
    }
    else
    {
        return $mlmid;
    }
}
function GetpairedNo($db,$uid,$mpair)
{
    //echo "select paired from user_id where uid=$uid";
    $r1=mysqli_fetch_assoc(mysqli_query($db,"select paired from user_id where uid=$uid"));
    $paired=$r1['paired'];
    if(isset($paired) && !empty($paired) && $paired >= $mpair)
    {
        return $paired;
    }
    else
    {
        return $mpair;
    }
}
function getChildIds($db,$paired,$parent_id)
{
    $user_ids=array();
    $qry1=mysqli_query($db,"select * from user_id where paired=$paired");
    while ($r1=mysqli_fetch_assoc($qry1))
    {
        $user_ids[]=$r1['uid'];
    }
    $uids=implode(',', $user_ids);
    $sql="SELECT t1.*,t2.* from pairing t1 join user_id t2 on t1.uid=t2.uid where t1.parent_id=$parent_id and t1.uid in ($uids)";
    $qry2=mysqli_query($db,"select * from pairing where parent_id=$parent_id and uid in ($uids)");
}
function GetUids($db,$uid)
{
    $uids=array();
    //echo "\n select * from pairing where parent_id = '$uid'";
    $q1 = mysqli_query($db,"select * from pairing where parent_id = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        while ($q4 = mysqli_fetch_assoc($q1)){
            $uid=$q4['uid'];
            $uids[]= $uid;
        }
        return $uids;
    }
    else
    {  
         return $uids;
    }
}
function getLevel2($db,$res)
{
    $res2=array();
    //echo "<pre>";print_r($res);
    foreach ($res as $key => $value) {
        $res1=GetUids($db,$value);
        if(count($res1) > 0)
        {
            $res2=array_merge($res2,$res1);
        }
    }
    return $res2;
}
function getLevel3($db,$res_arr)
{
    $res3=array();
    $res1=getLevel2($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        // print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel4($db,$res_arr)
{
    $res3=array();
    $res1=getLevel3($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel5($db,$res_arr)
{
    $res3=array();
    $res1=getLevel4($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel6($db,$res_arr)
{
    $res3=array();
    $res1=getLevel5($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel7($db,$res_arr)
{
    $res3=array();
    $res1=getLevel6($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel8($db,$res_arr)
{
    $res3=array();
    $res1=getLevel7($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel9($db,$res_arr)
{
    $res3=array();
    $res1=getLevel8($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel10($db,$res_arr)
{
    $res3=array();
    $res1=getLevel9($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel11($db,$res_arr)
{
    $res3=array();
    $res1=getLevel10($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel12($db,$res_arr)
{
    $res3=array();
    $res1=getLevel11($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel13($db,$res_arr)
{
    $res3=array();
    $res1=getLevel12($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel14($db,$res_arr)
{
    $res3=array();
    $res1=getLevel13($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function getLevel15($db,$res_arr)
{
    $res3=array();
    $res1=getLevel14($db,$res_arr);
    //echo "<pre>";print_r($res1);
    foreach($res1 as $key => $value)
    { 
        $res2=GetUids($db,$value);
        //print_r($res2);
        if(count($res2) > 0 && !empty($res2[0]))
        {
            $res3=array_merge($res2,$res3);
            //echo "<pre>";print_r($res3);
        }
    }
    return array_unique($res3);
}
function GetUsersID($db,$level,$mlmid)
{
    $res1=GetUids($db,$mlmid);
    if($level==1)
    {
        $res=$res1;
    }
    if($level==2)
    {
        $res=getLevel2($db,$res1);
    }
    if($level==3)
    {
        $res=getLevel3($db,$res1);
    }
    if($level==4)
    {
        $res=getLevel4($db,$res1);
    }
    if($level==5)
    {
        $res=getLevel5($db,$res1);
    }
    if($level==6)
    {
        $res=getLevel6($db,$res1);
    }
    if($level==7)
    {
        $res=getLevel7($db,$res1);
    }
    if($level==8)
    {
        $res=getLevel8($db,$res1);
    }
    if($level==9)
    {
        $res=getLevel9($db,$res1);
    }
    if($level==10)
    {
        $res=getLevel10($db,$res1);
    }
    if($level==11)
    {
        $res=getLevel11($db,$res1);
    }
    if($level==12)
    {
        $res=getLevel12($db,$res1);
    }
    if($level==13)
    {
        $res=getLevel13($db,$res1);
    }
    if($level==14)
    {
        $res=getLevel14($db,$res1);
    }
    if($level==15)
    {
        $res=getLevel15($db,$res1);
    }
    return $res;
}
function unpaid_child_count( $db, $id)
{
    $q = mysqli_fetch_assoc( mysqli_query( $db , "SELECT t1.*,t2.count FROM pairing t1 join child_counter t2 on t1.uid=t2.uid WHERE t1.parent_id = $id ") );
    $count = $q['count'];
    return $count ;
}
function checkIsValidChild($db,$sid,$cid)
{
    $sql ="SELECT `parent_id` FROM `pairing` WHERE `uid` = '$cid'";
    $q1 = mysqli_query($db,$sql);
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        $parent_id = $r1['parent_id'];
        //echo $parent_id."<br>";
        if($sid == $parent_id)
        {
            return true;
        }
        else if($parent_id == 1)
        {
            return false;
        }
        else
        {
            $cid = $parent_id;
            return checkIsValidChild($db,$sid,$cid);
        }
    }
    else
    {
        return false;
    }
}
/*************************************** Awards/Rewards *********************************/
//insert reward payment
function reward_payment($db,$uid,$amount)
{
    $date1=date("Y-m-d H:i");
    $q1 = mysqli_query($db,"SELECT * FROM `reward_payout` where uid = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1=mysqli_fetch_assoc($q1);
        //var_dump($r1);
        $amount1=$r1['amount'];
        $amount1 += $amount;
        //echo "UPDATE `reward_payout` SET amount='$amount1',updated='$date1' where uid = '$uid'";
        $q2 = mysqli_query($db,"UPDATE `reward_payout` SET amount='$amount1',updated='$date1' where uid = '$uid'");
    }
    else
    {
        //echo "INSERT INTO `reward_payout` SET amount='$amount',uid = '$uid',created='$date1'";
        $q2 = mysqli_query($db,"INSERT INTO `reward_payout` SET amount='$amount',uid = '$uid',created='$date1'");
    }
    return true;
}
function insert_reward($db)
{
    global $crdate;
    $reward_list=array();
    $qry2=mysqli_query($db,"select * from rewards_plans order by ramount");
    while($r1=mysqli_fetch_assoc($qry2))
    {
        //$reward_list[]=array($r1['amount'],$r1['id']);
        array_push($reward_list,array($r1['amount'],$r1['id']));
    }
    if(count($reward_list)>0)
    {
        usort($reward_list, function($a, $b) {
            return $a[0] - $b[0];
        });
        //echo "<pre>"; print_r($reward_list); die();
        $min_amount = $reward_list[0][0];
        $date1=date("Y-m-d H:i");
        echo "SELECT * FROM `reward_payout` where amount >= $min_amount";
        $q1 = mysqli_query($db,"SELECT * FROM `reward_payout` where amount >= $min_amount");
        $no=mysqli_num_rows($q1);
        if($no>0)
        {
            while($r1=mysqli_fetch_assoc($q1))
            {
                $amount = $r1['amount'];
                $uid = $r1['uid'];
                $q21 = mysqli_query($db,"SELECT * FROM `reward` where uid='$uid'");
                $no1=mysqli_num_rows($q21);
                $reward = '';
                $payment = $ramount = 0;
                //echo"<pre>"; var_dump($reward_list[$no1]);
                if(isset($reward_list[$no1]))
                {
                    if ($amount >= $reward_list[$no1][0]) {
                        $reward = $reward_list[$no1][1];
                        $ramount = $reward_list[$no1][0];
                        $payment = $amount - $reward_list[$no1][0];
                    }
                }
                if(!empty($reward)) {
                    echo $sql= "INSERT INTO `reward` SET amount='$ramount',uid = '$uid',reward = '$reward',date='$crdate'";
                    $q3 = mysqli_query($db, $sql);
                    if($q3)
                    {
                        $q2 = mysqli_query($db,"UPDATE `reward_payout` SET amount='$payment',updated='$date1' where uid = '$uid'");
                    }
                }
            }
        }
        else
        {
            echo "No Reward";
        }
    }
    return true;
}
function clear_allreward($db)
{
    $date = date('Y-m-d G:i:s');
    $q3 = mysqli_query($db,"UPDATE `reward` SET `status`= 1,`cleared_date`= '$date' ");
    if($q3)
    {
        return true;
    }
    else
    {
        return "Some reward did not clear";
    }
}
function clear_reward($db,$id)
{
    $date = date('Y-m-d G:i:s');
    $sql1="UPDATE `reward` SET `status`= 1,`cleared_date`= '$date' where id='$id' ";
    $q3 = mysqli_query($db,$sql1);
    if($q3)
    {
        return true;
    }
    else
    {
        return "Some reward did not clear";
    }
}
/******************************************** Re Purchase**************************************/
function Get2Parents($db,$uid)
{
    $uids=array();
    $uids[]=$uid;
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT `parent_id` FROM `pairing` where uid='$uid'"));
    $uids[]=$r1['parent_id'];
    $r2=mysqli_fetch_assoc(mysqli_query($db,"SELECT `parent_id` FROM `pairing` where uid=".$r1['parent_id']));
    $uids[]=$r2['parent_id'];
    return $uids;
}
function RepurchaseDownline($db,$uid)
{
    $psql=mysqli_query($db,"SELECT t1.*,t2.level_perc FROM `purchase` t1 left join rplans t2 on t1.plan_id=t2.plan_id where t1.uid='$uid' order by t1.date desc");
    $no=mysqli_num_rows($psql);
    if($no > 1)
    {
        $r1=mysqli_fetch_assoc($psql);
        $level_perc=json_decode($r1['level_perc']);
        $plan_id=$r1['plan_id'];
        $users=Get2Parents($db,$uid);
        $i=0;
        foreach ($users as $key => $value) {
            $amount=$level_perc[$i];
            $sql="INSERT INTO purchase_payout set uid='$value',parent_id='$uid',plan_id='$plan_id',amount='$amount'";
            $qry=mysqli_query($db,$sql);
            $i++;
        }
    }
    return true;
}
function RepurchasePayout($db)
{
    global $crdate;
    $sql=mysqli_query($db,"select sum(amount) as amount,uid FROM `purchase_payout` where status=0 group by uid");
    if(mysqli_num_rows($sql) > 0)
    {
        while ($r1=mysqli_fetch_assoc($sql))
        {
            $uid=$r1['uid'];
            $amount=$r1['amount'];
            $sql1=mysqli_query($db,"Select uid,re_amount from `payout` WHERE uid='$uid' and cleared=0");
            if(mysqli_num_rows($sql1) > 0)
            {
                $r2=mysqli_fetch_assoc($sql1);
                $amount=$r2['re_amount']+$amount;
                //echo "UPDATE `payout` SET `re_amount`= '$amount' WHERE uid='$uid' and cleared=0";
                $q2=mysqli_query($db,"UPDATE `payout` SET `re_amount`= '$amount' WHERE uid='$uid' and cleared=0");
            }
            else
            {
                //echo "INSERT INTO `payout` SET uid='$uid',`re_amount`= '$amount'";
                $q2=mysqli_query($db,"INSERT INTO `payout` SET uid='$uid',`re_amount`= '$amount',`date`='$crdate'");
            }
            if($q2)
            {
                //reward_payment($db,$uid,$amount);
                /*$msg=getPayoutDetail($db,$uid);
                if(isset($msg) && $msg!='' && !empty($msg))
                {
                   sendSMS($db,$uid,$msg); 
                }*/
                $c[] = 1;
                $q3=mysqli_query($db,"UPDATE `purchase_payout` SET `status`= 1 WHERE uid='$uid'");
            }
            else
            {
                $c[] = 0;
            }
        }
    }
    else
    {
        $c[] = 2;
    }
    return $c;
}
function CheckTDSApply($db,$uid)
{
    $success=false;
    $sql=mysqli_fetch_assoc(mysqli_query($db,"SELECT (sum(`amount`)+sum(`re_amount`)) as payout FROM `payout` WHERE `uid`='$uid'"));
    if($sql['payout'] >= 15000)
    {
        $success=true;
    }
    return $success;
}
function CheckRePurchase($db,$uid,$amount)
{
    $success=false;
    $sql=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `purchase` WHERE `uid`='$uid' and `amount`='$amount' and `status`=1"));
    if($sql > 0)
    {
        $success=true;
    }
    return $success;
}
// *********************************************** BINARY **********************************
function leftrighcounter($db,$uid){
    $temp=array();
    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE parent_id='".$uid."'");
        if(mysqli_num_rows($query)>0){
            while($row=mysqli_fetch_assoc($query)){
            $childcount=mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(pair_id) as 'total' FROM pairing  WHERE parent_id='".$uid."' ")) or die(mysqli_error($db));
                $total=$childcount['total'];
                if($total>=2){
                        $check=mysqli_query($db,"SELECT * FROM user_id WHERE uid='".$row['uid']."' AND binary_activated='1' ")or die(mysqli_error($db));
                            if($check){
                               $rightcount=$total-2;
                               mysqli_query($db,"UPDATE child_counter SET rightcount=rightcount+'".$rightcount."' WHERE uid='".$uid."'")or die(mysqli_error($db));  
                            }
                        }
                        else{
                           // mysqli_query($db,"UPDATE child_counter SET leftcount='".$total."'");
                                $check=mysqli_query($db,"SELECT * FROM user_id WHERE uid='".$row['uid']."' AND binary_activated='1' ")or die(mysqli_error($db));
                                if($check){
                                mysqli_query($db,"UPDATE child_counter SET leftcount=leftcount+'".$total."' WHERE uid='".$uid."'")or die(mysqli_error($db));  
                                }
                        }
             }
             $uid=$row['uid'];
             leftrighcounter($db,$uid);
        }
}
// *****************    BINARY ACTIVATE USER *****************************
function activatebinary($db,$uid,$plan_binary_count=null){
    if($plan_binary_count == null){
        $plan_binary_count = 1;
    }
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT `parent_id` FROM pairing  WHERE uid='$uid'"));
    $parent_id=$r1['parent_id'];
     /*$r2=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$parent_id'"));
    echo "SELECT * FROM pairing  WHERE uid='$parent_id'";*/

    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);
        $uid=$row['uid'];
        //echo "rank : ".$row['position'];
        //$isPLanRB=IsPlanRoyaltyBinary($db,$parent_id);
        
            if($row['position']=="L")
            {
                 // echo "UPDATE child_counter SET leftcount=leftcount+$plan_binary_count WHERE uid='$parent_id'";
                    mysqli_query($db,"UPDATE child_counter SET leftcount=leftcount+$plan_binary_count WHERE uid='$parent_id'");
                    mysqli_query($db,"UPDATE child_counter SET total_left_count=total_left_count+1 WHERE uid='$parent_id'");
            }
            else if($row['position']=="R")
            {
                //  echo "UPDATE child_counter SET rightcount=rightcount+$plan_binary_count WHERE uid='$parent_id'";
                    mysqli_query($db,"UPDATE child_counter SET rightcount=rightcount+$plan_binary_count WHERE uid='$parent_id'");
                    mysqli_query($db,"UPDATE child_counter SET total_right_count=total_right_count+1 WHERE uid='$parent_id'");
            }
        if($parent_id==1)
        {}else{
             //$childid=$row['parent_id'];
             activatebinary($db,$parent_id,$plan_binary_count);
         }
    }
    return true;
}
// ***********************************   INSERT LEFT RIGHT IN PAIRING ***********************
function PVCount($db,$uid,$pv = null){
    
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT `sponsor_id` FROM pairing  WHERE uid='$uid'"));
    //print_r($r1);
    //die();
    $parent_id=isset($r1['sponsor_id']);
    
    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);
        if($row['position']=="L")
        {
            mysqli_query($db,"UPDATE child_counter SET left_pv=left_pv+$pv,rleft_pv=rleft_pv+$pv WHERE uid='$parent_id'");
        }
        else if($row['position']=="R")
        {
            mysqli_query($db,"UPDATE child_counter SET right_pv=right_pv+$pv,rright_pv=rright_pv+$pv WHERE uid='$parent_id'");
        }
        if($parent_id==1)
        {

        }else{
             //$childid=$row['parent_id'];
             PVCount($db,$parent_id,$pv);
         }
    }
    return true;
}

function PVCount_parent($db,$uid,$pv = null){
    
  $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'"));
    $parent_id=$r1['parent_id'];    
    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);
        if($row['position']=="L")
        {
            mysqli_query($db,"UPDATE child_counter SET left_pv=left_pv+$pv,rleft_pv=rleft_pv+$pv WHERE uid='$parent_id'");
        }
        else if($row['position']=="R")
        {
            mysqli_query($db,"UPDATE child_counter SET right_pv=right_pv+$pv,rright_pv=rright_pv+$pv WHERE uid='$parent_id'");
        }
        if($parent_id==1)
        {

        }else{
             //$childid=$row['parent_id'];
             PVCount_parent($db,$parent_id,$pv);
         }
    }
  return true;
}

function DecreementBVCount_parent($db,$uid,$pv = null){
    
  $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'"));
    $parent_id=$r1['parent_id'];    
    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);
        if($row['position']=="L")
        {
            mysqli_query($db,"UPDATE child_counter SET left_pv=left_pv-$pv,rleft_pv=rleft_pv-$pv WHERE uid='$parent_id'");
        }
        else if($row['position']=="R")
        {
            mysqli_query($db,"UPDATE child_counter SET right_pv=right_pv-$pv,rright_pv=rright_pv-$pv WHERE uid='$parent_id'");
        }
        if($parent_id==1)
        {

        }else{
             //$childid=$row['parent_id'];
             DecreementBVCount_parent($db,$parent_id,$pv);
         }
    }
  return true;
}

function DecreementPVCount($db,$uid,$pv = null){
    
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT `sponsor_id` FROM pairing  WHERE uid='$uid'"));
    $parent_id=$r1['sponsor_id'];
    
    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);
        if($row['position']=="L")
        {
            mysqli_query($db,"UPDATE child_counter SET left_pv=left_pv-$pv,rleft_pv=rleft_pv-$pv WHERE uid='$parent_id'");
        }
        else if($row['position']=="R")
        {
            mysqli_query($db,"UPDATE child_counter SET right_pv=right_pv-$pv,rright_pv=rright_pv-$pv WHERE uid='$parent_id'");
        }
        if($parent_id==1)
        {

        }else{
             //$childid=$row['parent_id'];
             DecreementPVCount($db,$parent_id,$pv);
         }
    }
    return true;
}



function updateLeftRighCounter($db,$parent_id,$uid,$position=null){
    //echo $position; die;
    if(isset($position) && !empty($position))
    {
        //echo "UPDATE pairing SET position ='$position' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ";
         mysqli_query($db,"UPDATE pairing SET position ='$position' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ") or die(mysqli_error($db));
    }
    else
    {
        $result=mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(pair_id) as 'total' FROM pairing WHERE parent_id='$parent_id' and uid!=1"));
        $total=$result['total'];
        if($total>1){
        mysqli_query($db,"UPDATE pairing SET position ='R',`rank`='$total' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ");
        }
        else{
         mysqli_query($db,"UPDATE pairing SET position ='L',`rank`='$total' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ");
        }
    }
    return true;
}

function updateLeftRighCounterold($db,$parent_id,$uid,$position=null){
    $result=mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(pair_id) as 'total' FROM pairing WHERE parent_id='$parent_id' and uid!=1"));
    $total=$result['total'];
    if($position == null){
        if($total>1){
        mysqli_query($db,"UPDATE pairing SET position ='R',`rank`='$total' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ");
        }
        else{
         mysqli_query($db,"UPDATE pairing SET position ='L',`rank`='$total' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ");
        }
    }
    else{
         mysqli_query($db,"UPDATE pairing SET position ='$position',`rank`='$total' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ");
    }
    return true;
}
function updateLeftRighCounter_old($db,$parent_id,$uid){
    $result=mysqli_fetch_assoc(mysqli_query($db,"SELECT COUNT(pair_id) as 'total' FROM pairing WHERE parent_id='$parent_id' and uid!=1"));
    $total=$result['total'];
    if($total>2){
    mysqli_query($db,"UPDATE pairing SET position ='R',`rank`='$total' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ");
    }
    else{
     mysqli_query($db,"UPDATE pairing SET position ='L',`rank`='$total' WHERE uid='".$uid."' AND parent_id='".$parent_id."' ");
    }
    return true;
}
function BinaryCount($db,$uid,$isPLanRB,$plan_count,$plan_binary_count = null){
    if($plan_binary_count == null){
        $plan_binary_count = 1;
    }
    //echo $plan_binary_count;
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT `parent_id` FROM pairing  WHERE uid='$uid'"));
    $parent_id=$r1['parent_id'];
     /*$r2=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$parent_id'"));
    echo "SELECT * FROM pairing  WHERE uid='$parent_id'";*/
    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);
        //echo "rank : ".$row['position'];
        if($row['position']=="L")
        {
             //echo "UPDATE child_counter SET uleftcount=uleftcount+$plan_binary_count WHERE uid='$parent_id'";
                mysqli_query($db,"UPDATE child_counter SET uleftcount=uleftcount+$plan_binary_count WHERE uid='$parent_id'");
        }
        else if($row['position']=="R")
        {
            //echo "UPDATE child_counter SET urightcount=urightcount+$plan_binary_count WHERE uid='$parent_id'";
                mysqli_query($db,"UPDATE child_counter SET urightcount=urightcount+$plan_binary_count WHERE uid='$parent_id'");
        }
        if($parent_id==1)
        {

        }else{
             //$childid=$row['parent_id'];
             BinaryCount($db,$parent_id,$isPLanRB,$plan_count,$plan_binary_count);
         }
    }
    return true;
}
function ConfirmBinaryActivate($db,$uid,$plan_binary_count=null)
{
    $date=date("Y-m-d H:i:s");
    $result=mysqli_query($db,"UPDATE user_id SET binary_activated='1' WHERE uid='$uid' ");
    if($result){
        activatebinary($db,$uid,$plan_binary_count);
        /*$q1=mysqli_query($db,"select * from rplans limit 2");
        while($plans=mysqli_fetch_assoc($q1))
        {
            $amount=$plans['plan_amount'];
            $plan_id=$plans['plan_id'];
            $sql="INSERT INTO `purchase` SET `plan_id`='$plan_id',`amount`='$amount',`uid`='$uid',`status`= 1,`approve_date`= '$date',`date`='$crdate'";
            $qry = mysqli_query($db,$sql) or die(mysqli_error($db));
        }*/
    }
}
function BinaryCountUpdate($db)
{
    $ar=array(
          'KAVU'=>9,  
          'BABA'=>24,  
          'AKKU'=>9,  
          'AKKU2'=>4,  
          'AKKU3'=>4,  
          'AKKU4'=>4,  
          'AKKU5'=>4,  
          'AKKU6'=>4,  
          'BM07968132687'=>4  
        );
    $sql=mysqli_query($db,"SELECT uid,uname FROM user_id where uname in ('KAVU','BABA','AKKU','AKKU2','AKKU3','AKKU4','AKKU5','AKKU6','BM07968132687')");
    while ($r1=mysqli_fetch_assoc($sql)) {
        $uid=$r1['uid'];
        $key=$r1['uname'];
        $isPLanRB=1;
        $plan_count=0;
        echo "<br><br>$key====".$plan_binary_count=$ar[$key];
            BinaryCount($db,$uid,$isPLanRB,$plan_count,$plan_binary_count);
    }
}
// ********************************  INSERT BINARY COMISSION IN PAYOUT  ***************************

function GenerateBinaryPayout($db){
    $c=array();
    $date=date("Y-m-d H:i");
    $query=mysqli_query($db,"SELECT t1.*,t2.*,t1.uid as user_id FROM user_id t1 LEFT JOIN child_counter t2 ON t1.uid=t2.uid WHERE t1.binary_activated=1 and t1.status=1");
        if(mysqli_num_rows($query)>0){
            while($result=mysqli_fetch_assoc($query))
            {
                $uid=$result['user_id'];
                $res1=GetUids($db,$uid);    
                $res=getLevel2($db,$res1);
                //var_dump(count($res));
                $leftcount=$result['leftcount'];
                $rightcount=$result['rightcount'];
                // print_r($result);die;
                // echo $leftcount.'->'.$rightcount.'->>'.count($res).'->>>';die;
                if(isset($res) && count($res)>0 && $leftcount>0 && $rightcount > 0)
                {
                    $minimumchild='';
                    if($leftcount > $rightcount)
                    {
                        $minimumchild=$rightcount;
                    }
                    else if($leftcount < $rightcount)
                    {
                        $minimumchild=$leftcount;
                    }
                    else if($leftcount == $rightcount)
                    {
                        $minimumchild=$leftcount-1;
                    }
                    $result1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t2.* FROM transpin t1 INNER JOIN plans t2 ON t2.plan_id = t1.plan_id where t1.pin_code='$result[pin]' LIMIT 1"));
                    $amount1=$result1['binary_com'];
                    $capping=$result1['bcapping'];
                    $actual_amount=$amount1*$minimumchild;
                    if($actual_amount > $capping)
                    {
                        $amount=$capping;
                    }
                    else
                    {
                        $amount=$actual_amount;
                    }
                    //echo "<br> UPDATE payout SET comission_amount='$comissionamount' WHERE uid='$uid'";
                    // echo "<br>UPDATE child_counter SET leftcount=leftcount-'".$minimumchild."',rightcount=rightcount-'".$minimumchild."' WHERE uid='".$uid."' ";
                    
                    // echo $minimumchild;
                    // echo "UPDATE child_counter SET leftcount=leftcount-$minimumchild,rightcount=rightcount-$minimumchild WHERE uid='$uid'<br>";
                    $hq1=mysqli_query($db,"SELECT * FROM `binary_history` where uid='$uid' and amount > 0");
                    $hno=mysqli_num_rows($hq1);
                    if($hno==0)
                    {
                        mysqli_query($db,"UPDATE child_counter SET leftcount=0,rightcount=0 WHERE uid='$uid'") or die(mysqli_error($db));
                    }
                    else
                    {
                        mysqli_query($db,"UPDATE child_counter SET leftcount=leftcount-$minimumchild,rightcount=rightcount-$minimumchild WHERE uid='$uid'") or die(mysqli_error($db));
                    }
                    $bqry3=mysqli_query($db,"select id,uid,comission_amount from `payout` WHERE uid='$uid' and cleared=0") or die(mysqli_error($db));
                    $qq_no=mysqli_num_rows($bqry3);
                    if($qq_no > 0)
                    {      
                        $brow=mysqli_fetch_assoc($bqry3);
                        //$amount=$amount+$brow['comission_amount'];
                        $pid=$brow['id'];   
                        // echo "UPDATE `payout` SET `comission_amount`= $amount WHERE uid='$uid' and id='$pid'";               
                        $q2=mysqli_query($db,"UPDATE `payout` SET `comission_amount`= comission_amount+$amount WHERE uid='$uid' and id='$pid'");

                    }
                    else
                    {
                        $q2=mysqli_query($db,"INSERT INTO `payout` SET `uid`= $uid,`comission_amount`= $amount,`date`='$date'");
                    }

                    if($q2)
                    {
                        $c[] = 1;
                        $q3=mysqli_query($db,"INSERT INTO `binary_history` SET `uid`= $uid,`left_count`= '$leftcount',`right_count`= '$rightcount',`count`= '$minimumchild',`binary_com`= '$amount1',`bcapping`= '$capping',`actual_amount`= '$actual_amount',`amount`= '$amount',`date`='$date'");
                       // mysqli_query($db,"UPDATE child_counter SET leftcount=leftcount-'".$minimumchild."',rightcount=rightcount-'".$minimumchild."' WHERE uid='".$uid."' ");
                       getBinaryPayoutDetail($db,$uid);

                    }
                    else
                    {
                        $c[] = 0;
                    }

                }
                else
                {
                    $c[] = 2;
                }
                
            }
            
        }
        else
        {
            $c[] = 2;
        }

        return $c;
}


/*---------------------- Generate binary -------------------------*/

function GenerateBonusPayout(){
    global $crdate;
    global $db;
    $c=array();
    $date=date("Y-m-d H:i");
    $query=mysqli_query($db,"SELECT 
                            t1.*,
                            t2.*,
                            t1.uid as user_id 
                            FROM user_id t1 
                            INNER JOIN child_counter t2 ON t1.uid=t2.uid 
                            WHERE t1.binary_activated=1 and t1.status=1");
    if(mysqli_num_rows($query)>0){
        while($result=mysqli_fetch_assoc($query))
        {
            $uid=$result['user_id'];
            $res=GetUids($db,$uid);
            $leftcount=$result['leftcount'];
            $rightcount=$result['rightcount'];
            // echo $leftcount.'->'.$rightcount.'->'.count($res);die;
            /*if(isset($res) && count($res)>0 && $leftcount>0 && $rightcount > 0)
            {*/
                $result1=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(bonus_amount) as binary_com FROM v2_bonus where sponsor_id='$result[uid]' AND day_count < 100"));
                $amount1=$result1['binary_com'];
               
                $amount = $amount1;
                $q2 = mysqli_query($db,"UPDATE v2_bonus SET v2_status='1' WHERE sponsor_id='$uid'");
            
                $q2 = mysqli_query($db,"UPDATE v2_bonus SET day_count=day_count+1 WHERE sponsor_id = '$uid'");


                $bqry3=mysqli_query($db,"select id,uid,comission_amount from `payout` WHERE uid='$uid' and cleared=0");
                $qq_no=mysqli_num_rows($bqry3);
                if($qq_no > 0)
                {      
                    $brow=mysqli_fetch_assoc($bqry3);
                    // $amount=$amount+$brow['comission_amount'];
                    $pid=$brow['id']; 
                    // echo "UPDATE `payout` SET `bonus_amount`= bonus_amount+$amount WHERE uid='$uid' and id='$pid'<br>";    
                    $q2=mysqli_query($db,"UPDATE `payout` SET `bonus_amount`= bonus_amount+$amount WHERE uid='$uid' and id='$pid'");
                }
                else
                {
                    // echo "INSERT INTO `payout` SET `uid`= '$uid',`bonus_amount`= '$amount',`date`='$date'<br>";
                    $q2=mysqli_query($db,"INSERT INTO `payout` SET `uid`= '$uid',`bonus_amount`= '$amount',`date`='$date'");
                }
                if($q2)
                {
                   $c[] = 1;
                    $q3=mysqli_query($db,"INSERT INTO `bonus_history` SET `uid`= $uid,`bonus_amount`= '$amount',`date`='$crdate'") or die(mysqli_error($db));
                   getBonusPayoutDetail($db,$uid);

                }
                else
                {
                    $c[] = 0;
                }

           /* }
            else
            {
                $c[] = 2;
            }*/
        }
    }
    else{
        $c[] = 2;
    }
    return $c;
}


function GenerateRoiPayout(){
    global $crdate;
    global $db;
    $c=array();
    $date=date("Y-m-d H:i");
    $query=mysqli_query($db,"SELECT 
                            t1.*,
                            t2.*,
                            t1.uid as user_id,
                            t3.plan_amount
                            FROM user_id t1 
                            INNER JOIN child_counter t2 ON t1.uid=t2.uid 
                            INNER JOIN transpin t4 ON t4.pin_code = t1.pin
                            INNER JOIN plans t3 ON t3.plan_id = t4.plan_id
                            WHERE t1.binary_activated=1 and t1.status=1 and t3.plan_amount > 0");
    if(mysqli_num_rows($query)>0){
        while($result=mysqli_fetch_assoc($query)){
            $c[] = 1;
            $uid = $result['user_id'];
            $q1 = mysqli_query($db,"SELECT sum(roi_amount) as roi_amount ,day_count,total_days FROM v2_roi_manage WHERE sponsor_id='$uid' GROUP BY day_count,total_days") or die(mysqli_error($db));
            $r1 = mysqli_fetch_assoc($q1);
            $total_days = $r1['total_days'];
            $day_count = $r1['day_count'];
            $roi_amount = $r1['roi_amount'];
            if($roi_amount == ''){
                $roi_amount = 0;
            }
            $q2 = mysqli_query($db,"SELECT * FROM payout  WHERE uid='$uid' and cleared=0") or die(mysqli_error($db));
            if(mysqli_affected_rows($db)>0){
                // echo "UPDATE payout SET roi_amount=roi_amount+$roi_amount WHERE uid='$uid'";
                $q3 = mysqli_query($db,"UPDATE payout SET roi_amount=roi_amount+$roi_amount WHERE uid='$uid'") or die(mysqli_error($db));
            }
            else{
                $q3 = mysqli_query($db,"INSERT INTO payout SET uid='$uid',roi_amount='$roi_amount',date='$crdate' ") or die(mysqli_error($db));  
            }
            $q4 = mysqli_query($db,"UPDATE v2_roi_manage SET day_count=day_count+1 WHERE sponsor_id='$uid'");
            $q5 = mysqli_query($db,"INSERT INTO v2_roi_history SET uid='$uid',roi_amount='$roi_amount',date='$crdate'") or die(mysqli_error($db));
            // die;
        }
    }
    return $c;
}


/*----------------------------------------------------------------*/


function ActivateBinaryPlan($db,$uid)
{
    $result=mysqli_query($db,"UPDATE user_id SET binary_activated='1' WHERE uid='".$uid."' ");
    if($result){
        activatebinary($db,$uid);
    }
}
function ActivateBinaryPlanAll($db)
{
    $sql=mysqli_query($db,"SELECT uid FROM user_id");
    while ($r1=mysqli_fetch_assoc($sql)) {
        $uid=$r1['uid'];
        $isPLanRB=IsPlanRoyaltyBinary($db,$uid);
    
        if($isPLanRB==1)
        {
            ConfirmBinaryActivate($db,$uid);
        }
    }
}
$all_user=array();
function GetUserCountPos($db,$sponsor_id,$position)
{
    //echo "select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uname='$sponsor_id' and t1.position='$position'";
   global $all_user;
   $all_user=array();
   $sql=mysqli_query($db,"select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uname='$sponsor_id' and t1.position='$position'");
   if($no=mysqli_num_rows($sql) > 0)
   {
        $r1=mysqli_fetch_assoc($sql);
        $uid=$r1['uid'];
        $res=GetAllUserCountPos($db,$uid,$position);
        return $res;
   }
   else
   {
        $r1=mysqli_fetch_assoc(mysqli_query($db,"select uid from user_id where uname='$sponsor_id'"));
        $new_array = array($r1['uid']);
        return $new_array;
   }

}
function GetAllUserCountPos($db,$uid,$position)
{
    global $all_user;
    $all_user[]=$uid;
    //echo "select * from pairing t1 where t1.parent_id='$uid' and t1.position='$position'";
   $sql=mysqli_query($db,"select * from pairing t1 where t1.parent_id='$uid' and t1.position='$position'");
   if($no=mysqli_num_rows($sql) > 0)
   {
        $r1=mysqli_fetch_assoc($sql);
        $uid1=$r1['uid'];
        //$all_user[]=$uid1;
        $res=GetAllUserCountPos($db,$uid1,$position);        
   }
   return $all_user;
}

/**** Vikas code start **********/
function get_total_businesss_with_payout($uid_array = array()){
    global $db;
    $total_business = 0;
    if(!empty($uid_array)){
        if(!empty($uid_array[0])){
            $uids = "'".implode("','",$uid_array)."'";
            $sql1 = "SELECT sum(t3.binary_count) as total_binary_count FROM user_id t1 
                    INNER JOIN transpin t2 ON t2.pin_code = t1.pin
                    INNER JOIN plans t3 ON t3.plan_id = t2.plan_id
                    WHERE t1.uid IN($uids)";
            $query1 = mysqli_query($db,$sql1) or die(mysqli_error($db));
            $row1 = mysqli_fetch_assoc($query1);
            $total_business = $row1['total_binary_count']*80;
        }
    }
    return $total_business;
}


/* vikas code end *************/
$all_user1=array();
function getLevelid($db,$res)
{
    global $all_user1;
    $all_user1=array_merge($all_user1,$res);
    $res1=array();
    //echo "<pre>";print_r($res);
    foreach ($res as $key => $value) {
        //$all_user1[]=$value;
        $res1=GetUids($db,$value);
        if(count($res1) > 0)
        {
            //$all_user1=array_merge($all_user1,$res1);
            getLevelid($db,$res1);
        }
    }
    /*if(!empty($res1))
    {
        getLevelid($db,$res1);
    }*/
    return $all_user1;
}
function GetUserByPos($db,$sponsor_id,$position)
{
   // echo "select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uname='$sponsor_id' and t1.position='$position'";
    global $all_user1;
    $all_user1=array();
 //Faiz Change sponsor to parent of this query on 04-07-2020
   // $sql=mysqli_query($db,"select t1.uid from pairing t1 left join user_id t2 on t1.sponsor_id=t2.uid where t2.uid='$sponsor_id' and t1.position='$position'");
    $sql=mysqli_query($db,"select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uid='$sponsor_id' and t1.position='$position'");
    if($no=mysqli_num_rows($sql) > 0)
    {
        $r1=mysqli_fetch_assoc($sql);
        $uid=$r1['uid'];
        //$res=GetAllUserPos($db,$uid,$position);
        $res1 = array($uid);
        $res=GetUids($db,$uid);
        if(count($res) > 0)
        {
            $res2=getLevelid($db,$res);
            $res1=array_merge($res1,$res2);
        }
        return $res1;
        //print_r($res1);
    }
    else
    {
        
       $new_array = array();
        return $new_array;
    }

}
function GetAllUserPos($db,$uid,$position)
{
    global $all_user1;
    $all_user1[]=$uid;
    //echo "select * from pairing t1 where t1.parent_id='$uid' and t1.position='$position'";
   $sql=mysqli_query($db,"select * from pairing t1 where t1.parent_id='$uid'");
   if($no=mysqli_num_rows($sql) > 0)
   {
        $r1=mysqli_fetch_assoc($sql);
        $uid1=$r1['uid'];
        //$all_user1[]=$uid1;
        $res=GetAllUserPos($db,$uid1,$position);        
   }
   return $all_user1;
}
function getTotalBV($uid_array = array()){
    global $db;
    //var_dump($uid_array);
    //unset($uid_array[0]);
    $total_business = 0;
    if(!empty($uid_array)){
        if(!empty($uid_array[0])){
            $rr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `payout_date` where id=1"));
            $pdate=$rr['date'];
            $uids = "'".implode("','",$uid_array)."'";
            $sql1 = "SELECT IFNULL(sum(pv),0) as tpv FROM checkout WHERE date > '$pdate' and uid IN($uids)";
            $query1 = mysqli_query($db,$sql1) or die(mysqli_error($db));
            $row1 = mysqli_fetch_assoc($query1);
            $total_business = $row1['tpv'];
        }
    }
    return $total_business;
}
function get_total_businesss($uid_array = array()){
    global $db;
    //var_dump($uid_array);
    //unset($uid_array[0]);
    $total_business = 0;
    if(!empty($uid_array)){
        if(!empty($uid_array[0])){
            $uids = "'".implode("','",$uid_array)."'";
            $sql1 = "SELECT sum(t3.plan_amount) as total_planamount FROM user_id t1 
                    INNER JOIN transpin t2 ON t2.pin_code = t1.pin
                    INNER JOIN plans t3 ON t3.plan_id = t2.plan_id
                    WHERE t1.uid IN($uids)";
            $query1 = mysqli_query($db,$sql1) or die(mysqli_error($db));
            $row1 = mysqli_fetch_assoc($query1);
            $total_business = $row1['total_planamount'];
        }
    }
    return $total_business;
}
function getGreenId($uid_array = array()){
    global $db;
    $greenid = 0;
    $c_date=date('d-m-Y');
    if(!empty($uid_array)){
        if(!empty($uid_array[0])){
            $uids = "'".implode("','",$uid_array)."'";
            $sql1 = "SELECT count(uid) as ucount FROM pairing WHERE uid IN($uids) and is_active=1";
            $query1 = mysqli_query($db,$sql1) or die(mysqli_error($db));
            $row1 = mysqli_fetch_assoc($query1);
            $greenid = $row1['ucount'];
        }
    }
    return $greenid;
}
function getRedId($uid_array = array()){
    global $db;
    $redid = 0;
    if(!empty($uid_array)){
        if(!empty($uid_array[0])){
            $uids = "'".implode("','",$uid_array)."'";
            $sql1 = "SELECT count(t3.plan_amount) as ucount FROM user_id t1 
                    INNER JOIN transpin t2 ON t2.pin_code = t1.pin
                    INNER JOIN plans t3 ON t3.plan_id = t2.plan_id
                    WHERE t1.uid IN($uids) and t3.plan_amount=0";
            $query1 = mysqli_query($db,$sql1) or die(mysqli_error($db));
            $row1 = mysqli_fetch_assoc($query1);
            $redid = $row1['ucount'];
        }
    }
    return $redid;
}
function UpgradeSponsorRoi($db,$uid)
{
    global $crdate;
    $q10 = mysqli_query($db,"SELECT t1.register_date,t3.plan_amount,t3.binary_com,t3.binary_com_percentage,t3.pb_amount_for_sponser_1,t3.pb_amount_for_sponser_2,t3.pb_amount_for_sponser_3,t3.pb_amount_for_sponser_4,t3.pb_amount_for_sponser_5,t3.pb_amount_for_sponser_6,t4.sponsor_id,t4.parent_id FROM user_id t1 INNER JOIN transpin t2 ON t2.pin_code = t1.pin INNER JOIN plans t3 ON t3.plan_id = t2.plan_id left join pairing t4 on t1.uid=t4.uid WHERE t1.uid = '$uid'") or die(mysqli_error($db));
    $r10 = mysqli_fetch_assoc($q10);
    $sponsor_id=$r10['sponsor_id'];
    $parent_id=$r10['parent_id'];
    
    $q11 = mysqli_query($db,"SELECT count(t1.uid) as total_count FROM user_id t1 INNER JOIN transpin t2 ON t2.pin_code = t1.pin INNER JOIN plans t3 ON t3.plan_id = t2.plan_id left join pairing t4 on t1.uid=t4.uid WHERE t4.`sponsor_id`='$sponsor_id' and t3.plan_amount > 0") or die(mysqli_error($db));
    $r11 = mysqli_fetch_assoc($q11);
    $total_count = $r11['total_count'];
    $bonus_percentage = 0;
    $plan_amount = $r10['plan_amount'];
    if($total_count == 1) $bonus_percentage = $r10['pb_amount_for_sponser_1'];
    elseif($total_count == 2) $bonus_percentage = $r10['pb_amount_for_sponser_2'];
    elseif($total_count == 3) $bonus_percentage = $r10['pb_amount_for_sponser_3'];
    elseif($total_count == 4) $bonus_percentage = $r10['pb_amount_for_sponser_4'];
    elseif($total_count == 5) $bonus_percentage = $r10['pb_amount_for_sponser_5'];
    elseif($total_count >= 6) $bonus_percentage = $r10['pb_amount_for_sponser_6'];

    $bonus_amount = ($plan_amount*$bonus_percentage)/100;
    $chk_no1=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `v2_bonus`WHERE ref_user_id='$uid' and sponsor_id='$sponsor_id'"));
    if($chk_no1 > 0)
    {
        //echo "UPDATE v2_bonus SET `plan_amount`='$plan_amount',`bonus_percentage`='$bonus_percentage',`bonus_amount`='$bonus_amount',`created_date`='$crdate'";echo "<br>";
        $q12 = mysqli_query($db,"UPDATE v2_bonus SET `plan_amount`='$plan_amount',`bonus_percentage`='$bonus_percentage',`bonus_amount`='$bonus_amount',`created_date`='$crdate' WHERE ref_user_id='$uid' and sponsor_id='$sponsor_id'") or die(mysqli_error($db));
    }
    else
    {
        //echo "INSERT INTO v2_bonus (`sponsor_id`,`ref_user_id`,`ref_user_parent_id`,`plan_amount`,`bonus_percentage`,`bonus_amount`,`created_date`) VALUES('$sponsor_id','$uid','$parent_id','$plan_amount','$bonus_percentage','$bonus_amount','$crdate')";echo "<br>";
        $q12 = mysqli_query($db,"INSERT INTO v2_bonus (`sponsor_id`,`ref_user_id`,`ref_user_parent_id`,`plan_amount`,`bonus_percentage`,`bonus_amount`,`created_date`) VALUES('$sponsor_id','$uid','$parent_id','$plan_amount','$bonus_percentage','$bonus_amount','$crdate')") or die(mysqli_error($db));
    }

    /*-------- end check number of member which sponser id is my id----------------------------------------*/ 


    /*-- Manage Binary for sponser id ---------------*/
    $binary_percentage = $r10['binary_com_percentage'];
    $binary_amount = ($binary_percentage*$plan_amount)/100;
    $q12 = mysqli_query($db,"INSERT INTO v2_binary(`sponsor_id`,`ref_user_id`,`ref_user_parent_id`,`plan_amount`,`binary_percentage`,`binary_amount`,`created_date`) VALUES('$sponsor_id','$uid','$parent_id','$plan_amount','$binary_percentage','$binary_amount','$crdate')");
    
        $register_date = strtotime($r10['register_date']);

        $for_roi_percentage_validation_1 = strtotime('2019-01-26');
        $for_roi_percentage_1 = 1;
        $for_roi_total_days_1 = 200;

        $for_roi_percentage_validation_2 = strtotime('2019-01-27');
        $for_roi_percentage_2 = 0.8;
        $for_roi_total_days_2 = 250;

        $for_roi_percentage_validation_3 = strtotime('2019-04-01');
        $for_roi_percentage_3 = 0.7;
        $for_roi_total_days_3 = 300;

        if($register_date<$for_roi_percentage_validation_1){
            $roi_percentage = $for_roi_percentage_1;
            $roi_amount = ($plan_amount*$roi_percentage)/100;
            $roi_total_days = $for_roi_total_days_1;
        }
        elseif($register_date>=$for_roi_percentage_validation_2 && $register_date<$for_roi_percentage_validation_3){
            $roi_percentage = $for_roi_percentage_2;
            $roi_amount = ($plan_amount*$roi_percentage)/100;
            $roi_total_days = $for_roi_total_days_2;
        }
        else{
            $roi_percentage = $for_roi_percentage_3;
            $roi_amount = ($plan_amount*$roi_percentage)/100;
            $roi_total_days = $for_roi_total_days_3;
        }
        $chk_no=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `v2_roi_manage` WHERE ref_user_id='$uid'"));
        if($chk_no > 0)
        {
            $q13 = mysqli_query($db,"UPDATE v2_roi_manage SET `plan_amount`='$plan_amount',`roi_percentage`='$roi_percentage',`roi_amount`='$roi_amount',`created_date`='$crdate' where ref_user_id='$uid' and sponsor_id='$sponsor_id'") or die(mysqli_error($db));
        }
        else
        {
            $q13 = mysqli_query($db,"INSERT INTO v2_roi_manage(`sponsor_id`,`ref_user_id`,`ref_user_parent_id`,`plan_amount`,`roi_percentage`,`roi_amount`,`total_days`,`created_date`) VALUES('$sponsor_id','$uid','$parent_id','$plan_amount','$roi_percentage','$roi_amount','$roi_total_days','$crdate')") or die(mysqli_error($db));
        }
    return true;
}
function GetValidParentId_old($db,$sponsor_id,$position)
{
    global $crdate;
    $parent_name='';
    $res=GetUserCountPos($db,$sponsor_id,$position);
    //var_dump($res);
    $parent_id=end($res);
    $sp1=mysqli_query($db,"select uname,paired from user_id where uid='$parent_id'");
    $spno=mysqli_num_rows($sp1);
    if($spno > 0)
    {
        $userid=mysqli_fetch_assoc($sp1);
        echo $parent_name=$userid['uname'];
        $check_position1 = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
       echo  $chkqry21 = mysqli_num_rows($check_position1);
        if($chkqry21>0){}else{
            GetValidParentId($db,$sponsor_id,$position);
        }
    }
    else
    {
        GetValidParentId($db,$sponsor_id,$position);
    }
    return $parent_name;
}
function GetValidParentUId_old($db,$parent_id,$sponsor_id,$position)
{
    global $crdate;
    $res=GetUserCountPos($db,$sponsor_id,$position);
    $parent_id=end($res);
    $sp1=mysqli_query($db,"select uname,paired from user_id where uid='$parent_id'");
    $spno=mysqli_num_rows($sp1);
    if($spno > 0)
    {
        $check_position1 = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
        $chkqry21 = mysqli_num_rows($check_position1);
        if($chkqry21>0){}else{
            GetValidParentUId($db,$parent_id,$sponsor_id,$position);
            echo "<br><br>1";
        }
        
    }
    else
    {
        GetValidParentUId($db,$parent_id,$sponsor_id,$position);
        echo "<br><br>2";
    }
    echo "<br><br>3";
    return $parent_id;
}


function GetValidParentId($db,$sponsor_id,$position)
{
    global $crdate;
    $parent_name='';
    $res=GetUserCountPos($db,$sponsor_id,$position);
    //var_dump($res);echo "1____<br>\n\n";
    $parent_id=end($res);
    //echo "select uid,uname,paired from user_id where uname='$parent_id'";
    $sp1=mysqli_query($db,"select uid,uname,paired from user_id where uid='$parent_id'");
    $spno=mysqli_num_rows($sp1);
    if($spno > 0)
    {
        $userid=mysqli_fetch_assoc($sp1);
        $parent_id=$userid['uid'];
        $parent_name=$userid['uname'];
        $check_position1 = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
        $chkqry21 = mysqli_num_rows($check_position1);
        if($chkqry21>0){
            //echo 2;
            GetValidParentId($db,$sponsor_id,$position);
        }
    }
    else
    {
        //echo 3;
        GetValidParentId($db,$sponsor_id,$position);
    }
    return $parent_name;
}
function GetValidParentUId($db,$parent_id,$sponsor_id,$position)
{
    global $crdate;
    $res=GetUserCountPos($db,$sponsor_id,$position);
    $parent_id1=end($res);
    //var_dump($res);
    $sp1=mysqli_query($db,"select uid,paired from user_id where uid='$parent_id1'");
    $spno=mysqli_num_rows($sp1);
    if($spno > 0)
    {
        $check_position1 = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id1' AND position='$position'") or die(mysqli_error($db));
        $chkqry21 = mysqli_num_rows($check_position1);
        if($chkqry21>0){
            GetValidParentUId($db,$parent_id,$sponsor_id,$position);
        }
        else
        {
            $parent_id=$parent_id1;
        }
        
    }
    else
    {
        GetValidParentUId($db,$parent_id,$sponsor_id,$position);
    }
    return $parent_id;
}


function selfpurchase_BV($db,$uid,$left_pv,$right_pv){
 $rr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `payout_date` where id=1"));    
 $pdate=$rr['date'];
 $self_purchase_bv=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as self_bv FROM checkout WHERE uid='$uid' && date > '$pdate'"));
         if($self_purchase_bv['self_bv']>0){
             if($left_pv<$right_pv){
              $lpv_self= $self_purchase_bv['self_bv'];
            }
            elseif($right_pv<$left_pv){
              $rpv_self= $self_purchase_bv['self_bv'];  
            }  
            else{
              $lpv_self= $self_purchase_bv['self_bv']; 
            }
         }
         else{
            $lpv_self =0;
            $rpv_self =0;
         }
  return array('lpv_self'=>$lpv_self,
               'rpv_self'=>$rpv_self);
}

// function GetBPVAll($db,$pair_amount)
// {
//     $tot_pv=0;
    
    
//     $q1=mysqli_query($db,"SELECT uid,left_pv,right_pv,rleft_pv,rright_pv FROM `child_counter` where uid!=1");
//     while ($r1=mysqli_fetch_assoc($q1)) {
//         $uid=$r1['uid'];
//         $is_active=GetMonthlyPurchaseStatus($db,$uid);
//         $self_purchase_bv=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as self_bv FROM checkout WHERE uid='$uid' && user='$uid'"));
        
//         if(isset($is_active) && $is_active==1){
//             if($self_purchase_bv['self_bv']>0){
//              if($r1['left_pv']<$r1['right_pv']){
//               $lpv_self= $self_purchase_bv['self_bv'];
//             }
//             elseif($r1['right_pv']<$r1['left_pv']){
//               $rpv_self= $self_purchase_bv['self_bv'];  
//             }  
//             else{
//               $lpv_self= $self_purchase_bv['self_bv']; 
//             }
//         }
//         else{
//             $lpv_self =0;
//             $rpv_self =0;
//         }
       
//         $llpp=$r1['left_pv']+$lpv_self;
//         $rrpp=$r1['right_pv']+$rpv_self;
//          $mpv=0;
//          $lpv=floor($llpp/$pair_amount);              
//          $rpv=floor($rrpp/$pair_amount);
//          if($lpv<$rpv || $lpv==$rpv)
//          {
//             $mpv=$lpv;
//          }
//          else{
//             $mpv=$rpv;
//          }
//          $rmpv=0;
//          $rlpv=round($r1['rleft_pv']/$pair_amount);              
//          $rrpv=round($r1['rright_pv']/$pair_amount);
//          if($rlpv<$rrpv || $rlpv==$rrpv)
//          {
//             $rmpv=$rlpv;
//          }
//          else{
//             $rmpv=$rrpv;
//          }
//          mysqli_query($db,"UPDATE child_counter SET pv='$mpv', tpv=tpv+'$rmpv' WHERE uid='$uid'");
         
//          $tot_pv+=$mpv;             
//         }

        
//     }
//     return $tot_pv;
// }

function GetBPVAll($db,$pair_amount)
{
    $tot_pv=0;
    $q1=mysqli_query($db,"SELECT uid,left_pv,right_pv,rleft_pv,rright_pv FROM `child_counter` where uid!=1");
    while ($r1=mysqli_fetch_assoc($q1)) {
        $uid=$r1['uid'];
        $is_active=GetMonthlyPurchaseStatus($db,$uid);       
        
        if(isset($is_active) && $is_active==1){
            
        $self=selfpurchase_BV($db,$uid,$r1['left_pv'],$r1['right_pv']);
        extract($self);
        $llpp=$r1['left_pv']+$lpv_self;
        $rrpp=$r1['right_pv']+$rpv_self;
        // echo $uid."--Left--".$llpp."-".$lpv_self;
        // echo $uid."--Right--".$rrpp."-".$rpv_self;
        // echo"<br>";
         $mpv=0;
         $lpv=floor($llpp/$pair_amount);              
         $rpv=floor($rrpp/$pair_amount);
         if($lpv<$rpv || $lpv==$rpv)
         {
            $mpv=$lpv;
         }
         else{
            $mpv=$rpv;
         }
         $rmpv=0;
         $rlpv=round($r1['rleft_pv']/$pair_amount);              
         $rrpv=round($r1['rright_pv']/$pair_amount);
         if($rlpv<$rrpv || $rlpv==$rrpv)
         {
            $rmpv=$rlpv;
         }
         else{
            $rmpv=$rrpv;
         }
         mysqli_query($db,"UPDATE child_counter SET pv='$mpv', tpv=tpv+'$rmpv' WHERE uid='$uid'");
         
         $tot_pv+=$mpv;             
        }
        else{
           $fbv=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `child_counter` WHERE uid='$uid'"));
           if($fbv['left_pv'] > $fbv['right_pv']){
              $right_pv=0;
              $left_pv = $fbv['left_pv'];
           }
           else{
              $left_pv=0;
              $right_pv = $fbv['right_pv'];
           }
           if($fbv['rleft_pv'] > $fbv['rright_pv']){
              $rright_pv=0;
              $rleft_pv = $fbv['rleft_pv'];
           }
           else{
              $rleft_pv=0;
              $rright_pv = $fbv['rright_pv'];
           }
           mysqli_query($db,"UPDATE `child_counter` SET `left_pv`=$llefttBv,`right_pv`=$rrightBv WHERE uid='$uid'");
        }

        
    }
    return $tot_pv;
}

function GetGTBPoint($db)
{
    $total_pv=GetBPVAll($db,500);
    //$res=UpdateRank($db);
    //$br=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as tpv FROM `user_id` WHERE uid!='1'"));
    $rr=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `payout_date` where id=1"));
    //$pdate=date("Y-m-d", strtotime($rr['date']));
    $pdate=$rr['date'];
    //echo "SELECT sum(pv) as tpv FROM `checkout` WHERE uid!='1' and DATETIME(date) > DATETIME('$pdate')";
    $br=mysqli_fetch_assoc(mysqli_query($db,"SELECT sum(pv) as tpv FROM `checkout` WHERE uid!='1' and date > '$pdate'"));
    $total_turnover_com=$br['tpv'];
    $bonus_perc=35;
    $bonus=($total_turnover_com*$bonus_perc)/100;
    $bonus_point_value=0;
    if(isset($total_pv) && $total_pv> 0)
    {
        $bonus_point_value=$bonus/$total_pv;
    }
    $bonus_point_value=floor($bonus_point_value);
    return array('gtb_point'=>$bonus_point_value,
                'total_turnover'=>$total_turnover_com,
                'total_pv'=>$total_pv,
                'perc'=>$bonus_perc,);
}
function SponsorGeneration($db,$uid,$amount)
{
    global $crdate;
    $q1=mysqli_query($db,"SELECT * FROM `sp_level`");
    while ($r1=mysqli_fetch_assoc($q1))
    {
        $lper=$r1['bonus'];
        $pamount=($amount*$lper)/100;
        $q2=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.* FROM `pairing` t1  WHERE t1.`uid` = '$uid' and t1.uid!=1"));
        $user_id=$uid;
        $uid=$parent_id=$q2['sponsor_id'];
        if(isset($parent_id) && $parent_id > 0)
        {
            $sql=mysqli_query($db,"INSERT INTO `child_earning`(`uid`, `parent_id`, `gtb`, `perc`, `amount`, `date`) VALUES ('$uid','$parent_id','$amount','$lper','$pamount','$crdate')") or die(mysqli_error($db));
        }
    }
    return true;
}

function GenerateGTBPayout($db)
{
    global $crdate;
    $sql=mysqli_query($db,"SELECT uid,left_pv,right_pv,pv FROM child_counter WHERE  left_pv > 0 and right_pv> 0 and uid!=1");
    if(mysqli_num_rows($sql) > 0)
    {
        while ($r1=mysqli_fetch_assoc($sql))
        {   
            $uid=$r1['uid'];
          $user_active=IsDistributor($db,$uid);
          if($user_active > 0 ){
            $left_pv=$r1['left_pv'];
            $right_pv=$r1['right_pv'];

            if($left_pv > $right_pv){
             $pay_bv=$right_pv;
            }
            elseif ($right_pv > $left_pv) {
             $pay_bv=$left_pv;
            }
            elseif ($right_pv == $left_pv) {
             $pay_bv=$left_pv;
            }

            // Faiz previous pv saved
            $previous_bv_transaction=mysqli_query($db,"SELECT * FROM `previous_bv_transaction` WHERE `uid`='$uid'");
            if(mysqli_num_rows($previous_bv_transaction)>0){
              mysqli_query($db,"UPDATE `previous_bv_transaction` SET `left_pv`=left_pv+'$left_pv',`right_pv`=right_pv+'$right_pv' WHERE `uid`='$uid'");
            }
            else{
                mysqli_query($db,"INSERT `previous_bv_transaction` SET `uid`='$uid', `left_pv`='$left_pv',`right_pv`='$right_pv'");
            }
            // end

            $pamount=$pay_bv*10;                      
            $sql1=mysqli_query($db,"SELECT uid,gtb FROM `payout` WHERE uid='$uid' AND cleared=0");
            if(mysqli_num_rows($sql1) > 0)
            {
                $r2=mysqli_fetch_assoc($sql1);
                $amount=$r2['gtb']+$pamount;
                $q2=mysqli_query($db,"UPDATE `payout` SET `gtb`= $amount WHERE uid='$uid' and cleared=0");
            }
            else
            {
                $q2=mysqli_query($db,"INSERT INTO `payout` SET uid='$uid',`gtb`= $pamount,`date`='$crdate'");
            }
               
            if($q2)
            {
                if(isset($pamount) && $pamount>0)
                {
                    $uname=GetUname($db,$uid);
                    $msg = "Group Turnover Bonus Payout Generated: ".date('d/m/Y H:i:s')."
                     User : $uname
                     Amount : $pamount";
                    $rv=SponsorGeneration($db,$uid,$pamount);
                    if(isset($msg) && $msg!='' && !empty($msg))
                    {
                       sendSMS($db,$uid,$msg); 
                    }
                }
                $c[] = 1;
                
                $addselfbv=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `child_counter` WHERE uid='$uid'"));
                $getRank=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` WHERE uid='$uid'"));
                $ranks=$getRank['achieve_rank'];
                $lefttBv=$addselfbv['left_pv'];
                $rightBv=$addselfbv['right_pv'];
                $l_bv=$addselfbv['left_pv']-$pay_bv;
                $r_bv=$addselfbv['right_pv']-$pay_bv;
                
                 // carry forward run on this condition build by Faiz..
                if($l_bv > $r_bv){ 

                 if($ranks==3){
                  if($l_bv>9999){
                    $l_bv1=10000;
                  }
                  else{ $l_bv1=$l_bv; }
                 }
                 elseif($ranks==4 || $ranks==5 || $ranks==6){
                  if($l_bv>14999){
                    $l_bv1=15000;
                  }
                  else{ $l_bv1=$l_bv; }
                 }
                 elseif($ranks==7 || $ranks==8 || $ranks==9){
                  if($l_bv>24999){
                    $l_bv1=25000;
                  }
                  else{ $l_bv1=$l_bv; }
                 }
                 elseif($ranks==10 || $ranks==11 || $ranks==12 || $ranks==13 || $ranks==14 || $ranks==15){
                  if($l_bv>49999){
                    $l_bv1=50000;
                  }
                  else{ $l_bv1=$l_bv; }
                 }
                 $r_bv1=$r_bv;
                }
                elseif ($r_bv > $l_bv) {

                  if($ranks==3){
                  if($r_bv>9999){
                    $r_bv1=10000;
                  }
                  else{ $r_bv1=$r_bv; }
                 }
                 elseif($ranks==4 || $ranks==5 || $ranks==6){
                  if($r_bv>14999){
                    $r_bv1=15000;
                  }
                  else{ $r_bv1=$r_bv; }
                 }
                 elseif($ranks==7 || $ranks==8 || $ranks==9){
                  if($r_bv>24999){
                    $r_bv1=25000;
                  }
                  else{ $r_bv1=$r_bv; }
                 }
                 elseif($ranks==10 || $ranks==11 || $ranks==12 || $ranks==13 || $ranks==14 || $ranks==15){
                  if($r_bv>49999){
                    $r_bv1=50000;
                  }
                  else{ $r_bv1=$r_bv; }
                 }
                 $l_bv1=$l_bv;                
                }

                $q3=mysqli_query($db,"UPDATE `child_counter` SET `left_pv`=$l_bv1,`right_pv`=$r_bv1 WHERE uid='$uid'");
                
                $q4=mysqli_query($db,"INSERT INTO binary_history SET uid='$uid',amount='$pamount',date='$crdate'");
            }
            else
            {
                $c[] = 0;
            }
              
          }             
        }
    }
    else
    {
        $c[] = 2;
    }
    return $c;
}

// Generate Rank Payout

function GenerateRankayout($db)
{
    global $crdate;
    echo "string";
}


function GenerateSponsorGenerationPayout($db)
{
    global $crdate;
    $sql=mysqli_query($db,"SELECT * FROM child_earning WHERE  amount > 0 and status=0 and uid!=1");
    if(mysqli_num_rows($sql) > 0)
    {
        while ($r1=mysqli_fetch_assoc($sql))
        {
            $uid=$r1['uid'];
            $bankres=GetBankDetail($db,$uid);
            
            $pid=$r1['pid'];
            $uid=$r1['parent_id'];
            $pamount=$r1['amount'];
            $is_active=GetMonthlyPurchaseStatus($db,$uid);
            //echo $is_active;
            if(isset($is_active) && $is_active==1)
            {
                if(isset($bankres) && $bankres==1)
                {
                    $sql1=mysqli_query($db,"SELECT uid,dsb FROM `payout` WHERE uid='$uid' AND cleared=0");
                    if(mysqli_num_rows($sql1) > 0)
                    {
                        $r2=mysqli_fetch_assoc($sql1);
                        $amount=$r2['dsb']+$pamount;
                        $q2=mysqli_query($db,"UPDATE `payout` SET `dsb`= $amount WHERE uid='$uid' and cleared=0");
                    }
                    else
                    {
                        $q2=mysqli_query($db,"INSERT INTO `payout` SET uid='$uid',`dsb`= $pamount,`date`='$crdate'");
                    }
                }
                else
                {
                    $sql1=mysqli_query($db,"SELECT uid,dsb FROM `payout` WHERE uid='$uid' AND cleared=2");
                    if(mysqli_num_rows($sql1) > 0)
                    {
                        $r2=mysqli_fetch_assoc($sql1);
                        $amount=$r2['dsb']+$pamount;
                        $q2=mysqli_query($db,"UPDATE `payout` SET `dsb`= $amount WHERE uid='$uid' and cleared=2");
                    }
                    else
                    {
                        $q2=mysqli_query($db,"INSERT INTO `payout` SET uid='$uid',`dsb`= $pamount,`date`='$crdate',cleared=2");
                    }
                }
                if($q2)
                {
                    if(isset($pamount) && $pamount>0)
                    {
                        $uname=GetUname($db,$uid);
                        $msg = "Direct Sponsor Bonus Payout Generated: ".date('d/m/Y H:i:s')."
                         User : $uname
                         Amount : $pamount";
                        if(isset($msg) && $msg!='' && !empty($msg))
                        {
                           sendSMS($db,$uid,$msg); 
                        }
                    }
                    $c[] = 1;
                    $q3=mysqli_query($db,"UPDATE `child_earning` SET status=1,udate='$crdate' WHERE pid='$pid'");
                    
                }
                else
                {
                    $c[] = 0;
                }
            }
            else
            {
                $c[] = 2;
            }
        }
    }
    else
    {
        $c[] = 2;
    }
    return $c;
}

function UpdateRank($db) 
{
    $q1=mysqli_query($db,"SELECT * FROM `rank_detail`");
    while ($r1=mysqli_fetch_assoc($q1)) 
    {
       $id=$r1['id'];
       $tpv=$r1['tpv'];
       $name=$r1['name'];
       //$q2=mysqli_query($db,"SELECT * FROM `child_counter` WHERE tpv>=$tpv");
       $q2=mysqli_query($db,"SELECT * FROM `child_counter` WHERE rleft_pv>=$tpv && rright_pv>=$tpv");
       if(mysqli_num_rows($q2) > 0)
       {
           while ($r2=mysqli_fetch_assoc($q2)) 
           {
                $uid=$r2['uid']; 
                //echo "<br><br>".$uid." --> ".$name;
                mysqli_query($db,"UPDATE pairing SET rank='$id' WHERE uid='$uid'");
            }
        }      
    }
    return true;
}

function GetPointValueAll($db,$pair_amount,$rank_id)
{
    $tot_point=0;
   
    $q1=mysqli_query($db,"SELECT t1.uid,t1.rleft_pv,t1.rright_pv FROM `child_counter` t1 LEFT JOIN `userAchieveRank` t2 on t1.uid=t2.uid WHERE t2.rank_id='$rank_id'");
    while ($r1=mysqli_fetch_assoc($q1)) {
        $uid=$r1['uid'];
        $is_active=GetMonthlyPurchaseStatus($db,$uid);  
        $self=selfpurchase_BV($db,$uid,$r1['rleft_pv'],$r1['rright_pv']);
        if(isset($is_active) && $is_active==1){
            extract($self);
            $llpp=$r1['rleft_pv']+$lpv_self;
            $rrpp=$r1['rright_pv']+$rpv_self;

             $mpv=0;
             $lpv=floor($llpp/$pair_amount);              
             $rpv=floor($rrpp/$pair_amount);
             if($lpv<$rpv || $lpv==$rpv)
             {
                $mpv=$lpv;
             }
             else{
                $mpv=$rpv;
             }             
             //echo $mpv;
             $tot_point+=$mpv;
        }
         
    }
    return $tot_point;
}

function GetUserPointValue($db,$pair_amount,$uid)
{
    $tot_point=0;
   
    $q1=mysqli_query($db,"SELECT t1.uid,t1.rleft_pv,t1.rright_pv FROM `child_counter` t1 LEFT JOIN `pairing` t2 on t1.uid=t2.uid WHERE t2.uid='$uid'");
    while ($r1=mysqli_fetch_assoc($q1)) {
        $uid=$r1['uid'];
         $mpv=0;
         $lpv=round($r1['rleft_pv']/$pair_amount);              
         $rpv=round($r1['rright_pv']/$pair_amount);
         if($lpv<$rpv || $lpv==$rpv)
         {
            $mpv=$lpv;
         }
         else{
            $mpv=$rpv;
         }
         //echo $mpv;
         $tot_point+=$mpv; 
    }
    return $tot_point;
}
function GetRankPoint($db,$tpv,$bonus_perc,$total_point,$total_turnover_com)
{
    $bonus_point_value=0;
    $bonus=($total_turnover_com*$bonus_perc)/100;
    //echo $bonus;
    //echo "<br>".$total_point;
    //echo "<br>".$total_turnover_com;
    //echo "<br>".$bonus_perc;
    if(isset($total_point) && $total_point>0)
    {
        $bonus_point_value=$bonus/$total_point;
    }
    //echo "bonus point -----".$bonus_point_value;
    return array('bonus_point_value'=>$bonus_point_value,
                'total_turnover'=>$total_turnover_com,
                'total_point'=>$total_point,
                'perc'=>$bonus_perc,);
}

function userAchieveRank($db){
    $try=mysqli_query($db,"SELECT * FROM `pairing` WHERE rank>0");    
    while($rank=mysqli_fetch_assoc($try)) 
    {
      $rk=$rank['rank']+1;
      $uid=$rank['uid'];
      for($i=1; $i < $rk ; $i++) { 
        $getAchiveRank=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `userachieverank` WHERE uid=$uid && rank_id = $i"));
        if($getAchiveRank>0){ }
        else{
            mysqli_query($db,"INSERT INTO `userachieverank`(`uid`, `rank_id`) VALUES ('$uid','$i')"); 
        }
      }      
    }
}

function getRankPayout($db)
{
    global $crdate;
    
     // Faiz previous pv saved
       $get_pv12=mysqli_query($db,"SELECT * FROM `child_counter`");
       while ($get_pv=mysqli_fetch_array($get_pv12)) {
            $uids=$get_pv['uid'];
            $left_pv=$get_pv['rleft_pv']*50;
            $right_pv=$get_pv['rright_pv']*50;
            $previous_bv_transaction=mysqli_query($db,"SELECT * FROM `previous_bv_transaction` WHERE `uid`='$uids'");
            if(mysqli_num_rows($previous_bv_transaction)>0){
              mysqli_query($db,"UPDATE `previous_bv_transaction` SET `left_pv`=left_pv+'$left_pv',`right_pv`=right_pv+'$right_pv' WHERE `uid`='$uids'");
            }
            else{
                mysqli_query($db,"INSERT `previous_bv_transaction` SET `uid`='$uids', `left_pv`='$left_pv',`right_pv`='$right_pv'");
            }      
       }        
    // end
    
    checkAppreciationFortNightly($db);
    $c=array();
    $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout`");
    if(mysqli_num_rows($ontime_rank_payout)>0){
      while($row=mysqli_fetch_assoc($ontime_rank_payout)){
        $uid=$row['uid'];
      $user_active=IsDistributor($db,$uid);
      if($user_active > 0 ){
        $gtb=$row['gtb'];
        $amount=$row['amount'];
        $sd=$row['sd'];
        $rd=$row['rd'];
        $ad=$row['ad'];
        $co=$row['co'];
        $sco=$row['sco'];
        $cco=$row['cco'];
        $se=$row['se'];
        $ge=$row['ge'];
        $pe=$row['pe'];
        $do=$row['do'];
        $bdo=$row['bdo'];
        $bldo=$row['bldo'];
        $ra=$row['ra'];
        $ia=$row['ia'];
        $ca=$row['ca'];
        $reward=$row['reward'];
        $royalty=$row['royalty'];
        $appriciation_amnt=$row['appriciation_amnt'];
         // Faiz previous pv saved
        $get_pv=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `child_counter` WHERE `uid`='$uid'"));
        $left_pv=$get_pv['rleft_pv']*50;
        $right_pv=$get_pv['rright_pv']*50;
        $previous_bv_transaction=mysqli_query($db,"SELECT * FROM `previous_bv_transaction` WHERE `uid`='$uid'");
        if(mysqli_num_rows($previous_bv_transaction)>0){
          mysqli_query($db,"UPDATE `previous_bv_transaction` SET `left_pv`=left_pv+'$left_pv',`right_pv`=right_pv+'$right_pv' WHERE `uid`='$uid'");
        }
        else{
            mysqli_query($db,"INSERT `previous_bv_transaction` SET `uid`='$uid', `left_pv`='$left_pv',`right_pv`='$right_pv'");
        }
        // end
        $sql=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `rank_payout` WHERE `uid`='$uid' && `cleared`=0"));
        if($sql>0){
          $q=mysqli_query($db,"UPDATE `rank_payout` SET `gtb`=gtb+'$gtb',`amount`=amount+'$amount',`sd`=sd+'$sd',`rd`=rd+'$rd',`ad`=ad+'$ad',`co`=co+'$co',`sco`=sco+'$sco',`cco`=cco+'$cco',`se`=se+'$se',`ge`=ge+'$ge',`pe`=pe+'$pe',`do`=do+'$do',`bdo`=bdo+'$bdo',`bldo`=bldo+'$bldo',`ra`=ra+'$ra',`ia`=ia+'$ia',`ca`=ca+'$ca',`reward`=reward+'$reward',`royalty`=royalty+'$royalty',`appriciation_amnt`=appriciation_amnt+'$appriciation_amnt',`date`='$crdate' WHERE `uid`='$uid'");
        }
        else{
           $q=mysqli_query($db,"INSERT `rank_payout` SET `uid`='$uid',`gtb`='$gtb',`amount`='$amount',`sd`='$sd',`rd`='$rd',`ad`='$ad',`co`='$co',`sco`='$sco',`cco`='$cco',`se`='$se',`ge`='$ge',`pe`='$pe',`do`='$do',`bdo`='$bdo',`bldo`='$bldo',`ra`='$ra',`ia`='$ia',`ca`='$ca',`reward`='$reward',`royalty`='$royalty',`appriciation_amnt`='$appriciation_amnt',`date`='$crdate'");
        }
        mysqli_query($db,"UPDATE `commision_history` SET status=1 , updates_at='$crdate' WHERE uid='$uid'");
        mysqli_query($db,"DELETE FROM `ontime_rank_payout` WHERE uid='$uid'");
        if($q){
            $uname=GetUname($db,$uid);
            $msg = "Commision Payout Generated: ".date('d/m/Y H:i:s')."
             User : $uname";
            if(isset($msg) && $msg!='' && !empty($msg))
            {
               sendSMS($db,$uid,$msg); 
            }
          $c[]=1;
        }
       }       
      }
      
    }
    else{
        $c[]=0;
    }

    mysqli_query($db,"UPDATE `user_id` SET `pv`=0");
    mysqli_query($db,"UPDATE `child_counter` SET `rleft_pv`=0,`rright_pv`=0 WHERE `rleft_pv`>0 and `rright_pv`>0") or die(mysqli_error($db));
   // mysqli_query($db,"TRUNCATE `ontime_rank_payout`");
    return $c;
}

function getRetailProfitkPayout($db){
    
    $rp=mysqli_query($db,"SELECT * FROM `child_counter` WHERE `retail_profit`>0");
        while($row1=mysqli_fetch_assoc($rp)){
             $retail_profit=$row1['retail_profit']; 
             echo $uids=$row1['uid'].","; 
             $sql123=mysqli_num_rows(mysqli_query($db,"SELECT * FROM `rank_payout` WHERE `uid`='$uids' && `cleared`=0"));
             if($sql123>0){
              $q1=mysqli_query($db,"UPDATE `rank_payout` SET `retail_profit`=retail_profit+'$retail_profit',`date`='$crdate' WHERE `uid`='$uids'");
             }
             else{
               $q1=mysqli_query($db,"INSERT `rank_payout` SET `uid`='$uids',`retail_profit`='$retail_profit',`date`='$crdate'");
             }
             
             if($q1){
                 mysqli_query($db,"UPDATE `child_counter` SET `retail_profit`=0 WHERE `uid`='$uids'");
             }
        }
    
}


function updateCartAfterLogin($db,$uid)
{
    $ip = get_userip();
    $result=mysqli_query($db, "SELECT t1.*,t2.mrp,t2.dp,t2.fp FROM cart t1 left join products t2 on t1.product_id=t2.product_id where uid='$uid' and transaction_id IS null");
    while ($r1=mysqli_fetch_assoc($result)) {
        $cart_id=$r1['cart_id'];
        $prd_id=$r1['product_id'];
        
        /*if(isset($_SESSION['franchiseid']) && !empty($_SESSION['franchiseid']))
        {
            $prd_price=$r1['mrp'];
        }
        else
        {*/
            $chk_pur=IsDistributor($db,$uid);
            if($chk_pur > 0)
            {
              $prd_price=$r1['dp'];
            }
            else
            {
                $prd_price=$r1['mrp'];
            }
        /*}*/
        $total=$r1['qty']*$prd_price;
        $qry=mysqli_query($db,"UPDATE cart SET  price='$prd_price',total='$total' WHERE cart_id='$cart_id'");
       
    }
    return true;
}

function GenerateRewardPayout($db)
{
    global $crdate;
    $sql0=mysqli_query($db,"SELECT t1.*,t2.register_date FROM `pairing` t1 left join user_id t2 on t1.uid=t2.uid WHERE t1.rank > 0 and t1.uid!=1");
    if(mysqli_num_rows($sql0) > 0)
    {
        while ($ur=mysqli_fetch_assoc($sql0)) {
            $uid=$ur['uid'];
            $bankres=GetBankDetail($db,$uid);
            
            $rank_id=$ur['rank'];
            $register_date=$ur['register_date'];
            $is_active=GetMonthlyPurchaseStatus($db,$uid);
            if(isset($is_active) && $is_active==1)
            {
                $sql11=mysqli_query($db,"SELECT * FROM `reward_history` WHERE rank_id='$rank_id' and uid='$uid'");
                if(mysqli_num_rows($sql11)==0)
                {
                    $sql=mysqli_query($db,"SELECT * FROM `reward_detail` WHERE rank_id='$rank_id'");
                    if(mysqli_num_rows($sql) > 0)
                    {
                        while ($r1=mysqli_fetch_assoc($sql))
                        {
                            $rank_id=$r1['rank_id'];
                            $gtb_pv=$r1['gtb_pv'];
                            $pamount=$r1['amount'];
                            $month=$r1['month'];
                            $rdate=date("Y-m-d",strtotime("+".$month." months",strtotime($register_date)));
                            //echo $uid."------".$rank_id."-----".$gtb_pv."--------".$pamount."---------".$month;
                            $cur_date=date("Y-m-d");
                            if(strtotime($rdate) > strtotime($cur_date))
                            {
                                if(isset($bankres) && $bankres==1)
                                {
                                    $sql1=mysqli_query($db,"SELECT uid,reward FROM `payout` WHERE uid='$uid' AND cleared=0");
                                    if(mysqli_num_rows($sql1) > 0)
                                    {
                                        $r2=mysqli_fetch_assoc($sql1);
                                        $amount=$r2['reward']+$pamount;
                                        $q2=mysqli_query($db,"UPDATE `payout` SET `reward`= $amount WHERE uid='$uid' and cleared=0");
                                    }
                                    else
                                    {
                                        $q2=mysqli_query($db,"INSERT INTO `payout` SET uid='$uid',`reward`= $pamount,`date`='$crdate'");
                                    }
                                }
                                else
                                {
                                    $sql1=mysqli_query($db,"SELECT uid,reward FROM `payout` WHERE uid='$uid' AND cleared=2");
                                    if(mysqli_num_rows($sql1) > 0)
                                    {
                                        $r2=mysqli_fetch_assoc($sql1);
                                        $amount=$r2['reward']+$pamount;
                                        $q2=mysqli_query($db,"UPDATE `payout` SET `reward`= $amount WHERE uid='$uid' and cleared=2");
                                    }
                                    else
                                    {
                                        $q2=mysqli_query($db,"INSERT INTO `payout` SET uid='$uid',`reward`= $pamount,`date`='$crdate',cleared=2");
                                    }
                                }
                                
                                if($q2)
                                {
                                    if(isset($pamount) && $pamount>0)
                                    {
                                        $uname=GetUname($db,$uid);
                                        $msg = "Reward Payout Generated: ".date('d/m/Y H:i:s')."
                                         User : $uname
                                         Pv : $gtb_pv
                                         Amount : $pamount";
                                        if(isset($msg) && $msg!='' && !empty($msg))
                                        {
                                           sendSMS($db,$uid,$msg); 
                                        }
                                    }
                                    $c[] = 1;
                                    
                                    $q4=mysqli_query($db,"INSERT INTO reward_history SET uid='$uid',rank_id='$rank_id',pv='$gtb_pv',amount='$pamount',date='$crdate'");
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
                    }
                    else
                    {
                        $c[] = 2;
                    }
                }
                else
                {
                    $c[] = 2;
                }
            }
            else
            {
                $c[] = 2;
            }
        }
    }
    else
    {
        $c[] = 2;
    }
    return $c;
}
function GetTeamUser($db,$sponsor_id)
{
    //echo "select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uname='$sponsor_id' and t1.position='$position'";
    global $all_user1;
    $all_user1=array();
    $res1 = array();
    $sql=mysqli_query($db,"select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uid='$sponsor_id'");
    if($no=mysqli_num_rows($sql) > 0)
    {
        //$r1=mysqli_fetch_assoc($sql);
        while ($r1=mysqli_fetch_assoc($sql)) {
          
            $uid=$r1['uid'];
            //$res=GetAllUserPos($db,$uid);
            //$res1 = array($uid);
            $res1[]=$uid;
            $res=GetUids($db,$uid);
            if(count($res) > 0)
            {
                $res2=getLevelid($db,$res);
                $res1=array_merge($res1,$res2);
                //$res1=array_merge($res1,$res);
            }
        }
        return $res1;
    }
    else
    {
       $new_array = array();
        return $new_array;
    }

}

function GetAllUserCountPosImport($db,$uid,$position)
{
    global $all_user;
    $all_user[]=$uid;
    echo "select * from pairing t1 where t1.parent_id='$uid' and t1.position='$position'";
   $sql=mysqli_query($db,"select * from pairing t1 where t1.parent_id='$uid' and t1.position='$position'");
   if($no=mysqli_num_rows($sql) > 0)
   {
        $r1=mysqli_fetch_assoc($sql);
        $uid1=$r1['uid'];
        //$all_user[]=$uid1;
        $res=GetAllUserCountPosImport($db,$uid1,$position);        
   }
   return $all_user;
}
function GetUserCountPosImport($db,$sponsor_id,$position)
{
    //echo "select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uname='$sponsor_id' and t1.position='$position'";
    echo "select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uname='$sponsor_id' and t1.position='$position'";
    echo "<br><br>\n\m_________________________________________";
   global $all_user;
   $all_user=array();
   $sql=mysqli_query($db,"select t1.uid from pairing t1 left join user_id t2 on t1.parent_id=t2.uid where t2.uname='$sponsor_id' and t1.position='$position'");
   if($no=mysqli_num_rows($sql) > 0)
   {
        $r1=mysqli_fetch_assoc($sql);
        $uid=$r1['uid'];
        $res=GetAllUserCountPosImport($db,$uid,$position);
        return $res;
   }
   else
   {
        $r1=mysqli_fetch_assoc(mysqli_query($db,"select uid from user_id where uname='$sponsor_id'"));
        $new_array = array($r1['uid']);
        return $new_array;
   }

}
function GetValidParentIdImport($db,$sponsor_id,$position)
{
    global $crdate;
    $parent_name='';
    $res=GetUserCountPosImport($db,$sponsor_id,$position);
    var_dump($res);echo "1____<br>\n\n";die;
    $parent_id=end($res);
    //echo "select uid,uname,paired from user_id where uname='$parent_id'";
    $sp1=mysqli_query($db,"select uid,uname,paired from user_id where uid='$parent_id'");
    $spno=mysqli_num_rows($sp1);
    if($spno > 0)
    {
        $userid=mysqli_fetch_assoc($sp1);
        $parent_id=$userid['uid'];
        $parent_name=$userid['uname'];
        $check_position1 = mysqli_query($db,"SELECT uid FROM pairing WHERE parent_id='$parent_id' AND position='$position'") or die(mysqli_error($db));
        $chkqry21 = mysqli_num_rows($check_position1);
        if($chkqry21>0){
            //echo 2;
            GetValidParentIdImport($db,$sponsor_id,$position);
        }
    }
    else
    {
        //echo 3;
        GetValidParentIdImport($db,$sponsor_id,$position);
    }
    return $parent_name;
}

function UpdateBv($db)
{
    $q1=mysqli_query($db,"SELECT * FROM `checkout`");
    while ($r1=mysqli_fetch_assoc($q1)) {
        $uid=$r1['uid'];
        $pv=$r1['pv'];
        $sr=mysqli_fetch_assoc(mysqli_query($db,"select sponsor_id,position from pairing where uid='$uid'"));
    
        $sponsor_id=$sr['sponsor_id'];
        PVCount($db,$sponsor_id,$pv);
    }
    return true;
}

// previous payout

function previouspayout($db){
    //$date=date("Y-m-d H:i");
    $sql=mysqli_query($db,"SELECT * FROM `payout`");
    while($row=mysqli_fetch_array($sql)){
        $uid=$row['uid'];
        $gtb=$row['gtb'];
        $dsb=$row['dsb'];
        $amount=$row['amount'];
        $eb=$row['eb'];
        $db1=$row['db'];
        $sdb=$row['sdb'];
        $gdb=$row['gdb'];
        $pdb=$row['pdb'];
        $cdb=$row['cdb'];
        $ddb=$row['ddb'];
        $reward=$row['reward'];
        $date=$row['date'];
        $cleared=$row['cleared'];
        $ins=mysqli_query($db,"INSERT INTO `payout_history`(`uid`,`gtb`,`amount`,`dsb`,`eb`,`db`,`sdb`,`gdb`,`pdb`,`cdb`,`ddb`,`reward`,`date`,`cleared`) VALUES('$uid','$gtb','$amount','$dsb','$eb','$db1','$sdb','$gdb','$pdb','$cdb','$ddb','$reward','$date','$cleared')");

    }
    return true;
    
}
function achieve_rank($db){
  userAchieveRank($db);
  $u=mysqli_query($db,"SELECT * FROM `user_id`");
  while($row=mysqli_fetch_array($u)){
    $uids=$row['uid'];
    $try1=mysqli_query($db,"SELECT * FROM `userachieverank` WHERE uid=$uids ORDER BY rank_id desc limit 1"); 
    $tycount=mysqli_num_rows($try1);
    $ty=mysqli_fetch_assoc($try1);
    $ids=$ty['rank_id'];
    if($tycount>0){
     $rows=mysqli_query($db,"UPDATE `pairing` SET `achieve_rank`=$ids WHERE uid=$uids");     
    }
  }  
}

function checkAppreciationFortNightly($db){

   $users=mysqli_query($db,"SELECT * FROM `child_counter`");
   while ($row=mysqli_fetch_array($users)) { 
     $uid=$row['uid'];
     $pairing=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` WHERE uid=$uid"));
     $rleft_pv=$row['rleft_pv'];
     $rright_pv=$row['rright_pv'];
     $getFN_date=$pairing['fn_date'];
     $achieve_rank=$pairing['achieve_rank'];
     $cr_date=date('Y-m-d');
     if($pairing['rleft_pv'] > 0 && $pairing['rright_pv']>0){
        $pair_rleft_bv=$row['rleft_pv']-$pairing['rleft_pv'];
        $pair_rright_bv=$row['rleft_pv']-$pairing['rright_pv'];
     }
     else{
        $pair_rleft_bv=0;
        $pair_rright_bv=0;
     }

     $fort_N_date=date('Y-m')."-18";

     if($achieve_rank==1){
        if(($rleft_pv >= 20 && $rright_pv >= 20) && ($rleft_pv <=250 && $rright_pv<=250) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 20 && $pair_rright_bv >= 20) && ($pair_rleft_bv <= 250 && $pair_rright_bv <= 250) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/20);
            $tot_rright_bv=floor($rright_pv/20);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=100;
            $appriciation_amnt=$appriciation_amt;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' WHERE uid=$uid");
         }
     }

     elseif($achieve_rank==2){
        if(($rleft_pv >= 250 && $rright_pv >= 250) && ($rleft_pv <=500 && $rright_pv<=500) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 250 && $pair_rright_bv >= 250) && ($pair_rleft_bv <= 500 && $pair_rright_bv <= 500) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/250);
            $tot_rright_bv=floor($rright_pv/250);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=2500;
            $appriciation_amnt=$appriciation_amt;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' WHERE uid=$uid");
         }
     }

     elseif($achieve_rank==3){
        if(($rleft_pv >= 500 && $rright_pv >= 500) && ($rleft_pv <=1000 && $rright_pv<=1000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 500 && $pair_rright_bv >= 500) && ($pair_rleft_bv <= 1000 && $pair_rright_bv <= 1000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/500);
            $tot_rright_bv=floor($rright_pv/500);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=5000;
            $appriciation_amnt=$appriciation_amt;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' WHERE uid=$uid");
         }
     }

     elseif($achieve_rank==4){
        if(($rleft_pv >= 1000 && $rright_pv >= 1000) && ($rleft_pv <=2500 && $rright_pv<=2500) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 1000 && $pair_rright_bv >= 1000) && ($pair_rleft_bv <= 2500 && $pair_rright_bv <= 2500) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/1000);
            $tot_rright_bv=floor($rright_pv/1000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=10000;
            $appriciation_amnt=$appriciation_amt;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' WHERE uid=$uid");
         }
     }

     elseif($achieve_rank==4){
        if(($rleft_pv >= 1000 && $rright_pv >= 1000) && ($rleft_pv <=2500 && $rright_pv<=2500) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 1000 && $pair_rright_bv >= 1000) && ($pair_rleft_bv <= 2500 && $pair_rright_bv <= 2500) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/1000);
            $tot_rright_bv=floor($rright_pv/1000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=10000;
            $appriciation_amnt=$appriciation_amt;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' WHERE uid=$uid");
         }
     }

     elseif($achieve_rank==5){
        if(($rleft_pv >= 2500 && $rright_pv >= 2500) && ($rleft_pv <=5000 && $rright_pv<=5000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 2500 && $pair_rright_bv >= 2500) && ($pair_rleft_bv <= 5000 && $pair_rright_bv <= 5000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/2500);
            $tot_rright_bv=floor($rright_pv/2500);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=25000;
            $appriciation_amnt=$appriciation_amt;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==6){
        if(($rleft_pv >= 5000 && $rright_pv >= 5000) && ($rleft_pv <=10000 && $rright_pv<=10000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 5000 && $pair_rright_bv >= 5000) && ($pair_rleft_bv <= 10000 && $pair_rright_bv <= 10000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/5000);
            $tot_rright_bv=floor($rright_pv/5000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=50000;
            $appriciation_amnt=$appriciation_amt;
            $reward='R.O.SYSTEM';
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==7){
        if(($rleft_pv >= 10000 && $rright_pv >= 10000) && ($rleft_pv <=20000 && $rright_pv<=20000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 10000 && $pair_rright_bv >= 10000) && ($pair_rleft_bv <= 20000 && $pair_rright_bv <= 20000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/10000);
            $tot_rright_bv=floor($rright_pv/10000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=100000;
            $appriciation_amnt=$appriciation_amt;
            $reward='ANDROID TABLET';
            $royalty=5000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==8){
        if(($rleft_pv >= 20000 && $rright_pv >= 20000) && ($rleft_pv <=40000 && $rright_pv<=40000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 20000 && $pair_rright_bv >= 20000) && ($pair_rleft_bv <= 40000 && $pair_rright_bv <= 40000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/20000);
            $tot_rright_bv=floor($rright_pv/20000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=20000;
            $appriciation_amnt=$appriciation_amt;
            $reward='Laptop';
            $royalty=10000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==9){
        if(($rleft_pv >= 40000 && $rright_pv >= 40000) && ($rleft_pv <=80000 && $rright_pv<=80000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 40000 && $pair_rright_bv >= 40000) && ($pair_rleft_bv <= 80000 && $pair_rright_bv <= 80000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/40000);
            $tot_rright_bv=floor($rright_pv/40000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=40000;
            $appriciation_amnt=$appriciation_amt;
            $reward='Two Wheeler';
            $royalty=20000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==10){
        if(($rleft_pv >= 80000 && $rright_pv >= 80000) && ($rleft_pv <=160000 && $rright_pv<=160000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 80000 && $pair_rright_bv >= 80000) && ($pair_rleft_bv <= 160000 && $pair_rright_bv <= 160000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/80000);
            $tot_rright_bv=floor($rright_pv/80000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=80000;
            $appriciation_amnt=$appriciation_amt;
            $reward='Alto LXI Car';
            $royalty=40000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==11){
        if(($rleft_pv >= 160000 && $rright_pv >= 160000) && ($rleft_pv <=320000 && $rright_pv<=320000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 160000 && $pair_rright_bv >= 160000) && ($pair_rleft_bv <= 320000 && $pair_rright_bv <= 320000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/160000);
            $tot_rright_bv=floor($rright_pv/160000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=160000;
            $appriciation_amnt=$appriciation_amt;
            $reward='Swift Dezire CAR';
            $royalty=80000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==12){
        if(($rleft_pv >= 320000 && $rright_pv >= 320000) && ($rleft_pv <=640000 && $rright_pv<=640000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 320000 && $pair_rright_bv >= 320000) && ($pair_rleft_bv <= 640000 && $pair_rright_bv <= 640000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/320000);
            $tot_rright_bv=floor($rright_pv/320000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=320000;
            $appriciation_amnt=$appriciation_amt;
            $reward='Hyundai Creta Car';
            $royalty=80000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==13){
        if(($rleft_pv >= 640000 && $rright_pv >= 640000) && ($rleft_pv <=1280000 && $rright_pv<=1280000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 640000 && $pair_rright_bv >= 640000) && ($pair_rleft_bv <= 1280000 && $pair_rright_bv <= 1280000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/640000);
            $tot_rright_bv=floor($rright_pv/640000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=640000;
            $appriciation_amnt=$appriciation_amt;
            $reward='Fortuner Car';
            $royalty=80000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==14){
        if(($rleft_pv >= 1280000 && $rright_pv >= 1280000) && ($rleft_pv <=2560000 && $rright_pv<=2560000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 1280000 && $pair_rright_bv >= 1280000) && ($pair_rleft_bv <= 2560000 && $pair_rright_bv <= 2560000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/1280000);
            $tot_rright_bv=floor($rright_pv/1280000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=1280000;
            $appriciation_amnt=$appriciation_amt;
            $reward='Audi A4 Car';
            $royalty=80000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
     elseif($achieve_rank==15){
        if(($rleft_pv >= 2560000 && $rright_pv >= 2560000) && ($getFN_date==NULL )){
         $FN_date1   = $fort_N_date;
         mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 1 , `fn_date`= '$FN_date1' , `rleft_pv`='$rleft_pv' , `rright_pv`='$rright_pv' WHERE uid=$uid");
         }         
         elseif(($pair_rleft_bv >= 2560000 && $pair_rright_bv >= 2560000) && $getFN_date==$cr_date){
            $tot_rleft_bv=floor($rleft_pv/2560000);
            $tot_rright_bv=floor($rright_pv/2560000);
            if($tot_rleft_bv == $tot_rright_bv){
                $total_noOF_time=$tot_rleft_bv;
            }
            elseif($tot_rleft_bv < $tot_rright_bv){
                $total_noOF_time= $tot_rright_bv;
            }
            elseif($tot_rleft_bv > $tot_rright_bv){
                $total_noOF_time= $tot_rleft_bv;
            }
            $appriciation_amt=1280000;
            $appriciation_amnt=$appriciation_amt;
            $reward='BMW Car';
            $royalty=80000*2/100;
            mysqli_query($db,"UPDATE `pairing` SET `appriciation_FN` = 2 , `appriciation_amnt` = '$appriciation_amnt' , `reward`='$reward' , `royalty`='$royalty' WHERE uid=$uid");
         }
     }
   }
}


function get_currentRankCommision($db,$rank,$uid,$pv){
 $user_active=IsDistributor($db,$uid);
 if($user_active > 0 ){   
  
 if($rank>0){   
    if($rank==1){                                              
       $amount=($pv*50)*9/100;
       $rank_name='sd'; 
    }
    elseif($rank==2){
       $amount=($pv*50)*14/100;
       $rank_name='rd';   
    }
    elseif($rank==3){
       $amount=($pv*50)*17/100;  
       $rank_name='ad'; 
    }
    elseif($rank==4){
       $amount=($pv*50)*19/100;  
       $rank_name='co'; 
    }
    elseif($rank==5){
       $amount=($pv*50)*21/100;  
       $rank_name='sco'; 
    }
    elseif($rank==6){
       $amount=($pv*50)*22.50/100;  
       $rank_name='cco'; 
    }
    elseif($rank==7){
       $amount=($pv*50)*24/100;  
       $rank_name='se'; 
    }
    elseif($rank==8){
       $amount=($pv*50)*25/100;  
       $rank_name='ge'; 
    }
    elseif($rank==9){
       $amount=($pv*50)*26/100;  
       $rank_name='pe'; 
    }
    elseif($rank==10){
       $amount=($pv*50)*27/100;  
       $rank_name='do'; 
    }
    elseif($rank==11){
       $amount=($pv*50)*28/100;  
       $rank_name='bdo'; 
    }
    elseif($rank==12){
       $amount=($pv*50)*28.50/100;  
       $rank_name='bldo'; 
    }
    elseif($rank==13){
       $amount=($pv*50)*29/100;  
       $rank_name='ra';   
    }
    elseif($rank==14){
       $amount=($pv*50)*29.50/100;  
       $rank_name='ia';   
    }
    elseif($rank==15){
       $amount=($pv*50)*30/100;  
       $rank_name='ca';   
    }
    $commision=mysqli_query($db,"SELECT $rank_name,uid FROM `ontime_rank_payout` WHERE uid='$uid'");
    if(mysqli_num_rows($commision)>0){
      $tr=mysqli_fetch_assoc($commision);
      $comm=$tr[$rank_name]+$amount;
      mysqli_query($db,"UPDATE ontime_rank_payout SET $rank_name='$comm' WHERE uid='$uid'");
    }else{
       mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',$rank_name='$amount'");
    }
  }
 }
}


function Commision_distribute($db,$uid,$pv = null,$hbt,$self_id=null){
    $r1=mysqli_fetch_assoc(mysqli_query($db,"SELECT `sponsor_id` FROM pairing  WHERE uid='$uid'"));
    $sponsor_id=$r1['sponsor_id']; 
    $query=mysqli_query($db,"SELECT * FROM pairing  WHERE uid='$uid'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);        
        // echo $uid.'--'.$rank=$row['achieve_rank']; 
        // echo "<br>";
       $rank=$row['achieve_rank'];
       // $user_active=IsDistributor($db,$uid);
       // if($user_active > 0 ){  
        if($rank==1){
          if($hbt==0){
            $amount=($pv*50)*9/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
            if(mysqli_num_rows($ontime_rank_payout)>0){
              mysqli_query($db,"UPDATE ontime_rank_payout SET sd=sd+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',sd='$amount'");
            }
          if($uid==$self_id){
            $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
          }
          else{
            $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
          }            

            $hbt=1;
          }
        }
        elseif($rank==2){
            if($hbt==0){

            }else{
             if($hbt<2){
               $hbts=1-$hbt;
               $hbt=$hbt+$hbts;            
             } 
            }
         
         if($hbt==0){
            $amount=($pv*50)*14/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET rd=rd+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',rd='$amount'");
              }
            $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=2;
         }
         elseif($hbt==1){
            $amount=($pv*50)*5/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET rd=rd+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',rd='$amount'");
              }

            $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=2;
         }
        }
        elseif($rank==3){
        
           if($hbt==0){
             
            }else{
              if($hbt<3){
                $hbts=2-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*17/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ad=ad+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ad='$amount'");
              }
            $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=3;
         }
         elseif($hbt==2){
            $amount=($pv*50)*3/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ad=ad+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ad='$amount'");
              }
            $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=3;
         }
        }
        elseif($rank==4){
         
            if($hbt==0){
             
            }else{
              if($hbt<4){
                $hbts=3-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*19/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET co=co+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',co='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=4;
         }
         elseif($hbt==3){
            $amount=($pv*50)*2/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET co=co+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',co='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=4;
         }
        }
        elseif($rank==5){
         
            if($hbt==0){
             
            }else{
              if($hbt<5){
                $hbts=4-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*21/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET sco=sco+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',sco='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=5;
         }
         elseif($hbt==4){
            $amount=($pv*50)*2/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET sco=sco+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',sco='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=5;
         }
        }
        elseif($rank==6){
         
            if($hbt==0){
             
            }else{
              if($hbt<6){
                $hbts=5-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*22.50/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET cco=cco+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',cco='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=6;
         }
         elseif($hbt==5){
            $amount=($pv*50)*1.5/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET cco=cco+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',cco='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=6;
         }
        }
        elseif($rank==7){
         
            if($hbt==0){
             
            }else{
              if($hbt<7){
                $hbts=6-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*24/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET se=se+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',se='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=7;
         }
         elseif($hbt==6){
            $amount=($pv*50)*1.5/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET se=se+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',se='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=7;
         }
        }
        elseif($rank==8){
         
            if($hbt==0){
                 
            }else{
              if($hbt<8){
                $hbts=7-$hbt;
                $hbt=$hbt+$hbts;            
              }
            }
         if($hbt==0){
            $amount=($pv*50)*25/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ge=ge+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ge='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=8;
         }
         elseif($hbt==7){
            $amount=($pv*50)*1/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ge=ge+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ge='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=8;
         }
        }
        elseif($rank==9){         
            if($hbt==0){
                 
            }else{
              if($hbt<9){
                $hbts=8-$hbt;
                $hbt=$hbt+$hbts;            
              }
            }
         if($hbt==0){
            $amount=($pv*50)*26/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET pe=pe+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',pe='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=9;
         }
         elseif($hbt==8){
            $amount=($pv*50)*1/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET pe=pe+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',pe='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=9;
         }
        }
        elseif($rank==10){
         
            if($hbt==0){
                     
            }else{
              if($hbt<10){
                $hbts=9-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*27/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET do=do+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',do='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=10;
         }
         elseif($hbt==9){
            $amount=($pv*50)*1/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET do=do+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',do='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=10;
         }
        }
        elseif($rank==11){         
            if($hbt==0){
                         
            }else{
              if($hbt<11){
                $hbts=10-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*28/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET bdo=bdo+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',bdo='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=11;
         }
         elseif($hbt==10){
            $amount=($pv*50)*1/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET bdo=bdo+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',bdo='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=11;
         }
        }
        elseif($rank==12){
         
            if($hbt==0){
                             
            }else{
              if($hbt<12){
                $hbts=11-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*28.50/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET bldo=bldo+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',bldo='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=12;
         }
         elseif($hbt==11){
            $amount=($pv*50)*0.50/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET bldo=bldo+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',bldo='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=12;
         }
        }
        elseif($rank==13){
         
            if($hbt==0){
                                 
            }else{
              if($hbt<13){
                $hbts=12-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*29/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ra=ra+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ra='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=13;
         }
         elseif($hbt==12){
            $amount=($pv*50)*0.50/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ra=ra+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ra='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=13;
         }
        }
        elseif($rank==14){
         
            if($hbt==0){
                                     
            }else{
              if($hbt<14){
                $hbts=13-$hbt;
                $hbt=$hbt+$hbts;            
             }
            }
         if($hbt==0){
            $amount=($pv*50)*29.50/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ia=ia+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ia='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=14;
         }
         elseif($hbt==13){
            $amount=($pv*50)*0.50/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ia=ia+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ia='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=14;
         }
        }
        elseif($rank==15){
         
        if($hbt==0){
                                     
        }else{
          if($hbt<15){
            $hbts=14-$hbt;
            $hbt=$hbt+$hbts;            
         }
        }
         if($hbt==0){
            $amount=($pv*50)*30/100;
              $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ca=ca+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ca='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET self_commision=self_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',self_commision='$amount',rank='$rank'");
            } 
            $hbt=15;
         }
         elseif($hbt==14){
            $amount=($pv*50)*0.50/100;
            $ontime_rank_payout=mysqli_query($db,"SELECT * FROM `ontime_rank_payout` WHERE uid='$uid'");
              if(mysqli_num_rows($ontime_rank_payout)>0){
                mysqli_query($db,"UPDATE ontime_rank_payout SET ca=ca+'$amount' WHERE uid='$uid'");
              }else{ 
                mysqli_query($db,"INSERT ontime_rank_payout SET uid='$uid',ca='$amount'");
              }
              $commision_history=mysqli_query($db,"SELECT * FROM `commision_history` WHERE uid='$uid' && status='0' && rank='$rank'");
            if(mysqli_num_rows($commision_history)>0){
              mysqli_query($db,"UPDATE commision_history SET rank_commision=rank_commision+'$amount' WHERE uid='$uid'");
            }else{
               mysqli_query($db,"INSERT commision_history SET uid='$uid',rank_commision='$amount',rank='$rank'");
            } 
            $hbt=15;
         }
        }
      //}
        if($sponsor_id==1)
        {

        }else{            
           Commision_distribute($db,$sponsor_id,$pv,$hbt);
         }
         
    }
   
   return true;
}


function Is_userActive($db,$uid,$pv){
    
    $res=0;
    $sql=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` WHERE uid='$uid'"));    
    $achieve_rank=$sql['achieve_rank'];
    if($achieve_rank==1 || $achieve_rank==2 || $achieve_rank==3){
        if($pv >= 5)
        {
            $res=1;
        }
    }
    elseif($achieve_rank==4 || $achieve_rank==5 || $achieve_rank==6){
        if($pv >= 10)
        {
            $res=1;
        }
    } 
    elseif($achieve_rank==7 || $achieve_rank==8 || $achieve_rank==9 || $achieve_rank==10 || $achieve_rank==11 || $achieve_rank==12){
        if($pv >= 25)
        {
            $res=1;
        }
    }
    elseif($achieve_rank==13 || $achieve_rank==14 || $achieve_rank==15){
       if($pv >= 50)
       {
           $res=1;
       }
    }  
    elseif($achieve_rank==0){
        if($pv >= 5)
        {
            $res=1;
        }
    }    
    
    if($res>0){
        $active_validto="15-".date('m-Y',strtotime('first day of +1 month'));
        mysqli_query($db,"UPDATE `pairing` SET `is_active`='$res',`active_validto`='$active_validto' WHERE `uid`='$uid'");
    }
    
    return $res;

}


?>