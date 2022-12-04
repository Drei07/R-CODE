<?php
include_once '../../database/dbconfig2.php';
require_once 'authentication/user-class.php';
include_once "../superadmin/controller/select-settings-configuration-controller.php";


$user_home = new USER();

if (!$user_home->is_logged_in()) {
	$user_home->redirect('../../');
}

$stmt = $user_home->runQuery("SELECT * FROM user WHERE userId=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$profile_user 				= $row['userProfile'];
$name 						= $row['userLast_Name'] . ', ' . $row['userFirst_Name'];

$userId	=	$_GET['Id'];

$pdoQuery = "SELECT * FROM admin WHERE userId=$userId";
$pdoResult = $pdoConnect->prepare($pdoQuery);
$pdoExec = $pdoResult->execute();
$admin_profile = $pdoResult->fetch(PDO::FETCH_ASSOC);


$profile_admin 				= $admin_profile['adminProfile'];
$first_name                 = $admin_profile["adminFirst_Name"];
$middle_name                = $admin_profile["adminMiddle_Name"];
$last_name                  = $admin_profile["adminLast_Name"];
$email 						= $admin_profile["adminEmail"];
$address					= $admin_profile["address"];
$business_name				= $admin_profile["business_name"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../src/img/<?php echo $logo ?>">
	<link rel="stylesheet" href="../../src/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../src/node_modules/boxicons/css/boxicons.min.css">
	<link rel="stylesheet" href="../../src/node_modules/aos/dist/aos.css" />
	<link rel="stylesheet" href="../../src/css/admin.css?v=<?php echo time(); ?>">
	<title>Seller Information</title>
</head>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar" class="hide">
		<a href="#" class="brand"><img src="../../src/img/<?php echo $logo ?>" alt="logo" class="brand-img"></i>&nbsp;&nbsp;FSR</a>
		<ul class="side-menu">
			<li><a href="home"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar'></i>
			<span class="divider"></span>
			<div class="dropdown">
				<span><?php echo $name ?></i></span>
			</div>
			<div class="profile">
				<img src="../../src/img/<?php echo $profile_user ?>" alt="">
				<ul class="profile-link">
					<li><a href="profile"><i class='bx bxs-user-circle icon'></i> Profile</a></li>
					<li><a href="authentication/user-signout" class="btn-signout"><i class='bx bxs-log-out-circle'></i> Signout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Seller Profile</h1>
			<ul class="breadcrumbs">
				<li><a href="home">Home</a></li>
				<li class="divider">|</li>
				<li><a href="" class="active">Seller Profile</a></li>

			</ul>

			<!-- PROFILE CONFIGURATION -->

			<section class="profile-form">
				<div class="header"></div>
				<div class="profile">
					<div class="profile-img">
						<img src="../../src/img/<?php echo $profile_admin ?>" alt="logo">

						<label for="" style="font-weight: bold; font-size: 20px; text-align: center;"><?php echo $business_name ?></label>
					</div>

					<div id="Edit">
						<form action="" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
							<div class="row gx-5 needs-validation">

								<label class="form-label" style="text-align: left; padding-top: .5rem; padding-bottom: 1rem; font-size: 1rem; font-weight: bold;"><i class='bx bxs-user'></i> Seller Profile</label>

								<div class="col-md-6">
									<label for="first_name" class="form-label">First Name</label>
									<input type="text" disabled class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="FName" id="first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required value="<?php echo $first_name ?>">
									<div class="invalid-feedback">
										Please provide a First Name.
									</div>
								</div>

								<div class="col-md-6">
									<label for="middle_name" class="form-label">Middle Name</label>
									<input type="text" disabled class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="MName" id="middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="<?php echo $middle_name ?>">
									<div class="invalid-feedback">
										Please provide a Middle Name.
									</div>
								</div>

								<div class="col-md-6">
									<label for="last_name" class="form-label">Last Name</label>
									<input type="text" disabled class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="LName" id="last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required value="<?php echo $last_name ?>">
									<div class="invalid-feedback">
										Please provide a Last Name.
									</div>
								</div>

								<div class="col-md-6">
									<label for="email" class="form-label">Email</label>
									<input disabled type="email" class="form-control" autocapitalize="off" autocomplete="off" name="Email" id="email" required placeholder="<?php echo $email ?>">
									<div class="invalid-feedback">
										Please provide a valid Email.
									</div>
								</div>

								<div class="col-md-12" style="opacity: 0; padding-bottom: 1.3rem;">
									<label for="sname" class="form-label">Old Password<span> *</span></label>
									<input type="text" class="form-control" autocapitalize="on" autocomplete="off">
									<div class="invalid-feedback">
										Please provide a Old Password.
									</div>
								</div>


							</div>

						</form>
					</div>
			</section><br>
			
			<h1 class="title">Products</h1>
			<div class="dashboard-data-products">


				<?php
				$pdoQuery = "SELECT * FROM product_list WHERE admin_id =$userId AND product_status = :product_status";
				$pdoResult3 = $pdoConnect->prepare($pdoQuery);
				$pdoExec = $pdoResult3->execute(array(":product_status" => "active"));
				$total_data = $pdoResult3->rowCount();


				if ($total_data > 0){

				while ($product_data = $pdoResult3->fetch(PDO::FETCH_ASSOC)) {
					$product_image = $product_data['product_image'];

				?>

						<div class="dashboard-card-products">
							<div class="list" onclick="location.href='products-details?Id=<?php echo $product_data['product_id'] ?>'">
								<div>
									<img src="../../src/img/<?php echo $product_image ?>" alt="">
									<h1><?php echo $product_data['product_name']; ?></h1>
									<p><?php echo $product_data['product_descriptions']; ?></p>
									<p>Availability :</p>
									<?php

									if($product_data['start_datetime'] == NULL || $product_data['end_datetime'] == NULL){
									?>
										<p style="font-weight: bold; color: red;">Not Available</p>
									<?php

									}else{
									?>
										<p style="font-weight: bold;"><?php echo date("F d", strtotime($product_data['start_datetime'])) ?> to <?php echo date("F d, Y", strtotime($product_data['end_datetime'])) ?></p>
									<?php
									}
									?>
									<label for="">₱ <?php echo $product_data['product_price']; ?> per kg.</label>
								</div>
							</div>
						</div>

				<?php
					}
				}
				else{
				?>
				
				<div class="no-data">
                        <h3>NO PRODUCTS AVAILABLE</h3>
                	</div>
				<?php
				}
				?>

			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- END NAVBAR -->


	<script src="../../src/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../src/node_modules/jquery/dist/jquery.min.js"></script>
	<script src="../../src/js/dashboard.js"></script>

	<script>
		// Signout
		$('.btn-signout').on('click', function(e) {
			e.preventDefault();
			const href = $(this).attr('href')

			swal({
					title: "Signout?",
					text: "Are you sure do you want to signout?",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willSignout) => {
					if (willSignout) {
						document.location.href = href;
					}
				});
		})
	</script>

	<!-- SWEET ALERT -->
	<?php

	if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
	?>
		<script>
			swal({
				title: "<?php echo $_SESSION['status_title']; ?>",
				text: "<?php echo $_SESSION['status']; ?>",
				icon: "<?php echo $_SESSION['status_code']; ?>",
				button: false,
				timer: <?php echo $_SESSION['status_timer']; ?>,
			});
		</script>
	<?php
		unset($_SESSION['status']);
	}
	?>
</body>

</html>