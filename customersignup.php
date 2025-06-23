<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Signup | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Customer Signup</h4>
                    </div>
                    <div class="card-body">
                        <div id="alertContainer"></div>
                        <form action="customer_registered_success.php" method="POST" id="customerSignupForm">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="customer_name"><i class="fas fa-user"></i> Full Name</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required minlength="2" maxlength="50" pattern="[a-zA-Z\s]+" title="Name should contain only letters and spaces">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customer_username"><i class="fas fa-user-tag"></i> Username</label>
                                    <input type="text" class="form-control" id="customer_username" name="customer_username" required minlength="3" maxlength="20" pattern="[a-zA-Z0-9_]+" title="Username should contain only letters, numbers, and underscores">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Username is available!</div>
                                    <small class="form-text text-muted">3-20 characters, letters, numbers, and underscores only</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="customer_email"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Email is available!</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customer_phone"><i class="fas fa-phone"></i> Phone</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required pattern="[\+]?[0-9\-\(\)\s]{10,20}" title="Please enter a valid phone number">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Phone number format is valid!</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="customer_address"><i class="fas fa-map-marker-alt"></i> Address</label>
                                <input type="text" class="form-control" id="customer_address" name="customer_address" required minlength="5" maxlength="200">
                                <div class="invalid-feedback"></div>
                                <div class="valid-feedback">Address looks good!</div>
                            </div>
                            <div class="form-group">
                                <label for="customer_password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="customer_password" name="customer_password" required minlength="6" maxlength="50">
                                <div class="invalid-feedback"></div>
                                <div class="valid-feedback">Password strength is good!</div>
                                <small class="form-text text-muted">Minimum 6 characters</small>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a>
                                    </label>
                                    <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block" id="submitBtn">
                                <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                <span id="submitText">Sign Up</span>
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Already have an account? <a href="customerlogin.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Account Registration</h6>
                    <p>By creating an account with LiveLife Automobiles, you agree to provide accurate and complete information. You are responsible for maintaining the confidentiality of your account credentials.</p>

                    <h6>Data Usage</h6>
                    <p>We collect and use your personal information to provide our car rental services, process bookings, and communicate with you about your reservations.</p>

                    <h6>Service Agreement</h6>
                    <p>Our rental services are subject to availability and our standard rental terms. All bookings are subject to verification and approval.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="document.getElementById('termsCheck').checked = true;">I Agree</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            let usernameCheckTimeout;
            let emailCheckTimeout;
            let usernameValidated = false;
            let emailValidated = false;
            let isCheckingUsername = false;
            let isCheckingEmail = false;

            // Real-time validation functions
            function showFieldError(fieldId, message) {
                const field = $('#' + fieldId);
                field.removeClass('is-valid').addClass('is-invalid');
                field.siblings('.invalid-feedback').text(message);

                // Update validation flags
                if (fieldId === 'customer_username') {
                    usernameValidated = false;
                } else if (fieldId === 'customer_email') {
                    emailValidated = false;
                }
            }

            function showFieldSuccess(fieldId, message = '') {
                const field = $('#' + fieldId);
                field.removeClass('is-invalid').addClass('is-valid');
                if (message) {
                    field.siblings('.valid-feedback').text(message);
                }

                // Update validation flags
                if (fieldId === 'customer_username') {
                    usernameValidated = true;
                } else if (fieldId === 'customer_email') {
                    emailValidated = true;
                }
            }

            function clearFieldStatus(fieldId) {
                const field = $('#' + fieldId);
                field.removeClass('is-invalid is-valid');

                // Reset validation flags
                if (fieldId === 'customer_username') {
                    usernameValidated = false;
                } else if (fieldId === 'customer_email') {
                    emailValidated = false;
                }
            }

            // Check username availability
            function checkUsername(username) {
                if (username.length < 3) return;

                isCheckingUsername = true;

                $.ajax({
                    url: 'check_availability.php',
                    method: 'POST',
                    data: {
                        type: 'username',
                        value: username,
                        user_type: 'customer'
                    },
                    success: function(response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.available) {
                                showFieldSuccess('customer_username', 'Username is available!');
                            } else {
                                showFieldError('customer_username', 'This username is already taken');
                            }
                        } catch (e) {
                            console.error('Error parsing username check response:', e);
                            clearFieldStatus('customer_username');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Username check failed:', error);
                        clearFieldStatus('customer_username');
                    },
                    complete: function() {
                        isCheckingUsername = false;
                    }
                });
            }

            // Check email availability
            function checkEmail(email) {
                if (!email.includes('@')) return;

                isCheckingEmail = true;

                $.ajax({
                    url: 'check_availability.php',
                    method: 'POST',
                    data: {
                        type: 'email',
                        value: email,
                        user_type: 'customer'
                    },
                    success: function(response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.available) {
                                showFieldSuccess('customer_email', 'Email is available!');
                            } else {
                                showFieldError('customer_email', 'An account with this email already exists');
                            }
                        } catch (e) {
                            console.error('Error parsing email check response:', e);
                            clearFieldStatus('customer_email');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Email check failed:', error);
                        clearFieldStatus('customer_email');
                    },
                    complete: function() {
                        isCheckingEmail = false;
                    }
                });
            }

            // Optional real-time validation (non-blocking)
            $('#customer_username').on('input', function() {
                const value = $(this).val();
                clearTimeout(usernameCheckTimeout);

                if (value.length >= 3 && /^[a-zA-Z0-9_]+$/.test(value)) {
                    // Check availability after 500ms delay
                    usernameCheckTimeout = setTimeout(() => checkUsername(value), 500);
                }
            });

            $('#customer_email').on('input', function() {
                const value = $(this).val();
                clearTimeout(emailCheckTimeout);

                if (value.includes('@') && value.includes('.')) {
                    // Check availability after 500ms delay
                    emailCheckTimeout = setTimeout(() => checkEmail(value), 500);
                }
            });

            // Form submission
            $('#customerSignupForm').on('submit', function(e) {
                e.preventDefault();

                // Show loading state
                $('#submitSpinner').removeClass('d-none');
                $('#submitText').text('Creating Account...');
                $('#submitBtn').prop('disabled', true);

                // Basic validation - only check required fields and terms
                let isValid = true;
                let errors = [];

                const requiredFields = {
                    'customer_name': 'Full Name',
                    'customer_username': 'Username',
                    'customer_email': 'Email',
                    'customer_phone': 'Phone',
                    'customer_address': 'Address',
                    'customer_password': 'Password'
                };

                // Check required fields
                Object.keys(requiredFields).forEach(field => {
                    const fieldValue = $('#' + field).val().trim();
                    if (!fieldValue) {
                        errors.push(requiredFields[field] + ' is required');
                        $('#' + field).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#' + field).removeClass('is-invalid');
                    }
                });

                // Check terms checkbox
                if (!$('#termsCheck').is(':checked')) {
                    errors.push('You must agree to the terms and conditions');
                    $('#termsCheck').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#termsCheck').removeClass('is-invalid');
                }

                // Only check if basic validation passed
                if (isValid) {
                    // Submit the form
                    this.submit();
                    return;
                }

                // Reset button state
                $('#submitSpinner').addClass('d-none');
                $('#submitText').text('Sign Up');
                $('#submitBtn').prop('disabled', false);

                // Show specific errors
                let errorHtml = '<strong>Please fix the following issues:</strong><ul>';
                errors.forEach(error => {
                    errorHtml += '<li>' + error + '</li>';
                });
                errorHtml += '</ul>';

                $('#alertContainer').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        ${errorHtml}
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);

                // Scroll to first error
                const firstError = $('.is-invalid').first();
                if (firstError.length) {
                    firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            });

            // Terms checkbox validation
            $('#termsCheck').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>
