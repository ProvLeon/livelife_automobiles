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
    <!-- <!-- <link rel="shortcut icon" type="image/png" href="assets/img/P.png"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css"> -->


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
            color: white;
        }

        /* #googleId {
            width: 80%;
            display
        } */
    </style>

</head>

<body>

    <!-- Navigation -->
    <?php include 'navbar.php'; ?>

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
            <div id="googleId" class="w3-col m4 w3-container ">
                <!-- Add Google Maps -->
                <div id="googleMap" class="w3-round-large w3-greyscale" style="width:100%;height:400px;"></div>
            </div>
            <div class="w3-col m8 w3-panel">
                <div class="w3-large w3-margin-bottom">
                    <i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> LiveLife Automobiles, Ghana<br>
                    <i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Phone: <?php echo('+'.CONTACT_NUM); ?><br>
                    <i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Email: <?php echo CONTACT_EMAIL; ?><br>
                </div>
                <p>New to LiveLife? Drop Your Details and Leave it on us We'll Revert</p>
                <!-- Replace the existing form in the contact section with this -->
                <form id="contactForm">
                    <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
                        <div class="w3-half">
                            <input class="w3-input w3-border" type="text" placeholder="Name" required name="name">
                        </div>
                        <div class="w3-half">
                            <input class="w3-input w3-border" type="email" placeholder="Email" required name="email">
                        </div>
                    </div>
                    <textarea class="w3-input w3-border" rows="4" placeholder="Message" required name="message"></textarea>
                    <div id="messageResponse" style="display:none;"></div>
                    <button class="w3-button w3-black w3-right w3-section" type="submit">
                        <i class="fa fa-paper-plane"></i> SEND MESSAGE
                    </button>
                </form>

                <script>
                $(document).ready(function() {
                    $('#contactForm').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            type: 'POST',
                            url: 'send_message.php',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 'success') {
                                    $('#messageResponse').html('<div class="alert alert-success">' + response.message + '</div>').show();
                                    $('#contactForm')[0].reset();
                                } else {
                                    $('#messageResponse').html('<div class="alert alert-danger">' + response.message + '</div>').show();
                                }
                            },
                            error: function() {
                                $('#messageResponse').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>').show();
                            }
                        });
                    });
                });
                </script>

            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

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
