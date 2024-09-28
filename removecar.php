<?php
include('session_admin.php');
require 'connection.php';
$conn = Connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = mysqli_real_escape_string($conn, $_POST['car_id']);

    // First, delete from clientcars table
    $sql_clientcars = "DELETE FROM clientcars WHERE car_id = $car_id";
    mysqli_query($conn, $sql_clientcars);

    // Then, delete from cars table
    $sql_cars = "DELETE FROM cars WHERE car_id = $car_id";
    if (mysqli_query($conn, $sql_cars)) {
        echo "success";
    } else {
        echo "error";
    }
}

mysqli_close($conn);
?>
