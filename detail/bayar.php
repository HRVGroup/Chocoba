<?php
namespace Midtrans;
session_start();

include '../conn.php';
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans/Notification.php'; // Memuat kelas Notification

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-K8b0jrqMoVY7E9MCLAKM2Mlt';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

$id = $_GET['beli'];
$barang = $conn->query("SELECT h_barang FROM barang WHERE id = $id");
$hasil = $barang->fetch_assoc();

$use = $_SESSION['username'];
$user = $conn->query("SELECT * FROM user WHERE email = '$use'");
$result = $user->fetch_assoc();

$jumlah = $hasil['h_barang'] * $_GET['banyak'];

$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $jumlah,
    ),
    'customer_details' => array(
        'first_name' => $result['username'],
        'email' => $result['email'],
        'phone' => $result['no_hp'],
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);

if (empty($_SESSION['cek'])) {
  $order = $params['transaction_details']['order_id'];
  $gros = $jumlah;
  $harga = $hasil['h_barang'];

  $conn->query("INSERT INTO tranksasi VALUES ('', '$order', '$harga', '$gros', '', '')");
  $_SESSION['cek'] = 'sudah';
}
  
if ($_POST) {
  try {
    // Membuat instance objek Notification
    $notification = new \Midtrans\Notification();
    // Mendapatkan respons dari Midtrans
    $transaction_status = $notification->transaction_status;
    $fraud_status = $notification->fraud_status;
    $order_id = $notification->order_id;
    $alamat = $_POST['alamat'];

    // Menyimpan status transaksi ke dalam database
    $conn->query("UPDATE tranksasi SET status_p = '$transaction_status', alamat = '$alamat' WHERE order_id = $order_id");
  } catch (\Exception $e) {
    // Tangani kesalahan
    exit($e->getMessage());
  }
}

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
    <script type="text/javascript"
		src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-h_TvY-2raIxF7dLz"></script>
  </head>
  <body>
    
  <div class="container overflow-hidden detail">
      <a href="index.php"><div class="bi bi-arrow-left"></div></a>

        <div class="row gx-4 gap-5">
          <div class="col-lg-6 g" style="background-image: url(../asset/img/1c63eddf-6304-4e65-b84f-941ae4c1c3e7.jpg);"></div>
          <div class="col-lg-5">
              <h1 class="h1">SELESAIKAN PEMBAYARAN</h1>
              
              <form action="" method="post" class="justify-content-center">
                <p>METODE PEMBAYARAN</p>
                <button type="button" class="b btn btn-light">Pilih Pembayaran</button>

                <p>TOTAL HARGA</p>
                <input class="number" name="total" readonly value="10.000">

                <p>ALAMAT PENERIMA</p>
                <textarea name="alamat"></textarea>
                <!-- id="ada" -->
                <button type="submit" class="tombol" id='ada'>SELESAIKAN TRANSAKSI</button>
              </form>
          </div>
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="text/javascript">
      button = document.getElementById('ada');

      button.addEventListener('click', async function (e) {
        e.preventDefault();

        try {
          window.snap.pay('<?= $snapToken ?>');
        } catch {
          console.log(err.message)
        }  
      });
    </script>
</body>