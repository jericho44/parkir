<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

if (isset($_POST["ubahParkir"])) {

    if (ubahParkir($_POST) > 0) {
        echo "
			<script>
				alert('Kendaraan sudah keluar');
				document.location.href = 'parkirKeluar.php';
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

// $parkirMasuk = query("SELECT * FROM jam_parkir");

if (isset($_POST["cariNoPlat"])) {
    $parkirMasuk = cariNoPlat($_POST["pencarian"]);
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkir Keluar</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <h3 class="text-center">Parkir Keluar</h3>
            <div class="col-md-8">
                <form action="" method="POST" class="d-flex">
                    <input type="text" name="pencarian" size="30" placeholder="pencarian.." autocomplete="off" autofocus="" class="form-control">
                    <button type="submit" name="cariNoPlat" class="btn btn-info mx-2">CARI!!</button>
                </form>
            </div>
        </div>


        <div class="row mt-4">
            <?php if (!empty($parkirMasuk)) { ?>
                <?php foreach ($parkirMasuk as $item) : ?>
                    <div class="col-md-8">
                        <form action="" method="POST" class="d-flex">
                            <div class="form-group mx-2">
                                <label for="noPlat" class="form-label">Nomor Polisi</label>
                                <input type="text" name="noPlat" value="<?= $item['noPlat'] ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group mx-2">
                                <label for="jamMasuk" class="form-label">Jam Masuk</label>
                                <input type="datetime-local" name="jamMasuk" id="jamMasuk" value="<?= $item['jamMasuk'] ?>" readonly class="form-control">
                            </div>
                            <?php if ($item['status'] == 'Keluar') { ?>
                                <div class="form-group mx-2">
                                    <label for="jamKeluar" class="form-label">Jam Keluar</label>
                                    <input type="datetime-local" name="jamKeluar" id="jamKeluar" value="<?= $item['jamKeluar'] ?>" readonly class="form-control">
                                </div>
                            <?php } else { ?>
                                <div class="form-group mx-2">
                                    <label for="jamKeluar" class="form-label">Jam Keluar</label>
                                    <input type="datetime-local" name="jamKeluar" id="jamKeluar" class="form-control">
                                </div>
                                <div class="form-group mt-4">
                                    <button class="btn btn-success" type="submit" name="ubahParkir" id="btn">Ubah</button>
                                </div>
                            <?php } ?>
                            <div class="form-group mt-4 mx-2">
                                <a class="btn btn-secondary btn-xs" href="index.php">Kembali</a>
                            </div>
                        </form>
                    </div>

                    <div class="row mt-4">
                        <table border="1" cellpadding="10" cellspacing="0" class="table table-bordered table-striped">
                            <?php $i = 1; ?>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Polisi</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                                <th>Tarif</th>
                            </tr>
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
                                <td>
                                    <b>
                                        <?= $item['tarif']; ?>
                                    </b>
                                </td>
                            </tr>


                            <?php $i++ ?>
                        <?php endforeach; ?>
                        </table>
                    </div>
        </div>



    <?php } ?>
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            const btn = document.getElementById('btn');

            btn.addEventListener('click', function handleClik() {
                const dateInput = document.querySelector('#jamKeluar');
                const jamMasuk = $('#jamMasuk').val();

                if (!dateInput.value) {
                    event.preventDefault();
                    alert('Mohon mengisikan jam keluar!')
                }

                if (new Date(dateInput.value) < new Date(jamMasuk)) {
                    alert('Jam keluar tidak boleh sebelum dibawah jam masuk!.')
                    event.preventDefault();

                }

                let tarif = '<%=session.getAttribute("tarif")%>';

                alert(tarif)
            });
        });
    </script>
</body>

</html>