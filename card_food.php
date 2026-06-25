<?php
session_start();

if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php"); // your login page
    exit;
} 

include_once('api/config.php');

$foods = []; 
$sql = "SELECT * FROM food_type_master WHERE status = 1 ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $foods[] = $row;
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

/* Make jQuery Validate error messages bold */
    /* label.error {
        margin-top:5px;
        font-weight: 600;
        color: red; 
        font-size: 14px; 
    } */

/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 30px;   /* track width */
  height: 16px;  /* track height */
}
.page-footer {
    position: fixed;
    bottom: 0;
    width: 100%;
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
					<div class="breadcrumb-title pe-3 text-uppercase">Dashboard</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"><em> Meals Served</em></li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				<!--end row-->
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0 text-uppercase">Meals Served</h5>
                            </div>
                            <div class="card-body p-4">
		                        <div id="rsttbl">
                                    <table id="example2" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Food Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(count($foods) > 0) {
                                                $i = 1;
                                                foreach($foods as $food) {
                                                    echo "<tr>
                                                            <td>".$i++."</td>
                                                            <td>".htmlspecialchars($food['food_type_name'])."</td>
                                                        </tr>";
                                                }
                                            } else {
                                                echo "<tr>
                                                        <td colspan='5' class='text-center'>No Data Found</td>
                                                    </tr>";
                                            }
                                            ?>
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



    // pdf, csv, excel 
    $(document).ready(function () {

    var table = $('#example2').DataTable({
        dom: '<"dt-top"lBf>rtip',
        lengthChange: true,
        pageLength: 10,
        buttons: [
            {
                extend: 'excel',
                title: 'Meals Served'
            },
            {
                extend: 'pdf',
                title: 'Meals Served'
            },
            {
                extend: 'print',
                title: 'Meals Served'
            }
        ]
    });

    table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
});

</script>
<script src="assets/js/app.js"></script>
</body>

</html> 