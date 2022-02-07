<?php include('../db_config.php');
 if(!isset($_GET['id']))
    die();

$uid = $_GET['id'];
$sql=mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid =t2.uid where t1.uid = '$uid'");
$row = mysqli_fetch_assoc($sql);
$tname = $row['first_name']." ".$row['last_name'];
$tuser_id = $row['uname'];
$address = $row['address'];
$city = $row['city'];
$zip = $row['zip'];
//$joining_date = $row['register_date'];
$tpassword = "********";
$tstatus = isset($row['status']) && $row['status'] == 1?'Active':'Inactive';
$date = date('d-m-Y G:i:s',strtotime($row['register_date']));

$sql2 = "SELECT t1.uname FROM `pairing` t2 join user_id t1 on t2.`parent_id` = t1.uid WHERE t2.`uid` = '$uid' ";
$q2 = mysqli_query($db,$sql2);
if(mysqli_num_rows($q2)>0)
{
    $r2 = mysqli_fetch_assoc($q2);
    $tsponserid = $r2['uname'];
} 
//include('../template.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body {
			background-color: #d7d6d3;
			font-family:'verdana';
		}
		.id-card-holder {
			width: 400px;
		    padding: 4px;
		    margin: 0 auto;
		    background-color: #1f1f1f;
		    border-radius: 5px;
		    position: relative;
		}
		.id-card-holder:after {
		    content: '';
		    width: 7px;
		    display: block;
		    background-color: #0a0a0a;
		    height: 100px;
		    position: absolute;
		    top: 105px;
		    border-radius: 0 5px 5px 0;
		}
		.id-card-holder:before {
		    content: '';
		    width: 10px;
		    display: block;
		    background-color: #0a0a0a;
		    height: 100px;
		    position: absolute;
		    top: 105px;
		    left: 398px;
		    border-radius: 5px 0 0 5px;
		}
		.id-card {
			
		    background-color: #555af8fc;
			padding: 10px;
			border-radius: 10px;
			text-align: center;
			box-shadow: 0 0 1.5px 0px #b9b9b9;
		}
		.id-card img {
			margin: 0 auto;
		}
		.header img {
			width: 100px;
    		margin-top: 15px;
		}
		.photo img {
			width: 80px;
    		margin-top: 15px;
		}
		h2 {
			font-size: 15px;
			margin: 5px 0;
			color:white;
		}
		h3 {
			font-size: 12px;
			margin: 2.5px 0;
			font-weight: 300;
			color:white;
		}
		.qr-code img {
			width: 50px;
		}
		p {
			font-size: 10px;
			margin: 2px;
			color:white;
		}
		.id-card-hook {
			background-color: #000;
		    width: 70px;
		    margin: 0 auto;
		    height: 15px;
		    border-radius: 5px 5px 0 0;
		}
		.id-card-hook:after {
			content: '';
		    background-color: #d7d6d3;
		    width: 47px;
		    height: 6px;
		    display: block;
		    margin: 0px auto;
		    position: relative;
		    top: 6px;
		    border-radius: 4px;
		}
		.id-card-tag-strip {
			width: 45px;
		    height: 40px;
		    background-color: #0950ef;
		    margin: 0 auto;
		    border-radius: 5px;
		    position: relative;
		    top: 9px;
		    z-index: 1;
		    border: 1px solid #0041ad;
		}
		.id-card-tag-strip:after {
			content: '';
		    display: block;
		    width: 100%;
		    height: 1px;
		    background-color: #c1c1c1;
		    position: relative;
		    top: 10px;
		}
		.id-card-tag {
			width: 0;
			height: 0;
			border-left: 100px solid transparent;
			border-right: 100px solid transparent;
			border-top: 100px solid #0958db;
			margin: -10px auto -30px auto;
		}
		.id-card-tag:after {
			content: '';
		    display: block;
		    width: 0;
		    height: 0;
		    border-left: 50px solid transparent;
		    border-right: 50px solid transparent;
		    border-top: 100px solid #d7d6d3;
		    margin: -10px auto -30px auto;
		    position: relative;
		    top: -130px;
		    left: -50px;
		}
	</style>
</head>
<body>
	<div class="id-card-tag"></div>
	<div class="id-card-tag-strip"></div>
	<div class="id-card-hook"></div>
	<div class="id-card-holder">
		<div class="id-card">
			<div class="header">
				<h1 style="font-family: emoji; font-size: 28px; border-bottom: 1px solid #b9b9b9; color:white;">Varietiz Pharma Pvt. Ltd.</h1>
			</div>
			<?php
                $q2 = mysqli_fetch_assoc($db->query("select * from user_bank where uid = '$uid'"));
            ?>
			<div class="photo">
				<?php
			  if(empty($q2['image'])){ ?>
			      <img class="user-avatar" alt="" src="../assets1/images/noavatar.jpg" />
			  <?php }else{
			  ?>
				<img src="../upload/kyc/<?php echo $q2['image'];?>">
			  <?php } ?>
			</div>
			
			<div style="margin-left:0px;margin-right:20px;">
			    <div style="width:30%; float:left; text-align:right;"><h2>Name:</h2></div>
    			<div style="width:70%; float:left; text-align:right;"><h2><?= $tname;?></h2></div>
    			
    			<div style="width:30%; float:left; text-align:right;"><h2>User ID:</h2></div>
    			<div style="width:70%; float:left; text-align:right;"><h2><?= $tuser_id;?></h2></div> 
    		
    			
    			<div style="width:30%; float:left;text-align:right;"><h2>Email:</h2></div>
    			<div style="width:70%; float:left;text-align:right;"><h2><?= $row['email'];?></h2></div>
    			
    			<div style="width:30%; float:left;text-align:right;"><h2>Phone:</h2></div>
    			<div style="width:70%; float:left;text-align:right;"><h2><?= $row['phone'];?></h2></div>
    			
    			<div style="width:30%; float:left;text-align:right;"><h2>Rank:</h2></div>
    			<div style="width:70%; float:left;text-align:right;"><h2>
    			    
    			     <?php   
					    $uids=$uid;
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
					    ?>
    			    
    			</h2></div>
			</div>
		
			<h3>www.varietiz.com</h3>
			<hr>
			<p><strong>"Corporate Office"</strong> Varietiz Pharma Pvt Ltd.,
yashodeep housing society office no. 408,
near kailash complex vikroli Mumbai 400079.</p>

			<!--<p>Ph: 9324345389 | E-mail: info@varietiz.com | Web: www.varietiz.com</p>-->
			<p>Ph: 9324345389 | E-mail: info@varietiz.com </p>

		</div>
	</div>
</body>
</html>