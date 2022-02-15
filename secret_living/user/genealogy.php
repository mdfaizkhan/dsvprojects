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
		background-color: #0000FF;
		width:35px;
		border :1px;
	}
	.alert-warning, .Legends {
		background-color: #fff;
	}

	.alert-warning-box
	{
		background-color: #ffe34c;
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
		
		/*background-color: #ff7300;*/
		background-color: #0cfb29a3;
		width:35px;
		border :1px;
	}
	.alert-primary-box
	{
		background: black;
		width:35px;
		color : #FFF;
		border :1px;
	}
	.alert-info .user-icon {
		background: #0000FF;
	    border-radius: 50%;
	    width:   41px;
	}
	.alert-warning .user-icon {
		background: #ffe34c;
	    border-radius: 50%;
	    width:   41px;
	}
	.alert-danger .user-icon {
		background: #0cfb29a3;
	    border-radius: 50%;
	    width:   41px;
	}
	.alert-success .user-icon {
		background: #41a941;
	    border-radius: 50%;
	    width:   41px;
	}
	.alert-primary .user-icon {
		background: black;
	    border-radius: 50%;
	    color: #fff;
	    width:   41px;
	}
	.mypopup{
	    display: none;
		position: absolute;
		top: 60px;
		left: 50px;
		width: 470px;
		z-index: 999;
		border-radius: 15px;
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
        padding: 1px -1px;
	}
	.alert-warning
	{
		color:#ffe34c;
	}
	.plan-info,.nodes-info,.invest-info
	{
	    background-color: #3a3f51;
	    padding: 21px;
	    color: white;
	}
	.fa-dollar
	{
		font-weight: bolder;
	}
	@media(max-width:600px){
	   #genealogy_id{
	     margin-left: -235px !important;  
	   }
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
				<div id='treeview-pan' class='pan-wrap' style="transform: matrix(1, 0, 0, 1, 250, 0); backface-visibility: hidden; transform-origin: 50% 50% 0px; cursor: move; transition: none 0s ease 0s;">
				<!-- <div  class='row' style="overflow-x:scroll;"> -->
				   <div class="tree" id="genealogy_id">
		<?php
		//echo "SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid = t2.uid and t1.uid = $mlmid";
		$q1=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t2.*,t4.uname as sname from user_id t1 join user_detail t2 on t1.uid = t2.uid left join pairing t3 on t1.uid=t3.uid left join user_id t4 on t3.sponsor_id=t4.uid where t1.uid = $mlmid"));
		?>		   
		
		<?php
			$pamount=IsDistributor($db,$q1["uid"]);
			if($q1["gender"]=='male'){
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
							<!-- Total Bv : <?php echo GetUserTotalBV($db,$q1['uid']); ?><br>
							Total PV : <?php echo GetUserTotalPV($db,$q1['uid']); ?><br> -->
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
                                    					  	  )); ?>
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
									1. Hover Your mouse into the tree chart</br>
									2. You can drag the chart so you can extend your diagram view</br>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <!-- javascript file -->
        <script type="text/javascript">var plugin_path = '../assets1/plugins/';</script>
        <script type="text/javascript" src="../assets1/plugins/jquery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets1/js/app.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        <script type="text/javascript" src="../assets1/js/bootstrap-multiselect.js"></script>
        <script type="text/javascript" src="../assets1/plugins/jqueryvalidate/jquery.validate.min.js" ></script>
        <script type="text/javascript" src="../assets1/plugins/ckeditor/ckeditor.js" ></script>
        <script type="text/javascript" src="../includes/function.js"></script>
        <script type="text/javascript" src="../includes/adminscript.js"></script>



          <script type="text/javascript">var plugin_path = '../assets1/plugins/';</script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
  <script type="text/javascript" src="../assets1/plugins/jquery/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="../assets1/js/app.js"></script>
  <script type="text/javascript" src="../includes/function.js"></script>
  <script type="text/javascript" src="../includes/adminscript.js"></script>

  <script src="../new_assets/theme/js/jquery.min.js"></script>
      <script>
          $(document).ready(function(){
                $('.nav a').each(function(index)
                {
                    if(this.href.trim() == window.location)
                    {
                        $(this).closest('li').addClass('active');
                        $(this).closest('.el_primary').addClass('active');
                    }

                });
                $(document).on('focus', '.select2.select2-container', function (e) {
                  if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
                    $(this).siblings('select').select2('open');
                  } 
                });
            });

            loadScript(plugin_path + "datatables/js/jquery.dataTables.min.js", function()
            {
                loadScript(plugin_path + "datatables/js/dataTables.tableTools.min.js", function()
                {
                    loadScript(plugin_path + "datatables/dataTables.bootstrap.js", function()
                    {
                        loadScript(plugin_path + "select2/js/select2.full.min.js", function(){

                            var table = jQuery('.sample_5');

                            /* Set tabletools buttons and button container */

                            jQuery.extend(true, jQuery.fn.DataTable.TableTools.classes, {
                                "container": "btn-group pull-right tabletools-topbar",
                                "buttons": {
                                    "normal": "btn btn-sm btn-default",
                                    "disabled": "btn btn-sm btn-default disabled"
                                },
                                "collection": {
                                    "container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
                                }
                            });

                            var oTable = table.dataTable({
                                "order": [
                                    [0, 'desc']
                                ],
                                "lengthMenu": [
                                    [10, 15, 20, -1],
                                    [10, 15, 20, "All"] // change per page values here
                                ],
                                "pageLength": 10, // set the initial value,
                                "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                                "tableTools": {
                                    "sSwfPath": plugin_path + "datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                                    "aButtons": [{
                                        "sExtends": "pdf",
                                        "sButtonText": "PDF"
                                    }, {
                                        "sExtends": "csv",
                                        "sButtonText": "CSV"
                                    }, {
                                        "sExtends": "xls",
                                        "sButtonText": "Excel"
                                    }, {
                                        "sExtends": "print",
                                        "sButtonText": "Print",
                                        "sInfo": 'Please press "CTR+P" to print or "ESC" to quit',
                                        "sMessage": "Generated by DataTables"
                                    }]
                                }
                            });

                            var tableWrapper = jQuery('#sample_5_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
                            tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

                        });
                    });
                });
            });
        
      </script>
      <script src="../new_assets/theme/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
      <script src="../new_assets/theme/js/ui-load.js"></script>
      <script src="../new_assets/theme/js/ui-jp.config.js"></script>
      <script src="../new_assets/theme/js/ui-jp.js"></script>
      <script src="../new_assets/theme/js/ui-nav.js"></script>
      <script src="../new_assets/theme/js/ui-toggle.js"></script>
      <script src="../new_assets/theme/js/ui-client.js"></script>
      <script src="../new_assets/theme/js/wizard.js"></script>
      <!-- <script src="../new_assets/theme/js/theme-setting.js" type="text/javascript"></script> -->
      <script src="../new_assets/theme/libs/jquery/zebra-datepicker/zebra_datepicker.min.js" type="text/javascript"></script>
      <script src="../new_assets/theme/libs/jquery/autocomplete/jquery.autocomplete.js" type="text/javascript"></script>
      <script src="../new_assets/theme/js/custom.js" type="text/javascript"></script>
      <script src="../new_assets/theme/libs/jquery/tooltipster/js/tooltipster.bundle.min.js" type="text/javascript"></script>
    <!--   <script src="../new_assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> -->
      
      <style type="text/css">
         .new-members.panel {
         min-height: 314px;
         }
         .user-det > div .sponsor-details:nth-child(1) {
         padding-left: 20px;
         }
         .renew_upgrade:hover,.renew_upgrade:active ,.renew_upgrade:focus .view_user:hover {
         background: #55489c;
         color: #fff;
         }
         .mr-20 {
         margin-right:20px
         }
         .pl-2 {
         padding-left:5px
         }
         .vertical_line {
         border-right: 1px dotted #bfbfbf;
         }
         .rela-blog-cnt-title {
         font-size: 15px;
         text-align: center;
         background: #e4e4e433;
         padding: 10px;
         height: 52px;
         margin: auto 0;
         overflow: hidden;
         font-weight: 600;
         }
         .panel .h1.font-thin.h1 {
         font-weight: 400;
         color: #6c787f;
         }
         .rela-blog-img {
         border-radius: 0%;
         }
         .news_content {
         height: 80px;
         overflow: hidden;
         }
         .read_full_news {
         text-align: center;
         color: #857cc3;
         }
         .read_full_news a:hover, a:focus {
         color: #717d84;
         text-decoration: none;
         }
         .rela-blog-cnt a.read_full_news {
         float: right;
         border: 1px solid #857cc3;
         border-radius: 15px;
         padding: 2px 8px;
         font-size: 11px;
         }
         .padding_bottom_zero {
         padding-bottom:0 !important; 
         }
         .padding_top_zero {
         padding-top: 0 !important;
         }
         .news-carousel .item {
         border: 1px solid #eee;
         padding: 6px 4px;
         }
         .rela-blog-img {
         border: unset;
         }
         .view_user {
         border-radius:2px
         }
         @media screen and (max-width: 1199px) {
         .col-md-12 {
         float: unset;
         }
         .box::after, .box1::after, .box2::after, .box3::after {
         width: 141px;
         height: 112px;
         top: -23%;
         left: -22%;
         }
         .box::before, .box1::before, .box2::before, .box3::before {
         top: -43%;
         left: -8%;
         }
         }
         @media screen and (max-width: 800px) {
         .box::after, .box1::after, .box2::after, .box3::after {
         width: 141px;
         height: 112px;
         top: -27%;
         left: -40%
         }
         .box::before, .box1::before, .box2::before, .box3::before {
         top: -47%;
         left: -18%;
         }
         }
      </style>
      <script type="text/javascript">
         $(function () {
         // loadDatePicker();
         // loadTimePicker();
         // loadDateTimePicker();
         });
      </script>

	</body>
</html>
<!-- Global JS -->
        <script src="../genealogy/jquery.panzoom.js"></script>
        <script src="../genealogy/jquery.mousewheel.js"></script>
        <script src="../genealogy/treeview.js"></script>
