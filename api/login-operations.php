<?php
require_once "config.php";
session_start();


header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$rstArray = [];

$Flag = isset($data['Flag']) ? $data['Flag'] : '';

if ($Flag == "login") {

    $username = isset($data['username']) ? mysqli_real_escape_string($conn, $data['username']) : '';
    $password = isset($data['password']) ? mysqli_real_escape_string($conn, $data['password']) : '';

    if ($username != "" && $password != "") {

        $rstQuery = mysqli_query($conn, "SELECT `id`, `name`, `username`, `password`, `role`, `email_id`, `food_type_id`, `status`, `created_by`, `created_at`
                                        FROM `user_master`
                                        WHERE `username`='$username' LIMIT 1");

        if ($rstQuery) {

            if (mysqli_num_rows($rstQuery) == 1) {

                $rstRec = mysqli_fetch_assoc($rstQuery);

                // If passwords are plain text (your current DB)
                if ($password == $rstRec['password']) {

                    $role_id = $rstRec['role'];

                    if ($role_id == 1) {
                        $role_name = 'Admin';
                    } else if($role_id == 3){
                        $role_name = 'SuperAdmin';
                    }else{
                        $role_name = 'Vendor';
                    }

                    $_SESSION['name'] = $rstRec['name'];
                     $_SESSION['email_id'] = $rstRec['email_id'];
                     $_SESSION['username'] = $rstRec['username'];
                    $_SESSION['id'] = $rstRec['id'];
                    $_SESSION['emp_role'] = $role_name;
                    $_SESSION['emp_loggedin'] = true;
                    $_SESSION['vendor_id'] = $rstRec['id'];    // user_master.id
                    $_SESSION['role'] = $rstRec['role'];   // ✅ ADD THIS

                    session_regenerate_id(true);

                    $rstArray['message'] = "Login successful.";
                    $rstArray['status'] = "success";

                } else {

                    $rstArray['message'] = "Invalid password.";
                    $rstArray['status'] = "failed";

                }

            } else {

                $rstArray['message'] = "Please check your credentials!";
                $rstArray['status'] = "failed";

            }

        } else {

            $rstArray['message'] = "Database Error: " . mysqli_error($conn);
            $rstArray['status'] = "failed";

        }

    } else {

        $rstArray['message'] = "Fields cannot be blank!";
        $rstArray['status'] = "failed";

    }

}

echo json_encode($rstArray);
exit;
?>