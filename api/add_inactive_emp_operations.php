<?php
session_start(); 
include_once('config.php');

class EmployeeAPI {
    private $conn;

    public function __construct($conn){ 
        $this->conn = $conn; 
    }

    // =========================
    // ✅ ACTIVITY LOG FUNCTION
    // =========================
    private function logActivity($action, $message)
    {
        if (!isset($_SESSION['username']) || $_SESSION['emp_role'] !== "Admin") {
            return;
        }

        $admin = $_SESSION['name'];

        $stmt = $this->conn->prepare("
            INSERT INTO activity_logs (admin_user, action_type, target_type, message)
            VALUES (?, ?, 'employee', ?)
        ");

        $stmt->bind_param("sss", $admin, $action, $message);
        $stmt->execute();
    }

    public function handleRequest(){
        $flag = $_POST['flag'] ?? '';

        switch($flag){
            case 'inactive_employees': 
                $this->inactiveEmployees(); 
                break;

            case 'showdata': 
                $this->showData(); 
                break;

            default: 
                echo json_encode(['error'=>'Invalid flag']); 
        }
    }  

    // =========================
    // INACTIVE EMPLOYEES
    // =========================
    private function inactiveEmployees(){

        $employee_ids = $_POST['employee_ids'] ?? '';

        if($employee_ids == ''){
            echo json_encode(['status'=>'error','message'=>'Please enter Employee IDs']);
            return;
        }

        $ids = array_map('trim', explode(',', $employee_ids));

        $not_exist = [];
        $already_inactive = [];
        $valid_for_update = [];

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));

        // FETCH DATA
        $sql_check = "SELECT emp_id, emp_status, emp_name FROM employee WHERE emp_id IN ($placeholders)";
        $stmt_check = $this->conn->prepare($sql_check);
        $stmt_check->bind_param($types, ...$ids);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        $db_data = [];

        while($row = $result->fetch_assoc()){
            $db_data[$row['emp_id']] = [
                'status' => $row['emp_status'],
                'name' => $row['emp_name']
            ];
        }

        $inactivatedEmployees = []; // ✅ for logging

        foreach($ids as $id){

            if(!isset($db_data[$id])){
                $not_exist[] = $id;

            } else {

                if($db_data[$id]['status'] == 0){
                    $already_inactive[] = $id;

                } else {
                    $valid_for_update[] = $id;

                    // ✅ collect name + id
                    $inactivatedEmployees[] = $db_data[$id]['name'] . " ($id)";
                }
            }
        }

        // UPDATE
        if(count($valid_for_update) > 0){

            $placeholders_update = implode(',', array_fill(0, count($valid_for_update), '?'));
            $types_update = str_repeat('i', count($valid_for_update));

            $sql_update = "UPDATE employee SET emp_status = 0 WHERE emp_id IN ($placeholders_update)";
            $stmt_update = $this->conn->prepare($sql_update);
            $stmt_update->bind_param($types_update, ...$valid_for_update);
            $stmt_update->execute();

            // =========================
            // ✅ LOG ACTIVITY
            // =========================
            $empList = "";

            if (!empty($inactivatedEmployees)) {
                $limited = array_slice($inactivatedEmployees, 0, 10);
                $empList = implode(", ", $limited);

                if (count($inactivatedEmployees) > 10) {
                    $empList .= " ... +" . (count($inactivatedEmployees) - 10) . " more";
                }
            }

            $this->logActivity(
                "STATUS",
                "Bulk inactivated employees: " . count($valid_for_update) . " | $empList"
            );
        }

        echo json_encode([
            'status'=>'success',
            'not_exist'=>$not_exist,
            'already_inactive'=>$already_inactive
        ]);
    }

    // =========================
    // SHOW DATA
    // =========================
    private function showData()
    {
        $sql = "SELECT e.*, c.company_name, d.department_name
                FROM employee e 
                LEFT JOIN company_master c ON e.company_id = c.id
                LEFT JOIN department_master d ON e.department_id = d.id
                WHERE e.emp_status = 0
                ORDER BY e.id DESC";         

        $result = $this->conn->query($sql);

        $rows = '';
        $sr = 0;

        while($rw = $result->fetch_assoc()){

            $sr++;
            $id = $rw['id'];
            $checked = $rw['emp_status'] == '1' ? 'checked' : '';

            $foodTime = (int)$rw['two_times_food_allowed'];

            if ($foodTime === 1) {
                $foodBadge = '<span class="badge bg-success">One Time</span>';
            } elseif ($foodTime === 2) {
                $foodBadge = '<span class="badge bg-primary">Two Times</span>';
            } else {
                $foodBadge = '<span class="badge bg-secondary">N/A</span>';
            }

            $createdDate = !empty($rw['created_at']) 
                ? date('d/m/Y h:i A', strtotime($rw['created_at'])) 
                : 'N/A';

            $rows .= "<tr>
                <td>$sr</td>
                <td>{$rw['emp_id']}</td>
                <td>{$rw['emp_name']}</td>
                <td>{$rw['company_name']}</td>
                <td>{$rw['department_name']}</td>
                <td>$foodBadge</td>
                <td id='tempcreated$id'>$createdDate</td>
                <td class='switch-col'>
                    <label class='switch'>
                        <input type='checkbox' class='status-toggle' data-id='$id' $checked>
                        <span class='slider round'></span>
                    </label>
                </td>      
            </tr>";
        }

        echo $rows;
    }
}

$api = new EmployeeAPI($conn);
$api->handleRequest();
?>