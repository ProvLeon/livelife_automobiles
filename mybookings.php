<?php
session_start();
require_once 'connection.php';
$conn = Connect();

// Check if customer is logged in
if (!isset($_SESSION['login_customer'])) {
    header("Location: customerlogin.php");
    exit();
}

$login_customer = $_SESSION['login_customer'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            padding-top: 60px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-wrapper {
            flex: 1 0 auto;
            padding: 20px 0;
        }
        .footer {
            flex-shrink: 0;
        }
        .booking-card {
            transition: all 0.3s ease;
        }
        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn-book-another {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="content-wrapper">
    <div class="container">
        <h1 class="text-center mb-4">My Bookings</h1>

        <?php
        $sql1 = "SELECT rc.*, c.car_name, c.car_img
                 FROM rentedcars rc
                 JOIN cars c ON c.car_id = rc.car_id
                 WHERE rc.customer_username = ? AND rc.return_status = 'R'
                 ORDER BY rc.rent_start_date DESC";

        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("s", $login_customer);
        $stmt->execute();
        $result1 = $stmt->get_result();

        if ($result1->num_rows > 0) {
        ?>
        <div class="row">
            <?php while($row = $result1->fetch_assoc()) { ?>
            <div class="col-md-6 mb-4">
                <div class="card booking-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-car mr-2"></i><?php echo htmlspecialchars($row["car_name"]); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo htmlspecialchars($row["car_img"]); ?>" alt="<?php echo htmlspecialchars($row["car_name"]); ?>" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <p><strong>Start Date:</strong> <?php echo date('M d, Y', strtotime($row["rent_start_date"])); ?></p>
                                <p><strong>End Date:</strong> <?php echo date('M d, Y', strtotime($row["rent_end_date"])); ?></p>
                                <p><strong>Fare:</strong> <?php echo CURRENCY . number_format($row["fare"], 2) . ($row["charge_type"] == "days" ? "/day" : "/km"); ?></p>
                                <p><strong><?php echo $row["charge_type"] == "days" ? "Days" : "Distance"; ?>:</strong> <?php echo $row["charge_type"] == "days" ? $row["no_of_days"] . " days" : $row["distance"] . " km"; ?></p>
                                <p><strong>Total Amount:</strong> <?php echo CURRENCY . number_format($row["total_amount"], 2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle mr-2"></i>You haven't made any bookings yet.
            <a href="index.php" class="alert-link">Rent a car now!</a>
        </div>
        <?php } ?>
    </div>
    <a href='index.php#sec2' class="btn btn-primary btn-lg btn-book-another">
        <i class="fas fa-plus mr-2"></i>Book Another Car</a>
</main>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>
