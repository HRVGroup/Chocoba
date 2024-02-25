<?php
  session_start();
  include '../conn.php';

  $id = $_GET['barang'];
  $barang = $conn->query("SELECT * FROM barang WHERE id = $id");
  $hasil = $barang->fetch_assoc();

  $number = number_format($hasil['h_barang'], 0, ',', '.');

  $use = $_SESSION['username'];
  $user = $conn->query("SELECT * FROM user WHERE email = '$use'");
  $result = $user->fetch_assoc();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../asset/css/style.css">
  </head>
  <body>
    
    <div class="container overflow-hidden detail">
      <a href="../home.php"><div class="bi bi-arrow-left"></div></a>

        <div class="row gx-4 gap-5">
          <div class="col-lg-6 g" style="background-image: url(../asset/img/1c63eddf-6304-4e65-b84f-941ae4c1c3e7.jpg);"></div>
          <div class="col-lg-5">
              <h1><span>KRIPIK PISANG</span>
                <?= strtoupper($hasil['n_barang']) ?></h1>
              <h3><?= $number ?></h3>
              <div class="product-rating">
                <span class="star-rating">
                  <i></i>
                  <i></i>
                  <i></i>
                  <i></i>
                  <i></i>
                </span>
                <span class="rating-text"><?= $hasil['bintang'] ?></span>
              </div>
              <p><?= $hasil['desk_barang'] ?></p>
              <div class="jumlah">
                <form action="bayar.php" method="get">
                <input type="hidden" name="beli" value="<?= $id ?>">

                  JUMLAH PESANAN
                  <button type="button" id="kurang" onclick="decrement()"><i class="bi bi-dash"></i></button>
                  <input type="number" name="banyak" id="quantity" value="1">
                  <button type="button" id="tambah" onclick="increment()"><i class="bi bi-plus"></i></button>
                  <div class="tmbl d-flex justify-content-center gap-3">
                    <button type="submit">Beli</button>
                    <button type="button"><a href="">Keranjang</a></button>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        var disable = document.getElementById("tambah");
        var disable2 = document.getElementById("kurang");
        var quantity = document.getElementById("quantity");

        function increment() {
          quantity.value++;

          if (quantity.value >= 10) {
            disable.removeAttribute("onclick")
            disable.style.color = "gray";
          }

          if (quantity.value >= 1) {
            disable2.style.color = "black";
          }
        }
        
        function decrement() {
          quantity.value--;

          if (quantity.value < 10) {
            disable.setAttribute("onclick", "increment()")
            disable.style.color = "black";
          }

          if (quantity.value <= 1) {
            quantity.value = "1";
            disable2.style.color = "gray";
          }
        }

        quantity.addEventListener("input", Quantity);

        function validateQuantity(event) {
        if (event.key === "-") {
            event.preventDefault();
        }
        }

        quantity.addEventListener("keydown", validateQuantity);
    </script>
    <script>
const productRating = document.querySelectorAll(".product-rating");

for (const rating of productRating) {
  const starRating = rating.querySelector(".star-rating");
  const ratingText = rating.querySelector(".rating-text");

  const ratingValue = parseFloat(ratingText.textContent);

  // Mengatur jumlah bintang yang penuh
  for (let i = 0; i <= ratingValue; i++) {
    starRating.children[i].classList.add("bi", "bi-star-fill");
  }

  // Mengatur bintang setengah
  if (ratingValue % 1 !== 0) {
    const a = Math.floor(ratingValue);
    starRating.children[a].classList.add("bi", "bi-star-half");
  }

  // Mengatur bintang kosong
  for (let i = Math.ceil(ratingValue); i <= 5; i++) {
    starRating.children[i].classList.add("bi", "bi-star");
  }
}

    </script>
  </body>
</html>