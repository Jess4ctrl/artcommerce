<?php

@include 'config.php';

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");

    if (mysqli_num_rows($select_cart) > 0) {
        $message[] = 'Product already added to cart';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
        $message[] = 'Product added to cart successfully';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php if (isset($message)) : ?>
    <?php foreach ($message as $msg) : ?>
        <div class="message">
            <span><?= $msg; ?></span>
            <i class="fas fa-times" onclick="this.parentElement.style.display = 'none';"></i>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include 'navbar.php'; ?>
<main id="home">
    <section class="hero-container">
        <div class="hero">
            <h1>Discover Unique Art for Your Space</h1>
            <p>Discover a world of breathtaking paintings, crafted by passionate artists. From modern masterpieces<br> to timeless classics, our collection brings beauty, inspiration, and elegance to any room.</p>
            <a href="products.php" class="btn btn-outline-light">Shop Now</a>
        </div>
    </section>

    <section class="gallery my-5" id="gallery">
        <div class="container">
            <h2 class="text-center mb-4">Products</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                
                $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                ?>
                <div class="col">
                    <form action="" method="post">
                        <div class="card h-100">
                            <img src="uploaded_img/<?php echo htmlspecialchars($fetch_product['image']); ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body text-center">
                                
                                <div class="rating" data-title="<?php echo htmlspecialchars($fetch_product['name']); ?>">
                                    <span class="star" data-value="1">&#9733;</span>
                                    <span class="star" data-value="2">&#9733;</span>
                                    <span class="star" data-value="3">&#9733;</span>
                                    <span class="star" data-value="4">&#9733;</span>
                                    <span class="star" data-value="5">&#9733;</span>
                                </div>
                                <h3 class="card-title"><?php echo htmlspecialchars($fetch_product['name']); ?></h3>
                                <p>PHP <?php echo number_format($fetch_product['price'], 2); ?></p>
                                <h5 class="text-muted">by: <?php echo htmlspecialchars($fetch_product['artist']); ?></h5>

                                
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_product['name']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($fetch_product['price']); ?>">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_product['image']); ?>">
                                
                                
                                <input type="submit" class="btn btn-primary mt-3" value="Add to Cart" name="add_to_cart">
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>No products available.</p></div>';
                }
                ?>
            </div>
        </div>
    </section>

    <section id="about" class="container my-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4">About Us</h2>
            <p>
                Welcome to <b>Art Commerce</b>, where art meets opportunity. We are passionate about bringing diverse,
                exceptional artwork from talented artists around the world to art enthusiasts and collectors.
                <br><br>
                Our platform is designed to showcase unique pieces, giving artists the chance to reach a wider
                audience while making it easy for buyers to discover and own captivating art.
                <br><br>
                At <b>Art Commerce</b>, we bridge the gap between creators and collectors by purchasing artwork directly
                from artists and reselling it on our curated website. Our mission is to celebrate creativity,
                provide artists with the support they deserve, and create an accessible space for art lovers
                to find their next treasured piece.
            </p>
        </div>
    </div>
</section>

</main>

<footer class="bg-light mt-5">
        <div class="container text-center">
            <section class="mb-4">
                <h5>Contact Us</h5>
                <p>
                    363 Casal St, Quiapo, Manila, 1001 Metro Manila <br>
                    +1 (555) 123-4567 <br>
                    artcommerce@gmail.com
                </p>
            </section>

        </div>

        <div class="text-center p-3 bg-dark text-white">
            © 2023 Art Commerce. All rights reserved.
        </div>
    </footer>
</body>
</html>
