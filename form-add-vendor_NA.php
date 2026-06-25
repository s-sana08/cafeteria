<?php
include('api/config.php');
// 2. Query data
$query = "SELECT * FROM  food_type_master ORDER BY food_type_name ASC"; // Replace 'products' and 'product_name'
$results = mysqli_query($conn, $query);


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
	
	<link href="assets/sass/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/sass/dark-theme.css">
	<link rel="stylesheet" href="assets/sass/semi-dark.css">
	<link rel="stylesheet" href="assets/sass/bordered-theme.css">
	<title>Cafeteria | Management System</title>
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
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Forms</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Validations</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				<div class="row">
                    <div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header px-4 py-3">
								<h5 class="mb-0">Add Vendor</h5>
							</div>
							<div class="card-body p-4">
								<div id="msg"></div>
								<form id="submit_form" method="POST" action="">
									<div class="row mb-3">
										<label for="input35" class="col-sm-3 col-form-label">Enter Vendor name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="name" name="name" placeholder="Enter Vendor name" required>
										</div>
									</div>
									<div class="row mb-3">
										<label for="input36" class="col-sm-3 col-form-label">Username</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
										</div>
									</div>
									<div class="row mb-3">
										<label for="input37" class="col-sm-3 col-form-label">password</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="password" name="password" placeholder="Enter Password" required>
										</div>
									</div>
									<div class="row mb-3">
										<label for="input37" class="col-sm-3 col-form-label">Email Address</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email Address" required>
										</div>
									</div>
									<div class="row mb-3">
										<label for="input39" class="col-sm-3 col-form-label">Food Type</label>
										<div class="col-sm-9">
											<select class="form-select" id="food_type_id" name="food_type_id" required>
												<?php
													while ($row = mysqli_fetch_assoc($results)) 
													{
														echo '<option value="'.htmlspecialchars($row['id']).'">'
														.htmlspecialchars($row['food_type_name']).'</option>';
													}
													?>
											  </select>
										</div>
									</div>
									<div class="row">
										<label class="col-sm-3 col-form-label"></label>
										<div class="col-sm-9">
											<div class="d-md-flex d-grid align-items-center gap-3">
												<button type="submit"  id="submit" class="btn btn-primary px-4" name="submit">Submit</button>
												<button type="reset" class="btn btn-light px-4">Reset</button>
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
								<h5 class="mb-0">Vendor Details</h5>
							</div>
							<div class="card-body p-4">
								<div class="table-responsive">
									<table id="example2" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Sr.No.</th>
												<th>Vendor Name</th>
												<th>Username</th>
												<th>Password</th>
												<th>Email Address</th>
												<th>Food Type</th>
												<th>Edit</th>
												<th>Active/Inactive</th>
											</tr>
										</thead>
    									<tbody>
											<?php
											$sql = "SELECT u.*, f.food_type_name 
													FROM user_master u
													LEFT JOIN food_type_master f ON u.food_type_id = f.id
													ORDER BY u.id DESC";

											$result = mysqli_query($conn, $sql);
											$i = 1;

											while($row = mysqli_fetch_assoc($result)){
												$status = ($row['status'] == 1) ? 'checked' : '';
												$color = ($row['status'] == 1) ? 'success' : 'danger';
											?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo htmlspecialchars($row['name']); ?></td>
												<td><?php echo htmlspecialchars($row['username']); ?></td>
												<td><?php echo htmlspecialchars($row['password']); ?></td>
												<td><?php echo htmlspecialchars($row['email_id']); ?></td>
												<td><?php echo htmlspecialchars($row['food_type_name']); ?></td>
												<td>
													<div class="d-flex order-actions">
														<a href="javascript:void(0);" class="edit-vendor" data-id="<?php echo $row['id']; ?>">
															<i class='bx bxs-edit'></i>
														</a>
													</div>
												</td>
												<td>
													<!-- <div class="form-check form-switch">
														<input class="form-check-input toggle-status" type="checkbox" data-id="<?php echo $row['id']; ?>" <?php echo $status; ?>>
													</div> -->

													<div class="form-check form-switch">
														<input class="form-check-input toggle-status <?php echo ($row['status']==1)?'bg-success':'bg-danger'; ?>" 
														type="checkbox" data-id="<?php echo $row['id']; ?>" <?php echo ($row['status']==1)?'checked':''; ?>>
													</div>
												</td>
											</tr>
											<?php } ?>
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
		<!--Start Back To Top Button-->
		 <!-- <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a> -->
		<!--End Back To Top Button-->
		<?php include("api/footer.php"); ?>
	</div>
	<!--end wrapper-->



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<script>
$(document).ready(function(){

    var editId = null;

    // Populate form when Edit clicked (delegate for dynamic rows)
    $('#example2').on('click', '.edit-vendor', function(){
        editId = $(this).data('id');

        $.ajax({
            url: 'api/get_vendor.php',
            type: 'POST',
            data: {id: editId},
            dataType: 'json',
            success: function(data){
                $('#name').val(data.name);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#email_id').val(data.email_id);
                $('#food_type_id').val(data.food_type_id);
            }
        });
    });

    // Handle form submit (insert/update)
    $("#submit_form").on("submit", function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        if(editId) formData += '&id=' + editId;

        $.ajax({
            url: "api/insert_vendor.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response){
                if(response.status == "success"){
                    $("#msg").html('<div class="alert alert-success">Vendor saved successfully!</div>');

                    // Reset form
                    $("#submit_form")[0].reset();
                    editId = null;

                    // Update table
                    if(response.action == "insert"){
                        // Add new row
                        $('#example2 tbody').prepend(renderRow(response.data));
                    } else if(response.action == "update"){
                        // Replace existing row
                        $('#row_'+response.data.id).replaceWith(renderRow(response.data));
                    }

                } else {
                    $("#msg").html('<div class="alert alert-danger">'+response.message+'</div>');
                }

                setTimeout(function(){
                    $("#msg").fadeOut('slow', function(){ $(this).html('').show(); });
                }, 2000);
            }
        });
    });

    // Function to render table row
    function renderRow(vendor){
        var status = (vendor.status == 1) ? 'checked' : '';
        var color = (vendor.status == 1) ? 'bg-success' : 'bg-danger';

        return `
            <tr id="row_${vendor.id}">
                <td>#</td>
                <td>${vendor.name}</td>
                <td>${vendor.username}</td>
                <td>${vendor.password}</td>
                <td>${vendor.email_id}</td>
                <td>${vendor.food_type_name}</td>
                <td>
                    <div class="d-flex order-actions">
                        <a href="javascript:void(0);" class="edit-vendor" data-id="${vendor.id}">
                            <i class='bx bxs-edit'></i>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status ${color}" 
                               type="checkbox" data-id="${vendor.id}" ${status}>
                    </div>
                </td>
            </tr>
        `;
    }

});
</script>

<!-- <script>
$(document).ready(function(){

    $('.toggle-status').on('change', function(){
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: 'api/update_vendor_status.php',
            type: 'POST',
            data: {id: id, status: status},
            success: function(response){
                if(status == 1){
                    alert('Vendor Activated');
                } else {
                    alert('Vendor Deactivated');
                }
            }
        });
    });

});
</script> -->


<script>
$(document).ready(function(){

    $('.toggle-status').on('change', function(){
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        var switchEl = $(this);

        $.ajax({
            url: 'api/update_vendor_status.php',
            type: 'POST',
            data: {id: id, status: status},
            success: function(response){
                // Color Change 
                if(status == 1){
                    switchEl.removeClass('bg-danger').addClass('bg-success');
                } else {
                    switchEl.removeClass('bg-success').addClass('bg-danger');
                }
            }
        });
    });

});
</script>





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
	</script>

	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: ['excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>


	


</body>

</html>