<?php
session_start();

if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
    header("Location: auth-login.php"); // your login page
    exit;
}


$selected_emp_id = isset($_SESSION['selected_emp_id']) ? $_SESSION['selected_emp_id'] : '';


unset($_SESSION['selected_emp_id']);
?>


<!doctype html> 
<html lang="en" data-bs-theme="light">
  
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/kings_logo_sm.png" type="image/png">
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

    .dim-row td.switch-col {
    color: inherit;
    background-color: transparent;
}
.dim-row .badge {
    opacity: 0.6;
}


  .dt-top {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: nowrap;
    justify-content: space-between;
}

 
    /* Dropdown Value black when validation start */
    #frmmaster select.error {
        color: black !important;
        border-color: red;
    }

    #frmmaster select option[value=""] {
        color: gray;
    }

    /* Dropdown Value black when validation End */

    html {
        scroll-behavior: smooth;
    } 

    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 30px;
        /* track width */
        height: 16px;
        /* track height */
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
        background-color: #FF0000;;
        /* inactive color */
        transition: 0.4s;
        border-radius: 16px;
        /* half of track height for full round */
    }

    /* The circle */
    .slider:before {
        position: absolute;
        content: "";
        height: 12px;
        /* smaller circle */
        width: 12px;
        /* smaller circle */
        left: 2px;
        /* small padding inside track */
        bottom: 2px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    /* When checkbox is checked */
    input:checked+.slider {
        background-color: #4CAF50;
        /* green when active */
    }

    /* Move the circle to right when checked */
    input:checked+.slider:before {
        transform: translateX(14px);
        /* track width - circle width - padding */
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
                                <li class="breadcrumb-item"><a href="javascript:;"><a href="index.php" target="_blank" rel="noopener noreferrer"><i class="bx bx-home-alt"></i></a></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"> <em> Add Employee </em></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0">ADD EMPLOYEE</h5>
                            </div>
                            <div class="card-body p-4" >
                                <form id="frmmaster">

                                    <div class="row mb-3">
                                        <label for="txtempid" class="col-md-3 col-form-label " >Employee ID<font color="red">*</font></label>
                                        <div class="col-md-9 ">
                                            <input type="text" class="form-control" id="idemp" name="idemp" hidden>
                                            <input type="text" class="form-control" id="txtempid" name="txtempid" value="<?php echo $selected_emp_id; ?>" placeholder="Enter Employee ID">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="txtempname" class="col-md-3 col-form-label " >Employee Name<font color="red">*</font></label>
                                        <div class="col-md-9 ">
                                            <input type="text" class="form-control" id="txtempname" name="txtempname" maxlength="30" placeholder="Enter Employee Name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="txtcompanyname" class="col-md-3 col-form-label  " >Company Name<font color="red">*</font></label>
                                        <div class="col-md-9 ">
                                            <select class="form-select" id="txtcompanyname" name="txtcompanyname">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="txtdepartment" class="col-md-3 col-form-label  " >Department<font color="red">*</font></label>
                                        <div class="col-md-9 ">
                                            <select class="form-select" id="txtdepartment" name="txtdepartment">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="txtfoodtime" class="col-md-3 col-form-label  " Forms>Food Time Allow<font color="red">*</font></label>
                                        <div class="col-md-9 ">
                                            <select class="form-select" id="txtfoodtime" name="txtfoodtime">
                                                <option selected disabled value>Select Food Time</option>
                                                <option value="1">One Time</option>
                                                <option value="2">Two Times</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 col-form-label"></label>
                                        <div class="col-md-9">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4" id="btnsubmit" name="submit">Add Employee</button>
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
                                <h5 class="mb-0">EMPLOYEE LIST</h5>
                            </div>
                            <div class="card-body p-4" style="overflow-x: auto;">
                                <div id="rsttbl">
                                    <table id="example2" class="table table-striped table-bordered">
                                        <thead >
                                            <tr class="mt-5">
                                                <th>Sr. No.</th>
                                                <th>Employee ID</th>
                                                <th>Employee Name</th>
                                                <th>Company Name</th>
                                                <th>Department</th>
                                                <th>Food Time</th>
                                                <th>Date & Time</th>
                                                <th>Edit</th>
                                                <th>Action</th>
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
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
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
        this.loadDropdowns();
        this.showData();
        // $('#txtempid').focus();
    }

    cacheElements() {
        this.$form = $('#frmmaster');
        this.$empId = $('#txtempid');
        this.$empName = $('#txtempname');
        this.$company = $('#txtcompanyname');
        this.$department = $('#txtdepartment');
        this.$foodTime = $('#txtfoodtime');
        this.$btnSubmit = $('#btnsubmit');
        this.$table = $('#example2');
        this.$formHeader = $('.card-header h5');
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
        id: $('#idemp').val(),
        empid: this.$empId.val(),
        empname: this.$empName.val(),
        companyname: this.$company.val(),
        department: this.$department.val(),
        foodtime: this.$foodTime.val()
    };

    // Update mode: only submit if fields changed
    if (data.id) {
        const changed = data.empid !== this.originalData.empid ||
                        data.empname !== this.originalData.empname ||
                        data.companyname !== this.originalData.companyname ||
                        data.department !== this.originalData.department ||
                        data.foodtime !== this.originalData.foodtime;
        if (!changed) {
            Swal.fire({
                icon: "info",
                title: "No changes detected",
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }
    }

    // Confirmation before submitting
    // Swal.fire({
    //     title: "Are you sure?",
    //     text: data.id ? "Do you want to update this employee?" : "Do you want to add this employee?",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonText: "Yes, proceed",
    //     cancelButtonText: "Cancel"
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
        confirmButton: 'btn btn-primary',   // ✅ Bootstrap class
        cancelButton: 'btn btn-secondary'   // optional
    },
                    html: `
        <div class="swal-content-wrapper">

            <div class="swal-question">
                Are you sure? 
            </div>

            <div class="swal-subtext">
                ${data.id ? "Do you want to update this Employee?" : "Do you want to add this Employee?"}
            </div>

            <div class="swal-info-card">
                <div class="info-row">
                    <span class="label">Employee ID:</span>
                    <span class="value">${data.empid}</span>
                </div>
    <div class="info-row">
        <span class="label">Employee Name:</span>
        <span class="value">${data.empname}</span>
    </div>
    <div class="info-row">
        <span class="label">Company Name:</span>
        <span class="value">${$('#txtcompanyname option:selected').text()}</span>
    </div>
    <div class="info-row">
        <span class="label">Department Name:</span>
        <span class="value">${$('#txtdepartment option:selected').text()}</span>
    </div>
    <div class="info-row">
        <span class="label">Meal Time:</span>
        <span class="value">${$('#txtfoodtime option:selected').text()}</span>
    </div>
            </div>

        </div>
    `
                }).then((result) => {



        if (result.isConfirmed) {

            // Loading popup
            Swal.fire({
                title: "Processing...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.post('api/add_emp_operations.php', data, (response) => {
                let res;
                try { 
                    res = JSON.parse(response); 
                } catch (err) { 
                    Swal.fire("Error", "Server error", "error");
                    return; 
                }

                // Success / error messages
                if (res.status === "inserted") {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Employee added successfully",
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else if (res.status === "updated") {
                    Swal.fire({
                        icon: "success",
                        title: "Updated",
                        text: "Employee updated successfully",
                        timer: 1500,
                        showConfirmButton: false
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
        this.$btnSubmit.html("Update Employee");
        
        $('#idemp').val(id);

        this.$empId.val($(`#tempempid${id}`).text().trim()).prop('readonly', true);
        this.$empName.val($(`#tempempname${id}`).text().trim());
        this.$company.val($(`#tempcompanyname${id}`).data('companyid'));
        this.$department.val($(`#tempdepartment${id}`).data('departmentid'));

const foodValue = $(`#tempfoodtime${id}`).data('foodvalue'); // gets 1, 2, or 0
this.$foodTime.val(foodValue).change(); // .change() is important for plugins

        // Store original data for change detection
        this.originalData = {
            empid: this.$empId.val(),
            empname: this.$empName.val(),
            companyname: this.$company.val(),
            department: this.$department.val(),
            foodtime: this.$foodTime.val()
        };

        this.$btnSubmit.prop('disabled', true);

        // Enable button when any field changes
        this.$empId.add(this.$empName).add(this.$company).add(this.$department).add(this.$foodTime)
            .off('input change').on('input change', () => {
                const changed = this.$empId.val() !== this.originalData.empid ||
                                this.$empName.val() !== this.originalData.empname ||
                                this.$company.val() !== this.originalData.companyname ||
                                this.$department.val() !== this.originalData.department ||
                                this.$foodTime.val() !== this.originalData.foodtime;
                this.$btnSubmit.prop('disabled', !changed);
            });

        $('html, body').animate({ scrollTop: $('#frmmaster').offset().top - 200 }, 300);
    }

    resetForm() {
        $('#idemp').val('');
        this.$empId.val('');
        this.$empName.val('');
        this.$company.val('');
        this.$department.val('');
        this.$foodTime.val('');
        this.$btnSubmit.html("Add Employee").prop('disabled', false);
        // Remove stale change handlers bound during edit mode
        this.$empId.add(this.$empName).add(this.$company).add(this.$department).add(this.$foodTime)
            .off('input change');
        this.$empId.focus(false);
    }

    loadDropdowns() {
        $.post('api/add_emp_operations.php', { flag: 'fetch_dropdowns' }, (response) => {
            const data = JSON.parse(response);

            let deptHtml = '<option value="">Select Department</option>';
            data.department.forEach(d => deptHtml += `<option value="${d.id}">${d.department_name}</option>`);
            this.$department.html(deptHtml);

            let compHtml = '<option value="">Select Company</option>';
            data.company.forEach(c => compHtml += `<option value="${c.id}">${c.company_name}</option>`);
            this.$company.html(compHtml);
        });
    }

    // showData() {
    //     $.post('api/add_emp_operations.php', { flag: 'showdata' }, (response) => {
    //         if ($.fn.DataTable.isDataTable(this.$table)) this.$table.DataTable().clear().destroy();
    //         this.$table.find('tbody').html(response);
    //         this.$table.DataTable({ lengthChange:false, buttons:['excel','pdf','print'] });
    //     });
    // }


    // Avoid redirect 1st page 
     showData() {
    let currentPage = 0;
    if ($.fn.DataTable.isDataTable(this.$table)) {
        currentPage = this.$table.DataTable().page();
    }

    $.post('api/add_emp_operations.php', { flag: 'showdata' }, (response) => {

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
                     title: 'Employee List',
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
                     title: 'Employee List',
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
                     title: 'Employee List',
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
} 
}

$(document).ready(() => { 
    window.EmployeeApp = new EmployeeManager(); 
});

function ShowInEditor(id) { 
    window.EmployeeApp.showInEditor(id); 
}
 
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