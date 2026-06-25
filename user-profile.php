<?php
session_start();

$name = $_SESSION['name'] ?? '';
$email = $_SESSION['email_id'] ?? '';
$username = $_SESSION['username'] ?? '';

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
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	
	<link href="assets/sass/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
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
								<li class="breadcrumb-item active" aria-current="page"><em>User Profile</em></li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-4  d-flex">
								<div class="card card w-100">
									<div class="card-body">
										<div class="d-flex flex-column align-items-center text-center">
											<img src="assets/images/dark.png" alt="Admin" class="rounded-circle p-1 " width="160">
											<div class="mt-3">
												<h5 id="profileName"><?php echo $_SESSION['name']; ?></h5>
												<h6><?php echo $_SESSION['email_id']; ?></h6>
											</div>
										</div>
										
									</div>
								</div>
							</div>
<div class="col-lg-7 d-flex">
<div class="card w-100">
    
    <div class="card-header text-center">
        <h5 class="mb-0"><b>Profile</b></h5>
    </div>

    <div class="card-body">
            <form action="" method="post" id="profileForm">

                <div class="row mb-3">
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" id="user_id" value="<?php echo $_SESSION['id']; ?>" hidden />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Full Name<font color="red">*</font></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" />
						<span id="nameError" class="text-danger" style="font-size:12px;"></span>
                    </div>
					
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email Id<font color="red">*</font></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo $_SESSION['email_id']; ?>" />
						<span id="email_idError" class="text-danger" style="font-size:12px;"></span>
                    </div>
					
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Username<font color="red">*</font></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" id="username" name="username"  value="<?php echo $_SESSION['username']; ?>" />
						<span id="usernameError" class="text-danger" style="font-size:12px;"></span>
                    </div>
					
                </div>

                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="button" class="btn btn-primary px-4" id="saveProfileBtn" value="Save Changes" />
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
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="assets/js/index2.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>

<script>
$(document).ready(function() {

    // Disable button initially
    $('#saveProfileBtn').prop('disabled', true);

    // Enable when user changes input
    $('#name, #email_id, #username').on('input', function() {
        $('#saveProfileBtn').prop('disabled', false);
    });

  $('#saveProfileBtn').click(function() {
    var id = $('#user_id').val();
    var name = $('#name').val().trim();
    var email_id = $('#email_id').val().trim();
    var username = $('#username').val().trim();

    // Initialize validation flag
    var isValid = true;

    // Name validation
    if(name === "") {
        $('#nameError').text("Please enter your name.");
        $('#name').addClass('error');
        isValid = false;
    } else {
        $('#nameError').text("");
        $('#name').removeClass('error');
    }  

    // Email validation
    if(email_id === "") {
        $('#email_idError').text("Please enter your email.");
        $('#email_id').addClass('error');
        isValid = false;
    } else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email_id)) {
        $('#email_idError').text("Please enter a valid email address.");
        $('#email_id').addClass('error');
        isValid = false;
    } else {
        $('#email_idError').text("");
        $('#email_id').removeClass('error');
    }

    // Username validation
    if(username === "") {
        $('#usernameError').text("Please enter your username.");
        $('#username').addClass('error');
        isValid = false;
    } else {
        $('#usernameError').text("");
        $('#username').removeClass('error');
    }

    // Stop if not valid
    if(!isValid) {
        return false;
    }

    // AJAX call
    $.ajax({
        url: 'api/user_update_profile.php',
        type: 'POST',
        data: { id: id, name: name, email_id: email_id, username: username },
        dataType: 'json',
        success: function(response) {
            if(response.status === 'success'){
                $('#profileName').text(name);

                Swal.fire({
                    icon: 'success',
                    title: 'Updated successfully',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#saveProfileBtn').prop('disabled', true);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
            });
        }
    });
});
});


</script>


</body>

</html>