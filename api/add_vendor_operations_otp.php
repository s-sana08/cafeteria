<?php
include_once('config.php');

class VendorAPI {
    private $conn;
 
    public function __construct($conn) {
        $this->conn = $conn;
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
                case 'send_otp':
                $this->sendOtp();
                break;

                case 'verify_otp':
                $this->verifyOtp();
                break;
            default:
                echo json_encode(['error' => 'Invalid flag']);
        }
    }

    private function insertOrUpdate() {
        $id = $_POST['id'] ?? '';
        $name = $_POST['vndname'] ?? '';
        $username = $_POST['vndusernm'] ?? '';
        $password = $_POST['vndpass'] ?? '';
        $email_id = $_POST['vndemail'] ?? '';
        $food_type_id = $_POST['vndfood'] ?? '';
        $role = 2; // always default

        if ($id === '') {

    $stmt = $this->conn->prepare(
    "INSERT INTO user_master (name, username, password, email_id, food_type_id, role) VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssssii", $name, $username, $password, $email_id, $food_type_id, $role);

    if($stmt->execute()){
        echo json_encode(['status' => 'inserted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
}
        else {
            
            $stmt = $this->conn->prepare("UPDATE user_master SET name=?, username=?, password=?, email_id=?, food_type_id=? WHERE id=?");
            // $stmt->bind_param("ssiiii", $name, $username, $password, $email_id, $food_type_id, $id);
            $stmt->bind_param("ssssii", $name, $username, $password, $email_id, $food_type_id, $id);
            if($stmt->execute()){
                echo json_encode(['status' => 'updated']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }
        }
    }

   private function sendOtp() {

    $email = $_POST['email'] ?? '';

    if($email == ''){
        echo json_encode(['status'=>'error','message'=>'Email required']);
        return;
    }

    $otp = rand(100000, 999999);

    $_SESSION['otp'] = $otp;

    // ⚠️ localhost साठी direct OTP return
    echo json_encode([
        'status' => 'sent',
        'otp' => $otp   // 👈 testing साठी
    ]);
}


private function verifyOtp() {

    $userOtp = $_POST['otp'] ?? '';

    if(isset($_SESSION['otp']) && $_SESSION['otp'] == $userOtp){
        echo json_encode(['status'=>'verified']);
    } else {
        echo json_encode(['status'=>'error']);
    }
}

    private function fetchDropdowns() 
    {

    $data = [];

    $result = $this->conn->query("SELECT id, food_type_name FROM food_type_master");

    $data['food_type_master'] = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($data);
    }


       private function toggleStatus() {
        $id = $_POST['id'] ?? '';
        $status = $_POST['status'] ?? '0';

        $stmt = $this->conn->prepare("UPDATE user_master SET status=? WHERE id=?");
        $stmt->bind_param("ii", $status, $id);
        echo $stmt->execute() ? json_encode(['status'=>'success']) : json_encode(['status'=>'error', 'message'=>$stmt->error]);
    }


    private function showData() 
    {
       $sql = "SELECT u.*, f.food_type_name 
		FROM user_master u
		LEFT JOIN food_type_master f ON u.food_type_id = f.id WHERE u.role = 2
	    ORDER BY u.status DESC, u.id DESC"; 

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
                        <td id='tempvndnm$id'>{$rw['name']}</td>
                        <td id='tempvndusernm$id'>{$rw['username']}</td>
                       <td>
    <div style='display:flex; align-items:center; justify-content: space-around;'>
        <span id='pass_$id' data-pass='{$rw['password']}' class='fixed-pass'>******</span>
        <i class='bx bx-show toggle-icon' onclick='togglePassword($id)'></i>
    </div>
</td>
                        <td id='tempvndemail$id'>{$rw['email_id']}</td>
                        <td id='tempfoodname$id' data-foodid='{$rw['food_type_id']}'>{$rw['food_type_name']}</td>
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