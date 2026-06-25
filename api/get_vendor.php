<?php
include("config.php");

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $sql = "SELECT * FROM user_master WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    echo json_encode($row);
}
?> 