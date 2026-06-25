<?php
session_start();
header('Content-Type: application/json');

if(isset($_POST['otp'])) {

    $otp = $_POST['otp'];

    if(!isset($_SESSION['otp'])) {
        echo json_encode(['status'=>'error','message'=>'No OTP found']);
        exit;
    }

    if($_SESSION['otp'] == $otp) {
        echo json_encode(['status'=>'success','message'=>'OTP verified']);
    } else {
        echo json_encode(['status'=>'invalid','message'=>'Wrong OTP']);
    }
}
?>