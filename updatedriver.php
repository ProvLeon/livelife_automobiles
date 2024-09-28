<?php
include('session_admin.php');
require 'connection.php';
$conn = Connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = mysqli_real_escape_string($conn, $_POST['driver_id']);
    $driver_name = mysqli_real_escape_string($conn, $_POST['driver_name']);
    $dl_number = mysqli_real_escape_string($conn, $_POST['dl_number']);
    $driver_phone = mysqli_real_escape_string($conn, $_POST['driver_phone']);
    $driver_address = mysqli_real_escape_string($conn, $_POST['driver_address']);
    $driver_gender = mysqli_real_escape_string($conn, $_POST['driver_gender']);

    $sql = "UPDATE driver SET
            driver_name = '$driver_name',
            dl_number = '$dl_number',
            driver_phone = '$driver_phone',
            driver_address = '$driver_address',
            driver_gender = '$driver_gender'
            WHERE driver_id = $driver_id";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}

mysqli_close($conn);
?>
