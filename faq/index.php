<?php
require_once('../config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQ | LiveLife Automobiles</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <link rel="stylesheet" href="../assets/w3css/w3.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-wrapper {
            flex: 1 0 auto;
            padding-top: 70px;
        }
        .cd-faq {
            max-width: 1024px;
            margin: 2em auto;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php include 'faq_navbar.php'; ?>

    <div class="content-wrapper">
        <section class="cd-faq">
            <ul class="cd-faq-categories">
                <li><a class="selected" href="#basics">Basics</a></li>
                <li><a href="#membership">Membership</a></li>
                <li><a href="#chauffeur">Chauffeur Services</a></li>
            </ul>

            <div class="cd-faq-items">
                <ul id="basics" class="cd-faq-group">
                    <li class="cd-faq-title">
                        <h2>Basics</h2>
                    </li>
                <li>
                    <a class="cd-faq-trigger" href="#0">How do I pay for my Rental?</a>
                    <div class="cd-faq-content">
                        <p>LiveLife Automobiles gladly accepts Mastercard and Visa. Personal Checks are also accepted providing you purchase CDW and Theft Protection on your rental.
                         At this time we would like to advise that personal checks are not accepted locally.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">What if i find a better rate for a rental car?</a>
                    <div class="cd-faq-content">
                        <p>One of the many great things about LiveLife Automobiles is our rental rates and services are guaranteed to be the very best in the industry. If you come across a lower price from a competitor and the rate is on a comparable vehicle including the same terms, locations, and rental car fees we will be glad to beat the price for you. Please complete our Guaranteed Best Rate form if you have found a better rate with one of our competitors.</div>
                    <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Will i need a driving license to rent a car?</a>
                    <div class="cd-faq-content">
                        <p>A driving license is not needed as a driver is already provided by the client.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Is there a fee if i return the car after the due date?</a>
                    <div class="cd-faq-content">
                        <p>Yes, we charge <?php echo CURRENCY; ?> 200/- day after the due date.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>
            </ul>
            <!-- cd-faq-group -->

            <ul id="membership" class="cd-faq-group">
                <li class="cd-faq-title">
                    <h2>Membership</h2>
                </li>
                <li>
                    <a class="cd-faq-trigger" href="#0">Why should i sign up?</a>
                    <div class="cd-faq-content">
                        <p>When you sign-up to be a member on our site, you will be able to save time filling out requests. Once you have joined and logged-in, each time you send us a request, we will pre-fill the submission form with your personal information so that you do not have type the same things again and again. We also give you the opportunity to sign-up for our email newsletter which will keep you up-to-date on the latest specials and incentives we're offering.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">How do I become a member?</a>
                    <div class="cd-faq-content">
                        <p>There are two ways to sign-up. You can either go directly to our sign-up form or you can simply complete a request as you normally would. After you send in that request, you will have an opportunity to sign-up. If you choose to do so, when you go to the sign-up form, the information you provided for your request will be pre-filled in the sign-up form.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>
                <li>
                    <a class="cd-faq-trigger" href="#0">How do I login?</a>
                    <div class="cd-faq-content">
                        <p>Once you sign-up, we will redirect you to the log in screen. When you are logged in, you will see a small bar in the upper right corner of the screen welcoming to you our site. If you already have set up an account but have logged out, you can either click on the 'Log-In' button on our menu bar which takes you to our log-in page or, if you are on our home page, you can use the log-in area on it.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>
                <li>
                    <a class="cd-faq-trigger" href="#0">What about my privacy?</a>
                    <div class="cd-faq-content">
                        <p>Your privacy is very important to us. As long as you do not share your member name and password with others, no one will be able to see or edit your personal information. For more information, please read our privacy policy.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>
                <li>
                    <a class="cd-faq-trigger" href="#0">What if i share my computer?</a>
                    <div class="cd-faq-content">
                        <p>If you share your computer with others, you should log-out when you are done with your session on our web site. And, when you log-in, make sure that the check-box next to 'Save my password on this computer' is unchecked. Taking these steps will ensure that the next person using the computer will not have access to your account.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>
                <li>
                    <a class="cd-faq-trigger" href="#0">Is my credit card information stored in my account?</a>
                    <div class="cd-faq-content">
                        <p>No, We do not store any credit card information in your account.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>
            </ul>
            <!-- cd-faq-group -->

            <ul id="chauffeur" class="cd-faq-group">
                <li class="cd-faq-title">
                    <h2>Chauffeur service</h2>
                </li>
                <li>
                    <a class="cd-faq-trigger" href="#0">Do you have meet and greet services?</a>
                    <div class="cd-faq-content">
                        <p>You will be greeted in airports and other public places with a hand-held sign. We can also meet you at your hotel and in other locations.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">How can i pay for my chauffeur services?</a>
                    <div class="cd-faq-content">
                        <p>LiveLive Automobiles gladly accepts MasterCard, Visa, and checks. We also PayTm.</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Is there a fee if i change my Chauffeur services?</a>
                    <div class="cd-faq-content">
                        <p>There is no fee to change reservations for chauffeur services.

</p>
                    </div>
                    <!-- cd-faq-content -->
                </li>
            </ul>
            <!-- cd-faq-group -->
        </div>
        <!-- cd-faq-items -->
        <a href="#0" class="cd-close-panel">Close</a>
    </section>
    </div>

    <?php include 'faq_footer.php'; ?>

    <!-- cd-faq -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/jquery.mobile.custom.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Resource jQuery -->
</body>

</html>
