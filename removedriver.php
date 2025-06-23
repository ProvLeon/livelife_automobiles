<?php
include('session_admin.php');
require 'connection.php';
$conn = Connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = mysqli_real_escape_string($conn, $_POST['driver_id']);

    $sql = "DELETE FROM driver WHERE driver_id = $driver_id";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}

mysqli_close($conn);
?>
