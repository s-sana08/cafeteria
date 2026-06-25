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
                    <div class="breadcrumb-title pe-3">Reports</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Date Wise Report</li>
                            </ol>
                        </nav>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header px-4 py-3">
								<h5 class="mb-0">Date Wise</h5>
							</div>
							<div class="card-body p-4">
                               <form id="frmdate">
                                    <div class="row mb-6">
                                    <div class="col-sm-12 d-flex align-items-start gap-3">

    <div class="form-group mb-0 d-flex flex-column">
        <label for="fromdate" class="form-label col-form-label">From<font color="red">*</font></label>
        <input type="date" id="fromdate" class="form-control">
        <div style="min-height:18px;">
            <span id="fromError" class="text-danger" style="font-size:12px;"></span>
        </div>
    </div>

    <div class="form-group mb-0 d-flex flex-column">
        <label for="todate" class="form-label col-form-label">To<font color="red">*</font></label>
        <input type="date" id="todate" class="form-control">
        <div style="min-height:18px;">
            <span id="toError" class="text-danger" style="font-size:12px;"></span>
        </div>
    </div>

    <!-- Button aligned with input -->
    <div class="form-group mb-0 d-flex flex-column">
        <label style="visibility:hidden;">Hidden</label> <!-- spacer -->
        <button type="submit" class="btn btn-primary" id="btnsubmit">
            Select
        </button>
    </div>

</div>
                                       
                                    </div>
                                </form> 
							</div>
						</div>
					</div>
				</div>




                <div class="card">
                    <div class="card-header px-4 py-3">
						<h5 class="mb-0">Date Wise List</h5>
					</div>
                    <div class="card-body p-4" style="overflow-x: auto;">
                        <div id="rsttbl" >
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



    <script>


$(document).ready(function () {

   // Initialize DataTable once
   <?php if(isset($_SESSION['emp_role'])){ ?>
   var vendorName = "<?php echo addslashes($_SESSION['name']); ?>";
   var buttonsConfig = [
       { 
           extend: 'excel', 
           title: 'Date-wise Food Report | ' + vendorName,
           exportOptions: { columns: [0,1,2,3,4,5] } // optional: only required columns
       },
       { 
           extend: 'pdf', 
           title: 'Date-wise Food Report | ' + vendorName,
           exportOptions: { columns: [0,1,2,3,4,5] },
           customize: function(doc) {
               var objLayout = {};
               objLayout['hLineWidth'] = function(i){ return 0.5; };
               objLayout['vLineWidth'] = function(i){ return 0.5; };
               objLayout['hLineColor'] = function(i){ return '#aaa'; };
               objLayout['vLineColor'] = function(i){ return '#aaa'; };
               objLayout['paddingLeft'] = function(i){ return 8; };
               objLayout['paddingRight'] = function(i){ return 8; };
               doc.content[1].layout = objLayout;
           }
       },
       { 
           extend: 'print', 
           title: 'Date-wise Food Report | ' + vendorName,
           exportOptions: { columns: [0,1,2,3,4,5] },
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
   <?php }?>

   var table = $('#example2').DataTable({
       dom: '<"dt-top"lBf>rtip',          // 👈 THIS FIXES IT
       lengthChange: true,
       pageLength: 10,          
       buttons: buttonsConfig
   });

    table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    // Set today's date as minimum for To field
    let today = new Date().toISOString().split('T')[0];
    $('#todate').attr('min', today);

    // Submit button validation & Ajax
     $('#fromdate').on('change', function() {
        const fromVal = $(this).val();
        const toVal = $('#todate').val();

        // If To Date is empty, set it to today's date
        if(toVal === "" && fromVal !== "") {
            const today = new Date();
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1; // Months are 0-based
            let dd = today.getDate();

            // Add leading zeros
            if(mm < 10) mm = '0' + mm;
            if(dd < 10) dd = '0' + dd;

            const todayStr = `${yyyy}-${mm}-${dd}`; // format: yyyy-mm-dd
            $('#todate').val(todayStr);
            $('#toError').text("");
            $('#todate').removeClass('error');
        }
    });

    $('#frmdate').submit(function(e){
        e.preventDefault();

        let fromdate = $('#fromdate').val(); 
        let todate = $('#todate').val(); 
        let isValid = true;

        // From date
        if(fromdate === "") {
            $('#fromError').text("Please select From date.");
            $('#fromdate').addClass('error');
            isValid = false;
        } else {
            $('#fromError').text("");
            $('#fromdate').removeClass('error');
        }

        // To date
        if(todate === "") {
            $('#toError').text("Please select To date.");
            $('#todate').addClass('error');
            isValid = false;
        } else if(fromdate !== "" && todate < fromdate) {
            $('#toError').text("To date cannot be earlier than From date.");
            $('#todate').addClass('error');
            isValid = false;
        } else {
            $('#toError').text("");
            $('#todate').removeClass('error');
        }

        if(!isValid) return false;

        // Ajax call
         $.post('api/vendor_report_operations.php', { 
            flag: 'Datewiseshowdata',
            fromdate: fromdate,
            todate: todate
        }, function(response){
            table.clear().draw();
            $('#example2 tbody').html(response);
            table.rows.add($('#example2 tbody tr')).draw();
        });
    });

          $('#fromdate').change(function () {
        let fromDate = $(this).val();
        if(fromDate !== ""){
            $('#fromError').text("");
            $(this).removeClass('error');

            // Restrict To date
            $('#todate').attr('min', fromDate);
        }
    });

    // To date change
    $('#todate').change(function () {
        let fromdate = $('#fromdate').val();
        let todate = $(this).val();
        if(todate !== ""){
            if(fromdate !== "" && todate < fromdate){
                $('#toError').text("To date cannot be earlier than From date");
                $(this).addClass('error');
            } else {
                $('#toError').text("");
                $(this).removeClass('error');
            }
        }
    });


});

    </script>
    <!--app JS-->

    <script src="assets/js/app.js"></script>
</body>

</html>