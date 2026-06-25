<?php
session_start();

if (!isset($_SESSION['emp_loggedin']) || $_SESSION['emp_loggedin'] !== true) {
	header("Location: auth-login.php"); // your login page
	exit;
}


$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$vendor_id = isset($_SESSION['vendor_id']) ? $_SESSION['vendor_id'] : '';

include_once('api/config.php');

include_once('api/index_backend.php');
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
	<link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

	<link href="assets/sass/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link rel="stylesheet" href="assets/sass/semi-dark.css">
	<link rel="stylesheet" href="assets/sass/bordered-theme.css">
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<title>Cafeteria | Management System</title>




	<style>
		/* Smooth hover effect for all cards */
		.card-hover {
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}

		/* On hover: slightly lift and shadow */
		.card-hover:hover {
			transform: translateY(-5px);
			box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
		}

		.info-icon {
			position: relative;
			cursor: pointer;
			margin-left: 5px;
			color: rgba(128, 128, 128, 0.6);
			/* grey transparent */
			transition: color 0.3s;
			display: inline-flex;
			align-items: center;
			font-size: 18px;
			/* icon size */
		}

		/* Hover effect */
		.info-icon:hover {
			color: rgba(128, 128, 128, 1);
			/* fully grey on hover */
		}

		/* Tooltip box */
		.tooltip-text {
			visibility: hidden;
			width: 180px;
			background-color: #333;
			color: #fff;
			text-align: center;
			border-radius: 6px;
			padding: 6px 10px;
			position: absolute;
			z-index: 10;
			bottom: 125%;
			left: 50%;
			transform: translateX(-50%);
			opacity: 0;
			transition: opacity 0.3s;
			font-size: 12px;
		}

		/* Tooltip arrow */
		.tooltip-text::after {
			content: "";
			position: absolute;
			top: 100%;
			left: 50%;
			transform: translateX(-50%);
			border-width: 5px;
			border-style: solid;
			border-color: #333 transparent transparent transparent;
		}

		/* Show tooltip on hover */
		.info-icon:hover .tooltip-text {
			visibility: visible;
			opacity: 1;
		}


		.bg-gradient-warning {
			/*background: linear-gradient(145deg, #FF5F6D, #FFC371);*/
			background: linear-gradient(130deg, #00897b, #00695c)
				/* Gradient background */
		}

		.bg-gradient-success {
			/*background: linear-gradient(99deg, #ff8008, #ffc837);*/
			background: linear-gradient(130deg, #00c853, #2e7d32);
		}

		.bg-gradient-danger {
			background: linear-gradient(145deg, #fd8a79, #ff6a88);
		}


		.bg-gradient-success1 {
			/*background: linear-gradient(145deg, #FF6B6B, #556270);*/
			background: linear-gradient(130deg, #fb8c00, #ef6c00);
		}

		.bg-gradient-success2 {
			/*background: linear-gradient(145deg, #c850c0, #4158d0);*/
			background: linear-gradient(130deg, #1e88e5, #1565c0);
		}

		.bg-gradient-success3 {
			/*background: linear-gradient(130deg, #e52d27, #1e3c72);*/
			background: linear-gradient(130deg, #ff3d00, #c62828);
		}

		.bg-gradient-success4 {
			/*background: linear-gradient(99deg, #56ab2f, #a8e063);*/
			background: linear-gradient(130deg, #3949ab, #1a237e);
		}


		.widgets-icons {
			display: flex;
			justify-content: center;
			align-items: center;
			width: 60px;
			height: 60px;
			border-radius: 50%;
			background-color: #ffbc00;
			/* Base color if gradient isn't supported */
		}

		.widgets-icons i {
			font-size: 2.5rem;
			/* Increase icon size */
		}

		.text-secondary {
			color: #6c757d;
		}

		.text-warning {
			color: #ff6600;
		}

		.card {
			border-radius: 10px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		}

		.card-body {
			padding: 1.5rem;
		}

		/* Optional: Custom text and icon shadow effect */
		.shadow-lg {
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
		}


		@media (max-width: 425px) {
			.page-wrapper .page-content {
				padding: 1rem !important;
			}
		}

		@media (max-width: 910px) {

			.card-body {
				padding: 0.7rem;
			}

			.card-body h6 {
				font-size: 15px !important;
			}

			.widgets-icons {
				width: 50px !important;
				height: 50px !important;
			}

			.widgets-icons i {
				font-size: 25px !important;
			}

		}


		@media (max-width: 1024px) {
			.sidebar-wrapper .sidebar-header {
				justify-content: start;
			}

			.row-graph-card {
				flex-wrap: wrap;
				flex-direction: column-reverse;
			}
		}


		@media (min-width: 1025px) and (max-width: 1199px) {

			.card-body {
				padding: 0.7rem;
			}


			.card-body h6 {
				font-size: 15px !important;
			}

			.widgets-icons {
				width: 50px !important;
				height: 50px !important;
			}

			.widgets-icons i {
				font-size: 25px !important;
			}
		}

		@media (min-width: 1200px) and (max-width: 1280px) {

			.card-body {
				padding: 0.7rem;
			}


			.card-body h6 {
				font-size: 15px !important;
			}

			.widgets-icons {
				width: 50px !important;
				height: 50px !important;
			}

			.widgets-icons i {
				font-size: 25px !important;
			}
		}

		@media (min-width: 1280px) and (max-width: 1444px) {

			.card-body {
				padding: 1.31rem;
			}


			.card-body h6 {
				font-size: 15px !important;
			}

			.widgets-icons {
				width: 50px !important;
				height: 50px !important;
			}

			.widgets-icons i {
				font-size: 25px !important;
			}
		}
	</style>

</head>

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
				<div class="row row-cols-1  row-cols-xl-3">
					<div class="col col-sm-12 col-md-4 col-lg-4 col-xl-4">
						<div class="card radius-10 card-hover">
							<?php if ($role == '1' || $role == '3') {
							?>
								<div class="card-body" style="cursor:pointer;"
									onclick="window.location.href='card_emp.php'">
									<div class="d-flex align-items-center">
										<div>

											<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
												Total Employees
												<span class="info-icon">
													<i class='bx bx-info-circle'></i>
													<span class="tooltip-text">Shows the total number of employees in the company.</span>
												</span>
											</h6>

											<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $employee_count; ?>" >
											</span>
										</div>
										<div class="ms-auto">
											<div class="widgets-icons bg-gradient-danger text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
												<i class='bx bx-group fs-2'></i>
											</div>
										</div>
									</div>
								</div>
							<?php } else {
							?>
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
												Total Employees
												<span class="info-icon">
													<i class='bx bx-info-circle'></i>
													<span class="tooltip-text">Shows the total number of employees in the company.</span>
												</span>
											</h6>

											<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $employee_count; ?>" >
										</div>
										<div class="ms-auto">
											<div class="widgets-icons bg-gradient-danger text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
												<i class='bx bx-group fs-2'></i>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="col col-sm-12 col-md-4 col-lg-4 col-xl-4">
						<div class="card card-hover">
							<?php if ($role == '1' || $role == '3') {
							?>
								<div class="card-body" style="cursor:pointer;"
									onclick="window.location.href='card_vendor.php'">
									<div class="d-flex align-items-center">
										<div>
											<!-- <h6 class="my-1 text-secondary"></h5> -->

											<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
												Total Vendors
												<span class="info-icon">
													<i class='bx bx-info-circle'></i>
													<span class="tooltip-text">Shows the total numbers of vendors.</span>
												</span>
											</h6>
											<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $vendor_count; ?>">
											</span>
										</div>
										<div class="ms-auto">
											<div class="widgets-icons bg-gradient-warning text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
												<i class='bx bx-store fs-2'></i>
											</div>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<!-- <h6 class="my-1 text-secondary"></h5> -->

											<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
												Total Vendors
												<span class="info-icon">
													<i class='bx bx-info-circle'></i>
													<span class="tooltip-text">Shows the total numbers of vendors.</span>
												</span>
											</h6>
											<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $vendor_count; ?>">
										</div>
										<div class="ms-auto">
											<div class="widgets-icons bg-gradient-warning text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
												<i class='bx bx-store fs-2'></i>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>

					<div class="col col-sm-12 col-md-4 col-lg-4 col-xl-4">
						<div class="card radius-10 card-hover">
							<div class="card-body" style="cursor:pointer;"
								onclick="window.location.href='card_total_request.php'">
								<div class="d-flex align-items-center">
									<div class="">
										<!-- <h6 class="my-1 text-secondary">Total Requests </h4> -->

										<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
											Total Requests
											<span class="info-icon">
												<i class='bx bx-info-circle'></i>
												<span class="tooltip-text">New employee requests for record addition.</span>
											</span>
										</h6>
										<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $total_request_count; ?>">
										</span>
									</div>
									<div class="ms-auto">
										<div class="widgets-icons bg-gradient-success1 text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
											<i class='bx bx-receipt fs-2'></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>




				</div>
				<!--end row old -->
				<div class="row row-graph-card">
					<div class="col-xl-8">
						<div class="row">
							<div class="col-12 col-md-6 col-xl-6 d-flex">
								<div class="card radius-10 w-100 ">
									<div class="card-body pb-0">
										<div class="d-flex align-items-center">
											<div>
												<h5 class="mb-0 d-flex align-items-center">
													<i class='bx bx-store-alt fs-4 me-2'></i>
													Today's Vendors Insights
												</h5>
											</div>
											<div class="dropdown ms-auto">
											</div>
										</div>
										<div class="mt-3" id="chart160"></div>
									</div>
									<ul class="list-group list-group-flush">
										<?php if ($role == '1' || $role == '3') {
										?>
											<?php
											$i = 0;
											while ($row = mysqli_fetch_assoc($result_vendor_daily)) {
												$color = $colors[$i % count($colors)];
											?>
												<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center" style="font-weight:500">
													<?php echo $row['name']; ?>

													<span class="badge rounded-pill" style="background-color: <?php echo $color; ?>; color:#fff;">
														<?php echo $row['total']; ?>
													</span>
												</li>
											<?php
												$i++;
											}
											?>
										<?php } else { ?>
											<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center" style="font-weight:500">
												<?php echo $_SESSION['name']; ?>
												<span class="badge bg-danger rounded-pill"><?php echo $food_count; ?></span>
											</li>
										<?php } ?>
										<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center" style="font-weight:500">
											Total
											<span class="badge bg-info text-dark rounded-pill">
												<?php
												echo $food_count;
												?>
											</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-12 col-md-6 col-xl-6 d-flex">
								<div class="card radius-10 w-100">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div>
												<h5 class="mb-0 d-flex align-items-center">
													<i class='bx bx-dish fs-3 me-2'></i>
													Today's Meal Insights
												</h5>


											</div>
											<div class="dropdown ms-auto">
											</div>
										</div>
										<div class="m-3" id="chart15"></div>
									</div>
									<ul class="list-group list-group-flush">
										<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center" style="font-weight:500">Total Meal Count<span class="badge bg-success rounded-pill"><?php echo $dish_count; ?></span>
										</li>
										<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center" style="font-weight:500">Taken Meal Count<span class="badge bg-danger rounded-pill"><?php echo $food_count; ?></span>
										</li>
										<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center" style="font-weight:500">Remaining Meal Count<span class="badge bg-warning text-dark rounded-pill"><?php echo $remaining;  ?></span>
										<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center" style="font-weight:500">
											Taken Meal Percentage
											<span class="badge bg-info text-dark rounded-pill">
												<?php
												$dish_count = isset($dish_count) ? (int)$dish_count : 0;
												$food_count = isset($food_count) ? (int)$food_count : 0;

												if ($dish_count > 0) {
													$percentage = ($food_count / $dish_count) * 100;
													echo round($percentage, 2) . "%";
												} else {
													echo "0%";
												}
												?>
											</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 ">
						<div class="row">
							<!-- <div class="col-12 col-md-6 col-xl-12">
								<div class="card radius-10">
									<?php if ($role == '1' || $role == '3') {
									?>
										<div class="card-body" style="cursor:pointer;"
											onclick="window.location.href='card_emp.php'">
											<div class="d-flex align-items-center">
												<div>

													<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
														Total Employees
														<span class="info-icon">
															<i class='bx bx-info-circle'></i>
															<span class="tooltip-text">Shows the total number of employees in the company.</span>
														</span>
													</h6>

													<span style="position:relative;font-weight:600;z-index:1;font-size: 28px;"><?php echo $employee_count; ?>
													</span>
												</div>
												<div class="ms-auto">
													<div class="widgets-icons bg-gradient-danger text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
														<i class='bx bx-group fs-2'></i>
													</div>
												</div>
											</div>
										</div>
									<?php } else {
									?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
													<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
														Total Employees
														<span class="info-icon">
															<i class='bx bx-info-circle'></i>
															<span class="tooltip-text">Shows the total number of employees in the company.</span>
														</span>
													</h6>

													<span style="position:relative;font-weight:600;z-index:1;font-size: 28px;"><?php echo $employee_count; ?>
													</span>
												</div>
												<div class="ms-auto">
													<div class="widgets-icons bg-gradient-danger text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
														<i class='bx bx-group fs-2'></i>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div> -->
							<div class="col-12 col-md-6 col-xl-12">
								<?php if ($role == '1' || $role == '3') {
								?>
									<div class="card radius-10 card-hover">
										<div class="card-body" style="cursor:pointer;"
											onclick="window.location.href='card_skipped_meal_count.php'">
											<div class="d-flex align-items-center">
												<div class="">
													<!-- <h6 class="my-1 text-secondary">Today's Skipped Meals</h4> -->

													<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
														Today's Unserved Meals
														<span class="info-icon">
															<i class='bx bx-info-circle'></i>
															<span class="tooltip-text">Shows the total number of employees who have not taken a meal.(4 AM to 4 AM)</span>
														</span>
													</h6>

													<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $skipped_employee_count; ?>" >
													</span>
												</div>
												<div class="ms-auto">
													<!-- Icon Container with Gradient Background -->
													<div class="widgets-icons bg-gradient-success3 text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
														<i class='bx bx-x fs-2'></i>
													</div>

												</div>

											</div>
										</div>
									</div>
								<?php } else { ?>

									<div class="card radius-10 card-hover">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="">
													<!-- <h6 class="my-1 text-secondary">Today's Skipped Meals</h4> -->

													<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
														Today's Unserved Meals
														<span class="info-icon">
															<i class='bx bx-info-circle'></i>
															<span class="tooltip-text">Shows the total number of employees who have not taken a meal.(4 AM to 4 AM)</span>
														</span>
													</h6>

													<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $skipped_employee_count; ?>" >
													</span>
												</div>
												<div class="ms-auto">
													<!-- Icon Container with Gradient Background -->
													<div class="widgets-icons bg-gradient-success3 text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
														<i class='bx bx-x fs-2'></i>
													</div>

												</div>

											</div>
										</div>
									</div>
								<?php } ?>
							</div>


							<div class="col-12 col-md-6 col-xl-12">
								<div class="card radius-10 card-hover" style="cursor:pointer;"
									onclick="window.location.href='card_daily_meal_count.php'">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div>
												<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center;">
													Today's Meals Served
													<span class="info-icon">
														<i class='bx bx-info-circle'></i>
														<span class="tooltip-text">Shows the total meals served today.(4 AM to 4 AM)</span>
													</span>
												</h6>

												<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $food_count; ?>" >
												</span>
											</div>
											<div class="ms-auto">
												<div class="widgets-icons bg-gradient-success text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg"><i class='bx bx-dish'></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="col-12 col-md-6 col-xl-12">
								<div class="card">
									<?php if ($role == '1' || $role == '3') {
									?>
										<div class="card-body" style="cursor:pointer;"
											onclick="window.location.href='card_vendor.php'">
											<div class="d-flex align-items-center">
												<div>
													

													<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
														Total Vendors
														<span class="info-icon">
															<i class='bx bx-info-circle'></i>
															<span class="tooltip-text">Shows the total numbers of vendors.</span>
														</span>
													</h6>
													<span style="position:relative;font-weight:600;z-index:1;font-size: 28px;"><?php echo $vendor_count; ?>
													</span>
												</div>
												<div class="ms-auto">
													<div class="widgets-icons bg-gradient-warning text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
														<i class='bx bx-store fs-2'></i>
													</div>
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
													

													<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
														Total Vendors
														<span class="info-icon">
															<i class='bx bx-info-circle'></i>
															<span class="tooltip-text">Shows the total numbers of vendors.</span>
														</span>
													</h6>
													<span style="position:relative;font-weight:600;z-index:1;font-size: 28px;"><?php echo $vendor_count; ?>
													</span>
												</div>
												<div class="ms-auto">
													<div class="widgets-icons bg-gradient-warning text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
														<i class='bx bx-store fs-2'></i>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div> -->

							<div class="col-12 col-md-6 col-xl-12">
								<div class="card radius-10 card-hover">
									<div class="card-body" style="cursor:pointer;"
										onclick="window.location.href='card_weekly_meal_count.php'">
										<div class="d-flex align-items-center">
											<div class="">
												<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
													Weekly Meals Served
													<span class="info-icon">
														<i class='bx bx-info-circle'></i>
														<span class="tooltip-text">Shows the total meals served in this week.</span>
													</span>
												</h6>
												<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $weekly_meal_count; ?>" >
												</span>
												<!-- <h3 class="my-1 mt-3"><?php echo $weekly_meal_count; ?></h3> -->
											</div>
											<div class="ms-auto">
												<div class="widgets-icons bg-gradient-success2 text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
													<i class='bx bx-calendar-week fs-2'></i>
												</div>
											</div>
										</div>
									</div>
									<!-- <div id="chart13"></div> -->
								</div>
							</div>

							<div class="col-12 col-md-6 col-xl-12">
								<div class="card radius-10 card-hover">

									<div class="card-body" style="cursor:pointer;"
										onclick="window.location.href='card_monthly_meal_count.php'">
										<div class="d-flex align-items-center">
											<div class="">
												<!-- <h6 class="my-1 text-secondary">Monthly Meals Served</h4> -->

												<h6 class="my-1 text-secondary" style="margin: 0; display: flex; align-items: center; ">
													Monthly Meals Served
													<span class="info-icon">
														<i class='bx bx-info-circle'></i>
														<span class="tooltip-text">Shows the total meals served in this month.</span>
													</span>
												</h6>


												<span class="counter" style="position:relative;font-weight:600;z-index:1;font-size: 28px;" data-target="<?php echo $monthly_meal_count ?>" >
												</span>
												<!-- <h3 class="my-1 mt-3"><?php echo $monthly_meal_count ?></h3> -->
											</div>

											<div class="ms-auto">

												<div class="widgets-icons bg-gradient-success4 text-white rounded-circle p-3 d-flex justify-content-center align-items-center shadow-lg">
													<i class='bx bx-calendar fs-2'></i>
												</div>

											</div>

										</div>
									</div>
									<!-- <div id="chart13"></div> -->
								</div>
							</div>





						</div>
					</div>
				</div>


				<!-- new  -->
				<div class="row row-graph-card">
					<div class="col-xl-12 d-flex">
						<div class="card radius-10 w-100">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-1">
											<?php
											if ($role == '1' || $role == '3') {
												echo "Active Vendors Monthly Meals";
											} else {
												echo "My Monthly Meals";
											}
											?>
										</h5>
										<!-- <p class="mb-0 font-13 text-secondary"><i class='bx bxs-calendar'></i>in last 30 days revenue</p> -->
									</div>
								</div>
								<?php
								if ($role == '1' || $role == '3') {
								?> <!--show 3 vendor in a row-->
									<!-- <div class="row row-cols-1 row-cols-sm-3 mt-4"> -->
									<!--show 4 vendor in a row-->
									<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 mt-4">
										<?php
										$vendor_no = 1;
										while ($vendor = mysqli_fetch_assoc($result_vendor_list)) {

										?>
											<div class="col">
												<div>
													<p class="mb-0 text-secondary">Vendor <?php echo $vendor_no; ?></p>

													<span style=" font-style:italic; font-size:16px; font-weight:500;">
														<?php echo $vendor['name']; ?></span>

												</div>
											</div>
										<?php
											$vendor_no++;
										}
										?>
									</div>
								<?php } ?>

								<div id="chart4"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- end -->
				<!--end row-->
				<div class="row">
					<div class="col-xl-12 d-flex">
						<div class="card radius-10 w-100">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-1">Recent Employee Meal List</h5>
										<!-- <p class="mb-0 font-13 text-secondary"><i class='bx bxs-calendar'></i>in last 30 days</p> -->
									</div>
								</div>
								<div class="table-responsive mt-4">
									<?php
									// 12 to 12
									// $current_date = date('Y-m-d');
									// if ($role == '1' || $role == '3') {
									// 	$sql = "SELECT f.emp_id, e.emp_name, v.name, DATE(f.created_at) AS date, TIME(f.created_at) AS time,
									// 'Served' AS status
									// FROM food_entry f 
									// JOIN employee e ON f.emp_id = e.emp_id
									// JOIN user_master v ON f.created_by = v.id
									// WHERE DATE(f.created_at) = '$current_date'
									// ORDER BY time DESC";
									// } else {
									// 	$sql = "SELECT f.emp_id, e.emp_name, v.name, DATE(f.created_at) AS date, TIME(f.created_at) AS time,
									// 'Served' AS status
									// FROM food_entry f 
									// JOIN employee e ON f.emp_id = e.emp_id
									// JOIN user_master v ON f.created_by = v.id
									// WHERE DATE(f.created_at) = '$current_date' AND f.created_by = '$vendor_id'
									// ORDER BY time DESC";
									// }
									// $result = mysqli_query($conn, $sql);

									// 4 to 4
									$current_date = date('Y-m-d');
									if ($role == '1' || $role == '3') {
										$sql = "
												SELECT f.emp_id, e.emp_name, v.name, DATE(f.created_at) AS date, TIME(f.created_at) AS time,
													'Served' AS status
												FROM food_entry f 
												JOIN employee e ON f.emp_id = e.emp_id
												JOIN user_master v ON f.created_by = v.id
												WHERE f.created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 HOUR), '%Y-%m-%d 04:00:00')
												AND f.created_at < DATE_FORMAT(DATE_ADD(DATE_SUB(NOW(), INTERVAL 4 HOUR), INTERVAL 1 DAY), '%Y-%m-%d 04:00:00')
												ORDER BY time DESC
											";
									} else {
										$sql = "
												SELECT f.emp_id, e.emp_name, v.name, DATE(f.created_at) AS date, TIME(f.created_at) AS time,
													'Served' AS status
												FROM food_entry f 
												JOIN employee e ON f.emp_id = e.emp_id
												JOIN user_master v ON f.created_by = v.id
												WHERE f.created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 HOUR), '%Y-%m-%d 04:00:00')
												AND f.created_at < DATE_FORMAT(DATE_ADD(DATE_SUB(NOW(), INTERVAL 4 HOUR), INTERVAL 1 DAY), '%Y-%m-%d 04:00:00')
												AND f.created_by = '$vendor_id'
												ORDER BY time DESC
											";
									}
									$result = mysqli_query($conn, $sql);
									?>
									<table class="table align-middle mb-0 table-hover" id="Transaction-History">
										<thead class="table-light">
											<tr>
												<th>Employee id</th>
												<th>Employee Name</th>
												<th>Vendor Name</th>
												<th>Date</th>
												<th>Time</th>
											</tr>
										</thead>
										<tbody>
											<?php
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<tr>';
												echo '<td>' . htmlspecialchars($row['emp_id']) . '</td>';
												echo '<td>' . htmlspecialchars($row['emp_name']) . '</td>';
												echo '<td>' . htmlspecialchars($row['name']) . '</td>';
												echo '<td>' . htmlspecialchars(date('d M Y', strtotime($row['date']))) . '</td>';
												echo '<td>' . htmlspecialchars(date('H:i:s', strtotime($row['time']))) . '</td>';
												echo '</tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="col-12 col-xl-5 d-flex">
						<div class="card radius-10 w-100">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-0">Summary Report</h5>
									</div>
									<div class="dropdown ms-auto">	
									</div>
								</div>
								<div class="mt-5" id="chart15"></div>
							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Total Employees <span class="badge bg-success rounded-pill"><?php echo $employee_count; ?></span>
								</li>
								<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center"><?php echo $_SESSION['name']; ?><span class="badge bg-danger rounded-pill"><?php echo $food_count; ?></span>
								</li>
								<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Remaning Employee<span class="badge bg-warning text-dark rounded-pill"><?php echo $skipped_employee_count; ?></span>
								<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Total Percentage
									<span class="badge bg-info text-dark rounded-pill">
										<?php
										if ($employee_count > 0) {
											echo round(($food_count / $employee_count) * 100, 2);
										} else {
											echo "0.00";
										}
										?>
									</span>
								</li>
							</ul>
						</div>
					</div> -->
				</div>
				<!--end row-->

				<!--end row-->
				<!-- <div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<h5 class="mb-0">Recent 10 Employee Meal List</h5>
							</div>
						</div>
						<hr />
						<div class="table-responsive">
							<?php
							$current_date = date('Y-m-d');
							if ($role == '1' || $role == '3') {
								$sql = "SELECT f.emp_id, e.emp_name, v.name, DATE(f.created_at) AS date, TIME(f.created_at) AS time,
									'Served' AS status
									FROM food_entry f 
									JOIN employee e ON f.emp_id = e.emp_id
									JOIN user_master v ON f.created_by = v.id
									WHERE DATE(f.created_at) = '$current_date'
									ORDER BY time DESC LiMIT 10 ";
							} else {
								$sql = "SELECT f.emp_id, e.emp_name, v.name, DATE(f.created_at) AS date, TIME(f.created_at) AS time,
									'Served' AS status
									FROM food_entry f 
									JOIN employee e ON f.emp_id = e.emp_id
									JOIN user_master v ON f.created_by = v.id
									WHERE DATE(f.created_at) = '$current_date' AND f.created_by = '$vendor_id'
									ORDER BY time DESC LIMIT 10 ";
							}
							$result = mysqli_query($conn, $sql);
							?>
							<table class="table align-middle mb-0">
								<thead class="table-light">
									<tr>
										<th>Employee id</th>
										<th>Employee Name</th>
										<th>Vendor Name</th>
										<th>Date</th>
										<th>Time</th>
										<th>Status</th>
									</tr>
								</thead>
							   <tbody>
									<?php
									while ($row = mysqli_fetch_assoc($result)) {
										echo '<tr>';
										echo '<td>' . htmlspecialchars($row['emp_id']) . '</td>';
										echo '<td>' . htmlspecialchars($row['emp_name']) . '</td>';
										echo '<td>' . htmlspecialchars($row['name']) . '</td>';
										echo '<td>' . htmlspecialchars(date('d M Y', strtotime($row['date']))) . '</td>';
										echo '<td>' . htmlspecialchars(date('H:i:s', strtotime($row['time']))) . '</td>';
										echo '<td><span class="badge bg-success">Served</span></td>';
										echo '</tr>';
									}
									?>
    							</tbody>
							</table>
						</div>
					</div>
				</div> -->
				<!--end row-->

			</div>
		</div>



		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay mobile-toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		<!-- <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a> -->
		<!--End Back To Top Button-->
		<?php include("api/footer.php"); ?>
	</div>
	<!--end wrapper-->


	<!-- search modal -->

	<!-- end search modal -->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

	<script src="assets/js/index2.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>


	<!-- Graph No.1 Start -->
	<script>
		var seriesData = [];

		<?php if ($role == '1' || $role == '3') { ?>

			<?php foreach ($vendors as $vendorName => $data) { ?>
				seriesData.push({
					name: "<?php echo $vendorName; ?>",
					data: <?php echo json_encode(array_values($data)); ?>
				});
			<?php } ?>

		<?php } else { ?>

			seriesData.push({
				name: "My Meals",
				data: <?php echo json_encode(array_values($monthly_data)); ?>
			});

		<?php } ?>
	</script>

	<script>
		var options = {
			series: seriesData,
			chart: {
				type: "bar",
				height: 300,
				toolbar: {
					show: false
				}
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: "55%",
					endingShape: "rounded"
				}
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ["transparent"]
			},
			colors: ["#0dcaf0", "#0d6efd", "#ffc107", "#20c997", "#dc3545"], // auto multi color
			xaxis: {
				categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
			},
			grid: {
				show: true,
				borderColor: 'rgba(0,0,0,0.15)',
				strokeDashArray: 4
			},
			tooltip: {
				y: {
					formatter: function(val) {
						return val + " meals";
					}
				}
			}
		};

		new ApexCharts(document.querySelector("#chart4"), options).render();
	</script>
	<!-- Graph No.1 End -->



	<!-- Graph No.2 start -->
	<script>
		// First Chart (Meal Count)
		var todayMeals = <?php echo $food_count; ?>;
		var remainingMeals = <?php echo $remaining; ?>;

		var e1 = {
			series: [todayMeals, remainingMeals], // First slice = meals eaten, second = remaining
			chart: {
				height: 280, // Set height to 280px
				type: "donut"
			},
			legend: {
				position: "bottom",
				show: false // Hide the legend
			},
			plotOptions: {
				pie: {
					donut: {
						size: "70%", // Increase donut hole size (larger hole)
						labels: {
							show: true,
							total: {
								show: true,
								label: 'Meal Count',
								fontSize: '20px', // Increased font size for the center label
								fontWeight: 500,
								formatter: function(w) {
									return todayMeals; // Display todayMeals in the center
								}
							}
						}
					}
				}
			},
			colors: ["#1c9a3e", "#d52d1d"], // Green = Eaten, Red = Remaining
			dataLabels: {
				enabled: true,
				formatter: function(val, opts) {
					return opts.w.config.series[opts.seriesIndex]; // Show count instead of %
				}
			},
			labels: ["Total Meal Count", "Remaining Count"],
			responsive: [{
				breakpoint: 480, // When screen width is 480px or less
				options: {
					chart: {
						height: 300 // Reduced chart height for smaller screens
					},
					legend: {
						position: "bottom" // Move the legend to the bottom for smaller screens
					}
				}
			}]
		};

		new ApexCharts(document.querySelector("#chart15"), e1).render();


		// Second Chart (Vendor Meal Count)
		var vendorSeries = <?php echo json_encode($vendor_counts); ?>;
		var vendorLabels = <?php echo json_encode($vendor_names); ?>;
		var colors = <?php echo json_encode($colors); ?>;

		var allZero = vendorSeries.every(val => val === 0); // Check if all values are 0

		// Use dummy values if all values are zero
		var displaySeries = allZero ? vendorSeries.map(() => 1) : vendorSeries;

		var totalMeals = vendorSeries.reduce((a, b) => a + b, 0);

		var e2 = {
			series: displaySeries,
			chart: {
				height: 280, // Set the same height as the first chart
				type: "donut",
				width: '100%' // Set width to 100% for responsiveness
			},
			labels: vendorLabels,
			colors: colors.slice(0, vendorSeries.length),
			plotOptions: {
				pie: {
					donut: {
						size: "70%", // Increase donut hole size (larger hole)
						labels: {
							show: true,
							total: {
								show: true,
								label: "Meal Count",
								fontSize: '20px', // Increased font size for the center label
								fontWeight: 500,
								formatter: function() {
									return totalMeals; // Display total meals in the center
								}
							}
						}
					}
				}
			},
			dataLabels: {
				enabled: true,
				formatter: function(val, opts) {
					return vendorSeries[opts.seriesIndex]; // Show actual values (meal count)
				}
			},
			tooltip: {
				y: {
					formatter: function(val, opts) {
						return vendorSeries[opts.seriesIndex]; // Show actual value in the tooltip
					}
				}
			},
			legend: {
				show: false
			},
			responsive: [{
				breakpoint: 480, // When screen width is 480px or less
				options: {
					chart: {
						height: 300 // Reduced chart height for smaller screens
					},
					legend: {
						position: "bottom" // Move the legend to the bottom for smaller screens
					}
				},
			}]
		};

		new ApexCharts(document.querySelector("#chart160"), e2).render();
		
	</script>


<script>
	document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".counter");

  counters.forEach(counter => {
    counter.innerText = "0";

    const updateCounter = () => {
      const target = +counter.getAttribute("data-target");
      const current = +counter.innerText;

      const increment = Math.ceil(target / 100); // speed control

      if (current < target) {
        counter.innerText = current + increment;
        setTimeout(updateCounter, 30);
      } else {
        counter.innerText = target;
      }
    };

    updateCounter();
  });
});
</script>

</body>

</html>