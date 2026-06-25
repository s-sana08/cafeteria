<?php
session_start(); 
include_once('config.php');

class EmployeeAPI
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn; 
    } 

    // =========================
    // ✅ LOG FUNCTION
    // =========================
    private function logActivity($action, $message)
    {
        if (!isset($_SESSION['id'])) return;

        $admin = $_SESSION['name'] ?? 'Unknown';

        $stmt = $this->conn->prepare("
            INSERT INTO activity_logs (admin_user, action_type, target_type, message)
            VALUES (?, ?, 'employee', ?)
        ");

        $stmt->bind_param("sss", $admin, $action, $message);
        $stmt->execute();
    }

    public function handleRequest()
    {
        $flag = $_POST['flag'] ?? '';
        switch ($flag) {
            case 'insert':
                $this->insertOrUpdate();
                break;
            case 'fetch_dropdowns':
                $this->fetchDropdowns();
                break;
            case 'showdata':
                $this->showData();
                break;
            case 'toggle_status':
                $this->toggleStatus();
                break;
            default:
                echo json_encode(['error' => 'Invalid flag']);
        }
    }

    // =========================
    // INSERT + UPDATE
    // =========================
    private function insertOrUpdate()
    {
        $id = $_POST['id'] ?? '';
        $emp_id = $_POST['empid'] ?? '';
        $emp_name = $_POST['empname'] ?? '';
        $company = $_POST['companyname'] ?? '';
        $department = $_POST['department'] ?? '';
        $food_time = $_POST['foodtime'] ?? '';

        // SESSION CHECK
        if (!isset($_SESSION['id'])) {
            echo json_encode(['status'=>'error', 'message'=>'User session not found']);
            return;
        }

        $created_by = $_SESSION['id'];

        // =========================
        // INSERT
        // =========================
        if ($id === '') {

            $stmt = $this->conn->prepare("
                INSERT INTO employee 
                (emp_id, emp_name, company_id, department_id, two_times_food_allowed, created_by)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param("ssiiii", $emp_id, $emp_name, $company, $department, $food_time, $created_by);

            if ($stmt->execute()) {

                $this->logActivity(
                    "INSERT",
                    "Added employee $emp_name (EmpID: $emp_id)"
                );

                echo json_encode(['status' => 'inserted']);
            }

        } else {

            $id = (int)$id;
            $company    = (int)$company;
            $department = (int)$department;
            $food_time  = (int)$food_time;

            // =========================
            // OLD DATA
            // =========================
            $oldResult = $this->conn->query("
                SELECT e.emp_name, e.company_id, e.department_id, e.two_times_food_allowed,
                       c.company_name, d.department_name
                FROM employee e
                LEFT JOIN company_master c ON e.company_id = c.id
                LEFT JOIN department_master d ON e.department_id = d.id
                WHERE e.id = $id
            ");

            if (!$oldResult || $oldResult->num_rows === 0) {
                echo json_encode(['status' => 'error', 'message' => 'Employee not found']);
                return;
            }

            $old = $oldResult->fetch_assoc();

            $changes = [];

            // NAME
            if ($old['emp_name'] != $emp_name) {
                $changes[] = "Name: {$old['emp_name']} → $emp_name";
            }

            // COMPANY
            if ($old['company_id'] != $company) {
                $newCompanyResult = $this->conn->query("SELECT company_name FROM company_master WHERE id=$company");
                $newCompany = $newCompanyResult ? $newCompanyResult->fetch_assoc() : null;
                $newCompanyName = $newCompany ? $newCompany['company_name'] : 'Unknown';
                $changes[] = "Company: {$old['company_name']} → $newCompanyName";
            }

            // DEPARTMENT
            if ($old['department_id'] != $department) {
                $newDeptResult = $this->conn->query("SELECT department_name FROM department_master WHERE id=$department");
                $newDept = $newDeptResult ? $newDeptResult->fetch_assoc() : null;
                $newDeptName = $newDept ? $newDept['department_name'] : 'Unknown';
                $changes[] = "Department: {$old['department_name']} → $newDeptName";
            }

            // FOOD TIME
            if ($old['two_times_food_allowed'] != $food_time) {
                $oldFood = $old['two_times_food_allowed'] == 1 ? "One Time" : "Two Times";
                $newFood = $food_time == 1 ? "One Time" : "Two Times";
                $changes[] = "Food: $oldFood → $newFood";
            }

            // UPDATE QUERY
            $stmt = $this->conn->prepare("
                UPDATE employee 
                SET emp_id=?, emp_name=?, company_id=?, department_id=?, two_times_food_allowed=? 
                WHERE id=?
            ");

            $stmt->bind_param("ssiiii", $emp_id, $emp_name, $company, $department, $food_time, $id);

            if ($stmt->execute()) {

                $msg = !empty($changes)
                    ? "Updated employee $emp_name (" . implode(", ", $changes) . ")"
                    : "Updated employee $emp_name (No changes)";

                $this->logActivity("UPDATE", $msg);

                echo json_encode(['status' => 'updated']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Update query failed: ' . $stmt->error]);
            }
        }
    }

    // =========================
    // STATUS TOGGLE
    // =========================
    private function toggleStatus()
    {
        $id     = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);

        if ($id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid employee ID']);
            return;
        }

        $res = $this->conn->query("SELECT emp_name FROM employee WHERE id=$id");
        if (!$res || $res->num_rows === 0) {
            echo json_encode(['status' => 'error', 'message' => 'Employee not found']);
            return;
        }
        $row = $res->fetch_assoc();

        $stmt = $this->conn->prepare("UPDATE employee SET emp_status=? WHERE id=?");
        $stmt->bind_param("ii", $status, $id);

        if ($stmt->execute()) {

            $action = $status == 1 ? "Activated" : "Deactivated";

            $this->logActivity(
                "STATUS",
                "$action employee {$row['emp_name']}"
            );

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Status update failed: ' . $stmt->error]);
        }
    }

    // =========================
    // YOUR EXISTING FUNCTIONS
    // =========================
    private function fetchDropdowns()
    {
        $data = [];

        $result = $this->conn->query("SELECT id, department_name FROM department_master");
        $data['department'] = $result->fetch_all(MYSQLI_ASSOC);

        $result = $this->conn->query("SELECT id, company_name FROM company_master");
        $data['company'] = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($data);
    }

   private function showData()
{
    $sql = "
    SELECT 
        e.id, 
        e.emp_id, 
        e.emp_name, 
        e.two_times_food_allowed,
        e.company_id, 
        e.department_id, 
        e.emp_status, 
        e.created_at,
        c.company_name, 
        d.department_name

    FROM employee e

    LEFT JOIN company_master c 
        ON e.company_id = c.id

    LEFT JOIN department_master d 
        ON e.department_id = d.id

    ORDER BY e.emp_status DESC, e.id DESC
    ";

    $result = $this->conn->query($sql);

    $SrNo = 0;
    $rows = '';

    while ($rw = $result->fetch_assoc()) {

        $SrNo++;
        $id = $rw['id'];

        $checked = ($rw['emp_status'] == '1') ? 'checked' : '';
        $rowClass = ($rw['emp_status'] == '1') ? '' : 'dim-row';

        // ✅ Food Badge
        $foodTime = (int)$rw['two_times_food_allowed'];

        if ($foodTime === 1) {
            $foodBadge = '<span class="badge bg-success">One Time</span>';
        } elseif ($foodTime === 2) {
            $foodBadge = '<span class="badge bg-primary">Two Times</span>';
        } else {
            $foodBadge = '<span class="badge bg-secondary">N/A</span>';
        }

        // ✅ Date Format
        $createdDate = !empty($rw['created_at']) 
            ? date('d/m/Y h:i A', strtotime($rw['created_at'])) 
            : 'N/A';

        // ✅ Row HTML
        $rows .= "
        <tr class='$rowClass'>
            <td>$SrNo</td>
            <td id='tempempid$id'>".htmlspecialchars($rw['emp_id'])."</td>
            <td id='tempempname$id'>".htmlspecialchars($rw['emp_name'])."</td>
            <td id='tempcompanyname$id' data-companyid='{$rw['company_id']}'>
                ".htmlspecialchars($rw['company_name'])."
            </td>
            <td id='tempdepartment$id' data-departmentid='{$rw['department_id']}'>
                ".htmlspecialchars($rw['department_name'])."
            </td>
            <td class='food-col' id='tempfoodtime$id' data-foodvalue='{$foodTime}'>
                $foodBadge
            </td>
            <td id='tempcreated$id'>$createdDate</td>

            <td>
                " . ($rw['emp_status'] == 1
                    ? "<i class='bx bxs-edit' style='cursor:pointer;font-size:18px;' onclick='ShowInEditor($id)'></i>"
                    : "<i class='bx bxs-edit' style='cursor:not-allowed;font-size:18px;opacity:0.4;' title='Activate Employee to edit'></i>"
                ) . "
            </td>

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