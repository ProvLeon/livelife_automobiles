<?php
require_once 'config.php';
require_once 'sendMail/PHPMailerAutoload.php';

class EmailService {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer;
        $this->setupSMTP();
    }

    private function setupSMTP() {
        $this->mail->isSMTP();
        $this->mail->Host = SMTP_HOST;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = EMAIL_ACC;
        $this->mail->Password = EMAIL_PASSWORD;
        $this->mail->SMTPSecure = SMTP_SECURE;
        $this->mail->Port = SMTP_PORT;
        $this->mail->isHTML(true);

        // Set from address
        $this->mail->setFrom(EMAIL_ACC, 'LiveLife Automobiles');
    }

    public function sendWelcomeEmail($recipientEmail, $recipientName, $userType = 'customer') {
        try {
            // Clear any previous recipients
            $this->mail->clearAddresses();

            // Add recipient
            $this->mail->addAddress($recipientEmail, $recipientName);

            // Set email subject
            $this->mail->Subject = 'Welcome to LiveLife Automobiles - Registration Successful!';

            // Create email body
            $emailBody = $this->createWelcomeEmailBody($recipientName, $userType);
            $this->mail->Body = $emailBody;

            // Create plain text alternative
            $this->mail->AltBody = $this->createPlainTextWelcome($recipientName, $userType);

            // Send email
            if ($this->mail->send()) {
                return true;
            } else {
                error_log('Email sending failed: ' . $this->mail->ErrorInfo);
                return false;
            }
        } catch (Exception $e) {
            error_log('Email exception: ' . $e->getMessage());
            return false;
        }
    }

    private function createWelcomeEmailBody($name, $userType) {
        $loginUrl = ($userType === 'admin') ? 'adminlogin.php' : 'customerlogin.php';
        $panelName = ($userType === 'admin') ? 'Admin Panel' : 'Customer Dashboard';

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Welcome to LiveLife Automobiles</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #28a745; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background-color: #f8f9fa; padding: 30px; border-radius: 0 0 5px 5px; }
                .welcome-box { background-color: white; padding: 20px; border-radius: 5px; margin: 20px 0; }
                .button { display: inline-block; background-color: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
                .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
                .logo { font-size: 24px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="logo">LiveLife Automobiles</div>
                    <h2>Welcome Aboard!</h2>
                </div>

                <div class="content">
                    <div class="welcome-box">
                        <h3>Hello ' . htmlspecialchars($name) . '!</h3>

                        <p>Congratulations! Your account has been successfully created with LiveLife Automobiles.</p>

                        <p>We are excited to have you join our community of automotive enthusiasts. Whether you\'re looking to rent a car for a weekend getaway, a business trip, or any other occasion, we\'re here to provide you with reliable and comfortable vehicles.</p>

                        <h4>What\'s Next?</h4>
                        <ul>
                            <li>Login to your account using your credentials</li>
                            <li>Browse our extensive fleet of vehicles</li>
                            <li>Make your first booking</li>
                            <li>Enjoy the LiveLife experience!</li>
                        </ul>

                        <div style="text-align: center; margin: 25px 0;">
                            <a href="http://' . $_SERVER['HTTP_HOST'] . '/livelife_automobiles/' . $loginUrl . '" class="button">
                                Access Your ' . $panelName . '
                            </a>
                        </div>

                        <p><strong>Need Help?</strong><br>
                        If you have any questions or need assistance, feel free to contact us:</p>
                        <ul>
                            <li>Phone: ' . CONTACT_NUM . '</li>
                            <li>Email: ' . CONTACT_EMAIL . '</li>
                        </ul>
                    </div>
                </div>

                <div class="footer">
                    <p>Thank you for choosing LiveLife Automobiles!</p>
                    <p>&copy; ' . date('Y') . ' LiveLife Automobiles. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    private function createPlainTextWelcome($name, $userType) {
        $loginUrl = ($userType === 'admin') ? 'adminlogin.php' : 'customerlogin.php';
        $panelName = ($userType === 'admin') ? 'Admin Panel' : 'Customer Dashboard';

        return "
Welcome to LiveLife Automobiles!

Hello $name!

Congratulations! Your account has been successfully created with LiveLife Automobiles.

We are excited to have you join our community of automotive enthusiasts. Whether you're looking to rent a car for a weekend getaway, a business trip, or any other occasion, we're here to provide you with reliable and comfortable vehicles.

What's Next?
- Login to your account using your credentials
- Browse our extensive fleet of vehicles
- Make your first booking
- Enjoy the LiveLife experience!

Access Your $panelName: http://" . $_SERVER['HTTP_HOST'] . "/livelife_automobiles/$loginUrl

Need Help?
If you have any questions or need assistance, feel free to contact us:
- Phone: " . CONTACT_NUM . "
- Email: " . CONTACT_EMAIL . "

Thank you for choosing LiveLife Automobiles!

© " . date('Y') . " LiveLife Automobiles. All rights reserved.
        ";
    }

    public function sendBookingConfirmation($recipientEmail, $recipientName, $bookingDetails) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($recipientEmail, $recipientName);

            $this->mail->Subject = 'Booking Confirmation - LiveLife Automobiles';

            $emailBody = $this->createBookingConfirmationBody($recipientName, $bookingDetails);
            $this->mail->Body = $emailBody;

            $this->mail->AltBody = "Hello $recipientName, your booking has been confirmed. Booking ID: " . $bookingDetails['booking_id'];

            return $this->mail->send();
        } catch (Exception $e) {
            error_log('Booking email exception: ' . $e->getMessage());
            return false;
        }
    }

    private function createBookingConfirmationBody($name, $details) {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Booking Confirmation</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background-color: #f8f9fa; padding: 30px; border-radius: 0 0 5px 5px; }
                .booking-details { background-color: white; padding: 20px; border-radius: 5px; margin: 20px 0; }
                .detail-row { margin: 10px 0; padding: 10px; background-color: #f8f9fa; border-radius: 3px; }
                .car-image { max-width: 200px; height: auto; border-radius: 8px; margin: 15px 0; }
                .total-cost { background-color: #28a745; color: white; padding: 15px; border-radius: 5px; text-align: center; margin: 15px 0; }
                .contact-info { background-color: #e9ecef; padding: 15px; border-radius: 5px; margin: 15px 0; }
                .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div style="font-size: 24px; font-weight: bold;">LiveLife Automobiles</div>
                    <h2>Booking Confirmed!</h2>
                </div>

                <div class="content">
                    <div class="booking-details">
                        <h3>Hello ' . htmlspecialchars($name) . '!</h3>
                        <p>Great news! Your car rental booking has been confirmed. Here are your booking details:</p>

                        <div class="detail-row">
                            <strong>Booking ID:</strong> ' . htmlspecialchars($details['booking_id']) . '
                        </div>

                        <div class="detail-row">
                            <strong>Car:</strong> ' . htmlspecialchars($details['car_name']) . ' (' . htmlspecialchars($details['car_nameplate']) . ')
                        </div>

                        <div class="detail-row">
                            <strong>Rental Period:</strong> ' . htmlspecialchars($details['start_date']) . ' to ' . htmlspecialchars($details['end_date']) . '
                        </div>

                        <div class="detail-row">
                            <strong>Duration:</strong> ' . htmlspecialchars($details['no_of_days']) . ' day(s)
                        </div>

                        <div class="detail-row">
                            <strong>Charge Type:</strong> ' . ucfirst(htmlspecialchars($details['charge_type'])) . '
                        </div>

                        <div class="detail-row">
                            <strong>Driver:</strong> ' . htmlspecialchars($details['driver_name']) . ' (Phone: ' . htmlspecialchars($details['driver_phone']) . ')
                        </div>

                        <div class="total-cost">
                            <h4 style="margin: 0;">Total Amount: ' . CURRENCY . number_format($details['total_amount'], 2) . '</h4>
                        </div>

                        <div class="contact-info">
                            <h4>Important Information:</h4>
                            <ul>
                                <li>Please arrive 15 minutes before your rental start time</li>
                                <li>Bring a valid driver\'s license and ID</li>
                                <li>Your assigned driver will contact you before pickup</li>
                                <li>Keep this confirmation email for your records</li>
                            </ul>
                        </div>

                        <div class="contact-info">
                            <h4>Need Help?</h4>
                            <p>If you have any questions or need to make changes to your booking, please contact us:</p>
                            <ul>
                                <li>Phone: ' . CONTACT_NUM . '</li>
                                <li>Email: ' . CONTACT_EMAIL . '</li>
                            </ul>
                        </div>

                        <p style="text-align: center; margin-top: 30px;">
                            <strong>Thank you for choosing LiveLife Automobiles!</strong><br>
                            We look forward to serving you.
                        </p>
                    </div>
                </div>

                <div class="footer">
                    <p>&copy; ' . date('Y') . ' LiveLife Automobiles. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';
    }
}
?>
