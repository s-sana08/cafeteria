<?php

include_once('api/config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$search = $_GET['search'] ?? '';

// BASE QUERY
$sql = "SELECT * FROM activity_logs";

// APPLY SEARCH FILTER
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);

    $sql .= " WHERE 
        admin_user LIKE '%$search%' 
        OR action_type LIKE '%$search%' 
        OR message LIKE '%$search%'";
}

// ORDER
$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

// CHECK QUERY ERROR
if (!$result) {
    echo "SQL Error: " . mysqli_error($conn);
    exit;
}

// NO DATA
if (mysqli_num_rows($result) == 0) {
    echo "<p style='color:red;'>No logs found</p>";
    exit;
}

// OUTPUT
while ($row = mysqli_fetch_assoc($result)) {

    echo "<div class='log'>
        <b style='color:#0d6efd;'>[" . $row['created_at'] . "]</b><br>
        <b style='color:#6f42c1;'>" . htmlspecialchars($row['admin_user']) . "</b> | 
        <span style='color:#198754;'>" . htmlspecialchars($row['action_type']) . "</span> | 
        " . htmlspecialchars($row['message']) . "
    </div>
    <hr style='border-top:1px solid #ddd;'>";
}
?>