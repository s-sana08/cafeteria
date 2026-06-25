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


/*red color box Start */
#frmemp input[type="text"] {
    color: black !important;
}
#frmemp input[type="text"].error {
    border-color: red !important;
}

#frmemp input[type="text"]:invalid {
    color: #999;
}
/*red color box End */




.page-footer {
    margin-top: auto;
}

.wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

@media (max-width: 767px) {
    #fromdate,
    #todate {
        max-width: 100% !important;
    }
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
                                <li class="breadcrumb-item active" aria-current="page"><em> Employee Wise Report </em></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header px-4 py-3">
								<h5 class="mb-0 text-uppercase">Employee Wise Report</h5>
							</div>
							<div class="card-body p-4">
                                <form id="frmemp">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <div class="d-md-flex d-grid align-items-end gap-3">
                                                <!-- Enter Employee ID -->
                                                <div>
                                                    <label for="txtemp" class="form-label col-form-label">Enter Employee ID<font color="red">*</font></label>
                                                    <input type="text" class="form-control" id="txtemp" name="txtemp" placeholder="Type Employee ID">
                                                    <!-- <select class="form-select" id="txtemp" name="txtemp">
                                                    </select> -->
                                                </div>
                                                <!-- From Date -->
                                                <div>
                                                    <label class="form-label" style="font-weight:bold ;">From</label>
                                                    <input type="date" id="fromdate" name="fromdate"
                                                        class="form-control" style="max-width:150px;" />
                                                </div>
                                                <!-- To Date -->
                                                <div>
                                                    <label class="form-label" style="font-weight:bold ;">To</label>
                                                    <input type="date" id="todate" name="todate" class="form-control" style="max-width:150px;" />
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary px-4" id="btnsubmit" name="submit">Select</button>
                                                </div>
                                            </div>
                                        </div>
                                        <span id="empError" style="color:red; display:none; margin-top:5px;"></span>
                                        <!-- Place error message below the flex container -->
                                        <span id="empError" style="color:red; display:none; margin-top:5px;"></span>
                                    </div>
                                </form> 
							</div>
						</div>
					</div>
				</div>
                <div class="card">
                    <div class="card-header px-4 py-3">
						<h5 class="mb-0 text-uppercase">Employee Wise Report</h5>
					</div>
                    <div class="card-body p-4" style="overflow-x: auto;">
                        <div id="rsttbl">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Food Type</th>
                                        <th>Vendor Name</th>
                                        <th>Meal Time</th>
                                        <th>Date & Time</th>
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 



   <script>
$(document).ready(function () {

        $('#fromdate').on('change', function () {
        let fromDate = $(this).val();

        if (fromDate) {
            $('#todate').attr('min', fromDate);

            if ($('#todate').val() < fromDate) {
                $('#todate').val('');
            }
        }
    });
    var buttonsConfig = [];


    <?php if(isset($_SESSION['emp_role'])) { ?>
        var vendorName = "<?php echo addslashes($_SESSION['name']); ?>";

        buttonsConfig = [
            {
                extend: 'excel',
                title: 'Employee-wise Food Report | ' + vendorName,
                exportOptions: 
                {
                    columns: [0, 1, 2, 3, 4, 5,6]
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
                title: 'Employee-wise Food Report | ' + vendorName,
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: 
                {
                   columns: [0, 1, 2, 3, 4, 5,6]
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

                    // ✅ Dynamic width (best)
                    var columnCount = doc.content[1].table.body[0].length;
                    doc.content[1].table.widths = Array(columnCount).fill('*');
                    doc.defaultStyle.fontSize = 8;
                }
            },
            {
                extend: 'print',
                title: 'Employee-wise Food Report | ' + vendorName,
                exportOptions: {
                   columns: [0, 1, 2, 3, 4, 5,6]
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

    $('#frmemp').submit(function(e){
        e.preventDefault();

        let selectedEmp = $('#txtemp').val(); 
        let fromDate = $('#fromdate').val();
        let toDate = $('#todate').val();

            // 👉 Auto To Date logic
    if (fromDate && !toDate) {
        let today = new Date().toISOString().split('T')[0];
        $('#todate').val(today);
        toDate = today;
    }


        if (selectedEmp == "") {
            $('#empError').text("Please enter employee id.").show();
            $('#txtemp').addClass('error'); 
            return;
        } else {
            $('#empError').hide();
            $('#txtemp').removeClass('error'); 
        }




        $.post('api/report_operations.php', { 
            flag: 'Empwiseshowdata',
            empid: selectedEmp, 
             fromdate: $('#fromdate').val(),
                todate: $('#todate').val()
        }, function (response) {


         // Invalid employee check start
    if (response.trim() === "invalid_emp") {
        $('#empError').text("Invalid employee id.").show();
        $('#txtemp').addClass('error');
        table.clear().draw();
        return;
    }
    // Invalid employee check end



            table.clear().draw();
            
            $('#example2 tbody').html(response);
            table.rows.add($('#example2 tbody tr')).draw();
        });
    });
    $('#txtemp').change(function () {
        if ($(this).val() !== "") {
            $('#empError').hide();
            $(this).removeClass('error');
        }
    });

});
</script>
    <!--app JS-->

    <script src="assets/js/app.js"></script>
</body>

</html>