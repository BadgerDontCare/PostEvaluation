<?php
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("connect.php");

    $like = mysqli_real_escape_string($connect,$_POST['like']);
    $pic =  mysqli_real_escape_string($connect,$_POST['pic']);

        $_sql = "UPDATE images SET likes = '".like."' WHERE id='".$_POST['pic']."';";

        if (mysqli_query($connect, $_sql)) {

            $status = "success";
            $response = "Email vorhanden";

        }
    }
    exit(json_encode(array("status"=>$status,"response"=>$response)));
}
?>
