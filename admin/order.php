<?php include("header.php");?>
<section id="middle">
    <header id="page-header">
        <h1>Order</h1>
    </header>
    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default mypanel">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>Order</strong>
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
                                <th  class="">Username</th>
                                <th  class="">First Name</th>
                                <th  class="">Last Name</th>
                                <th  class="">MRP</th>
                                <th  class="">BV</th>
                                <th  class="">Shipping Charge</th>

                                <th  class="">Franchise</th>
                                <th  class="">Payment Status</th>
                                <th  class="">Payment Date</th>
                                <th  class="">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i = 1;
                        $sql=mysqli_query($db,"SELECT t1.*,t2.uname,t3.first_name,t3.last_name,t4.name as frname,t4.uname as funame FROM checkout t1 left join user_id t2 on t1.uid=t2.uid left join user_detail t3 on t1.uid=t3.uid   left join franchise t4 on t1.fid=t4.id order by t1.id ") or die(mysqli_error($db));
                        while($row = mysqli_fetch_assoc($sql))
                        {
                        ?>
                            <tr class="odd gradeX">
                                <!--<td align="center">
                                    <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php /*echo $row['plan_id']; */?>"/>
                                </td>-->
                                <td><?php echo $i++;?></td>
                                <td><?php echo "QFRM".leftpad($row['id'],6);?></td>
                                <td><?php echo $row['uname'];?></td>
                                <td><?php echo $row['first_name'];?></td>
                                <td><?php echo $row['last_name'];?></td>
                                
                                <td><?php echo "Rs.".$row['amount'];?></td>
                                <?php  
                                    $total_amount += $row['amount']

                                ?>
                                <td><?php echo $row['bv'];?></td>
                                <td><?php echo $row['shipping_charge'];?></td>
                                <td><?php echo $row['frname']." (".$row['funame'].")";?></td>
                                <!-- <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td> -->
                                <td><?php /*if($row['cleared'] == 1)
                                    {
                                        echo '<i class = "fa fa-check-circle" style="color: green;"></i> Paid';
                                    }
                                    else
                                    {
                                        echo 'Pending';
                                    }*/
                                     echo '<i class = "fa fa-check-circle" style="color: green;"></i> Paid';
                                    ?>
                                </td>
                                <td><?php echo isset($row['date']) && !empty($row['date'])?date("d-m-Y",strtotime($row['date'])):''; ?></td>
                                <td>
                                    <a href="myinvoice?id=<?php echo $row['id'];?>" class="btn btn-info btn-xs" id="invoice" data-id="" />View Invoice</a>
                                    <!--<a class="btn btn-danger btn-xs" onclick="DeleteOrder(<?php echo $row['id'];?>)">Cancel Order</a>-->
                                    
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td>Total :</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo "Rs.".$total_amount;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tfoot>
                    </table>
                </div>

            </div>
            </form>
            <!-- /panel content -->

        </div>
    </div>
</section>

<script>
    
function DeleteOrder(id){
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a order. if any user have this order will be removed from it Continue to Delete?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
               
                $('.bootbox-confirm').modal('hide');
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        id : id,
                        type : 'DeleteOrder'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

}
    
</script>

<?php include("footer.php");?>
