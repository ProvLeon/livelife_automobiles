<?php
session_start();
require_once 'connection.php';
$conn = Connect();

// Check if admin is logged in
if (!isset($_SESSION['login_admin'])) {
    header("Location: adminlogin.php");
    exit();
}

$login_admin = $_SESSION['login_admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/adminview.css">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            padding-top: 60px; /* Adjust this value based on your navbar height */
        }
        .content-wrapper {
            flex: 1 0 auto;
            margin-top: 20px;
        }
        .footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Admin Dashboard</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user-shield mr-2"></i>Admin Actions</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="entercar.php" class="text-dark"><i class="fas fa-car mr-2"></i>Add New Car</a></li>
                        <li class="list-group-item"><a href="enterdriver.php" class="text-dark"><i class="fas fa-id-card mr-2"></i>Add New Driver</a></li>
                        <li class="list-group-item active"><a href="adminview.php" class="text-white"><i class="fas fa-eye mr-2"></i>View Bookings</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-book mr-2"></i>Current Bookings</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $sql1 = "SELECT rc.*, c.customer_name, cars.car_name
                                 FROM rentedcars rc
                                 JOIN clientcars cc ON cc.car_id = rc.car_id
                                 JOIN customers c ON c.customer_username = rc.customer_username
                                 JOIN cars ON cars.car_id = cc.car_id
                                 WHERE cc.client_username = '$login_admin' AND rc.return_status = 'R'
                                 ORDER BY rc.rent_start_date DESC";
                        $result1 = $conn->query($sql1);

                        if (mysqli_num_rows($result1) > 0) {
                        ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Car</th>
                                            <th>Customer</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Distance</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = mysqli_fetch_assoc($result1)) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row["car_name"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["customer_name"]); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($row["rent_start_date"])); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($row["rent_end_date"])); ?></td>
                                            <td><?php echo $row["distance"] . " km"; ?></td>
                                            <td><?php echo CURRENCY . number_format($row["total_amount"], 2); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle mr-2"></i>No active bookings at the moment.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
