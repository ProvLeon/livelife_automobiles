<!DOCTYPE html>
<html>
<?php
session_start();

require_once 'connection.php';
$conn = Connect();

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <style>
        .menu-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .car-card {
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .car-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .car-info {
            padding: 15px;
        }
        .car-name {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .car-price {
            font-size: 0.9em;
            color: #666;
        }
        .book-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .book-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   LiveLife Automobiles </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
                if(isset($_SESSION['login_admin'])){
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_admin']; ?></a>
                    </li>
                    <li>
                    <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="entercar.php">Add Car</a></li>
              <li> <a href="enterdriver.php"> Add Driver</a></li>
              <li> <a href="adminview.php">View</a></li>

            </ul>
            </li>
          </ul>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
                }
                else if (isset($_SESSION['login_customer'])){
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                    </li>
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> garage <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="prereturncar.php">Return Now</a></li>
              <li> <a href="mybookings.php"> My Bookings</a></li>
            </ul>
            </li>
          </ul>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
            }
                else {
            ?>

            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="adminlogin.php">Admin</a>
                    </li>
                    <li>
                        <a href="customerlogin.php">Customer</a>
                    </li>
                    <li>
                        <a href="faq/index.php"> FAQ </a>
                    </li>
                </ul>
            </div>
                <?php   }
                ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="bgimg-1">
        <header class="intro">
            <div class="intro-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h1 class="brand-heading" style="color: white">LiveLife Automobiles</h1>
                            <p class="intro-text">
                                Online car rental service
                            </p>
                            <a href="#sec2" class="btn btn-circle page-scroll blink">
                                <i class="fa fa-angle-double-down animated"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <!-- Replace the existing car listing section with this -->
    <div id="sec2" style="color: #777;background-color:white;text-align:center;padding:50px 80px;">
        <h3 style="text-align:center;">Currently Available Cars</h3>
        <br>
        <section class="menu-content">
            <?php
            $sql1 = "SELECT * FROM cars WHERE car_availability='yes'";
            $result1 = mysqli_query($conn,$sql1);

            if(mysqli_num_rows($result1) > 0) {
                while($row1 = mysqli_fetch_assoc($result1)){
                    $car_id = $row1["car_id"];
                    $car_name = $row1["car_name"];
                    $ac_price = $row1["ac_price"];
                    $ac_price_per_day = $row1["ac_price_per_day"];
                    $non_ac_price = $row1["non_ac_price"];
                    $non_ac_price_per_day = $row1["non_ac_price_per_day"];
                    $car_img = $row1["car_img"];
            ?>
            <div class="car-card">
                <img class="car-img" src="<?php echo $car_img; ?>" alt="<?php echo $car_name; ?>" loading="lazy">
                <div class="car-info">
                    <div class="car-name"><?php echo $car_name; ?></div>
                    <div class="car-price">
                        <p>AC: <?php echo CURRENCY . $ac_price . "/km & " . CURRENCY . $ac_price_per_day . "/day"; ?></p>
                        <p>Non-AC: <?php echo CURRENCY . $non_ac_price . "/km & ". CURRENCY . $non_ac_price_per_day . "/day"; ?></p>
                    </div>
                    <a href="booking.php?id=<?php echo $car_id; ?>" class="book-btn">Book Now</a>
                </div>
            </div>
            <?php
                }
            } else {
            ?>
            <h1>No cars available at the moment</h1>
            <?php
            }
            ?>
        </section>
    </div>

    <div class="bgimg-2">
        <div class="caption">
            <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;"></span>
        </div>
    </div>

    <div style="position:relative;">
        <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
            <p>Click here for the latest deals on your bookings</p>
        </div>
    </div>
    <!-- Container (Contact Section) -->
    <div class="w3-content w3-container w3-padding-64" id="contact">
        <h3 class="w3-center">WHERE WE WORK</h3>
        <p class="w3-center"><em>We love your feedback!</em></p>

        <div class="w3-row w3-padding-32 w3-section">
            <div class="w3-col m4 w3-container">
                <!-- Add Google Maps -->
                <div id="googleMap" class="w3-round-large w3-greyscale" style="width:100%;height:400px;"></div>
            </div>
            <div class="w3-col m8 w3-panel">
                <div class="w3-large w3-margin-bottom">
                    <i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> LiveLife Automobiles, Ghana<br>
                    <i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Phone: +233 550 144 927<br>
                    <i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Email: delatay101@gmail.com<br>
                </div>
                <p>New to LiveLife? Drop Your Details and Leave it on us We'll Revert</p>
                <form action="action_page.php" method="POST">
                    <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
                        <div class="w3-half">
                            <input class="w3-input w3-border" type="text" placeholder="Name" required name="name">
                        </div>
                        <div class="w3-half">
                            <input class="w3-input w3-border" type="text" placeholder="Email" required name="e_mail">
                        </div>
                    </div>
                    <input class="w3-input w3-border" type="text" placeholder="Message" required name="message">
                    <button class="w3-button w3-black w3-right w3-section" type="submit">
                <i class="fa fa-paper-plane"></i> SEND MESSAGE
              </button>
                </form>
            </div>
        </div>
    </div>
    <footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© <?php echo date("Y") ?> LiveLife Automobiles</h5>
                </div>
                <div class="col-sm-6 social-icons">
                    <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fa fa-google-plus"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <script>
    function myMap() {
        try {
            myCenter = new google.maps.LatLng(5.6037, -0.1870);
            var mapOptions = {
                center: myCenter,
                zoom: 12,
                scrollwheel: true,
                draggable: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);

            var marker = new google.maps.Marker({
                position: myCenter,
            });
            marker.setMap(map);
        } catch (error) {
            console.error("Error initializing Google Map:", error);
            document.getElementById("googleMap").innerHTML = "Failed to load Google Maps. Please try again later.";
        }
    }
    </script>
    <script>
        function sendGaEvent(category, action, label) {
            ga('send', {
                hitType: 'event',
                eventCategory: category,
                eventAction: action,
                eventLabel: label
            });
        };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?callback=myMap" async defer></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="assets/js/jquery.easing.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="assets/js/theme.js"></script>
</body>

</html>
