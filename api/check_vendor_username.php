<?php
include_once('config.php');

$vndusernm = $_POST['vndusernm'] ?? ''; 
$id = $_POST['id'] ?? ''; 

if ($vndusernm == '') {
    echo json_encode(false);
    exit;
}

if ($id) {
    // Update mode
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM user_master WHERE username = ? AND id != ?");
    $stmt->bind_param("si", $vndusernm, $id);
} else {
    // Insert mode
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM user_master WHERE username = ?");
    $stmt->bind_param("s", $vndusernm);
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