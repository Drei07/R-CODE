<?php
include_once __DIR__. '/../../src/API/api.php';
include_once '../../dashboard/superadmin/controller/select-settings-configuration-controller.php';


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
    <link rel="stylesheet" href="../../src/css/countrySelect.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="../../src/css/admin.css?v=<?php echo time(); ?>">
	<title>Registration</title>
</head>
<body>

    <!-- MODALS -->
	<div class="class-modal">
		<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content" >
				<div class="header"></div>
					<div class="modal-header">
						<h5 class="modal-title" id="registrationModalLabel">Registration</h5>
						<button type="button" class="btn-close" onclick="location.href='../../'"></button>
					</div>
					<div class="modal-body">
                        <section class="data-form">
                            <div class="registration">
                                <form action="../../dashboard/user/authentication/user-registration.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()"  novalidate style="overflow: hidden;">
                                    <div class="row gx-5 needs-validation">

                                    <label class="form-label" style="text-align: left; padding-bottom: 2rem; font-size: 1rem; font-weight: bold;">User Information</label>

                                        <div class="col-md-6">
                                            <label for="first_name" class="form-label">First Name<span> *</span></label>
                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocomplete="off" name="FName" id="first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required>
                                            <div class="invalid-feedback">
                                            Please provide a First Name.
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="middle_name" class="form-label">Middle Name</label>
                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"  class="form-control" autocomplete="off" name="MName" id="middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                                            <div class="invalid-feedback">
                                            Please provide a Middle Name.
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="last_name" class="form-label">Last Name<span> *</span></label>
                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocomplete="off" name="LName" id="last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required >
                                            <div class="invalid-feedback">
                                            Please provide a Last Name.
                                            </div>
                                        </div>

                                        <div class="col-md-6" >
                                            <label for="phone_number" class="form-label">Phone Number<span> *</span></label>
                                            <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping">+63</span>
                                            <input type="text" class="form-control numbers"  autocapitalize="off" inputmode="numeric" autocomplete="off" name="PNumber" id="phone_number" required minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  placeholder="10-digit number">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="ToC" class="form-label">Type of Customer<span> *</span></label>
                                            <select class="form-select form-control"  name="ToC"  maxlength="6" autocomplete="off" id="ToC" required>
                                            <option selected disabled value="">Select...</option>
                                            <option value="0">BUYER</option>
                                            <option value="1 ">SELLER</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a type of Customer.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email<span> *</span></label>
                                            <input type="email" class="form-control" autocapitalize="off" autocomplete="off" name="Email" id="email" required placeholder="Ex. juan@email.com">
                                            <div class="invalid-feedback">
                                            Please provide a valid Email.
                                            </div>
                                        </div>

                                        

                                    </div>

                                    <div class="addBtn">
                                        <button type="submit" class="primary" name="btn-register" id="btn-register" onclick="return IsEmpty(); sexEmpty();">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </section>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END MODALS -->
	<!-- END NAVBAR -->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script src="../../src/js/countrySelect.min.js"></script>
	<script src="../../src/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../src/js/dashboard.js"></script>

	<script>
        //Load Modal
        $(window).on('load', function() {
        $('#registrationModal').modal('show');
        });

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

        // Country Selector
        $("#nationality").countrySelect({
            defaultCountry:"ph",
            defaultStyling:"inside",
            responsiveDropdown:true
        });


		// Signout
		$('.btn-signout').on('click', function(e){
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

		//numbers only
		$('.numbers').keypress(function(e) {
		var x = e.which || e.keycode;
		if ((x >= 48 && x <= 57) || x == 8 ||
			(x >= 35 && x <= 40) || x == 46)
			return true;
		else
			return false;
		});

        //birthdate
        function formatDate(date){
            var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');

        }

        function getAge(dateString){
            var birthdate = new Date().getTime();
            if (typeof dateString === 'undefined' || dateString === null || (String(dateString) === 'NaN')){
            birthdate = new Date().getTime();
            }
            birthdate = new Date(dateString).getTime();
            var now = new Date().getTime();
            var n = (now - birthdate)/1000;
            if (n < 604800){
            var day_n = Math.floor(n/86400);
            if (typeof day_n === 'undefined' || day_n === null || (String(day_n) === 'NaN')){
                return '';
            }else{
                return day_n + '' + (day_n > 1 ? '' : '') + '';
            }
            } else if (n < 2629743){
            var week_n = Math.floor(n/604800);
            if (typeof week_n === 'undefined' || week_n === null || (String(week_n) === 'NaN')){
                return '';
            }else{
                return week_n + '' + (week_n > 1 ? '' : '') + '';
            }
            } else if (n < 31562417){
            var month_n = Math.floor(n/2629743);
            if (typeof month_n === 'undefined' || month_n === null || (String(month_n) === 'NaN')){
                return '';
            }else{
                return month_n + ' ' + (month_n > 1 ? '' : '') + '';
            }
            }else{
            var year_n = Math.floor(n/31556926);
            if (typeof year_n === 'undefined' || year_n === null || (String(year_n) === 'NaN')){
                return year_n = '';
            }else{
                return year_n + '' + (year_n > 1 ? '' : '') + '';
            }
            }
        }
        function getAgeVal(pid){
            var birthdate = formatDate(document.getElementById("birthdate").value);
            var count = document.getElementById("birthdate").value.length;
            if (count=='10'){
            var age = getAge(birthdate);
            var str = age;
            var res = str.substring(0, 1);
            if (res =='-' || res =='0'){
                document.getElementById("birthdate").value = "";
                document.getElementById("age").value = "";
                $('#birthdate').focus();
                return false;
            }else{
                document.getElementById("age").value = age;
            }
            }else{
            document.getElementById("age").value = "";
            return false;
            }
        };

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