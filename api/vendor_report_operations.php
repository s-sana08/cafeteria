<?php
include_once('config.php');
session_start();
$vendorid = $_SESSION['id'];
$flag = $_POST['flag'] ?? '';


if($flag == 'showdata') 
    {

   // 12 to 12 
// $rstFormData = mysqli_query($conn, "
//     SELECT f.id, f.emp_id, f.meal_time, f.created_at,u.name,e.emp_name, fm.food_type_name
//     FROM food_entry f
//     INNER JOIN employee e ON f.emp_id = e.emp_id
//     INNER JOIN food_type_master fm ON f.food_type = fm.id
//       INNER JOIN user_master u ON f.created_by = u.id
//     WHERE e.emp_status = '1'
//     AND f.created_by = '$vendorid'
//     AND f.created_at >= CURDATE()
//     AND f.created_at < CURDATE() + INTERVAL 1 DAY
//     ORDER BY e.id DESC
// "); 

// 4 am to 4 am 
$rstFormData = mysqli_query($conn, "
    SELECT f.id, f.emp_id, f.meal_time, f.created_at,u.name,e.emp_name, fm.food_type_name
    FROM food_entry f
    INNER JOIN employee e ON f.emp_id = e.emp_id
    INNER JOIN food_type_master fm ON f.food_type = fm.id
    INNER JOIN user_master u ON f.created_by = u.id
    WHERE e.emp_status = '1'
    AND f.created_by = '$vendorid'
    AND DATE(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))
    ORDER BY e.id DESC
");

$SrNo = 0;

while($rwFormData = mysqli_fetch_assoc($rstFormData)){
    $SrNo++;
    $id = $rwFormData['id'];
    $empid = $rwFormData['emp_id'];
    $name = $rwFormData['emp_name'];
    $mealtime = $rwFormData['meal_time'];
    $created_at = $rwFormData['created_at'];
    $foodtypename = $rwFormData['food_type_name'];
    

    echo "<tr>
            <td>$SrNo</td>
            <td id='tempempid$id'>$empid</td>
            <td id='tempempname$id'>$name</td>
            <td id='tempempname$id'>$foodtypename</td>
            <td id='tempempname$id'>$mealtime</td>
            <td id='tempfoodtime$id'>" . date('d/m/Y H:i:s', strtotime($created_at)) . "</td>

         
          </tr>";
}

}

else if($flag == 'Monthlyshowdata') 
    {

    $datetime = $_POST['datetime'] ?? '';  
    if(!empty($datetime) && strpos($datetime, '-') !== false){
        list($year, $month) = explode('-', $datetime);

        // 12 to 12
        // $rstFormData = mysqli_query($conn, "
        //     SELECT f.id, f.emp_id, f.meal_time, f.created_at, e.emp_name, fm.food_type_name
        //     FROM food_entry f
        //     INNER JOIN employee e ON f.emp_id = e.emp_id
        //     INNER JOIN food_type_master fm ON f.food_type = fm.id
        //     WHERE e.emp_status = '1'
        //       AND f.created_by = '$vendorid'
        //       AND YEAR(f.created_at) = '$year'
        //       AND MONTH(f.created_at) = '$month'
        //     ORDER BY e.emp_id DESC
        // ");

        // 4 to 4 
            $rstFormData = mysqli_query($conn, "
            SELECT f.id, f.emp_id, f.meal_time, f.created_at, e.emp_name, fm.food_type_name
            FROM food_entry f
            INNER JOIN employee e ON f.emp_id = e.emp_id
            INNER JOIN food_type_master fm ON f.food_type = fm.id
            WHERE e.emp_status = '1'
            AND f.created_by = '$vendorid'
            AND YEAR(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = '$year'
            AND MONTH(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = '$month'
            ORDER BY e.emp_id DESC
        ");
 
        $SrNo = 0;
        while($rwFormData = mysqli_fetch_assoc($rstFormData)){
            $SrNo++;
            $id = $rwFormData['id'];
            $empid = $rwFormData['emp_id'];
            $name = $rwFormData['emp_name'];
            $mealtime = $rwFormData['meal_time'];
            $created_at = $rwFormData['created_at'];
            $foodtypename = $rwFormData['food_type_name'];

            echo "<tr>
                    <td>$SrNo</td>
                    <td>$empid</td>
                    <td>$name</td>
                    <td>$foodtypename</td>
                    <td>$mealtime</td>
                     <td>" . date('d/m/Y H:i:s', strtotime($created_at)) . "</td>
                  </tr>";
        }
    } else {
       
        echo "<tr><td colspan='6' class='text-center'>Please select a month.</td></tr>";
    }

}
else if($flag == 'Datewiseshowdata') {

    $fromdate = $_POST['fromdate'] ?? '';  
    $todate = $_POST['todate'] ?? '';  

    if(!empty($fromdate) && !empty($todate)){

       // 12 to 12 
        // $rstFormData = mysqli_query($conn, "
        //     SELECT f.id, f.emp_id, f.meal_time, f.created_at, e.emp_name, fm.food_type_name
        //     FROM food_entry f
        //     INNER JOIN employee e ON f.emp_id = e.emp_id
        //     INNER JOIN food_type_master fm ON f.food_type = fm.id
        //     WHERE e.emp_status = '1'
        //     AND f.created_by = '$vendorid'
        //     AND DATE(f.created_at) BETWEEN '$fromdate' AND '$todate'
        //     ORDER BY e.emp_id DESC
        // ");


        // 4 to 4
        $rstFormData = mysqli_query($conn, "
    SELECT f.id, f.emp_id, f.meal_time, f.created_at, e.emp_name, fm.food_type_name
    FROM food_entry f
    INNER JOIN employee e ON f.emp_id = e.emp_id
    INNER JOIN food_type_master fm ON f.food_type = fm.id
    WHERE e.emp_status = '1'
      AND f.created_by = '$vendorid'
      AND DATE(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) BETWEEN '$fromdate' AND '$todate'
    ORDER BY e.emp_id DESC
");

        $SrNo = 0;

        while($rwFormData = mysqli_fetch_assoc($rstFormData)){
            $SrNo++;
            $id = $rwFormData['id'];
            $empid = $rwFormData['emp_id'];
            $name = $rwFormData['emp_name'];
            $mealtime = $rwFormData['meal_time'];
            $created_at = $rwFormData['created_at'];
            $foodtypename = $rwFormData['food_type_name'];

            echo "<tr>
                    <td>$SrNo</td>
                    <td>$empid</td>
                    <td>$name</td>
                    <td>$foodtypename</td>
                    <td>$mealtime</td>
                    <td>$created_at</td>
                  </tr>";
        }

    } else {
        echo "<tr><td colspan='6' class='text-center'>Please select From and To dates.</td></tr>";
    }

}

else if($flag == 'fetch_dropdowns') {

    $data = [];

    $q1 = mysqli_query($conn,"SELECT emp_id, emp_name FROM employee  WHERE emp_status = '1'");
    while($row = mysqli_fetch_assoc($q1)){
        $data['empname'][] = $row;
    }

   
    echo json_encode($data);

} 


?>