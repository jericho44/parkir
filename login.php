<?php
session_start();
require 'functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM users WHERE id_user = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}


if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    // cek username
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            // cek sesion
            $_SESSION["login"] = true;

            // remember me
            if (isset($_POST["remember"])) {
                // buat cookie
                setcookie('id', $row['id_user'], time() + 120);
                setcookie('key', hash('sha256', $row['username']) + 120);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>


    <?php if (isset($error)) : ?>
        <p style="color: red; font-style: italic;">username / passowrd salah</p>
    <?php endif; ?>

    <div class="container mt-5 border border-text-secondary">
        <h3 class="text-center text-muted">Halaman Login</h3>
        <form action="" method="post">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" />
                    </div>

                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <div class="form-check">
                                <label class="form-check-label" for="remember"> Remember me </label>
                                <input class="form-check-input" type="checkbox" name="remember" value="" id="remember" checked />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mb-4" name="login">Login</button>
                        <a href="registrasi.php" class="text-center">Registrasi</a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>