<?php
include('session_admin.php');
require 'connection.php';
$conn = Connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Drivers | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/adminpage.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Manage Drivers</h2>

        <!-- Add Driver Form -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add New Driver</h5>
            </div>
            <div class="card-body">
                <form action="enterdriver1.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="driver_name">Driver Name</label>
                            <input type="text" class="form-control" id="driver_name" name="driver_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dl_number">Driving License Number</label>
                            <input type="text" class="form-control" id="dl_number" name="dl_number" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="driver_phone">Contact</label>
                            <input type="tel" class="form-control" id="driver_phone" name="driver_phone" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="driver_address">Address</label>
                            <input type="text" class="form-control" id="driver_address" name="driver_address" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="driver_gender">Gender</label>
                            <select class="form-control" id="driver_gender" name="driver_gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Add Driver</button>
                </form>
            </div>
        </div>

        <!-- Driver Listing -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">My Drivers</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>DL Number</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user_check = $_SESSION['login_admin'];
                            $sql = "SELECT * FROM driver WHERE client_username='$user_check' ORDER BY driver_name";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["driver_name"] . "</td>";
                                    echo "<td>" . $row["driver_gender"] . "</td>";
                                    echo "<td>" . $row["dl_number"] . "</td>";
                                    echo "<td>" . $row["driver_phone"] . "</td>";
                                    echo "<td>" . $row["driver_address"] . "</td>";
                                    echo "<td>" . $row["driver_availability"] . "</td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-primary mr-2' onclick='openUpdateModal(" . json_encode($row) . ")'>Update</button>
                                            <button class='btn btn-sm btn-danger' onclick='removeDriver(" . $row["driver_id"] . ")'>Remove</button>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No drivers available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Driver Modal -->
    <div class="modal fade" id="updateDriverModal" tabindex="-1" role="dialog" aria-labelledby="updateDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateDriverModalLabel">Update Driver Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateDriverForm">
                        <input type="hidden" id="update_driver_id" name="driver_id">
                        <div class="form-group">
                            <label for="update_driver_name">Driver Name</label>
                            <input type="text" class="form-control" id="update_driver_name" name="driver_name" required>
                        </div>
                        <div class="form-group">
                            <label for="update_dl_number">Driving License Number</label>
                            <input type="text" class="form-control" id="update_dl_number" name="dl_number" required>
                        </div>
                        <div class="form-group">
                            <label for="update_driver_phone">Contact</label>
                            <input type="tel" class="form-control" id="update_driver_phone" name="driver_phone" required>
                        </div>
                        <div class="form-group">
                            <label for="update_driver_address">Address</label>
                            <input type="text" class="form-control" id="update_driver_address" name="driver_address" required>
                        </div>
                        <div class="form-group">
                            <label for="update_driver_gender">Gender</label>
                            <select class="form-control" id="update_driver_gender" name="driver_gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateDriver()">Update Driver</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function openUpdateModal(driver) {
            $('#update_driver_id').val(driver.driver_id);
            $('#update_driver_name').val(driver.driver_name);
            $('#update_dl_number').val(driver.dl_number);
            $('#update_driver_phone').val(driver.driver_phone);
            $('#update_driver_address').val(driver.driver_address);
            $('#update_driver_gender').val(driver.driver_gender);
            $('#updateDriverModal').modal('show');
        }

        function updateDriver() {
            $.ajax({
                url: 'updatedriver.php',
                type: 'POST',
                data: $('#updateDriverForm').serialize(),
                success: function(response) {
                    alert('Driver updated successfully');
                    location.reload();
                },
                error: function() {
                    alert('Error updating driver');
                }
            });
        }

        function removeDriver(driverId) {
            if (confirm('Are you sure you want to remove this driver?')) {
                $.ajax({
                    url: 'removedriver.php',
                    type: 'POST',
                    data: { driver_id: driverId },
                    success: function(response) {
                        alert('Driver removed successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Error removing driver');
                    }
                });
            }
        }
    </script>
</body>
</html>
