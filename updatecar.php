<?php
include('session_admin.php');
require 'connection.php';
$conn = Connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = mysqli_real_escape_string($conn, $_POST['car_id']);
    $car_name = mysqli_real_escape_string($conn, $_POST['car_name']);
    $car_nameplate = mysqli_real_escape_string($conn, $_POST['car_nameplate']);
    $ac_price = floatval($_POST['ac_price']);
    $non_ac_price = floatval($_POST['non_ac_price']);
    $ac_price_per_day = floatval($_POST['ac_price_per_day']);
    $non_ac_price_per_day = floatval($_POST['non_ac_price_per_day']);

    $sql = "UPDATE cars SET
            car_name = '$car_name',
            car_nameplate = '$car_nameplate',
            ac_price = $ac_price,
            non_ac_price = $non_ac_price,
            ac_price_per_day = $ac_price_per_day,
            non_ac_price_per_day = $non_ac_price_per_day
            WHERE car_id = $car_id";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}

mysqli_close($conn);
?>
