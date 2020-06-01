<?php
    $status = "Fehlgeschlagen";
    $response = "Löschen nicht möglich";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("connect.php");
    $id = $_POST['id'];
        $_sql = "delete from images Where id='".$id."';";
        if (mysqli_query($connect, $_sql)) { 
                $status = "success";
                $response = "Login Erfolgreich";
                   }
    exit(json_encode(array("status" => $status, "response" => $response)));
    } else {
    // Redirect to login or main (when signed in)
    include('geheim.php');
    if(array_key_exists("id", $_SESSION)) {
        header("location: main.php"); 
    }
}
?>