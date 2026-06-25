<?php
include_once('config.php');

class CompanyAPI {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }

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

    private function insertOrUpdate() {
        $id = $_POST['id'] ?? '';
        $name = trim($_POST['compname'] ?? '');

        if($name === '') {
            echo json_encode(['status'=>'error', 'message'=>'Company name required']);
            return;
        }

        // Check duplicate
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

        // Insert or update
        if($id === '') {
            $stmt = $this->conn->prepare("INSERT INTO company_master (company_name) VALUES (?)");
            $stmt->bind_param("s", $name);
            echo $stmt->execute() ? json_encode(['status'=>'inserted']) : json_encode(['status'=>'error', 'message'=>$stmt->error]);
        } else {
            $stmt = $this->conn->prepare("UPDATE company_master SET company_name=? WHERE id=?");
            $stmt->bind_param("si", $name, $id);
            echo $stmt->execute() ? json_encode(['status'=>'updated']) : json_encode(['status'=>'error', 'message'=>$stmt->error]);
        }
    }

    private function showData() {
        $sql = "SELECT * FROM company_master ORDER BY id DESC";
        $result = $this->conn->query($sql);
        $SrNo = 0; $rows = '';
        while($rw = $result->fetch_assoc()) {
            $SrNo++;
            $id = $rw['id'];
            $checked = $rw['status'] == '1' ? 'checked' : '';
            $style = $rw['status'] == '1' ? '' : 'style="opacity:0.5;"';
            $rows .= "<tr $style>
                        <td>$SrNo</td>
                        <td id='tempcompnm$id'>{$rw['company_name']}</td>
<td>
".($rw['status']==1 
? "<i class='bx bxs-edit' style='cursor:pointer;font-size:18px;' onclick='ShowInEditor($id)'></i>" 
: "<i class='bx bxs-edit' style='cursor:not-allowed;font-size:18px;opacity:0.4;' title='Activate company to edit'></i>"
)."
</td>                        <td><label class='switch'>
                            <input type='checkbox' class='status-toggle' data-id='$id' $checked>
                            <span class='slider round'></span>
                        </label></td>
                      </tr>";
        }
        echo $rows;
    }

    private function toggleStatus() {
        $id = $_POST['id'] ?? '';
        $status = $_POST['status'] ?? '0';
        $stmt = $this->conn->prepare("UPDATE company_master SET status=? WHERE id=?");
        $stmt->bind_param("ii", $status, $id);
        echo $stmt->execute() ? json_encode(['status'=>'success']) : json_encode(['status'=>'error','message'=>$stmt->error]);
    }

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