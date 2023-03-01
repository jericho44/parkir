<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

if (isset($_POST["tambahParkir"])) {

    if (tambahParkir($_POST) > 0) {
        echo "
			<script>
				alert('Kendaran masuk parkir');
				document.location.href = 'parkirMasuk.php';
			</script>
			";
    } else {
        echo "		
			<script>
				alert('Data Gagal Ditambahkan');
			</script>
			";
    }
};

$parkirMasuk = query("SELECT * FROM jam_parkir ORDER BY id DESC");

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkir Masuk</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <h3 class="text-center">Parkir Masuk</h3>
            <div class="col-md-6">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="noPlat" class="form-label">Nomor Polisi</label>
                        <input type="text" name="noPlat" placeholder="Nomor Polisi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="jamMasuk" class="form-label">Jam Masuk</label>
                        <input type="datetime-local" name="jamMasuk" id="jamMasuk" class="form-control">
                    </div>
                    <button type="submit" name="tambahParkir" id="btn" class="btn btn-primary mt-3">Tambah</button>
                    <a class="btn btn-secondary mt-3" href="index.php">Kembali</a>
                </form>
            </div>
        </div>

        <div class="row mt-4">

            <table border="1" cellpadding="10" cellspacing="0" class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Nomor Polisi</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                    <th>Tarif</th>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($parkirMasuk as $item) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $item['noPlat']; ?></td>
                        <td><?= $item['jamMasuk']; ?></td>
                        <?php if ($item['jamKeluar'] == '0000-00-00 00:00:00') { ?>
                            <td>-</td>
                        <?php } else { ?>
                            <td><?= $item['jamKeluar']; ?></td>
                        <?php } ?>
                        <?php if ($item['status'] == 'Masuk') { ?>
                            <td>
                                <span class="badge text-bg-success"><?= $item['status']; ?></span>
                            </td>
                        <?php } else { ?>
                            <td>
                                <span class="badge text-bg-danger"><?= $item['status']; ?></span>
                            </td>
                        <?php } ?>
                        <td><?= $item['tarif']; ?></td>
                    </tr>


                    <?php $i++ ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const btn = document.getElementById('btn');

        btn.addEventListener('click', function handleClik() {
            const dateInput = document.querySelector('#jamMasuk');

            if (!dateInput.value) {
                event.preventDefault();
                alert('Mohon mengisikan jam masuk!')
            }
        });
    </script>
</body>

</html>