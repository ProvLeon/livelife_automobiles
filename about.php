<?php
require_once('config.php'); // Include config for constants if needed (like CONTACT_NUM)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | LiveLife Automobiles</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom User CSS (if applicable) -->
    <link rel="stylesheet" href="assets/css/user.css">
     <!-- Google Fonts (from index.php) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <style>
        body {
            /* Ensure footer stays at bottom */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-wrapper {
            flex: 1 0 auto;
             /* Adjust padding to prevent content from being hidden behind the fixed navbar */
             padding-top: 70px; /* Match navbar height */
        }
        .about-header {
            background: url('assets/img/lets.jpg') no-repeat center center; /* Replace with a relevant image */
            background-size: cover;
            color: white;
            padding: 5rem 0;
            text-align: center;
            margin-bottom: 3rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
        }
        .about-header h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .about-header p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }
        .section-padding {
            padding: 3rem 0;
        }
        .section-title {
            text-align: center;
            margin-bottom: 2.5rem;
            font-weight: bold;
            color: #333;
        }
        .value-icon {
            font-size: 2.5rem;
            color: #158cba; /* Primary color from nav */
            margin-bottom: 1rem;
        }
        .team-member img {
            max-width: 150px;
            border-radius: 50%;
            margin-bottom: 1rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
         /* Adjustments for compatibility with user.css */
        body {
            padding-top: 0; /* Override padding-top from clientlogin.css */
            background: #f8f9fa; /* Set a default background */
        }
        /* Ensure footer stays at the bottom */
        footer {
             margin-top: auto; /* Push footer to the bottom */
             flex-shrink: 0;
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; // Include the standard navigation bar ?>

    <div class="content-wrapper">
        <div class="about-header">
            <div class="container">
                <h1>About LiveLife Automobiles</h1>
                <p>Discover the story behind your premium car rental experience in Ghana.</p>
            </div>
        </div>

        <div class="container section-padding">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h2 class="section-title">Our Story</h2>
                    <p class="lead">LiveLife Automobiles started with a simple mission: to provide exceptional car rental services with unparalleled customer care. Founded in [Year, e.g., 2023], we saw a need for reliable, high-quality vehicle rentals paired with professional chauffeur services in Ghana.</p>
                    <p>From our humble beginnings, we have grown by focusing on our core values and consistently exceeding client expectations. We believe that renting a car should be a seamless and enjoyable experience, whether for business, leisure, or special occasions.</p>
                </div>
            </div>
        </div>

        <div class="container section-padding bg-light">
            <h2 class="section-title">Our Mission & Values</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <i class="fas fa-check-circle value-icon"></i>
                    <h5>Quality & Reliability</h5>
                    <p>We maintain a fleet of modern, well-maintained vehicles to ensure your safety and comfort on every journey.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-users value-icon"></i>
                    <h5>Customer Focus</h5>
                    <p>Your satisfaction is our top priority. We strive to provide personalized service tailored to your specific needs.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-shield-alt value-icon"></i>
                    <h5>Professionalism & Integrity</h5>
                    <p>We operate with the highest standards of professionalism, ensuring transparency and trustworthiness in all our dealings.</p>
                </div>
            </div>
        </div>

        <div class="container section-padding">
            <h2 class="section-title">Why Choose Us?</h2>
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <ul>
                        <li><strong>Premium Fleet:</strong> A wide selection of top-quality vehicles for every occasion.</li>
                        <li><strong>Professional Chauffeurs:</strong> Experienced, courteous, and knowledgeable drivers ensure a smooth ride.</li>
                        <li><strong>Transparent Pricing:</strong> Clear and competitive rates with no hidden fees (<?php echo CURRENCY; ?>).</li>
                        <li><strong>Easy Booking:</strong> Simple and convenient online booking process.</li>
                        <li><strong>Customer Support:</strong> Dedicated support team ready to assist you. Contact us at <?php echo('+'. CONTACT_NUM);?>.</li>
                        <li><strong>Local Expertise:</strong> Deep understanding of routes and locations across Ghana.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Optional Team Section -->
        <!--
        <div class="container section-padding bg-light">
            <h2 class="section-title">Meet Our Team</h2>
            <div class="row text-center">
                <div class="col-md-4 team-member mb-4">
                    <img src="assets/img/team-member-1.jpg" alt="Team Member 1">
                    <h5>[Member Name]</h5>
                    <p>[Position]</p>
                </div>
                <div class="col-md-4 team-member mb-4">
                    <img src="assets/img/team-member-2.jpg" alt="Team Member 2">
                    <h5>[Member Name]</h5>
                    <p>[Position]</p>
                </div>
                <div class="col-md-4 team-member mb-4">
                    <img src="assets/img/team-member-3.jpg" alt="Team Member 3">
                    <h5>[Member Name]</h5>
                    <p>[Position]</p>
                </div>
            </div>
        </div>
        -->

    </div> <!-- /content-wrapper -->

    <?php include 'footer.php'; // Include the standard footer ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
