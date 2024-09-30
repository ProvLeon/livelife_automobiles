<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['login_customer'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['total_cost']) || !is_numeric($_POST['total_cost'])) {
    // Redirect back to booking page if total_cost is not set or not numeric
    header("Location: booking.php?id=" . $_POST['car_id']);
    exit;
}

$total_cost = floatval($_POST['total_cost']);

// Store session data to be consistent
$_SESSION['car_id'] = $_POST['car_id'];
$_SESSION['start_date'] = $_POST['start_date'];
$_SESSION['end_date'] = $_POST['end_date'];
$_SESSION['car_type'] = $_POST['car_type'];
$_SESSION['charge_type'] = $_POST['charge_type'];
$_SESSION['driver_id'] = $_POST['driver_id'];
$_SESSION['total_cost'] = $total_cost;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { padding-top: 56px; background-color: #f8f9fa; }
        .payment-form { max-width: 500px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .form-group label { font-weight: bold; }
        #total-amount { font-size: 1.5em; font-weight: bold; color: #28a745; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Payment Details</h2>
        <div class="payment-form">
            <form id="payment-form" action="process_payment.php" method="POST">
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" class="form-control" id="card-number" name="card_number" required pattern="\d{16}" placeholder="1234 5678 9012 3456">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="expiry-date">Expiry Date</label>
                        <input type="text" class="form-control" id="expiry-date" name="expiry_date" required pattern="(0[1-9]|1[0-2])\/\d{2}" placeholder="MM/YY">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required pattern="\d{3}" placeholder="123">
                    </div>
                </div>
                <div class="form-group">
                    <label for="card-holder">Card Holder Name</label>
                    <input type="text" class="form-control" id="card-holder" name="card_holder" required>
                </div>
                <div class="form-group">
                    <label for="total-amount">Total Amount</label>
                    <input type="text" class="form-control" id="total-amount" value="$<?php echo $total_cost; ?>" readonly>
                </div>

                <!-- Hidden fields for booking data -->
                <input type="hidden" name="total_cost" value="<?php echo $total_cost; ?>">
                <input type="hidden" name="car_id" value="<?php echo $_POST['car_id']; ?>">
                <input type="hidden" name="start_date" value="<?php echo $_POST['start_date']; ?>">
                <input type="hidden" name="end_date" value="<?php echo $_POST['end_date']; ?>">
                <input type="hidden" name="car_type" value="<?php echo $_POST['car_type']; ?>">
                <input type="hidden" name="charge_type" value="<?php echo $_POST['charge_type']; ?>">
                <input type="hidden" name="driver_id" value="<?php echo $_POST['driver_id']; ?>">

                <button type="submit" class="btn btn-primary btn-block mt-4">Pay Now</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#payment-form').submit(function(e) {
                var cardNumber = $('#card-number').val().replace(/\s/g, '');
                var expiryDate = $('#expiry-date').val();
                var cvv = $('#cvv').val();

                if (!/^\d{16}$/.test(cardNumber)) {
                    alert('Please enter a valid 16-digit card number.');
                    e.preventDefault();
                } else if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
                    alert('Please enter a valid expiry date in MM/YY format.');
                    e.preventDefault();
                } else if (!/^\d{3}$/.test(cvv)) {
                    alert('Please enter a valid 3-digit CVV.');
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
