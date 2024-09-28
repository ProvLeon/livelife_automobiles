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
        /* CSS Reset for footer elements */
        /* .livelife-footer * {
            /* margin: 0;
            padding: 0;
            box-sizing: border-box; */
        } */

        /* Sticky Footer Styles */
        html, body {
            height: 100%;
        }

        /* body {
            display: flex;
            flex-direction: column;
        } */

        .content-wrapper {
            flex: 1 0 auto;
        }

        /* Footer Styles */
        .livelife-footer {
            background-color: #2c3e50;
            color: #bdc3c7;
            padding: 3rem 0 1rem;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .livelife-footer h5 {
            color: #ecf0f1 !important;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        .livelife-footer p {
            line-height: 1.6;
        }

        .livelife-footer .footer-nav {
            list-style: none;
            padding-left: 0;
        }

        .livelife-footer .footer-nav .footer-link {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .livelife-footer .footer-nav .footer-link:hover {
            color: #3498db;
        }

        .livelife-footer address {
            font-style: normal;
            line-height: 1.6;
        }

        .livelife-footer hr {
            border-top: 1px solid #34495e;
            margin: 2rem 0 1rem;
        }

        .livelife-footer .copyright {
            color: #95a5a6;
        }

        .livelife-footer .footer-bottom-links {
            text-align: right;
        }

        .livelife-footer .footer-bottom-links a {
            color: #95a5a6;
            text-decoration: none;
            transition: color 0.3s ease;
            margin-left: 1rem;
        }

        .livelife-footer .footer-bottom-links a:hover {
            color: #3498db;
        }

        .livelife-footer .social-icons {
            margin-top: 1rem;
        }

        .livelife-footer .social-icons a {
            color: #bdc3c7;
            font-size: 1.2rem;
            margin-right: 1rem;
            transition: color 0.3s ease;
        }

        .livelife-footer .social-icons a:hover {
            color: #3498db;
        }

        @media (max-width: 767px) {
            .livelife-footer .footer-bottom-links,
            .livelife-footer .copyright {
                text-align: center;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>

<footer class="livelife-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <h5>LiveLife Automobiles</h5>
                <p>Your trusted partner for premium car rentals. Experience luxury and comfort on every journey.</p>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h5>Quick Links</h5>
                <ul class="footer-nav">
                    <li><a class="footer-link" href="index.php">Home</a></li>
                    <li><a class="footer-link" href="customerlogin.php">Rent a Car</a></li>
                    <li><a class="footer-link" href="faq.php">FAQ</a></li>
                    <li><a class="footer-link" href="about.php">About Us</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Contact Us</h5>
                <address>
                    LiveLife Automobiles<br>
                    Koforidua, Ghana<br>
                    <abbr title="Phone">P:</abbr> <?php echo('+'. CONTACT_NUM);?><br>
                    <a href="mailto:info@livelifeauto.com"><?php echo CONTACT_EMAIL; ?></a>
                </address>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p class="copyright">&copy; <?php echo date("Y"); ?> LiveLife Automobiles. All rights reserved.</p>
            </div>
            <div class="col-md-6 footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
