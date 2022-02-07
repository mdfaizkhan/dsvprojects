<?php include("header.php");
$child_counter=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `child_counter` WHERE uid='$mlmid'"));
$pairing=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `pairing` WHERE uid='$mlmid'"));
?>
			
<section id="middle">
	<header id="page-header">
		<h1>My Next Goal</h1>  
	</header>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<!-- panel content -->
			
			<div class="panel-body ">
			 <div class="row">
			  <div class="col-sm-5">
			  	<center>
			  	    <span style="font-size:20px;">
			  	    Current Rank: 
			  	[  <?php   
				    $uids=$mlmid;
				    $r1 = mysqli_fetch_assoc(mysqli_query($db,"SELECT t2.name as rank_name,t1.rank FROM `pairing` t1 left join rank_detail t2 on t1.`rank`= t2.id  where t1.uid='$uids'"));
				        $try1=mysqli_query($db,"SELECT * FROM `userachieverank` WHERE uid=$uids ORDER BY rank_id desc limit 1"); 
		                $tycount=mysqli_num_rows($try1);
				        $ty=mysqli_fetch_assoc($try1);
			            $ids=$ty['rank_id'];
						if($tycount>0){
						 $rows=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `rank_detail` WHERE id=$ids "));
						 echo $rows['name']; 
						}
						else{
						    if(!isset($r1['achieve_rank']) || empty($r1['achieve_rank']))
							{
								$chk_pur=IsDistributor($db,$uids);
					            if($chk_pur > 0)
					            {
					                echo "Distributor";
					            }
							}
							else
							{
								echo $r1['rank_name'];
							}
						}	
				    ?> ] <br>
				Current Left BV:  <?= $child_counter['left_bv'] ?><br>
				Current Right BV: <?= $child_counter['right_bv'] ?>
			  	</span>
			  	</center>
			  </div>
			  <div class="col-sm-3">
			  	<center>
			  	    <i class="fa fa-arrow-circle-right" style="font-size: 80px;"></i>
			  	    <h3>Next Goal</h3>
			  	</center>
			  </div>
			  <div class="col-sm-4">
			    <center>
			       <span style="font-size:20px;">
    			  	<?php
    			  	$ids1=$ty['rank_id']+1;
    			  	$rows1=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `rank_detail` WHERE id=$ids1 "));
    				echo $rows1['name'];
    			  	?>
    			  	<br>
    			  	Left BV:  <?= $rows1['tpv'] ?><br>
    				Right BV: <?= $rows1['tpv'] ?><br>
    
    				Need Left BV:  <?= $rows1['tpv']-$child_counter['left_bv'] ?><br>
    				Need Right BV: <?= $rows1['tpv']-$child_counter['right_bv'] ?>
				  </span>
			    </center>
			  </div>
			 </div>
			</div>			
			<!-- /panel content -->

		</div>
	</div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>