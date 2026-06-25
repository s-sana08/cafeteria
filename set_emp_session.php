<?php
session_start();

if(isset($_GET['emp_id'])){
    $_SESSION['selected_emp_id'] = $_GET['emp_id'];
}

// redirect without showing emp_id
header("Location: form_add_emp.php");
exit;
?>