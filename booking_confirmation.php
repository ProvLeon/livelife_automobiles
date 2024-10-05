<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['login_customer']) || !isset($_SESSION['booking_success'])) {
    header("Location: index.php");
    exit;
}

$booking_id = $_SESSION['booking_id'];
$car_id = $_SESSION['car_id'];
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$car_type = $_SESSION['car_type'];
$charge_type = $_SESSION['charge_type'];
$driver_id = $_SESSION['driver_id'];
$total_cost = $_SESSION['total_cost'];

$conn = Connect();

$car_sql = "SELECT car_name, car_nameplate, car_img FROM cars WHERE car_id = ?";
$car_stmt = $conn->prepare($car_sql);
$car_stmt->bind_param("i", $car_id);
$car_stmt->execute();
$car_result = $car_stmt->get_result();
$car_details = $car_result->fetch_assoc();

$driver_sql = "SELECT driver_name, driver_phone FROM driver WHERE driver_id = ?";
$driver_stmt = $conn->prepare($driver_sql);
$driver_stmt->bind_param("i", $driver_id);
$driver_stmt->execute();
$driver_result = $driver_stmt->get_result();
$driver_details = $driver_result->fetch_assoc();

$conn->close();

// Clear the session variables
unset($_SESSION['booking_success'], $_SESSION['car_id'], $_SESSION['start_date'], $_SESSION['end_date'],
      $_SESSION['car_type'], $_SESSION['charge_type'], $_SESSION['driver_id'], $_SESSION['total_cost'], $_SESSION['booking_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { padding-top: 56px; background-color: #f8f9fa; }
        .content { margin-top: 2rem; padding-bottom: 70px; }
        .car-image { max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 1rem; }
        .confirmation-card { background-color: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .confirmation-header { background-color: #28a745; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .list-group-item { border: none; padding: 0.75rem 1.25rem; }
        .list-group-item:nth-of-type(odd) { background-color: rgba(0,0,0,.05); }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card confirmation-card">
                        <div class="card-header confirmation-header">
                            <h4 class="mb-0">Booking Confirmation</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Thank you for your booking!</h5>
                            <p class="card-text">Your booking has been confirmed. Here are the details:</p>

                            <img src="<?php echo $car_details['car_img']; ?>" alt="<?php echo $car_details['car_name']; ?>" class="car-image">

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Booking ID:</strong> <?php echo $booking_id; ?></li>
                                <li class="list-group-item"><strong>Car:</strong> <?php echo $car_details['car_name']; ?> (<?php echo $car_details['car_nameplate']; ?>)</li>
                                <li class="list-group-item"><strong>Start Date:</strong> <?php echo $start_date; ?></li>
                                <li class="list-group-item"><strong>End Date:</strong> <?php echo $end_date; ?></li>
                                <li class="list-group-item"><strong>Car Type:</strong> <?php echo ucfirst($car_type); ?></li>
                                <li class="list-group-item"><strong>Charge Type:</strong> <?php echo ucfirst($charge_type); ?></li>
                                <li class="list-group-item"><strong>Total Cost:</strong> <?php echo(CURRENCY.number_format($total_cost, 2)); ?></li>
                                <li class="list-group-item"><strong>Driver:</strong> <?php echo $driver_details['driver_name']; ?> (Phone: <?php echo $driver_details['driver_phone']; ?>)</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <p class="mb-0">If you have any questions, please contact our customer support.</p>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-primary">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
