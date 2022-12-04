<?php
include_once '../../database/dbconfig2.php';
include_once '../../src/API/api.php';
require_once 'authentication/admin-class.php';
include_once '../superadmin/controller/select-settings-configuration-controller.php';



$admin_home = new ADMIN();

if (!$admin_home->is_logged_in()) {
	$admin_home->redirect('../../public/admin/signin');
}

$stmt = $admin_home->runQuery("SELECT * FROM admin WHERE userId=:uid");
$stmt->execute(array(":uid" => $_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$UId = $row['userId'];

$pdoQuery = "SELECT * FROM admin WHERE userId=$UId";
$pdoResult = $pdoConnect->prepare($pdoQuery);
$pdoExec = $pdoResult->execute();
$admin_profile = $pdoResult->fetch(PDO::FETCH_ASSOC);


$profile_admin 				= $admin_profile['adminProfile'];
$first_name                 = $admin_profile["adminFirst_Name"];
$middle_name                = $admin_profile["adminMiddle_Name"];
$last_name                  = $admin_profile["adminLast_Name"];
$email 						= $admin_profile["adminEmail"];
$address					= $admin_profile["address"];
$latitude					= $admin_profile["latitude"];
$longitude					= $admin_profile["longitude"];
$business_name				= $admin_profile["business_name"];	
$updated_at  				= $admin_profile["updated_at"];



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
	<title>Account Information</title>
</head>

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
				<span><?php echo $row['adminLast_Name']; ?>, <?php echo $row['adminFirst_Name']; ?></i></span>
			</div>
			<div class="profile">
				<img src="../../src/img/<?php echo $profile_admin ?>" alt="">
				<ul class="profile-link">
					<li><a href="profile"><i class='bx bxs-user-circle icon'></i> Profile</a></li>
					<li><a href="authentication/admin-signout" class="btn-signout"><i class='bx bxs-log-out-circle'></i> Signout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Profile</h1>
			<ul class="breadcrumbs">
				<li><a href="home">Home</a></li>
				<li class="divider">|</li>
				<li><a href="" class="active">Profile</a></li>

			</ul>

			<!-- PROFILE CONFIGURATION -->

			<section class="profile-form">
				<div class="header"></div>
				<div class="profile">
					<div class="profile-img">
						<img src="../../src/img/<?php echo $profile_admin ?>" alt="logo">

						<a href="controller/delete-profile-controller.php?id=<?php echo $UId ?>" class="delete"><i class='bx bxs-trash'></i></a>
						<button class="primary change" onclick="edit()"><i class='bx bxs-edit'></i> Edit Profile</button>
						<button class="primary change" onclick="avatar()"><i class='bx bxs-user'></i> Change Avatar</button>
						<button class="primary change" onclick="password()"><i class='bx bxs-key'></i> Change Password</button>
						<button class="primary change" data-bs-toggle="modal" data-bs-target="#mapmodal"><i class='bx bx-current-location'></i> Change Location</button>


					</div>

					<div id="Edit">
						<form action="controller/update-profile-controller.php?id=<?php echo $UId ?>" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
							<div class="row gx-5 needs-validation">

								<label class="form-label" style="text-align: left; padding-top: .5rem; padding-bottom: 1rem; font-size: 1rem; font-weight: bold;"><i class='bx bxs-edit'></i> Edit Profile<p>Last update: <?php echo $updated_at  ?></p></label>

								<div class="col-md-6">
									<label for="first_name" class="form-label">First Name<span> *</span></label>
									<input type="text" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="FName" id="first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required value="<?php echo $first_name ?>">
									<div class="invalid-feedback">
										Please provide a First Name.
									</div>
								</div>

								<div class="col-md-6">
									<label for="middle_name" class="form-label">Middle Name</label>
									<input type="text" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="MName" id="middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="<?php echo $middle_name ?>">
									<div class="invalid-feedback">
										Please provide a Middle Name.
									</div>
								</div>

								<div class="col-md-6">
									<label for="last_name" class="form-label">Last Name<span> *</span></label>
									<input type="text" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="LName" id="last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required value="<?php echo $last_name ?>">
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


							</div>

							<div class="addBtn">
								<button type="submit" class="primary" name="btn-update-profile" id="btn-update" onclick="return IsEmpty(); sexEmpty();">Update</button>
							</div>
						</form>
					</div>

					<div id="avatar" style="display: none;">
						<form action="controller/update-profile-avatar-controller.php?id=<?php echo $UId ?>" method="POST" enctype="multipart/form-data" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
							<div class="row gx-5 needs-validation">

								<label class="form-label" style="text-align: left; padding-top: .5rem; padding-bottom: 1rem; font-size: 1rem; font-weight: bold;"><i class='bx bxs-user'></i> Change Avatar<p>Last update: <?php echo $superadmin_profile_last_update  ?></p></label>

								<div class="col-md-12">
									<label for="logo" class="form-label">Upload Logo<span> *</span></label>
									<input type="file" class="form-control" name="Logo" id="logo" style="height: 33px ;" required>
									<div class="invalid-feedback">
										Please provide a Logo.
									</div>
								</div>

								<div class="col-md-12" style="opacity: 0;">
									<label for="email" class="form-label">Default Email<span> *</span></label>
									<input type="email" class="form-control" autocapitalize="off" autocomplete="off" name="" id="email" required value="<?php echo $system_email  ?>">
									<div class="invalid-feedback">
										Please provide a valid Email.
									</div>
								</div>

								<div class="col-md-12" style="opacity: 0; padding-bottom: 1.3rem;">
									<label for="sname" class="form-label">Old Password<span> *</span></label>
									<input type="text" class="form-control" autocapitalize="on" autocomplete="off" name="" id="sname" required value="<?php echo $system_name  ?>">
									<div class="invalid-feedback">
										Please provide a Old Password.
									</div>
								</div>

							</div>

							<div class="addBtn">
								<button type="submit" class="primary" name="btn-update-avatar" id="btn-update" onclick="return IsEmpty(); sexEmpty();">Update</button>
							</div>
						</form>
					</div>

					<div id="password" style="display: none;">
						<form action="controller/update-password-controller.php?id=<?php echo $UId ?>" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
							<div class="row gx-5 needs-validation">

								<label class="form-label" style="text-align: left; padding-top: .5rem; padding-bottom: 1rem; font-size: 1rem; font-weight: bold;"><i class='bx bxs-key'></i> Change Password<p>Last update: <?php echo $superadmin_profile_last_update  ?></p></label>

								<div class="col-md-12">
									<label for="old_pass" class="form-label">Old Password<span> *</span></label>
									<input type="password" class="form-control" autocapitalize="on" autocomplete="off" name="Old" id="old_pass" required>
									<div class="invalid-feedback">
										Please provide a Old Password.
									</div>
								</div>

								<div class="col-md-12">
									<label for="new_pass" class="form-label">New Password<span> *</span></label>
									<input type="text" class="form-control" autocapitalize="on" autocomplete="off" name="New" id="new_pass" required>
									<div class="invalid-feedback">
										Please provide a New Password.
									</div>
								</div>

								<div class="col-md-12">
									<label for="confirm_pass" class="form-label">Confirm Password<span> *</span></label>
									<input type="text" class="form-control" autocapitalize="on" autocomplete="off" name="Confirm" id="confirm_pass" required>
									<div class="invalid-feedback">
										Please provide a Confirm Password.
									</div>
								</div>

							</div>

							<div class="addBtn">
								<button type="submit" class="btn-primary" name="btn-update-password" id="btn-update" onclick="return IsEmpty(); sexEmpty();">Update</button>
							</div>
						</form>
					</div>
				</div>
			</section>
		</main>
		<!-- MAIN -->

		<!-- MODALS -->
		<div class="class-modal">
			<div class="modal fade" id="mapmodal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true" >
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content" style="height: 100%;">
						<div class="header"></div>
						<div class="modal-header">
							<h5 class="modal-title" id="classModalLabel">Please Select Location</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

						</div>
						<div class="modal-body">
							<section class="data-form">
								<div class="registration">
									<form action="controller/add-admin-location-controller.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
										<div class="row gx-5 needs-validation">

											<div class="col-md-12">
													<label for="business_name" class="form-label">Business name <span style="font-size:17px; margin-top: 2rem; color:red;">*</span></label>
													<input type="text" class="form-control" value="<?php echo $business_name ?>" name="business_name" id="business_name" placeholder="Add business name" required>
													<div class="invalid-feedback" id="invalid">
														Please provide valid Business Name.
													</div>
												</div>

											<div class="col-md-12">
												<label for="last_name" class="form-label">Address <span style="font-size:17px; color:red;">*</span></label>
												<input type="text" class="form-control" onkeydown="return false;" value="<?php echo $address ?>" name="Address" id="map-search" required>
												<div class="invalid-feedback" id="invalid">
													Please provide valid.
												</div>
											</div>
											
											<div id="map-canvas"></div>

											<div class="col-md-6" style="display: none;">
												<label for="Latitude" class="form-label">Latitude<span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></label>
												<input type="text" class="form-control latitude" autocapitalize="on" autocomplete="off" name="Latitude" id="Latitude" required>
												<div class="invalid-feedback">
													Please provide a Latitude.
												</div>
											</div>
											<div class="col-md-6" style="display: none;">
												<label for="Longitude" class="form-label">Longitude<span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></label>
												<input type="text" class="form-control longitude" autocapitalize="on" autocomplete="off" name="Longitude" id="Longitude" required>
												<div class="invalid-feedback">
													Please provide a Longitude.
												</div>
												<input type="text" class="reg-input-city" placeholder="City" style="display: none;">
											</div>

										</div>

										<div class="addBtn">
											<button type="submit" class="primary" name="btn-update-location" id="btn-add-location" onclick="return IsEmpty(); sexEmpty();">Update</button>
										</div>
									</form>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END NAVBAR -->


	<script src="../../src/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../src/node_modules/jquery/dist/jquery.min.js"></script>
	<script src="../../src/js/dashboard.js"></script>
	<script src="../../src/js/loader.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $GoogleAPI ?>&libraries=places&callback=initialize" async defer></script>


	<script>
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

		window.onpageshow = function() {
			document.getElementById('avatar').style.display = 'none';
			document.getElementById('password').style.display = 'none';
		};

		function edit() {
			document.getElementById('Edit').style.display = 'block';
			document.getElementById('password').style.display = 'none';
			document.getElementById('avatar').style.display = 'none';
		}

		function avatar() {
			document.getElementById('avatar').style.display = 'block';
			document.getElementById('Edit').style.display = 'none';
			document.getElementById('password').style.display = 'none';
		}

		function password() {
			document.getElementById('password').style.display = 'block';
			document.getElementById('avatar').style.display = 'none';
			document.getElementById('Edit').style.display = 'none';
		}

		//google maps--------------------------------------------------------------
		function initialize() {

			var mapOptions, map, marker, searchBox, city,
				infoWindow = '',
				addressEl = document.querySelector('#map-search'),
				latEl = document.querySelector('.latitude'),
				longEl = document.querySelector('.longitude'),
				element = document.getElementById('map-canvas');
			city = document.querySelector('.reg-input-city');

			mapOptions = {
				// How far the maps zooms in.
				zoom: 15,
				// Current Lat and Long position of the pin/
				center: new google.maps.LatLng(<?php echo $latitude?>,<?php echo $longitude?>,),
				// center : {
				// 	lat: -34.397,
				// 	lng: 150.644
				// },
				streetViewControl: false,
				disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
				scrollWheel: true, // If set to false disables the scrolling on the map.
				draggable: true, // If set to false , you cannot move the map around.
				// mapTypeId: google.maps.MapTypeId.HYBRID, // If set to HYBRID its between sat and ROADMAP, Can be set to SATELLITE as well.
				// maxZoom: 11, // Wont allow you to zoom more than this
				minZoom: 8 // Wont allow you to go more up.

			};

			/**
			 * Creates the map using google function google.maps.Map() by passing the id of canvas and
			 * mapOptions object that we just created above as its parameters.
			 *
			 */
			// Create an object map with the constructor function Map()
			map = new google.maps.Map(element, mapOptions); // Till this like of code it loads up the map.

			/**
			 * Creates the marker on the map
			 *
			 */
			marker = new google.maps.Marker({
				position: mapOptions.center,
				map: map,
				// icon: 'http://pngimages.net/sites/default/files/google-maps-png-image-70164.png',
				draggable: true
			});

			/**
			 * Creates a search box
			 */
			searchBox = new google.maps.places.SearchBox(addressEl);

			/**
			 * When the place is changed on search box, it takes the marker to the searched location.
			 */
			google.maps.event.addListener(searchBox, 'places_changed', function() {
				var places = searchBox.getPlaces(),
					bounds = new google.maps.LatLngBounds(),
					i, place, lat, long, resultArray,
					addresss = places[0].formatted_address;

				for (i = 0; place = places[i]; i++) {
					bounds.extend(place.geometry.location);
					marker.setPosition(place.geometry.location); // Set marker position new.
				}

				map.fitBounds(bounds); // Fit to the bound
				map.setZoom(15); // This function sets the zoom to 15, meaning zooms to level 15.
				// console.log( map.getZoom() );

				lat = marker.getPosition().lat();
				long = marker.getPosition().lng();
				latEl.value = lat;
				longEl.value = long;

				resultArray = places[0].address_components;

				// Get the city and set the city input value to the one selected
				for (var i = 0; i < resultArray.length; i++) {
					if (resultArray[i].types[0] && 'administrative_area_level_2' === resultArray[i].types[0]) {
						citi = resultArray[i].long_name;
						city.value = citi;
					}
				}

				// Closes the previous info window if it already exists
				if (infoWindow) {
					infoWindow.close();
				}
				/**
				 * Creates the info Window at the top of the marker
				 */
				infoWindow = new google.maps.InfoWindow({
					content: addresss
				});

				infoWindow.open(map, marker);
			});


			/**
			 * Finds the new position of the marker when the marker is dragged.
			 */
			google.maps.event.addListener(marker, "dragend", function(event) {
				var lat, long, address, resultArray, citi;

				console.log('i am dragged');
				lat = marker.getPosition().lat();
				long = marker.getPosition().lng();

				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({
					latLng: marker.getPosition()
				}, function(result, status) {
					if ('OK' === status) { // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
						address = result[0].formatted_address;
						resultArray = result[0].address_components;

						// Get the city and set the city input value to the one selected
						for (var i = 0; i < resultArray.length; i++) {
							if (resultArray[i].types[0] && 'administrative_area_level_2' === resultArray[i].types[0]) {
								citi = resultArray[i].long_name;
								console.log(citi);
								city.value = citi;
							}
						}
						addressEl.value = address;
						latEl.value = lat;
						longEl.value = long;

					} else {
						console.log('Geocode was not successful for the following reason: ' + status);
					}

					// Closes the previous info window if it already exists
					if (infoWindow) {
						infoWindow.close();
					}

					/**
					 * Creates the info Window at the top of the marker
					 */
					infoWindow = new google.maps.InfoWindow({
						content: address
					});

					infoWindow.open(map, marker);
				});
			});
		}

		//Delete Profile

		$('.delete').on('click', function(e) {
			e.preventDefault();
			const href = $(this).attr('href')

			swal({
					title: "Delete?",
					text: "Do you want to delete?",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						document.location.href = href;
					}
				});
		})

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

		//numbers only----------------------------------------------------------------------------------------------------->
		$('.numbers').keypress(function(e) {
			var x = e.which || e.keycode;
			if ((x >= 48 && x <= 57) || x == 8 ||
				(x >= 35 && x <= 40) || x == 46)
				return true;
			else
				return false;
		});
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