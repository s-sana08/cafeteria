<?php


$conn = new mysqli("localhost", "root", "", "automryl_cafeteria");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username']) || $_SESSION['emp_role'] !== "Admin") {
    exit;
}

$user = $_SESSION['username'];
$message = $_POST['message'] ?? '';

$stmt = $conn->prepare("
    INSERT INTO activity_logs (admin_user, action_type, target_type, message)
    VALUES (?, 'BUTTON_CLICK', 'ui', ?)
");

$stmt->bind_param("ss", $user, $message);
$stmt->execute();
?>