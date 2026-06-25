<?php
include("config.php");

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$email_id = $_POST['email_id'];
$food_type_id = $_POST['food_type_id'];
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Check duplicate username for insert
if(!$id){
    $check = mysqli_query($conn, "SELECT * FROM user_master WHERE username='$username'");
    if(mysqli_num_rows($check) > 0){
        echo json_encode(['status'=>'error','message'=>'Username already exists!']);
        exit();
    }
}

// Insert or Update
if($id){
    // Update
    $sql = "UPDATE user_master SET name='$name', username='$username', password='$password', email_id='$email_id', food_type_id='$food_type_id' WHERE id=$id";
    $action = "update";
} else {
    // Insert
    $sql = "INSERT INTO user_master (name, username, password, email_id, food_type_id, role) 
            VALUES ('$name','$username','$password','$email_id','$food_type_id', '2')";
    $action = "insert";
}

if(mysqli_query($conn, $sql)){
    $vendor_id = $id ? $id : mysqli_insert_id($conn);

    // Fetch complete row with food_type_name
    $result = mysqli_query($conn, "SELECT u.*, f.food_type_name 
                                   FROM user_master u 
                                   LEFT JOIN food_type_master f ON u.food_type_id = f.id
                                   WHERE u.id = $vendor_id");
    $row = mysqli_fetch_assoc($result);

    echo json_encode(['status'=>'success','action'=>$action,'data'=>$row]);
} else {
    echo json_encode(['status'=>'error','message'=>'Database error!']);
}
?>