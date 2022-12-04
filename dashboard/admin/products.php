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




?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../src/img/<?php echo $logo ?>">
	<link rel="stylesheet" href="../../src/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../src/node_modules/boxicons/css/boxicons.min.css">
	<link rel="stylesheet" href="../../src/node_modules/aos/dist/aos.css">
	<link rel="stylesheet" href="../../src/css/admin.css?v=<?php echo time(); ?>">
	<title>Products</title>
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
			<h1 class="title">Products</h1>
			<ul class="breadcrumbs">
				<li><a href="home">Home</a></li>
				<li class="divider">|</li>
				<li><a href="" class="active">Products</a></li>
			</ul>
			<div class="level">
                <button type="button" onclick="location.href='add-products.php'"><i class='bx bx-plus'></i> Add Product</button>
            </div>
			<div class="dashboard-data-products">
				

			<?php

				$pdoQuery = "SELECT * FROM product_list WHERE admin_id=$admin_id AND product_status = :product_status ";
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
		(function () {
			'use strict'
			var forms = document.querySelectorAll('.needs-validation')
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