<?php
    include("connect.php");

    $status = "failure";
    $response = "keine passende ID";


    if(!empty($_GET["id"])) {

        $_sql = "UPDATE user SET isActive = '1' WHERE ID='".$_GET['id']."';";

        if (mysqli_query($connect, $_sql)) {

            header("location: index.php");

        } else {
           $status = "failure";
            $response = "koin blassen";

		}
    }
    exit(json_encode(array("status"=>$status,"response"=>$response)));
?>