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


    <style>
        @media (max-width: 1440px) {
            .container-col-2 {
                padding: 3rem 4rem;
            }
            .ondirect-logo{
                width: 320px;
            }
        }

        @media (max-width: 1024px) {

            .container-col-2 {
                padding: 2rem 3rem;
            }

            .ondirect-logo {
                width: 270px;
            }

        }

        @media (max-width: 768px) {

            .ondirect-logo {
                width: 235px;
            }

            .container-col-2 {
                padding: 2rem 2rem;
            }



        }

        @media (max-width: 767px) {

            .container-col-2 {

                width: 95%;
                margin: 0 1rem;
            }

            .ondirect-logo {
                width: 100px;
                margin-bottom: 1rem;
            }

            .container-row-1 {
                justify-content: center;
            }

        }


        @media (max-width: 320px) {

            .container-col-2 {
                margin: 0 1rem;
            }

            .ondirect-logo {
                width: 80px;
                margin-bottom: 1rem;
            }

            .container-col-2 {
                padding: 1.5rem 1rem;
            }

            .container-row-1 {
                justify-content: center;
            }

        }
    </style>


</head>

<body class="body-img">

    <div class="wrapper">


        <div class="container-fluid container-1 d-flex flex-column justify-content-center ">
            <div class="row container-row-1  ">
                <div class="col-12 col-md-6  container-col-1  d-flex flex-column justify-content-center ">
                    <div class="text-center">
    <!-- <img src="assets/images/ss_logo.png" class="logo-light ondirect-logo"> -->
    <img src="assets/images/logo_white.png" class="logo-dark ondirect-logo">
</div>
                </div>
                <div class="col-12  col-md-6  container-col-2 d-flex flex-column justify-content-center ">
                    <div>
                        <h2 class="mb-4 " style="letter-spacing: 0.8px;line-height: 1.5;font-weight:500;">Welcome! <br>Login to continue</h2>

                        <form class="row" id="loginform">
                            <div class="mb-5">
                                <input type="text" class="form-control underline-input" id="username" aria-describedby="emailHelp" placeholder="USERNAME*">
                                <span id="usernameError" class="error-text" style="display:none;color:red;"></span>
                            </div>
                            <div class="mb-5">
                                <div class="position-relative"> <input type="password" name="password" class="form-control underline-input" id="userpassword" placeholder="PASSWORD*"> <span class="position-absolute end-0 top-50 translate-middle-y me-0"> <a href="javascript:;" class="input-group-text bg-transparent border-0 pe-0"> <i class='bx bx-hide hide-icon'></i> </a> </span> </div> <span id="passwordError" class="error-text" style="display:none;color:red;"></span>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-gradient-red">LOGIN</button>
                            </div>
                        </form>
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
        $(document).ready(function() {

            /* PASSWORD SHOW HIDE */

            $("#show_hide_password a").on('click', function(event) {

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
            $("#loginform").submit(function(e) {

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
                    $("#usernameError").text("This field is required.").show();
                    $("#username").addClass("error");
                    hasError = true;
                }

                if (password === "") {
                    $("#passwordError").text("This field is required.").show();
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

                    success: function(response) {

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

                            setTimeout(function() {
                                window.location.href = "index.php";
                            }, 1200);

                        } else {

                            // ❌ Show inline error under inputs
                            if (response.field === "username") {
                                $("#usernameError").text(response.message).show();
                                $("#username").addClass("error");
                            } else if (response.field === "password") {
                                $("#passwordError").text(response.message).show();
                                $("#userpassword").addClass("error");
                            } else {
                                // fallback (e.g. wrong credentials)
                                $("#passwordError").text(response.message).show();
                                // $("#userpassword").addClass("error");
                            }

                        }

                    },

                    error: function(xhr) {
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector(".input-group-text");
    const passwordInput = document.getElementById("userpassword");
    const icon = document.querySelector(".hide-icon");

    toggleBtn.addEventListener("click", function (e) {
        e.preventDefault();

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("bx-hide");
            icon.classList.add("bx-show");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("bx-show");
            icon.classList.add("bx-hide");
        }
    });
});
</script>
    <script src="assets/js/app.js"></script>

</body>

</html>