<?php
session_start();
require_once 'connection.php';
require_once 'registration_validator.php';
require_once 'email_service.php';

// Initialize variables
$registrationSuccess = false;
$errors = [];
$warnings = [];
$adminData = null;
$emailSent = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create validator instance
    $validator = new RegistrationValidator();

    // Validate registration data
    $validationResult = $validator->validateAdminRegistration($_POST);

    if ($validationResult['status'] === 'success') {
        // Extract validated data
        $adminData = $validationResult['data'];
        $warnings = $validationResult['warnings'];

        // Attempt to register the admin
        $conn = Connect();

        // Use prepared statement for security
        $query = "INSERT INTO clients (client_name, client_username, client_email, client_phone, client_address, client_password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Hash password for security
            $hashedPassword = password_hash($adminData['client_password'], PASSWORD_DEFAULT);

            $stmt->bind_param("ssssss",
                $adminData['client_name'],
                $adminData['client_username'],
                $adminData['client_email'],
                $adminData['client_phone'],
                $adminData['client_address'],
                $hashedPassword
            );

            if ($stmt->execute()) {
                $registrationSuccess = true;

                // Send welcome email
                $emailService = new EmailService();
                $emailSent = $emailService->sendWelcomeEmail(
                    $adminData['client_email'],
                    $adminData['client_name'],
                    'admin'
                );

                // Store success data in session to prevent refresh issues
                $_SESSION['admin_registration_success'] = [
                    'name' => $adminData['client_name'],
                    'email' => $adminData['client_email'],
                    'email_sent' => $emailSent
                ];

                // Redirect to prevent form resubmission
                header("Location: admin_registered_success.php");
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
    if (isset($_SESSION['admin_registration_success'])) {
        $registrationSuccess = true;
        $adminData = [
            'client_name' => $_SESSION['admin_registration_success']['name'],
            'client_email' => $_SESSION['admin_registration_success']['email']
        ];
        $emailSent = $_SESSION['admin_registration_success']['email_sent'];

        // Clear session data
        unset($_SESSION['admin_registration_success']);
    } else {
        // No POST data and no success data - redirect to signup page
        header("Location: adminsignup.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { padding-top: 56px; background-color: #f8f9fa; }
        .content { margin-top: 2rem; padding-bottom: 70px; }
        .success-card { background-color: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .success-header { background-color: #007bff; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .error-card { background-color: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); border-left: 5px solid #dc3545; }
        .error-header { background-color: #dc3545; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .btn-back { margin-top: 20px; }
        .icon-large { font-size: 3rem; margin-bottom: 1rem; }
        .error-icon { color: #dc3545; }
        .success-icon { color: #007bff; }
        .warning-icon { color: #ffc107; }
        .admin-badge { background: linear-gradient(45deg, #007bff, #0056b3); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; }
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
                                    <i class="fas fa-shield-alt"></i> Admin Registration Successful!
                                </h4>
                            </div>
                            <div class="card-body text-center">
                                <div class="icon-large success-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>

                                <h3>Welcome Administrator <?php echo htmlspecialchars($adminData['client_name']); ?>!</h3>
                                <span class="admin-badge">
                                    <i class="fas fa-star"></i> Admin Account
                                </span>
                                <p class="lead mt-3">Your administrator account has been created successfully.</p>

                                <!-- Email Status -->
                                <?php if ($emailSent): ?>
                                    <div class="alert alert-success" role="alert">
                                        <i class="fas fa-envelope-check"></i>
                                        <strong>Welcome email sent!</strong><br>
                                        Please check your email at <strong><?php echo htmlspecialchars($adminData['client_email']); ?></strong> for admin access instructions and security guidelines.
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Account created successfully!</strong><br>
                                        However, we couldn't send the welcome email. Please contact support if you need assistance.
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

                                <!-- Admin Privileges -->
                                <div class="mt-4">
                                    <h5><i class="fas fa-tools"></i> Admin Privileges</h5>
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <div class="card border-primary">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-car fa-2x text-primary mb-2"></i>
                                                    <h6>Car Management</h6>
                                                    <p class="small">Add, edit, remove vehicles</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-success">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-id-card fa-2x text-success mb-2"></i>
                                                    <h6>Driver Management</h6>
                                                    <p class="small">Manage driver profiles</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-warning">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                                                    <h6>Booking Control</h6>
                                                    <p class="small">View and manage bookings</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-info">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-users fa-2x text-info mb-2"></i>
                                                    <h6>User Management</h6>
                                                    <p class="small">Manage customer accounts</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Notice -->
                                <div class="mt-4">
                                    <div class="card bg-warning border-warning">
                                        <div class="card-body">
                                            <h6><i class="fas fa-shield-alt"></i> Security Reminder</h6>
                                            <ul class="mb-0 text-left">
                                                <li>Keep your admin credentials secure and confidential</li>
                                                <li>Always log out when finished with admin tasks</li>
                                                <li>Monitor system activity regularly</li>
                                                <li>Report any suspicious activity immediately</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4">
                                    <a href="adminlogin.php" class="btn btn-primary btn-lg mr-3">
                                        <i class="fas fa-sign-in-alt"></i> Access Admin Panel
                                    </a>
                                    <a href="index.php" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-home"></i> View Site
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Error Message -->
                        <div class="card error-card">
                            <div class="card-header error-header text-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> Admin Registration Failed
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="icon-large error-icon">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                    <h3>Registration Error</h3>
                                    <p class="lead">We couldn't create your administrator account. Please review the errors below and try again.</p>
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
                                            <h6><i class="fas fa-lightbulb text-warning"></i> Admin Registration Requirements</h6>
                                            <ul class="mb-0">
                                                <li>All fields must be completed with valid information</li>
                                                <li>Email address must be unique and not already registered</li>
                                                <li>Username must be unique across the entire system</li>
                                                <li>Password must be at least 8 characters long for security</li>
                                                <li>Use a professional email address for admin communications</li>
                                                <li>If you already have an account, try <a href="adminlogin.php">logging in</a> instead</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="text-center mt-4">
                                    <a href="adminsignup.php" class="btn btn-primary btn-lg mr-3">
                                        <i class="fas fa-redo"></i> Try Again
                                    </a>
                                    <a href="adminlogin.php" class="btn btn-outline-success btn-lg">
                                        <i class="fas fa-sign-in-alt"></i> Login Instead
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Additional Information -->
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
                                    <h6><i class="fas fa-info-circle text-info"></i> Admin Responsibilities</h6>
                                    <ul class="mb-0">
                                        <li>Fleet and driver management</li>
                                        <li>Customer support and assistance</li>
                                        <li>System monitoring and maintenance</li>
                                        <li>Business operations oversight</li>
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
