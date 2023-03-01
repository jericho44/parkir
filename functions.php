<?php
$conn = mysqli_connect("localhost", "root", "", "parkir");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    };
    return $rows;
};


function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $re_password = mysqli_real_escape_string($conn, $data["re_password"]);
    $email = htmlspecialchars($data["email"]);


    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

    if (
        mysqli_fetch_assoc($result)
    ) {
        echo "
			<script>
				alert('username sudah terdaftar!!');
			</script>
		";
        return false;
    }


    // cek konfirmasi password
    if ($password !== $re_password) {
        echo "
			<script>
				alert('Konfirmasi Password Salah');
			</script>
		";
        return false;
        ' ';
    }

    // enkripsi password 
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan data ke database
    mysqli_query($conn, "INSERT INTO users VALUES (
							'','$username','$password','$email')");


    return mysqli_affected_rows($conn);
}


function tambahParkir($data)
{
    global $conn;

    $noPlat = htmlspecialchars($data['noPlat']);
    $jamMasuk = $data['jamMasuk'];
    $status = 'Masuk';
    $tarif = 2000;

    $query = "INSERT INTO jam_parkir
                VALUES
                ('','$noPlat','$jamMasuk','','$status', '$tarif')
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cariNoPlat($pencarian)
{
    $query = "SELECT * FROM jam_parkir WHERE
				noPlat LIKE '%$pencarian%'
			";
    return query($query);
}

function ubahParkir($data)
{
    global $conn;

    $noPlat = $data['noPlat'];
    $jamKeluar = $data['jamKeluar'];
    $jamMasuk = $data['jamMasuk'];
    $timeMasuk  = strtotime($jamMasuk);
    $timeKeluar = strtotime($jamKeluar);
    $status = 'Keluar';

    $diff = $timeKeluar - $timeMasuk;
    $jamDiff = floor($diff / (60 * 60));

    if ($jamDiff > 2) {
        $tarif2jam = 2000;
        $selisihWaktu = $jamDiff - 2;
        $tarifBerikutnya = $selisihWaktu * 500;
        $totalTarif = $tarif2jam + $tarifBerikutnya;
    } else {
        $totalTarif = 2000;
    }

    $query = "UPDATE `jam_parkir` SET
                `jamKeluar` = '$jamKeluar',
                `status` = '$status',
                `tarif` = '$totalTarif'
                WHERE `noPlat` = '$noPlat'
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
