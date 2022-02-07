<?php
session_start();
$mlmid = $_SESSION['mlmid'];
include("../db_config.php");

			
list( $id , $parentid ) = explode("_", $_POST["id"] );

$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.paired = $id"));

///mlm parent id paired id
$query1 = mysqli_query( $db, "SELECT * FROM pairing WHERE uid = $mlmid" );
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

$query = mysqli_query( $db, "SELECT * FROM pairing WHERE pair_id = $parentid");
//echo "SELECT * FROM pairing WHERE pair_id = $parentid";
if(mysqli_num_rows($query)>0)
{
	$r1 = mysqli_fetch_assoc($query);
	$back_id = $r1['pair_id'];
	$parent_id = $r1["parent_id"];
	$query1 = mysqli_query( $db, "SELECT * FROM pairing WHERE uid = $parent_id" );
	if(mysqli_num_rows($query1)>0)
	{
		$r2 = mysqli_fetch_assoc($query1);
		$back_id = $r2['pair_id'];
		$parent_id = $r2["parent_id"];
	}
	else
	{
		$parent_id = $mlmid;
		$back_id = 0;
	}
}
else
{
	$parent_id = $mlmid;
	$back_id = 0;
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
	$unpay = "class = ' alert-success'";
	if(empty($q1["pin"]))
	{
		$unpay = "class = 'alert-danger'";
	}
	if($q1["paired"] == 0)
	{
		$onclick = "";
		$nofleft = $nofright = $lunpaid = $runpaid = 0;
	}
	else
	{
		$total_child_count = total_child_count( $db, $q1["paired"] );
		//list( $nofleft, $nofright) = explode("_", $total_child_count);
		$unpaid_child_count = unpaid_child_count( $db, $q1["uid"] );
		//list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
	}
	$back_id = $id;
	$onclick = "";
?>

<ul style='min-width:2000px;' >

    <li id="main_id"  data-id='<?php echo $q1["paired"];?>'>
        <a href="#" class="admin_tree" <?php echo $unpay;?>>
            <div>
                <span <?php echo $unpay;?> > <?php if($q1["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";} ?></span>
                <h3> <?php echo $q1["uname"];?> <br>  <?php echo $q1["first_name"]." ".$q1["last_name"];?></h3>
                <div class='mypopup mypopup<?php echo $q1["paired"]; ?>'>
                    <div class='col-md-12 plan-info'>
                        <div class='col-md-12 text-center'>
                            <?php echo getplanprice($db, $q1['uid']); ?>
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
                    <!-- <div class="col-md-12 invest-info">
                        <div class="col-md-6 linfest">
                            <strong>Left Unpaid</strong><br>
                            <?php //echo $lunpaid; ?>
                        </div>
                        <div class="col-md-6 rinfest">
                            <strong>Right Unpaid</strong><br>
                            <?php //echo $runpaid; ?>
                        </div>
                        <div class="clearfix"></div>
                    </div> -->
                </div>

            </div>
        </a>
        <?php
        $id = $q1["paired"];
        $back_id = $q1["paired"];

        $sql=mysqli_query($db,"SELECT * from pairing where pair_id = $id");
        if(mysqli_num_rows($sql)>0)
        {
            $row = mysqli_fetch_assoc($sql);

            echo "<ul>";
            if(!empty($row["uid"]))
            {
                $lchild = $row['uid'];
                $l = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$lchild'"));
                $puname = $l['uname'];
                $leftchild_id = $l["paired"];

                $unpay = "class = 'alert-success'";
                if(empty($l["pin"]))
                {
                    $unpay = "class = 'alert-danger'";
                }
                if($l["paired"] == 0)
                {
                    $onclick = "";
                    $nofleft = $nofright = $lunpaid = $runpaid = 0;
                }
                else
                {
                    $onclick = "onclick= 'return get_child(\"".$l["paired"]."_".$back_id."\")' ";
                    $total_child_count = total_child_count( $db, $l["paired"] );
                    //list( $nofleft, $nofright) = explode("_", $total_child_count);
                    $unpaid_child_count = unpaid_child_count( $db, $l["uid"] );
                    //list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
                }



                echo "
						<li data-id='".$l["paired"]."' >
							<a href='#' ".$onclick." ".$unpay.">
								<div class='tree-user'><div ".$unpay.">
									"; if($l["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";} echo "<h4>". $l["uname"]."<br>".$l["first_name"]." ".$l["last_name"]."</h4></div>
									<div class='mypopup mypopup".$l["paired"]."'>

									<div class='col-md-12 plan-info'>
                                                                            <div class='col-md-12 text-center'>
                                                                             ".getplanprice($db, $l['uid'])."
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
									

									<div class = 'clearfix'></div>
									</div>
								</div>
							</a>
						";

                $sql = mysqli_query($db,"SELECT * from pairing where pair_id = $leftchild_id");
                if(mysqli_num_rows($sql)>0)
                {
                    $leftrow = mysqli_fetch_assoc($sql);
                    echo "<ul>";

                    if(!empty($leftrow["lchild"]))
                    {
                        $lchild = $leftrow['lchild'];
                        $l = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$lchild'"));


                        $unpay = "class = 'alert-success'";
                        if(empty($l["pin"]))
                        {
                            $unpay = "class = 'alert-danger'";
                        }
                        if($l["paired"] == 0)
                        {
                            $onclick = "";
                            $nofleft = $nofright = $lunpaid = $runpaid = 0;
                        }
                        else
                        {
                            $onclick = "onclick= 'return get_child(\"".$l["paired"]."_".$back_id."\")' ";
                            $total_child_count = total_child_count( $db, $l["paired"] );
                            list( $nofleft, $nofright) = explode("_", $total_child_count);
                            $unpaid_child_count = unpaid_child_count( $db, $l["uid"] );
                            list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
                        }

                        echo "
								<li data-id='".$l["paired"]."' >
									<a href='#' ".$onclick." ".$unpay.">
										<div class='tree-user'><div ".$unpay.">";
                        if($l["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";}

                        echo "<h4>".$l["uname"]."<br>".$l["first_name"]." ".$l["last_name"]."</h4></div>
											<div class='mypopup mypopup".$l["paired"]."'>
											<div class='col-md-12 plan-info'>
                                                        <div class='col-md-12 text-center'>
                                                         ".getplanprice($db, $l['uid'])."
                                                        </div>
                                                        <div class='clearfix'></div>
                                            </div>
											<div class='col-md-12 nodes-info'>
												<div class='col-md-3'>
												 ".$nofleft."
												</div>
												<div class='col-md-6 midx'>
													 Nodes
												</div>
												<div class='col-md-3'>
												".$nofright."
												</div>
												<div class='clearfix'></div>
											</div>
											<div class='col-md-12 invest-info'>
												<div class='col-md-6 linfest'>
													<strong>Left Unpaid</strong><br>
														".$lunpaid."
												</div>
												
												<div class==col-md-6 rinfest'>
													<strong>Right Unpaid</strong><br>
														".$runpaid."
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
                        <a href='register.php?parentid=".$puname."&position=left'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
                    }


                    if(!empty($leftrow["rchild"]))
                    {
                        $rchild = $leftrow['rchild'];
                        $r = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$rchild'"));
                        $unpay = "class = 'alert-success'";
                        if(empty($r["pin"]))
                        {
                            $unpay = "class = 'alert-danger'";
                        }
                        if($r["paired"] == 0)
                        {
                            $onclick = "";
                            $nofleft = $nofright = $lunpaid = $runpaid = 0;
                        }
                        else
                        {
                            $onclick = "onclick= 'return get_child(\"".$r["paired"]."_".$back_id."\")' ";
                            $total_child_count = total_child_count( $db, $r["paired"] );
                            list( $nofleft, $nofright) = explode("_", $total_child_count);
                            $unpaid_child_count = unpaid_child_count( $db, $r["uid"] );

                            list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);

                        }

                        echo "<li data-id='".$r["paired"]."'  >
									<a href='#' ".$onclick." ".$unpay.">
										<div class='tree-user'><div ".$unpay.">
										 ";
                        if($r["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";}
                        echo "<h4>".$r["uname"]." <br>".$r["first_name"]." ".$r["last_name"]."</h4></div>
											   <div class='mypopup mypopup".$r["paired"]."'>
											   <div class='col-md-12 plan-info'>
                                                <div class='col-md-12 text-center'>
                                                      ".getplanprice($db, $r['uid'])."
                                                </div>
                                                  <div class='clearfix'></div>
                                            </div>
											<div class='col-md-12 nodes-info'>
												<div class='col-md-3'>
												". $nofleft ."
												</div>
												<div class='col-md-6 midx'>
													 Nodes
												</div>
												<div class='col-md-3'>
												".$nofright."
												</div>
												<div class='clearfix'></div>
											</div>
											<div class='col-md-12 invest-info'>
												<div class='col-md-6 linfest'>
													<strong>Left Unpaid</strong><br>
														".$lunpaid."
												</div>
												
												<div class==col-md-6 rinfest'>
													<strong>Right Unpaid</strong><br>
														".$runpaid."
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
                        <a href='register.php?parentid=".$puname."&position=right'>
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
                        <a href='register.php?parentid=".$puname."&position=left'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
                    echo "<li class='tree-user' >
                        <div class='alert-danger'>
                        <a href='register.php?parentid=".$puname."&position=right'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
                    echo "</ul>";
                }
                echo '<div class="clearfix"></div> </li>';

            }else{ echo "<li class='tree-user' >
	                <div class='alert-danger'>
			    	<a href='register.php?parentid=".$q1["uname"]."&position=left'>
                      <span class='add-icon'><i class='fa fa-plus'></i></span>
			  	      <h4>Add</h4>
				     </a>
				     </div>
				</li>";
            }
            if(!empty($row["rchild"]))
            {
                $rchild = $row['rchild'];
                $right_parent = $row['rchild'];

                $r = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$rchild'"));
                $puname = $r['uname'];
                $unpay = "class = 'alert-success'";
                if(empty($r["pin"]))
                {
                    $unpay = "class = 'alert-danger'";
                }
                if($r["paired"] == 0)
                {
                    $onclick = "";
                    $nofleft = $nofright = $lunpaid = $runpaid = 0;
                }
                else
                {
                    $onclick = "onclick= 'return get_child(\"".$r["paired"]."_".$back_id."\")' ";
                    $total_child_count = total_child_count( $db, $r["paired"] );
                    list( $nofleft, $nofright) = explode("_", $total_child_count);
                    $unpaid_child_count = unpaid_child_count( $db, $r["uid"] );
                    list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
                }
                $rightchild_id = $r["paired"];

                echo "
						<li data-id='".$r["paired"]."' >
							<a href='#' ".$onclick." ".$unpay.">
								<div class='tree-user'><div ".$unpay.">";
                if($r["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";}
                echo "<h4>". $r["uname"]."<br>".$r["first_name"]." ".$r["last_name"]."</h4></div>
									  <div class='mypopup mypopup".$r["paired"]."'>
									<div class='col-md-12 plan-info'>
                                                                            <div class='col-md-12 text-center'>
                                                                             ".getplanprice($db, $r['uid'])."
                                                                            </div>
                                                                            <div class='clearfix'></div>
                                                                        </div>
									<div class='col-md-12 nodes-info'>
										<div class='col-md-3'>
										 ".$nofleft."
										</div>
										<div class='col-md-6 midx'>
											 Nodes
										</div>
										<div class='col-md-3'>
										".$nofright."
										</div>
										<div class='clearfix'></div>
									</div>
									<div class='col-md-12 invest-info'>
										<div class='col-md-6 linfest'>
											<strong>Left Unpaid</strong><br>
												".$lunpaid."
										</div>
										
										<div class==col-md-6 rinfest'>
											<strong>Right Unpaid</strong><br>
												".$runpaid."
										</div>
										<div class='clearfix'></div>
									</div>
									
									<div class = 'clearfix'></div>
									</div>
								</div>
							</a>
						";

                $sql=mysqli_query($db,"SELECT * from pairing where pair_id = $rightchild_id");
                if(mysqli_num_rows($sql)>0)
                {
                    $rightrow = mysqli_fetch_assoc($sql);
                    echo "<ul>";

                    if(!empty($rightrow["lchild"]))
                    {
                        $lchild = $rightrow['lchild'];
                        $l = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$lchild'"));
                        $unpay = "class = 'alert-success'";
                        if(empty($l["pin"]))
                        {
                            $unpay = "class = 'alert-danger'";
                        }
                        if($l["paired"] == 0)
                        {
                            $onclick = "";
                            $nofleft = $nofright = $lunpaid = $runpaid = 0;
                        }
                        else
                        {
                            $onclick = "onclick= 'return get_child(\"".$l["paired"]."_".$back_id."\")' ";
                            $total_child_count = total_child_count( $db, $l["paired"] );
                            list( $nofleft, $nofright) = explode("_", $total_child_count);
                            $unpaid_child_count = unpaid_child_count( $db, $l["uid"] );
                            list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
                        }

                        echo "
								<li data-id='".$l["paired"]."' >
									<a href='#' ".$onclick." ".$unpay.">
										<div class='tree-user'><div ".$unpay.">
										";
                        if($l["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";}
                        echo "<h4>". $l["uname"]."<br>".$l["first_name"]." ".$l["last_name"]."</h4></div>
											  <div class='mypopup mypopup".$l["paired"]."'>
											<div class='col-md-12 plan-info'>
                                                                                            <div class='col-md-12 text-center'>
                                                                                             ".getplanprice($db, $l['uid'])."
                                                                                            </div>
                                                                                            <div class='clearfix'></div>
                                                                                        </div>
											<div class='col-md-12 nodes-info'>
												<div class='col-md-3'>
												 ".$nofleft."
												</div>
												<div class='col-md-6 midx'>
													 Nodes
												</div>
												<div class='col-md-3'>
												".$nofright."
												</div>
												<div class='clearfix'></div>
											</div>
											<div class='col-md-12 invest-info'>
												<div class='col-md-6 linfest'>
													<strong>Left Unpaid</strong><br>
														".$lunpaid."
												</div>
												
												<div class==col-md-6 rinfest'>
													<strong>Right Unpaid</strong><br>
														".$runpaid."
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
                        <a href='register.php?parentid=".$puname."&position=left'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
                    }


                    if(!empty($rightrow["rchild"]))
                    {
                        $rchild = $rightrow['rchild'];
                        $r = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$rchild'"));
                        $unpay = "class = 'alert-success'";
                        if(empty($r["pin"]))
                        {
                            $unpay = "class = 'alert-danger'";
                        }
                        if($r["paired"] == 0)
                        {
                            $onclick = "";
                            $nofleft = $nofright = $lunpaid = $runpaid = 0;
                        }
                        else
                        {
                            $onclick = "onclick= 'return get_child(\"".$r["paired"]."_".$back_id."\")' ";
                            $total_child_count = total_child_count( $db, $r["paired"] );
                            list( $nofleft, $nofright) = explode("_", $total_child_count);
                            $unpaid_child_count = unpaid_child_count( $db, $r["uid"] );
                            list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
                        }

                        echo "<li data-id='".$r["paired"]."' >
								<a href='#' ".$onclick." ".$unpay.">
										<div class='tree-user'><div ".$unpay.">
											"; if($r["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";}
                        echo"<h4>". $r["uname"]."<br>".$r["first_name"]." ".$r["last_name"]."</h4></div>
											 <div class='mypopup mypopup".$r["paired"]."'>
											<div class='col-md-12 plan-info'>
                                                                                            <div class='col-md-12 text-center'>
                                                                                             ".getplanprice($db, $r['uid'])."
                                                                                            </div>
                                                                                            <div class='clearfix'></div>
                                                                                        </div>
											<div class='col-md-12 nodes-info'>
												<div class='col-md-3'>
												 ".$nofleft."
												</div>
												<div class='col-md-6 midx'>
													 Nodes
												</div>
												<div class='col-md-3'>
													".$nofright."
												</div>
												<div class='clearfix'></div>
											</div>
											<div class='col-md-12 invest-info'>
												<div class='col-md-6 linfest'>
													<strong>Left Unpaid</strong><br>
														".$lunpaid."
												
												</div>
												<div class==col-md-6 rinfest'>
													<strong>Right Unpaid</strong><br>
														".$runpaid."
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
                        <a href='register.php?parentid=".$puname."&position=right'>
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
                        <a href='register.php?parentid=".$puname."&position=left'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
                    echo "<li class='tree-user' >
                        <div class='alert-danger'>
                        <a href='register.php?parentid=".$puname."&position=right'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
                    echo "</ul>";
                }
                echo '<div class="clearfix"></div> </li>';

            }else{ echo "<li class='tree-user' >
	                <div class='alert-danger'>
			    	<a href='register.php?parentid=".$q1["uname"]."&position=right'>
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
                        <a href='register.php?parentid=".$q1["uname"]."&position=left'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
            echo "<li class='tree-user' >
                        <div class='alert-danger'>
                        <a href='register.php?parentid=".$q1["uname"]."&position=right'>
                          <span class='add-icon'><i class='fa fa-plus'></i></span>
                          <h4>Add</h4>
                         </a>
                         </div>
                    </li>";
            echo "</ul>";
        }
        ?>
    </li>
</ul>
