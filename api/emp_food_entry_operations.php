<?php
include_once('config.php');
session_start();

class FoodEntry {

    private $conn;
    private $vendorid;

    public function __construct($db){
        $this->conn = $db;
        $this->vendorid = $_SESSION['id'] ?? null;
    }

    // Insert food entry
    public function insertEntry($emp_id)
    {
        if(empty($emp_id)){ 
            echo "<span style='color:red;'>Employee ID is required</span>";
            exit;
        } 

        // Check if employee exists
        $checkEmp = $this->conn->prepare("SELECT emp_id, two_times_food_allowed, emp_status FROM employee WHERE emp_id = ?");
        $checkEmp->bind_param("s",$emp_id);
        $checkEmp->execute();
        $empResult = $checkEmp->get_result();

        if($empResult->num_rows == 0){
            echo "<span style='color:red;'>Invalid Employee ID</span>";
            exit;
        }

        $empData = $empResult->fetch_assoc();

        // Check if employee is inactive
        if($empData['emp_status'] == '0'){
            echo "<span style='color:red;'>This employee is inactive</span>";
            exit;
        }

        $allowedMeals = $empData['two_times_food_allowed']; // 1 or 2

        // Determine meal_time with 4 AM - 3:59 AM cycle
        $hour = (int)date('H');
        $shiftedHour = ($hour - 4 + 24) % 24;
        $meal_time = ($shiftedHour < 14) ? 'lunch' : 'dinner';

        // Count meals already taken in the 4 AM cycle
        $countQuery = $this->conn->prepare(
            "SELECT COUNT(*) as total 
             FROM food_entry 
             WHERE emp_id = ? 
             AND DATE(DATE_SUB(created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))"
        );
        $countQuery->bind_param("s",$emp_id);
        $countQuery->execute();
        $countResult = $countQuery->get_result()->fetch_assoc();
        $currentCount = $countResult['total'];

        // if($currentCount >= $allowedMeals){
        //     echo "<span style='color:red;'>Meal already taken (Allowed: $allowedMeals)😜</span>";
        //     exit;
        // }

        if($currentCount >= $allowedMeals){
    echo "<div class='error-msg'>
            ❌ Meal already taken (Allowed: $allowedMeals)
            <span class='emoji'>😜</span>
          </div>";
    exit;
}


          

        // Get vendor's food type
        $stmt1 = $this->conn->prepare("SELECT food_type_id FROM user_master WHERE id = ?");
        $stmt1->bind_param("i",$this->vendorid);
        $stmt1->execute();
        $result = $stmt1->get_result();
        $food_type_id = $result->fetch_assoc()['food_type_id'] ?? null;

        // Insert entry
        $stmt2 = $this->conn->prepare(
            "INSERT INTO food_entry(emp_id, meal_time, created_by, food_type)
             VALUES (?, ?, ?, ?)"
        );
        $stmt2->bind_param("ssii",$emp_id,$meal_time,$this->vendorid,$food_type_id);

        if($stmt2->execute()){
            echo "
            <div class='success-msg'>
                ✅ Entry successful (" . ($currentCount+1) . "/$allowedMeals)
                <span class='emoji'>😊</span> 
            </div>
            ";
        } else {
            echo "Error: ".$stmt2->error;
        }
    }

    // Show today's data for vendor
    public function showData()
    {
        $query = "
        SELECT f.id, f.emp_id, f.meal_time, f.created_at, e.emp_name, fm.food_type_name
        FROM food_entry f
        INNER JOIN employee e ON f.emp_id = e.emp_id
        INNER JOIN food_type_master fm ON f.food_type = fm.id
        WHERE e.emp_status = '1'
        AND f.created_by = '$this->vendorid'
        AND DATE(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))
        ORDER BY e.id DESC
        ";

        $result = $this->conn->query($query);
        $SrNo = 0;

        while($row = $result->fetch_assoc()){
            $SrNo++;
            $id = $row['id'];
            $empid = $row['emp_id'];
            $name = $row['emp_name'];
            $mealtime = $row['meal_time'];
            $created_at = date('d/m/Y h:i A', strtotime($row['created_at'])); // <-- formatted

            $foodtypename = $row['food_type_name'];

            echo "<tr>
                    <td>$SrNo</td>
                    <td>$empid</td>
                    <td>$name</td>
                    <td>$foodtypename</td>
                    <td>$mealtime</td>
                    <td>$created_at</td>
                  </tr>";
        }
    }

    // Insert Employee Request
    public function insertEmployeeRequest($emp_id){
        $vnd_name = $_SESSION['name'] ?? '';
        $vendorid = $_SESSION['id'] ?? '';

        if(empty($emp_id) || empty($vnd_name) || empty($vendorid)){
            echo "Please provide Employee ID, Vendor Name and User ID!";
            exit;
        }

        // Check duplicate request
        $check = $this->conn->prepare(
            "SELECT id FROM employee_request WHERE emp_id = ? AND user_id = ?"
        );
        $check->bind_param("si", $emp_id, $vendorid);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0){
            echo "<span style='color:red;'>Request already sent!</span>";        
            exit;
        }

        // Insert request
        $stmt = $this->conn->prepare(
            "INSERT INTO employee_request (emp_id, vnd_name, user_id) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("ssi", $emp_id, $vnd_name, $vendorid);

        if($stmt->execute()){ 
            echo "<span style='color:green;'>Request has been sent successfully!</span>";        
        } else { 
            echo "Error: ".$stmt->error; 
        }
    }

}

// Handle POST requests
$flag = $_POST['flag'] ?? '';
$emp_id = $_POST['empid'] ?? '';

$food = new FoodEntry($conn);

if($flag == 'insert') $food->insertEntry($emp_id);
if($flag == 'showdata') $food->showData();
if($flag == 'insert_request') $food->insertEmployeeRequest($emp_id);

?>