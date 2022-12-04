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

$name = $row['adminLast_Name'] . ', ' . $row['adminFirst_Name'];
$profile_admin = $row['adminProfile'];
$admin_id = $row['userId'];

$pdoQuery = "SELECT * FROM product_list WHERE admin_id = :admin_id";
$pdoResult2 = $pdoConnect->prepare($pdoQuery);
$pdoExec = $pdoResult2->execute(array(":admin_id" => $admin_id));
$sched_res = [];

foreach ($pdoResult2->fetchAll(PDO::FETCH_ASSOC) as $schedue_row) {
	$schedue_row['sdate'] = date("F d, Y h:i A", strtotime($schedue_row['start_datetime']));
	$schedue_row['edate'] = date("F d, Y h:i A", strtotime($schedue_row['end_datetime']));
	$sched_res[$schedue_row['product_id']] = $schedue_row;
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
	<title>Dashboard</title>
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
			<li><a href="#" class="active"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
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
			<h1 class="title">Dashboard</h1>
			<ul class="breadcrumbs">
				<li><a href="home">Home</a></li>
				<li class="divider">|</li>
				<li><a href="" class="active">Dashboard</a></li>
			</ul>
			<div class="dashboard-data">

				<div class="dashboard-card">
					<div class="head" onclick="location.href='products'">
						<div>
							<?php
							$pdoQuery = "SELECT * FROM product_list WHERE admin_id = :admin_id";
							$pdoResult1 = $pdoConnect->prepare($pdoQuery);
							$pdoResult1->execute(array(":admin_id" => $admin_id));

							$count = $pdoResult1->rowCount();

							echo
							"
									<h2>$count</h2>
								";
							?>

							<p>Products</p>
						</div>
						<i class='bx bx-cart-add icon'></i>
					</div>
					<span class="progress" data-value="30%"></span>
				</div>
			</div><br>

			<div class="calendar" style="background-color: #FFF ;">
				<div class="container py-3" id="page-container">
					<div class="row">
						<div class="col-md-12">
							<div id="calendar"></div>
						</div>
					</div>
				</div>
			</div>

			
		</main>
		<!-- MAIN -->

		<!-- MODALS -->

		<?php

		if ($row['address'] == NULL || $row['latitude'] == NULL || $row['longitude'] == NULL) {

		?>
			<div class="class-modal">
				<div class="modal fade" id="mapmodal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true" data-bs-backdrop="static">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content" style="height: 100%;">
							<div class="header"></div>
							<div class="modal-header">
								<h5 class="modal-title" id="classModalLabel">Please Select Location</h5>
							</div>
							<div class="modal-body">
								<section class="data-form">
									<div class="registration">
										<form action="controller/add-admin-location-controller.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
											<div class="row gx-5 needs-validation">

												<div class="col-md-12">
													<label for="business_name" class="form-label">Business name <span style="font-size:17px; margin-top: 2rem; color:red;">*</span></label>
													<input type="text" class="form-control" name="business_name" id="business_name" placeholder="Add business name" required>
													<div class="invalid-feedback" id="invalid">
														Please provide valid Business Name.
													</div>
												</div>

												<div id="map-canvas"></div>

												<div class="col-md-12" style="display: none;">
													<label for="map-search" class="form-label">Address <span style="font-size:17px; margin-top: 2rem; color:red;">*</span></label>
													<input type="text" class="form-control" name="Address" id="map-search" placeholder="Pin address to google maps" required>
													<div class="invalid-feedback" id="invalid">
														Please provide valid Address.
													</div>
												</div>
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
												<button type="submit" class="primary" name="btn-add-location" id="btn-add-location" onclick="return IsEmpty(); sexEmpty();">Submit</button>
											</div>
										</form>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php
		} else {
		}


		?>
	</section>
	<!-- END NAVBAR -->

	<script src="../../src/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../src/node_modules/jquery/dist/jquery.min.js"></script>
	<script src="../../src/js/dashboard.js"></script>
	<script src="../../src/js/loader.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $GoogleAPI ?>&libraries=places&callback=initialize" async defer></script>



	<script>
		$(window).on('load', function() {
			$('#mapmodal').modal('show');
		});
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
				zoom: 12,
				// Current Lat and Long position of the pin/
				center: new google.maps.LatLng(14.9021333, 120.5509358),
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