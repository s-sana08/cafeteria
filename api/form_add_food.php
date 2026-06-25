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
					<div class="breadcrumb-title pe-3">Forms</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Food Master</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				
			

				<div class="row">
                    <div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header px-4 py-3">
								<h5 class="mb-0">Add Food</h5>
							</div>
							<div class="card-body p-4">
								<form id="frmfood">
								
									<div class="row mb-3">
										<label for="txtfoodname" class="col-sm-3 col-form-label">Food Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="idfood" name="idfood" hidden>
											<input type="text" class="form-control" id="txtfoodname" name="txtfoodname" placeholder="Please Enter Food name">
										</div>
									</div>
									<div class="row">
										<label class="col-sm-3 col-form-label"></label>
										<div class="col-sm-9">
											<div class="d-md-flex d-grid align-items-center gap-3">
												<button type="submit" class="btn btn-primary px-4" id="btnsubmit" name="submit">Save</button>
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
						<h5 class="mb-0">Food List</h5>
					</div>
					<div class="card-body p-4">
						
		
		<div id="rsttbl">
    <table id="example2" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>SrNo</th>
                <th>Food Name</th>
                <th>Edit</th>
				<th>Active</th>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
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

class Food {
    constructor() {
        this.init();
    }

    init() {
        this.cacheElements();
        this.bindEvents();
        this.loadDropdowns();
        this.showData();
        $('#txtfoodname').focus();
    }

    cacheElements() {
        this.$form = $('#frmfood');
        this.$foodName = $('#txtfoodname');
        this.$btnSubmit = $('#btnsubmit');
        this.$table = $('#example2');
    }

    bindEvents() {
        this.$form.on('submit', (e) => this.handleSubmit(e));
    }
handleSubmit(e) {
    if(e) e.preventDefault();

    const data = {
        flag: 'insert',
        id: $('#idfood').val(),
        foodname: this.$foodName.val(),
    };

    $.post('api/add_food_operations.php', data, (response) => {
            let res;
            try {
                res = JSON.parse(response);
            } catch (err) {
                console.error("Invalid JSON response:", response);
                alertify.error("Server error");
                return;
            }

            if (res.status === "inserted") {
                alertify.success("Inserted");
            } else if (res.status === "updated") {
                alertify.success("Updated");
            } else {
                alertify.error(res.message || "Operation failed");
            }

            this.showData();
            this.resetForm();
        });
    }

    loadDropdowns() {
        $.post('api/add_food_operations.php', { flag: 'fetch_dropdowns' }, (response) => {
            const data = JSON.parse(response);
            let deptHtml = '<option value="">Select Food Type</option>';
            data.food_type_master.forEach(d => {
                deptHtml += `<option value="${d.id}">${d.food_type_name}</option>`;
            });
            this.$vndFood.html(deptHtml);
        });
    }

    showData() {
        $.post('api/add_food_operations.php', { flag: 'showdata' }, (response) => {
            if ($.fn.DataTable.isDataTable(this.$table)) {
                this.$table.DataTable().clear().destroy();
            }

            this.$table.find('tbody').html(response);

            const table = this.$table.DataTable({
                lengthChange: false,
                buttons: ['excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    }

    showInEditor(id) {
        this.$btnSubmit.html("Update");
        $('#idfood').val(id);
        this.$foodName.val($(`#tempfoodnm${id}`).html());
    }

    resetForm() {
        $('#idfood').val('');
        this.$foodName.val('');
        this.$btnSubmit.html("Save");
    }
}

// Initialize the class
$(document).ready(() => {
    window.FoodApp = new Food();
});

// Expose ShowInEditor globally
function ShowInEditor(id) {
    window.FoodApp.showInEditor(id);
}

// **Toggle status event binding**
$(document).on('change', '.status-toggle', function() {
    const id = $(this).data('id');
    const status = $(this).is(':checked') ? 1 : 0;

    $.post('api/add_food_operations.php', { flag: 'toggle_status', id: id, status: status }, function(response) {
        let res;
        try {
            res = JSON.parse(response);
        } catch (err) {
            console.error("Invalid JSON response:", response);
            alertify.error("Server error");
            return;
        }

        if(res.status === 'success') {
            alertify.success("Status updated");
        } else {
            alertify.error(res.message || "Failed to update status");
        }
    });
});
</script>
<!--app JS-->
<script src="assets/js/app.js"></script>
</body>

</html> 