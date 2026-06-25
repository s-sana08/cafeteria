<div class="sidebar-wrapper" data-simplebar="true">

    <div class="sidebar-header">
        <div class="logo-container-king">
            <a href="index.php">
                <img src="../cafeteria/assets/images/ss_logo.png" class="logo-icon-king" alt="logo icon">
            </a>
        </div>
        <div class="mobile-toggle-icon ms-auto">
            <i class='bx bx-x'></i>
        </div>
    </div>

    <!-- navigation wrapper -->
    <div class="sidebar-menu">
        <ul class="metismenu" id="menu">

            <?php if($_SESSION['emp_role']=="Admin" || $_SESSION['emp_role']=="SuperAdmin") { ?>

            <li>
                <a href="index.php">
                    <div class="parent-icon"><i class='bx bx-home'></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            <li class="menu-label text-uppercase">Admin Management & Reports</li>

            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-message-square-edit'></i></div>
                    <div class="menu-title">Admin Management</div>
                </a>
                <ul>
                    <?php if($_SESSION['emp_role']=="SuperAdmin") { ?>
                        <li><a href="admin_master.php"><i class='bx bx-user-plus'></i>Add Admin</a></li>
                    <?php } ?>
                    <li><a href="form_add_emp.php"><i class='bx bx-user-plus'></i>Add Employee</a></li>
                    <li><a href="form_add_bulk_emp.php"><i class='bx bx-group'></i>Add Bulk Employees</a></li>
                    <li><a href="form_add_vendor.php"><i class='bx bx-store'></i>Add Vendor</a></li>
                    <li><a href="form_add_company.php"><i class='bx bx-buildings'></i>Add Company</a></li>
                    <li><a href="form_add_department.php"><i class='bx bx-sitemap'></i>Add Department</a></li>
                    <li><a href="form_add_food.php"><i class='bx bx-dish'></i>Add Food Type</a></li>
                    <li><a href="form_add_inactive_emp.php"><i class='bx bx-user-x'></i>Deactivate Employees</a></li>
                    <li><a href="show_request.php"><i class='bx bx-envelope'></i>Registration Request</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="bx bx-grid-alt"></i></div>
                    <div class="menu-title">Reports</div>
                </a>
                <ul>
                    <li><a href="table_daily_report.php"><i class='bx bx-time'></i>Daily Report</a></li>
                    <li><a href="table_monthly_report.php"><i class='bx bx-calendar'></i>Monthly Report</a></li>
                    <li><a href="table_datewise_report.php"><i class='bx bx-calendar-alt'></i>Datewise Report</a></li>
                    <li><a href="table_emp_report.php"><i class='bx bx-layer'></i>Employee wise Report</a></li>
                    <li><a href="table_vendor_report.php"><i class='bx bx-briefcase'></i>Vendor wise Report</a></li>
                    <li><a href="table_request_report.php"><i class='bx bx-file'></i>Request Report</a></li>
                </ul>
            </li>

            <?php } ?>

            <?php if($_SESSION['emp_role']=="Vendor") { ?>

            <li>
                <a href="index.php">
                    <div class="parent-icon"><i class='bx bx-cookie'></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            <li class="menu-label">Vendor Operations & Reports</li>

            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-message-square-edit'></i></div>
                    <div class="menu-title">Vendor Operations</div>
                </a>
                <ul>
                    <li><a href="emp_food_entry.php"><i class='bx bx-user-plus'></i>Employee Food Entry</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="bx bx-grid-alt"></i></div>
                    <div class="menu-title">Reports</div>
                </a>
                <ul>
                    <li><a href="vendor_daily_report.php"><i class='bx bx-home'></i>Daily Report</a></li>
                    <li><a href="vendor_monthly_report.php"><i class='bx bx-calendar'></i>Monthly Report</a></li>
                    <li><a href="table_request_report.php"><i class='bx bx-briefcase'></i>Request Report</a></li>
                </ul>
            </li>

            <?php } ?>


			
			 <?php if($_SESSION['emp_role'] == "SuperAdmin") { ?>
              <li class="menu-label text-uppercase">Admin Activity Log</li>
            <li>
                <a href="admin_logs.php">
                    <div class="parent-icon"><i class='bx bx-history'></i></div>
                    <div class="menu-title">Activity Log</div>
                </a>
            </li>
        <?php } ?>

        </ul>
    </div>


</div>