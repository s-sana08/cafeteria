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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/images/ss_logo.png" type="image/png">

    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link href="assets/css/pace.min.css" rel="stylesheet">
    <script src="assets/js/pace.min.js"></script>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css">

    <link href="assets/sass/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">

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
</style>

<body>
<div class="wrapper">

    <?php include("api/sidebar.php"); ?>
    <?php include("api/header.php"); ?>

    <div class="page-wrapper">
        <div class="page-content container-xxl">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Reports</div>
                <div class="ps-3">
                    <nav>
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Monthly Report</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Month Filter -->
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Monthly Food</h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="frmmonth">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label class="form-label">Select Month <font color="red">*</font></label>
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <input type="month" id="txtmonthly" class="form-control">
                                            <button type="submit" class="btn btn-primary px-4">Select</button>
                                        </div>
                                        <span id="Error" style="color:red; display:none;"></span>
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="card-header px-4 py-3">
                    <h5 class="mb-0">Monthly Food List</h5>
                </div>
                <div class="card-body p-4">
                    <div style="overflow-x:auto;">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Food Type</th>
                                    <th>Meal Time</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="overlay toggle-icon"></div>
    <?php include("api/footer.php"); ?>

</div>

<!-- JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>

<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

<script src="assets/plugins/validation/jquery.validate.min.js"></script>
<script src="assets/plugins/validation/validation-script.js"></script>

<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
$(document).ready(function () {

    // Initial DataTable (NO BUTTONS)
    var table = $('#example2').DataTable({
        dom: '<"dt-top"lf>rtip',
        lengthChange: true,
        pageLength: 10
    });

    // Form submit
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

        $.post('api/vendor_report_operations.php', { 
            flag: 'Monthlyshowdata',
            datetime: selectedMonth
        }, function (response) {

            if ($.fn.DataTable.isDataTable('#example2')) {
                table.clear().destroy();
            }

            $('#example2 tbody').html(response);

            // Reinitialize again (NO BUTTONS)
            table = $('#example2').DataTable({
                dom: '<"dt-top"lf>rtip',
                lengthChange: true,
                pageLength: 10
            });

        });
    });

    // Remove error on change
    $('#txtmonthly').change(function () {
        if ($(this).val() !== "") {
            $('#Error').hide();
            $(this).removeClass('error');
        }
    });

});
</script>

<script src="assets/js/app.js"></script>

</body>
</html>