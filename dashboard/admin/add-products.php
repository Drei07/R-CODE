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
    <title>Add Products</title>
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
                    <li><a href="settings"><i class='bx bxs-cog'></i> Settings</a></li>
                    <li><a href="authentication/admin-signout" class="btn-signout"><i class='bx bxs-log-out-circle'></i> Signout</a></li>
                </ul>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Add Products</h1>
            <ul class="breadcrumbs">
                <li><a href="home">Home</a></li>
                <li class="divider">|</li>
                <li><a href="products">Products</a></li>
                <li class="divider">|</li>
                <li><a href="" class="active">Add Products</a></li>
            </ul>

            <section class="data-form">
                <div class="header"></div>
                <div class="registration">
                    <form action="controller/add-products-controller.php" method="POST" enctype="multipart/form-data" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
                        <div class="row gx-5 needs-validation">

                            <div class="col-md-12">
                                <label for="product_name" class="form-label">Product Name<span> *</span></label>
                                <input type="text" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="product_name" id="product_name"  required>
                                <div class="invalid-feedback">
                                    Please provide a Product Name.
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="product_description" class="form-label">Product Description<span> *</span></label>
                                <textarea class="form-control" placeholder="Add product description" id="floatingTextarea2" style="height: 200px" name="product_descriptions" id="product_descriptions" required></textarea>
                                <div class="invalid-feedback">
                                    Please provide a Product Description.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="product_price" class="form-label">Product Price<span> *(kg)</span></label>
                                <input type="text" class="form-control numbers" autocapitalize="on" maxlength="15" autocomplete="off" name="product_price" id="product_price"  required>
                                <div class="invalid-feedback">
                                    Please provide a Product Price.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="product_image" class="form-label">Product Image<span> *</span></label>
                                <input type="file" class="form-control" autocapitalize="on" maxlength="20" autocomplete="off" name="product_image" id="product_image"  required>
                                <div class="invalid-feedback">
                                    Please provide a Product Price.
                                </div>
                            </div>

                        </div>

                        <div class="addBtn">
                            <button type="submit" class="primary" name="btn-add-product" id="btn-add-product" onclick="return IsEmpty(); sexEmpty();">Add</button>
                        </div>
                    </form>
                </div>
            </section>

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

        //numbers only----------------------------------------------------------------------------------------------------->
		$('.numbers').keypress(function(e) {
		var x = e.which || e.keycode;
		if ((x >= 48 && x <= 57) || x == 8 ||
			(x >= 35 && x <= 40) || x == 46)
			return true;
		else
			return false;
		});


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