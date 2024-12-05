<?php
@include 'config.php';

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    // Prevent duplicate entries in the cart
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");

    if (mysqli_num_rows($select_cart) > 0) {
        $message[] = 'Product already added to cart';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
        $message[] = 'Product added to cart successfully';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Gallery</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    
    <?php if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">'
               . '<span>' . $msg . '</span>'
               . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
               . '</div>';
        }
    } ?>

    <!-- Products Gallery -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
