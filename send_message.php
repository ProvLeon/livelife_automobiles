<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/sendMail/PHPMailerAutoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = EMAIL_ACC;
        $mail->Password   = EMAIL_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(EMAIL_ACC, 'LiveLife Automobiles');
        $mail->addAddress(EMAIL_ACC, 'LiveLife Automobiles');
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Inquiry from LiveLife Automobiles Website';
        $mail->Body    = "
        <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #4CAF50; color: white; padding: 10px; text-align: center; }
                    .content { background-color: #f9f9f9; padding: 20px; border-radius: 5px; }
                    .footer { text-align: center; margin-top: 20px; font-size: 0.8em; color: #777; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>New Customer Inquiry</h2>
                    </div>
                    <div class='content'>
                        <p><strong>Name:</strong> $name</p>
                        <p><strong>Email:</strong> $email</p>
                        <h3>Message:</h3>
                        <p>" . nl2br($message) . "</p>
                    </div>
                    <div class='footer'>
                        <p>This email was sent from the contact form on the LiveLife Automobiles website.</p>
                        <p>© " . date("Y") . " LiveLife Automobiles. All rights reserved.</p>
                    </div>
                </div>
            </body>
        </html>";

        $mail->AltBody = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        $response = array('status' => 'success', 'message' => 'Your message has been sent successfully.');
    } catch (Exception $e) {
        $response = array('status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If not a POST request, redirect to the home page
header("Location: index.php");
?>
