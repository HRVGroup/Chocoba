<?php
session_start();
include "../conn.php";

// Periksa apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai username dan password dari form
    $username = $_POST['email'];
    $password = $_POST['pw'];

    // Query untuk memeriksa apakah username dan password cocok
    $sql = "SELECT * FROM user WHERE email='$username' AND pasword='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika login berhasil, set session dan redirect ke halaman dashboard
        $_SESSION["username"] = $username;
        header("Location: ../home.php");
    } else {
        // Jika login gagal, tampilkan pesan error atau redirect kembali ke halaman login
        echo "<script>Login failed. Invalid username or password</script>";
    }

    // Tutup koneksi
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chocoba</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../asset/css/style.css">
  </head>
  <body>

    <section class="login d-flex justify-content-center">
        <p><span>CHOCOBA</span>SNACK</p>
        <div class="gambar-login col-6">
            <div class="img"></div>
        </div>
        <div class="form-login col-6">
            <h1>HELLO WELCOME</h1>
            <p>Selamat datang kembali, selamat
                berbelanja disini</p>
            <form action="" method="post" class="input">
                <input type="email" name="email" placeholder="          Email">
                <input type="password" name="pw" placeholder="         Kata Sandi">

                <button type="submit">LOGIN</button>
            </form>
            <div class="d-flex justify-content-center">
                <div class="lupa">
                    <a href="">LUPA PASSWORD</a>
                </div>
                <div class="buat">
                    <a href="">BUAT AKUN</a>
                </div>
            </div>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>