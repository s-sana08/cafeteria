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

    #employee_ids::placeholder {
  font-style: italic;
}


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
  background-color: #d33; /* inactive color */
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
								<li class="breadcrumb-item active" aria-current="page"><em>Deactivate Employees</em></li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				<div class="row">
                    <div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header px-4 py-3">
								<h5 class="mb-0 text-uppercase">Deactivate Employees</h5>
							</div>
							<div class="card-body p-4">
                                <form id="frmEmployee">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Enter Employee Id's<font color="red">*</font></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="employee_ids" name="employee_ids" rows="3" placeholder="e.g. 100101,100102,100103..."></textarea>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary px-4" id="btnsubmit">Inactive</button>
                                            <button type="button" class="btn btn-primary px-4"
                                                onclick="window.EmployeeApp.resetForm();">
                                                Reset
                                            </button>                                        
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
                                <h5 class="mb-0 text-uppercase">Deactivated Employees List</h5>
                            </div> 
                            <div class="card-body p-4" style="overflow-x: auto;">
                               <div id="rsttbl">
                                     <table id="example2"  class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Company Name</th>
                                            <th>Department Name</th>
                                            <th>Food Time</th>
                                            <th>Date & Time</th>
                                            <th>Action</th> 
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <!-- rows injected by JS -->
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
class EmployeeApp {
    constructor() {
        this.init();
    }

    init() {
        this.cacheElements();
        this.bindEvents();
        this.showData();
    }

    cacheElements() {
        this.$form = $('#frmEmployee');
        this.$employeeIds = $('#employee_ids');
        this.$table = $('#example2');
    }

    bindEvents() {
        this.$form.on('submit', (e) => this.handleSubmit(e));
    }



handleSubmit(e) {
    e.preventDefault();

    if (!this.$form.valid()) return;

    const ids = this.$employeeIds.val().trim();
    const validator = this.$form.validate();

    // First call (validation only)
    $.post('api/add_inactive_emp_operations.php', { 
        flag: 'inactive_employees',
        employee_ids: ids,
        confirm: 0
    }, (response) => {

        let res;
        try {
            res = JSON.parse(response);
        } catch (err) {
            Swal.fire("Error", "Server error", "error");
            return;
        }

        // ❌ Show validation errors FIRST
        if (res.not_exist && res.not_exist.length > 0) {
            validator.showErrors({
                "employee_ids": "These Employee IDs do not exist: " + res.not_exist.join(', ')
            });
            return;
        }

        if (res.already_inactive && res.already_inactive.length > 0) {
            validator.showErrors({
                "employee_ids": "Already Deactivated Employeess: " + res.already_inactive.join(', ')
            });
            return;
        }

        // ✅ Now confirmation
        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "Do you really want to mark these employees as inactive?",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonText: "Yes, proceed"
        // }).then((result) => {


          Swal.fire({
            icon: "warning",
            width: '480px',
            showCancelButton: true,
            confirmButtonText: "Yes, Proceed",
            cancelButtonText: "Cancel",
            background: '#f8f9fa',
            customClass: {
                popup: 'custom-swal-popup',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            html: `
                <div class="swal-content-wrapper">
                    <div class="swal-question">Are you sure?</div>
                    <div class="swal-subtext">Do you really want to mark these employees as inactive?</div>
                    <div class="swal-info-card">
                        <div class="info-row">
                            <span class="label">Employee IDs:</span>
                            <span class="value">${ids}</span>
                        </div>
                    </div>
                </div>
            `
        }).then((result) => {



            if (result.isConfirmed) {

                // Loading
                Swal.fire({
                    title: "Processing...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                // Final call
                $.post('api/add_inactive_emp_operations.php', { 
                    flag: 'inactive_employees',
                    employee_ids: ids,
                    confirm: 1
                }, (finalResponse) => {

                    let finalRes;
                    try {
                        finalRes = JSON.parse(finalResponse);
                    } catch (err) {
                        Swal.fire("Error", "Server error", "error");
                        return;
                    }

                    if (finalRes.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Employees set to inactive",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        this.$employeeIds.val('');
                        this.showData();
                    } else {
                        Swal.fire("Failed", finalRes.message || "Operation failed", "error");
                    }
                });
            }
        });
    });
}
    showData() {
        $.post('api/add_inactive_emp_operations.php', { flag: 'showdata' }, (response)=>{
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
            title: 'Deactivated Employees List',
            exportOptions: 
            {
                columns: [0, 1,2,3,4,5,6]
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
            title: 'Deactivated Employees List',
            exportOptions: 
            {
                columns: [0, 1,2,3,4,5,6]
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
            customize: function (doc) 
            {
			// Get the table
			var objLayout = {};
			
			// Add borders
			objLayout['hLineWidth'] = function(i) { return 0.5; };
			objLayout['vLineWidth'] = function(i) { return 0.5; };
			objLayout['hLineColor'] = function(i) { return '#aaa'; };
			objLayout['vLineColor'] = function(i) { return '#aaa'; };
			objLayout['paddingLeft'] = function(i) { return 8; };
			objLayout['paddingRight'] = function(i) { return 8; };

			doc.content[1].layout = objLayout;
		}
        },
        {
            extend: 'print',
            title: 'Deactivated Employees List',
            exportOptions: 
            {
                columns: [0, 1,2,3,4,5,6]
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
            customize: function (win) 
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
    ]
});
        table.buttons().container()
            .appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
}


resetForm() {
    // textarea clear
    this.$employeeIds.val('');

    // validation errors clear
    this.$form.validate().resetForm();

    // remove red/green borders
    this.$form.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
}


}

$(document).ready(()=>{
    window.EmployeeApp = new EmployeeApp();
});


$(document).on('change', '.status-toggle', function() {
    const checkbox = $(this);
    const id = checkbox.data('id');
    const status = checkbox.is(':checked') ? 1 : 0;
    const actionText = status === 1 ? "activate" : "deactivate";

    // Confirmation before toggling
    Swal.fire({
        title: "Are you sure?",
        text: `Do you really want to ${actionText} this employee?`,
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

            $.post('api/add_emp_operations.php', { flag: 'toggle_status', id: id, status: status }, (response) => {
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
                        text: status === 1 ? "Employee activation successful." : "Employee deactivation successful.",
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

</script>
<!--app JS-->
<script src="assets/js/app.js"></script>
</body>

</html> 