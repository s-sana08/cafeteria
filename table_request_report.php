<?php
session_start();

// Ensure employee/vendor is logged in
if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php");
    exit;
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$vendor_id = isset($_SESSION['vendor_id']) ? $_SESSION['vendor_id'] : '';

// Include DB connection
include_once('api/config.php'); 
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
/* Select text always black */
#frmrequest select {
    color: black !important;
}

/* Error border only */
#frmrequest select.error {
    border-color: red !important;
}

/* Placeholder option gray */
#frmrequest select option[value=""] {
    color: #999;
}


/* Date input text always black */
#frmrequest input[type="date"] {
    color: black !important;
}

/* Error border only */
#frmrequest input[type="date"].error {
    border-color: red !important;
}

/* Placeholder (when empty) - light gray */
#frmrequest input[type="date"]:invalid {
    color: #999;
}
    /* Dropdown Value black when validation End */



.page-footer {
    margin-top: auto;
}

.wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
@media print {
    .no-export {
        display: none !important;
    }
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
					<div class="breadcrumb-title pe-3 text-uppercase">Reports</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><a href="index.php" target="_blank" rel="noopener noreferrer"><i class="bx bx-home-alt"></i></a></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"><em>Request Report</em></li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0 text-uppercase">Select Request Report</h5>
                            </div>
                            <div class="card-body p-4">
                                <form id="frmrequest"> 
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <div class="d-md-flex d-grid align-items-start gap-3">
                                                <!-- Report Type -->
                                                <div style="min-width:220px;">
                                                    <label class="form-label" style="font-weight:bold ;">Select Request Type<font color="red">*</font></label>
                                                        <select class="form-select" id="txtrequest" name="txtrequest">
                                                        <option value="">-- Select --</option>
                                                        <option value="requested">Requested</option>
                                                        <option value="approved">Approved</option>
                                                        <option value="reject">Rejected</option>
                                                        <option value="all">All</option> 
                                                    </select>                                                    
                                                    <div style="height:18px;">
                                                        <span id="vendorError" class="text-danger" style="font-size:12px;"></span>
                                                    </div>
                                                </div>
                                                <!-- From Date -->
                                                <div style="min-width:180px;">
                                                    <label class="form-label" style="font-weight:bold ;">From</label>
                                                    <input type="date" id="fromdate" name="fromdate" class="form-control">
                                                    <div style="height:18px;">
                                                        <span id="fromError" class="text-danger" style="font-size:12px;"></span>
                                                    </div>
                                                </div>
                                                <!-- To Date -->
                                                <div style="min-width:180px;">
                                                    <label class="form-label" style="font-weight:bold ;">To</label>
                                                    <input type="date" id="todate" name="todate" class="form-control">
                                                    <div style="height:18px;">
                                                        <span id="toError" class="text-danger" style="font-size:12px;"></span>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <div class="d-flex align-items-end" style="height:70px;">
                                                    <button type="button" class="btn btn-primary px-4" id="btnsubmit">
                                                        Select
                                                    </button>
                                                </div>
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
                                            <h5 class="mb-0 text-uppercase">Request Report</h5>
                                        </div>
                                        <div class="card-body p-4" style="overflow-x :auto";>
                                            
                            
                            <div id="rsttbl">
                                <table id="example2" class="table table-striped table-bordered">
                                    <thead>
                                        <th style="display:none;">Flag</th>
                                        <th>Sr. No.</th>
                                        <!-- <th>Vendor Name</th> -->
                                        <th>Employee ID</th>
                                        <th>Request Time</th>
                                        <th>Status</th>
                                        <!-- <th  class="no-export">Action</th>
                                        <th  class="no-export">Delete Request</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                     
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
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
$(document).ready(function() {

    // ================= DATATABLE =================
    var buttonsConfig = [];

      <?php if (isset($_SESSION['role']) && $_SESSION['role'] == '1') { ?>

            
        var vendorName = "<?php echo addslashes($_SESSION['name']); ?>";

        buttonsConfig = [
            {
                extend: 'excel',
                title: 'Request Report',
                exportOptions: 
                { 
                    columns: [1, 2, 3,4,5] 
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
                title: 'Request Report',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: 
                { 
                    columns: [1, 2, 3,4,5] 
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
                    var objLayout = {};
                    objLayout['hLineWidth'] = function(i) { return 0.5; };
                    objLayout['vLineWidth'] = function(i) { return 0.5; };
                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                    objLayout['paddingLeft'] = function(i) { return 6; };
                    objLayout['paddingRight'] = function(i) { return 6; };

                    doc.content[1].layout = objLayout;

                    // Auto widths (better for dynamic columns)
                    doc.content[1].table.widths = '*';

                    // Smaller font
                    doc.defaultStyle.fontSize = 8;
                }
            },
            {
                extend: 'print',
                title: 'Request Report',
                exportOptions: 
                { 
                    columns: [1, 2, 3,4,5] 
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

                    $(win.document.body).find('table')
                        .css('border-collapse', 'collapse')
                        .css('width', '100%');

                    $(win.document.body).find('table th, table td')
                        .css('border', '1px solid black')
                        .css('padding', '8px');

                    $(win.document.body).find('h1')
                        .css('text-align', 'center');
                }
            }
        ];
    <?php } ?>

    var table = $('#example2').DataTable({
        dom: '<"dt-top"lBf>rtip',
        lengthChange: true,
        pageLength: 10,
        buttons: buttonsConfig
    });

    table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');


    // ================= FILTER REPORT =================
    $('#btnsubmit').click(function () {
 
        if (!$("#frmrequest").valid()) return;

        let fromDate = $('#fromdate').val();
        let toDate = $('#todate').val();

        // Auto set today's date if To Date empty
        if (fromDate && toDate === "") {
            let today = new Date().toISOString().split('T')[0];
            $('#todate').val(today);
        }

        $.ajax({
            url: 'api/request_operations.php',
            type: 'POST',
            data: {
                flag: 'filter_request',
                report_type: $('#txtrequest').val(),
                from_date: $('#fromdate').val(),
                to_date: $('#todate').val()
            },
            success: function (response) {
                table.clear().draw();
                $('#example2 tbody').html(response);
                table.rows.add($('#example2 tbody tr')).draw();
            },
            error: function () {
                alertify.error("Error loading data");
            }
        });

    });


    // ================= DATE RESTRICTION =================
    $('#fromdate').on('change', function () {

        let fromDate = $(this).val();
        let toDate = $('#todate').val();

        if (fromDate !== "") {
            $('#todate').attr('min', fromDate);

            if (toDate && toDate < fromDate) {
                $('#todate').val('');
            }
        } else {
            $('#todate').removeAttr('min');
        }
    });

    $('#todate').on('change', function () {

        let toDate = $(this).val();

        if (toDate !== "") {
            $('#fromdate').attr('max', toDate);
        } else {
            $('#fromdate').removeAttr('max');
        }
    });


    // ================= REMOVE ERROR =================
    $('#txtrequest').change(function () {
        if ($(this).val() !== "") {
            $('#vendorError').hide();
        }
    });


    // ================= STATUS TOGGLE =================
    $(document).on("change", ".status-toggle", function() {

        const checkbox = $(this);
        const requestId = parseInt(checkbox.data("id"));
        const newFlag = checkbox.is(":checked") ? 1 : 0;

        const actionText = newFlag === 1 ? "mark as approved" : "mark as Pending";

        Swal.fire({
            title: "Are you sure?",
            text: `Do you really want to ${actionText}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: "Updating...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.post("api/update_request_flag.php", 
                    { id: requestId, flag: newFlag }, 
                    function(response){

                        response = response.trim();

                        if(response === "success") {

                            const statusText = (newFlag == 1) 
                                ? "<span class='badge bg-success'>approved</span>" 
                                : "<span class='badge bg-warning'>Requested</span>";

                            $("#status-" + requestId).html(statusText);

                            Swal.fire({
                                icon: "success",
                                title: "Updated!",
                                timer: 1200,
                                showConfirmButton: false
                            });

                        } else {
                            Swal.fire("Error", response, "error");
                            checkbox.prop("checked", !newFlag);
                        }
                    }
                );

            } else {
                checkbox.prop("checked", !newFlag);
            }
        });

    });


    // ================= DELETE REQUEST =================
    $(document).on("click", ".delete-btn", function() {

        const button = $(this);
        const requestId = button.data("id");
        const flag = parseInt(button.data("flag")); 
        const row = button.closest("tr");

        if(flag === 1) {
            Swal.fire({
                icon: "warning",
                title: "Not Allowed",
                text: "Request already accepted"
            });
            return; 
        }

        Swal.fire({
            title: "Are you sure?",
            text: "This request will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: "Deleting...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.post("api/delete_request.php", 
                    { id: requestId }, 
                    function(response){

                        response = response.trim();

                        if(response === "success") {

                            table.row(row).remove().draw();

                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                timer: 1200,
                                showConfirmButton: false
                            });

                        } else {
                            Swal.fire("Error", response, "error");
                        }
                    }
                );
            }
        });

    });

});
</script>


<script src="assets/js/app.js"></script>
</body>
</html>