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
#frmadmin select.error {
    color: black !important;
    border-color: red; 
}

#frmadmin select option[value=""] {
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
  background-color: #FF0000;; /* inactive color */
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


/* Reserve enough width for the longest password */
.fixed-pass {
    display: inline-block;
    width: 120px; /* set according to your max password length */
    overflow: hidden; 
    text-overflow: ellipsis; /* hides extra chars if too long */
    white-space: nowrap;
}

.toggle-icon {
    margin-left: 8px; /* static space between text and icon */
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
								<li class="breadcrumb-item"><a href="index.php" target="_blank" rel="noopener noreferrer"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"> <em>Add Admin</em></li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				
			

				<div class="row">
                    <div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header px-4 py-3">
								<h5 class="mb-0 text-uppercase">Add Admin</h5>
							</div>
							<div class="card-body p-4">
								<form id="frmadmin">
								
									<div class="row mb-3">
										<label for="txtadminname" class="col-sm-3 col-form-label">Admin Name<font color="red">*</font></label>
										<div class="col-md-9">
											<input type="text" class="form-control" id="idadmin" name="idadmin" hidden>
											<input type="text" class="form-control" id="txtadminname" name="txtadminname" maxlength="20" placeholder="Enter Admin Name">
										</div>
									</div>
									<div class="row mb-3">
										<label for="txtadminusername" class="col-sm-3 col-form-label">Admin Username<font color="red">*</font></label>
										<div class="col-md-9">
											<input type="text" class="form-control" id="txtadminusername" name="txtadminusername" maxlength="20" placeholder="Enter Admin Username">
										</div>
									</div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Admin Password<font color="red">*</font></label>
                                        <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="password" id="txtadminpassword" name="txtadminpassword" class="form-control" placeholder="Enter Admin Password">
                                            <span class="input-group-text cursor-pointer" id="togglePassword" style="user-select:none;"><i class="bx bx-hide"></i></span>
                                        </div>
                                        </div>
                                    </div>
									<div class="row mb-3">
										<label for="adminemailid" class="col-sm-3 col-form-label">Admin Email ID<font color="red">*</font></label>
										<div class="col-md-9">
											<input type="text" class="form-control" id="adminemailid" name="adminemailid" placeholder="Enter Admin Email ID">
										</div>
									</div>
									<!-- <div class="row mb-3">
										<label for="txtfoodtype" class="col-sm-3 col-form-label">Food Type<font color="red">*</font></label>
										<div class="col-md-9">
											<select class="form-select" id="txtfoodtype" name="txtfoodtype">
											  </select>
										</div>
									</div> -->
									<div class="row">
										<label class="col-sm-3 col-form-label"></label>
										<div class="col-md-9">
											<div class="d-md-flex d-grid align-items-center gap-3">
												<button type="submit" class="btn btn-primary px-4" id="btnsubmit" name="submit">Add Admin</button>
                                                <button type="button" class="btn btn-primary px-4" id="btnreset"  onclick="EmployeeApp.resetForm();" name="resetbtn">Reset</button>
												
											</div>
										</div>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
				
				<!--end row-->
	<div class="row">
			<div class="col-lg-12 mx-auto">
				<div class="card">
					<div class="card-header px-4 py-3">
						<h5 class="mb-0 text-uppercase">Admin List</h5>
					</div>
					<div class="card-body p-4">
						 
		
		<div id="rsttbl"style="
    overflow-x: auto;">
    <table id="example2" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Admin Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email ID</th>
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
		(function () {
			'use strict'

			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.querySelectorAll('.needs-validation')

			// Loop over them and prevent submission
			Array.prototype.slice.call(forms)
			.forEach(function (form) {
				form.addEventListener('submit', function (event) {
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
 
 class EmployeeManager {
    constructor() {
        this.init();
    }

    init() {
        this.cacheElements();
        this.bindEvents();
        this.showData();
        $('#txtadminname').focus();
    }

    cacheElements() {
        this.$form = $('#frmadmin');
        this.$vndName = $('#txtadminname');
        this.$vndUsernm = $('#txtadminusername');
        this.$vndPass = $('#txtadminpassword');
        this.$vndEmail = $('#adminemailid');
        // this.$vndFood = $('#txtfoodtype');
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
        id: $('#idadmin').val(),
        vndname: this.$vndName.val(),
        vndusernm: this.$vndUsernm.val(),
        vndpass: this.$vndPass.val(),
        vndemail: this.$vndEmail.val()
        // vndfood: this.$vndFood.val()
    };

    // Update mode: only submit if any change occurred
    if (data.id) {
        const changed = data.vndname !== this.originalData.vndname ||
                        data.vndusernm !== this.originalData.vndusernm ||
                        data.vndpass !== this.originalData.vndpass ||
                        data.vndemail !== this.originalData.vndemail;
                        // data.vndfood !== this.originalData.vndfood;
        if (!changed) {
            Swal.fire({
                icon: "info",
                title: "No changes detected",
                timer: 1500,
                showConfirmButton: false,
                 position: 'bottom-end'
            });
            return;
        }
    }

    // Confirmation before submitting
    Swal.fire({
        title: "Are you sure?",
        text: data.id ? "Do you want to update this admin?" : "Do you want to add this admin?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, proceed",
        cancelButtonText: "Cancel",
         position: 'bottom-end'
    }).then((result) => {

        if (result.isConfirmed) {

            // Loading popup
            Swal.fire({
                title: "Processing...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.post('api/admin_master_operations.php', data, (response) => {
                let res;
                try { res = JSON.parse(response); } 
                catch (err) { 
                    Swal.fire("Error", "Server error", "error");
                    return; 
                }

                // Success / error messages
                if (res.status === "inserted") {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Admin added successfully",
                        timer: 1500,
                        showConfirmButton: false,
                         position: 'bottom-end'
                    });
                } else if (res.status === "updated") {
                    Swal.fire({
                        icon: "success",
                        title: "Updated",
                        text: "Admin updated successfully",
                        timer: 1500,
                        showConfirmButton: false,
                         position: 'bottom-end'
                    });
                } else {
                    Swal.fire("Failed", res.message || "Operation failed", "error");
                }

                this.showData();
                this.resetForm();
            });
        }
    });
}

    showInEditor(id) {
        this.$btnSubmit.html("Update Admin");
        $('#idadmin').val(id);

        this.$vndName.val($(`#tempvndnm${id}`).html());
        this.$vndUsernm.val($(`#tempvndusernm${id}`).html());
        // this.$vndPass.val($(`#tempvndpass${id}`).html());
        this.$vndPass.val($(`#pass_${id}`).attr('data-pass'));
        this.$vndEmail.val($(`#tempvndemail${id}`).html());
        // this.$vndFood.val($(`#tempfoodname${id}`).data('foodid'));

        this.originalData = {
            vndname: this.$vndName.val(),
            vndusernm: this.$vndUsernm.val(),
            vndpass: this.$vndPass.val(),
            vndemail: this.$vndEmail.val()
            // vndfood: this.$vndFood.val()
        };

        this.$btnSubmit.prop('disabled', true);

        this.$vndName.add(this.$vndUsernm).add(this.$vndPass).add(this.$vndEmail)
            .off('input change').on('input change', () => {
                const changed = this.$vndName.val() !== this.originalData.vndname ||
                                this.$vndUsernm.val() !== this.originalData.vndusernm ||
                                this.$vndPass.val() !== this.originalData.vndpass ||
                                this.$vndEmail.val() !== this.originalData.vndemail;
                                // this.$vndFood.val() !== this.originalData.vndfood;
                this.$btnSubmit.prop('disabled', !changed);
            });

        $('html, body').animate({ scrollTop: $('#frmadmin').offset().top - 200 }, 300);
    }

    resetForm() {
        $('#idadmin').val('');
        this.$vndName.val('');
        this.$vndUsernm.val('');
        this.$vndPass.val('');
        this.$vndEmail.val('');
        // this.$vndFood.val('');
        this.$btnSubmit.html("Add Admin").prop('disabled', false);
    }

  

  
     showData() {
    let currentPage = 0;
    if ($.fn.DataTable.isDataTable(this.$table)) {
        currentPage = this.$table.DataTable().page();
    }

    $.post('api/admin_master_operations.php', { flag: 'showdata' }, (response) => {

        if ($.fn.DataTable.isDataTable(this.$table)) {
            this.$table.DataTable().clear().destroy();
        }

        this.$table.find('tbody').html(response);

        const table = this.$table.DataTable({
            dom: '<"dt-top"lBf>rtip',          // 👈 THIS FIXES IT
                lengthChange: true,
                pageLength: 10, 
                      buttons: [
                {
                    extend: 'excel',
                     title: 'Admin List',
                    exportOptions: {
                        columns: [0, 1, 2,4, 5] // ✅  only required columns
                    }
                },
                {
                    extend: 'pdf',
                     title: 'Admin List',
                    exportOptions: {
                        columns: [0, 1, 2,4, 5]
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
                     title: 'Admin List',
                    exportOptions: {
                        columns: [0, 1, 2,4, 5]
                    },
                 	customize: function (win) {

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

$(document).ready(() => { window.EmployeeApp = new EmployeeManager(); });
function ShowInEditor(id) { window.EmployeeApp.showInEditor(id); }



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
        cancelButtonText: "No",
         position: 'bottom-end'
    }).then((result) => {

        if (result.isConfirmed) {

            // Loading popup
            Swal.fire({
                title: "Processing...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.post('api/admin_master_operations.php', { flag: 'toggle_status', id: id, status: status }, (response) => {
                let res;
                try {
                    res = JSON.parse(response);
                } catch (err) {
                    console.error("Invalid JSON response:", response);
                    Swal.fire("Error", "Server error", "error");
                    checkbox.prop('checked', !status); // revert checkbox
                    return;
                }

                if(res.status === 'success') {
                    Swal.fire({
                        icon: status === 1 ? "success" : "warning",
                        title: status === 1 ? "Activated!" : "Deactivated!",
                        text: status === 1 ? "User activation successful." : "User deactivation successful.",
                        timer: 1500,
                        showConfirmButton: false,
                         position: 'bottom-end'
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

$(document).on('click', '.delete-btn', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "This record will be deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: 'api/admin_master_operations.php',
                type: 'POST',
                data: {
                    flag: 'deleteAdmin',
                    id: id
                },
                success: function (res) {
                    let response = JSON.parse(res);

                    if (response.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: "Deleted!",
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // remove row without reload (better UX)
                        $(`button[data-id='${id}']`).closest('tr').fadeOut();

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.message
                        });
                    }
                }
            });

        }
    });
});

$(document).ready(function() {
    $('#togglePassword').on('click', function() {
        const passwordField = $('#txtadminpassword');
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