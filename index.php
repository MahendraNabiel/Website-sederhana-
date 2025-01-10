<?php
session_start();

// Handle adding product to the cart
if (isset($_GET['add'])) {
    // Add product to cart session
    $productIndex = $_GET['add'];

    $products = [
        ['name' => 'Red Leather Sneakers', 'price' => 500000],
        ['name' => 'Black High Heels', 'price' => 700000],
        ['name' => 'Sporty Running Shoes', 'price' => 600000],
        ['name' => 'Brown Leather Boots', 'price' => 800000],
    ];

    $product = $products[$productIndex];

    $_SESSION['cart'][] = $product;  // Add to cart

    // Redirect to index after adding to cart
    header("Location: index.php");
    exit();

    
}
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
    header("Location: index.php");
    exit();
}

// Handle removing product from the cart
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoes Store</title>

    <!-- swiper link -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- cdn icon link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- header section start here -->
    <header class="header">
        <div class="logoContent">
            <a href="#" class="logo"><img src="images/logop.png" alt=""></a>
            <h1 class="logoName">Shoes Store</h1>
        </div>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#product">Produk</a>
            <a href="#contact">Kontak</a>
            <a href="profile.php">Profil</a>
        </nav>

        <div class="icon">
            <i class="fas fa-search" id="search"></i>
            <i class="fas fa-bars" id="menu-bar"></i>
            <a href="cart.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count" class="badge">
                    <?php 
                    // Ensure 'cart' is set in the session and is an array
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        echo count($_SESSION['cart']);
                    } else {
                        echo 0; // Default to 0 if 'cart' is not set or is not an array
                    }
            ?>
        </span>
    </a>
        </div>

        <div class="search" style="display: none;">
            <input type="search" id="searchInput" placeholder="Search products...">
        </div>
    </header>
    <!-- header section end here -->

    <!-- home section start here -->
    <section class="home" id="home">
        <div class="homeContent">
        <?php
            // Display welcome message
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo "<p>Welcome, $username! Enjoy shopping with us.<p>";
            } else {
                echo "<p>Welcome, Guest! Please <a href='login.php'>login</a> to start shopping.<p>";
            }
            ?>
            <h2>Sepatu Keren untuk Semua Orang</h2>
            <p>Jelajahi koleksi eksklusif sepatu kami yang nyaman dan penuh gaya, dibuat dengan hati-hati dan bahan berkualitas. Beli sepasang sepatu yang sempurna hari ini!
            </p>
        </div>
    </section>

    <!-- home section end here -->

    <!-- product section start here -->
    <section class="product" id="product">
        <div class="heading">
            <h2>Sepatu Eksklusif Kami</h2>
        </div>
        <div class="product-row">
    <?php 
    $products = [
        ['name' => 'Red Leather Sneakers', 'price' => 500000],
        ['name' => 'Black High Heels', 'price' => 700000],
        ['name' => 'Sporty Running Shoes', 'price' => 600000],
        ['name' => 'Brown Leather Boots', 'price' => 800000]
    ];

    foreach ($products as $index => $product) {
        // Debugging output: Check if image path is being generated correctly
        $imagePath = 'images/' . ($index + 1) . '.jpg';
        if (!file_exists($imagePath)) {
            echo "<p>Warning: Image $imagePath does not exist!</p>"; // Check if the image exists
        }

        echo "
            <div class='box'>
                <div class='img'>
                    <img src='$imagePath' alt='{$product['name']}'>
                </div>
                <div class='product-content'>
                    <h3>{$product['name']}</h3>
                    <p>Sepatu yang nyaman untuk setiap kesempatan. Kualitas dan gaya yang tinggi!</p>
                    <p class='price'><strong>Rp" . number_format($product['price'], 0, ',', '.') . "/pcs</strong></p>
                    <div class='orderNow'>
                        <a href='index.php?add=$index' class='btn btn-primary'>
                            <i class='fas fa-shopping-cart'></i> Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        ";
    }
    ?>
</div>

    </section>
    <!-- product section end here -->

    <!-- footer section start here -->
    <footer class="footer" id="contact">
        <div class="box-container">
            <div class="mainBox">
                <div class="content">
                    <a href="#"><img src="images/logop.png" alt=""></a>
                    <h1 class="logoName"></h1>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="box">
                <h3>Informasi Kontak</h3>
                <a href="#"> <i class="fas fa-phone"></i>+62 813-1028-7270</a>
                <a href="#"> <i class="fas fa-envelope"></i> nabielpramudyafc@gmail.com</a>
            </div>
        </div>
        <div class="credit">
            created by <span>Nabiel Pramudya Mahendra</span> | all rights reserved!
        </div>
    </footer>

    <!-- swiper js link -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- custom js file -->
    <script src="index.js"></script>

    <!-- swiper js link -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- custom js file -->
    <script src="index.js"></script>

    <script>
        // Activate the search functionality
        const searchIcon = document.getElementById("search");
        const searchInput = document.getElementById("searchInput");
        const productList = document.getElementById("productList");

        searchIcon.addEventListener("click", function() {
            const searchContainer = document.querySelector(".search");
            searchContainer.style.display = searchContainer.style.display === "none" ? "block" : "none";
            searchInput.focus();
        });

        searchInput.addEventListener("input", function() {
            const query = searchInput.value.toLowerCase();
            const products = document.querySelectorAll(".box");

            products.forEach(function(product) {
                const productName = product.querySelector("h3").textContent.toLowerCase();
                if (productName.includes(query)) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        });
    </script>

</body>
</html>
