<?php
use PHPMailer\PHPMailer\PHPMailer;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include("connect.php");

	$email = mysqli_real_escape_string($connect,$_POST['email']);
	$_abfrage = "SELECT * from user Where email='".$email."';";
	$result = mysqli_query($connect, $_abfrage);
	$count = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$id = $row['ID'];
	$random = uniqid();
	$status = "wrongemail";
	$response = "email nicht vorhanden";

	if($count == 1) {

	$_random = "UPDATE user SET Random = '".$random."', pwreset = 1 WHERE email='".$email."';";

	if (mysqli_query($connect, $_random)) {

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

		$actual_link = "http://$_SERVER[HTTP_HOST]/povalue-master/WebContent/pwsetback.php?id=".$id."&email=".$email."&random=".$random;


		//Email Settings
		$mail->isHTML(true);
		$mail->setFrom("povalue@gmx.de");
		$mail->addAddress($email);
		$mail->Subject = "Deine Passwortänderung bei Povalue";

		$mail->Body = "Hallo, keine Sorge, du kannst Dein Kennwort zurücksetzen, indem du auf den Link klickst: <br /> <br /> <html><a href=".$actual_link.">Klick hier um dein neues Passwort auszuwählen</a></html><br /><br />Wenn Du das Zurücksetzen Deines Kennworts nicht angefordert hast,
		lösch diese E-Mail einfach und genieße weiterhin deine Zeit bei Povalue. <br /><br /> Viele Grüße<br />Dein Povalue-Team";

		if ($mail->send()) {
			$status = "success";
			$response = "Email versendet!";
			} 
			else 
			{
			$status = "failed";
			$response = "Etwas ist fehlgeschlagen: " . $mail->ErrorInfo;
			}
		} 

	}

exit(json_encode(array("status"=>$status,"response"=>$response)));
}  else {
// Redirect to login or main (when signed in)
include('geheim.php');
if(array_key_exists("id", $_SESSION)) {
	header("location: main.php");
	}
}
?>