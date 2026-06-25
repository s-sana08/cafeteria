<?php
session_start();

$response = array('sessionActive' => isset($_SESSION['emp_role'])); // Adjust 'user_id' based on your session data

header('Content-Type: application/json');
echo json_encode($response);

?>