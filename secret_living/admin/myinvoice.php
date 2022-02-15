<?php include("header.php");
if(isset($_GET['id']) && !empty($_GET['id'])){
    $txnid=$id = $_GET['id'];
    $sql=mysqli_query($db,"SELECT t1.* FROM checkout t1 where t1.id='$id' ");
    $data1=mysqli_fetch_assoc($sql);
    $muid=$data1['uid'];
    $fid=$data1['fid'];
    $shipping_charge=$data1['shipping_charge'];
    $data2=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM franchise WHERE id='$fid'"));
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
                    <!-- <div class="panel-heading panel-heading-transparent">
                        <strong>My Invoice</strong>
                       
                    </div> -->
                    <div class="panel-body" id="PrintArea">
                        <div class="row clerfix">
                            <div class="col-md-5 col-sm-12 text-left">
                               <img src="../images/logo.jpeg" style="width:40%;">
                            </div>
                            <div class="col-md-2 col-sm-12 text-center">
                                <h3><b>TAX INVOICE</b></h3>
                            </div>
                            <div class="col-md-5 col-sm-12 text-right"><b>
                                Varietiz Pharma Pvt Ltd.<br>
                                yashodeep housing society office no. 408,<br>
                                near kailash complex vikroli Mumbai 400079.<br>
                                Mumbai, Maharashtra-400101<br>Mobile : +91 9324345389,<br>
                                Email : info@varietiz.com<br>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row clerfix">
                            <?php if(isset($data1['fid']) && !empty($data1['fid'])){ ?>
                            <div class="col-md-9 col-sm-12 text-left" >
                                
                                <h5><b><?php echo isset($data2['name'])?$data2['name']:''; ?> (<?php echo isset($data2['uname'])?$data2['uname']:''; ?>)</b></h5>
                                <h6><?php echo isset($data2['address'])?$data2['address']:''; ?><br>Mobile : <?php echo isset($data2['mobile'])?$data2['mobile']:''; ?>, Email : <?php echo isset($data2['email'])?$data2['email']:''; ?></h6>
                            </div>
                            <?php } ?>
                            <div class="col-md-3 col-sm-12 text-left" style="border: 1px solid #ddd;margin-top:30px;">
                                <br>
                               <h5><text>Invoice No. : <?php echo "QFRM".leftpad($data1['id'],6);?></text>
                                <br>
                                <text>Invoice Date : <?php echo isset($data1['date']) && !empty($data1['date'])?date("d M, Y",strtotime($data1['date'])):''; ?></text>
                            </h5>
                            </div>
                        </div>
                        <div class="row clerfix">
                            <div class="col-md-9 col-sm-12 text-left" >
                                
                                <h5><b><?php echo isset($data['first_name'])?$data['first_name']:''; ?> <?php echo isset($data['last_name'])?$data['last_name']:''; ?> (<?php echo isset($data['uname'])?$data['uname']:''; ?>)</b></h5>
                                <h6><?php echo isset($address)?$address:''; ?></h6>
                                <h6>Phone No.:<?php echo isset($data['mobile'])?$data['mobile']:''; ?></h6>
                            </div>
                            <div class="col-md-3 col-sm-12 text-left" style="border: 1px solid #ddd;margin-top:30px;">
                                <br>
                                <SMALL>Name of Service recipient/Consignee</SMALL>
                               <h5><b><?php echo isset($data['uname'])?$data['uname']:''; ?> - <?php echo isset($data['first_name'])?$data['first_name']:''; ?> <?php echo isset($data['last_name'])?$data['last_name']:''; ?> </b></h5>
                                </h5>
                                 <h6><?php echo isset($address)?$address:''; ?></h6>
                                <h6>Phone No.:<?php echo isset($data['mobile'])?$data['mobile']:''; ?></h6>
                            </div>
                        </div>
                        
                        <div class="row clerfix">
                            <div class="col-md-12 col-sm-12 text-right" >
                                &nbsp;
                            </div>
                        </div>
                        <div class="row clerfix">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Product Code</th>
                                            <th>Description of Goods/Services</th>
                                            <th>Quantity</th>
                                            <th>Rate/ Price</th>
                                            <th>Amount Base Price</th>
                                            <th>Tax</th>
                                            <!-- <th>Taxable Amount</th>
                                            <th>CGST Rate</th>
                                            <th>CGST Amount</th>
                                            <th>SGST Rate</th>
                                            <th>SGST Amount</th> -->
                                            <th>Total Amount (Inc. Tax)</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $ftotal=0;
                                            $fbv=0;
                                            $p=1;
                                            $total_price=0;
                                            foreach ($products as $key => $value) {
                                                $pid=$value['name'];
                                                $prd_id=$value['product_id'];
                                                $r=mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `products` WHERE product_id='$prd_id'"));
                                                /*$total=isset($value['qty']) && isset($r['mrp'])?$value['qty']*$r['mrp']:0;
                                                $total1=isset($value['qty']) && isset($r['bv'])?$value['qty']*$r['bv']:0;
                                                $ftotal=$ftotal+$total;
                                                $fbv=$fbv+$total1;*/
                                        ?>
                                        <tr>
                                            <td><?=$p++; ?></td>
                                            <td><?php echo "PC".leftpad($prd_id,6);?></td>
                                            <td><?php echo isset($r['name'])?$r['name']:''; ?></td>
                                            <td><?php echo isset($value['qty'])?$value['qty']:''; ?></td>
                                            <td>
                                                <?php 
                                                //  $chk_pur=IsDistributor($db,$muid);
                                                // if($chk_pur > 0)
                                                // {
                                                //   echo "Rs.". isset($r['dp'])?$r['dp']:'';
                                                //   $prd_price=$r['dp'];
                                                // }
                                                // else { 
                                                    echo "Rs.". isset($r['mrp'])?$r['mrp']:'';
                                                    $prd_price=$r['mrp'];
                                                //}
                                               ?></td>
                                            
                                            <td><?php echo $ftotal = $prd_price*$value['qty']; ?></td>
                                              <td>CGST(9%): <?= $ftotal*9/100; ?> <br> SGST(9%): <?= $ftotal*9/100; ?></td>
                                            <!-- <td><?=$ftotal; ?></td>
                                            <td><?='6'; ?></td>
                                            <td><?=$cgst=($ftotal*6)/100; ?></td>
                                            <td><?='6'; ?></td>
                                            <td><?=$sgst=($ftotal*6)/100; ?></td> -->
                                            <td>
                                                <?php //echo $total_price=$ftotal+$cgst+$sgst; ?>
                                                <?php echo $ftotal;
                                                 $total_price+=$ftotal; ?>
                                            </td>
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
                                            <td colspan="7" align="right"><b>Grand Total</b></td>
                                            <!-- <td><b><?php //echo isset($ftotal)?number_format($ftotal,2):''; ?></b></td>
                                            <td><b></b></td> -->
                                            <td><b><?php echo isset($total_price)?number_format($total_price,2):''; ?></b></td>
                                            <!-- <td><b></b></td>
                                            <td><b><?php echo isset($cgst)?number_format($cgst,2):''; ?></b></td>
                                            <td><b></b></td>
                                            <td><b><?php echo isset($sgst)?number_format($sgst,2):''; ?></b></td> -->
                                            <!-- <td><b><?php echo isset($total_price)?$total_price:0; ?></b></td> -->
                                        </tr>       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row clerfix">
                            <div class="col-md-12 col-sm-12 text-right" style="padding-right: 20px;">
                                <span>Total Amount : <?php echo isset($total_price)?number_format($total_price,2):0; ?></span><br>
                                <!-- <span>Tax Amount : <?php 
                                $tax_amount=$cgst+$sgst;
                                echo isset($cgst)?number_format($tax_amount,2):0; ?></span><br> -->
                                <span>Shipping Charges: <?=$shipping_charge; ?></span><br>
                                <span>Total Invoice Amount:<?php echo isset($total_price)?$total_price+$shipping_charge:0; ?></span>
                            </div>
                        </div>
                       <div class="row clerfix"><br><br><br>
                            <div class="col-md-12 col-sm-12 text-left">Note: Unless otherwise stated, tax on this invoice is not payable under reverse charge for Varietiz Pharma Pvt Ltd.
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



