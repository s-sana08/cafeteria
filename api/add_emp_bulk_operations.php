<?php
session_start();
include_once('config.php');

class EmployeeAPI {
    private $conn;

    public function __construct($conn) {
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
            VALUES (?, ?, 'employee_bulk', ?)
        ");

        $stmt->bind_param("sss", $admin, $action, $message);
        $stmt->execute();
    }

    public function handleRequest() {
        $flag = $_POST['flag'] ?? '';

        switch($flag) {
            case 'bulk_upload_csv':
                $this->bulkUploadCSV();
                break;

            case 'showdata':
                $this->showData();
                break;

            case 'download_errors':
                $this->downloadErrors();
                break;

            default:
                echo json_encode([
                    'status' => 'error',
                    'errors' => ['Invalid flag']
                ]);
        }
    }

    // =========================
    // DOWNLOAD ERRORS
    // =========================
    private function downloadErrors() {
        if (!isset($_POST['errors']) || !is_array($_POST['errors']) || empty($_POST['errors'])) {
            echo "No errors to download.";
            return;
        }

        $errors = $_POST['errors'];

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=employee_upload_errors.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Error Details']);

        foreach ($errors as $err) {
            fputcsv($output, [$err]);
        }

        fclose($output);
        exit;
    }

    // =========================
    // BULK UPLOAD CSV
    // =========================
    private function bulkUploadCSV() {

        if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] != 0) {
            echo json_encode(['status'=>'error','errors'=>['Please select a valid CSV file.']]);
            return;
        }

        if ($_FILES['csvFile']['size'] == 0) {
            echo json_encode(['status'=>'error','errors'=>['The CSV file is empty.']]);
            return;
        }

        $file = $_FILES['csvFile']['tmp_name'];
        $handle = fopen($file, "r");

        if (!$handle) {
            echo json_encode(['status'=>'error','errors'=>['Cannot open file.']]);
            return;
        }

        $rowNum = 0;
        $hasValidData = false;

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNum++;
            if ($rowNum == 1) continue;
            if (!empty(array_filter($row))) {
                $hasValidData = true;
                break;
            }
        }

        if (!$hasValidData) {
            fclose($handle);
            echo json_encode(['status'=>'error','errors'=>['CSV file contains no valid employee data.']]);
            return;
        }

        rewind($handle);

        $successCount = 0;
        $errorRows = [];
        $duplicateIds = [];
        $insertedEmployees = []; // ✅ NEW
        $rowNum = 0;
        $header = [];
        $headerIndex = [];

        $requiredColumns = [
            'emp_id',
            'emp_name',
            'company_id',
            'department_id',
            'two_times_food_allowed'
        ];

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNum++;

            if ($rowNum == 1) {
                $header = array_map('strtolower', array_map('trim', $row));

                foreach ($requiredColumns as $colName) {
                    $idx = array_search($colName, $header);
                    if ($idx === FALSE) {
                        fclose($handle);
                        echo json_encode(['status'=>'error','errors'=>["Missing required column: $colName."]]);
                        return;
                    }
                    $headerIndex[$colName] = $idx;
                }
                continue;
            }

            if (empty(array_filter($row))) continue;

            $emp_id = trim($row[$headerIndex['emp_id']] ?? '');
            $emp_name = trim($row[$headerIndex['emp_name']] ?? '');
            $company_input = trim($row[$headerIndex['company_id']] ?? '');
            $department_input = trim($row[$headerIndex['department_id']] ?? '');
            $food_input_raw = trim($row[$headerIndex['two_times_food_allowed']] ?? '');

            $rowErrors = [];

            // FOOD
            $food_input = strtolower($food_input_raw);
            $food_input = preg_replace('/\s+/', ' ', $food_input);
            $food_input = str_replace(['times'], 'time', $food_input);

            $foodMap = ['1'=>1,'one'=>1,'one time'=>1,'2'=>2,'two'=>2,'two time'=>2];

            if (!isset($foodMap[$food_input])) {
                $rowErrors[] = "invalid food time '$food_input_raw'";
            } else {
                $food_time_db = $foodMap[$food_input];
            }

            // VALIDATION
            if ($emp_id === '' || $emp_name === '' || $company_input === '' || $department_input === '') {
                $rowErrors[] = "missing required data";
            }

            if (!ctype_digit($emp_id)) $rowErrors[] = "emp_id must be numeric";
            if (strlen($emp_id) > 10) $rowErrors[] = "emp_id max 10 digits";
            if (ltrim($emp_id,'0')==='') $rowErrors[] = "invalid emp_id";
            if (strlen($emp_name)<2 || strlen($emp_name)>30) $rowErrors[] = "emp_name must be 2-30 chars";
            if (!preg_match('/^[A-Za-z]+( [A-Za-z]+)*$/',$emp_name)) $rowErrors[] = "invalid emp_name";

            // COMPANY
            if (!is_numeric($company_input)) {
                $stmt = $this->conn->prepare("SELECT id FROM company_master WHERE LOWER(company_name)=?");
                $name = strtolower($company_input);
                $stmt->bind_param("s",$name);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows==0) {
                    $rowErrors[] = "company '$company_input' not found";
                } else {
                    $stmt->bind_result($company_id_db);
                    $stmt->fetch();
                }
                $stmt->close();
            } else {
                $company_id_db = $company_input;
            }

            // DEPARTMENT
            if (!is_numeric($department_input)) {
                $stmt = $this->conn->prepare("SELECT id FROM department_master WHERE LOWER(department_name)=?");
                $name = strtolower($department_input);
                $stmt->bind_param("s",$name);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows==0) {
                    $rowErrors[] = "department '$department_input' not found";
                } else {
                    $stmt->bind_result($department_id_db);
                    $stmt->fetch();
                }
                $stmt->close();
            } else {
                $department_id_db = $department_input;
            }

            // DUPLICATE
            $stmt = $this->conn->prepare("SELECT emp_id FROM employee WHERE emp_id=?");
            $stmt->bind_param("s",$emp_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows>0) {
                $rowErrors[] = "duplicate emp_id '$emp_id'";
                $duplicateIds[] = $emp_id;
            }
            $stmt->close();

            if (!empty($rowErrors)) {
                $errorRows[] = "Row $rowNum: " . implode("; ", $rowErrors);
                continue;
            }

            // INSERT
            $stmt = $this->conn->prepare(
                "INSERT INTO employee (emp_id, emp_name, company_id, department_id, two_times_food_allowed)
                 VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->bind_param("ssiii",$emp_id,$emp_name,$company_id_db,$department_id_db,$food_time_db);

            if ($stmt->execute()) {
                $successCount++;
                $insertedEmployees[] = "$emp_name ($emp_id)"; // ✅ STORE
            } else {
                $errorRows[] = "Row $rowNum: insert failed";
            }

            $stmt->close();
        }

        fclose($handle);

        // =========================
        // ✅ LOGGING WITH DETAILS
        // =========================
        $empList = "";

        if (!empty($insertedEmployees)) {
            $limited = array_slice($insertedEmployees, 0, 10);
            $empList = " | Employees: " . implode(", ", $limited);

            if (count($insertedEmployees) > 10) {
                $empList .= " ... +" . (count($insertedEmployees) - 10) . " more";
            }
        }

        if ($successCount > 0 && empty($errorRows)) {
            $this->logActivity("INSERT", "Bulk upload successful: $successCount employees added$empList");
        } elseif ($successCount > 0) {
            $this->logActivity("INSERT", "Bulk upload partial: $successCount added, ".count($errorRows)." failed$empList");
        } else {
            $this->logActivity("INSERT", "Bulk upload failed: No employees inserted");
        }

        $uniqueDuplicates = array_values(array_unique($duplicateIds));

        echo json_encode([
            'status' => 'success',
            'success_count' => $successCount,
            'duplicate_emp_ids' => $uniqueDuplicates,
            'errors' => array_merge(
                !empty($uniqueDuplicates) ? ["Duplicate emp_ids: ".implode(', ', $uniqueDuplicates)] : [],
                $errorRows
            ),
            'message' => $successCount > 0 ? "$successCount employees inserted successfully." : ''
        ]);
    }

    // =========================
    // SHOW DATA
    // =========================
    private function showData()  
    {
        $stmt = $this->conn->prepare(
            "SELECT 
                e.id, e.emp_id, e.emp_name, e.two_times_food_allowed, e.emp_status,
                e.created_at, c.company_name, d.department_name
            FROM employee e 
            LEFT JOIN company_master c ON e.company_id = c.id
            LEFT JOIN department_master d ON e.department_id = d.id
            WHERE e.emp_status = 1
            ORDER BY e.emp_status DESC, e.id DESC"
        );

        $stmt->execute();
        $result = $stmt->get_result(); 

        $rows = '';
        $SrNo = 0;

        while ($rw = $result->fetch_assoc()) {

            $SrNo++;
            $id = $rw['id'];

            $foodTime = (int)$rw['two_times_food_allowed'];
            $foodBadge = ($foodTime===1)
                ? '<span class="badge bg-success">One Time</span>'
                : (($foodTime===2)
                    ? '<span class="badge bg-primary">Two Times</span>'
                    : '<span class="badge bg-secondary">N/A</span>');

            $createdDate = !empty($rw['created_at']) 
                ? date('d/m/Y h:i A', strtotime($rw['created_at'])) 
                : 'N/A';

            $rows .= "<tr>
                        <td>$SrNo</td>
                        <td>".htmlspecialchars($rw['emp_id'])."</td>
                        <td>".htmlspecialchars($rw['emp_name'])."</td>
                        <td>".htmlspecialchars($rw['company_name'])."</td>
                        <td>".htmlspecialchars($rw['department_name'])."</td>
                        <td>$foodBadge</td>
                        <td id='tempcreated$id'>$createdDate</td>
                      </tr>";
        }

        $stmt->close();
        echo $rows;
    }
}

$api = new EmployeeAPI($conn);
$api->handleRequest();
?>