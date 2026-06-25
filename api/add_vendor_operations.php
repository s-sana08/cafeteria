<?php
session_start(); 
include_once('config.php');

class VendorAPI {
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
            VALUES (?, ?, 'vendor', ?)
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

            default:
                echo json_encode(['error' => 'Invalid flag']);
        }
    }

    // =========================
    // INSERT / UPDATE
    // =========================
    private function insertOrUpdate() {

        $id = $_POST['id'] ?? '';
        $name = $_POST['vndname'] ?? '';
        $username = $_POST['vndusernm'] ?? '';
        $password = $_POST['vndpass'] ?? '';
        $email_id = $_POST['vndemail'] ?? '';
        $food_type_id = $_POST['vndfood'] ?? '';
        $role = 2;


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
                INSERT INTO user_master 
                (name, username, password, email_id, food_type_id, role, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("ssssiii", $name, $username, $password, $email_id, $food_type_id, $role, $created_by);

            if($stmt->execute()) {

                // ✅ LOG INSERT
                $this->logActivity(
                    "INSERT",
                    "Added vendor: $name (Username: $username)"
                );

                echo json_encode(['status' => 'inserted']);

            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }

        } else {

            // =========================
            // GET OLD DATA
            // =========================
            $old = $this->conn->query("
                SELECT name, username, email_id, food_type_id 
                FROM user_master 
                WHERE id=$id
            ")->fetch_assoc();

            $changes = [];

            if ($old['name'] != $name) {
                $changes[] = "Name: {$old['name']} → $name";
            }

            if ($old['username'] != $username) {
                $changes[] = "Username: {$old['username']} → $username";
            }

            if ($old['email_id'] != $email_id) {
                $changes[] = "Email: {$old['email_id']} → $email_id";
            }

            if ($old['food_type_id'] != $food_type_id) {
                $oldFood = $this->conn->query("SELECT food_type_name FROM food_type_master WHERE id={$old['food_type_id']}")->fetch_assoc();
                $newFood = $this->conn->query("SELECT food_type_name FROM food_type_master WHERE id=$food_type_id")->fetch_assoc();

                $changes[] = "Food: {$oldFood['food_type_name']} → {$newFood['food_type_name']}";
            }

            // =========================
            // UPDATE
            // =========================
            $stmt = $this->conn->prepare("
                UPDATE user_master 
                SET name=?, username=?, password=?, email_id=?, food_type_id=? 
                WHERE id=?
            ");
            $stmt->bind_param("ssssii", $name, $username, $password, $email_id, $food_type_id, $id);

            if($stmt->execute()) {

                $msg = !empty($changes)
                    ? "Updated vendor $name (" . implode(", ", $changes) . ")"
                    : "Updated vendor $name (No changes)";

                // ✅ LOG UPDATE
                $this->logActivity("UPDATE", $msg);

                echo json_encode(['status' => 'updated']);

            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }
        }
    }

    // =========================
    // FETCH DROPDOWN
    // =========================
    private function fetchDropdowns() 
    {
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

        // Get vendor name
        $old = $this->conn->query("SELECT name FROM user_master WHERE id=$id")->fetch_assoc();
        $name = $old['name'] ?? '';

        $stmt = $this->conn->prepare("
            UPDATE user_master SET status=? WHERE id=?
        ");
        $stmt->bind_param("ii", $status, $id);

        if($stmt->execute()) {

            $action = $status == 1 ? "Activated" : "Deactivated";

            // ✅ LOG STATUS
            $this->logActivity(
                "STATUS",
                "$action vendor: $name"
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
        $sql = "SELECT u.*, f.food_type_name, u.created_at 
            FROM user_master u
            LEFT JOIN food_type_master f ON u.food_type_id = f.id 
            WHERE u.role = 2
            ORDER BY u.status DESC, u.id DESC"; 

        $result = $this->conn->query($sql);

        $SrNo = 0; 
        $rows = '';

        while($rw = $result->fetch_assoc()) {

            $SrNo++;
            $id = $rw['id'];
            $checked = $rw['status'] == '1' ? 'checked' : '';
            $rowClass = $rw['status'] == '1' ? '' : 'dim-row';

            $createdDate = !empty($rw['created_at']) 
                ? date('d/m/Y h:i A', strtotime($rw['created_at'])) 
                : 'N/A';

            $rows .= "<tr class='$rowClass'>
                        <td>$SrNo</td>
                        <td id='tempvndnm$id'>{$rw['name']}</td>
                        <td id='tempvndusernm$id'>{$rw['username']}</td>
                        <td>
                            <div style='display:flex; align-items:center; justify-content: space-around;'>
                                <span id='pass_$id' data-pass='{$rw['password']}' class='fixed-pass'>******</span>
                                <i class='bx bx-show toggle-icon' onclick='togglePassword($id)'></i>
                            </div>
                        </td>
                        <td id='tempvndemail$id'>{$rw['email_id']}</td>
                        <td id='tempfoodname$id' data-foodid='{$rw['food_type_id']}'>
                            {$rw['food_type_name']}
                        </td>
                        <td id='tempcreated$id'>$createdDate</td>
                        <td>
                            ".($rw['status']==1 
                            ? "<i class='bx bxs-edit' style='cursor:pointer;font-size:18px;' onclick='ShowInEditor($id)'></i>" 
                            : "<i class='bx bxs-edit' style='cursor:not-allowed;font-size:18px;opacity:0.4;' title='Activate Vendor to edit'></i>"
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

$api = new VendorAPI($conn);
$api->handleRequest();
?>