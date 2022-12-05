<?php
include_once '../../database/dbconfig2.php';
include_once '../../src/API/api.php';
require_once 'authentication/user-class.php';
include_once '../superadmin/controller/select-settings-configuration-controller.php';


$user_home = new USER();

if (!$user_home->is_logged_in()) {
  $user_home->redirect('../../');
}

$stmt = $user_home->runQuery("SELECT * FROM user WHERE userId=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $row['userLast_Name'] . ', ' . $row['userFirst_Name'];
$user_profile = $row['userProfile'];

$product_id = $_GET['Id'];
$pdoQuery = "SELECT * FROM product_list WHERE product_id=$product_id";
$pdoResult = $pdoConnect->prepare($pdoQuery);
$pdoExec = $pdoResult->execute();
$product_data = $pdoResult->fetch(PDO::FETCH_ASSOC);

$product_name               		=   $product_data['product_name'];
$product_descriptions      	 		=   $product_data['product_descriptions'];
$product_price              		=   $product_data['product_price'];
$product_image              		=   $product_data['product_image'];
$product_created_at         		=   $product_data['created_at'];
$product_updated_at         		=   $product_data['updated_at'];
$product_availability_started_at 	= $product_data['start_datetime'];
$product_availability_end_at 		= $product_data['end_datetime'];

$pdoQuery = "SELECT * FROM product_list WHERE product_id = :product_id";
$pdoResult2 = $pdoConnect->prepare($pdoQuery);
$pdoExec = $pdoResult2->execute(array(":product_id" => $product_id));
$sched_res = [];

foreach ($pdoResult2->fetchAll(PDO::FETCH_ASSOC) as $schedue_row) {
	$schedue_row['sdate'] = date("F d, Y h:i A", strtotime($schedue_row['start_datetime']));
	$schedue_row['edate'] = date("F d, Y h:i A", strtotime($schedue_row['end_datetime']));
	$sched_res[$schedue_row['id']] = $schedue_row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../src/img/<?php echo $logo ?>">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
	<link rel="stylesheet" href="../../src/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../src/node_modules/boxicons/css/boxicons.min.css">
	<link rel="stylesheet" href="../../src/node_modules/aos/dist/aos.css">
	<link rel="stylesheet" href="../../src/css/admin.css?v=<?php echo time(); ?>">
	<script src="../../src/fullcalendar/lib/main.min.js"></script>
	<link rel="stylesheet" href="../../src/fullcalendar/lib/main.min.css">


	<title>Products Details</title>
</head>

<style>
	.calendar .btn-info.text-light:hover,
	.btn-info.text-light:focus {
		background: #000;
	}

	.calendar table,
	tbody,
	td,
	tfoot,
	th,
	thead,
	tr {
		border-color: #ebe8e8 !important;
		border-style: solid;
		border-width: 1px !important;
	}
</style>

<body>

	<!-- Loader -->
	<div class="loader"></div>

	<!-- SIDEBAR -->
	<section id="sidebar" class="hide">
		<a href="#" class="brand"><img src="../../src/img/<?php echo $logo ?>" alt="logo" class="brand-img"></i>&nbsp;&nbsp;FSR</a>
		<ul class="side-menu">
			<li><a href="home"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<li>
				<a href="#"><i class='bx bx-cart-add icon'></i> Products <i class='bx bx-chevron-right icon-right'></i></a>
				<ul class="side-dropdown">
					<li><a href="products">Data</a></li>
					<li><a href="add-products">Add Products</a></li>
				</ul>
			</li>
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
				<span><?php echo $name ?></span>
			</div>
			<div class="profile">
				<img src="../../src/img/<?php echo $user_profile ?>" alt="">
				<ul class="profile-link">
					<li><a href="profile"><i class='bx bxs-user-circle icon'></i> Profile</a></li>
					<li><a href="authentication/user-signout" class="btn-signout"><i class='bx bxs-log-out-circle'></i> Signout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Products Details</h1>
			<ul class="breadcrumbs">
				<li><a href="home">Home</a></li>
				<li class="divider">|</li>
				<li><a href="seller-data?Id=<?php echo $product_id ?>">Products</a></li>
				<li class="divider">|</li>
				<li><a href="" class="active">Products Details</a></li>
			</ul>

			<section class="profile-form">
				<div class="header"></div>
				<div class="profile">
					<div class="profile-img">
						<img src="../../src/img/<?php echo $product_image ?>" alt="logo">
                        <label for="" style="font-weight: bold; font-size: 20px; text-align: center;"><?php echo $product_name ?></label>
					</div>

					<div id="product-details">
						<form action="" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
							<div class="row gx-5 needs-validation">

								<label class="form-label" style="text-align: left; padding-top: .5rem; padding-bottom: 1rem; font-size: 1rem; font-weight: bold;"><i class='bx bxs-edit'></i> Product Details</label>

								<div class="col-md-12">
									<label for="product_name" class="form-label">Product Name</label>
									<input type="text" disabled class="form-control" value="<?php echo $product_name ?>" autocapitalize="on" maxlength="15" autocomplete="off" >
									<div class="invalid-feedback">
										Please provide a Product Name.
									</div>
								</div>

								<div class="col-md-12">
									<label for="product_description" class="form-label">Product Description</label>
									<input type="text" disabled class="form-control" value="<?php echo $product_descriptions ?>" autocapitalize="on" maxlength="15" autocomplete="off" >
									<div class="invalid-feedback">
										Please provide a Product Description.
									</div>
								</div>

								<div class="col-md-12">
									<label for="product_price" class="form-label">Product Price<span> (kg)*</span></label>
									<input type="text" disabled class="form-control numbers" value="<?php echo $product_price ?>" autocapitalize="on" maxlength="15" autocomplete="off" >
									<div class="invalid-feedback">
										Please provide a Product Price.
									</div>
								</div>

								<div class="col-md-6" style="opacity: 0;">
									<label for="product_image" class="form-label">Product Image</label>
									<input type="file" class="form-control" autocapitalize="on" maxlength="20" autocomplete="off">
									<div class="invalid-feedback">
										Please provide a Product Price.
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
			</section> <br>

			<div class="calendar" style="background-color: #FFF ;">
				<div class="container py-3" id="page-container">
					<div class="row">
						<div class="col-md-12">
							<div id="calendar"></div>
						</div>
					</div>
				</div>
			</div>

			<!-- MODAL -->



		</main>
		<!-- MAIN -->
	</section>
	<!-- END NAVBAR -->

	<script src="../../src/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../src/node_modules/jquery/dist/jquery.min.js"></script>
	<script src="../../src/js/dashboard.js"></script>
	<script src="../../src/js/loader.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $GoogleAPI ?>&libraries=places&callback=initialize" async defer></script>



	<script>
		//Schedule
		var scheds = $.parseJSON('<?= json_encode($sched_res) ?>');

		var calendar;
		var Calendar = FullCalendar.Calendar;
		var events = [];
		$(function() {
			if (!!scheds) {
				Object.keys(scheds).map(k => {
					var row = scheds[k]
					events.push({
						id: row.id,
						title: row.product_name,
						start: row.start_datetime,
						end: row.end_datetime
					});
				})
			}
			var date = new Date()
			var d = date.getDate(),
				m = date.getMonth(),
				y = date.getFullYear()

			calendar = new Calendar(document.getElementById('calendar'), {
				headerToolbar: {
					left: 'prev,next today',
					right: 'dayGridMonth,dayGridWeek,list',
					center: 'title',
				},
				selectable: true,
				themeSystem: 'bootstrap',
				//Random default events
				events: events,
				eventDidMount: function(info) {
					// Do Something after events mounted
				},
				editable: true
			});

			calendar.render();

			// Form reset listener
			$('#schedule-form').on('reset', function() {
				$(this).find('input:hidden').val('')
				$(this).find('input:visible').first().focus()
			})
		});

		// Form reset listener
		$('#schedule-form').on('reset', function() {
			$(this).find('input:hidden').val('')
			$(this).find('input:visible').first().focus()
		});
		// ------------------------------------------------------------------------------------------------------------------------
		// Form
		(function() {
			'use strict'
			var forms = document.querySelectorAll('.needs-validation')
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
		})();

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