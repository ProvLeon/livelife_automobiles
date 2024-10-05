<?php
session_start();
require_once 'config.php';
require_once 'connection.php';

if (!isset($_SESSION['login_customer'])) {
    header("Location: index.php");
    exit;
}

$car_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$car_id) {
    header("Location: index.php");
    exit;
}

$conn = Connect();

$sql = "SELECT * FROM cars WHERE car_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();

$drivers = [];
if ($car) {
    $sql_driver = "SELECT * FROM driver WHERE driver_availability = 'yes'";
    $stmt_driver = $conn->prepare($sql_driver);
    $stmt_driver->execute();
    $drivers = $stmt_driver->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    header("Location: index.php");
    exit;
}

$stmt->close();
$stmt_driver->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo htmlspecialchars($car['car_name']); ?> | LiveLife Automobiles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 70px;
        }
        .booking-container { max-width: 900px; margin: 0 auto; }
        .car-image { max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .booking-card { background-color: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .booking-card .card-header { background-color: #007bff; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .booking-card .form-control { border-radius: 5px; }
        .booking-card .btn-primary { border-radius: 5px; }
        .price-info { background-color: #e9ecef; border-radius: 5px; padding: 10px; margin-bottom: 20px; }
        #total-cost { font-size: 1.2em; font-weight: bold; color: #28a745; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container booking-container mt-5">
        <h2 class="text-center mb-4">Book Your Car</h2>
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($car['car_img']); ?>" alt="<?php echo htmlspecialchars($car['car_name']); ?>" class="car-image mb-4">
                <div class="price-info">
                    <h5>Pricing Information</h5>
                    <p><strong>AC Fare per Day:</strong> <?php echo(CURRENCY. htmlspecialchars($car['ac_price_per_day'])); ?></p>
                    <p><strong>Non-AC Fare per Day:</strong> <?php echo(CURRENCY. htmlspecialchars($car['non_ac_price_per_day'])); ?></p>
                    <p><strong>AC Price per KM:</strong> <?php echo(CURRENCY.htmlspecialchars($car['ac_price'])); ?></p>
                    <p><strong>Non-AC Price per KM:</strong> <?php echo(CURRENCY.htmlspecialchars($car['non_ac_price'])); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card booking-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><?php echo htmlspecialchars($car['car_name']); ?> - <?php echo htmlspecialchars($car['car_nameplate']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="payment.php" method="POST" id="booking-form">
                            <div class="form-group">
                                <label for="start-date">Start Date</label>
                                <input type="date" class="form-control" id="start-date" name="start_date" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="end-date">End Date</label>
                                <input type="date" class="form-control" id="end-date" name="end_date" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="driver">Driver</label>
                                <select class="form-control" id="driver" name="driver_id" required>
                                    <option value="">Select a driver</option>
                                    <?php foreach ($drivers as $driver): ?>
                                        <option value="<?php echo intval($driver['driver_id']); ?>">
                                            <?php echo htmlspecialchars($driver['driver_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="charge-type">Charge Type</label>
                                <select class="form-control" id="charge-type" name="charge_type" required>
                                    <option value="day">Per Day</option>
                                    <option value="km">Per KM</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ac-type">AC Type</label>
                                <select class="form-control" id="ac-type" name="ac_type" required>
                                    <option value="ac">AC</option>
                                    <option value="non_ac">Non-AC</option>
                                </select>
                            </div>
                            <div id="km-input" class="form-group" style="display: none;">
                                <label for="km">Estimated KM</label>
                                <input type="number" class="form-control" id="km" name="km" min="1">
                            </div>
                            <div class="form-group">
                                <p id="total-cost">Estimated Total: <?php echo CURRENCY?>0.00</p>
                            </div>
                            <input type="hidden" name="car_id" value="<?php echo intval($car['car_id']); ?>">
                            <input type="hidden" name="car_type" value="<?php echo htmlspecialchars($car['car_name']); ?>">
                            <input type="hidden" name="total_cost" id="hidden-total-cost" value="0">
                            <button type="submit" class="btn btn-primary btn-block mt-4">Proceed to Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateTotalCost() {
                var startDate = new Date($('#start-date').val());
                var endDate = new Date($('#end-date').val());
                var chargeType = $('#charge-type').val();
                var acType = $('#ac-type').val();
                var km = $('#km').val();

                if (startDate && endDate && chargeType && acType) {
                    var days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                    var rate = acType === 'ac' ?
                        (chargeType === 'day' ? <?php echo $car['ac_price_per_day']; ?> : <?php echo $car['ac_price']; ?>) :
                        (chargeType === 'day' ? <?php echo $car['non_ac_price_per_day']; ?> : <?php echo $car['non_ac_price']; ?>);

                    var totalCost = chargeType === 'day' ? days * rate : (km ? km * rate : 0);
                    $('#total-cost').text('Estimated Total: $' + totalCost.toFixed(2));
                    $('#hidden-total-cost').val(totalCost.toFixed(2));
                }
            }

            $('#booking-form').submit(function(e) {
                var startDate = new Date($('#start-date').val());
                var endDate = new Date($('#end-date').val());

                if (endDate <= startDate) {
                    alert('End date must be after the start date.');
                    e.preventDefault();
                }

                // Ensure total cost is calculated before submission
                updateTotalCost();
            });

            $('#charge-type').change(function() {
                if ($(this).val() === 'km') {
                    $('#km-input').show();
                } else {
                    $('#km-input').hide();
                }
                updateTotalCost();
            });

            $('#start-date, #end-date, #charge-type, #ac-type, #km').change(updateTotalCost);
        });
    </script>
</body>
</html>
