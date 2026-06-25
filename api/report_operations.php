<?php
include_once('config.php');

class FoodEntry {
    private $conn;
    private $flag;

    public function __construct($conn, $flag) {
        $this->conn = $conn;
        $this->flag = $flag;
    }

    public function handleRequest() {
        if($this->flag == 'showdata') {
            $this->showdata();  
        } 
        else if($this->flag == 'Monthlyshowdata') {
            $datetime = $_POST['datetime'] ?? '';
            $this->Monthlyshowdata($datetime);
        } 
        else if($this->flag == 'Datewiseshowdata') {
            $fromdate = $_POST['fromdate'] ?? ''; 
            $todate = $_POST['todate'] ?? '';
            $this->Datewiseshowdata($fromdate, $todate);
        }
        else if($this->flag == 'fetch_dropdowns') {
            $this->fetch_dropdowns();
        }
        else if($this->flag == 'Empwiseshowdata') {
            $empid = $_POST['empid'] ?? '';
            $this->Empwiseshowdata($empid);
        }
        else if($this->flag == 'fetch_vendor') {
            $this->fetch_vendor();
        }
        else if($this->flag == 'vendorwiseshowdata') {
            $vendorid = $_POST['vendorid'] ?? '';
            $this->vendorwiseshowdata($vendorid);
        }
        else {
            echo "<tr><td colspan='6' class='text-center'>Invalid action.</td></tr>";
        }
    }

    // 12 to 12 
    // private function showdata() {
    //     $rstFormData = mysqli_query($this->conn, "
    //         SELECT f.id, f.emp_id, f.meal_time, f.created_at, u.name, e.emp_name, fm.food_type_name
    //         FROM food_entry f
    //         INNER JOIN employee e ON f.emp_id = e.emp_id
    //         INNER JOIN food_type_master fm ON f.food_type = fm.id
    //         INNER JOIN user_master u ON f.created_by = u.id
    //         WHERE e.emp_status = '1'
    //         AND f.created_at >= CURDATE()
    //         AND f.created_at < CURDATE() + INTERVAL 1 DAY
    //         ORDER BY e.id DESC
    //     ");
    //     $this->outputTable($rstFormData); 
    // }
 
    // 4 to 4
    private function showdata() 
    { 
        $rstFormData = mysqli_query($this->conn, "
        SELECT f.id, f.emp_id, f.meal_time, f.created_at, u.name, e.emp_name, fm.food_type_name
        FROM food_entry f
        INNER JOIN employee e ON f.emp_id = e.emp_id
        INNER JOIN food_type_master fm ON f.food_type = fm.id
        INNER JOIN user_master u ON f.created_by = u.id
        WHERE e.emp_status = '1'
        AND DATE(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))
        ORDER BY e.id DESC
    ");
    $this->outputTable($rstFormData); 
}

    // 12 to 12
    private function Monthlyshowdata($datetime) 
    {
        if(!empty($datetime) && strpos($datetime, '-') !== false)
        {
            list($year, $month) = explode('-', $datetime);

            // 12 am to 12 am 
            // $rstFormData = mysqli_query($this->conn, "
            //     SELECT f.id, f.emp_id, f.meal_time, f.created_at,u.name, e.emp_name, fm.food_type_name
            //     FROM food_entry f
            //     INNER JOIN employee e ON f.emp_id = e.emp_id
            //     INNER JOIN food_type_master fm ON f.food_type = fm.id
            //     INNER JOIN user_master u ON f.created_by = u.id
            //     WHERE e.emp_status = '1'
            //       AND YEAR(f.created_at) = '$year'
            //       AND MONTH(f.created_at) = '$month'
            //     ORDER BY e.emp_id DESC
            // ");

            // 4 am to 4 am
            $rstFormData = mysqli_query($this->conn, "
            SELECT f.id, f.emp_id, f.meal_time, f.created_at,u.name, e.emp_name, fm.food_type_name
            FROM food_entry f
            INNER JOIN employee e ON f.emp_id = e.emp_id
            INNER JOIN food_type_master fm ON f.food_type = fm.id
            INNER JOIN user_master u ON f.created_by = u.id
            WHERE e.emp_status = '1'
            AND YEAR(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = '$year'
            AND MONTH(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = '$month'
            ORDER BY e.emp_id DESC
        ");
        $this->outputTable($rstFormData);
        } 
        else 
        {
            echo "<tr><td colspan='6' class='text-center'>Please select a month.</td></tr>";
        }
    }

    // 12 to 12 
    private function Datewiseshowdata($fromdate, $todate) {
        if(!empty($fromdate) && !empty($todate)){
            // 12 to 12
            // $rstFormData = mysqli_query($this->conn, "
            //     SELECT f.id, f.emp_id, f.meal_time, f.created_at,u.name, e.emp_name, fm.food_type_name
            //     FROM food_entry f
            //     INNER JOIN employee e ON f.emp_id = e.emp_id
            //     INNER JOIN food_type_master fm ON f.food_type = fm.id
            //     INNER JOIN user_master u ON f.created_by = u.id
            //     WHERE e.emp_status = '1'
            //     AND DATE(f.created_at) BETWEEN '$fromdate' AND '$todate'
            //     ORDER BY e.emp_id DESC
            // ");

            // 4 am to 4 am 
            $rstFormData = mysqli_query($this->conn, "
    SELECT f.id, f.emp_id, f.meal_time, f.created_at,u.name, e.emp_name, fm.food_type_name
    FROM food_entry f
    INNER JOIN employee e ON f.emp_id = e.emp_id
    INNER JOIN food_type_master fm ON f.food_type = fm.id
    INNER JOIN user_master u ON f.created_by = u.id
    WHERE e.emp_status = '1'
    AND DATE(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) BETWEEN '$fromdate' AND '$todate'
    ORDER BY e.emp_id DESC
");

            $this->outputTable($rstFormData);
        } else {
            echo "<tr><td colspan='6' class='text-center'>Please select From and To dates.</td></tr>";
        }
    }

    // 4 to 4


    private function fetch_dropdowns() {
        $data = [];
        $q1 = mysqli_query($this->conn,"SELECT emp_id, emp_name FROM employee WHERE emp_status = '1'");
        while($row = mysqli_fetch_assoc($q1)){
            $data['empname'][] = $row;
        }
        echo json_encode($data);
    }

    // private function Empwiseshowdata($empid) 
    // {
        
    //     if(!empty($empid)){
    //         $rstFormData = mysqli_query($this->conn, "
    //             SELECT f.id, f.emp_id, f.meal_time, f.created_at,u.name, e.emp_name, fm.food_type_name
    //             FROM food_entry f
    //             INNER JOIN employee e ON f.emp_id = e.emp_id
    //             INNER JOIN food_type_master fm ON f.food_type = fm.id
    //             INNER JOIN user_master u ON f.created_by = u.id
    //             WHERE e.emp_status = '1'
    //             AND e.emp_id = '$empid'
    //             ORDER BY e.emp_id DESC
    //         ");
    //         $this->outputTable($rstFormData);
    //     } else {
    //         echo "<tr><td colspan='6' class='text-center'>Please select an employee.</td></tr>";
    //     }
    // }

    private function Empwiseshowdata($empid) 
    {

    $fromdate = $_POST['fromdate'] ?? '';
    $todate = $_POST['todate'] ?? '';

    if (!empty($empid)) {

        // invalid employee id start
        $checkEmp = mysqli_query($this->conn, "
            SELECT emp_id FROM employee 
            WHERE emp_id = '$empid' AND emp_status = '1'
        ");

        if (mysqli_num_rows($checkEmp) == 0) {
            echo "invalid_emp"; 
            return;
        } 

        // invalid employee id End

        // Base query
        $query = "
            SELECT f.id, f.emp_id, f.meal_time, f.created_at, u.name, e.emp_name, fm.food_type_name
            FROM food_entry f
            INNER JOIN employee e ON f.emp_id = e.emp_id
            INNER JOIN food_type_master fm ON f.food_type = fm.id
            INNER JOIN user_master u ON f.created_by = u.id
            WHERE e.emp_status = '1'
            AND e.emp_id = '$empid'
        ";

        // 👉 Date filter logic (same as vendor)
        if (!empty($fromdate) && !empty($todate)) {
            $query .= " AND DATE(f.created_at) BETWEEN '$fromdate' AND '$todate' ";
        } else if (!empty($fromdate)) {
            $query .= " AND DATE(f.created_at) >= '$fromdate' ";
        } else if (!empty($todate)) {
            $query .= " AND DATE(f.created_at) <= '$todate' ";
        }

        $query .= " ORDER BY e.emp_id DESC";

        $rstFormData = mysqli_query($this->conn, $query);

        $this->outputTable($rstFormData);

    } else {
        echo "<tr><td colspan='6' class='text-center'>Please select an employee.</td></tr>";
    }
}


    private function fetch_vendor() {
        $data = [];
        $q1 = mysqli_query($this->conn,"SELECT id , name FROM `user_master` WHERE `role` = 2 AND status = 1");
        while($row = mysqli_fetch_assoc($q1)){
            $data['vendorname'][] = $row;
        }
        echo json_encode($data);
    }

 
    // 12 to 12
//     private function vendorwiseshowdata($vendorid) 
//     {
//         $fromdate = $_POST['fromdate'] ?? '';
//         $todate = $_POST['todate'] ?? '';

//         if (!empty($vendorid)) {
    
//         // Basic query start
//         $query = "
//             SELECT f.id, f.emp_id, f.meal_time, f.created_at, u.name, e.emp_name, fm.food_type_name
//             FROM food_entry f
//             INNER JOIN employee e ON f.emp_id = e.emp_id
//             INNER JOIN food_type_master fm ON f.food_type = fm.id
//             INNER JOIN user_master u ON f.created_by = u.id
//             WHERE e.emp_status = '1'
//             AND f.created_by = '$vendorid'
//         ";

//         // Date filtering conditions
//         if (!empty($fromdate) && !empty($todate)) {
//             $query .= " AND DATE(f.created_at) BETWEEN '$fromdate' AND '$todate' ";
//         } else if (!empty($fromdate)) {
//             $query .= " AND DATE(f.created_at) >= '$fromdate' ";
//         } else if (!empty($todate)) {
//             $query .= " AND DATE(f.created_at) <= '$todate' ";
//         }

//         $query .= " ORDER BY e.emp_id DESC";

//         $rstFormData = mysqli_query($this->conn, $query);

//         $this->outputTable($rstFormData);

//     } else {
//         echo "<tr><td colspan='7' class='text-center'>Please select a vendor.</td></tr>";
//     }
// }

    // 4 to 4
private function vendorwiseshowdata($vendorid) 
{
    $fromdate = $_POST['fromdate'] ?? '';
    $todate = $_POST['todate'] ?? '';

    if (!empty($vendorid)) {

        $query = "
            SELECT f.id, f.emp_id, f.meal_time, f.created_at, u.name, e.emp_name, fm.food_type_name
            FROM food_entry f
            INNER JOIN employee e ON f.emp_id = e.emp_id
            INNER JOIN food_type_master fm ON f.food_type = fm.id
            INNER JOIN user_master u ON f.created_by = u.id
            WHERE e.emp_status = '1'
            AND f.created_by = '$vendorid'
        ";

        // ✅ 4 AM based filtering
        if (!empty($fromdate) && !empty($todate)) {

            $from = $fromdate . " 04:00:00";
            $to   = date('Y-m-d 04:00:00', strtotime($todate . ' +1 day'));

            $query .= " AND f.created_at >= '$from' AND f.created_at < '$to' ";

        } else if (!empty($fromdate)) {

            $from = $fromdate . " 04:00:00";

            $query .= " AND f.created_at >= '$from' ";

        } else if (!empty($todate)) {

            $to = date('Y-m-d 04:00:00', strtotime($todate . ' +1 day'));

            $query .= " AND f.created_at < '$to' ";
        }

        $query .= " ORDER BY e.emp_id DESC";

        $rstFormData = mysqli_query($this->conn, $query);

        $this->outputTable($rstFormData);

    } else {
        echo "<tr><td colspan='7' class='text-center'>Please select a vendor.</td></tr>";
    }
}


    private function outputTable($rstFormData) {
        $SrNo = 0;
        while($rwFormData = mysqli_fetch_assoc($rstFormData)){
            $SrNo++;
            $id = $rwFormData['id'];
            $empid = $rwFormData['emp_id'];
            $name = $rwFormData['emp_name'];
            $mealtime = $rwFormData['meal_time'];
            $created_at = $rwFormData['created_at'];
            $foodtypename = $rwFormData['food_type_name'];
            $vendorname = $rwFormData['name'] ?? '';
           

                  // Convert date and time
            $dateTimeFormatted = date('d/m/Y H:i:s', strtotime($created_at));


            echo "<tr>
                    <td>$SrNo</td>
                    <td>$empid</td>
                    <td>$name</td>
                    <td>$foodtypename</td>
                    <td>$vendorname</td>
                    <td>$mealtime</td>
                    <td>$dateTimeFormatted</td>

                   ";

           
        
        }
    }
}

// Usage
$flag = $_POST['flag'] ?? '';
$foodEntry = new FoodEntry($conn, $flag);
$foodEntry->handleRequest();
?>