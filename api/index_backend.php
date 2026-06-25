<?php
// food type count
$sql = "SELECT COUNT(*) as total_meal_count FROM food_type_master WHERE status='1'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_meal_count = $row['total_meal_count'];

// Request Count 
$vnd_name = $_SESSION['name'];
if ($role == '1' || $role == '3')
	{
    $sql8 = "SELECT COUNT(*) as total_request_count FROM employee_request WHERE status='1'";
    }
    else
        {
            $sql8 = "SELECT COUNT(*) as total_request_count FROM employee_request WHERE vnd_name = '$vnd_name' AND status='1'";

        }
$result = mysqli_query($conn, $sql8);
$row = mysqli_fetch_assoc($result);
$total_request_count = $row['total_request_count'];

 


 
// vendor count
$sql1 = "SELECT COUNT(*) as vendor_count FROM user_master WHERE role='2' AND status='1'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);
$vendor_count = $row['vendor_count'];

// Employee count
$sql2 = "SELECT COUNT(*) as employee_count FROM employee WHERE emp_status='1'";
$result2 = mysqli_query($conn, $sql2);
$row = mysqli_fetch_assoc($result2);
$employee_count = $row['employee_count'];

// Dish Count
$dish_count = 0;

$sql = "SELECT SUM(two_times_food_allowed) AS dish_count FROM employee WHERE emp_status = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $dish_count = $row['dish_count'] ?: 0;
}



// **********----- daily Food Entry Count start *********** -----///////

    // 12 to 12 am 
	// $current_date = date('Y-m-d');
	// if ($role == '1' || $role == '3')
	// {
    // 	// ADMIN
    // 	$sql3 = "SELECT COUNT(*) as food_count FROM food_entry WHERE DATE(created_at) = '$current_date'";
	// } 
	// else 
	// {
    // 	// VENDOR
    // 	$sql3 = "SELECT COUNT(*) as food_count FROM food_entry WHERE DATE(created_at) = '$current_date' AND created_by = '$vendor_id'";
	// }
 
	// $result3 = mysqli_query($conn, $sql3);
	// $row = mysqli_fetch_assoc($result3);
	// $food_count = $row['food_count'];


    // 4 to 3:59 am
	if ($role == '1' || $role == '3')
    {
        $sql3 = "
        SELECT COUNT(*) as food_count 
        FROM food_entry 
        WHERE DATE(DATE_SUB(created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))
        ";
    } 
    else 
    {
        $sql3 = "
        SELECT COUNT(*) as food_count 
        FROM food_entry 
        WHERE DATE(DATE_SUB(created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))
        AND created_by = '$vendor_id'
        ";
    }

    $result3 = mysqli_query($conn, $sql3);
    $row = mysqli_fetch_assoc($result3);
    $food_count = $row['food_count'];

// **********----- daily Food Entry Count End *********** -----///////



// **********----- Weekly Food Entry Count Start *********** -----///////

// 12 am to 12 am 
// $current_year_week = date('Y-W'); 
// if ($role == '1' || $role == '3')
// {
// $sql4 = "SELECT COUNT(*) as weekly_meal_count FROM food_entry WHERE DATE_FORMAT(created_at, '%Y-%u') = '$current_year_week'";
// }
// else
// {
// $sql4 = "SELECT COUNT(*) as weekly_meal_count FROM food_entry WHERE DATE_FORMAT(created_at, '%Y-%u') = '$current_year_week' AND created_by = '$vendor_id'";

// }
// $result4 = mysqli_query($conn, $sql4);
// $row = mysqli_fetch_assoc($result4);
// $weekly_meal_count = $row['weekly_meal_count'];


// 4 am to 4 am
$current_year_week = date('Y-W'); 

if ($role == '1' || $role == '3')
{
    $sql4 = "
    SELECT COUNT(*) as weekly_meal_count 
    FROM food_entry 
    WHERE DATE_FORMAT(DATE_SUB(created_at, INTERVAL 4 HOUR), '%Y-%u') = '$current_year_week'
    ";
}
else
{
    $sql4 = "
    SELECT COUNT(*) as weekly_meal_count 
    FROM food_entry 
    WHERE DATE_FORMAT(DATE_SUB(created_at, INTERVAL 4 HOUR), '%Y-%u') = '$current_year_week'
    AND created_by = '$vendor_id'
    ";
}

$result4 = mysqli_query($conn, $sql4);
$row = mysqli_fetch_assoc($result4);
$weekly_meal_count = $row['weekly_meal_count'];


// **********----- Weekly Food Entry Count End *********** -----///////




// **********----- Monthly Food Entry Count Start *********** -----///////
// 12 to 12 
// $current_year_month = date('Y-m'); // 'Y' is year, 'm' is month
// 	if ($role == '1' || $role == '3')
// 	{
// 		$sql5 = "SELECT COUNT(*) as monthly_meal_count FROM food_entry WHERE DATE_FORMAT(created_at, '%Y-%m') = '$current_year_month'";
// 	}
// 	else
// 	{
// 		$sql5 = "SELECT COUNT(*) as monthly_meal_count FROM food_entry WHERE DATE_FORMAT(created_at, '%Y-%m') = '$current_year_month' AND created_by = '$vendor_id'";
// 	}
// 	$result5 = mysqli_query($conn, $sql5);
// 	$row = mysqli_fetch_assoc($result5);
// 	$monthly_meal_count = $row['monthly_meal_count'];



    // 4 to 4
    $current_year_month = date('Y-m'); // 'Y' is year, 'm' is month

    if ($role == '1' || $role == '3')
    {
    $sql5 = " 
    SELECT COUNT(*) as monthly_meal_count
    FROM food_entry
    WHERE DATE_FORMAT(DATE_SUB(created_at, INTERVAL 4 HOUR), '%Y-%m') = '$current_year_month'
    ";
} else {
    $sql5 = "
    SELECT COUNT(*) as monthly_meal_count
    FROM food_entry
    WHERE DATE_FORMAT(DATE_SUB(created_at, INTERVAL 4 HOUR), '%Y-%m') = '$current_year_month'
      AND created_by = '$vendor_id'
    ";
}

$result5 = mysqli_query($conn, $sql5);
$row = mysqli_fetch_assoc($result5);
$monthly_meal_count = $row['monthly_meal_count'];

// **********----- Monthly Food Entry Count End *********** -----///////





// **********----- Monthly skipped Food Entry Count Start *********** -----///////

//12 to 12
// $current_date1 = date('Y-m-d');  // Format the date as 'YYYY-MM-DD'
// $sql6 = "SELECT COUNT(e.id) as skipped_employee_count
//          FROM employee e
//          LEFT JOIN food_entry f ON e.emp_id = f.emp_id AND DATE(f.created_at) = '$current_date1'
//          WHERE e.emp_status = 1 AND f.emp_id IS NULL";
// $result6 = mysqli_query($conn, $sql6);
// $row = mysqli_fetch_assoc($result6);
// $skipped_employee_count = $row['skipped_employee_count'];


// 4 to 4 
$current_date1 = date('Y-m-d');

$sql6 = "
SELECT COUNT(e.id) as skipped_employee_count
FROM employee e
LEFT JOIN food_entry f 
    ON e.emp_id = f.emp_id 
    AND DATE(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))
WHERE e.emp_status = 1 
AND f.emp_id IS NULL
";

$result6 = mysqli_query($conn, $sql6);
$row = mysqli_fetch_assoc($result6);
$skipped_employee_count = $row['skipped_employee_count'];




// **********----- Monthly skipped Food Entry Count End *********** -----///////










$sql_vendor_list = "SELECT name FROM user_master WHERE role='2' AND status='1'";
$result_vendor_list = mysqli_query($conn, $sql_vendor_list);




// ===== Monthly Graph Data (Current Year) ===== Start

// --- Monthly Graph Data (Current Year) ---

// 12 to 12 (all)
// $current_year = date('Y');

// if ($role == '1' || $role == '3')
// {
//     // ADMIN: All vendors
//     $sql_graph = "
//         SELECT u.id, u.name, MONTH(f.created_at) as month, COUNT(*) as total
//         FROM food_entry f
//         JOIN user_master u ON f.created_by = u.id
//         WHERE YEAR(f.created_at) = '$current_year'
//         AND u.role = '2' AND u.status = '1'
//         GROUP BY u.id, MONTH(f.created_at)
//         ORDER BY u.id, month
//     ";
//     $result_graph = mysqli_query($conn, $sql_graph);

//     // prepare vendors monthly data
//     $vendors = [];
//     while ($row = mysqli_fetch_assoc($result_graph)) {
//         $vendor_name = $row['name'];
//         $month = (int)$row['month'];
//         $total = (int)$row['total'];

//         if (!isset($vendors[$vendor_name])) {
//             $vendors[$vendor_name] = array_fill(1, 12, 0);
//         }
//         $vendors[$vendor_name][$month] = $total;
//     }

// } 
// else 
// {
//     // VENDOR: Only his data
//     $sql_monthly = "
//         SELECT MONTH(created_at) as month, COUNT(*) as total 
//         FROM food_entry 
//         WHERE YEAR(created_at) = '$current_year' 
//         AND created_by = '$vendor_id'
//         GROUP BY MONTH(created_at)
//     ";
//     $result_monthly = mysqli_query($conn, $sql_monthly);

//     $monthly_data = array_fill(1, 12, 0);
//     while ($row = mysqli_fetch_assoc($result_monthly)) {
//         $month = (int)$row['month'];
//         $monthly_data[$month] = (int)$row['total'];
//     }
// }


// 4 to 4 ( Top 4)

$current_year = date('Y');

if ($role == '1' || $role == '3')
{
    $sql_graph = "
        SELECT 
    u.id,
    u.name,
    MONTH(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) as month,
    COUNT(f.id) as total
    FROM food_entry f
    JOIN user_master u ON f.created_by = u.id

    WHERE u.role = '2'
    AND u.status = '1'

    -- YEAR wise filter (important)
    AND YEAR(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = '$current_year'

    GROUP BY u.id, MONTH(DATE_SUB(f.created_at, INTERVAL 4 HOUR))
    ORDER BY u.id, month

        ";

    $result_graph = mysqli_query($conn, $sql_graph);

    $vendors = [];

    while ($row = mysqli_fetch_assoc($result_graph)) {

        $vendor_name = $row['name'];
        $month = (int)$row['month'];
        $total = (int)$row['total'];

        if (!isset($vendors[$vendor_name])) {
            $vendors[$vendor_name] = array_fill(1, 12, 0);
        }

        $vendors[$vendor_name][$month] = $total;
    }
}
else 
{
    $sql_monthly = "
        SELECT 
            MONTH(DATE_SUB(created_at, INTERVAL 4 HOUR)) as month,
            COUNT(id) as total 
        FROM food_entry 
        WHERE created_by = '$vendor_id'

        -- YEAR wise filter (important for proper monthly chart)
        AND YEAR(DATE_SUB(created_at, INTERVAL 4 HOUR)) = '$current_year'

        GROUP BY MONTH(DATE_SUB(created_at, INTERVAL 4 HOUR))
        ORDER BY month
    ";

    $result_monthly = mysqli_query($conn, $sql_monthly);

    $monthly_data = array_fill(1, 12, 0);

    while ($row = mysqli_fetch_assoc($result_monthly)) {
        $month = (int)$row['month'];
        $monthly_data[$month] = (int)$row['total'];
    }
}




// ===== Monthly Graph Data (Current Year) ===== End







// graph count ( circle graph) start
// 12 to 12 
// if ($role == '1' || $role == '3')
// {
   
//     $sql_vendor_meals = "
//         SELECT u.name, COUNT(f.id) as total
//         FROM user_master u
//         LEFT JOIN food_entry f 
//             ON u.id = f.created_by 
//             AND DATE(f.created_at) = CURDATE()
//         WHERE u.role='2' AND u.status='1'
//         GROUP BY u.id
//     ";

//     $sql_vendor_daily = $sql_vendor_meals; 
// } 
// else 
// {
   
//     $sql_vendor_meals = "
//         SELECT u.name, COUNT(f.id) as total
//         FROM user_master u
//         LEFT JOIN food_entry f 
//             ON u.id = f.created_by 
//             AND DATE(f.created_at) = CURDATE()
//         WHERE u.id = '$vendor_id'
//         GROUP BY u.id
//     ";

//     $sql_vendor_daily = $sql_vendor_meals; 
// }


// 4 to 4 
if ($role == '1' || $role == '3')
{
    $sql_vendor_meals = "
        SELECT u.name, COUNT(f.id) as total
        FROM user_master u
        LEFT JOIN food_entry f 
            ON u.id = f.created_by 
            AND f.created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 HOUR), '%Y-%m-%d 04:00:00')
            AND f.created_at < DATE_FORMAT(DATE_ADD(DATE_SUB(NOW(), INTERVAL 4 HOUR), INTERVAL 1 DAY), '%Y-%m-%d 04:00:00')
        WHERE u.role='2' AND u.status='1'
        GROUP BY u.id
    ";

    $sql_vendor_daily = $sql_vendor_meals; 
} 
else 
{
    $sql_vendor_meals = "
        SELECT u.name, COUNT(f.id) as total
        FROM user_master u
        LEFT JOIN food_entry f 
            ON u.id = f.created_by 
            AND f.created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 HOUR), '%Y-%m-%d 04:00:00')
            AND f.created_at < DATE_FORMAT(DATE_ADD(DATE_SUB(NOW(), INTERVAL 4 HOUR), INTERVAL 1 DAY), '%Y-%m-%d 04:00:00')
        WHERE u.id = '$vendor_id'
        GROUP BY u.id
    ";

    $sql_vendor_daily = $sql_vendor_meals; 
}
// graph count ( circle graph) End





$result_vendor_meals = mysqli_query($conn, $sql_vendor_meals);
$result_vendor_daily = mysqli_query($conn, $sql_vendor_daily);

$vendor_names = [];
$vendor_counts = [];

while ($row = mysqli_fetch_assoc($result_vendor_meals)) {
    $vendor_names[] = $row['name'];
    $vendor_counts[] = (int)$row['total'];
}






// 12 am to 12 am 
// $sql_vendor_daily = "
//     SELECT u.name, COUNT(f.id) as total
//     FROM user_master u
//     LEFT JOIN food_entry f 
//         ON u.id = f.created_by 
//         AND DATE(f.created_at) = CURDATE()
//     WHERE u.role='2' AND u.status='1'
//     GROUP BY u.id
//     ORDER BY total DESC
//     LIMIT 4
// ";


// 4 am to 4 am

$sql_vendor_daily = "
    SELECT u.name, COUNT(f.id) as total
    FROM user_master u
    LEFT JOIN food_entry f 
        ON u.id = f.created_by 
        AND f.created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 HOUR), '%Y-%m-%d 04:00:00')
        AND f.created_at < DATE_FORMAT(DATE_ADD(DATE_SUB(NOW(), INTERVAL 4 HOUR), INTERVAL 1 DAY), '%Y-%m-%d 04:00:00')
    WHERE u.role='2' AND u.status='1'
    GROUP BY u.id
    ORDER BY total DESC
    LIMIT 4
";



$result_vendor_daily = mysqli_query($conn, $sql_vendor_daily);



$colors = ["#f41127", "#0d6efd", "#17a00e", "#ffc107", "#6f42c1", "#20c997", "#fd7e14", "#6610f2"];






// Ensure values are numeric
$dish_count = isset($dish_count) ? (int)$dish_count : 0;
$food_count = isset($food_count) ? (int)$food_count : 0;

// Calculate remaining meals
$remaining = $dish_count - $food_count;

// Prevent negative values
if ($remaining < 0) {
    $remaining = 0;
}
?>


