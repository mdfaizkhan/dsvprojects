<?php
require_once 'lib/phpmailer/PHPMailerAutoload.php';


define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
define('KB', 1000);
define('MB', 1000000);
define('GB', 1000000000);
define('TB', 1000000000000);

/*
 * Ban Word Array
 */
$banword = array("anal","anus","arse","ass","ballsack","balls","bastard","bitch","biatch","bloody","blowjob","blow job","bollock","bollok","boner","boob","bugger","bum","butt","buttplug","clitoris","cock","coon","crap","cunt","damn","dick","dildo","dyke","fag","feck","fellate","fellatio","felching","fuck","f u c k","fudgepacker","fudge packer","flange","Goddamn","God damn","hell","homo","jerk","jizz","knobend","knob end","labia","lmao","lmfao","muff","nigger","nigga","omg","penis","piss","poop","prick","pube","pussy","queer","scrotum","sex","shit","s hit","sh1t","slut","smegma","spunk","tit","tosser","turd","twat","vagina","wank","whore","wtf");
/*
 * Check Foul Language
 */
function CheckFoulLanguage($string)
{
    global $banword;
    $fileterban = "(".implode('|',$banword).")";
    preg_match("/$fileterban/", $string, $matches, PREG_OFFSET_CAPTURE);
    if(isset($matches[0]) && count($matches[0])>0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
/*
 * Check Email-id Present in body
 */
function CheckEmailPresent($string)
{
    $pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
    preg_match_all($pattern, $string, $matches);
    if(isset($matches[0]) && count($matches[0])>0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
/*
 * Check body consist of number greater than 4
 */
function ContainsNumbers($string){
    $pattern = '/(\d{5,})/';
    preg_match_all($pattern, $string, $matches);
    if(isset($matches[0]) && count($matches[0])>0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/*
 * MAsk Credit numbers
 */
function ccMasking($number, $maskingCharacter = 'X') {
    return str_repeat($maskingCharacter, strlen($number) - 4) . substr($number, -4);
}
/*
 * Get Initial of String
 */
function getInitial($string)
{
    return substr($string, 0, 1);
}
/*
 * Secure Email
 */
function secureEmail($email)
{
    $em   = explode("@",$email);
    $name = implode(array_slice($em, 0, count($em)-1), '@');
    $len  = floor(strlen($name)/2);
    $len2 = strlen($name) - $len;
    return substr($name,0, $len) . str_repeat('*', $len2) . "@" . end($em);

}
/*
 * Function to generate password and pin
 */
function special_code($length) 
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

function random_password($length) 
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
function encrypt_password($password) 
{
    $hash_cost_factor = 10;
    $e_pwd = password_hash($password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor) );
    return $e_pwd;
}

function verify_password($current,$system)
{
    return password_verify($current, $system);
}

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'TestKeys456';
    $secret_iv = 'TestKeys782';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}


/*
 * Function to generate pin
 */
function random_pin($length) 
{
    $chars = "0123456789";
    $pin = substr( str_shuffle( $chars ), 0, $length );
    return $pin;
}
/*
 * get Ip Address
 */
function get_userip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP'];} 
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; } 
    else { $ip = $_SERVER['REMOTE_ADDR']; }
    return $ip;
}

/*
 * function truncate string
 */
function truncate($string,$length)
{
    $string = strip_tags($string);
    if (strlen($string) > $length)
    {
        // truncate string
        $stringCut = substr($string, 0, $length);
        // make sure it ends in a word so assassinate doesn't become ass...
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
    }
    return $string;
}
/*
 * Function to add dash to us number
 */
function localize_us_number($phone) {
    $numbers_only = preg_replace("/[^\d]/", "", $phone);
    return preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $numbers_only);
}
function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
}
/*
 * function to get specific length number or padding with zero
 */
function leftPad($number, $targetLength)
{
    $output = $number . '';
    while (strlen($output) < $targetLength) {
        $output = '0' . $output;
    }
    return $output;
}

/*
 *  PHP Mail Sending Code
 */
function send_phpmail1( $toname, $to ,$fromname, $from , $subject, $body )
{
    global $mailsetting;

    if(empty($from))
    {

        $fromname = $mailsetting['defaultfromname'];
        $from = $mailsetting['defaultfromemail'];
    }
    if(empty($to))
    {
        $toname = $mailsetting['defaulttoname'];
        $to = $mailsetting['defaulttoemail'];
    }
    $cc = $mailsetting['defaultccemail'];
    $header = "From: $fromname <$from> \r\n";
    if(!empty($cc))
    {
        $header .= "Cc: $cc \r\n";
    }

    $header .= 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    //send mail
    if(mail( $to, $subject, $body, $header))
    {
        return true;
    }
    else
    {
        return false;
    }

}
function sendphpemail1($to,$toname,$users,$subject,$message)
{
    global $mailsetting;

    if(!isset($from))
    {
        $fromname = $mailsetting['defaultfromname'];
        $from = $mailsetting['defaultfromemail'];
    }
    $usersemail = implode(", ",$users);
    $header = "From: $fromname <$from> \r\n";
    if(!empty($users))
    {
        $header .= "Bcc: $usersemail \r\n";
    }
    $header .= 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    //send mail
    if(mail( $to, $subject, $message, $header))
    {
        return true;
    }
    else
    {
        return false;
    }

}
/*
 * PHP Mail With Attachment
 */
function send_phpmail_attach1( $toname, $to ,$fromname, $from , $subject, $html_content, $filename )
{
    global $mailsetting;

    if(empty($from))
    {
        $fromname = $mailsetting['defaultfromname'];
        $from = $mailsetting['defaultfromemail'];
    }
    if(empty($to))
    {
        $toname = $mailsetting['defaulttoname'];
        $to = $mailsetting['defaulttoemail'];
    }

    $cc = $mailsetting['defaultccemail'];

    $text_content = '';
    $path = 'temp';
    $file = $path . "/" . $filename;
    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));
    # Setup mime boundary
    $mime_boundary = 'Multipart_Boundary_x'.md5(time()).'x';

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\r\n";
    $headers .= "Content-Transfer-Encoding: 7bit\r\n";

    $body    = "This is a multi-part message in mime format.\n\n";

    # Add in plain text version
    $body   .= "--$mime_boundary\n";
    $body   .= "Content-Type: text/plain; charset=\"charset=us-ascii\"\n";
    $body   .= "Content-Transfer-Encoding: 7bit\n\n";
    $body   .= $text_content;
    $body   .= "\n\n";

    # Add in HTML version
    $body   .= "--$mime_boundary\n";
    $body   .= "Content-Type: text/html; charset=\"UTF-8\"\n";
    $body   .= "Content-Transfer-Encoding: 7bit\n\n";
    $body   .= $html_content;
    $body   .= "\n\n";

    # Attachments would go here
    $body   .= "--$mime_boundary\n";
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\n";
    $body .= "Content-Transfer-Encoding: base64 \n\n";
    $body .= "Content-Disposition: attachment\n\n";
    $body .= $content;
    $body   .= "\n\n";

    # End email
    $body   .= "--$mime_boundary--\n"; # <-- Notice trailing --, required to close email body for mime's

    # Finish off headers
    $headers .= "From: $fromname <$from>\r\n";
    //$headers .= "X-Sender-IP: $_SERVER[SERVER_ADDR]\r\n";
    if(!empty($cc))
    {
        $headers .= "Cc: $cc \r\n";
    }
    $headers .= 'Date: '.date('n/d/Y g:i A')."\r\n";

    # Mail it out
    $mail = mail($to, $subject, $body, $headers);
    if ($mail) {
        return true;
    } else {
        return "Mail not sent";

    }

}
/*
 *  Mail Sending Code	
 */
function send_phpmail( $toname, $to ,$fromname, $from , $subject, $body )
{
    global $mailsetting;
    if(empty($from))
    {
        $from = $mailsetting['defaultfromemail'];
    }
    if(empty($fromname))
    {

        $fromname = $mailsetting['defaultfromname'];
    }
    if(empty($to))
    {
        $toname = $mailsetting['defaulttoname'];
        $to = $mailsetting['defaulttoemail'];
    }
    $mail = new PHPMailer;
    //$mail->isSMTP();
    $mail->IsMail();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = $mailsetting['Host'];
    $mail->Port = $mailsetting['Port'];
    $mail->SMTPSecure = $mailsetting['SMTPSecure'];
    $mail->SMTPAuth = $mailsetting['SMTPAuth'];
    $mail->Username = $mailsetting['gmail_username'];
    $mail->Password = $mailsetting['gmail_password'];
    $mail->setFrom($from, $fromname);
    $mail->addReplyTo($from, $fromname);
    $mail->addAddress($to, $toname);
    if(!empty($mailsetting['defaultccemail'])){
        $mail->AddCC($mailsetting['defaultccemail'], $mailsetting['defaultccname']);
    }

    $mail->AddEmbeddedImage('../assets/images/logo.png', "logo_2u");
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body    = $body;
    if (!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
		return true;
    }
	
}
//send_phpmail( '', '' ,'', '' , 'test rhis', 'yes' );

function sendphpemail($to,$toname,$users,$subject,$message)
{
    global $mailsetting;

    if(!isset($from))
    {

        $fromname = $mailsetting['defaultfromname'];
        $from = $mailsetting['defaultfromemail'];
    }

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = $mailsetting['Host'];
    $mail->Port = $mailsetting['Port'];
    $mail->SMTPSecure = $mailsetting['SMTPSecure'];
    $mail->SMTPAuth = $mailsetting['SMTPAuth'];
    $mail->Username = $mailsetting['gmail_username'];
    $mail->Password = $mailsetting['gmail_password'];
    $mail->setFrom($from, $fromname);
    $mail->addReplyTo($from, $fromname);
    $mail->addAddress($to, $toname);
    foreach ($users as $useremail)
    {
        $mail->AddBCC($useremail, $useremail);
    }
    //Added extra
    if(!empty($mailsetting['defaultccemail'])){
        $mail->AddCC($mailsetting['defaultccemail'], $mailsetting['defaultccname']);
    }
    $mail->AddEmbeddedImage('../assets/images/logo.png', "logo_2u");
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body    = $message;
    if (!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return true;
    }

}
function sendMultipleEmailAttachment($to,$toname,$fromname,$subject,$message,$attachment=array())
{
    global $mailsetting;

    if(!isset($from))
    {
        $from = $mailsetting['defaultfromemail'];
    }
    if(empty($fromname))
    {
        $fromname = $mailsetting['defaultfromname'];
    }

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = $mailsetting['Host'];
    $mail->Port = $mailsetting['Port'];
    $mail->SMTPSecure = $mailsetting['SMTPSecure'];
    $mail->SMTPAuth = $mailsetting['SMTPAuth'];
    $mail->Username = $mailsetting['gmail_username'];
    $mail->Password = $mailsetting['gmail_password'];
    $mail->setFrom($from, $fromname);
    //$mail->addReplyTo($from, $fromname);
    $mail->addAddress($to, $toname);

    //Added extra
    if(!empty($mailsetting['defaultccemail'])){
        $mail->AddCC($mailsetting['defaultccemail'], $mailsetting['defaultccname']);
    }

    $mail->AddEmbeddedImage('../assets/images/powered.png', "poweredby_2u");
    $mail->AddEmbeddedImage('../upload/barcode/'.$attachment['refercode'].".png", "refercode_2u");
    $mail->AddEmbeddedImage('../upload/images/'.$attachment['clogo'], "clogo_2u");
    $mail->AddEmbeddedImage('../assets/images/logo.png', "logo_2u");
    /*if(isset($attachment['marketing']) && !empty($attachment['marketing'])){
        $mail->AddAttachment( "../upload/attachment/".$attachment['marketing'], $attachment['marketing']);
    }*/
    //$mail->AddAttachment( "../upload/barcode/".$attachment['refercode'], $attachment['refercode']);
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body    = $message;
    if (!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return true;
    }

}


/*
 * Get User Data
 */
function checkUser($userData = array(),$db)
{
    if(!empty($userData))
    {
        $prevQuery = "SELECT * FROM consumer WHERE oauth_provider in ('facebook','website','google','twitter') AND email = '".$userData['email']."'";
        $prevResult = $db->query($prevQuery);
        if($prevResult->num_rows > 0)
        {
            //Update user data if already exists
            $query = "UPDATE consumer SET fullname = '".$userData['first_name']." ".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider in ('facebook','website','google') AND email = '".$userData['email']."'";
            $update = $db->query($query);
        }
        else
        {
            
            //Insert user data
            $query = "INSERT INTO consumer SET oauth_uid = '".$userData['oauth_uid']."', fullname = '".$userData['first_name']." ".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."',oauth_provider = '".$userData['oauth_provider']."', link = '".$userData['link']."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'";
            $insert = $db->query($query);            
        }

        //Get user data from the database
        $result = $db->query($prevQuery);
        $userData = $result->fetch_assoc();
        
    }
    return $userData;
}

//curl function
function curl($url, $post = "") {
    $curl = curl_init();
    $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
    curl_setopt($curl, CURLOPT_URL, $url);
    //The URL to fetch. This can also be set when initializing a session with curl_init().
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
    //The number of seconds to wait while trying to connect.
    if ($post != "") {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
    //The contents of the "User-Agent: " header to be used in a HTTP request.
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    //To follow any "Location: " header that the server sends as part of the HTTP header.
    curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
    //To automatically set the Referer: field in requests where it follows a Location: redirect.
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    //The maximum number of seconds to allow cURL functions to execute.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    //To stop cURL from verifying the peer's certificate.
    $contents = curl_exec($curl);
    curl_close($curl);
    return $contents;
}

function isHtmlDiff($old,$new)
{
    $diff = new HtmlDiff($old, $new);
    $diff->build();
    $a = $diff->getDifference();
    if (strpos($a, '<ins') !== false) {
        return true;
    }
    else
    {
        return false;
    }
}

function Pagination($db,$sql,$rpage,$req,$limit)
{

    $adjacents = 3;
    //$query = "SELECT COUNT(*) as num FROM $table";
    $total_pages = mysqli_num_rows(mysqli_query($db,$sql));
    if($limit == 'ALL')
    {
        $limit = $total_pages;
    }
    //$total_pages = $total_pages['num'];

    /* Setup vars for query. */
    $targetpage = $rpage;    //your file name  (the name of this file)

    //$page = $_GET['page'];
    $page = isset($_GET['page'])?$_GET['page']:0;
    if($page)
        $start = ($page - 1) * $limit;          //first item to display on this page
    else
        $start = 0;                             //if no page var is given, set start to 0

    /* Get data. */
    $Pqry=$sql." LIMIT $start, $limit";
    //echo $Pqry;
    $result = mysqli_query($db,$Pqry);

    /* Setup page vars for display. */
    if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
    $prev = $page - 1;                          //previous page is page - 1
    $next = $page + 1;                          //next page is page + 1
    $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;
    if(mysqli_num_rows($result)>0)
    {
        $pagination = $request = "";
        if(isset($req) && !empty($req))
        {
            $request='&'.implode("&",$req);
        }
        if($lastpage > 1)
        {
            $pagination .= "<div class=\"pagination\">";
            //previous button
            if ($page > 1)
                $pagination.= "<a href=\"$targetpage?page=$prev$request\"><i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i> </a>";
            else
                $pagination.= "<span class=\"disabled\"><i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i> </span>";

            //pages
            if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
            {
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"current\">$counter</span>";
                    else
                        $pagination.= "<a href=\"$targetpage?page=$counter$request\">$counter</a>";
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
            {
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2))
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?page=$counter$request\">$counter</a>";
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$targetpage?page=$lpm1$request\">$lpm1</a>";
                    $pagination.= "<a href=\"$targetpage?page=$lastpage$request\">$lastpage</a>";
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<a href=\"$targetpage?page=1$request\">1</a>";
                    $pagination.= "<a href=\"$targetpage?page=2$request\">2</a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?page=$counter$request\">$counter</a>";
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$targetpage?page=$lpm1$request\">$lpm1</a>";
                    $pagination.= "<a href=\"$targetpage?page=$lastpage$request\">$lastpage</a>";
                }
                //close to end; only hide early pages
                else
                {
                    $pagination.= "<a href=\"$targetpage?page=1$request\">1</a>";
                    $pagination.= "<a href=\"$targetpage?page=2$request\">2</a>";
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?page=$counter$request\">$counter</a>";
                    }
                }
            }

            //next button
            if ($page < $counter - 1)
                $pagination.= "<a href=\"$targetpage?page=$next$request\"> <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>";
            else
                $pagination.= "<span class=\"disabled\">  <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></span>";
            $pagination.= "</div>\n";
        }
    }
    else {

        $pagination="<center><h5><i>No Records found...</i></h5></center>";

    }
    $record = array(
        "pagination" => $pagination,
        "result" => $result
    );
    return $record;
}
function CPagination($db,$sql,$rpage,$req,$limit,$pagename)
{
    $adjacents = 3;
    //$query = "SELECT COUNT(*) as num FROM $table";
    $total_pages = mysqli_num_rows(mysqli_query($db,$sql));
    if($limit == 'ALL')
    {
        $limit = $total_pages;
    }
    //$total_pages = $total_pages['num'];

    /* Setup vars for query. */
    $targetpage = $rpage;    //your file name  (the name of this file)

    //$page = $_GET['page'];
    $page = isset($_REQUEST[$pagename])?$_REQUEST[$pagename]:0;
    if($pagename == 'jpage')
    {
        $pagename = 'typeid=1&jpage';
    }
    else if($pagename == 'npage')
    {
        $pagename = 'typeid=2&npage';
    }
    else
    {
        $pagename = 'typeid=3&bpage';
    }
    if($page)
        $start = ($page - 1) * $limit;          //first item to display on this page
    else
        $start = 0;                             //if no page var is given, set start to 0

    /* Get data. */
    $Pqry=$sql." LIMIT $start, $limit";
    //echo $Pqry;
    $result = mysqli_query($db,$Pqry);

    /* Setup page vars for display. */
    if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
    $prev = $page - 1;                          //previous page is page - 1
    $next = $page + 1;                          //next page is page + 1
    $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;
    if(mysqli_num_rows($result)>0)
    {
        $pagination = $request = "";
        /*if(isset($req) && !empty($req))
        {
            $request='&'.implode("&",$req);
        }*/
        $request = '&'.$req;
        if($lastpage > 1)
        {
            $pagination .= "<div class=\"pagination\">";
            //previous button
            if ($page > 1)
                $pagination.= "<a href=\"$targetpage?$pagename=$prev$request\"><i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i> </a>";
            else
                $pagination.= "<span class=\"disabled\"><i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i> </span>";

            //pages
            if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
            {
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"current\">$counter</span>";
                    else
                        $pagination.= "<a href=\"$targetpage?$pagename=$counter$request\">$counter</a>";
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
            {
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2))
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?$pagename=$counter$request\">$counter</a>";
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$targetpage?$pagename=$lpm1$request\">$lpm1</a>";
                    $pagination.= "<a href=\"$targetpage?$pagename=$lastpage$request\">$lastpage</a>";
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<a href=\"$targetpage?$pagename=1$request\">1</a>";
                    $pagination.= "<a href=\"$targetpage?$pagename=2$request\">2</a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?$pagename=$counter$request\">$counter</a>";
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$targetpage?$pagename=$lpm1$request\">$lpm1</a>";
                    $pagination.= "<a href=\"$targetpage?$pagename=$lastpage$request\">$lastpage</a>";
                }
                //close to end; only hide early pages
                else
                {
                    $pagination.= "<a href=\"$targetpage?$pagename=1$request\">1</a>";
                    $pagination.= "<a href=\"$targetpage?$pagename=2$request\">2</a>";
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?$pagename=$counter$request\">$counter</a>";
                    }
                }
            }

            //next button
            if ($page < $counter - 1)
                $pagination.= "<a href=\"$targetpage?$pagename=$next$request\"> <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></a>";
            else
                $pagination.= "<span class=\"disabled\">  <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i></span>";
            $pagination.= "</div>\n";
        }
    }
    else {

        $pagination="<center><h5><i>No Records found...</i></h5></center>";

    }
    $record = array(
        "pagination" => $pagination,
        "result" => $result
    );
    return $record;
}

function dbDate($date)
{
    return date('Y-m-d',strtotime($date));
}

function modifyDate($date)
{
    return date('Y-m-d',strtotime($date));
}

function modifyDateTime($datetime)
{
    return date('m/d/Y H:i ',strtotime($datetime));
}
function modifyTime($datetime)
{
    $date = DateTime::createFromFormat( 'Y-m-d H:i:s.u', $datetime);
    return $date->format( 'h:i a');
}
function checkRegisterPin($db,$pin)
{
    $q1 = $db->query("SELECT * FROM `transpin` WHERE `pin_code` = '$pin'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        if($r1["status"] == 0)
        {
            return 1;
        }
        else
        {
            return "PIN is Already Used";
        }
    }
    else
    {
        return "Not A Valid Pin";
    }
}

function addRegisterPin($db,$pin,$uid)
{
    $q1 = $db->query("SELECT * FROM `registerpin` WHERE `pin_code` = '$pin'");
    if(mysqli_num_rows($q1)>0)
    {
        $r1 = mysqli_fetch_assoc($q1);
        if($r1["status"] == 0)
        {
            $q3 = $db->query("UPDATE `user_id` SET `rpin`= '$pin' WHERE `uid`  = '$uid'");
            $q3 = $db->query("UPDATE `registerpin` SET `uid`= '$uid',`status`= 1 WHERE `pin_code`  = '$pin'");
            return true;
        }
        else
        {
            return "Code is already used";
        }
    }
    else
    {
        return "Not a valid code";
    }
}


// Assign Sponser to user 
function addadminsponser($db,$sponser,$child,$direct_sponser,$position)
{   
    
    $q9 = $db->query("SELECT * FROM `pairing` WHERE `lchild` = '$child' or rchild = '$child'");
    if((mysqli_num_rows($q9)<1))
    {
        $q8 = $db->query("SELECT * FROM `pairing` WHERE `lchild` = '$sponser' or rchild = '$sponser'");
        if((mysqli_num_rows($q8)>0) || ($sponser == 1))
        {
            if($position=="left") {$pchild = 'lchild'; $pcount = 'lcount'; $poscount = 'leftcount';}
            else {$pchild = 'rchild'; $pcount = 'rcount'; $poscount = 'rightcount';}
            $q1 = $db->query("SELECT * FROM `pairing` WHERE `parent_id` = '$sponser'");


            if(mysqli_num_rows($q1)>0)
            {
                    $r1 = mysqli_fetch_assoc($q1);
                    if(empty($r1[$pchild]))
                    {
                        $q2 = $db->query("UPDATE `pairing` SET `$pchild` = '$child' WHERE parent_id = '$sponser'");

                        //update pairing table
                        $q3 = mysqli_fetch_assoc( mysqli_query($db, " SELECT * FROM `pairing` WHERE `parent_id` = '$sponser'"));
                        $rcount = $q3[$pcount] + 1;
                        $q4 = $db->query("UPDATE pairing SET `$pcount` = $rcount WHERE parent_id = '$sponser'" );

                        //Check for paid and update parent counter
                        //
                        //$q7 = mysqli_num_rows( mysqli_query($db, "SELECT * FROM `transpin` WHERE `uid` = '$child'"));
                        $q7 = mysqli_query($db, "SELECT t2.plan_name,t2.plan_amount,t2.commission FROM `transpin` t1 join plans t2 on t1.plan_id = t2.plan_id WHERE t1.`uid` = '$child'");

                        $paidcount = false;
                        $paidamount = 0;
                        if(mysqli_num_rows($q7)>0)
                        {
                                //update child_counter table
                            $paidcount = true;
                            $r7 = mysqli_fetch_assoc($q7);
                            $paidamount = intval($r7['commission']);
                            $q5 = mysqli_fetch_assoc( mysqli_query($db, " SELECT * FROM `child_counter` WHERE `parent_id` = '$sponser'"));
                            $rightcount = intval($q5[$poscount]) + $paidamount;
                            $q6 = $db->query("UPDATE child_counter SET `$poscount` = '$rightcount' WHERE parent_id = '$sponser'" );
                        }
                        if($q2)
                        {
                            $q5 = mysqli_fetch_assoc( mysqli_query($db, " SELECT * FROM `child_counter` WHERE `parent_id` = '$sponser'"));
                            $upcount = "u".$poscount;
                            $rightcount = $q5[$upcount] + 1;
                            $sql = "UPDATE child_counter SET `$upcount` = $rightcount WHERE parent_id = '$sponser'";
                            $q6 = $db->query($sql );

                            child_counter($db,$sponser,$paidcount,$paidamount);
                            update_direct_child_count($db,$direct_sponser,$child);
                            if($direct_sponser == $sponser)
                            {
                                updateBonus($db,$direct_sponser,$child,$pchild);
                            }
                            else
                            {
                                $childpos = getChildPosition($db,$direct_sponser,$sponser);
                                updateBonus($db,$direct_sponser,$child,$childpos);
                            }
                            return 1;
                        }
                        else
                        {
                            return "Pairing not added";
                        }
                    }
                    else
                    {
                        return addadminsponser($db,$r1[$pchild],$child,$direct_sponser,$position); 
                    }
            }
            else
            {
                $q2 = $db->query("INSERT INTO `pairing`(`parent_id`, `$pchild`) VALUES ('$sponser','$child')");
                if($q2)
                {
                    $pair_id = $db->insert_id;
                    $q3 = $db->query("UPDATE `user_id` SET `paired`= '$pair_id' WHERE uid = '$sponser'");

                    //update pairing table
                    $q4 = mysqli_fetch_assoc( mysqli_query($db, " SELECT * FROM `pairing` WHERE `parent_id` = '$sponser'"));
                    $lcount = $q4[$pcount] + 1;
                    $q5 = $db->query("UPDATE pairing SET `$pcount` = $lcount WHERE parent_id = '$sponser'" );

                    //Check for paid and update parent counter
                    $q7 = mysqli_query($db, "SELECT t2.plan_name,t2.plan_amount,t2.commission FROM `transpin` t1 join plans t2 on t1.plan_id = t2.plan_id WHERE t1.`uid` = '$child'");

                    $paidcount = false;
                    $paidamount = 0;
                    if(mysqli_num_rows($q7)>0)
                    {
                        //update child_counter table
                        $paidcount = true;
                        $r7 = mysqli_fetch_assoc($q7);
                        $paidamount = intval($r7['commission']);
                        $q6 = mysqli_fetch_assoc( mysqli_query($db, " SELECT * FROM `child_counter` WHERE `parent_id` = '$sponser'"));
                        $leftcount = intval($q6[$poscount]) + $paidamount;
                        $q6 = $db->query("UPDATE child_counter SET `$poscount` = '$leftcount' WHERE parent_id = '$sponser'" );
                    }
                    if($q3)
                    {

                        $q6 = mysqli_fetch_assoc( mysqli_query($db, " SELECT * FROM `child_counter` WHERE `parent_id` = '$sponser'"));
                        $upcount = "u".$poscount;
                        $leftcount = $q5[$upcount] + 1;
                        $q7 = $db->query("UPDATE child_counter SET `$upcount` = $leftcount WHERE parent_id = '$sponser'" );

                        child_counter($db,$sponser,$paidcount,$paidamount);
                        update_direct_child_count($db,$direct_sponser,$child);
                        if($direct_sponser == $sponser)
                        {
                            updateBonus($db,$direct_sponser,$child,$pchild);
                        }
                        else
                        {
                            $childpos = getChildPosition($db,$direct_sponser,$sponser);
                            updateBonus($db,$direct_sponser,$child,$childpos);
                        }

                        return 1;
                    }
                    else
                    {
                            return "Pairing not updated";
                    }
                }
                else
                {
                    return "Pairing not added";
                }
             }
        }
        else
        {
            return "Sponser doesn't have any sponser.";
        }
    }
    else
    {
        return "Child user Already have a Sponser.";
    }
}
function sendSMS($db,$uid,$message)
{
    $q1 = mysqli_query($db,"SELECT `mobile` FROM `user_detail` WHERE `uid` = '$uid'");
    if(mysqli_num_rows($q1)>0)
    {
        /*$r1 = mysqli_fetch_assoc($q1);
        if(!empty($r1['mobile']))
        {
            $mobileno = $r1['mobile'];
            $requestParams = array(
                'user' => 'frentic',
                'pass' => 'latest@123',
                'sender' => 'FRENTC',
                'phone' => $mobileno,
                'text' => $message,
                'priority' => 'ndnd',
                'stype' => 'normal'
            );
            $url = "http://sms.dsvinfosolutions.com/api/sendmsg.php?";
            foreach($requestParams as $key => $val){
                if($key!='user' && $key!='pass')
                {
                    $url .= $key.'='.urlencode($val).'&';
                }
                else
                {
                    $url .= $key.'='.$val.'&';
                }
            }
            $url = rtrim($url, "&");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);
            curl_close($ch);
        }*/
    }

    return true;
}

function sendSMS1($db)
{
    $mobileno = '9172434045';
    $message="test frentic";
    if(!empty($mobileno))
    {

        $requestParams = array(
            'user' => 'frentic',
            'pass' => 'latest@123',
            'sender' => 'FRENTC',
            'phone' => $mobileno,
            'text' => $message,
            'priority' => 'ndnd',
            'stype' => 'normal'
        );
        //$url = "http://bhashsms.com/api/sendmsg.php?";
        $url = "http://sms.dsvinfosolutions.com/api/sendmsg.php?";
        foreach($requestParams as $key => $val){
            $url .= $key.'='.urlencode($val).'&';
        }
        
        $url = rtrim($url, "&");
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
    }
    return true;
}


?>