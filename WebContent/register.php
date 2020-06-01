<?php
    use PHPMailer\PHPMailer\PHPMailer;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("connect.php");
    session_start();

    $password_hash=password_hash($_POST['password'], PASSWORD_DEFAULT);

    $_email = mysqli_real_escape_string($connect,$_POST['email']);
    $_sql = "SELECT * from user Where email='".$_email."';";
    $result = mysqli_query($connect, $_sql);
    $count = mysqli_num_rows($result);

    $status = "mailexists";
    $response = "E-Mail ist bereits vergeben";
    if($count == 0) {
        $user_info ="INSERT INTO USER (`email`, `passwort`, `vorname`, `nachname`) VALUES ('".$_POST["email"]."','".$password_hash."','".$_POST["firstname"]."','".$_POST["lastname"]."');";
        if (mysqli_query($connect, $user_info))
        {

        $sql = "SELECT * from user Where email='".$_email."';";
        $ergebnis = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($ergebnis, MYSQLI_ASSOC);
        $current_id = $row['ID'];

    $email = $_POST['email'];
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();

    //SMTP Settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "povalue@gmail.com";
    $mail->Password = 'mycsyg-qaqraj-Kagba5';
    $mail->Port = 465; //587
    $mail->SMTPSecure = "ssl"; //tls
    $mail->SMTPDecub = 2;

   $actual_link = "http://$_SERVER[HTTP_HOST]/povalue-master/WebContent/activate.php?id=" . $current_id;
			

    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom("povalue@gmx.de");
    $mail->addAddress($email);
    $mail->Subject = "Ihre Registrierung bei Povalue";
    $mail->Body = "Bitte bestätige deine E-Mail Adresse unter folgendem link <br /> <br /><html><a href=".$actual_link.">Registrierung abschließen</a></html>";

    if ($mail->send()) {
        $status = "success";
        $response = "Email versendet!";
    } else {
        $status = "failed";
        $response = "Etwas ist fehlgeschlagen: " . $mail->ErrorInfo;
    }

    exit(json_encode(array("status"=>$status,"response"=>$response)));
    } else {
        // Redirect to login or main (when signed in)
        if(array_key_exists("id", $_SESSION)) {
            header("location: main.php"); 
        }
    }
    }
    }
?>