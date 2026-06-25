<?php
session_start();
require_once "config.php";

// User class
class User {
    private $conn;
    private $id;

    public function __construct($conn, $id) {
        $this->conn = $conn;
        $this->id = $id;
    }

    public function updateProfile($name, $email, $username) {
        // if(empty($name) || empty($email) || empty($username)) {
        //     return ['status'=>'error','message'=>'All fields are required'];
        // }

        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $username = mysqli_real_escape_string($this->conn, $username);
        $id = mysqli_real_escape_string($this->conn, $this->id);

        $query = "UPDATE user_master SET name='$name', email_id='$email', username='$username' WHERE id='$id'";
        if(mysqli_query($this->conn, $query)){
            // Update session
            $_SESSION['name'] = $name;
            $_SESSION['email_id'] = $email;
            $_SESSION['username'] = $username;

            return ['status'=>'success','message'=>'Profile updated successfully'];
        } else {
            return ['status'=>'error','message'=>'Database error: '.mysqli_error($this->conn)];
        }
    }
}

// Only allow logged-in users
if(!isset($_SESSION['emp_loggedin'])) {
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

// POST data
$id = $_SESSION['id'];
$name = $_POST['name'] ?? '';
$email = $_POST['email_id'] ?? '';
$username = $_POST['username'] ?? '';

$user = new User($conn, $id);
$response = $user->updateProfile($name, $email, $username);

echo json_encode($response);
exit;
?>