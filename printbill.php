<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['login_customer'])) {
    header("Location: customerlogin.php");
    exit;
}

$conn = Connect();

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if (!$id || !isset($_POST['distance_or_days']) || !isset($_POST['hid_fare'])) {
    header("Location: mybookings.php");
    exit;
}

$distance_or_days = $conn->real_escape_string($_POST['distance_or_days']);
$fare = $conn->real_escape_string($_POST['hid_fare']);
$total_amount = $distance_or_days * $fare;
$car_return_date = date('Y-m-d');
$return_status = "R";
$login_customer = $_SESSION['login_customer'];

$sql0 = "SELECT rc.id, rc.rent_end_date, rc.charge_type, rc.rent_start_date, c.car_name, c.car_nameplate
         FROM rentedcars rc
         JOIN cars c ON c.car_id = rc.car_id
         WHERE rc.id = ?";

$stmt = $conn->prepare($sql0);
$stmt->bind_param("i", $id);
$stmt->execute();
$result0 = $stmt->get_result();

if($result0->num_rows == 0) {
    header("Location: mybookings.php");
    exit;
}

$row0 = $result0->fetch_assoc();
$rent_end_date = $row0["rent_end_date"];
$rent_start_date = $row0["rent_start_date"];
$car_name = $row0["car_name"];
$car_nameplate = $row0["car_nameplate"];
$charge_type = $row0["charge_type"];

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$extra_days = dateDiff($rent_end_date, $car_return_date);
$total_fine = $extra_days * 200;
$duration = dateDiff($rent_start_date, $rent_end_date);

if ($extra_days > 0) {
    $total_amount += $total_fine;
}

if ($charge_type == "days") {
    $no_of_days = $distance_or_days;
    $sql1 = "UPDATE rentedcars SET car_return_date=?, no_of_days=?, total_amount=?, return_status=? WHERE id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("sidsi", $car_return_date, $no_of_days, $total_amount, $return_status, $id);
} else {
    $distance = $distance_or_days;
    $sql1 = "UPDATE rentedcars SET car_return_date=?, distance=?, no_of_days=?, total_amount=?, return_status=? WHERE id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("sidssi", $car_return_date, $distance, $duration, $total_amount, $return_status, $id);
}

$result1 = $stmt->execute();

if ($result1) {
    $sql2 = "UPDATE cars c, driver d, rentedcars rc
             SET c.car_availability='yes', d.driver_availability='yes'
             WHERE rc.car_id=c.car_id AND rc.driver_id=d.driver_id AND rc.customer_username = ? AND rc.id = ?";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("si", $login_customer, $id);
    $stmt->execute();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill - Order #<?php echo $id; ?> | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { padding-top: 56px; background-color: #f8f9fa; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; background: #fff; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td { width: 100%; display: block; text-align: center; }
            .invoice-box table tr.information table td { width: 100%; display: block; text-align: center; }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading"><i class="fas fa-check-circle"></i> Car Returned Successfully</h4>
            <p>Thank you for choosing LiveLife Automobiles. We hope you had a great experience!</p>
        </div>

        <div class="invoice-box mt-4">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="assets/img/logo.png" style="width:100%; max-width:300px;">
                                </td>
                                <td class="text-right">
                                    Invoice #: <?php echo $id; ?><br>
                                    Created: <?php echo date("F j, Y"); ?><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    LiveLife Automobiles<br>
                                    123 Main Street<br>
                                    City, State 12345
                                </td>
                                <td class="text-right">
                                    <?php echo $_SESSION['login_customer']; ?><br>
                                    Customer ID: <?php echo $_SESSION['login_customer']; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="heading">
                    <td>Car Details</td>
                    <td>Info</td>
                </tr>

                <tr class="details">
                    <td>Vehicle Name</td>
                    <td><?php echo $car_name; ?></td>
                </tr>

                <tr class="details">
                    <td>Vehicle Number</td>
                    <td><?php echo $car_nameplate; ?></td>
                </tr>

                <tr class="heading">
                    <td>Rental Details</td>
                    <td>Date</td>
                </tr>

                <tr class="item">
                    <td>Start Date</td>
                    <td><?php echo $rent_start_date; ?></td>
                </tr>

                <tr class="item">
                    <td>End Date</td>
                    <td><?php echo $rent_end_date; ?></td>
                </tr>

                <tr class="item">
                    <td>Return Date</td>
                    <td><?php echo $car_return_date; ?></td>
                </tr>

                <tr class="heading">
                    <td>Charges</td>
                    <td>Price</td>
                </tr>

                <tr class="item">
                    <td>Fare (<?php echo $charge_type == "days" ? "per day" : "per km"; ?>)</td>
                    <td><?php echo CURRENCY . $fare; ?></td>
                </tr>

                <tr class="item">
                    <td><?php echo $charge_type == "days" ? "Number of days" : "Distance travelled"; ?></td>
                    <td><?php echo $distance_or_days . ($charge_type == "days" ? " day(s)" : " km"); ?></td>
                </tr>

                <?php if($extra_days > 0) { ?>
                <tr class="item">
                    <td>Late Return Fine (<?php echo $extra_days; ?> extra days)</td>
                    <td><?php echo CURRENCY . $total_fine; ?></td>
                </tr>
                <?php } ?>

                <tr class="total">
                    <td></td>
                    <td>Total: <?php echo CURRENCY . $total_amount; ?></td>
                </tr>
            </table>
        </div>

        <div class="text-center mt-4">
            <button onclick="window.print();" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Invoice
            </button>
            <a href="mybookings.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to My Bookings
            </a>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
