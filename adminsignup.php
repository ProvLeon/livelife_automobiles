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
                        <form action="admin_registered_success.php" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="client_name"><i class="fas fa-user"></i> Full Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_username"><i class="fas fa-user-tag"></i> Username</label>
                                    <input type="text" class="form-control" id="client_username" name="client_username" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="client_email"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" class="form-control" id="client_email" name="client_email" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_phone"><i class="fas fa-phone"></i> Phone</label>
                                    <input type="tel" class="form-control" id="client_phone" name="client_phone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="client_address"><i class="fas fa-map-marker-alt"></i> Address</label>
                                <input type="text" class="form-control" id="client_address" name="client_address" required>
                            </div>
                            <div class="form-group">
                                <label for="client_password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="client_password" name="client_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
