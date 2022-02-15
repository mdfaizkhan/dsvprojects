<?php
session_start();
$mlmid = $_SESSION['mlmid'];
include("../db_config.php");

//echo $_POST["id"];    
list( $id , $parentid ) = explode("_", $_POST["id"] );
//list($parentid , $id ) = explode("_", $_POST["id"] );

//$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.paired = $id"));

$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.*,t4.uname as sname from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid left join user_id t4 on t3.sponsor_id=t4.uid where t3.uid = '$id'"));

///mlm parent id paired id
$query1 = mysqli_query( $db, "SELECT * FROM pairing WHERE uid = $mlmid" );
if(mysqli_num_rows($query1)>0)
{
    $r1 = mysqli_fetch_assoc($query1);
    $mlmpair_id = $r1['pair_id']; //mlm parent pair_id
    $q5=mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = $mlmid"));
    $endbacktree = $mlmid;
}
else
{
    $q5=mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = $mlmid"));
    $endbacktree = $mlmid;
    $mlmpair_id = 0;
}
//End of parend pared id
//echo "SELECT t1.*,t3.* from user_id t1 left join pairing t3 on t1.uid=t3.uid WHERE t1.uid = $parentid";
$query = mysqli_query( $db, "SELECT t1.*,t3.* from user_id t1 left join pairing t3 on t1.uid=t3.uid WHERE t1.uid = $id");
//echo "SELECT * FROM pairing WHERE pair_id = $parentid";
if(mysqli_num_rows($query)>0)
{
    $r1 = mysqli_fetch_assoc($query);
    $back_id = $r1['uid'];
    $parent_id = $r1["parent_id"];
    //$query1 = mysqli_query( $db, "SELECT * FROM pairing WHERE uid = $parent_id" );
    $query1 = mysqli_query( $db, "SELECT t1.*,t3.* from user_id t1 left join pairing t3 on t1.uid=t3.uid WHERE t1.uid = $parentid" );
    if(mysqli_num_rows($query1)>0)
    {
        $r2 = mysqli_fetch_assoc($query1);
        $back_id = $r2['parent_id'];
        $parent_id = $r2["parent_id"];
    }
    else
    {
        //$parent_id = $mlmid;
        //$back_id = $mlmid;
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
    $pamount=IsDistributor($db,$q1["uid"]);
    if($q1['gender']=='male'){
      if($pamount > 0 )
        {
            
            $unpay = "class = ' alert-success'";
            $style="style='color:green;'";
            $uimg="<img src='" . ACTIVEICON . "' class='user-icon'>";
            
        } else 
        {
            $unpay = "class = ' alert-danger'";
            $style="style='color:red;'";
            $uimg="<img src='" . INACTIVEICON . "' class='user-icon'>";
        }
    }
    else{
        if($pamount > 0 )
        {
            
            $unpay = "class = ' alert-success'";
            $style="style='color:green;'";
            $uimg="<img src='" . ACTIVEICON_female . "' class='user-icon'>";
            
        } else 
        {
            $unpay = "class = ' alert-danger'";
            $style="style='color:red;'";
            $uimg="<img src='" . INACTIVEICON_female . "' class='user-icon'>";
        }
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

    $onclick = "";
?>

    
    <ul style='min-width:2000px;' >

        <li id="main_id"  data-id='<?php echo $q1["paired"];?>'>
            <a href="javascript:void(0);" class="admin_tree" <?php echo $unpay;?>>
                <div>
                    <span <?php echo $unpay;?> > <?=$uimg; ?></span>
                    <!-- <i class="fa fa-dollar fa-5x " <?php //echo $style;?>></i> -->
                    <h3> <?php echo $q1["uname"];?> <br>  <?php echo $q1["first_name"]." ".$q1["last_name"];?></h3>
                    <div class='mypopup mypopup<?php echo $q1["paired"]; ?>'>
                        <div class='col-md-12 plan-info'>
                        <div class='col-md-12 text-center'>
                          
                          Date of Joining : <?php echo modifyDate($q1["register_date"],'d/m/Y'); ?><br>
                          Total Direct Count : <?php echo GetMyDownlineCount($db,$q1['uid']); ?><br>
                          
                          Total Purchase : <?php echo  GetUserTotalPurchase($db,$q1['uid']); ?><br><br>
                           <div class='col-md-6'>
    					  	  Total Left Team : <?= count(GetUserByPos($db,$q1['uid'],'L')); ?><br>
    					  	</div>
    					  	<div class='col-md-6'>
    					  	  Total Right Team : <?= count(GetUserByPos($db,$q1['uid'],'R')); ?><br>
    					  	</div>
                        </div>
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
                    
                    $lq1=mysqli_query($db,"SELECT t1.*,t2.*,t3.position,t4.uname as sname from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid left join user_id t4 on t3.sponsor_id=t4.uid where t3.parent_id = '$parent_id' and t1.uid!=1  ORDER BY t3.`position` ASC");
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
                                
                                $pamount1=IsDistributor($db,$l1["uid"]);
                                if($l1["gender"]=='male'){
                                    if($pamount1 > 0 )
                                    {
                                            $unpay = "class = ' alert-success'";
                                            $style1="style='color:green;'";
                                            $uimg1="<img src='" . ACTIVEICON . "' class='user-icon'>";
                                    } 
                                    else 
                                    {
                                        $unpay = "class = ' alert-danger'";
                                        $style1="style='color:red;'";
                                        $uimg1="<img src='" . INACTIVEICON . "' class='user-icon'>";
                                    }
                                }
                                else{
                                    if($pamount1 > 0 )
                                    {
                                            $unpay = "class = ' alert-success'";
                                            $style1="style='color:green;'";
                                            $uimg1="<img src='" . ACTIVEICON_female . "' class='user-icon'>";
                                    } 
                                    else 
                                    {
                                        $unpay = "class = ' alert-danger'";
                                        $style1="style='color:red;'";
                                        $uimg1="<img src='" . INACTIVEICON_female . "' class='user-icon'>";
                                    }
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
                               
                                    echo "
                                    <li data-id='".$l1["paired"]."' >
                                        <a href='javascript:void(0);' ".$onclick." ".$unpay.">
                                            <div class='tree-user'><div ".$unpay.">
                                                ";
                                                echo $uimg1;
                                                //echo "<i class='fa fa-dollar fa-5x '" .$style1."></i>";
                                                echo "<h4>". $l1["uname"]."<br>".$l1["first_name"]." ".$l1["last_name"]."</h4></div>
                                                <div class='mypopup mypopup".$l1["paired"]."'>
                                                <div class='col-md-12 plan-info'>
                                                    <div class='col-md-12 text-center'>
                                                          
                                                          Date of Joining : ".modifyDate($l1["register_date"],'d/m/Y')."<br>
                                                          Total Direct Count :".GetMyDownlineCount($db,$l1['uid'])."<br>
                                                         
                                                          Total Purchase :".GetUserTotalPurchase($db,$l1['uid'])."<br><br>";?>
													       <div class='col-md-6'>
                                    					  	  Total Left Team : <?= count(GetUserByPos($db,$l1['uid'],'L')); ?><br>
                                    					  	  
                                    					  	</div>
                                    					  	<div class='col-md-6'>
                                    					  	  Total Right Team : <?= count(GetUserByPos($db,$l1['uid'],'R')); ?><br>
                                    					  	 
                                    					  	</div>
                                    					  	
													 <?php echo"</div>
                                                      </div>
                                                </div>
                                            </div>
                                        </a>
                                    ";
                                    $lq=mysqli_query($db,"SELECT t1.*,t2.*,t3.position,t4.uname as sname from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid left join user_id t4 on t3.sponsor_id=t4.uid where t3.parent_id = '$npid'");
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
                                                    $pamount2=IsDistributor($db,$l["uid"]);
                                                    if($l["gender"]=='male'){
                                                        if($pamount2 > 0 )
                                                        {
                                                                $unpay = "class = ' alert-success'";
                                                                $style2="style='color:green;'";
                                                                $uimg2="<img src='" . ACTIVEICON . "' class='user-icon'>";
                                                        } 
                                                        else 
                                                        {
                                                            $unpay = "class = ' alert-danger'";
                                                            $style2="style='color:red;'";
                                                            $uimg2="<img src='" . INACTIVEICON . "' class='user-icon'>";
                                                        }
                                                    }
                                                    else{
                                                        if($pamount2 > 0 )
                                                        {
                                                                $unpay = "class = ' alert-success'";
                                                                $style2="style='color:green;'";
                                                                $uimg2="<img src='" . ACTIVEICON_female . "' class='user-icon'>";
                                                        } 
                                                        else 
                                                        {
                                                            $unpay = "class = ' alert-danger'";
                                                            $style2="style='color:red;'";
                                                            $uimg2="<img src='" . INACTIVEICON_female . "' class='user-icon'>";
                                                        }
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
                                                    
                                                    echo "
                                                        <li data-id='".$l["paired"]."' >
                                                            <a href='javascript:void(0);' ".$onclick." ".$unpay.">
                                                                <div class='tree-user'><div ".$unpay.">";
                                                                    echo $uimg2;
                                                                      //echo "<i class='fa fa-dollar fa-5x '" .$style1."></i>";
                                                                      echo "<h4>".$l["uname"]."<br>".$l["first_name"]." ".$l["last_name"]."</h4></div>
                                                                    <div class='mypopup mypopup".$l["paired"]."'>
                                                                    <div class='col-md-12 plan-info'>   
                                                                        <div class='col-md-12 text-center'>
                                                                              
                                                                              Date of Joining : ".modifyDate($l["register_date"],'d/m/Y')."<br>
                                                                              Total Direct Count :".GetMyDownlineCount($db,$l['uid'])."<br>
                                                                              
                                                                              Total Purchase :".GetUserTotalPurchase($db,$l['uid'])."<br><br>";?>
													       <div class='col-md-6'>
                                    					  	  Total Left Team : <?= count(GetUserByPos($db,$l['uid'],'L')); ?><br>
                                    					  	  
                                    					  	</div>
                                    					  	<div class='col-md-6'>
                                    					  	  Total Right Team : <?= count(GetUserByPos($db,$l['uid'],'R')); ?><br>
                                    					  	 
                                    					  	</div>
                                    					  	
													 <?php echo"</div>
                                                                          </div>
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
                                                      <span class='add-icon'><img src='../assets/images/plus.png' class='user-icon'></span>
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
                                                  <span class='add-icon'><img src='../assets/images/plus.png' class='user-icon'></span>
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
                                              <span class='add-icon'><img src='../assets/images/plus.png' class='user-icon'></span>
                                              <h4>Add</h4>
                                             </a>
                                             </div>
                                        </li>
                                        <li class='tree-user' >
                                            <div class='alert-danger'>
                                            <a href='addusers?parentid=".$puname."&pos=R'>
                                              <span class='add-icon'><img src='../assets/images/plus.png' class='user-icon'></span>
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
                                  <span class='add-icon'><img src='../assets/images/plus.png' class='user-icon'></span>
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
                          <span class='add-icon'><img src='../assets/images/plus.png' class='user-icon'></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>
                    <li class='tree-user' >
                        <div class='alert-danger'>
                        <a href='addusers?parentid=".$q1["uname"]."&pos=R'>
                          <span class='add-icon'><img src='../assets/images/plus.png' class='user-icon'></span>
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

