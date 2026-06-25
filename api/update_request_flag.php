<?php
//session_start();
include_once('config.php'); // DB connection

$id = $_POST['id'] ?? '';
$flag = $_POST['flag'] ?? '';

if($conn && $id !== '' && $flag !== ''){
    $stmt = $conn->prepare("UPDATE employee_request SET flag = ? WHERE id = ?");
    $stmt->bind_param("ii", $flag, $id);

    if($stmt->execute()){
        echo "success";
    } else {
        echo "DB error: " . $stmt->error;
    }
} else {
    echo "Invalid input";
}
?>