<?php


$conn = new mysqli("localhost", "root", "", "automryl_cafeteria");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ONLY ADMIN LOGGING
if (isset($_SESSION['username']) && isset($_SESSION['emp_role']) && $_SESSION['emp_role'] === "Admin") {

    $user = $_SESSION['username'];
    $page = basename($_SERVER['PHP_SELF']);
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    $stmt = $conn->prepare("
        INSERT INTO activity_logs (admin_user, action_type, target_type, message, ip_address)
        VALUES (?, 'PAGE_VISIT', 'page', ?, ?)
    ");

    $msg = $user . " visited " . $page;

    $stmt->bind_param("sss", $user, $msg, $ip);
    $stmt->execute();
}
?>