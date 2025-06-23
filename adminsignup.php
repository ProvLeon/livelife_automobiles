<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup | LiveLife Automobiles</title>
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
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Admin Signup</h4>
                    </div>
                    <div class="card-body">
                        <div id="alertContainer"></div>
                        <form action="admin_registered_success.php" method="POST" id="adminSignupForm">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="client_name"><i class="fas fa-user"></i> Full Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name" required minlength="2" maxlength="50" pattern="[a-zA-Z\s]+" title="Name should contain only letters and spaces">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_username"><i class="fas fa-user-tag"></i> Username</label>
                                    <input type="text" class="form-control" id="client_username" name="client_username" required minlength="3" maxlength="20" pattern="[a-zA-Z0-9_]+" title="Username should contain only letters, numbers, and underscores">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Username is available!</div>
                                    <small class="form-text text-muted">3-20 characters, letters, numbers, and underscores only</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="client_email"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" class="form-control" id="client_email" name="client_email" required>
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Email is available!</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_phone"><i class="fas fa-phone"></i> Phone</label>
                                    <input type="tel" class="form-control" id="client_phone" name="client_phone" required pattern="[\+]?[0-9\-\(\)\s]{10,20}" title="Please enter a valid phone number">
                                    <div class="invalid-feedback"></div>
                                    <div class="valid-feedback">Phone number format is valid!</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="client_address"><i class="fas fa-map-marker-alt"></i> Address</label>
                                <input type="text" class="form-control" id="client_address" name="client_address" required minlength="5" maxlength="200">
                                <div class="invalid-feedback"></div>
                                <div class="valid-feedback">Address looks good!</div>
                            </div>
                            <div class="form-group">
                                <label for="client_password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="client_password" name="client_password" required minlength="8" maxlength="50">
                                <div class="invalid-feedback"></div>
                                <div class="valid-feedback">Password strength is good!</div>
                                <small class="form-text text-muted">Minimum 8 characters for admin accounts</small>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="adminTermsCheck" required>
                                    <label class="form-check-label" for="adminTermsCheck">
                                        I agree to the <a href="#" data-toggle="modal" data-target="#adminTermsModal">Admin Terms and Conditions</a>
                                    </label>
                                    <div class="invalid-feedback">You must agree to the admin terms and conditions.</div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" id="adminSubmitBtn">
                                <span id="adminSubmitSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                <span id="adminSubmitText">Sign Up</span>
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Already have an account? <a href="adminlogin.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Admin Terms and Conditions Modal -->
    <div class="modal fade" id="adminTermsModal" tabindex="-1" role="dialog" aria-labelledby="adminTermsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminTermsModalLabel">Admin Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Administrator Responsibilities</h6>
                    <p>As an administrator, you have access to sensitive system functions and customer data. You agree to use these privileges responsibly and maintain the confidentiality of all information.</p>

                    <h6>Security Requirements</h6>
                    <p>You must maintain strong password security, log out when finished, and immediately report any security incidents or unauthorized access attempts.</p>

                    <h6>System Management</h6>
                    <p>You are responsible for proper management of the car rental system, including vehicle and driver information, booking management, and customer support.</p>

                    <h6>Data Protection</h6>
                    <p>All customer data must be handled in accordance with privacy laws and company policies. Unauthorized sharing or misuse of customer information is strictly prohibited.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="document.getElementById('adminTermsCheck').checked = true;">I Agree</button>
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

            // Real-time validation functions
            function showFieldError(fieldId, message) {
                const field = $('#' + fieldId);
                field.removeClass('is-valid').addClass('is-invalid');
                field.siblings('.invalid-feedback').text(message);
            }

            function showFieldSuccess(fieldId, message = '') {
                const field = $('#' + fieldId);
                field.removeClass('is-invalid').addClass('is-valid');
                if (message) {
                    field.siblings('.valid-feedback').text(message);
                }
            }

            function clearFieldStatus(fieldId) {
                const field = $('#' + fieldId);
                field.removeClass('is-invalid is-valid');
            }

            // Check username availability
            function checkUsername(username) {
                if (username.length < 3) return;

                $.ajax({
                    url: 'check_availability.php',
                    method: 'POST',
                    data: {
                        type: 'username',
                        value: username,
                        user_type: 'admin'
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.available) {
                            showFieldSuccess('client_username', 'Username is available!');
                        } else {
                            showFieldError('client_username', 'This username is already taken');
                        }
                    },
                    error: function() {
                        clearFieldStatus('client_username');
                    }
                });
            }

            // Check email availability
            function checkEmail(email) {
                if (!email.includes('@')) return;

                $.ajax({
                    url: 'check_availability.php',
                    method: 'POST',
                    data: {
                        type: 'email',
                        value: email,
                        user_type: 'admin'
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.available) {
                            showFieldSuccess('client_email', 'Email is available!');
                        } else {
                            showFieldError('client_email', 'An account with this email already exists');
                        }
                    },
                    error: function() {
                        clearFieldStatus('client_email');
                    }
                });
            }

            // Optional real-time validation (non-blocking)
            $('#client_username').on('input', function() {
                const value = $(this).val();
                clearTimeout(usernameCheckTimeout);

                if (value.length >= 3 && /^[a-zA-Z0-9_]+$/.test(value)) {
                    // Check availability after 500ms delay
                    usernameCheckTimeout = setTimeout(() => checkUsername(value), 500);
                }
            });

            $('#client_email').on('input', function() {
                const value = $(this).val();
                clearTimeout(emailCheckTimeout);

                if (value.includes('@') && value.includes('.')) {
                    // Check availability after 500ms delay
                    emailCheckTimeout = setTimeout(() => checkEmail(value), 500);
                }
            });

            // Form submission
            $('#adminSignupForm').on('submit', function(e) {
                e.preventDefault();

                // Show loading state
                $('#adminSubmitSpinner').removeClass('d-none');
                $('#adminSubmitText').text('Creating Admin Account...');
                $('#adminSubmitBtn').prop('disabled', true);

                // Basic validation - only check required fields and terms
                let isValid = true;
                let errors = [];

                const requiredFields = {
                    'client_name': 'Full Name',
                    'client_username': 'Username',
                    'client_email': 'Email',
                    'client_phone': 'Phone',
                    'client_address': 'Address',
                    'client_password': 'Password'
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
                if (!$('#adminTermsCheck').is(':checked')) {
                    errors.push('You must agree to the admin terms and conditions');
                    $('#adminTermsCheck').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#adminTermsCheck').removeClass('is-invalid');
                }

                // Only check if basic validation passed
                if (isValid) {
                    // Submit the form
                    this.submit();
                    return;
                }

                // Reset button state
                $('#adminSubmitSpinner').addClass('d-none');
                $('#adminSubmitText').text('Sign Up');
                $('#adminSubmitBtn').prop('disabled', false);

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
            $('#adminTermsCheck').on('change', function() {
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
