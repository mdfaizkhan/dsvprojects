<?php include("header.php");?>
 <link href="../genealogy/treeview.css" rel="stylesheet">
<!-- 
	MIDDLE 
-->
<style>
	.tree-user{
        position: relative;
        min-height: 115px;
	}
	.alert-info, .Legends {
		background-color: #fff;
	}
	.alert-info-box
	{
		background-color: #5bc0de;
		width:35px;
		border :1px;
	}
	.alert-warning, .Legends {
		background-color: #fff;
	}
	.alert-warning-box
	{
		background-color: #efb73bf2;
		width:35px;
		border :1px;
	}
	.alert-success-box
	{
		background-color: #41a941;
		width:35px;
		border :1px;
	}
	.alert-danger-box
	{
		background-color: #ff7300;
		width:35px;
		border :1px;
	}
	.alert-info .user-icon {
		background: #efb73bf2;
	    border-radius: 50%;
	    width:   41px;
	}
	.alert-warning .user-icon {
		background: #efb73bf2;
	    border-radius: 50%;
	    width:   41px;
	}
	.alert-danger .user-icon {
		background: #ff7300;
	    border-radius: 50%;
	    width:   41px;
	}
	.alert-success .user-icon {
		background: #41a941;
	    border-radius: 50%;
	    width:   41px;
	}
	.mypopup{
	    display: none;
		position: absolute;
		top: 60px;
		left: 50px;
		width: 225px;
		z-index: 999;
	}
	.tree-user:hover .mypopup, .admin_tree:hover .mypopup{
		display: block !important;
	}
	.admin_tree{
	    position: relative;
        min-height: 115px;
	}
	.tree li a, .tree li a:hover, .tree-user .alert-danger, .tree-user .alert-success{
	    border-color: transparent !important;
	    background: transparent !important;
	}
	.add-icon{
	    border-radius: 50%;
        background: #ff7300;
        font-size: 20px;
        width: 41px;
        height: 41px;
        display: block;
        padding: 7px 14px;
	}
	.alert-warning
	{
		color:#ffe34c;
	}
</style>
<section id="middle">
	<header id="page-header">
		<h1>Downline</h1>  
	</header>
	<div id="content" class="padding-20">
		<div class="col-md-12">
			Here you can view all of your genealogy network tree, you can view your downline network also.<br>
			If you want to view your downline's network, just click on their box and you will get the information about their networking
			<div class='clearfix'></div>
		</div>
        <div class='clearfix'></div>
        <br>
        <div class="col-md-12">
            <div class="col-md-3" style="padding:0px">
                <div class="form-group">
                    <input type="text" class="form-control" id="sponserid" placeholder="UserID">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-info btn-block btn-submit" id="SearchID">Search</button>
            </div>
        </div>
		<div class='clearfix'></div>
		
		<div class="col-md-12">
			<div class="pan-container">
				<div id='treeview-pan' class='pan-wrap'>
				<!-- <div  class='row' style="overflow-x:scroll;"> -->
				   <div class="tree" id="genealogy_id">
						<?php
						//echo "SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = $mlmid";
						$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = $mlmid"));
						?>		   
						
						<?php
						$pamount=getPinAmount($db,$q1["uid"]);
						if($q1["status"] == 1)
			            {
			               if($pamount > 0 )
							{
								$isroyal=IsPlanRoyaltyBinary($db,$q1["uid"]);
								if($isroyal==1)
								{
									$unpay = "class = ' alert-warning'";
								}
								else
								{
									$unpay = "class = ' alert-success'";
								}
							} else 
							{
								$unpay = "class = ' alert-danger'";
							}
			            }
			            else
			            {
			                $unpay = "class = ' alert-warning'";
			            }
			            
						if($q1["paired"] == 0)
						{
							$onclick = "";
							$nofleft = $nofright = $lunpaid = $runpaid = 0;
							$total_child_count = 0;
						}
						else
						{
							$total_child_count = total_child_count( $db, $q1["uid"] );
							//list( $nofleft, $nofright) = explode("_", $total_child_count);
							$unpaid_child_count = unpaid_child_count( $db, $q1["uid"] );
							//list( $lunpaid, $runpaid) = explode("_", $unpaid_child_count);
						}
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
					                        <div class='clearfix'></div>
										</div>
					                    <div class='col-md-12 nodes-info'>
											<!-- <div class='col-md-3'>
											 <?php //echo $nofleft; ?>
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
								//$back_id = $q1["paired"];
								$back_id = $q1["uid"];
								$parent_id=$q1["uid"];
									
									echo "<ul>";
									
										//$uid1 = $row['parent_id'];
										//echo "SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t3.parent_id = '$parent_id'";
										$lq1=mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t3.parent_id = '$parent_id' and t1.uid!=1");
									if(mysqli_num_rows($lq1) > 0)
									{
									    $total_num_rows = mysqli_num_rows($lq1);
									    
					                	while ($l1 = mysqli_fetch_assoc($lq1))
					                	{
					                		
						                    $puname = $l1['uname'];
											$leftchild_id = $l1["paired"];
											$npid = $l1["uid"];
											
											$pamount1=getPinAmount($db,$l1["uid"]);
											if($l1["status"] == 1)
								            {
								               if($pamount1 > 0 )
												{
													$isroyal1=IsPlanRoyaltyBinary($db,$l1["uid"]);
													if($isroyal1==1)
													{
														$unpay = "class = ' alert-warning'";
													}
													else
													{
														$unpay = "class = ' alert-success'";
													}
												} else 
												{
													$unpay = "class = ' alert-danger'";
												}
								            }
								            else
								            {
								                $unpay = "class = ' alert-warning'";
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
															"; if($l1["gender"]=="male"){ echo "<img src='../assets/images/male.png' class='user-icon'>"; }else{ echo "<img src='../assets/images/female.png' class='user-icon'>";} echo "<h4>". $l1["uname"]."<br>".$l1["first_name"]." ".$l1["last_name"]."</h4></div>
															<div class='mypopup mypopup".$l1["paired"]."'>

															<div class='col-md-12 plan-info'>
						                                                <div class='col-md-12 text-center'>
						                                                 ".getplanprice($db, $l1['uid'])."
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
												echo "<ul>";
												$lq=mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid where t3.parent_id = '$npid'");
												if(mysqli_num_rows($lq) > 0)
												{	
													
													
													if(!empty($npid))
													{
														//$uid1 = $leftrow['leftchild_id'];
														//$l = mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = '$uid1'"));
														
							                			while ($l = mysqli_fetch_assoc($lq)) {
														
															$pamount2=getPinAmount($db,$l["uid"]);
															if($l["status"] == 1)
												            {
												               if($pamount2 > 0 )
																{
																	$isroyal2=IsPlanRoyaltyBinary($db,$l["uid"]);
																	if($isroyal2==1)
																	{
																		$unpay = "class = ' alert-warning'";
																	}
																	else
																	{
																		$unpay = "class = ' alert-success'";
																	}
																} else 
																{
																	$unpay = "class = ' alert-danger'";
																}
												            }
												            else
												            {
												                $unpay = "class = ' alert-warning'";
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
																				
																				<div class='col-md-6 midx'>
																					 Nodes
																				</div>
																				<div class='col-md-6'>
																				".$total_child_count1."
																				</div>
																				<div class='clearfix'></div>
																			</div>
																			
																			
																			<div class = 'clearfix'></div>
																			</div>
																		</div>
																	</a>
																<div class = 'clearfix'></div></li>";
														}
														echo "<li class='tree-user' >
									                        <div class='alert-danger'>
									                        <a href='addusers?parentid=".$puname."'>
									                          <span class='add-icon'><i class='fa fa-plus'></i></span>
									                          <h4>Add</h4>
									                         </a>
									                         </div>
									                    </li>";
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
												echo '<div class="clearfix"></div> </li>';
										}
										echo "<li class='tree-user' style='min-width: 133px;' >
							                <div class='alert-danger'>
									    	<a href='addusers?parentid=".$q1["uname"]."'>
						                      <span class='add-icon'><i class='fa fa-plus'></i></span>
									  	      <h4>Add</h4>
										     </a>
										     </div>
										</li>";	
									}else{ echo "<li class='tree-user' style='min-width: 133px;' >
						                <div class='alert-danger'>
								    	<a href='addusers?parentid=".$q1["uname"]."'>
					                      <span class='add-icon'><i class='fa fa-plus'></i></span>
								  	      <h4>Add</h4>
									     </a>
									     </div>
									</li>";
					              	}
									
									echo "</ul>";
								?>
							</li>
						</ul>
						<div class='clearfix'></div>
					</div>
					<div class='clearfix'></div>
				</div>
				<div class='clearfix'></div>
			</div>
			<div class='clearfix'></div>
			<div id='tree-loading'>
				<h2 style="text-align: center;padding-top: 40px;">LOADING YOUR NETWORK TREE</h2>
				<div class='clearfix'></div>
			</div>
			<div class='clearfix'></div>
		</div>
	</div>
	<div class='clearfix'></div>
	<div id="content1" class="padding-20">
		<div class='col-md-6'>
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">How to use ?</h3>
				</div>
				<div class="panel-body">
					<p>On this feature you can see all of the members listed on your network, ranging from the sponsored person and existing members under you.</p>
					<p>
						1. Hover Your mouse into the tree chart<br>
						2. You can drag the chart so you can extend your diagram view<br>
						3. If you want to see your downline's network, just click on their box and you will get the information
					</p>
				</div>
				<div class='clearfix'></div>
			</div>
		</div>
		<div class='clearfix'></div>
	</div>
</section>
			<!-- /MIDDLE -->

<?php include("footer.php");?>
<!-- Global JS -->
        <script src="../genealogy/jquery.panzoom.js"></script>
        <script src="../genealogy/jquery.mousewheel.js"></script>
        <script src="../genealogy/treeview.js"></script>
