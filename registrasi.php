<?php
require 'functions.php';

if (isset($_POST["register"])) {

	if (registrasi($_POST) > 0) {
		echo "
			<script>
				alert('Register Sukses');
			</script>
		";
	} else {
		echo mysqli_error($conn);
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrasi</title>


	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>

	<div class="container mt-5 border border-text-secondary">
		<h3 class="text-center text-muted">Halaman Registrasi</h3>
		<form action="" method="post">
			<div class="row d-flex justify-content-center">
				<div class="col-md-6">
					<div class="form-outline mb-4">
						<label for="username" class="form-label">Username</label>
						<input type="text" id="username" name="username" class="form-control">
					</div>
					<div class="form-outline mb-4">
						<label for="password" class="form-label">Password</label>
						<input type="password" id="password" name="password" class="form-control">
					</div>
					<div class="form-outline mb-4">
						<label for="re_password" class="form-label">Re-Password</label>
						<input type="password" id="re_password" name="re_password" class="form-control">
					</div>
					<div class="form-outline mb-4">
						<label for="email" class="form-label">Email</label>
						<input type="text" id="email" name="email" class="form-control">
					</div>
					<div class="row mb-4">
						<button type="submit" class="btn btn-primary btn-block mb-4" name="register">Registarsi</button>
						<a href="login.php" class="text-center">Login</a>
					</div>
				</div>
			</div>
		</form>
	</div>

</body>

</html>