<?php
session_start();
require_once 'connection.php';
require_once 'registration_validator.php';
require_once 'email_service.php';

// Initialize variables
$registrationSuccess = false;
$errors = [];
$warnings = [];
$customerData = null;
$emailSent = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create validator instance
    $validator = new RegistrationValidator();

    // Validate registration data
    $validationResult = $validator->validateCustomerRegistration($_POST);

    if ($validationResult['status'] === 'success') {
        // Extract validated data
        $customerData = $validationResult['data'];
        $warnings = $validationResult['warnings'];

        // Attempt to register the customer
        $conn = Connect();

        // Use prepared statement for security
        $query = "INSERT INTO customers (customer_name, customer_username, customer_email, customer_phone, customer_address, customer_password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Hash password for security
            $hashedPassword = password_hash($customerData['customer_password'], PASSWORD_DEFAULT);

            $stmt->bind_param("ssssss",
                $customerData['customer_name'],
                $customerData['customer_username'],
                $customerData['customer_email'],
                $customerData['customer_phone'],
                $customerData['customer_address'],
                $hashedPassword
            );

            if ($stmt->execute()) {
                $registrationSuccess = true;

                // Send welcome email
                $emailService = new EmailService();
                $emailSent = $emailService->sendWelcomeEmail(
                    $customerData['customer_email'],
                    $customerData['customer_name'],
                    'customer'
                );

                // Store success data in session to prevent refresh issues
                $_SESSION['registration_success'] = [
                    'name' => $customerData['customer_name'],
                    'email' => $customerData['customer_email'],
                    'email_sent' => $emailSent
                ];

                // Redirect to prevent form resubmission
                header("Location: customer_registered_success.php");
                exit();

            } else {
                $errors[] = "Registration failed. Please try again. Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $errors[] = "System error. Please try again later.";
        }

        $conn->close();

    } else {
        // Validation failed
        $errors = $validationResult['errors'];
        $warnings = $validationResult['warnings'];
    }
} else {
    // Check if we have success data from redirect
    if (isset($_SESSION['registration_success'])) {
        $registrationSuccess = true;
        $customerData = [
            'customer_name' => $_SESSION['registration_success']['name'],
            'customer_email' => $_SESSION['registration_success']['email']
        ];
        $emailSent = $_SESSION['registration_success']['email_sent'];

        // Clear session data
        unset($_SESSION['registration_success']);
    } else {
        // No POST data and no success data - redirect to signup page
        header("Location: customersignup.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { padding-top: 56px; background-color: #f8f9fa; }
        .content { margin-top: 2rem; padding-bottom: 70px; }
        .success-card { background-color: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .success-header { background-color: #28a745; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .error-card { background-color: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); border-left: 5px solid #dc3545; }
        .error-header { background-color: #dc3545; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .btn-back { margin-top: 20px; }
        .icon-large { font-size: 3rem; margin-bottom: 1rem; }
        .error-icon { color: #dc3545; }
        .success-icon { color: #28a745; }
        .warning-icon { color: #ffc107; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <?php if ($registrationSuccess): ?>
                        <!-- Success Message -->
                        <div class="card success-card">
                            <div class="card-header success-header text-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-check-circle"></i> Registration Successful!
                                </h4>
                            </div>
                            <div class="card-body text-center">
                                <div class="icon-large success-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>

                                <h3>Welcome <?php echo htmlspecialchars($customerData['customer_name']); ?>!</h3>
                                <p class="lead">Your customer account has been created successfully.</p>

                                <!-- Email Status -->
                                <?php if ($emailSent): ?>
                                    <div class="alert alert-success" role="alert">
                                        <i class="fas fa-envelope-check"></i>
                                        <strong>Welcome email sent!</strong><br>
                                        Please check your email at <strong><?php echo htmlspecialchars($customerData['customer_email']); ?></strong> for further instructions and login details.
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Account created successfully!</strong><br>
                                        However, we couldn
't send the welcome email. Please contact support if you need assistance.
                                    </div>
                                <?php endif; ?>

                                <!-- Warnings -->
                                <?php if (!empty($warnings)): ?>
                                    <div class="alert alert-info" role="alert">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Please Note:</strong>
                                        <ul class="mb-0 mt-2 text-left">
                                            <?php foreach ($warnings as $warning): ?>
                                                <li><?php echo htmlspecialchars($warning); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Next Steps -->
                                <div class="mt-4">
                                    <h5>What's Next?</h5>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="card border-success">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-sign-in-alt fa-2x text-success mb-2"></i>
                                                    <h6>Login</h6>
                                                    <p class="small">Access your account</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-primary">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-car fa-2x text-primary mb-2"></i>
                                                    <h6>Browse Cars</h6>
                                                    <p class="small">Explore our fleet</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-info">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                                                    <h6>Make Booking</h6>
                                                    <p class="small">Reserve your ride</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4">
                                    <a href="customerlogin.php" class="btn btn-success btn-lg mr-3">
                                        <i class="fas fa-sign-in-alt"></i> Login Now
                                    </a>
                                    <a href="index.php" class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-home"></i> Browse Cars
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Error Message -->
                        <div class="card error-card">
                            <div class="card-header error-header text-center">

                                <h4 class="mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> Registration Failed
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="icon-large error-icon">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                    <h3>Oops! Something went wrong</h3>
                                    <p class="lead">We couldn't create your account. Please review the errors below and try again.</p>
                                </div>

                                <!-- Error Messages -->
                                <?php if (!empty($errors)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <strong>Please fix the following issues:</strong>
                                        <ul class="mb-0 mt-2">
                                            <?php foreach ($errors as $error): ?>
                                                <li><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Warnings -->
                                <?php if (!empty($warnings)): ?>
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Please Note:</strong>
                                        <ul class="mb-0 mt-2">
                                            <?php foreach ($warnings as $warning): ?>
                                                <li><?php echo htmlspecialchars($warning); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Help Section -->
                                <div class="mt-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6><i class="fas fa-lightbulb text-warning"></i> Need Help?</h6>
                                            <ul class="mb-0">
                                                <li>Make sure all required fields are filled out</li>
                                                <li>Check that your email address is valid and not already registered</li>
                                                <li>Choose a unique username that hasn't been taken</li>
                                                <li>Ensure your password is at least 6 characters long</li>
                                                <li>If you already have an account, try <a href="customerlogin.php">logging in</a> instead</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="text-center mt-4">
                                    <a href="customersignup.php" class="btn btn-primary btn-lg mr-3">
                                        <i class="fas fa-redo"></i> Try Again
                                    </a>
                                    <a href="customerlogin.php" class="btn btn-outline-success btn-lg">
                                        <i class="fas fa-sign-in-alt"></i> Login Instead
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Additional Help -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-question-circle text-info"></i> Need Support?</h6>
                                    <p class="mb-0">
                                        <i class="fas fa-phone"></i> <?php echo CONTACT_NUM; ?><br>
                                        <i class="fas fa-envelope"></i> <?php echo CONTACT_EMAIL; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-info-circle text-info"></i> Account Benefits</h6>
                                    <ul class="mb-0">
                                        <li>Access to our full fleet</li>
                                        <li>Online booking management</li>
                                        <li>Exclusive member discounts</li>
                                        <li>Priority customer support</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Auto-hide alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
