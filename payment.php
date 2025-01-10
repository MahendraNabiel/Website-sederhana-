<?php
session_start();


// Handle the form submission for checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user details from checkout form
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Calculate total price
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'];
    }

    // Create the order message
    $orderMessage = "Detai Pesanan:\n";
    $orderMessage .= "Nama: $name\n";
    $orderMessage .= "Email: $email\n";
    $orderMessage .= "No. HP: $phone\n";
    $orderMessage .= "Alamat Pengiriman: $address\n";
    $orderMessage .= "Jumlah Order:\n";

    foreach ($_SESSION['cart'] as $item) {
        $orderMessage .= "- {$item['name']} (Rp" . number_format($item['price'], 0, ',', '.') . ")\n";
    }

    $orderMessage .= "Total: Rp" . number_format($total, 0, ',', '.') . "\n";
    $orderMessage .= "Harap konfirmasi pesanan Anda dan lanjutkan dengan pembayaran.";

    // Encode the message for URL
    $encodedMessage = urlencode($orderMessage);

    // Redirect to WhatsApp with the order message
    $whatsappUrl = "https://api.whatsapp.com/send?phone=081310287270&text=$encodedMessage";
    header("Location: $whatsappUrl");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Checkout</h2>

    <h4>Total Keranjang: Rp<?php 
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'];
        }
        echo number_format($total, 0, ',', '.');
    ?></h4>

    <!-- Checkout Form -->
    <form method="POST" action="payment.php">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat Pengiriman</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <button type="submit" class="btn btn-success">Order Sekarang</button>
    </form>

    <div class="mt-5">
        <h4>Konfirmasi Pesanan</h4>
        <p>Setelah pesanan Anda dilakukan, Anda akan menerima konfirmasi dengan ID pesanan Anda melalui WhatsApp.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
