<?php
session_start();
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulate payment processing
    $payment_successful = true; // In a real scenario, this would involve actual payment gateway logic

    if ($payment_successful) {
        // Store booking details in session
        $_SESSION['car_id'] = $_POST['car_id'];
        $_SESSION['start_date'] = $_POST['start_date'];
        $_SESSION['end_date'] = $_POST['end_date'];
        $_SESSION['car_type'] = $_POST['car_type'];
        $_SESSION['charge_type'] = $_POST['charge_type'];
        $_SESSION['driver_id'] = $_POST['driver_id'];
        $_SESSION['total_cost'] = floatval($_POST['total_cost']);

        // Here you would insert the booking details into your database
        $conn = Connect();
        $booking_id = mt_rand(100000, 999999); // Generate a random booking ID
        $customer_username = $_SESSION['login_customer'];

        // Format dates for MySQL
        $start_date = date('Y-m-d', strtotime($_SESSION['start_date']));
        $end_date = date('Y-m-d', strtotime($_SESSION['end_date']));

        // Calculate the number of days
        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);
        $interval = $date1->diff($date2);
        $no_of_days = $interval->days + 1; // Add 1 to include both start and end dates

        // Calculate fare based on charge type
        if ($_SESSION['charge_type'] == 'day') {
            $fare = $_SESSION['total_cost'] / $no_of_days;
        } else { // 'km'
            $fare = $_SESSION['total_cost'] / (100 * $no_of_days); // Assuming 100 km per day
        }

        $return_status = 'NR'; // Define the return status as a variable

        $sql = "INSERT INTO rentedcars (id, customer_username, car_id, driver_id, booking_date, rent_start_date, rent_end_date, fare, charge_type, no_of_days, total_amount, return_status)
                VALUES (?, ?, ?, ?, CURDATE(), ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isiisssdiis",
            $booking_id,
            $customer_username,
            $_SESSION['car_id'],
            $_SESSION['driver_id'],
            $start_date,
            $end_date,
            $fare,
            $_SESSION['charge_type'],
            $no_of_days,
            $_SESSION['total_cost'],
            $return_status
        );

        if ($stmt->execute()) {
            $_SESSION['booking_success'] = true;
            $_SESSION['booking_id'] = $booking_id;
            header("Location: booking_confirmation.php");
            exit;
        } else {
            $_SESSION['booking_error'] = "An error occurred while processing your booking. Please try again. Error: " . $stmt->error;
            header("Location: booking.php?id=" . $_POST['car_id']);
            exit;
        }
    } else {
        $_SESSION['payment_error'] = "Payment processing failed. Please try again.";
        header("Location: booking.php?id=" . $_POST['car_id']);
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
