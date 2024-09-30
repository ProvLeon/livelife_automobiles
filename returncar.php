<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['login_customer'])) {
    header("Location: customerlogin.php");
    exit;
}

$conn = Connect();

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if (!$id) {
    header("Location: mybookings.php");
    exit;
}

$sql = "SELECT c.car_name, c.car_nameplate, rc.rent_start_date, rc.rent_end_date, rc.fare, rc.charge_type, d.driver_name, d.driver_phone
        FROM rentedcars rc
        JOIN cars c ON c.car_id = rc.car_id
        JOIN driver d ON d.driver_id = rc.driver_id
        WHERE rc.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: mybookings.php");
    exit;
}

$row = $result->fetch_assoc();
$car_name = $row["car_name"];
$car_nameplate = $row["car_nameplate"];
$driver_name = $row["driver_name"];
$driver_phone = $row["driver_phone"];
$rent_start_date = $row["rent_start_date"];
$rent_end_date = $row["rent_end_date"];
$fare = $row["fare"];
$charge_type = $row["charge_type"];
$no_of_days = dateDiff($rent_start_date, $rent_end_date);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Car | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { padding-top: 56px; background-color: #f8f9fa; }
        .return-form { max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .form-group label { font-weight: bold; }
        .journey-details { background-color: #e9ecef; border-radius: 5px; padding: 15px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Return Car</h2>
        <div class="return-form">
            <div class="journey-details">
                <h4 class="mb-3">Journey Details</h4>
                <p><strong>Car:</strong> <?php echo htmlspecialchars($car_name); ?></p>
                <p><strong>Vehicle Number:</strong> <?php echo htmlspecialchars($car_nameplate); ?></p>
                <p><strong>Rent Date:</strong> <?php echo htmlspecialchars($rent_start_date); ?></p>
                <p><strong>End Date:</strong> <?php echo htmlspecialchars($rent_end_date); ?></p>
                <p><strong>Fare:</strong> <?php echo CURRENCY . htmlspecialchars($fare) . ($charge_type == "days" ? "/day" : "/km"); ?></p>
                <p><strong>Driver Name:</strong> <?php echo htmlspecialchars($driver_name); ?></p>
                <p><strong>Driver Contact:</strong> <?php echo htmlspecialchars($driver_phone); ?></p>
            </div>

            <form action="printbill.php?id=<?php echo $id; ?>" method="POST">
                <?php if($charge_type == "km") { ?>
                <div class="form-group">
                    <label for="distance_or_days">Distance Travelled (km)</label>
                    <input type="number" class="form-control" id="distance_or_days" name="distance_or_days" placeholder="Enter the distance travelled" required min="1">
                </div>
                <?php } else { ?>
                <div class="form-group">
                    <label for="distance_or_days">Number of Days</label>
                    <input type="number" class="form-control" id="distance_or_days" name="distance_or_days" value="<?php echo $no_of_days; ?>" readonly>
                </div>
                <?php } ?>
                <input type="hidden" name="hid_fare" value="<?php echo $fare; ?>">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Generate Bill</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
