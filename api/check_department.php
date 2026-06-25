<?php
include_once('config.php');

$dprtname = trim($_POST['txtdprtname'] ?? '');
$id = $_POST['id'] ?? '';

if($id) {
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM department_master WHERE department_name=? AND id!=?");
    $stmt->bind_param("si", $dprtname, $id);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM department_master WHERE department_name=?");
    $stmt->bind_param("s", $dprtname);
}

$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

// jQuery Validate expects true/false
echo $row['cnt'] > 0 ? "false" : "true";
?>