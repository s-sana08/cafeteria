<?php
require_once "config.php";
session_start();

$type = $_POST['report_type'] ?? '';
$fromDate = !empty($_POST['from_date']) ? $_POST['from_date'] : null;
$toDate = !empty($_POST['to_date']) ? $_POST['to_date'] : null;

$current_user_id = $_SESSION['id'] ?? 0;   // user_master.id
$current_role = $_SESSION['role'] ?? 0;    // user_master.role (1=Admin, 2=Vendor)

if (empty($type)) {
    echo "<tr><td colspan='6' class='text-center'>Please select a filter</td></tr>";
    exit;
}

// Base query
$query = "SELECT * FROM employee_request WHERE 1";

// Vendor filtering: role = 2 
if ($current_role == 2) {
    $query .= " AND user_id = $current_user_id";
} 

// Request type filter
if ($type == "requested") {
    $query .= " AND flag = 0";
} elseif ($type == "approved") {
    $query .= " AND flag = 1";
} elseif ($type == "reject") {
    $query .= " AND flag = 2"; 
} elseif ($type == "all") {
} else {
    echo "<tr><td colspan='6' class='text-center'>Invalid Type</td></tr>";
    exit;
}

// Date filter
if ($fromDate && $toDate) {
    $query .= " AND created_at BETWEEN '$fromDate 00:00:00' AND '$toDate 23:59:59'";
} elseif ($fromDate) {
    $query .= " AND created_at >= '$fromDate 00:00:00'";
} elseif ($toDate) {
    $query .= " AND created_at <= '$toDate 23:59:59'";
}

$query .= " ORDER BY id DESC";

$res = mysqli_query($conn, $query);

if(mysqli_num_rows($res) > 0){
    $i = 1;
    while($row = mysqli_fetch_assoc($res)){
        if($row['flag'] == 0){
            $status = "<span class='badge bg-warning'>Requested</span>";
        } elseif($row['flag'] == 1){
            $status = "<span class='badge bg-success'>Approved</span>";
        } elseif($row['flag'] == 2){
            $status = "<span class='badge bg-danger'>Rejected</span>";
        } else{
            $status = "<span class='badge bg-secondary'>Unknown</span>";
        }

        echo "<tr>
                <td style='display:none;'>".$row['flag']."</td>
                <td>".$i++."</td>
                <td>".$row['emp_id']."</td>
                <td>".date('d-m-Y h:i A', strtotime($row['created_at']))."</td>
                <td>".$status."</td>
              </tr>";
    }

} else {
    echo "<tr><td colspan='6' class='text-center'>Data Not Found</td></tr>";
}
?>