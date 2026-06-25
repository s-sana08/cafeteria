<?php
session_start(); 
include_once('config.php');

class CompanyAPI {
    private $conn;

    public function __construct($conn) { 
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

         $admin = $_SESSION['name'] ?? 'Unknown';

        $stmt = $this->conn->prepare("
            INSERT INTO activity_logs (admin_user, action_type, target_type, message)
            VALUES (?, ?, 'company', ?)
        ");

        $stmt->bind_param("sss", $admin, $action, $message);
        $stmt->execute();
    }

    // =========================
    // HANDLE REQUEST
    // =========================
    public function handleRequest() {
        $flag = $_POST['flag'] ?? '';

        switch($flag) {
            case 'insert': $this->insertOrUpdate(); break;
            case 'showdata': $this->showData(); break;
            case 'toggle_status': $this->toggleStatus(); break;
            case 'check_duplicate': $this->checkDuplicate(); break;
            default: echo json_encode(['error' => 'Invalid flag']);
        }
    } 

    // =========================
    // INSERT / UPDATE
    // =========================
    private function insertOrUpdate() {
        $id = $_POST['id'] ?? '';
        $name = trim($_POST['compname'] ?? '');

        if($name === '') {
            echo json_encode(['status'=>'error', 'message'=>'Company name required']);
            return;
        }

        // Get user session
        if (!isset($_SESSION['id'])) {
            echo json_encode(['status'=>'error', 'message'=>'User session not found']);
            return;
        }

        $created_by = $_SESSION['id'];

        // =========================
        // DUPLICATE CHECK
        // =========================
        if($id === '') {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM company_master WHERE company_name=?");
            $stmt->bind_param("s", $name);
        } else {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM company_master WHERE company_name=? AND id!=?");
            $stmt->bind_param("si", $name, $id);
        }

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if($row['cnt'] > 0) {
            echo json_encode(['status'=>'error', 'message'=>'Company name already exists']);
            return;
        }

        // =========================
        // INSERT
        // =========================
        if($id === '') {

            $stmt = $this->conn->prepare("
                INSERT INTO company_master (company_name, created_by) VALUES (?, ?)
            ");
            $stmt->bind_param("si", $name, $created_by);

            if($stmt->execute()) {

                // ✅ LOG INSERT
                $this->logActivity("INSERT", "Added company: $name");

                echo json_encode(['status'=>'inserted']);
            } else {
                echo json_encode(['status'=>'error', 'message'=>$stmt->error]);
            }

        } else {

            // =========================
            // UPDATE (GET OLD NAME FIRST)
            // =========================
            $old = $this->conn->query("SELECT company_name FROM company_master WHERE id=$id")->fetch_assoc();
            $oldName = $old['company_name'] ?? '';

            $stmt = $this->conn->prepare("
                UPDATE company_master SET company_name=? WHERE id=?
            ");
            $stmt->bind_param("si", $name, $id);

            if($stmt->execute()) {

                // ✅ LOG UPDATE
                if($oldName != $name) {
                    $this->logActivity(
                        "UPDATE",
                        "Updated company: $oldName → $name"
                    );
                } else {
                    $this->logActivity(
                        "UPDATE",
                        "Updated company: $name (no visible change)"
                    );
                }

                echo json_encode(['status'=>'updated']);
            } else {
                echo json_encode(['status'=>'error', 'message'=>$stmt->error]);
            }
        }
    }

    // =========================
    // SHOW DATA
    // =========================
    private function showData() 
    {
        $sql = "SELECT * FROM company_master ORDER BY status DESC, id DESC";
        $result = $this->conn->query($sql);

        $SrNo = 0;
        $rows = '';

        while($rw = $result->fetch_assoc()) {

            $SrNo++;
            $id = $rw['id'];

            $checked = $rw['status'] == '1' ? 'checked' : '';
            $rowClass = $rw['status'] == '1' ? '' : 'dim-row';

            $created = date('d/m/Y h:i A', strtotime($rw['created_at']));

            $rows .= "<tr class='$rowClass'>
                        <td>$SrNo</td>
                        <td id='tempcompnm$id'>{$rw['company_name']}</td>
                        <td>$created</td>                        
                        <td>
                        ".($rw['status']==1 
                        ? "<i class='bx bxs-edit' style='cursor:pointer;font-size:18px;' onclick='ShowInEditor($id)'></i>" 
                        : "<i class='bx bxs-edit' style='cursor:not-allowed;font-size:18px;opacity:0.4;'></i>"
                        )."
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

    // =========================
    // TOGGLE STATUS
    // =========================
    private function toggleStatus() {
        $id = $_POST['id'] ?? '';
        $status = $_POST['status'] ?? '0';

        $old = $this->conn->query("SELECT company_name FROM company_master WHERE id=$id")->fetch_assoc();
        $name = $old['company_name'] ?? '';

        $stmt = $this->conn->prepare("
            UPDATE company_master SET status=? WHERE id=?
        ");
        $stmt->bind_param("ii", $status, $id);

        if($stmt->execute()) {

            $actionText = $status == 1 ? "Activated" : "Deactivated";

            // ✅ LOG STATUS CHANGE
            $this->logActivity(
                "STATUS",
                "$actionText company: $name"
            );

            echo json_encode(['status'=>'success']);

        } else {
            echo json_encode(['status'=>'error','message'=>$stmt->error]);
        }
    }

    // =========================
    // CHECK DUPLICATE
    // =========================
    private function checkDuplicate() {
        $name = trim($_POST['txtcompname'] ?? '');
        $id = $_POST['id'] ?? '';

        if ($id === '') {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM company_master WHERE company_name=?");
            $stmt->bind_param("s", $name);
        } else {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM company_master WHERE company_name=? AND id!=?");
            $stmt->bind_param("si", $name, $id);
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        echo $result['cnt'] > 0 ? "false" : "true";
    }
}

$api = new CompanyAPI($conn);
$api->handleRequest();
?>