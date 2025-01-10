<?php
session_start();


// Handle the removal of an item from the cart
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array after removing an item
    header("Location: cart.php"); // Redirect back to the cart page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Putisserie Delight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Keranjang Belanja</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Keranjang Belanja Kosong. Tambahkan beberapa produk terlebih dahulu.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $index => $item) {
                    echo "
                        <tr>
                            <td>{$item['name']}</td>
                            <td>Rp" . number_format($item['price'], 0, ',', '.') . "</td>
                            <td><a href='cart.php?remove=$index' class='btn btn-danger'>Remove</a></td>
                        </tr>
                    ";
                    $total += $item['price'];
                }
                ?>
            </tbody>
        </table>
        <h4>Total: Rp<?php echo number_format($total, 0, ',', '.'); ?></h4>

        <a href="payment.php" class="btn btn-primary">Checkout</a>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
