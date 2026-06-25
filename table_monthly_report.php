<?php
session_start();

if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php"); 
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


.page-footer {
    margin-top: auto;
}

.wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
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
                                <li class="breadcrumb-item active" aria-current="page"><em> Monthly Report </em></li>
                            </ol>
                        </nav>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header px-4 py-3">
								<h5 class="mb-0 text-uppercase">Select a Month</h5>
							</div>
							<div class="card-body p-4">
                               <form id="frmmonth">
                                    <div class="row mb-6">
                                        <div class="col-sm-3">
                                             <label for="txtmonthly" class="form-label col-form-label">Select Month<font color="red">*</font></label>
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                               
                                                <input type="month" id="txtmonthly" class="form-control">
                                                <button type="submit" class="btn btn-primary px-4" id="btnsubmit" name="submit">Select</button>
                                            </div>
                                            <span id="Error" style="color:red; display:none; margin-top:5px;"></span>
                                            <!-- Place error message below the flex container -->
                                            <span id="Error" style="color:red; display:none; margin-top:5px;"></span>
                                        </div>
                                    </div>
                                </form> 
							</div>
						</div>
					</div>
				</div>




                <div class="card">
                    <div class="card-header px-4 py-3">
						<h5 class="mb-0 text-uppercase">Monthly Report</h5>
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

    var buttonsConfig = [];

    <?php if(isset($_SESSION['emp_role'])) { ?>
        var vendorName = "<?php echo addslashes($_SESSION['name']); ?>";

        buttonsConfig = [
            {
                extend: 'excel',
                title: 'Monthly Food Report | ' + vendorName,
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
                title: 'Monthly Food Report | ' + vendorName,
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
                title: 'Monthly Food Report | ' + vendorName,
                exportOptions: 
                {
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

    $('#frmmonth').submit(function(e){
        e.preventDefault();

        let selectedMonth = $('#txtmonthly').val(); 

        if (selectedMonth == "") {
            $('#Error').text("Please select a month.").show();
            $('#txtmonthly').addClass('error'); 
            return;
        } else {
            $('#Error').hide();
            $('#txtmonthly').removeClass('error'); 
        }

        $.post('api/report_operations.php', { 
            flag: 'Monthlyshowdata',
            datetime: selectedMonth
        }, function (response) {
            table.clear().draw();
            $('#example2 tbody').html(response);
            table.rows.add($('#example2 tbody tr')).draw();
        });
    });

    $('#txtmonthly').change(function () {
        if ($(this).val() !== "") {
            $('#Error').hide();
            $(this).removeClass('error');
        }
    });

});
</script>
    <!--app JS-->

    <script src="assets/js/app.js"></script>
</body>

</html>