<?php

defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author Balaji
 * @name: Rainbow PHP Framework
 * @copyright 2021 ProThemes.Biz
 *
 */

$pageTitle = 'Ban IP Address';
$subTitle = 'Add User IP to Ban';
$fullLayout = 1; $footerAdd = false; $footerAddArr = array();

if($pointOut == 'delete'){
    $code = $args[0];
    if($args[0] != ''){
        $query = "DELETE FROM banned_ip WHERE id='$args[0]'";
        $result = mysqli_query($con, $query);
    
        if (mysqli_errno($con)) {
            $msg = errorMsgAdmin(mysqli_error($con));

        } else {
            header('Location:'.adminLink($controller,true));
            die();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $ban_ip = escapeTrim($con, $_POST['ban_ip']);
    $banReason = escapeTrim($con, $_POST['reason']);
    
    if (!filter_var($ban_ip, FILTER_VALIDATE_IP) === false) {
    $query = "INSERT INTO banned_ip (added_at,ip,reason) VALUES ('$date','$ban_ip','$banReason')";
    mysqli_query($con, $query);
   
    if (mysqli_errno($con))
        $msg = errorMsgAdmin(mysqli_error($con));
    else 
        $msg =  successMsgAdmin('IP added to database successfully.');
   
    } else {
        $msg = errorMsgAdmin('IP is not valid!');
    }
}


$bannedList = array();
$result = mysqli_query($con,"SELECT id,added_at,ip,reason FROM banned_ip");
while($row = mysqli_fetch_assoc($result))
  $bannedList[] = $row;