<?php
include_once('config.php');

$empid = $_POST['empid'] ?? ''; 
$id = $_POST['id'] ?? ''; 

if ($empid == '') {
    echo json_encode(false);
    exit;
}

if ($id) {
    // Update mode: exclude current record
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM employee WHERE emp_id = ? AND id != ?");
    $stmt->bind_param("si", $empid, $id);
} else {
    // Insert mode: check all records
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM employee WHERE emp_id = ?");
    $stmt->bind_param("s", $empid);
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