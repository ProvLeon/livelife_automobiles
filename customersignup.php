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
                        <form action="customer_registered_success.php" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="customer_name"><i class="fas fa-user"></i> Full Name</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customer_username"><i class="fas fa-user-tag"></i> Username</label>
                                    <input type="text" class="form-control" id="customer_username" name="customer_username" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="customer_email"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customer_phone"><i class="fas fa-phone"></i> Phone</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="customer_address"><i class="fas fa-map-marker-alt"></i> Address</label>
                                <input type="text" class="form-control" id="customer_address" name="customer_address" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="customer_password" name="customer_password" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Sign Up</button>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
