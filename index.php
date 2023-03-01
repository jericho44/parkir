<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PARKIR</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row text-center position-absolute top-50 start-50 translate-middle">
            <div class="col-md-5">
                <a href="parkirMasuk.php" class="btn btn-primary">Parkir Masuk</a>
            </div>
            <div class="col-md-5">
                <a href="parkirKeluar.php" class="btn btn-success">Parkir Keluar</a>
            </div>
            <div class="col-md-2">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>