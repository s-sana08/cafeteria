<?php
include_once('config.php');
session_start();

if(!isset($_SESSION['id'])) {
    echo "Session expired";
    exit;
}

// =========================
// ✅ ACTIVITY LOG FUNCTION
// =========================
function logActivity($conn, $action, $message)
{
    if (!isset($_SESSION['username']) || $_SESSION['emp_role'] !== "Admin") {
        return;
    }

    $admin = $_SESSION['name'];

    $stmt = $conn->prepare("
        INSERT INTO activity_logs (admin_user, action_type, target_type, message)
        VALUES (?, ?, 'employee_request', ?)
    ");

    $stmt->bind_param("sss", $admin, $action, $message);
    $stmt->execute();
}

$loggedUserId = $_SESSION['id'];

if(isset($_POST['id'], $_POST['emp_id'], $_POST['emp_name'], $_POST['company_id'], $_POST['department_id'], $_POST['two_times_food_allowed'])) {

    $requestId = intval($_POST['id']);
    $emp_id = trim($_POST['emp_id']);
    $emp_name = trim($_POST['emp_name']);
    $company_id = intval($_POST['company_id']);
    $department_id = intval($_POST['department_id']);
    $food_time = intval($_POST['two_times_food_allowed']);

    if(!$emp_id || !$emp_name || !$company_id || !$department_id || !$food_time) {
        echo "All fields are required";
        exit;
    }

    // =========================
    // CHECK REQUEST STATUS
    // =========================
    $check = mysqli_query($conn, "SELECT flag FROM employee_request WHERE id = $requestId");
    $row = mysqli_fetch_assoc($check);

    if($row['flag'] == 1) {
        echo "not_allowed"; 
        exit;
    }

    // =========================
    // CHECK EMPLOYEE EXISTS
    // =========================
    $empCheck = mysqli_query($conn, "SELECT * FROM employee WHERE emp_id = '$emp_id'");

    if(mysqli_num_rows($empCheck) > 0) {

        // =========================
        // UPDATE EMPLOYEE
        // =========================
        $old = mysqli_fetch_assoc($empCheck);

        $changes = [];

        if ($old['emp_name'] != $emp_name) {
            $changes[] = "Name: {$old['emp_name']} → $emp_name";
        }

        if ($old['company_id'] != $company_id) {
            $changes[] = "Company ID: {$old['company_id']} → $company_id";
        }

        if ($old['department_id'] != $department_id) {
            $changes[] = "Department ID: {$old['department_id']} → $department_id";
        }

        if ($old['two_times_food_allowed'] != $food_time) {
            $changes[] = "Food: {$old['two_times_food_allowed']} → $food_time";
        }

        $updateSql = "UPDATE employee 
                      SET emp_name='$emp_name', company_id=$company_id, department_id=$department_id, 
                          two_times_food_allowed=$food_time, created_by=$loggedUserId
                      WHERE emp_id='$emp_id'";

        if(!mysqli_query($conn, $updateSql)) { 
            echo "Failed to update employee"; 
            exit; 
        }

        // ✅ LOG UPDATE
        $msg = !empty($changes)
            ? "Approved & updated employee $emp_name ($emp_id): " . implode(", ", $changes)
            : "Approved & updated employee $emp_name ($emp_id) (No changes)";

        logActivity($conn, "APPROVE_UPDATE", $msg);

    } else {

        // =========================
        // INSERT EMPLOYEE
        // =========================
        $insertSql = "INSERT INTO employee 
            (emp_id, emp_name, company_id, department_id, two_times_food_allowed, emp_status, created_by) 
            VALUES ('$emp_id', '$emp_name', $company_id, $department_id, $food_time, 1, $loggedUserId)";

        if(!mysqli_query($conn, $insertSql)) { 
            echo "Failed to insert employee"; 
            exit; 
        }

        // ✅ LOG INSERT
        logActivity(
            $conn,
            "APPROVE_INSERT",
            "Approved & added employee $emp_name (EmpID: $emp_id)"
        );
    }

    // =========================
    // MARK REQUEST APPROVED
    // =========================
    $updateRequest = "UPDATE employee_request 
                      SET flag = 1, created_by = $loggedUserId
                      WHERE id = $requestId";

    if(mysqli_query($conn, $updateRequest)) {

        // ✅ FINAL LOG (OPTIONAL)
        logActivity(
            $conn,
            "APPROVE",
            "Approved employee request ID: $requestId for EmpID: $emp_id"
        );

        echo "success";

    } else {
        echo "Failed to update request flag";
    }

} else {
    echo "invalid";
}
?>