<?php
require_once 'superadmin-class.php';
include_once '../controller/select-settings-configuration-controller.php';

$superadmin = new SUPERADMIN();

if(empty($_GET['id']) && empty($_GET['code']))
{
 $superadmin->redirect('../../../public/superadmin/signin');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
 $id = base64_decode($_GET['id']);
 $code = $_GET['code'];
 
 $stmt = $superadmin->runQuery("SELECT * FROM superadmin WHERE superadminId=:uid AND tokencode=:token");
 $stmt->execute(array(":uid"=>$id,":token"=>$code));
 $rows = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if($stmt->rowCount() == 1)
 {
  if(isset($_POST['btn-update-password']))
  {
   $npass = $_POST['new-password'];
   
    $code = md5(uniqid(rand()));
    $npass = md5($npass);
    $stmt = $superadmin->runQuery("UPDATE superadmin SET password=:upass, tokencode=:token WHERE superadminId=:uid");
    $stmt->execute(array(":token"=>$code,":upass"=>$npass,":uid"=>$rows['superadminId']));
    
    $_SESSION['status_title'] = "Success !";
    $_SESSION['status'] = "Password is updated. Redirecting to Sign in.";
    $_SESSION['status_code'] = "success";
    header("refresh:4;../../../public/superadmin/signin");
   
  } 
 }
 else
 {
    $_SESSION['status_title'] = "Oops !";
    $_SESSION['status'] = "Your token is expired.";
    $_SESSION['status_code'] = "error";
 }
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../../../src/img/<?php echo $logo ?>">
	<link rel="stylesheet" type="text/css" href="../../../src/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../src/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../../src/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../../../src/vendor/animate/animate.css">	
	<link rel="stylesheet" type="text/css" href="../../../src/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="../../../src/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="../../../src/vendor/select2/select2.min.css">	
	<link rel="stylesheet" type="text/css" href="../../../src/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="../../../src/css/util.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="../../../src/css/main.css?v=<?php echo time(); ?>">

    <title>Superadmin | Reset Password</title>
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(../../../src/img/fish.jpg);">
					<span class="login100-form-title-1">
						Reset Password?
					</span>
				</div>

				<form action="" method="POST" novalidate="" class="login100-form validate-form">

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="new-password" id="new-password" placeholder="Enter new password">
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">

					</div>

					<div class="container-login100-form-btn">
						<button type="submit" name="btn-update-password" id="submit" class="login100-form-btn">
						Reset Password
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="../../../src/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../../../src/vendor/animsition/js/animsition.min.js"></script>
	<script src="../../../src/vendor/bootstrap/js/popper.js"></script>
	<script src="../../../src/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../../../src/vendor/select2/select2.min.js"></script>
	<script src="../../../src/vendor/daterangepicker/moment.min.js"></script>
	<script src="../../../src/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="../../../src/vendor/countdowntime/countdowntime.js"></script>
	<script src="../../../src/js/main.js"></script>
	<script src="../../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../../src/node_modules/jquery/dist/jquery.min.js"></script>

	<script>

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