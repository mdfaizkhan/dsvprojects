<?php include('../db_config.php');
if(!isset($_GET['id']))
    die();

$uid = $_GET['id'];
$sql=mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid =t2.uid where t1.uid = '$uid'");
$row = mysqli_fetch_assoc($sql);
$tname = $row['first_name']." ".$row['last_name'];
$tuser_id = $row['uname'];
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
<div style="border: 5px solid #006699;padding: 5px;">
     
    <div id="ContentPlaceHolder1_Panel1" style="border:2px solid #2CA8E6; padding:2px;">
    
        <table id="ContentPlaceHolder1_Table1" border="0" width="100%">
        <tbody><tr>
            <td align="center" colspan="2">
                   
                    <img src="../assets/images/logo.png" width="10%">
                </td>
        </tr>
        <tr>
            <td align="left" colspan="2">
                    &nbsp;
                </td>
        </tr>
        <tr>
            <td align="center" colspan="2"><h4 class="style3">ARROWLEE FOUNDATION</h4></td>
        </tr>
        <tr>
            <td align="center" colspan="2"><h4 class="style3">CERTIFICATE OF ACHIEVEMENT</h4></td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                   
               <span id="ContentPlaceHolder1_lblusername3" style="font-weight:bold;">THIS CERTIFICATE IS PRESENTED TO MRS./ MISS, <?= $tname;?></span>
               
            </td>
        </tr>
        <tr>
            <td align="left" colspan="2">
                &nbsp;
            </td>
        </tr>
         <tr>
            <td align="left" colspan="2" class="style2">
                &nbsp;
            </td>
        </tr>
         <tr>
            <td align="left" colspan="2" class="style2">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td align="left" colspan="2" style="padding-left:200px;"><h4 class="style3">AS A ARROWLEE FOUNDATION</h4></td>
        </tr>
        <tr>
            <td align="left" colspan="2" class="style2">
                    &nbsp;
                </td>
        </tr>
        <tr>
            <td align="left" class="style1" colspan="2">
                    <span class="style6"><strong>CONGRATULATIONS</strong></span>
                </td>
        </tr>
        <tr>
            <td align="left" class="style1" colspan="2">
                    &nbsp;
                </td>
        </tr>
        <tr>
            <td style="text-align: justify" colspan="2">
                <p class="MsoNormal">
                    <span lang="EN-US">YOU ARE HEREBY APPOINTED AS ARROWLEE FOUNDATION ENTREPRENEUR. YOU can now represent Arrowlee Foundation. You can get sales for all its business activities viz: sales of health care and tours and travels packages. You will be eligible for commission/ incentive payment for the new business source for the company.<o:p></o:p></span></p>
            </td>
        </tr>
        <tr>
            <td style="text-align: justify" colspan="2">
                    &nbsp;
                </td>
        </tr>
        
        <tr>
            <td style="text-align: justify" colspan="2">
                <p class="MsoNormal">
                    <span lang="EN-US">Welcome to Arrowlee Foundation Family. Now you can start sponsoring/referring/ sales your contacts to share this wonderful opportunity. <o:p>
                    </o:p></span></p>
            </td>
        </tr>
        <tr>
            <td style="text-align: justify" colspan="2">
                    &nbsp;
                </td>
        </tr>
        
        <tr>
            <td align="left" colspan="2">
                <span lang="EN-US" class="style10">ARROWLEE FOUNDATION</span>
            </td>
        </tr>
        <!-- <tr>
            <td align="left" colspan="2">
                    <img src="cid:refercode_2u" style="width: 12%; float: right; padding-right: 50px;">
                </td>
        </tr> -->
        <tr>
            <td align="left" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" colspan="2">Copyright &copy; 2018 ARROWLEE FOUNDATION. All Rights Reserved.</td>
        </tr>
    </tbody></table>
    
    
</div>

    </div>