<?php
session_start();
require_once "config.php";

// User Class
class User {
    private $conn;
    private $id;

    public function __construct($conn, $id){
        $this->conn = $conn;
        $this->id = $id;
    }

    public function updatePassword($old_password, $new_password){
        if(empty($old_password) || empty($new_password)){
            return ['status'=>'error','message'=>'All fields are required'];
        }

        // Fetch current password from DB
        $id = mysqli_real_escape_string($this->conn, $this->id);
        $result = mysqli_query($this->conn, "SELECT password FROM user_master WHERE id='$id' LIMIT 1");
        if($result && mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            $current_password = $row['password'];

            // For plain text passwords (your current DB)
            if($old_password !== $current_password){
                return ['status'=>'error','message'=>'Old password is incorrect'];
            }

            $new_password_esc = mysqli_real_escape_string($this->conn, $new_password);
            $update = mysqli_query($this->conn, "UPDATE user_master SET password='$new_password_esc' WHERE id='$id'");


            if($update){
    session_destroy(); // logout user
    return ['status'=>'success','message'=>'Password Updated Successfully'];
}

        } else {
            return ['status'=>'error','message'=>'User not found'];
        }
    }
}

// Only logged-in users
if(!isset($_SESSION['emp_loggedin'])){
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

// POST data
$id = $_SESSION['id'];
$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';

$user = new User($conn, $id);
$response = $user->updatePassword($old_password, $new_password);

echo json_encode($response);
exit;
?>