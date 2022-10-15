<?php
include_once '../../dashboard/superadmin/authentication/superadmin-forgot-password.php';
include_once '../../dashboard/superadmin/controller/select-settings-configuration-controller.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../src/img/<?php echo $logo ?>">
	<link rel="stylesheet" type="text/css" href="../../src/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../src/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../src/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../../src/vendor/animate/animate.css">	
	<link rel="stylesheet" type="text/css" href="../../src/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="../../src/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="../../src/vendor/select2/select2.min.css">	
	<link rel="stylesheet" type="text/css" href="../../src/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="../../src/css/util.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="../../src/css/main.css?v=<?php echo time(); ?>">

	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $SiteKEY ?>"></script>

    <title>Superadmin | Forgot Password?</title>
</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(../../src/img/fish.jpg);">
					<span class="login100-form-title-1">
						Forgot Password?
					</span>
				</div>

				<form action="../../dashboard/superadmin/authentication/superadmin-forgot-password" method="POST" novalidate="" class="login100-form validate-form">

					<input type="hidden" id="g-token" name="g-token">

					<div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
						<span class="label-input100">Email</span>
						<input class="input100" type="email" name="email" placeholder="Enter email">
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">

						<div>
							<a href="signin" class="txt1">
								Back to Signin >
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" name="btn-forgot-password" id="submit" class="login100-form-btn">
							Send
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="../../src/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../../src/vendor/animsition/js/animsition.min.js"></script>
	<script src="../../src/vendor/bootstrap/js/popper.js"></script>
	<script src="../../src/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../../src/vendor/select2/select2.min.js"></script>
	<script src="../../src/vendor/daterangepicker/moment.min.js"></script>
	<script src="../../src/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="../../src/vendor/countdowntime/countdowntime.js"></script>
	<script src="../../src/js/main.js"></script>
	<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../src/node_modules/jquery/dist/jquery.min.js"></script>


	<script>

		// CAPTCHA
		grecaptcha.ready(function() {
		grecaptcha.execute('<?php echo $SiteKEY ?>', {action: 'submit'}).then(function(token) {
			document.getElementById("g-token").value = token;
		});
		});

	</script>

<!-- SWEET ALERT -->
<?php

	if(isset($_SESSION['status']) && $_SESSION['status'] !='')
	{
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