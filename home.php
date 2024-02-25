<?php
session_start();
include "conn.php";

if ($_SESSION['username']) {
  $login = 'detail/';
} else {
  $login = '';
}

$barang = $conn->query("SELECT * FROM barang");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="asset/css/style.css">
  </head>
  <body>
    <?php 
    if ($_SESSION['username'] && !$_SESSION['alert']) {
      echo '<div class="modal fade show text-center" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">terimakasih sudah login, sekarang pilih barang yang ingin anda beli!</h1>
            <button type="button" class="btn-close" onclick="closeAlert()" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-footer">
            <button class="btn btn-warning" onclick="closeAlert()">okey</button>
          </div>
        </div>
      </div>
    </div>';

    $_SESSION['alert'] = 'sudah';
    }

    if (!$_SESSION['alert'] && !$_SESSION['username']) {
    echo '<div class="modal fade show text-center" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Anda belum login, jika ingin membeli barang silahkan login!</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-dark" onclick="closeAlert()">tidak</button>
          <a href="login/" type="button" class="btn btn-warning">okey</a>
        </div>
      </div>
    </div>
  </div>';
    }
    ?>
    <!-- navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container d-flex flex-nowrap" id="baru">
          <a class="navbar-brand order-1" href="#" id="judul">Chocoba<span>Snack</span></a>
          <form class="d-flex order-2" id="cari" role="search">
              <input class="me-2" type="text" aria-label="Search">
          </form>
          <div class="notif order-4" id="bel">
            <a href=""><i class="bi bi-bell-fill "></i></a>
          </div>
          <button class="navbar-toggler order-5" id="togel" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse order-3" id="navbarSupportedContent">
            <ul class="navbar-nav mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Keranjang/">Keranjang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="histori/">Histori</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- iklan -->
      <header class="header container">
        <div class="carosel">

          <div class="row">
            <div class="col-4">
              PROMO<span>45%</span>
              <p>Hanya pembeli pertama</p>
            </div>

            <div class="col-4 hilang"></div>

            <div class="col-4">
              <p class="s">
                BEST<span>SNACK</span>
              </p>
            </div>
          </div>

          <div class="img"></div>
        </div>
      </header>

      <main class="produk container">
        <p>BEST SELLER</p>

        <div class="garis"></div>

        <section class="barang">
          <?php while($result = $barang->fetch_assoc()) { ?>
          <div class="box">
            <a href="<?= $login ?>?barang=<?= $result['id'] ?>">
              <img src="asset/img/1c63eddf-6304-4e65-b84f-941ae4c1c3e7.jpg" alt="">
              <h3><?= $result['n_barang'] ?></h3>
              <h5>Rp. <?= $result['h_barang'] ?></h5>
            </a>
          </div>
          <?php } ?>
        </section>

      </main>
      

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Mendapatkan elemen yang ingin ditambahkan kelas dan gaya CSS
    var alert = document.getElementById("exampleModal");
      alert.style.display = "block";
      setTimeout(function() {
        alert.style.opacity = 1;
        alert.classList.remove("hide");
      }, 100);
});

// Fungsi untuk menutup alert
function closeAlert() {
  var alert = document.getElementById("exampleModal");
  alert.style.opacity = 0;
  alert.classList.add("hide");
}
    </script>
    <script>
      const togel = document.getElementById('togel')
      const collapse = document.getElementById('navbarSupportedContent')
      const judul = document.getElementById('judul')
      const bel = document.getElementById('bel')
      const baru = document.getElementById('baru')
      const cari = document.getElementById('cari')

      togel.addEventListener("click", () => {
        collapse.classList.toggle("order-3")
        bel.classList.toggle("order-4")
        togel.classList.toggle("order-5")
        judul.classList.toggle("order-1")
        baru.classList.toggle("d-flex")
        baru.classList.toggle("flex-nowrap")
        cari.classList.toggle("order-2")
      });
    </script>
  </body>
</html>