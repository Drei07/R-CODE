<?php
include_once __DIR__. '/../../../database/dbconfig2.php';
require_once '../authentication/admin-class.php';


$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
 $admin_home->redirect('');
}


    $product_id                   = $_GET["Id"];
    $status                      = "delete";


    $pdoQuery = 'UPDATE product_list SET product_status=:product_status WHERE product_id= :product_id';
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(
    array
    ( 
    ":product_status"             =>$status,
    ":product_id"                =>$product_id
    )
    );

    $_SESSION['status_title'] = "Success!";
    $_SESSION['status'] = "Avatar successfully updated!";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_timer'] = 40000;
    header('Location: ../products');
    $pdoConnect = null;


?>