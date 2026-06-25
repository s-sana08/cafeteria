<?php
session_start();

if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php"); // your login page
    exit;
} 

include_once('api/config.php');

// 12 to 12 
// $current_date1 = date('Y-m-d');

// $sql_skipped = "
//     SELECT e.emp_id, e.emp_name, e.two_times_food_allowed
//     FROM employee e
//     LEFT JOIN food_entry f ON e.emp_id = f.emp_id AND DATE(f.created_at) = '$current_date1'
//     WHERE e.emp_status = 1 AND f.emp_id IS NULL
//     ORDER BY e.emp_name
// "; 

// 4 to 4 
$current_date1 = date('Y-m-d');

$sql_skipped = "
SELECT e.emp_id, e.emp_name, e.two_times_food_allowed,e.created_at,
c.company_name, d.department_name
FROM employee e

LEFT JOIN company_master c 
    ON e.company_id = c.id

LEFT JOIN department_master d 
    ON e.department_id = d.id

LEFT JOIN food_entry f 
    ON e.emp_id = f.emp_id 
    AND DATE(DATE_SUB(f.created_at, INTERVAL 4 HOUR)) = DATE(DATE_SUB(NOW(), INTERVAL 4 HOUR))
WHERE e.emp_status = 1 
AND f.emp_id IS NULL
ORDER BY e.id ASC 
";

$result_skipped = $conn->query($sql_skipped);
$skipped_employees = [];

if ($result_skipped && $result_skipped->num_rows > 0) {
    while ($row = $result_skipped->fetch_assoc()) {
        $skipped_employees[] = $row;
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


.page-footer {
    position: fixed;
    bottom: 0;
    width: 100%;
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
								<li class="breadcrumb-item active" aria-current="page"><em> Skipped Meal Count</em></li>
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
                                <h5 class="mb-0 text-uppercase">Skipped Meal Count</h5>
                            </div>
                            <div class="card-body p-4">
		                        <div id="rsttbl">
                                    <table id="example2" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Employee ID</th>
                                                <th>Employee Name</th>
                                                <th>Company Name</th>
                                                <th>Department Name</th>
                                                 <th>Meal Time</th>
                                                 <th>Date & Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($skipped_employees) > 0) {
                                                $i = 1;

                                                foreach ($skipped_employees as $emp) {

                                                    $foodBadge = '';

                                                    if ($emp['two_times_food_allowed'] == 1) {
                                                        $foodBadge = '<span class="badge bg-success">One Time</span>';
                                                    } elseif ($emp['two_times_food_allowed'] == 2) {
                                                        $foodBadge = '<span class="badge bg-primary">Two Times</span>';
                                                    } else {
                                                        $foodBadge = '<span class="badge bg-secondary">N/A</span>';
                                                    }

                                                    echo "<tr>
                                                            <td>".$i++."</td>
                                                            <td>".htmlspecialchars($emp['emp_id'])."</td>
                                                            <td>".htmlspecialchars($emp['emp_name'])."</td>
                                                               <td>".htmlspecialchars($emp['company_name'])."</td>
                                                            <td>".htmlspecialchars($emp['department_name'])."</td>
                                                            <td>".$foodBadge."</td>
                                                            <td>".date('d/m/Y h:i A', strtotime($emp['created_at']))."</td>  
                                                        </tr>";
                                                }

                                            } else {
                                                echo "<tr>
                                                        <td colspan='4' class='text-center'>No Data Found</td>
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
                title: 'Skipped Meal Employee List',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
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
                title: 'Skipped Meal Employee List',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
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
            customize: function(doc) 
            {

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
                title: 'Skipped Meal Employee List',
            exportOptions: 
            {
                columns: [0, 1, 2, 3, 4, 5, 6]
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
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    }
                });
            },
            customize: function(win) 
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

</script>
<script src="assets/js/app.js"></script>
</body>

</html> 