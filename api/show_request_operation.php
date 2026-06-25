<?php
include_once('config.php');

$notif_count = 0;
$pending_requests = [];

if(isset($conn)){
    $vendorName = $_SESSION['name'] ?? '';

    $count_sql = "SELECT COUNT(*) as cnt FROM employee_request WHERE flag = 0 ";
    $notif_count = $conn->query($count_sql)->fetch_assoc()['cnt'] ?? 0;


    $fetch_sql = "SELECT * FROM employee_request WHERE flag = 0 ORDER BY id DESC";
    $result = $conn->query($fetch_sql);
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $pending_requests[] = $row;
        }
    }
}
?>