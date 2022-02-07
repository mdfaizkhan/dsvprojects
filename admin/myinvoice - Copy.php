<?php include("header.php");
if(isset($_GET['id']) && !empty($_GET['id'])){
    $txnid=$id = $_GET['id'];
    $sql=mysqli_query($db,"SELECT t1.* FROM checkout t1 where t1.id='$id' ");
    $data1=mysqli_fetch_assoc($sql);
    $muid=$data1['uid'];
    $products=array();
    $q1=mysqli_query($db,"SELECT * FROM cart WHERE transaction_id='$txnid'");
    while ($r1=mysqli_fetch_assoc($q1)) {
        $products[]=$r1;
    }
    

    
    $total_price=$data1['amount'];
    
}

$data=mysqli_fetch_assoc(mysqli_query($db,"SELECT t1.*,t.uname,t.register_date,t.plan_date FROM user_id t left join `user_detail` t1 on t.uid=t1.uid  WHERE t1.`uid`='$muid'"));
    if(!empty($data['address']) && !empty($data['address']))
    {
        $address=$data['address'].", ".$data['state'].", ".$data['city'].", ".$data['zip'];
    }
//$r=getplanStatus($db,$muid);
/*if(isset($data1['cleared']) && $data1['cleared']==2)
{
    $class="btn-success";
    $text="Confirmed";
}
else if($r==1) {
    $class="btn-warning";
    $text="Pending - Paid";
}
else
{
    $class="btn-danger";
    $text="Pending- Unpaid";
}*/
$class="btn-success";
    $text="Confirmed";
?>
<style type="text/css">
#PrintArea1 h5
{
    padding-top : 0px;
    margin: 0px 0 0px 0 !important;
}
</style>
<section id="middle">
    <header id="page-header">
        <h1>My Invoice</h1>
    </header>
    <div id="content" class="padding-20">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default mypanel">
                    <div class="panel-heading panel-heading-transparent">
                        <strong>My Invoice</strong>
                        <!-- <a class="btn btn-sm btn-success paymentDetail pull-right" href="javascript:void(0);" title="Add Payment Detail"  data-id="<?php echo isset($id)?$id:''; ?>" data-mid="pay-modal"><i class="fa fa-edit white"> Add Payment Detail</i></a> -->
                        <input type="button" class="btn btn-info btn-sm pull-right" onclick="printDiv('PrintArea')" value="Print"/>
                    </div>
                    <div class="panel-body" id="PrintArea">
                        <div class="row clerfix">
                            <div class="col-md-6 col-sm-12 text-left">
                                <h4>Frentic Retail & Marketing Pvt. Ltd. </h4>
                                <!-- <h5>Surat,Gujarat , India</h5> -->
                            </div>
                            <div class="col-md-6 col-sm-12 text-right">
                                <h4><b>Order Id</b> : #<?php echo isset($data1['id'])?"QTEG".leftPad($data1['id'],"6"):''; ?></h4>

                                <h5><b>Registration Date</b> : <?php echo isset($data['register_date'])?date('Y-m-d',strtotime($data['register_date'])):''; ?></h5>

                                <!-- <h5><b>Expiry Date</b> : 2019-03-15</h5> -->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row clerfix">
                            <div class="col-md-6 col-sm-12 text-left" id="PrintArea1">
                                <h5><b>TO</b></h5>
                                <h5><b><?php echo isset($data['first_name'])?$data['first_name']:''; ?> <?php echo isset($data['last_name'])?$data['last_name']:''; ?> (<?php echo isset($data['uname'])?$data['uname']:''; ?>)</b></h5>
                                <h6><?php echo isset($address)?$address:''; ?></h6>
                            </div>
                        </div>
                        <div class="row clerfix">
                            <div class="col-md-6 col-sm-12 text-left">
                                <h5><b>Order date</b>: <?php echo isset($data1['date'])?date('Y-m-d',strtotime($data1['date'])):''; ?></h5>
                                <h5><b>Order status</b>:<button class="btn btn-xs btn-success"><?php echo $text; ?></button></h5>
                            </div>
                        </div>
                        <div class="row clerfix">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th>QTY</th>
                                            <th>DESCRIPTION</th>
                                            <!-- <?php
                                                if(isset($total_price) && $total_price > 5000)
                                                {
                                            ?>
                                            <th width="120">BV</th>
                                        <?php } else { ?> -->
                                            <th width="120">UNIT PRICE</th>
                                        <!-- <?php } ?>  -->
                                            <th>Qty</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $ftotal=0;
                                            $fbv=0;
                                            $p=1;
                                            foreach ($products as $key => $value) {
                                                $pid=$value['name'];
                                                $r=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `products` WHERE product_id='$value[product_id]'"));
                                                $total=isset($value['qty']) && isset($r['mrp'])?$value['qty']*$r['mrp']:0;
                                                $total1=isset($value['qty']) && isset($r['bv'])?$value['qty']*$r['bv']:0;
                                                $ftotal=$ftotal+$total;
                                                $fbv=$fbv+$total1;
                                        ?>
                                        <tr>
                                            <td><?=$p++; ?></td>
                                            <td><?php echo isset($r['name'])?$r['name']:''; ?></td>
                                            
                                            <?php
                                                if(isset($total_price) && $total_price > 5000)
                                                {
                                            ?>
                                             <td><?php echo isset($r['bv'])?$r['bv']:''; ?></td>
                                            <?php } else { ?>
                                                <td>Rs.<?php echo isset($r['mrp'])?$r['mrp']:''; ?></td>
                                            <?php } ?>
                                            <td><?php echo isset($value['qty'])?$value['qty']:''; ?></td>
                                            <td><?php echo isset($total_price) && $total_price > 5000?$total1:$total; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <!-- <tr>
                                            <td colspan="4" align="right"><b>Subtotal</b></td>
                                            <td>Rs.<?php echo isset($value['qty']) &&isset($value['price'])?$value['qty']*$value['price']:0; ?></td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td colspan="3" align="right"><b>Tax/VAT Included in Total</b></td>
                                            <td>Rs.0</td>
                                        </tr> -->   
                                        <tr>
                                            <td colspan="4" align="right"><b>Total</b></td>
                                            <td><b><?php echo isset($total_price) && $total_price > 5000?$fbv:"Rs.".$ftotal; ?></b></td>
                                        </tr>       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /MIDDLE -->
<?php include("footer.php");?>
<script type="text/javascript">
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<div id="pay-modal" class="modal fade bs-example-modal-md pay-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- header modal -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Payment Detail</h4>
            </div>

            <!-- body modal -->
            <div class="modal-body">
                <form id="ManagePaymentDetails" action="" method="post">
                    
                    <div class="row ">
                        <div class="form-group">
                        <div class="col-md-12">
                                <label>Txn Id</label>
                                <input type="text" name="txnid" id="txnid" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group">
                        <div class="col-md-12">
                                <label>Note</label>
                                <textarea row="10" name="note" id="note" class="form-control"></textarea>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group">
                        <div class="col-md-12">
                            <label>Files</label>
                            <div class="fancy-file-upload fancy-file-primary">

                                <i class="fa fa-upload"></i>
                                <input type="file" class="form-control"  name="image" onchange="jQuery(this).next('input').val(this.value);" >
                                <input type="text" class="form-control" placeholder="No file selected" readonly=""  >
                                <span class="button">Choose File</span>
                                
                                
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row clearfix">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 text-center">
                                <input type="hidden" name="type" value="ManagePaymentDetails">
                                <input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo isset($data1['id'])?isset($data1['id']):''; ?>">
                                <input type="submit"  data-form="ManagePaymentDetails"  class="btn btn-info btn-md btn-submit formvalidate"  value="Save">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
                
            </div>

        </div>
    </div>
</div>



