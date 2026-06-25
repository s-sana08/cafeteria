<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="assets/images/ss_logo.png" type="image/png">

	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">

	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>

	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

	<link href="assets/sass/app.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link href="assets/css/icons.css" rel="stylesheet">

	<!-- ALERTIFY -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

	<title>Cafeteria | Management System</title>
</head>
<style>
	.error {
    border: 1px solid red;
}

.error-text {
    font-size: 13px;
}
</style>
<body>

	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">

				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">

						<div class="card mb-0">
							<div class="card-body">

								<div class="p-4">

									<div class="mb-3 text-center">
										<img src="assets/images/kings_logo_black.png" width="80" height="auto">
									</div>

									

									<div class="form-body">

										<form class="row g-3 mt-2" id="loginform">

											<div class="col-12">
												<label class="form-label col-form-label">Username<font color="red">*</font></label>
												<input type="text" class="form-control" id="username"
													placeholder="Enter Username">
													<span id="usernameError" class="error-text" style="display:none;color:red;"></span>
											</div>

											<div class="col-12">
												<label class="form-label col-form-label">Password<font color="red">*</font></label>

												<div class="input-group" id="show_hide_password">

													<input type="password" class="form-control border-end-0"
														id="userpassword" placeholder="Enter Password">

													<a href="javascript:;" class="input-group-text bg-transparent">
														<i class='bx bx-hide'></i>
													</a>

												</div>
												<span id="passwordError" class="error-text" style="display:none;color:red;"></span>
											</div>

											<!-- <div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox">
													<label class="form-check-label">Remember Me</label>
												</div>
											</div> -->

											<div class="col-12">
												<div class="d-grid mt-2">
													<button type="submit" class="btn btn-primary">Log in</button>
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
	</div>
	</div>

	<!-- JS -->

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/jquery.min.js"></script>

	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

	<!-- ALERTIFY -->
	<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>

		$(document).ready(function () {

			/* PASSWORD SHOW HIDE */

			$("#show_hide_password a").on('click', function (event) {

				event.preventDefault();

				if ($('#show_hide_password input').attr("type") == "text") {

					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");

				} else {

					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");

				}

			});


			/* LOGIN AJAX */
$("#loginform").submit(function (e) {

    e.preventDefault();

    // Clear old errors
    $("#usernameError").text("").hide();
    $("#passwordError").text("").hide();
    $("#username, #userpassword").removeClass("error");

    var username = $("#username").val().trim();
    var password = $("#userpassword").val().trim();

    let hasError = false;

    // 🔹 Frontend validation
    if (username === "") {
        $("#usernameError").text("Username is required").show();
        $("#username").addClass("error");
        hasError = true;
    }

    if (password === "") {
        $("#passwordError").text("Password is required").show();
        $("#userpassword").addClass("error");
        hasError = true;
    }

    if (hasError) return;

    var Object = {
        Flag: "login",
        username: username,
        password: password
    };

    $.ajax({
        url: "api/login-operations.php",
        type: "POST",
        data: JSON.stringify(Object),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        processData: false,

        success: function (response) {

            console.log(response);

            if (response.status === "success") {

                // ✅ Only success uses SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful',
                    text: response.message,
                    timer: 1200,
                    showConfirmButton: false
                });

                setTimeout(function () {
                    window.location.href = "index.php";
                }, 1200);

            } else {

                // ❌ Show inline error under inputs
                if (response.field === "username") {
                    $("#usernameError").text(response.message).show();
                    $("#username").addClass("error");
                } 
                else if (response.field === "password") {
                    $("#passwordError").text(response.message).show();
                    $("#userpassword").addClass("error");
                } 
                else {
                    // fallback (e.g. wrong credentials)
                    $("#passwordError").text(response.message).show();
                    // $("#userpassword").addClass("error");
                }

            }

        },

        error: function (xhr) {
            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Something went wrong. Please try again.'
            });
        }

    });

});
		});

	</script>

	<script src="assets/js/app.js"></script>

</body>

</html>