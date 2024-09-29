<?php
require_once 'connection.php';
include('session_customer.php');

$conn = Connect();

if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
}

$car_id = $_GET["id"];
$sql1 = "SELECT * FROM cars WHERE car_id = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result1 = $stmt->get_result();
$row1 = $result1->fetch_assoc();

$car_name = $row1["car_name"];
$car_nameplate = $row1["car_nameplate"];
$ac_price = $row1["ac_price"];
$non_ac_price = $row1["non_ac_price"];
$ac_price_per_day = $row1["ac_price_per_day"];
$non_ac_price_per_day = $row1["non_ac_price_per_day"];
$car_img = $row1["car_img"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body { padding-top: 56px; }
        .booking-form { max-width: 800px; margin: 0 auto; }
        .car-image { max-width: 100%; height: auto; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Book Your Car</h1>
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $car_img; ?>" alt="<?php echo $car_name; ?>" class="car-image mb-3">
                <h3><?php echo $car_name; ?></h3>
                <p><strong>Vehicle Number:</strong> <?php echo $car_nameplate; ?></p>
                <p><strong>AC Price:</strong> <?php echo CURRENCY . $ac_price; ?>/km and <?php echo CURRENCY . $ac_price_per_day; ?>/day</p>
                <p><strong>Non-AC Price:</strong> <?php echo CURRENCY . $non_ac_price; ?>/km and <?php echo CURRENCY . $non_ac_price_per_day; ?>/day</p>
            </div>
            <div class="col-md-6">
                <form id="booking-form" class="booking-form">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Car Type</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="ac" name="car_type" class="custom-control-input" value="ac" required>
                            <label class="custom-control-label" for="ac">AC</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="non_ac" name="car_type" class="custom-control-input" value="non_ac" required>
                            <label class="custom-control-label" for="non_ac">Non-AC</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Charge Type</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="per_km" name="charge_type" class="custom-control-input" value="km" required>
                            <label class="custom-control-label" for="per_km">Per KM</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="per_day" name="charge_type" class="custom-control-input" value="day" required>
                            <label class="custom-control-label" for="per_day">Per Day</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="driver">Choose a Driver</label>
                        <select class="form-control" id="driver" name="driver_id" required>
                            <option value="">Select a driver</option>
                            <?php
                            $sql2 = "SELECT * FROM driver d WHERE d.driver_availability = 'yes' AND d.client_username IN (SELECT cc.client_username FROM clientcars cc WHERE cc.car_id = ?)";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->bind_param("i", $car_id);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            while($row2 = $result2->fetch_assoc()) {
                                echo "<option value='".$row2['driver_id']."'>".$row2['driver_name']." (".$row2['driver_gender'].")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="driver-details" class="mt-3" style="display: none;">
                        <h5>Driver Details</h5>
                        <p id="driver-name"></p>
                        <p id="driver-gender"></p>
                        <p id="driver-phone"></p>
                    </div>
                    <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                    <button type="submit" class="btn btn-primary btn-block mt-4">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="payment-form">
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                        <button id="submit-payment" class="btn btn-primary btn-block mt-4">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        $(document).ready(function() {
            $('#driver').change(function() {
                var driverId = $(this).val();
                if (driverId) {
                    $.ajax({
                        url: 'get_driver_details.php',
                        type: 'POST',
                        data: { driver_id: driverId },
                        dataType: 'json',
                        success: function(data) {
                            $('#driver-name').text('Name: ' + data.driver_name);
                            $('#driver-gender').text('Gender: ' + data.driver_gender);
                            $('#driver-phone').text('Phone: ' + data.driver_phone);
                            $('#driver-details').show();
                        }
                    });
                } else {
                    $('#driver-details').hide();
                }
            });

            $('#booking-form').submit(function(e) {
                e.preventDefault();
                $('#paymentModal').modal('show');
            });

            // Create a Stripe client.
            var stripe = Stripe('your_stripe_publishable_key');
            var elements = stripe.elements();

            // Create an instance of the card Element.
            var card = elements.create('card');

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    </script>
</body>
</html>
