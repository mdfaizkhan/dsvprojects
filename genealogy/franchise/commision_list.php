<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Order Commision List</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Commision List</strong>
                    <!-- <a href="add_order" class="btn btn-info btn-xs pull-right"><i class = "fa fa-plus"></i> Add </a> -->
                </span>
            </div>
            <!-- panel content -->
            <form name="bulk_action_form" action="" method="post"/>
            <div class="panel-body ">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover sample_5" id="sample_5">
                        <thead>
                            <tr>
                                <th  class="">ID</th>
                                <th  class="">Invoice No</th>
                                <th  class="">Percentage</th>
                                <th  class="">DP Amount</th>
                                <th  class="">Commision</th>
                                <th  class="">Title</th>
                                <th  class="">Date</th>
                               
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT * FROM `frenchise_com_list` WHERE `fid`='$mlmid'") or die(mysqli_error($db));
                        while($row = mysqli_fetch_assoc($sql))
                        {
                        ?>
                           <tr>
                              <td><?php echo $i++; ?></td>
                              <td><?php echo $row['order_id']; ?></td>
                              <td><?php echo $row['per']; ?>%</td>
                              <td><i class="fa fa-inr"></i> <?php echo $row['total_dp_amount']; ?></td>
                              <td><i class="fa fa-inr"></i> <?php echo $row['total_commision']; ?></td>
                              <td>Commision Added Your Wallet.</td>
                               <td><?php echo isset($row['datetime']) && !empty($row['datetime'])?date("d-m-Y",strtotime($row['datetime'])):''; ?></td>
                           </tr>
                        <?php
                        }
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
<?php include("footer.php");?>
