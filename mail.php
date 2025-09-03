<?php
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// php -S localhost:8000
$name = $_POST['inputname'];
$email = $_POST['inputemail'];
$phone = $_POST['inputphone'] || 'No especificado';
$company = $_POST['inputcompany'] || 'No especificada';
$subject = $_POST['inputsubject'];
$message = $_POST['inputmessage'];

if (!$name || !$email || !$phone || !$company || !$subject || !$message) {
  die('Invalid form');
}
#>echo "Los datos name: $name, email: $email, phone: $phone, company: $company, subject: $subject, message: $message";



$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'mail.networkspa.cl'; // Replace with your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'page@networkspa.cl'; // Your email
    $mail->Password   = 'D0pe32@#%&';      // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Or PHPMailer::ENCRYPTION_SMTPS for SSL
    $mail->Port       = 465; // Use 465 for SSL, 587 for TLS

    // Recipients
    $mail->setFrom('page@networkspa.cl', 'Mensaje desde Pagina Web');
    $mail->addAddress('mbensan@gmail.com'); // Add a recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $body = '<h2>Tiene un mensaje desde la página web</h2>';
    $body .= "<p>De: $name. Email: $email. Compañia: $company</p>";
    $body .= "<h3>Mensaje:</h3><p>$message</p>";
    $mail->Body    = $body;

    $mail->AltBody = 'This is a plain-text version of the email.';

    $mail->send();
    
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Email sent successfully.']);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
}
?>