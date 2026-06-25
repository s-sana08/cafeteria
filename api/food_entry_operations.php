<?php
include_once('config.php');
session_start();

class FoodEntry {

    private $conn;
    private $vendorid;

    public function __construct($db){
        $this->conn = $db;
        $this->vendorid = $_SESSION['id'];
    }

    public function insertEntry($emp_id){

        if(empty($emp_id)){
            // echo "Employee ID is required";
            exit;
        }

       
        $checkEmp = $this->conn->prepare("SELECT emp_id FROM employee WHERE emp_id = ?");
        $checkEmp->bind_param("s",$emp_id);
        $checkEmp->execute();
        $empResult = $checkEmp->get_result();

        if($empResult->num_rows == 0){
            echo "<span style='color:red;'>Invalid Employee ID</span>";
            exit;
        }

        
        $hour = date('H');
        $meal_time = ($hour >= 4 && $hour < 18) ? 'lunch' : 'dinner';

        
        $checkDuplicate = $this->conn->prepare(
            "SELECT id FROM food_entry WHERE emp_id = ? AND meal_time = ?"
        );
        $checkDuplicate->bind_param("ss",$emp_id,$meal_time);
        $checkDuplicate->execute();
        $dupResult = $checkDuplicate->get_result();

        if($dupResult->num_rows > 0){
            echo "<span style='color:red;'>Duplicate entry</span>";
            exit;
        }

        
        $stmt1 = $this->conn->prepare("SELECT food_type_id FROM user_master WHERE id = ?");
        $stmt1->bind_param("i",$this->vendorid);
        $stmt1->execute();
        $result = $stmt1->get_result();
        $food_type_id = $result->fetch_assoc()['food_type_id'] ?? null;

        
        $stmt2 = $this->conn->prepare(
            "INSERT INTO food_entry(emp_id, meal_time, created_by, food_type)
             VALUES (?, ?, ?, ?)"
        );
        $stmt2->bind_param("ssii",$emp_id,$meal_time,$this->vendorid,$food_type_id);

        if($stmt2->execute()){
            echo "<span style='color:green;'>Inserted</span>";
        }else{
            echo "Error: ".$stmt2->error;
        }

    }


    public function showData(){

        $query = "
        SELECT f.id, f.emp_id, f.meal_time, f.created_at, e.emp_name, fm.food_type_name
        FROM food_entry f
        INNER JOIN employee e ON f.emp_id = e.emp_id
        INNER JOIN food_type_master fm ON f.food_type = fm.id
        WHERE e.emp_status = '1'
        AND f.created_by = '$this->vendorid'
        AND f.created_at >= CURDATE()
        AND f.created_at < CURDATE() + INTERVAL 1 DAY
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
            $created_at = $row['created_at'];
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

}

$flag = $_POST['flag'] ?? '';
$emp_id = $_POST['empid'] ?? '';

$food = new FoodEntry($conn);

if($flag == 'insert'){
    $food->insertEntry($emp_id);
}

if($flag == 'showdata'){
    $food->showData();
}

?>