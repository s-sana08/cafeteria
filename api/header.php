<?php
include_once('api/show_request_operation.php'); 
?>

	<header>
		<div class="topbar">
			<nav class="navbar navbar-expand gap-2 align-items-center">
				<div class="mobile-toggle-menu d-flex"><i class='bx bx-menu'></i></div>
				<div class="top-menu ms-auto">
					<ul class="navbar-nav align-items-center gap-1">
						<li class="nav-item dark-mode d-none d-sm-flex">
							<a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
							</a>
						</li> 
						<?php if(isset($_SESSION['emp_role']) && $_SESSION['emp_role'] == "Admin" || $_SESSION['emp_role'] == "SuperAdmin") { ?>

					<li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown">
<span class="alert-count" id="requestCount"><?php echo $notif_count; ?></span>                            <i class='bx bx-bell'></i>
                        </a>  
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Pending Employee Requests</p>
<p class="msg-header-badge">
    <span id="requestCountText"><?php echo $notif_count; ?></span> New
</p>                                </div>
                            </a> 

                            <div class="header-notifications-list">
                                <?php
                                if(count($pending_requests) > 0){
                                    foreach($pending_requests as $row){
                                        $vendor_name = htmlspecialchars($row['vnd_name']);
                                        $emp_id = htmlspecialchars($row['emp_id']);
                                        $time = date('h:i A', strtotime($row['created_at']));
                                        // echo '<a class="dropdown-item" href="javascript:;">
                                        //         <div class="d-flex align-items-center">
                                        //             <div class="flex-grow-1">
                                        //                 <h6 class="msg-name">'.$vendor_name.'<span class="msg-time float-end">'.$time.'</span></h6>
                                        //                 <p class="msg-info">'.$emp_id.'</p>
                                        //             </div>
                                        //         </div>
                                        //       </a>';

										echo '<a class="dropdown-item" href="set_emp_session.php?emp_id='.$emp_id.'">
											<div class="d-flex justify-content-between">
												
												<!-- Left side labels -->
												<div>
													<div class="msg-label" style="font-weight:500;">Request Time:</div>
													<div class="msg-label" style="font-weight:500;">Vendor Name:</div>
													<div class="msg-label" style="font-weight:500;">Employee ID:</div>
												</div>

												<!-- Right side values -->
												<div class="text-end">
													<div class="msg-header-1">'.$time.'</div>
													<div class="msg-name">'.$vendor_name.'</div>
													<div class="badge bg-warning text-dark rounded-pill" >'.$emp_id.'</div>
												</div>
											</div>
										</a>';
                                    }
                                } else {
                                    echo '<p class="text-center p-2">No pending requests</p>';
                                }
                                ?>
                            </div>

                            <a href="show_request.php">
                                <div class="text-center msg-footer">
                                    <button class="btn btn-primary w-100">Show All Requests</button>
                                </div>
                            </a>
                        </div>
                    </li>

					<?php } ?>


						<li class="nav-item dropdown dropdown-app">
							<!-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" href="javascript:;"><i class='bx bx-grid-alt'></i></a> -->
							<div class="dropdown-menu dropdown-menu-end p-0">
								<div class="app-container p-2 my-2">
									
								</div>
							</div>
						</li> 

						<li class="nav-item dropdown dropdown-large">
							<!-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown"><span class="alert-count">7</span>
								<i class='bx bx-bell'></i>
							</a> -->
							<div class="dropdown-menu dropdown-menu-end">
								
								<div class="header-notifications-list">
									
								</div>
							
							</div>
						</li>

						<li class="nav-item dropdown dropdown-large">
							<!-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
								<i class='bx bx-shopping-bag'></i>
							</a> -->
							<div class="dropdown-menu dropdown-menu-end">
								<!-- <a href="javascript:;">
									<div class="msg-header">
										<p class="msg-header-title">My Cart</p>
										<p class="msg-header-badge">10 Items</p>
									</div>
								</a> -->
								<div class="header-message-list">
									
								</div>
							
							</div>
						</li>
					</ul>
				</div>
				<div class="user-box dropdown px-3">
					<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="assets/images/dark.png" class="user-img" alt="user avatar">
						<div class="user-info">
								<p class="user-name mb-0"><?php echo $_SESSION['name']; ?></p>
								<p class="designattion mb-0">
									<?php
									if(isset($_SESSION['role'])){
										echo ($_SESSION['role'] == 1) 
											? "Admin" 
											: (($_SESSION['role'] == 3) ? "SuperAdmin" : "Vendor");
									}
									?>
								</p>
						</div>
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item d-flex align-items-center" href="user-profile.php"><i class="bx bx-user fs-5"></i><span>Profile</span></a></li>
						<li><a class="dropdown-item d-flex align-items-center " href="change-password.php"><i class="bx bx-lock fs-5"></i><span>Change Password</span></a></li>
						
						
						<li><div class="dropdown-divider mb-0"></div></li>
						<li><a class="dropdown-item d-flex align-items-center" href="auth-logout.php"><i class="bx bx-log-out-circle fs-5"></i><span>Logout</span></a></li>
					</ul>
				</div>
				</nav>
			</div>
					
	<script>
let theme = localStorage.getItem("theme");
if(theme){
document.documentElement.setAttribute("data-bs-theme", theme);
}
</script>
		</header>


