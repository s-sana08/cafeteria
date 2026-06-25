<?php
include_once('config.php');

$vndemail = $_POST['vndemail'] ?? ''; 
$id = $_POST['id'] ?? ''; 

if ($vndemail == '') {
    echo json_encode(false);
    exit;
}

if ($id) {
    // Update mode
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM user_master WHERE email_id = ? AND id != ?");
    $stmt->bind_param("si", $vndemail, $id);
} else {
    // Insert mode
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM user_master WHERE email_id = ?");
    $stmt->bind_param("s", $vndemail);
}

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['cnt'] > 0) {
    echo json_encode(false); // duplicate
} else {
    echo json_encode(true);  // OK
}
?>