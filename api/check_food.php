<?php
include_once('config.php');

$foodname = trim($_POST['txtfoodname'] ?? '');
$id = $_POST['id'] ?? '';

if ($id) {
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM food_type_master WHERE food_type_name=? AND id!=?");
    $stmt->bind_param("si", $foodname, $id);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM food_type_master WHERE food_type_name=?");
    $stmt->bind_param("s", $foodname);
}

$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

// jQuery Validate expects 'true' if valid, 'false' if invalid
echo $result['cnt'] > 0 ? "false" : "true";
?>