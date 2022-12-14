<?php
require_once 'user-class.php';
//URL
$main_url = "https://fishery-supplier-recommender.shop";
include_once __DIR__.'/../../superadmin/controller/select-settings-configuration-controller.php';


$reg_user = new USER();


if(isset($_POST['btn-register'])) {

    $first_name                     = trim($_POST['FName']);
    $middle_name                    = trim($_POST['MName']);
    $last_name                      = trim($_POST['LName']);
    $phone_number                   = trim($_POST['PNumber']);
    $email                          = trim($_POST['Email']);


    // Generate Password
    $varchar         = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $shuffle         = str_shuffle($varchar);
    $upass           = substr($shuffle,0,8);

    // Token Generator
    $tokencode      = md5(uniqid(rand()));

    $stmt = $reg_user->runQuery("SELECT * FROM user WHERE userEmail=:email_id");
    $stmt->execute(array(":email_id"=>$email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Email Existed
    if($stmt->rowCount() > 0)
    {
      $_SESSION['status_title'] = "Oops!";
      $_SESSION['status'] = "Email already taken. Please try another one.";
      $_SESSION['status_code'] = "error";
      $_SESSION['status_timer'] = 100000;
      header('Location: ../../../registration');
    }
    else
    {
        if($reg_user->register($first_name,$middle_name,$last_name,$phone_number,$email,$upass,$tokencode))
        {   
        $id = $reg_user->lasdID();  
        $key = base64_encode($id);
        $id = $key;
        
        $message = "     
            Hello sir/maam $last_name,
            <br /><br />
            Welcome to $system_name!
            <br /><br />
            Email:<br />$email
            Password:<br />$upass
            <br /><br />
            <a href='$main_url/public/user/verify?id=$id&code=$tokencode'>Click HERE to Verify your Account!</a>
            <br /><br />
            Thanks,";
            
        $subject = "Verify Email";
            
        $reg_user->send_mail($email,$message,$subject,$smtp_email,$smtp_password,$system_name);
        $_SESSION['status_title'] = "Success!";
        $_SESSION['status'] = "Please check the Email to verify the account.";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_timer'] = 40000;
        header('Location: ../../../');
        }
        else
        {

            $_SESSION['status_title'] = "Sorry !";
            $_SESSION['status'] = "Something went wrong, please try again!";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_timer'] = 10000000;
            header('Location: ../../../registration');

        }
    }
      

}

?>