<?php
session_start();

if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
	header("Location: auth-login.php");
	exit;
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

				<div class="row">
					<div class="col-lg-12 mx-auto">

						<div class="card">
							<div class="card-header">
								<h5>Add Employee</h5>
							</div>

							<div class="card-body">

								<form id="frmmaster">

									<div class="row mb-3">

										<label class="col-sm-3 col-form-label" >Employee ID</label>

										<div class="col-sm-9">

											<input type="hidden" id="idemp">

											<input type="text"
												class="form-control"
												id="txtempid"
												placeholder="Enter Employee ID">

							

								<div id="msg" class="" style="margin-top:5px;"></div>
										</div>

									</div>

									<div class="row">
										<div class="col-sm-9 offset-sm-3">

											<button type="submit" class="btn btn-primary">
												Enter
											</button>

										</div>
									</div>

								</form>


							</div>
							
						</div>
					</div>
				</div>

				<br>

				<div class="row">
					<div class="col-lg-12 mx-auto">

						<div class="card">

							<div class="card-header">
								<h5>Employee List</h5>
							</div>

							<div class="card-body">

								<table id="example2" class="table table-striped table-bordered">

									<thead>
										<tr>
											<th>Sr.No</th>
											<th>Employee ID</th>
											<th>Employee Name</th>
											<th>Food Type</th>
											<th>Meal Time</th>
											<th>Date & Time</th>
										</tr>
									</thead>

									<tbody></tbody>

								</table>

							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

		<?php include("api/footer.php"); ?>

	</div>


		<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

	<script src="assets/js/index2.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>


	

	<script>
		$(document).ready(function() {

			$("#txtempid").focus();

			showdata();

		});


	$("#frmmaster").submit(function(e){

e.preventDefault();

var empid = $("#txtempid").val().trim();

if(empid == "")
{
    $("#msg").html("<span style='color:red;'>Please enter employee ID.</span>");
    $("#txtempid").focus();
    return false;
}

$.post(
'api/food_entry_operations.php',
{
flag:'insert',
empid:empid
},
function(data){

$("#msg").html(data);

showdata();

Refresh();

}
); 

}); 

		function showdata() {

			$.post(
				'api/food_entry_operations.php', {
					flag: 'showdata'
				},

				function(response) {

					$("#example2 tbody").html(response);

					if (!$.fn.DataTable.isDataTable('#example2')) {
						$('#example2').DataTable();
					}

				}

			);

		}


		function Refresh() {

			$("#txtempid").val("");

			$("#txtempid").focus();

		}
	</script>

</body>

</html>