<?php
include_once __DIR__. '/../../../database/dbconfig2.php';
require_once '../authentication/admin-class.php';


$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
 $admin_home->redirect('');
}


    $product_id                   = $_GET["Id"];
    $reset                      = NULL;


    $pdoQuery = 'UPDATE product_list SET start_datetime=:start_datetime, end_datetime=:end_datetime WHERE product_id= :product_id';
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(
    array
    ( 
    ":start_datetime"             =>$reset,
    ":end_datetime"             =>$reset,
    ":product_id"                =>$product_id
    )
    );

    $_SESSION['status_title'] = "Success!";
    $_SESSION['status'] = "Product availability successfully reset!";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_timer'] = 40000;
    header("Location: ../products-details?Id=$product_id");
    $pdoConnect = null;


?>