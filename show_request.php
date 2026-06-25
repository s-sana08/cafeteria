<?php
session_start();

// Ensure employee/vendor is logged in
if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php");
    exit;
}

// Include DB connection
include_once('api/config.php'); // Make sure path is correct

// Fetch all employee requests
$requests = [];
if ($conn) {
    // $res = $conn->query("SELECT * FROM employee_request ORDER BY id DESC");
// $res = $conn->query(" SELECT * FROM employee_request WHERE status = 1 ORDER BY flag ASC, id DESC "); 
$res = $conn->query("SELECT * FROM employee_request WHERE status = 1 AND flag = 0 ORDER BY id DESC");   
if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $requests[] = $row;
        }
    }
}


$companies = [];
$sql = "SELECT id, company_name FROM company_master WHERE status='1' ORDER BY company_name ASC";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $companies[] = $row;
}

$departments = [];
$sql2 = "SELECT id, department_name FROM department_master WHERE status='1'  ORDER BY department_name ASC";
$result = $conn->query($sql2);
while($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

$food_name = [];
$sql3 = "SELECT id, food_type_name FROM food_type_master WHERE status='1'  ORDER BY food_type_name ASC";
$result = $conn->query($sql3);
while($row = $result->fetch_assoc()) {
    $food_name[] = $row;
}
?>

<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/ss_logo.png" type="image/png">
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css">
	<link href="assets/sass/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link rel="stylesheet" href="assets/sass/semi-dark.css">
	<link rel="stylesheet" href="assets/sass/bordered-theme.css">
	<title>Cafeteria | Management System</title>
</head>
<style>
    .dt-top {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: nowrap;
    justify-content: space-between;
}


.page-footer {
    margin-top: auto;
}

.wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
@media print {
    .no-export {
        display: none !important;
    }
}


/* Dropdown Value black when validation start */
    #emp_form select.error {
        color: black !important;
        border-color: red;
    }

    #emp_form select option[value=""] {
        color: gray;
    }

    /* Dropdown Value black when validation End */
/* Make jQuery Validate error messages bold */
    /* label.error {
        margin-top:5px;
        font-weight: 600;
        color: red; 
        font-size: 14px; 
    } */

/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 30px;   /* track width */
  height: 16px;  /* track height */
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider (track) */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc; /* inactive color */
  transition: 0.4s;
  border-radius: 16px;    /* half of track height for full round */
}

/* The circle */
.slider:before {
  position: absolute;
  content: "";
  height: 12px;           /* smaller circle */
  width: 12px;            /* smaller circle */
  left: 2px;              /* small padding inside track */
  bottom: 2px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}

/* When checkbox is checked */
input:checked + .slider {
  background-color: #4CAF50; /* green when active */
}

/* Move the circle to right when checked */
input:checked + .slider:before {
  transform: translateX(14px); /* track width - circle width - padding */
}

/* Rounded sliders */
.slider.round {
  border-radius: 16px;
}

.slider.round:before {
  border-radius: 50%;
}


.btn-approve {
    background: linear-gradient(130deg, #06a548, #2e7d32);
    border: none;
    color: #fff;
    border-radius: 20px;
    padding: 2px 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-approve:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(40,167,69,0.3);
}

.btn-reject {
    background: linear-gradient(130deg, #d93501, #c62828);
    border: none;
    color: #fff;
    border-radius: 20px;
    padding: 2px 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-reject:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(220,53,69,0.3);
}

.btn i {
    font-size: 14px;
}

@media (max-width: 768px){

    .btn-approve{
        font-size: 12px;
    }
    .btn-reject{
        font-size: 12px;
    }
}

</style>

<body>
	<!--wrapper-->
	<div class="wrapper">
	    <!--sidebar wrapper -->
		<?php include("api/sidebar.php"); ?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php include("api/header.php"); ?>
        <!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content container-xxl">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3 text-uppercase">Configuration</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><a href="index.php" target="_blank" rel="noopener noreferrer"><i class="bx bx-home-alt"></i></a>
								</a></li>
								<li class="breadcrumb-item active" aria-current="page"><em>Registration Request</em></li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<!--end row-->
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0 text-uppercase">Registration Request</h5>
                            </div>
                            <div class="card-body p-4" style="overflow-x: auto;">
                                <div id="rsttbl" >
                                    <table id="example2" class="table table-striped table-bordered">
                                        <thead>
                                            <th style="display:none;">Flag</th>
                                            <th>Sr. No.</th>
                                            <th>Vendor Name</th>
                                            <th>Employee ID</th>
                                            <th>Request Time</th>
                                            <th>Status</th>
                                            <th  style="width: 250px !important;" class="no-export">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($requests) > 0): ?>
                                            <?php foreach($requests as $req): ?>
                                            <tr>
                                                <td style="display:none;"><?php echo $req['flag']; ?></td>
                                                <td><?php echo $req['id']; ?></td>
                                                <td><?php echo htmlspecialchars($req['vnd_name']); ?></td>
                                                <td class="emp_id"><?php echo htmlspecialchars($req['emp_id']); ?></td>                                                <td><?php echo date('d-m-Y h:i A', strtotime($req['created_at'])); ?></td>
                                                <td id="status-<?php echo $req['id']; ?>">
												<?php 
													echo ($req['flag'] == 0) 
														? "<span class='badge bg-warning text-dark rounded-pill'>Requested</span>" 
														: "<span class='badge bg-success text-dark rounded-pill'>Processed</span>"; 
												?>
											    </td> 
                                                <td>
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-approve btn-sm me-3 approved-btn" 
                                                        data-id="<?php echo $req['id']; ?>"
                                                        data-flag="<?php echo $req['flag']; ?>">
                                                        <i class="bi bi-check-circle me-1"></i> Approve
                                                    </button>
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-reject btn-sm delete-btn" 
                                                        data-id="<?php echo $req['id']; ?>"
                                                        data-flag="<?php echo $req['flag']; ?>">
                                                        <i class="bi bi-x-circle me-1"></i> Reject
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No requests found</td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>    
                                    </table>
                                </div>
			                </div>
				        </div>
			        </div>
				</div>
				<!--end row-->
			</div>
		</div>

        <!-- Approve Modal -->
      <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="  max-width: 500px; /* modal won't exceed 500px */
    width: 90%; " >
        <form id="emp_form" class="needs-validation" novalidate >
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Approve Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="modalRequestId">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="emp_id" class="form-label">Employee ID</label>
                            <input type="text" class="form-control" id="emp_id" name="emp_id" placeholder="Enter Employee ID" required>
                            <div class="invalid-feedback">Please enter the employee ID.</div>
                        </div>
                        <div class="col-md-12">
                            <label for="empName" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" id="empName" name="emp_name" placeholder="Enter Employee Name" required>
                            <div class="invalid-feedback">Please enter the employee name.</div>
                        </div>
                        <div class="col-md-12">
                            <label for="companyName" class="form-label">Company Name</label>
                            <select class="form-select" id="companyName" name="company_id" required>
                                <option value="">Select Company</option>
                                <?php foreach($companies as $comp): ?>
                                    <option value="<?= $comp['id']; ?>"><?= htmlspecialchars($comp['company_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a company.</div>
                        </div>
                        <div class="col-md-12">
                            <label for="departmentName" class="form-label">Department Name</label>
                            <select class="form-select" id="departmentName" name="department_id" required>
                                <option value="">Select Department</option>
                                <?php foreach($departments as $dprt): ?>
                                    <option value="<?= htmlspecialchars($dprt['id']); ?>"><?= htmlspecialchars($dprt['department_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a department.</div>
                        </div>
                        <div class="col-md-12">
                            <label for="foodTime" class="form-label">Food Time</label>
                            <select class="form-select" id="foodTime" name="foodTime">
                                <option selected disabled value="">Select Food Time</option>
                                <option value="1">One Time</option>
                                <option value="2">Two Times</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                   
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Approve
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Optional: Bootstrap Icons CDN for icons -->
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		
		<?php include("api/footer.php"); ?>
	</div>
	<!--end wrapper-->






<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="assets/plugins/validation/jquery.validate.min.js"></script>
<script src="assets/plugins/validation/validation-script.js"></script>
<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    $(document).ready(function() {
    <?php if(isset($_SESSION['emp_role'])){ ?>
    var vendorName = "<?php echo addslashes($_SESSION['name']); ?>";
    var buttonsConfig = [
    {
        extend: 'excel',
        title: 'Registration Request Report',
        exportOptions: 
        {
            columns: [1, 2, 3, 4]
        },
        action: function(e, dt, button, config) 
        {
            Swal.fire({
            icon: "warning",
            title: "Are you sure?",
            text: "Do you want to download this as Excel?",
            showCancelButton: true,
            confirmButtonText: "Yes, Download",
            cancelButtonText: "Cancel",
            customClass: 
            {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            didOpen: () => Swal.getConfirmButton().focus()
            }).then((result) => 
            {
                if(result.isConfirmed)
                {
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                }
            });
        }
    },
    {
        extend: 'pdf',
        title: 'Registration Request Report',
        exportOptions: {
            columns: [1, 2, 3, 4] // columns to export
        },
        action: function(e, dt, button, config) 
        {
            Swal.fire({
            icon: "warning",
            title: "Are you sure?",
            text: "Do you want to download this as PDF?",
            showCancelButton: true,
            confirmButtonText: "Yes, Download",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            didOpen: () => Swal.getConfirmButton().focus()
            }).then((result) => {
            if(result.isConfirmed) {
                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
            }
            });
        },
        customize: function(doc) 
        {
            // Center and style the title
            doc.content[0].alignment = 'center';
            doc.content[0].fontSize = 14;
            doc.content[0].bold = true;
            doc.content[0].margin = [0, 0, 0, 10];

            // Make table full page width
            var table = doc.content[1].table;
            var columnCount = table.body[0].length;
            table.widths = Array(columnCount).fill('*'); // full width

            // Add borders and padding
            var objLayout = {};
            objLayout['hLineWidth'] = function(i) { return 0.5; };
            objLayout['vLineWidth'] = function(i) { return 0.5; };
            objLayout['hLineColor'] = function(i) { return '#aaa'; };
            objLayout['vLineColor'] = function(i) { return '#aaa'; };
            objLayout['paddingLeft'] = function(i) { return 8; };
            objLayout['paddingRight'] = function(i) { return 8; };
            doc.content[1].layout = objLayout;

            // Optional: reduce font size for better fit
            doc.defaultStyle.fontSize = 10;
        } 
    },
    {
        extend: 'print',
            title: 'Registration Request Report',
        exportOptions: 
        {
            columns: [1, 2, 3, 4]
        },
        action: function(e, dt, button, config) 
        { 
            Swal.fire({
            icon: "warning",
            title: "Are you sure?",
            text: "Do you want to print this table?",
            showCancelButton: true,
            confirmButtonText: "Yes, Print",
            cancelButtonText: "Cancel",
            customClass: 
            {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            didOpen: () => Swal.getConfirmButton().focus()
            }).then((result) => 
            {
                if(result.isConfirmed)
                {
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                }
            });
        },
        customize: function(win) 
        {

            // Add CSS for borders
            $(win.document.body).find('table')
                .css('border-collapse', 'collapse')
                .css('width', '100%');

            $(win.document.body).find('table th, table td')
                .css('border', '1px solid black')
                .css('padding', '8px');

            // Optional: center title
            $(win.document.body).find('h1')
                .css('text-align', 'center');
        }
    }
    ];
    <?php } else { ?>
    var buttonsConfig = [];
    <?php } ?>
 
    var table = $('#example2').DataTable({
    dom: '<"dt-top"lBf>rtip',
    lengthChange: true,
    pageLength: 10,
    buttons: buttonsConfig

    });
   

 $(document).ready(function() 
 {

    // ===== Approve button click =====
    $(document).on("click", ".approved-btn", function() {
        const row = $(this).closest("tr");
        const requestId = $(this).data("id");
        const flag = parseInt($(this).data("flag"));

        if(flag === 1) {
            Swal.fire({ icon: "warning", title: "Not Allowed", text: "Request already accepted" });
            return;
        }

        // Prefill modal from table row
     $("#modalRequestId").val(requestId);
    $("#emp_id").val(row.find(".emp_id").text().trim());
    // $("#empName").val(...);  // optional, comment out
    // $("#companyName").val(...);  // optional
    // $("#departmentName").val(...);  // optional
    // $("#foodName").val(...);  // optional

        $("#approveModal").modal("show");
    });

    // ===== Modal submit =====
    $("#emp_form").on("submit", function(e) 
    {
        e.preventDefault();

          // Only proceed if the form is valid
    if (!$(this).valid()) {
        return; // stop if validation failed
    }

        const empId = $("#emp_id").val().trim();
        const empName = $("#empName").val().trim();
        const companyId = $("#companyName").val();
        const departmentId = $("#departmentName").val();
        const foodTime = $("#foodTime").val();
        const requestId = $("#modalRequestId").val();

        // if (!empId || !empName || !companyId || !departmentId || !foodTime) {
        //     Swal.fire("Error", "Please fill all fields", "error");
        //     return;
        // } 

      $("#approveModal").modal("hide");

Swal.fire({
    icon: "warning",
    width: '480px',
    background: '#f8f9fa',
    showCancelButton: true,
    confirmButtonText: "Yes, Approve",
    cancelButtonText: "Cancel",
    customClass: {
        popup: 'custom-swal-popup',
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-secondary'
    },
    html: `
        <div class="swal-content-wrapper">

            <div class="swal-question">
                Are you sure?
            </div>

            <div class="swal-subtext">
                Do you want to approve this request?
            </div>

            <div class="swal-info-card">

                <div class="info-row">
                    <span class="label">Employee ID:</span>
                    <span class="value">${empId}</span>
                </div>

                <div class="info-row">
                    <span class="label">Employee Name:</span>
                    <span class="value">${empName}</span>
                </div>

                <div class="info-row">
                    <span class="label">Company Name:</span>
                    <span class="value">${$("#companyName option:selected").text()}</span>
                </div>

                <div class="info-row">
                    <span class="label">Department Name:</span>
                    <span class="value">${$("#departmentName option:selected").text()}</span>
                </div>

                <div class="info-row">
                    <span class="label">Food Time:</span>
                  <span class="value">
        ${foodTime == 1 ? 'One Time' : foodTime == 2 ? 'Two Times' : 'N/A'}
    </span>
                </div>

            </div>

        </div>
    `
}).then((result) => {

    if (result.isConfirmed) {

        Swal.fire({
            title: "Processing...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.post("api/approved_request.php", {
            id: requestId,
            emp_id: empId,
            emp_name: empName,
            company_id: companyId,
            department_id: departmentId,
            two_times_food_allowed: foodTime
        }, function (response) {

          if (response === "success") {

    table.row($(`.approved-btn[data-id='${requestId}']`).closest("tr")).remove().draw();

    // ✅ UPDATE COUNT HERE
    let countEl = $("#requestCount");
    let countText = $("#requestCountText");

    let currentCount = parseInt(countEl.text()) || 0;

    if (currentCount > 0) {
        let newCount = currentCount - 1;

        countEl.text(newCount);
        countText.text(newCount);

        if (newCount === 0) {
            countEl.hide();
        }
    }

    Swal.fire({
        icon: "success",
        title: "Approved!",
        timer: 1500,
        showConfirmButton: false
    });
}else {
                Swal.fire("Error", response, "error");
            }
        });

    } else {
        // ✅ THIS IS THE FIX
        $("#approveModal").modal("show");
    }
});
    });

});


    

  // ===== Delete button =====
  $(document).on("click", ".delete-btn", function() {
    const button = $(this);
    const requestId = button.data("id");
    const flag = parseInt(button.data("flag"));
    const row = button.closest("tr");

    if(flag === 1) {
      Swal.fire({ icon: "warning", title: "Not Allowed", text: "Request already accepted" });
      return;
    }

    Swal.fire({
        
      title: "Are you sure?",
      text: "you want to reject this request?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      confirmButtonText: "Yes, reject it!"
    }).then((result) => {
      if(result.isConfirmed) {
        Swal.fire({ title: "Deleting...", allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.post("api/delete_request.php", { id: requestId }, function(response) {
          response = response.trim();
        if(response === "success") {
    table.row(row).remove().draw();

    // ✅ UPDATE COUNT HERE
    let countEl = $("#requestCount");
    let countText = $("#requestCountText");

    let currentCount = parseInt(countEl.text()) || 0;

    if (currentCount > 0) {
        let newCount = currentCount - 1;

        countEl.text(newCount);
        countText.text(newCount);

        if (newCount === 0) {
            countEl.hide();
        }
    }

    Swal.fire({ 
        icon: "success", 
        title: "Rejected!", 
        timer: 1000, 
        showConfirmButton: false 
    });
}else {
            Swal.fire("Error", response, "error");
          }
        });
      }
    });
  });

    });
</script>
<script src="assets/js/app.js"></script>
</body>
</html>