<?php
session_start(); 
include_once('config.php');

class FoodAPI {
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

        $admin = $_SESSION['name'];

        $stmt = $this->conn->prepare("
            INSERT INTO activity_logs (admin_user, action_type, target_type, message)
            VALUES (?, ?, 'food', ?)
        ");

        $stmt->bind_param("sss", $admin, $action, $message);
        $stmt->execute();
    }
 
    public function handleRequest() {
        $flag = $_POST['flag'] ?? '';

        switch($flag) { 
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
            case 'check_duplicate':
                $name = trim($_POST['txtfoodname'] ?? '');
                $id = $_POST['id'] ?? '';
                
                if ($id === '') {
                    $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM food_type_master WHERE food_type_name = ?");
                    $stmt->bind_param("s", $name);
                } else {
                    $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM food_type_master WHERE food_type_name = ? AND id != ?");
                    $stmt->bind_param("si", $name, $id);
                }

                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                echo $result['cnt'] > 0 ? "false" : "true";
                break;

            default:
                echo json_encode(['error' => 'Invalid flag']);
        }
    }

    // =========================
    // INSERT / UPDATE
    // =========================
    private function insertOrUpdate() 
    { 
        $id = $_POST['id'] ?? '';
        $name = trim($_POST['foodname'] ?? '');

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
                INSERT INTO food_type_master (food_type_name, created_by) 
                VALUES (?, ?)
            ");
            $stmt->bind_param("si", $name, $created_by);

            if ($stmt->execute()) {

                // ✅ LOG INSERT
                $this->logActivity("INSERT", "Added food: $name");

                echo json_encode(['status'=>'inserted']);

            } else {
                echo json_encode(['status'=>'error','message'=>$stmt->error]);
            }

        } else {

            // =========================
            // UPDATE (GET OLD NAME)
            // =========================
            $old = $this->conn->query("SELECT food_type_name FROM food_type_master WHERE id=$id")->fetch_assoc();
            $oldName = $old['food_type_name'] ?? '';

            $stmt = $this->conn->prepare("
                UPDATE food_type_master SET food_type_name=? WHERE id=?
            ");
            $stmt->bind_param("si", $name, $id);

            if ($stmt->execute()) {

                // ✅ LOG UPDATE
                if ($oldName != $name) {
                    $this->logActivity(
                        "UPDATE",
                        "Updated food: $oldName → $name"
                    );
                } else {
                    $this->logActivity(
                        "UPDATE",
                        "Updated food: $name (no visible change)"
                    );
                }

                echo json_encode(['status'=>'updated']);

            } else {
                echo json_encode(['status'=>'error','message'=>$stmt->error]);
            }
        }
    }

    // =========================
    // FETCH DROPDOWN
    // =========================
    private function fetchDropdowns() {
        $data = [];
        $result = $this->conn->query("SELECT id, food_type_name FROM food_type_master");
        $data['food_type_master'] = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    }

    // =========================
    // TOGGLE STATUS
    // =========================
    private function toggleStatus() {
        $id = $_POST['id'] ?? '';
        $status = $_POST['status'] ?? '0';

        // Get name for log
        $old = $this->conn->query("SELECT food_type_name FROM food_type_master WHERE id=$id")->fetch_assoc();
        $name = $old['food_type_name'] ?? '';

        $stmt = $this->conn->prepare("
            UPDATE food_type_master SET status=? WHERE id=?
        ");
        $stmt->bind_param("ii", $status, $id);

        if ($stmt->execute()) {

            $actionText = $status == 1 ? "Activated" : "Deactivated";

            // ✅ LOG STATUS
            $this->logActivity(
                "STATUS",
                "$actionText food: $name"
            );

            echo json_encode(['status'=>'success']);

        } else {
            echo json_encode(['status'=>'error', 'message'=>$stmt->error]);
        }
    }

    // =========================
    // SHOW DATA
    // =========================
    private function showData() 
    {
        $sql = "SELECT * FROM food_type_master ORDER BY status DESC, id DESC";
        $result = $this->conn->query($sql);

        $SrNo = 0;
        $rows = '';

        while($rw = $result->fetch_assoc()) {

            $SrNo++;
            $id = $rw['id'];

            $checked = $rw['status'] == '1' ? 'checked' : '';
            $rowClass = $rw['status'] == '1' ? '' : 'dim-row';

            $rows .= "<tr class='$rowClass'>
                        <td>$SrNo</td>
                        <td id='tempfoodnm$id'>{$rw['food_type_name']}</td>
                        <td>".date('d/m/Y h:i A', strtotime($rw['created_at']))."</td>      

                        <td>
                            ".($rw['status']==1 
                            ? "<i class='bx bxs-edit' style='cursor:pointer;font-size:18px;' onclick='ShowInEditor($id)'></i>" 
                            : "<i class='bx bxs-edit' style='cursor:not-allowed;font-size:18px;opacity:0.4;' title='Activate Food to edit'></i>"
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
}

$api = new FoodAPI($conn);
$api->handleRequest();
?>