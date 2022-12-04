<?php
include_once __DIR__. '/../../../database/dbconfig2.php';
require_once '../authentication/admin-class.php';


$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
 $admin_home->redirect('');
}

$Id            = $_GET["Id"];


if(isset($_POST['btn-update-product-details'])){

    $product_name                    = trim($_POST['product_name']);
    $product_descriptions            = trim($_POST['product_descriptions']);
    $product_price                   = trim($_POST['product_price']);

    $pdoQuery = 'UPDATE product_list SET product_name=:product_name, product_descriptions=:product_descriptions, product_price=:product_price  WHERE product_id= :product_id';;
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(
    array
    ( 

    ":product_name"             =>$product_name,
    ":product_descriptions"     =>$product_descriptions,
    ":product_price"            =>$product_price,
    ":product_id"               =>$Id,

    )
    );

    $_SESSION['status_title'] = "Success!";
    $_SESSION['status'] = "Product details succesfully updated";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_timer'] = 40000;
    header("Location: ../products-details?Id=$Id");

}

else if (isset($_POST['btn-update-product-image'])){

    $folder = "../../../src/img/" . basename($_FILES['product_image']['name']);
    $product_image = $_FILES['product_image']['name'];

    $pdoQuery = 'UPDATE product_list SET product_image=:product_image WHERE product_id= :product_id';
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(
    array
    ( 
    ":product_image"             =>$product_image,
    ":product_id"                =>$Id
    )
    );

    $_SESSION['status_title'] = "Success!";
    $_SESSION['status'] = "Product image succesfully updated";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_timer'] = 40000;
    header("Location: ../products-details?Id=$Id");

    if (move_uploaded_file($_FILES['Logo']['tmp_name'], $folder)) {
        header("Location: ../products-details?Id=$Id");
    }
}

else if (isset($_POST['btn-update-product-availability'])) {

    $start_datetime                    = trim($_POST['start_datetime']);
    $end_datetime                      = trim($_POST['end_datetime']);

    $pdoQuery = 'UPDATE product_list SET start_datetime=:start_datetime, end_datetime=:end_datetime  WHERE product_id= :product_id';
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(
    array
    ( 

    ":start_datetime"             =>$start_datetime,
    ":end_datetime"               =>$end_datetime,
    ":product_id"               =>$Id,

    )
    );

    $_SESSION['status_title'] = "Success!";
    $_SESSION['status'] = "Product availability succesfully updated";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_timer'] = 40000;
    header("Location: ../products-details?Id=$Id");
}

else{

    $_SESSION['status_title'] = "Oops!";
    $_SESSION['status'] = "Something went wrong, please try again!";
    $_SESSION['status_code'] = "error";
    $_SESSION['status_timer'] = 100000;
    header("Location: ../products-details?Id=$Id");
    
    
}

?>