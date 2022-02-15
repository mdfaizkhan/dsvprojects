<?php include("header.php"); ?>
<section id="middle">
	<header id="page-header">
		<h1>Rank Achievers</h1>  
	</header>
	
	<div id="content" class="padding-20">
		<div id="panel-1" class="panel panel-default mypanel">
			<div class="panel-heading">
				<span class="title elipsis">
					<strong>Rank Achievers </strong> <!-- panel title -->
				</span>
			</div>
			<!-- panel content -->
			
			<div class="panel-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
						<thead>
						  <tr>
							<tr>
	                            <th align="center">ID</th>
								<th  class="">Sponsor</th>
								<th  class="">Rank Name</th>
								<th  class="">Amount</th>
								<th  class="">Date</th>
								<th  class="">Action</th>
								
							</tr>
						</thead>

						<tbody>
						<?php
						
                        	$i=1;
                        	$j=0;
                        	$check=0;
                        	$r0 = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM rank_detail where id=1"));
                        	$left=$r0['leftcount'];
                        	$right=$r0['rightcount'];
                        	
                        	$q1=mysqli_query($db,"SELECT t1.uid as tuid,(SELECT t5.name as rank_name FROM `child_counter` t4 left join rank_detail t5 on t4.`uleftcount`>= t5.leftcount and t4.urightcount >=t5.rightcount where t4.uid=t1.uid and t4.uid in (SELECT t7.uid FROM `child_counter` t7 left join rank_detail t6 on t7.`uleftcount`>= t6.leftcount and t7.urightcount >=t6.rightcount) ORDER BY t5.id DESC limit 1) as rank_name,t1.uleftcount,t1.urightcount,t2.first_name,t2.last_name,t3.uname FROM child_counter t1 left join user_detail t2 on t1.uid=t2.uid left join user_id t3 on t1.uid=t3.uid where t1.uleftcount >='$left' and t1.urightcount >='$right'");
                        	while($r1 = mysqli_fetch_assoc($q1))
	                        {
	                        	$fullname=$r1['first_name']." ".$r1['last_name']." (".$r1['uname'].")";
	                        	$rank_name=isset($r1['rank_name']) && !empty($r1['rank_name'])?$r1['rank_name']:'None';                            	
                           		$rq=mysqli_query($db,"SELECT * FROM `rank_payout` where `rank`='$rank_name' and uid=$r1[tuid]");
                           		$rn=mysqli_num_rows($rq);
                           		$rr1=mysqli_fetch_assoc($rq);
			                    ?>
			                        <tr class="odd gradeX">
										<td align="center"><?php echo $i++; ?></td>
										<td><?php echo $fullname; ?></td>
										<td><?php echo $rank_name; ?></td>
										<td><?php echo $rr1['amount']; ?></td>
										<td><?php echo isset($rr1['date']) && !empty($rr1['date'])?date('d/m/Y',strtotime($rr1['date'])):'';?></td>
										<td>
										<?php
											if($rn > 0)
											{
												echo "<span class='btn btn-xs btn-success'>PAID</span>";
											}
											else
											{
										?>
										<a href="javascript:void(0);" class="btn btn-xs btn-success PModaluser" data-id="<?php echo $r1['tuid'];?>" data-name="<?php echo $fullname; ?>" data-rank="<?php echo $rank_name; ?>" title="Pay"><i class="fa fa-inr"></i> Pay</a>
										<?php } ?>
										</td>
			                        </tr>
	                    <?php
	                    	$j++;
		                     }
	                     ?>    
						</tbody>
					</table>
				</div>
			</div>
			
			<!-- /panel content -->

		</div>
	</div>
</section>
<!-- /MIDDLE -->

<?php include("footer.php");?>
<div id="UserPayModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <form id="UserRankPay" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label>Amount*</label>
                                <input type="number" class="form-control" name = "amount"  placeholder = "Enter Amount You Want To Pay">
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <label>Date*</label>
                                <input type="text" class="form-control datepicker" name = "date" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" placeholder = "Date">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type ="hidden" name = "type" value="UserRankPayout">
                    <input type ="hidden" name = "rank_name" id="rank_name" value="">
                    <input type ="hidden" name = "user_id" id="userid" value="">
                    <input type="button"  id="formvalidate" data-form="UserRankPay"  class="btn btn-info btn-md btn-submit"  value="Pay">
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>