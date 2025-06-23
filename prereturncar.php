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
    <title>Return Car | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
    <div class="container">
        <h1 class="text-center mb-4">Return Your Car</h1>

        <?php
        $sql1 = "SELECT c.car_name, rc.rent_start_date, rc.rent_end_date, rc.fare, rc.charge_type, rc.id
                 FROM rentedcars rc
                 JOIN cars c ON c.car_id = rc.car_id
                 WHERE rc.customer_username = ? AND rc.return_status = 'NR'
                 ORDER BY rc.rent_end_date ASC";

        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("s", $login_customer);
        $stmt->execute();
        $result1 = $stmt->get_result();

        if ($result1->num_rows > 0) {
        ?>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-car mr-2"></i>Cars to Return</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Car</th>
                                <th>Rent Start Date</th>
                                <th>Rent End Date</th>
                                <th>Fare</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result1->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["car_name"]); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row["rent_start_date"])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row["rent_end_date"])); ?></td>
                                <td>
                                    <?php
                                    echo CURRENCY . number_format($row["fare"], 2) .
                                         ($row["charge_type"] == "days" ? "/day" : "/km");
                                    ?>
                                </td>
                                <td>
                                    <a href="returncar.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-undo-alt mr-1"></i>Return
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle mr-2"></i>You have no cars to return at the moment.
        </div>
        <?php } ?>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
