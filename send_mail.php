<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'library/PHPMailer/Exception.php';
require 'library/PHPMailer/PHPMailer.php';
require 'library/PHPMailer/SMTP.php';

if (isset($_POST['submit'])) {

$mail = new PHPMailer(true);

$to = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$data_uri = $_POST['attachment'];
$encoded_image = explode(",", $data_uri)[1];
$decoded_image = base64_decode($encoded_image);
file_put_contents("img/signature.png", $decoded_image);

$mail->SMTPDebug = false;
$mail->isSMTP();
$mail->Host       = 'server';
$mail->SMTPAuth   = true;
$mail->Username   = 'username';
$mail->Password   = 'password';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;

$mail->setFrom('sender');
$mail->addAddress("$to");

$mail->addAttachment("img/signature.png");

$mail->isHTML(true);
$mail->Subject = "Here is your signature " . $firstname . " " . $lastname . "";
$mail->Body    = 'You have recently sign a form, in attachment you can find your signature';

try {
    $mail->send();
    echo "<script>
        alert('Message sent succesfully, thank you " . $firstname . " " . $lastname . "'); 
        window.history.go(-1);
        </script>";
} catch (Exception $e) {
    echo "<script>
        alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); 
        window.history.go(-1);
        </script>";
}
}
?>