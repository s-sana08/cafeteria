<?php
include_once('config.php');

if(isset($_POST['id'])) {

    $id = intval($_POST['id']);

   
    $check = mysqli_query($conn, "SELECT flag FROM employee_request WHERE id = $id");
    $row = mysqli_fetch_assoc($check);

    if($row['flag'] == 1) {
        echo "not_allowed";
        exit;
    }

   
    $query = "UPDATE employee_request SET flag = 2 WHERE id = $id";

    if(mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }

} else {
    echo "invalid";
}
?>
