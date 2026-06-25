<?php
session_start();

// Ensure employee/vendor is logged in
if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php");
    exit;
}

include_once('api/config.php'); 

$requests = [];
if ($conn) {

    $vnd_name = $_SESSION['name'];
    // $res = $conn->query("SELECT * FROM employee_request ORDER BY id DESC");
        $res = $conn->query("SELECT * FROM employee_request WHERE vnd_name = '$vnd_name' ORDER BY flag ASC, id DESC");

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $requests[] = $row;
        }
    }
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
	<link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS --> 
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

	<link href="assets/sass/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link rel="stylesheet" href="assets/sass/semi-dark.css">
	<link rel="stylesheet" href="assets/sass/bordered-theme.css">
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<title>Cafeteria | Management System</title>
</head>

<body>
<div class="wrapper">
    <?php include("api/sidebar.php"); ?>
    <?php include("api/header.php"); ?>

    <div class="page-wrapper">
        <div class="page-content container-xxl">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show All Requests</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <h6 class="mb-0 text-uppercase">Show All Requests</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="display:none;">Flag</th>
                                    <th>Sr. No.</th>
                                    <th>Vendor Name</th>
                                    <th>Employee ID</th>
                                    <th>Request Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($requests) > 0): ?>
                                    <?php foreach($requests as $req): ?>
                                        <tr>
                                              <td style="display:none;"><?php echo $req['flag']; ?></td>
                                            <td><?php echo $req['id']; ?></td>
                                            <td><?php echo htmlspecialchars($req['vnd_name']); ?></td>
                                            <td><?php echo htmlspecialchars($req['emp_id']); ?></td>
                                            <td><?php echo date('d-m-Y h:i A', strtotime($req['created_at'])); ?></td>
											<!-- <td id="status-<?php echo $req['id']; ?>">
												<?php 
													echo ($req['flag'] == 0) 
														? "<span class='badge bg-warning'>Pending</span>" 
														: "<span class='badge bg-success'>Processed</span>"; 
												?>
											</td> -->

                                            <td id="status-<?php echo $req['id']; ?>">
                                                <?php 
                                                    if($req['status'] == 0) {
                                                        echo "<span class='badge bg-danger'>Rejected</span>";
                                                    } else {
                                                        echo ($req['flag'] == 0) 
                                                            ? "<span class='badge bg-warning'>Pending</span>" 
                                                            : "<span class='badge bg-success'>Processed</span>"; 
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No requests found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="overlay toggle-icon"></div>
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <?php include("api/footer.php"); ?>
</div>

<!-- JS Plugins -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
        });
        table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });


</script>
<script src="assets/js/app.js"></script>
</body>
</html>