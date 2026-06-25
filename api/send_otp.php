<?php
include_once('config.php');

header('Content-Type: application/json');

session_set_cookie_params(['path' => '/']);
session_start();

$email = $_POST['email'] ?? '';

if ($email == '') {
    echo json_encode(['status' => 'error', 'message' => 'Email required']);
    exit;
}

// check email exists
$stmt = $conn->prepare("SELECT id FROM user_master WHERE email_id = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'exists', 'message' => 'Email already exists']);
    exit;
}

// generate OTP
$otp = rand(100000, 999999);

$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;
$_SESSION['otp_time'] = time();

// ----------------------
// EMAIL SEND (PHPMailer)
// ----------------------

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    $mail->Username   = 'youremail@gmail.com';  //chaange this
    $mail->Password   = 'your app password';    //chaange this

    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('sana.shaikh.dev@gmail.com', 'SS Cafeteria');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Your OTP Code";
    $mail->Body    = "Your OTP is: <b>$otp</b>";

    $mailSent = $mail->send();

} catch (Exception $e) {
    $mailSent = false;
}

// ----------------------

if ($mailSent) {
    echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Mail sending failed']);
}

exit;
?>
