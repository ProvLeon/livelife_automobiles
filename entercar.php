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
    <title>Manage Cars | LiveLife Automobiles</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="assets/css/adminpage.css"> -->
    <style>
    .actions {
        display: flex;
    }
    #bg-custom, #thead-custom {
        background-color: #2c3e50;
    }

    .thead-dark {
        color: white;
        font-weight: bold;
        justify-self: center;
        text-align: center;
    }

    #add_car_btn {
        position: right;
    }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Manage Cars</h2>

        <!-- Add Car Form -->
        <div class="card mb-4">
            <div id='bg-custom' class="card-header bg-custom text-white">
                <h5 class="mb-0">Add New Car</h5>
            </div>
            <div class="card-body">
                <form action="entercar1.php" enctype="multipart/form-data" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="car_name">Car Name</label>
                            <input type="text" class="form-control" id="car_name" name="car_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="car_nameplate">Vehicle Number</label>
                            <input type="text" class="form-control" id="car_nameplate" name="car_nameplate" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="ac_price">AC Fare per km</label>
                            <input type="number" class="form-control" id="ac_price" name="ac_price" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="non_ac_price">Non-AC Fare per km</label>
                            <input type="number" class="form-control" id="non_ac_price" name="non_ac_price" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ac_price_per_day">AC Fare per day</label>
                            <input type="number" class="form-control" id="ac_price_per_day" name="ac_price_per_day" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="non_ac_price_per_day">Non-AC Fare per day</label>
                            <input type="number" class="form-control" id="non_ac_price_per_day" name="non_ac_price_per_day" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="car_image">Car Image</label>
                        <input type="file" class="form-control-file" id="car_image" name="uploadedimage" required>
                    </div>
                    <button id='add_car_btn' type="submit" name="submit" class="btn btn-primary">Add Car</button>
                </form>
            </div>
        </div>

        <!-- Car Listing -->
        <div class="card">
            <div id='bg-custom' class="card-header bg-custom text-white">
                <h5 class="mb-0">My Cars</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead id='thead-custom' class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Nameplate</th>
                                <th>AC Fare (/km)</th>
                                <th>Non-AC Fare (/km)</th>
                                <th>AC Fare (/day)</th>
                                <th>Non-AC Fare (/day)</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user_check = $_SESSION['login_admin'];
                            $sql = "SELECT * FROM cars WHERE car_id IN (SELECT car_id FROM clientcars WHERE client_username='$user_check')";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["car_name"] . "</td>";
                                    echo "<td>" . $row["car_nameplate"] . "</td>";
                                    echo "<td>" . $row["ac_price"] . "</td>";
                                    echo "<td>" . $row["non_ac_price"] . "</td>";
                                    echo "<td>" . $row["ac_price_per_day"] . "</td>";
                                    echo "<td>" . $row["non_ac_price_per_day"] . "</td>";
                                    echo "<td>" . $row["car_availability"] . "</td>";
                                    echo "<td class='actions'>
                                            <button class='btn btn-sm btn-primary mr-2' onclick='openUpdateModal(" . json_encode($row) . ")'>Update</button>
                                            <button class='btn btn-sm btn-danger' onclick='removeCar(" . $row["car_id"] . ")'>Remove</button>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No cars available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Car Modal -->
    <div class="modal fade" id="updateCarModal" tabindex="-1" role="dialog" aria-labelledby="updateCarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCarModalLabel">Update Car Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateCarForm">
                        <input type="hidden" id="update_car_id" name="car_id">
                        <div class="form-group">
                            <label for="update_car_name">Car Name</label>
                            <input type="text" class="form-control" id="update_car_name" name="car_name" required>
                        </div>
                        <div class="form-group">
                            <label for="update_car_nameplate">Vehicle Number</label>
                            <input type="text" class="form-control" id="update_car_nameplate" name="car_nameplate" required>
                        </div>
                        <div class="form-group">
                            <label for="update_ac_price">AC Fare per km</label>
                            <input type="number" class="form-control" id="update_ac_price" name="ac_price" required>
                        </div>
                        <div class="form-group">
                            <label for="update_non_ac_price">Non-AC Fare per km</label>
                            <input type="number" class="form-control" id="update_non_ac_price" name="non_ac_price" required>
                        </div>
                        <div class="form-group">
                            <label for="update_ac_price_per_day">AC Fare per day</label>
                            <input type="number" class="form-control" id="update_ac_price_per_day" name="ac_price_per_day" required>
                        </div>
                        <div class="form-group">
                            <label for="update_non_ac_price_per_day">Non-AC Fare per day</label>
                            <input type="number" class="form-control" id="update_non_ac_price_per_day" name="non_ac_price_per_day" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateCar()">Update Car</button>
                </div>
            </div>
        </div>
    </div>
<br/>
<br/>
<br/>
    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function openUpdateModal(car) {
            $('#update_car_id').val(car.car_id);
            $('#update_car_name').val(car.car_name);
            $('#update_car_nameplate').val(car.car_nameplate);
            $('#update_ac_price').val(car.ac_price);
            $('#update_non_ac_price').val(car.non_ac_price);
            $('#update_ac_price_per_day').val(car.ac_price_per_day);
            $('#update_non_ac_price_per_day').val(car.non_ac_price_per_day);
            $('#updateCarModal').modal('show');
        }

        function updateCar() {
            $.ajax({
                url: 'updatecar.php',
                type: 'POST',
                data: $('#updateCarForm').serialize(),
                success: function(response) {
                    alert('Car updated successfully');
                    location.reload();
                },
                error: function() {
                    alert('Error updating car');
                }
            });
        }

        function removeCar(carId) {
            if (confirm('Are you sure you want to remove this car?')) {
                $.ajax({
                    url: 'removecar.php',
                    type: 'POST',
                    data: { car_id: carId },
                    success: function(response) {
                        alert('Car removed successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Error removing car');
                    }
                });
            }
        }
    </script>
</body>
</html>
