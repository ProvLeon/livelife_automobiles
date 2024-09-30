<?php
require_once 'connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login_customer'])) {
    echo json_encode(array('error' => 'User not logged in'));
    exit;
}

// Check if driver_id is set
if (!isset($_POST['driver_id'])) {
    echo json_encode(array('error' => 'No driver ID provided'));
    exit;
}

$conn = Connect();

$driver_id = $conn->real_escape_string($_POST['driver_id']);

$sql = "SELECT driver_name, driver_gender, driver_phone FROM driver WHERE driver_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $driver = $result->fetch_assoc();
    echo json_encode($driver);
} else {
    echo json_encode(array('error' => 'Driver not found'));
}

$stmt->close();
$conn->close();
?>
