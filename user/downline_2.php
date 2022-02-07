<?php include("header.php");
$getpair=mysqli_fetch_assoc(mysqli_query($db,"select * from user_id where uid='$mlmid'"));
$mpair=$getpair['paired'];
if(isset($_GET['pid']) && !empty($_GET['pid']))
{
	//$id = $_GET['level'];
	
	$pid = encrypt_decrypt("decrypt",$_GET['pid']);
	if(isset($pid) && $pid > $mlmid)
	{
		$pid1=getParentIds($db,$pid,$mlmid);
	}
	else
	{
		$pid1=$mlmid;
	}
	
	$mid=GetpairedNo($db,$pid,$mpair);
	$id=$mid+1;
	$sql="SELECT t1.*,t2.* from pairing t1 join user_id t2 on t1.uid=t2.uid where t1.parent_id = $pid";
	$sql=mysqli_query($db,$sql);
}
else
{
	$id=$mpair+1;
	$pid=$mlmid;
	$sql="SELECT t1.*,t2.* from pairing t1 join user_id t2 on t1.uid=t2.uid where t1.parent_id=$mlmid";
	$sql=mysqli_query($db,$sql);
}
?>
<style type="text/css">
	.main-icon {
    float: left;
    font-size: 20px;	
    text-align: center;
}
</style>		
<section id="middle">
	<header id="page-header">
		<h1>Downline Distributor</h1>  
	</header>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Downline Distributor</strong>
				</span>
				<!-- <a href="downline?pid=<?php echo encrypt_decrypt("encrypt",$pid1); ?>" class="btn btn-success btn-sm pull-right <?php echo isset($pid) && $pid==$mlmid?'disabled':''; ?>"><i class = " main-icon fa fa-arrow-circle-down"></i></a> -->
				<span class="btn btn-success btn-sm pull-right" >Level <?php echo $id-$mpair; ?></span>
				<a href="downline?pid=<?php echo encrypt_decrypt("encrypt",$pid1); ?>" class="btn btn-success btn-sm pull-right"><i class = "main-icon fa fa fa-arrow-circle-up"></i></a>
			</div>
			<!-- panel content -->
			<form name="bulk_action_form" action="" method="post"/>
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
						  <tr>
							<tr>
								<th align="center">ID</th>
								<th class=""> Parent</th>
								<th class="">Distributor</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i=1;
						$parr_str='';
						$parr=array();
						while($row = mysqli_fetch_assoc($sql))
						{	
							$parent_id = $row['parent_id'];
							$child = $row['uid'];
							$parr[]=$row['uid'];
							$p = mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = '$parent_id'"));
							$l = mysqli_fetch_assoc(mysqli_query($db,"SELECT * from user_id where uid = '$child'"));
							$pid=encrypt_decrypt("encrypt",$l['uid']);

						?>
							<tr class="odd gradeX">
								<td align="center">
									<?php echo $i;?>
								</td>
								<td><?php echo $p["uname"]; ?></td>
								<td>
									<a href="downline?pid=<?php echo $pid; ?>"><?php echo $l["uname"];	?></a>
								</td>
						<?php 
						$i++;
						}
						//echo $parr_str=implode(',', $parr);
						?>
						</tbody>
					</table>
				</div>
			</div>
			</form>
			<!-- /panel content -->

		</div>
	</div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>
<script type="text/javascript">
var pid='<?php echo $parr_str?>';
$('#pid').val(pid);
</script>
