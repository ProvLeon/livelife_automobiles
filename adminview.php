<!DOCTYPE html>
<html>
<?php
session_start();
require_once 'connection.php';
$conn = Connect();
?>
<head>
    <title>Admin View | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link rel="stylesheet" type="text/css" href="assets/css/customerlogin.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/adminpage.css" />
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .content-wrapper {
            flex: 1 0 auto;
        }
        .livelife-footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body id="page-top" data-spy="scroll">

<?php include 'navbar.php'; ?>

<?php
$login_admin = $_SESSION['login_admin'];
$sql1 = "SELECT * FROM rentedcars rc, clientcars cc, customers c, cars WHERE cc.client_username = '$login_admin' AND cc.car_id = rc.car_id AND rc.return_status = 'R' AND c.customer_username = rc.customer_username AND cc.car_id = cars.car_id";
$result1 = $conn->query($sql1);

if (mysqli_num_rows($result1) > 0) {
?>
<div class="container">
    <div class="jumbotron">
        <h1>Your Bookings</h1>
        <p>Hope you enjoyed our service</p>
    </div>
</div>

<div class="table-responsive" style="padding-left: 100px; padding-right: 100px;" >
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th width="20%">Car</th>
                <th width="15%">Customer Name</th>
                <th width="20%">Rent Start Date</th>
                <th width="20%">Rent End Date</th>
                <th width="10%">Distance</th>
                <th width="15%">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result1)) {
            ?>
            <tr>
                <td><?php echo $row["car_name"]; ?></td>
                <td><?php echo $row["customer_name"]; ?></td>
                <td><?php echo $row["rent_start_date"] ?></td>
                <td><?php echo $row["rent_end_date"]; ?></td>
                <td><?php echo $row["distance"]; ?></td>
                <td><?php echo CURRENCY . $row["total_amount"]; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
} else {
?>
<div class="container">
    <div class="jumbotron">
        <h1>No booked cars</h1>
        <p>Rent some cars now</p>
    </div>
</div>
<?php
}
?>

<div></div>
<br/>
<br/>
<br/>
<br/>
<?php include 'footer.php'; ?>
</body>
</html>
