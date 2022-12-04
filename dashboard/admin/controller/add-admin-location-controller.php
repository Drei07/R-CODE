<?php
include_once __DIR__. '/../../../database/dbconfig2.php';
require_once '../authentication/admin-class.php';


$admin_home = new ADMIN();

if(!$admin_home->is_logged_in())
{
 $admin_home->redirect('');
}

$stmt = $admin_home->runQuery("SELECT * FROM admin WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$admin_id = $row['userId'];



if(isset($_POST['btn-add-location'])){

    $Address                      = trim($_POST['Address']);
    $Latitude                     = trim($_POST['Latitude']);
    $Longitude                    = trim($_POST['Longitude']);
    $Business_name                = trim($_POST['business_name']);

    $pdoQuery = 'UPDATE admin SET address=:address, latitude=:latitude, longitude=:longitude, business_name=:business_name  WHERE userId= :userId';
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(
    array
    ( 

    ":address"             =>$Address,
    ":latitude"            =>$Latitude,
    ":longitude"           =>$Longitude,
    ":business_name"       =>$Business_name,
    ":userId"              =>$admin_id,

    )
    );

    $_SESSION['status_title'] = "Success!";
    $_SESSION['status'] = "Location succesfully added!";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_timer'] = 40000;
    header('Location: ../home');

}
else if (isset($_POST['btn-update-location'])){

    $Address                      = trim($_POST['Address']);
    $Latitude                     = trim($_POST['Latitude']);
    $Longitude                    = trim($_POST['Longitude']);
    $Business_name                = trim($_POST['business_name']);

    $pdoQuery = 'UPDATE admin SET address=:address, latitude=:latitude, longitude=:longitude, business_name=:business_name  WHERE userId= :userId';
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(
    array
    ( 

    ":address"             =>$Address,
    ":latitude"            =>$Latitude,
    ":longitude"           =>$Longitude,
    ":business_name"       =>$Business_name,
    ":userId"              =>$admin_id,

    )
    );

    $_SESSION['status_title'] = "Success!";
    $_SESSION['status'] = "Location succesfully updated!";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_timer'] = 40000;
    header('Location: ../profile');
}
else{

    $_SESSION['status_title'] = "Oops!";
    $_SESSION['status'] = "Something went wrong, please try again!";
    $_SESSION['status_code'] = "error";
    $_SESSION['status_timer'] = 100000;
    header('Location: ../profile');
    
    
}

?>