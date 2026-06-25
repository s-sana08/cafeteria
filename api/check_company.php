<?php
include_once('config.php');

$compname = trim($_POST['txtcompname'] ?? '');
$id = $_POST['id'] ?? '';

if ($id) {
    // update mode, स्वतःच्या ID ignore करा
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM company_master WHERE company_name=? AND id!=?");
    $stmt->bind_param("si", $compname, $id);
} else {
    // insert mode
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM company_master WHERE company_name=?");
    $stmt->bind_param("s", $compname);
}

$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

// jQuery Validate expects 'true' if valid, 'false' if invalid
echo $result['cnt'] > 0 ? "false" : "true";
?>