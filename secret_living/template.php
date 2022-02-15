<?php

$sql=mysqli_query($db,"SELECT t1.*,t2.* from user_id t1 join user_detail t2 on t1.uid =t2.uid where t1.uname = '$tuser_id'");
$row = mysqli_fetch_assoc($sql);
$tname = $row['first_name']." ".$row['last_name'];
$tuser_id = $row['uname'];
$address = $row['address'];
$city = $row['city']; 
$zip = $row['zip'];
?>
<!-- <div style="border: 5px solid #006699;padding: 5px;"> -->
<div style="padding: 50px;width:70%;padding-left:15%;padding-right:15%; ">
     <!-- border:2px solid #2CA8E6; -->
    <div id="ContentPlaceHolder1_Panel1" style=" padding:2px;">
    
        <table id="ContentPlaceHolder1_Table1" border="0" width="100%">
            <tbody>
                <tr>
                    <td align="left" colspan="2" style="border-bottom:5px solid #62d2a2;margin-left: 200px;margin-right: 200px;">
                      <img src="../images/logo.jpeg" width="10%">
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2">
                            &nbsp;
                        </td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="padding-left: 30px;"><h4 class="style3"> Varietiz Pharma Pvt Ltd.<br>
                                yashodeep housing society office no. 408,<br>
                                near kailash complex vikroli Mumbai 400079.<br>
                                Mumbai, Maharashtra-400101<br>Mobile : +91 9324345389,<br>
                                Email : info@varietiz.com<br></h4></td>
                </tr>
                <tr>
                    <td align="left" colspan="2"><h1 class="style3"> <?= $tname;?></h1></td>
                </tr>
                
                <tr>
                    <td align="left" colspan="2">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>ID : <?=$tuser_id; ?></td>
                    <td>DOJ : <?=$date; ?></td>
                </tr>
                <tr>
                    <td>Address : <?=$address; ?></td>
                    <td>City : <?=$city; ?></td>
                </tr>
                <tr>
                    <td>Pin code : <?=$zip; ?></td>
                    <td>User Name : <?=$tuser_id; ?></td>
                </tr>
                <tr>
                    <td align="left" colspan="2">
                        &nbsp;
                    </td>
                </tr>
                    <td align="left" colspan="2"><h1 class="style3"> Congratulations!!!</h1></td>
                </tr>
                <tr>
                    <td align="left" class="style1" colspan="2">
                            &nbsp;
                        </td>
                </tr>
                <tr>
                    <td style="text-align: justify" colspan="2">
                        <p class="MsoNormal">
                            <span lang="EN-US">Well begun is half done .I’d like to welcome you to Varietiz. We are glad that you have joined us
                        <o:p></o:p></span></p>
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
                            <span lang="EN-US">We believe that this letter finds you mutually excited about your new opportunity with Varietiz</span></p>
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
                            <span lang="EN-US">Each of us will play a vital role to ensure your successful mingle into the company. Your agenda will involve planning your orientation with company and setting some initial work goals so that you feel immediately productive in your new role. And urther growing into an integral part of this business providing you an opportunity to earn money which is optional, your earnings will depend directly in the amount of efforts you put to develop your business. Again, welcome to the team. If you have questions prior to your start date, please contact us at any time, or send email if that is more convenient. We look forward to having you come onboard. The secret of success is constancy.</span></p>
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
                            <span lang="EN-US">We wish you a very good luck !!</span></p>
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: left" colspan="2">
                        <p class="MsoNormal">
                            <span lang="EN-US">Best Regards,</span></p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left" colspan="2">
                        <p class="MsoNormal">
                            <span lang="EN-US">Chief Admin Officer</span></p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left" colspan="2">
                        <p class="MsoNormal">
                            <span lang="EN-US">Varietiz Pharma Pvt Ltd.</span></p>
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: left" colspan="2">
                        <p class="MsoNormal">
                            <span lang="EN-US"> Varietiz Pharma Pvt Ltd., yashodeep housing society office no. 408,near kailash complex vikroli Mumbai 400079. Mumbai, Maharashtra-400101, E-mail :info@varietiz.com, WebSite : www.varietiz.com</span></p>
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" colspan="2">Copyright &copy; 2020 DSV Info Solutions Pvt. Ltd.  All Rights Reserved.</td>
                </tr>
            </tbody>
        </table>
    
    
    </div>

</div>