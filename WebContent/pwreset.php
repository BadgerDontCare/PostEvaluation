<?php

    $status = "failure";
    $response = "Änderung nicht erfolgreich";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("connect.php");
    session_start();

    $password_hash=password_hash($_POST['password'], PASSWORD_DEFAULT);
         
  
        $_sql = "UPDATE user SET passwort = '".$password_hash."', pwreset='0' WHERE email='".$_SESSION["email"]."';";

        if (mysqli_query($connect, $_sql)) {

           // header("location: index.php");
            $status = "success";
                        $response = "Login Erfolgreich";
        } else {
           $status = "failure";
           $response = "koin blassen";

		}
    
    exit(json_encode(array("status"=>$status,"response"=>$response)));
}  else {

} 
?>
