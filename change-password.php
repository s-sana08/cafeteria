<?php
session_start();

$name = $_SESSION['name'] ?? '';
$email = $_SESSION['email_id'] ?? '';
$username = $_SESSION['username'] ?? '';
$password = $_SESSION['password'] ?? '';

if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php"); // your login page
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
	<link href="assets/css/pace.min.css" rel="stylesheet"/>    
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

	<!-- Alertify CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

<!-- Alertify JS -->
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>


	<title>Cafeteria | Management System</title>
</head>
<style>
/* html, body {
    height: 100%;
} */

.wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* .page-wrapper {
    flex: 1;
} */

.page-footer {
    margin-top: auto;
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
					<div class="breadcrumb-title pe-3">PROFILE</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"><em>Update Password</em></li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row d-flex flex-column align-items-center justify-content-center">
							
							<div class="col-lg-8">
								<div class="card">
									   <div class="card-header text-center">
        <h5 class="mb-0"><b>Update Password</b></h5>
    </div>
									<div class="card-body">
									<form id="passwordForm">
											<input type="hidden" id="user_id" value="<?php echo $_SESSION['id']; ?>">

										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Old Password<font color="red">*</font></h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="password" id="old_password" name="old_password" class="form-control" placeholder="enter old password">
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">New Password<font color="red">*</font></h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="password" id="new_password" name="new_password" class="form-control" placeholder="enter new password">
											</div>
										</div>
										
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Confirm Password<font color="red">*</font></h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="confirm new password">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9 text-secondary">
												<input type="button" class="btn btn-primary px-4" id="savePasswordBtn" value="Save Changes" />
											</div>
										</div>
									</form>
									</div>
								</div>
							
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
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
	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	
	<script src="assets/js/index2.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
<script src="assets/plugins/validation/jquery.validate.min.js"></script>
<script src="assets/plugins/validation/validation-script.js"></script>

<!-- <script>
$(document).ready(function() {
    $('#savePasswordBtn').click(function() {
        var user_id = $('#user_id').val();
        var old_password = $('#old_password').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();


        $.ajax({
            url: 'api/user_update_password.php',
            type: 'POST',
            data: { user_id: user_id, old_password: old_password, new_password: new_password },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success'){
                    alertify.success(response.message);
                    
                    $('#old_password, #new_password, #confirm_password').val('');
                } else {
                    alertify.error(response.message);
                }
            },
            error: function() {
                alertify.error('Something went wrong!');
            }
        });
    });
});
</script> -->

<script>
	$(document).ready(function () {

    $("#savePasswordBtn").click(function () {

        // check validation first
        if (!$("#passwordForm").valid()) {
            return false;
        }

        var formData = $("#passwordForm").serialize();

        $.ajax({
            url: "api/user_update_password.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {

    if (response.status === "success") {
        alertify.success(response.message);

        $("#passwordForm")[0].reset();

        // ✅ logout + redirect
        setTimeout(function () {
            window.location.replace("index.php");
        }, 1500);

    } else {
        alertify.error(response.message);
    }

},
            error: function () {
                alertify.error("Something went wrong");
            }
        });

    });

});


</script>


</body>

</html>