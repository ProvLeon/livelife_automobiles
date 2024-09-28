<?php
include('login_admin.php'); // Includes Login Script

if(isset($_SESSION['login_admin'])){
    header("location: index.php"); //Redirecting
}

if (!isset($error)) {
    $error = '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Login | Car Rental</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/adminlogin.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="jumbotron">
        <h1>Welcome to LiveLife Automobiles <span>(Admin)</span></h1>
        <br>
        <p>Kindly LOGIN to continue.</p>
    </div>
</div>

<div class="container" style="margin-top: -2%; margin-bottom: 2%;">
    <div class="col-md-5 col-md-offset-4">
        <label style="margin-left: 5px;color: red;"><span> <?php echo $error;  ?> </span></label>
        <div class="panel panel-primary">
            <div class="panel-heading"> Login </div>
            <div class="panel-body">
                <form action="" method="POST">

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <label for="client_username"><span class="text-danger" style="margin-right: 5px;">*</span> Username: </label>
                                    <div class="input-group">
                                        <input class="form-control" id="client_username" type="text" name="client_username" placeholder="Username" required="" autofocus="">
                                        <span class="input-group-btn">
                <label class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></label>
            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <label for="client_password"><span class="text-danger" style="margin-right: 5px;">*</span> Password: </label>
                                    <div class="input-group">
                                        <input class="form-control" id="client_password" type="password" name="client_password" placeholder="Password" required="">
                                        <span class="input-group-btn">
                <label class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></label>
                                        </span>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-4">
                                    <button class="btn btn-primary" name="submit" type="submit" value=" Login ">Submit</button>

                                </div>

                            </div>
                            <label style="margin-left: 5px;">or</label> <br>
                            <label style="margin-left: 5px;"><a href="adminsignup.php">Create a new account.</a></label>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
