<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        /* CSS Reset */ */
        /* .livelife-navbar * {
            margin: 0;
            padding: 1;
            box-sizing: border-box;

        } */

        /* Navbar Styles */
        .livelife-navbar {
            padding-top: 70px; /* Adjust this value to match your navbar height */
        }
        .livelife-navbar .navbar {
            height: 70px;
            background-color: #2c3e50;
            padding: 0.5rem 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            transition: all 0.3s ease;
        }
        .livelife-navbar .navbar-brand {
            font-weight: bold;
            color: #ecf0f1 !important;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        .livelife-navbar .navbar-brand:hover {
            color: #3498db !important;
        }
        .livelife-navbar .navbar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .livelife-navbar .navbar-nav .nav-link {
            color: #bdc3c7 !important;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
            display: flex;
        }
        .livelife-navbar .navbar-nav .nav-link:hover {
            color: #3498db !important;
        }
        .livelife-navbar .navbar-nav .active > .nav-link {
            color: #3498db !important;
        }
        .livelife-navbar .btn-outline-light {
            border-color: #bdc3c7;
            color: #bdc3c7;
            transition: all 0.3s ease;
        }
        .livelife-navbar .btn-outline-light:hover {
            background-color: #3498db;
            border-color: #3498db;
            color: #fff;
        }
        .livelife-navbar .navbar-text {
            color: #ecf0f1;
        }
        @media (max-width: 991.98px) {
            .livelife-navbar .navbar-nav {
                padding-top: 0.5rem;
            }
            .livelife-navbar .navbar-nav.ml-auto {
                padding-top: 0.5rem;
            }
        }
    </style>
</head>
<body class="livelife-navbar">

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">LiveLife Automobiles</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if(isset($_SESSION['login_admin']) || isset($_SESSION['login_customer'])): ?>
                <ul class="navbar-nav mr-auto">
                    <?php if(isset($_SESSION['login_admin'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="entercar.php">Manage Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="enterdriver.php">Manage Drivers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminview.php">View Bookings</a>
                        </li>
                    <?php elseif(isset($_SESSION['login_customer'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="prereturncar.php">Return Car</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mybookings.php">My Bookings</a>
                        </li>
                    <?php endif; ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="faq.php">FAQ</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="navbar-text mr-3">
                            Welcome, <?php echo isset($_SESSION['login_admin']) ? $_SESSION['login_admin'] . ' (Admin)' : $_SESSION['login_customer']; ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminlogin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customerlogin.php">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="faq.php">FAQ</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
