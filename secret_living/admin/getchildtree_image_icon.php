<?php
session_start();
$mlmid = $_SESSION['mlmid'];
include("../db_config.php");

/*echo $_POST["id"];  
echo "<br></br>";*/	
list( $id , $parentid ) = explode("_", $_POST["id"] );
//list($parentid , $id ) = explode("_", $_POST["id"] );

//$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.paired = $id"));
$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t3.uid = '$id'"));

///mlm parent id paired id
$query1 = mysqli_query( $db, "SELECT * FROM pairing WHERE uid = $parentid" );
if(mysqli_num_rows($query1)>0)
{
	$r1 = mysqli_fetch_assoc($query1);
	$mlmpair_id = $r1['pair_id']; //mlm parent pair_id
	$q5=mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = $mlmid"));
	$endbacktree = $q5["paired"];
}
else
{
	$q5=mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = $mlmid"));
	$endbacktree = $q5["paired"];
	$mlmpair_id = 0;
}
//End of parend pared id

$query = mysqli_query( $db, "SELECT t1.*,t3.* from user_id t1 left join pairing t3 on t1.uid=t3.uid WHERE t1.uid = $parentid");
//echo "SELECT * FROM pairing WHERE pair_id = $parentid";
if(mysqli_num_rows($query)>0)
{
	$r1 = mysqli_fetch_assoc($query);
	$back_id = $r1['uid'];
	$parent_id = $r1["parent_id"];
    //$query1 = mysqli_query( $db, "SELECT * FROM pairing WHERE uid = $parent_id" );
    //echo "SELECT t1.*,t3.* from user_id t1 left join pairing t3 on t1.uid=t3.uid WHERE t1.uid = $parent_id";
	$query1 = mysqli_query( $db, "SELECT t1.*,t3.* from user_id t1 left join pairing t3 on t1.uid=t3.uid WHERE t1.uid = $parent_id" );
	if(mysqli_num_rows($query1)>0)
	{
		$r2 = mysqli_fetch_assoc($query1);
		$back_id = $r2['uid'];
		$parent_id = $r2["parent_id"];
	}
	else
	{
		$parent_id = $mlmid;
		$back_id = $mlmid;
	}
}
else
{
	$parent_id = $mlmid;
	$back_id = $mlmid;
}	
//echo "MLMID".$mlmid." parent:".$parent_id." Back_id:".$back_id." mypairid:".$mlmpair_id." id:".$id." End tree:".$endbacktree;	
?>
<?php if($id == $endbacktree)
{
}
else
{
?>
<a href="" class=""  onclick= 'return get_child("<?php echo $parentid."_".$back_id; ?>")'> <i class="fa fa-arrow-left fa-3x"></i> </a>
<?php 
} ?>
<?php
	$pamount=getPinAmount($db,$q1["uid"]);
        if($q1["status"] == 1)
        {
            if($pamount > 0 )
            {
                
                $unpay = "class = ' alert-success'";
                
            } else 
            {
                $unpay = "class = ' alert-info'";
            }
        }
        else if($q1['pin'] == ''){
            $unpay = "class = ' alert-danger'";
        }
        else
        {
            $unpay = "class = ' alert-primary'";
        }
    
	if($q1["paired"] == 0)
	{
		$onclick = "";
		$nofleft = $nofright = $lunpaid = $runpaid = 0;
	}
	else
	{
		$total_child_count = total_child_count( $db, $q1["uid"] );
		//list( $nofleft, $nofright) = explode("_", $total_child_count);
		$unpaid_child_count = unpaid_child_count( $db, $q1["uid"] );
		//list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
	}
	$back_id = $id;
	$onclick = "";
    
    $left_users = GetUserByPos($db,$q1['uid'],'L');
    $right_users = GetUserByPos($db,$q1['uid'],'R');

    $left_green_id = getGreenId($left_users);
    $right_green_id = getGreenId($right_users);

    $left_red_id = getRedId($left_users);
    $right_red_id = getRedId($right_users);

    $left_user_business = get_total_businesss($left_users);
    $right_user_business = get_total_businesss($right_users);
    $onclick = "";
?>

    
    <ul style='min-width:2000px;' >

        <li id="main_id"  data-id='<?php echo $q1["paired"];?>'>
            <a href="javascript:void(0);" class="admin_tree" <?php echo $unpay;?>>
                <div>
                    <span <?php echo $unpay;?> > <?php if($q1["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";} ?></span>
                    <h3> <?php echo $q1["uname"];?> <br>  <?php echo $q1["first_name"]." ".$q1["last_name"];?></h3>
                    <div class='mypopup mypopup<?php echo $q1["paired"]; ?>'>
                        <div class='col-md-12 plan-info'>
                            <div class='col-md-12 text-center'>
                                <?php echo getplanprice($db, $q1['uid']); ?>
                            </div>
                            <div class="col-md-12">
                                Left Business : <?php echo $left_user_business;?>
                            </div>
                            <div class="col-md-12">
                                Right Business : <?php  echo $right_user_business; ?>
                            </div>
                            <div class='clearfix'></div>
                        </div>
                        <div class='col-md-12 nodes-info'>
                            <!-- <div class='col-md-3'>
                                <?php //echo $total_child_count; ?>
                            </div> -->
                            <div class='col-md-6 midx'>
                                Nodes
                            </div>
                            <div class='col-md-6'>
                                <?php echo $total_child_count; ?>
                            </div>
                            <div class='clearfix'></div>
                        </div>
                        <div class='col-md-12 invest-info'>
                            <div class='col-md-6 linfest'>
                                <strong>Left Blue Count</strong><br>
                                <?php echo $left_red_id; ?>
                            </div>
                            <div class='col-md-6'>
                                <strong>Right Blue Count</strong><br>
                                <?php echo $right_red_id; ?>
                            </div>
                            <div class='clearfix'></div>
                        </div>
                        <div class='col-md-12 nodes-info'>
                            <div class='col-md-6 linfest'>
                                <strong>Left Green Count</strong><br>
                                <?php echo $left_green_id; ?>
                            </div>
                            <div class='col-md-6'>
                                <strong>Right Green Count</strong><br>
                                <?php echo $right_green_id; ?>
                            </div>
                            <div class='clearfix'></div>
                        </div>
                    </div>

                </div>
            </a>
            <?php
                $id = $q1["paired"];
                //$back_id = $q1["paired"];
                $back_id = $q1["uid"];
                $parent_id=$q1["uid"];
                    
                    echo "<ul>";
                    
                    
                    //$uid1 = $row['parent_id'];
                    //echo "SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t3.parent_id = '$parent_id'";
                    
                    $lq1=mysqli_query($db,"SELECT t1.*,t2.*,t3.position from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t3.parent_id = '$parent_id' and t1.uid!=1  ORDER BY t3.`position` ASC");
                    $label_2nd = mysqli_num_rows($lq1);
                    if($label_2nd>0)
                    {
                        $arr1=array("L"=>"","R"=>"");
                         while ($l1 = mysqli_fetch_assoc($lq1))
                        {
                            $arr1[$l1['position']]=$l1;
                        }
                        $i=0;
                        foreach ($arr1 as $key => $l1)
                        {
                            if(!empty($l1))
                            {
                                $puname = $l1['uname'];
                                $leftchild_id = $l1["paired"];
                                $npid = $l1["uid"];
                                
                                $pamount1=getPinAmount($db,$l1["uid"]);

                                if($l1["status"] == 1)
                                {
                                   if($pamount1 > 0 )
                                    {
                                            $unpay = "class = ' alert-success'";
                                    } 
                                    else 
                                    {
                                        $unpay = "class = ' alert-info'";
                                    }
                                }
                                else if($l1['pin'] == ''){
                                    $unpay = "class = ' alert-danger'";
                                }
                                else if($l1["status"] == 0)
                                {
                                    $unpay = "class = ' alert-primary'";
                                }
                                else
                                {
                                    $unpay = "class = ' alert-info'";
                                }
                                
                                if($l1["paired"] == 0)
                                {
                                    $onclick = "";
                                    $nofleft = $nofright = $lunpaid = $runpaid = 0;
                                }
                                else
                                {
                                    $onclick = "onclick= 'return get_child(\"".$l1["uid"]."_".$back_id."\")' ";
                                    $total_child_count = total_child_count( $db, $l1["uid"] );
                                    //list( $nofleft, $nofright) = explode("_", $total_child_count);
                                    $unpaid_child_count = unpaid_child_count( $db, $l1["uid"] );
                                    //list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
                                }
                                $left_users1 = GetUserByPos($db,$l1['uid'],'L');
                                $right_users1 = GetUserByPos($db,$l1['uid'],'R');

                                $left_green_id1 = getGreenId($left_users1);
                                $right_green_id1 = getGreenId($right_users1);

                                $left_red_id1 = getRedId($left_users1);
                                $right_red_id1 = getRedId($right_users1);

                                $left_user_business1 = get_total_businesss($left_users1);
                                $right_user_business1 = get_total_businesss($right_users1);
                                    echo "
                                    <li data-id='".$l1["paired"]."' >
                                        <a href='javascript:void(0);' ".$onclick." ".$unpay.">
                                            <div class='tree-user'><div ".$unpay.">
                                                "; if($l1["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";} echo "<h4>". $l1["uname"]."<br>".$l1["first_name"]." ".$l1["last_name"]."</h4></div>
                                                <div class='mypopup mypopup".$l1["paired"]."'>

                                                <div class='col-md-12 plan-info'>
                                                        <div class='col-md-12 text-center'>
                                                             ".getplanprice($db, $l1['uid'])."
                                                            </div>
                                                             <div class='col-md-12'>
                                                                Left Business : ".$left_user_business1."
                                                            </div>
                                                            <div class='col-md-12'>
                                                                Right Business : ".$right_user_business1."
                                                            </div>
                                                            <div class='clearfix'></div>
                                                        </div>
                                                        <div class='col-md-12 nodes-info'>
                                                            
                                                            <div class='col-md-6 midx'>
                                                                 Nodes
                                                            </div>
                                                            <div class='col-md-6'>
                                                             ".$total_child_count."
                                                            </div>
                                                            <div class='clearfix'></div>
                                                        </div>
                                                        <div class='col-md-12 invest-info'>
                                                            <div class='col-md-6 linfest'>
                                                                <strong>Left Blue Count</strong><br>".$left_red_id1."
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <strong>Right Blue Count</strong><br>".$right_red_id1."
                                                            </div>
                                                            <div class='clearfix'></div>
                                                        </div>
                                                        <div class='col-md-12 nodes-info'>
                                                            <div class='col-md-6 linfest'>
                                                                <strong>Left Green Count</strong><br>".$left_green_id1."
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <strong>Right Green Count</strong><br>".$right_green_id1."
                                                            </div>
                                                            <div class='clearfix'></div>
                                                        </div>
                                                
                                                <div class = 'clearfix'></div>
                                                </div>
                                            </div>
                                        </a>
                                    ";
                                    $lq=mysqli_query($db,"SELECT t1.*,t2.*,t3.position from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t3.parent_id = '$npid'");
                                    $lebel_3rd = mysqli_num_rows($lq);
                                    if($lebel_3rd > 0)
                                    {   
                                        echo "<ul>";
                                        
                                        if(!empty($npid))
                                        {
                                            //$uid1 = $leftrow['leftchild_id'];
                                            //$l = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$uid1'"));
                                            $arr2=array("L"=>"","R"=>"");
                                            while ($l = mysqli_fetch_assoc($lq))
                                            {
                                                $arr2[$l['position']]=$l;
                                            }
                                            $i=0;
                                            foreach ($arr2 as $key1 => $l)
                                            {
                                                if(!empty($l))
                                                {
                                                    $pamount2=getPinAmount($db,$l["uid"]);

                                                    if($l["status"] == 1)
                                                    {
                                                        if($pamount2 > 0 )
                                                        {
                                                            
                                                        $unpay = "class = ' alert-success'";
                                                           
                                                        } 
                                                        else 
                                                        {
                                                            $unpay = "class = ' alert-info'";
                                                        }
                                                    }
                                                    else if($l['pin'] == ''){
                                                        $unpay = "class = ' alert-danger'";
                                                    }
                                                    else if($l["status"] == 0)
                                                    {
                                                        $unpay = "class = ' alert-primary'";
                                                    }
                                                    else
                                                    {
                                                        $unpay = "class = ' alert-info'";
                                                    }
                                                    
                                                    if($l["paired"] == 0)
                                                    {
                                                        $onclick = "";
                                                        $nofleft = $nofright = $lunpaid = $runpaid = 0;
                                                    }
                                                    else
                                                    {
                                                        $onclick = "onclick= 'return get_child(\"".$l["uid"]."_".$back_id."\")' ";
                                                        $total_child_count1 = total_child_count( $db, $l["uid"] );
                                                        //list( $nofleft, $nofright) = explode("_", $total_child_count);
                                                        $unpaid_child_count = unpaid_child_count( $db, $l["uid"] );
                                                        //list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
                                                    }
                                                    $left_users2 = GetUserByPos($db,$l['uid'],'L');                     
                                                    $right_users2 = GetUserByPos($db,$l['uid'],'R');


                                                    $left_green_id2 = getGreenId($left_users2);
                                                    $right_green_id2 = getGreenId($right_users2);

                                                    $left_red_id2 = getRedId($left_users2);
                                                    $right_red_id2 = getRedId($right_users2);

                                                     $left_user_business2 = get_total_businesss($left_users2);
                                                    $right_user_business2 = get_total_businesss($right_users2);
                                                    echo "
                                                        <li data-id='".$l["paired"]."' >
                                                            <a href='javascript:void(0);' ".$onclick." ".$unpay.">
                                                                <div class='tree-user'><div ".$unpay.">";
                                                                    if($l["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";}

                                                                      echo "<h4>".$l["uname"]."<br>".$l["first_name"]." ".$l["last_name"]."</h4></div>
                                                                    <div class='mypopup mypopup".$l["paired"]."'>
                                                                    <div class='col-md-12 plan-info'>
                                                                                <div class='col-md-12 text-center'>
                                                                                 ".getplanprice($db, $l['uid'])."
                                                                                </div>
                                                                                <div class='col-md-12'>
                                                                                    Left Business : ".$left_user_business2."
                                                                                </div>
                                                                                <div class='col-md-12'>
                                                                                    Right Business : ".$right_user_business2."
                                                                                </div>
                                                                                <div class='clearfix'></div>
                                                                    </div>
                                                                    <div class='col-md-12 nodes-info'>
                                                                        
                                                                        <div class='col-md-6 midx'>
                                                                             Nodes
                                                                        </div>
                                                                        <div class='col-md-6'>
                                                                        ".$total_child_count1."
                                                                        </div>
                                                                        <div class='clearfix'></div>
                                                                    </div>
                                                                    <div class='col-md-12 invest-info'>
                                                                        <div class='col-md-6 linfest'>
                                                                            <strong>Left Blue Count</strong><br>".$left_red_id1."
                                                                        </div>
                                                                        <div class='col-md-6'>
                                                                            <strong>Right Blue Count</strong><br>".$right_red_id1."
                                                                        </div>
                                                                        <div class='clearfix'></div>
                                                                    </div>
                                                                    <div class='col-md-12 nodes-info'>
                                                                        <div class='col-md-6 linfest'>
                                                                            <strong>Left Green Count</strong><br>".$left_green_id1."
                                                                        </div>
                                                                        <div class='col-md-6'>
                                                                            <strong>Right Green Count</strong><br>".$right_green_id1."
                                                                        </div>
                                                                        <div class='clearfix'></div>
                                                                    </div>
                                                                    <div class = 'clearfix'></div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        <div class = 'clearfix'></div></li>";
                                                }
                                                else
                                                {
                                                    echo "<li class='tree-user' >
                                                    <div class='alert-danger'>
                                                    <a href='addusers?parentid=$puname&pos=$key1'>
                                                      <span class='add-icon'><i class='fa fa-plus'></i></span>
                                                      <h4>Add</h4>
                                                     </a>
                                                     </div>
                                                    </li>";
                                                }
                                            }
                                            if($lebel_3rd<2){
                                                 /*echo "<li class='tree-user' >
                                                    <div class='alert-danger'>
                                                    <a href='addusers?parentid=".$puname."'>
                                                      <span class='add-icon'><i class='fa fa-plus'></i></span>
                                                      <h4>Add</h4>
                                                     </a>
                                                     </div>
                                                </li>";*/
                                            }
                                        }
                                        else
                                        {
                                            echo "<li class='tree-user' >
                                                <div class='alert-danger'>
                                                <a href='addusers?parentid=".$puname."'>
                                                  <span class='add-icon'><i class='fa fa-plus'></i></span>
                                                  <h4>Add</h4>
                                                 </a>
                                                 </div>
                                            </li>";
                                        }
                                       
                                        echo "</ul>";
                                    }
                                    else
                                    {
                                        echo "<ul>";
                                        echo "<li class='tree-user' >
                                            <div class='alert-danger'>
                                            <a href='addusers?parentid=".$puname."&pos=L'>
                                              <span class='add-icon'><i class='fa fa-plus'></i></span>
                                              <h4>Add</h4>
                                             </a>
                                             </div>
                                        </li>
                                        <li class='tree-user' >
                                            <div class='alert-danger'>
                                            <a href='addusers?parentid=".$puname."&pos=R'>
                                              <span class='add-icon'><i class='fa fa-plus'></i></span>
                                              <h4>Add</h4>
                                             </a>
                                             </div>
                                        </li>
                                        ";
                                        echo "</ul>";
                                    }
                                    echo '<div class="clearfix"></div> </li>';
                            }
                            else
                            {
                                echo "<li class='tree-user' >
                                <div class='alert-danger'>
                                <a href='addusers?parentid=".$q1["uname"]."&pos=$key'>
                                  <span class='add-icon'><i class='fa fa-plus'></i></span>
                                  <h4>Add</h4>
                                 </a>
                                 </div>
                                </li>";
                            }
                            $i++;
                        } 
                        if($label_2nd<2){
                            /*echo "<li class='tree-user' >
                                <div class='alert-danger'>
                                <a href='addusers?parentid=".$q1["uname"]."'>
                                  <span class='add-icon'><i class='fa fa-plus'></i></span>
                                  <h4>Add</h4>
                                 </a>
                                 </div>
                                </li>";*/
                        }  
                    }else{ echo "<li class='tree-user' >
                        <div class='alert-danger'>
                        <a href='addusers?parentid=".$q1["uname"]."&pos=L'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>
                    <li class='tree-user' >
                        <div class='alert-danger'>
                        <a href='addusers?parentid=".$q1["uname"]."&pos=R'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>
                    ";
                    }
                    
                    echo "</ul>";
                ?>
        </li>
    </ul>
