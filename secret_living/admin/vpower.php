<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
            <h1>Activate Virtual Power</h1>
    </header>
				
    <div id="content" class="dashboard padding-20">
        <div class="row">
        
            <div class="col-md-6">
                <div class="panel panel-default mypanel ">
                    <div class="panel-heading panel-heading-transparent">
                            <strong>Activate Virtual Power</strong> 
                    </div>
                    <div class="panel-body">
                        <form  id="UpgradeVPower" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>Username*</label>
                                            <div class="fancy-form fancy-form-select"><!-- input -->
                                                <select class = "form-control select2" name = "uid" id = "username" required>
                                                <option value = "" selected disabled>Select Distributor</option>
                                                <?php

                                                
                                                $sql=mysqli_query($db,"SELECT * FROM `user_id` t1 left join pairing t2 on t1.uid=t2.uid WHERE t1.status = 1 and t1.uid!=1 and t2.rank!=8");
                                                while($row = mysqli_fetch_assoc($sql))
                                                {
                                                ?>
                                                <option value = "<?php echo $row["uid"];?>"><?php echo $row["uname"];?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>Choose Position</label>
                                                <div class="fancy-form">
                                                <select class="form-control" name="position">
                                                    <option value="">Please Select</option>
                                                    <option value="L" <?php echo isset($pos) && $pos=='L'?'selected':''; ?>>Left</option>
                                                    <option value="R" <?php echo isset($pos) && $pos=='R'?'selected':''; ?>>Right</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 text-center">
                                            <input type="hidden" name="type" value="UpgradeVPower">
                                            <button type="button" name = "UpgradeVPower"  class="btn btn-info btn-md btn-submit formvalidate" data-uid="<?php echo $mlmid; ?>" data-form="UpgradeVPower" > Activate Plan</button>
                                        </div>
                                         <div class="clearfix"></div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>	
</section>

<script>
    var mlmid = '<?php echo $mlmid;?>';
</script>
<?php include("footer.php");?>
