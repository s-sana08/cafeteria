<?php
session_start();

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
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="assets/sass/dark-theme.css">
    <link rel="stylesheet" href="assets/sass/semi-dark.css">
    <link rel="stylesheet" href="assets/sass/bordered-theme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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

    /* Dropdown Value black when validation start */
    #frmvendor select.error {
        color: black !important;
        border-color: red;
    }

    #frmvendor select option[value=""] {
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

    html {
        scroll-behavior: smooth;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 30px;
        /* track width */
        height: 16px;
        /* track height */
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
        background-color: #FF0000;
        ;
        /* inactive color */
        transition: 0.4s;
        border-radius: 16px;
        /* half of track height for full round */
    }

    /* The circle */
    .slider:before {
        position: absolute;
        content: "";
        height: 12px;
        /* smaller circle */
        width: 12px;
        /* smaller circle */
        left: 2px;
        /* small padding inside track */
        bottom: 2px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    /* When checkbox is checked */
    input:checked+.slider {
        background-color: #4CAF50;
        /* green when active */
    }

    /* Move the circle to right when checked */
    input:checked+.slider:before {
        transform: translateX(14px);
        /* track width - circle width - padding */
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 16px;
    }

    .slider.round:before {
        border-radius: 50%;
    }


    /* Reserve enough width for the longest password */
    .fixed-pass {
        display: inline-block;
        width: 120px;
        /* set according to your max password length */
        overflow: hidden;
        text-overflow: ellipsis;
        /* hides extra chars if too long */
        white-space: nowrap;
    }

    .toggle-icon {
        margin-left: 8px;
        /* static space between text and icon */
        cursor: pointer;
        font-size: 18px;
        color: #495057;
        vertical-align: middle;
        transition: color 0.2s;
    }

    .toggle-icon:hover {
        color: #0d6efd;
    }

    .dim-row td:not(.switch-col) {
        color: #999;
        background-color: #f5f5f5;
    }

    .dim-row td:not(.switch-col) i {
        opacity: 0.5;
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
                                <li class="breadcrumb-item"><a href="javascript:;"><a href="index.php" target="_blank" rel="noopener noreferrer"><i class="bx bx-home-alt"></i></a></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"> <em>Add Vendor</em></li>
                            </ol>
                        </nav>
                    </div>

                </div>
                <!--end breadcrumb-->



                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0 text-uppercase">Add Vendor</h5>
                            </div>
                            <div class="card-body p-4">
                                <form id="frmvendor">
                                    <div class="row mb-3">
                                        <label for="txtvendorname" class="col-sm-3 col-form-label">Vendor Name<font color="red">*</font></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="idvnd" name="idvnd" hidden>
                                            <input type="text" class="form-control" id="txtvendorname" name="txtvendorname" maxlength="20" placeholder="Enter Vendor Name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="txtvendorusername" class="col-sm-3 col-form-label">Vendor Username<font color="red">*</font></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txtvendorusername" name="txtvendorusername" maxlength="20" placeholder="Enter Vendor Username">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Vendor Password<font color="red">*</font></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="password" id="txtvendorpassword" name="txtvendorpassword" class="form-control" placeholder="Enter Vendor Password">
                                                <span class="input-group-text cursor-pointer" id="togglePassword" style="user-select:none;"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="vendoremailid" class="col-sm-3 col-form-label">Vendor Email ID<font color="red">*</font> </label>

                                        <div class="col-md-9" >
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <input type="email" class="form-control" id="vendoremailid" name="vendoremailid" placeholder="Enter Email" style="max-width: 250px;">
                                                <button type="button" id="otpBtn" class="btn btn-primary" onclick="sendOTP()">Send OTP</button>
                                                <span id="timer" style="font-weight:bold; color:red;"></span>
                                            </div>
                                        </div>
                                    </div>


                               <div class="row mb-3 d-none" id="divid">
    <label class="col-sm-3 col-form-label">
        <!-- label removed intentionally -->
    </label>

    <div class="col-md-9">

        <div class="d-flex align-items-center gap-2">

            <!-- OTP Input (same position kept) -->
            <input type="text"
                   class="form-control"
                   id="otp"
                   name="otp"
                   placeholder="Enter OTP"
                   style="max-width:250px;">

            <!-- Verify Button -->
            <button type="button" id="verifyBtn" class="btn btn-success" onclick="verifyOTP()">
                Verify OTP
            </button>

        </div>

        <!-- Error message -->
        <div id="otpError" class="text-danger mt-1" style="display:none;"></div>

    </div>
</div>

                                    
                                    <div class="row mb-3">
                                        <label for="txtfoodtype" class="col-sm-3 col-form-label">Food Type<font color="red">*</font></label>
                                        <div class="col-md-9">
                                            <select class="form-select" id="txtfoodtype" name="txtfoodtype">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-md-9">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4" id="btnsubmit" name="submit">Add Vendor</button>
                                                <button type="button" class="btn btn-primary px-4" id="btnreset"  onclick="EmployeeApp.resetForm();" name="resetbtn">Reset</button>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 mx-auto"></div> -->
                </div>

                <!--end row-->
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0 text-uppercase">Vendor List</h5>
                            </div>
                            <div class="card-body p-4">


                                <div id="rsttbl" style="
    overflow-x: auto;">
                                    <table id="example2" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Vendor Name</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Email ID</th>
                                                <th>Food Type</th>
                                                <th>Date & Time</th>
                                                <th>Edit</th>
                                                <th style="opacity: 1 !important;">Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- rows will be injected here -->
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>



<script>
let countdown;
let timeLeft = 60;

$(document).ready(function () {
    document.getElementById("divid").classList.add("d-none");
});

// ======================
// SEND OTP
// ======================
function sendOTP() {

    if (countdown) clearInterval(countdown);

    let email = document.getElementById("vendoremailid").value;

    if (email === "") {
        Swal.fire("Enter email first");
        return;
    }

    fetch("api/send_otp.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "email=" + encodeURIComponent(email)
    })
    .then(res => res.text())   // TEMP DEBUG (IMPORTANT)
    .then(data => {

        console.log("RAW RESPONSE:", data); // 🔥 check in console

        let res = JSON.parse(data);

        if (res.status === "exists") {

            Swal.fire({
                icon: "error",
                title: "Email Exists",
                text: res.message
            });

            document.getElementById("divid").classList.add("d-none");
            document.getElementById("otpBtn").disabled = false;
            return;
        }

        if (res.status === "success") {

            Swal.fire({
                icon: "success",
                title: "OTP Sent",
                text: res.message
            });

            document.getElementById("divid").classList.remove("d-none");

            startTimer();
            document.getElementById("otpBtn").disabled = true;
        }

        if (res.status === "error") {
            Swal.fire("Error", res.message, "error");
        }
    })
    .catch(err => {
        console.log(err);
        Swal.fire("Error", "AJAX failed", "error");
    });
}
// ======================
// TIMER (FIXED)
// ======================
function startTimer() {

    let timerDisplay = document.getElementById("timer");
    let button = document.getElementById("otpBtn");

    clearInterval(countdown);

    timeLeft = 60;

    countdown = setInterval(() => {

        if (timerDisplay) {
            timerDisplay.innerHTML = "OTP expires in " + timeLeft + " sec";
        }

        timeLeft--;

        if (timeLeft < 0) {

            clearInterval(countdown);

            if (timerDisplay) {
                timerDisplay.innerHTML = "OTP expired ⏰";
            }

            button.disabled = false;
            button.innerHTML = "Resend OTP";
        }

    }, 1000);
}

// ======================
// VERIFY OTP (UNCHANGED BUT SAFE)
// ======================
function verifyOTP() {

    let email = document.getElementById("vendoremailid").value;
    let otp = document.getElementById("otp").value;

    let error = document.getElementById("otpError");

    if (otp === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Missing OTP',
            text: 'Please enter OTP'
        });
        return;
    }

    fetch("api/verify_otp.php", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "email=" + encodeURIComponent(email) + "&otp=" + otp
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === "success") {

            clearInterval(countdown);
            document.getElementById("timer").innerHTML = "";

            let btn = document.getElementById("otpBtn");
            btn.innerHTML = "✔ Verified";
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-success");
            btn.disabled = true;

            document.getElementById("otp").style.display = "none";
            document.getElementById("verifyBtn").style.display = "none";

            // document.getElementById("vendoremailid").readOnly = true;

            Swal.fire({
                icon: 'success',
                title: 'Verified!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
        }

        else if (data.status === "expired") {
            Swal.fire("Expired", data.message, "warning");
        }

        else if (data.status === "invalid") {
            Swal.fire("Invalid OTP", data.message, "error");
        }

        else {
            Swal.fire("Error", data.message, "error");
        }
    });
}
</script>
    <script>

function resetOTPUI() {

    // Reset button
    let btn = document.getElementById("otpBtn");
    if (btn) {
        btn.innerHTML = "Send OTP";
        btn.classList.remove("btn-success");
        btn.classList.add("btn-primary");
        btn.disabled = false;
    }

    // Show OTP input
    let otpInput = document.getElementById("otp");
    if (otpInput) {
        otpInput.style.display = "block";
        otpInput.value = "";
    }

    // Show verify button
    let verifyBtn = document.getElementById("verifyBtn");
    if (verifyBtn) {
        verifyBtn.style.display = "inline-block";
    }

    // Clear timer
    let timer = document.getElementById("timer");
    if (timer) timer.innerHTML = "";

    // Stop countdown
    if (typeof countdown !== "undefined") {
        clearInterval(countdown);
    }

    // Unlock email field
    let emailField = document.getElementById("vendoremailid");
    if (emailField) emailField.readOnly = false;

    // Clear OTP error
    let error = document.getElementById("otpError");
    if (error) {
        error.style.display = "none";
        error.innerHTML = "";
    }
}
        class EmployeeManager {
            constructor() {
                this.init();
            }

            init() {
                this.cacheElements();
                this.bindEvents();
                this.loadDropdowns();
                this.showData();
                $('#txtvendorname').focus();
            }

            cacheElements() {
                this.$form = $('#frmvendor');
                this.$vndName = $('#txtvendorname');
                this.$vndUsernm = $('#txtvendorusername');
                this.$vndPass = $('#txtvendorpassword');
                this.$vndEmail = $('#vendoremailid');
                this.$vndFood = $('#txtfoodtype');
                this.$btnSubmit = $('#btnsubmit');
                this.$table = $('#example2');
            }

            bindEvents() {
                // Remove previous submit handlers to prevent double trigger
                this.$form.off('submit').on('submit', (e) => this.handleSubmit(e));
            }

            handleSubmit(e) {
                e.preventDefault();

                if (!this.$form.valid()) return;

                const data = {
                    flag: 'insert',
                    id: $('#idvnd').val(),
                    vndname: this.$vndName.val(),
                    vndusernm: this.$vndUsernm.val(),
                    vndpass: this.$vndPass.val(),
                    vndemail: this.$vndEmail.val(),
                    vndfood: this.$vndFood.val()
                };

                // Update mode: only submit if any change occurred
                if (data.id) {
                    const changed = data.vndname !== this.originalData.vndname ||
                        data.vndusernm !== this.originalData.vndusernm ||
                        data.vndpass !== this.originalData.vndpass ||
                        data.vndemail !== this.originalData.vndemail ||
                        data.vndfood !== this.originalData.vndfood;
                    if (!changed) {
                        Swal.fire({
                            icon: "info",
                            title: "No changes detected",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        return;
                    }
                }

               
                Swal.fire({
    icon: "warning",
    width: '480px',
    showCancelButton: true,
    confirmButtonText: "Yes, Proceed",
    cancelButtonText: "Cancel",
    background: '#f8f9fa',
    customClass: {
        popup: 'custom-swal-popup',
        confirmButton: 'btn btn-primary',   // ✅ Bootstrap class
        cancelButton: 'btn btn-secondary'   // optional
    },
                    html: `
        <div class="swal-content-wrapper">

            <div class="swal-question">
                Are you sure?
            </div>

            <div class="swal-subtext">
                ${data.id ? "Do you want to update this vendor?" : "Do you want to add this vendor?"}
            </div>

            <div class="swal-info-card">
                <div class="info-row">
        <span class="label">Vendor Name:</span>
        <span class="value">${data.vndname}</span>
    </div>
    <div class="info-row">
        <span class="label">Username:</span>
        <span class="value">${data.vndusernm}</span>
    </div>
    <div class="info-row">
        <span class="label">Email:</span>
        <span class="value">${data.vndemail}</span>
    </div>
    <div class="info-row">
        <span class="label">Food Type:</span>
        <span class="value">${$('#txtfoodtype option:selected').text()}</span>
    </div>
            </div>

        </div>
    `
                }).then((result) => {







                    if (result.isConfirmed) {

                        // Loading popup
                        Swal.fire({
                            title: "Processing...",
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        $.post('api/add_vendor_operations.php', data, (response) => {
                            let res;
                            try {
                                res = JSON.parse(response);
                            } catch (err) {
                                Swal.fire("Error", "Server error", "error");
                                return;
                            }

                            // Success / error messages
                            if (res.status === "inserted") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: "Vendor added successfully",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else if (res.status === "updated") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Updated",
                                    text: "Vendor updated successfully",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire("Failed", res.message || "Operation failed", "error");
                            }

                           this.showData();
                            this.resetForm();
                            resetOTPUI(); // ✅ ADD THIS LINE
                        });
                    }
                });
            }

            showInEditor(id) {
                this.$btnSubmit.html("Update Vendor");
                $('#idvnd').val(id);

                this.$vndName.val($(`#tempvndnm${id}`).html());
                this.$vndUsernm.val($(`#tempvndusernm${id}`).html());
                // this.$vndPass.val($(`#tempvndpass${id}`).html());
                this.$vndPass.val($(`#pass_${id}`).attr('data-pass'));
                this.$vndEmail.val($(`#tempvndemail${id}`).html());
                this.$vndFood.val($(`#tempfoodname${id}`).data('foodid'));

                this.originalData = {
                    vndname: this.$vndName.val(),
                    vndusernm: this.$vndUsernm.val(),
                    vndpass: this.$vndPass.val(),
                    vndemail: this.$vndEmail.val(),
                    vndfood: this.$vndFood.val()
                };

                this.$btnSubmit.prop('disabled', true);

                this.$vndName.add(this.$vndUsernm).add(this.$vndPass).add(this.$vndEmail).add(this.$vndFood)
                    .off('input change').on('input change', () => {
                        const changed = this.$vndName.val() !== this.originalData.vndname ||
                            this.$vndUsernm.val() !== this.originalData.vndusernm ||
                            this.$vndPass.val() !== this.originalData.vndpass ||
                            this.$vndEmail.val() !== this.originalData.vndemail ||
                            this.$vndFood.val() !== this.originalData.vndfood;
                        this.$btnSubmit.prop('disabled', !changed);
                    });

                $('html, body').animate({
                    scrollTop: $('#frmvendor').offset().top - 200
                }, 300);
            }

           resetForm() {
    $('#idvnd').val('');
    this.$vndName.val('');
    this.$vndUsernm.val('');
    this.$vndPass.val('');
    this.$vndEmail.val('');
    this.$vndFood.val('');

    this.$btnSubmit.html("Add Vendor").prop('disabled', false);

    // ✅ RESET OTP UI
    resetOTPUI();

    // ✅ HIDE OTP DIV
    document.getElementById("divid").classList.add("d-none");
}

            loadDropdowns() {
                $.post('api/add_vendor_operations.php', {
                    flag: 'fetch_dropdowns'
                }, (response) => {
                    const data = JSON.parse(response);
                    let html = '<option value="">Select Food Type</option>';
                    data.food_type_master.forEach(f => {
                        html += `<option value="${f.id}">${f.food_type_name}</option>`;
                    });
                    this.$vndFood.html(html);
                });
            }

           

            // Avoid redirect 1st page 
            showData() {
                let currentPage = 0;
                if ($.fn.DataTable.isDataTable(this.$table)) {
                    currentPage = this.$table.DataTable().page();
                }

                $.post('api/add_vendor_operations.php', {
                    flag: 'showdata'
                }, (response) => {

                    if ($.fn.DataTable.isDataTable(this.$table)) {
                        this.$table.DataTable().clear().destroy();
                    }

                    this.$table.find('tbody').html(response);

                    const table = this.$table.DataTable({
                        dom: '<"dt-top"lBf>rtip', // 👈 THIS FIXES IT
                        lengthChange: true,
                        pageLength: 10,
                        buttons: [{
                                extend: 'excel',
                                title: 'Vendor List',
                                exportOptions: {
                                    columns: [0, 1, 2, 4, 5,6],
                                     rows: function(idx, data, node) 
                                        {
                                            return $(node).find('.status-toggle').is(':checked');
                                        } 
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
                                title: 'Vendor List',
                                exportOptions: {
                                    columns: [0, 1, 2, 4, 5,6],
                                     rows: function(idx, data, node) 
                            {
                                return $(node).find('.status-toggle').is(':checked');
                            }
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
                            }).then((result) => 
                            {
                                if(result.isConfirmed)
                                {
                                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                                }
                            });
                        },
                                customize: function(doc) {

                                    // Get the table
                                    var objLayout = {};

                                    // Add borders
                                    objLayout['hLineWidth'] = function(i) {
                                        return 0.5;
                                    };
                                    objLayout['vLineWidth'] = function(i) {
                                        return 0.5;
                                    };
                                    objLayout['hLineColor'] = function(i) {
                                        return '#aaa';
                                    };
                                    objLayout['vLineColor'] = function(i) {
                                        return '#aaa';
                                    };
                                    objLayout['paddingLeft'] = function(i) {
                                        return 8;
                                    };
                                    objLayout['paddingRight'] = function(i) {
                                        return 8;
                                    };

                                    doc.content[1].layout = objLayout;
                                }

                            },

                            {
                                extend: 'print',
                                title: 'Vendor List',
                                exportOptions: {
                                    columns: [0, 1, 2, 4, 5,6],
                                     rows: function(idx, data, node) 
                            {
                                return $(node).find('.status-toggle').is(':checked');
                            }
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
                                customClass: {
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
                                customize: function(win) {

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
                        ]
                    });

                    table.buttons().container()
                        .appendTo('#example2_wrapper .col-md-6:eq(0)');
                });
            }
        }

        $(document).ready(() => {
            window.EmployeeApp = new EmployeeManager();
        });

        function ShowInEditor(id) {
            window.EmployeeApp.showInEditor(id);
        }



        $(document).on('change', '.status-toggle', function() {
            const checkbox = $(this);
            const id = checkbox.data('id');
            const status = checkbox.is(':checked') ? 1 : 0;
            const actionText = status === 1 ? "activate" : "deactivate";

            // Confirmation before toggling
            Swal.fire({
                title: "Are you sure?",
                text: `Do you really want to ${actionText} this user?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then((result) => {

                if (result.isConfirmed) {

                    // Loading popup
                    Swal.fire({
                        title: "Processing...",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.post('api/add_vendor_operations.php', {
                        flag: 'toggle_status',
                        id: id,
                        status: status
                    }, (response) => {
                        let res;
                        try {
                            res = JSON.parse(response);
                        } catch (err) {
                            console.error("Invalid JSON response:", response);
                            Swal.fire("Error", "Server error", "error");
                            checkbox.prop('checked', !status); // revert checkbox
                            return;
                        }

                        if (res.status === 'success') {
                            Swal.fire({
                                icon: status === 1 ? "success" : "warning",
                                title: status === 1 ? "Activated!" : "Deactivated!",
                                text: status === 1 ? "User activation successful." : "User deactivation successful.",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            window.EmployeeApp.resetForm();
                            window.EmployeeApp.showData();

                        } else {
                            Swal.fire("Failed", res.message || "Failed to update status", "error");
                            checkbox.prop('checked', !status); // revert checkbox
                        }
                    });

                } else {
                    // User cancelled → revert checkbox
                    checkbox.prop('checked', !status);
                }
            });
        });


        $(document).ready(function() {
            $('#togglePassword').on('click', function() {
                const passwordField = $('#txtvendorpassword');
                const icon = $(this).find('i'); // target the <i> inside button

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('bx-hide').addClass('bx-show');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('bx-show').addClass('bx-hide');
                }
            });
        });
    </script>
    <script>
        let currentlyVisibleId = null;

        function togglePassword(id) {
            const passSpan = document.getElementById("pass_" + id);
            const icon = passSpan.nextElementSibling;

            // 👉 Hide previously opened password
            if (currentlyVisibleId !== null && currentlyVisibleId !== id) {
                const prevSpan = document.getElementById("pass_" + currentlyVisibleId);
                const prevIcon = prevSpan.nextElementSibling;

                // prevSpan.innerText = "••••••";
                prevSpan.innerText = "******";
                prevIcon.classList.remove("bx-hide");
                prevIcon.classList.add("bx-show");
            }

            // 👉 Toggle current one
            if (passSpan.innerText === "******") {
                passSpan.innerText = passSpan.getAttribute("data-pass");
                icon.classList.remove("bx-show");
                icon.classList.add("bx-hide");
                currentlyVisibleId = id;
            } else {
                passSpan.innerText = "******";
                icon.classList.remove("bx-hide");
                icon.classList.add("bx-show");
                currentlyVisibleId = null;
            }
        }
    </script>
    <!--app JS-->
    <script src="assets/js/app.js"></script>
</body>

</html>