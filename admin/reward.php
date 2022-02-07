<?php include("header.php");?>
<section id="middle">
	<header id="page-header">
		<h1>Reward</h1>  
	</header>
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Pending Reward</strong> <!-- panel title -->
				</span>
			</div>
			<!-- panel content -->
			<form name="bulk_action_form" action="" method="post"/>
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
						  <tr>
							<tr>										
								<th  class="">ID</th>
								<th  class="">Username</th>
								<th  class="">Amount</th>
								<th  class="">Image</th>
								<th  class="">Reward</th>
								<th  class="">Date</th>
								<th  class="">Action</th>
							</tr>
						</thead>

						<tbody>
						<?php
						$i = 1;
						$sql=mysqli_query($db,"SELECT s.*,u.uname,r.ramount FROM reward as s join user_id as u on s.uid=u.uid left join rewards_plans r on s.reward=r.id where s.status='0' order by s.id");
						while($row = mysqli_fetch_assoc($sql))
						{	
						?>
							<tr class="odd gradeX">
								<td><?php echo $i;?></td>
								<td><?php echo $row['uname'];?></td>
								<td><?php echo $row['amount'];?></td>
								<td><?php 
									if(isset($row['image']) && !empty($row['image']))
									{
										echo "<img src='../upload/".$row['image']."' height='100px' width='100px'>";
									}
								?></td>
								<td><?php echo $row['ramount'];?></td>
								<td><?php echo date("d/m/Y",strtotime($row['date']));?></td>
								<td>
	                                <a href="javascript:void(0);" title="Mark Reward As Paid" class="MarkRewardPaid btn btn-success btn-xs" data-id="<?php echo $row['id'];?>"><i class="fa fa-check"></i> Mark As Paid</a>
	                            </td>
							</tr><!--#31708F-->
						<?php $i++;
						}
						?>
						</tbody>
					</table>
	                <a href="javascript:void(0);" title="Mark All Reward As Paid" class="MarkAllRewardPaid btn btn-primary btn-md" data-id="<?php echo $row['id'];?>"><i class="fa fa-check"></i> Mark All As Paid</a>
	            </div>
			</div>
			</form>
			<!-- /panel content -->

		</div>
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
				<span class="title elipsis">
					<strong>Done Reward</strong> <!-- panel title -->
				</span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                    <thead>
                    <tr>
                    <tr>
                        <th  class="">ID</th>
                        <th  class="">Username</th>
                        <th  class="">Amount</th>
                        <th  class="">Image</th>
                        <th  class="">Reward</th>
                        <th  class="">Date</th>
                        <th  class="">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    $sql=mysqli_query($db,"SELECT s.*,u.uname,r.ramount FROM reward as s join user_id as u on s.uid=u.uid left join rewards_plans r on s.reward=r.id where s.status='1' order by s.id desc");
                    while($row = mysqli_fetch_assoc($sql))
                    {
                        ?>
                        <tr class="odd gradeX">
                            <td><?php echo $i;?></td>
                            <td><?php echo $row['uname'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            <td><?php 
								if(isset($row['image']) && !empty($row['image']))
								{
									echo "<img src='../upload/".$row['image']."' height='100px' width='100px'>";
								}
							?></td>
                            <td><?php echo $row['ramount'];?></td>
                            <td><?php echo date("d/m/Y",strtotime($row['date']));?></td>
                            <td  class="">
                                <a href="javascript:void(0);" class="btn btn-xs btn-success MarkAsClearedReward" title="Mark As Paid" data-id="<?php echo $row['id'];?>" disabled>Cleared</a>
                            </td>
                        </tr><!--#31708F-->
                        <?php $i++;
                    }
                    ?>
                    </tbody>
                </table>

            </div>
            </form>
            <!-- /panel content -->

        </div>
	</div>
</section>
<!-- /MIDDLE -->
<?php include("footer.php");?>