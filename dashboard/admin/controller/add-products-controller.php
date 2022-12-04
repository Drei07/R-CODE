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


if(isset($_POST['btn-add-product'])) {

    $product_name                    = trim($_POST['product_name']);
    $product_descriptions            = trim($_POST['product_descriptions']);
    $product_price                   = trim($_POST['product_price']);

    $folder = "../../../src/img/" . basename($_FILES['product_image']['name']);
    $product_image = $_FILES['product_image']['name'];


    $pdoQuery = "INSERT INTO product_list (admin_id, product_name, product_descriptions, product_price, product_image) 
                    VALUES (:admin_id, :product_name, :product_descriptions, :product_price, :product_image)";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute
    (
        array
        ( 
            ":admin_id"                    =>      $admin_id,
            ":product_name"                =>      $product_name,
            ":product_descriptions"        =>      $product_descriptions,
            ":product_price"               =>      $product_price,
            ":product_image"               =>      $product_image


        )
      );

      $_SESSION['status_title'] = "Success!";
      $_SESSION['status'] = "Product successfully added!";
      $_SESSION['status_code'] = "success";
      $_SESSION['status_timer'] = 40000;
      header("Location: ../products");

      if (move_uploaded_file($_FILES['product_image']['tmp_name'], $folder)) {
        header('Location: ../products');
    }
  
}
else
{
    $_SESSION['status_title'] = "Oops!";
    $_SESSION['status'] = "Something went wrong, please try again!";
    $_SESSION['status_code'] = "error";
    $_SESSION['status_timer'] = 100000;
    header("Location: ../products");

}

?>

?>