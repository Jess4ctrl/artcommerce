<?php

@include 'config.php'; 

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
    header('location:cart.php');
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart`");
    header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container my-5">
    <section class="shopping-cart">
        <h2 class="text-center mb-4">Shopping Cart</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                $grand_total = 0;

                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                        $grand_total += $sub_total;
                ?>
                <tr>
                    <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $fetch_cart['name']; ?></td>
                    <td>PHP <?php echo number_format($fetch_cart['price'], 2); ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                            <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>" class="form-control">
                            <button class="btn btn-primary mt-2" type="submit" name="update_update_btn">Update</button>
                        </form>
                    </td>
                    <td>PHP <?php echo number_format($sub_total, 2); ?></td>
                    <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?');" class="btn btn-danger">Remove</a></td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Your cart is empty</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                    <td>PHP <?php echo number_format($grand_total, 2); ?></td>
                    <td>
                        <a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="btn btn-danger">Delete All</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="text-center">
            <a href="checkout.php" class="btn btn-success <?= ($grand_total > 0) ? '' : 'disabled'; ?>">Checkout</a>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
