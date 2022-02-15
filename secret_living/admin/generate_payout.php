<?php include("header.php");

?>
<section id="middle">
    <header id="page-header">
        <h1>Generate Payout</h1>
    </header>
    <div id="content" class="padding-20">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default mypanel">
                    <div class="panel-heading panel-heading-transparent">
                        <strong>Generate Payout</strong>
                    </div>
                    <div class="panel-body">
                        <div class="row clerfix">
                        <!-- <div class="form-group">
                            <div class="col-md-8 col-md-offset-2 padding-10">
                                <input type="button" class="btn btn-primary btn-block GenerateDirectPlan" id="plan1" value="Generate Direct Payout"/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        </div>
                        <div class="row clerfix">
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2 padding-10">
                                    <input type="button" class="btn btn-primary btn-block GenerateSingleLeg" id="plan2" value="Generate Royalty Payout"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> -->
                        <div class="row clerfix">
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2 padding-10">
                                    <input type="button" class="btn btn-primary btn-block GenerateGTBPayout" id="gtbpayout" value="Generate Matching Payout"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                         <div class="row clerfix">
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2 padding-10">
                                    <input type="button" class="btn btn-primary btn-block GenerateRankayout" id="rankpayout" value="Generate Rank Payout"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- <div class="row clerfix">
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2 padding-10">
                                    <input type="button" class="btn btn-primary btn-block GenerateReferalPayout" id="plan2" value="Generate Referal Bonus Payout"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="row clerfix"> -->
                        <!-- <div class="form-group">
                            <div class="col-md-8 col-md-offset-2 padding-10">
                                <input type="button" class="btn btn-primary btn-block generateBonusPayout" id="plan3" value="Generate Bonus Payout"/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2 padding-10">
                                <input type="button" class="btn btn-primary btn-block generateRoiPayout" id="plan3" value="Generate ROI Payout"/>
                            </div>
                            <div class="clearfix"></div>
                        </div> -->
                        <!-- <div class="form-group">
                            <div class="col-md-8 col-md-offset-2 padding-10">
                                <input type="button" class="btn btn-primary btn-block plan3" id="plan3" value="Generate Re-Purchase Payout"/>
                            </div>
                            <div class="clearfix"></div>
                        </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /MIDDLE -->
<?php include("footer.php");?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Enter Your Password</h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12">   
            <input type="hidden" name="user_id" id="user_id" value="1">      
            <input type="hidden" name="plan" id="plan" value="">      
            <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" autocomplete="false">
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info SubmitPassword">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



