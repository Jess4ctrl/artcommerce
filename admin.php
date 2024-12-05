<?php

@include 'config.php'; // Remove the @ if error suppression is not necessary

session_start();

if (isset($_POST['add_product'])) {
   $p_name = $_POST['p_name'];
   $p_artist = $_POST['p_artist'];
   $p_price = $_POST['p_price'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/' . $p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, artist, price, image) VALUES('$p_name', '$p_artist', '$p_price', '$p_image')");

   if ($insert_query) {
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product added successfully';
   } else {
      $message[] = 'could not add the product';
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id");
   if ($delete_query) {
      header('location:admin.php');
   } else {
      header('location:admin.php');
   }
}

if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_artist = $_POST['update_p_artist'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/' . $update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', artist ='$update_p_artist', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");

   if ($update_query) {
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      header('location:admin.php');
   } else {
      header('location:admin.php');
   }
}

if (isset($_GET['delete_order'])) {
   $order_id = $_GET['delete_order'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$order_id'");
   header('location:admin.php');
}

if (isset($_GET['clear_orders'])) {
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:admin.php');
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
   session_destroy();
   header('Location: admin_login.php');
   exit();
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
   
    
</head>
<body>



<?php include 'navbar.php'; ?>
<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">'
             . '<span>' . $message . '</span>'
             . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
             . '</div>';
    }
}
?>
<div class="container my-5">

    <section class="mb-5">
        <form method="post" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
            <h3 class="text-center">Add a New Product</h3>
            <div class="mb-3">
                <input type="text" name="p_name" placeholder="Product Name" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="text" name="p_artist" placeholder="Product Artist" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="number" name="p_price" min="0" placeholder="Price" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="form-control" required>
            </div>
            <button type="submit" value="add the product" name="add_product" class="btn btn-primary">Add the Product</button>
        </form>
    </section>

    <section>
        <h3 class="text-center mb-3">Products List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Artist</th>
                    <th>Product Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                if (mysqli_num_rows($select_products) > 0) {
                    while ($row = mysqli_fetch_assoc($select_products)) {
                ?>
                <tr>
                <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['artist']; ?></td>
                    <td>Php <?php echo $row['price']; ?></td>
                    <td>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');">
                             Delete
                        </a>
                        <a href="admin.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">
                             Update
                        </a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No Product Added</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section>
        <?php
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
            if (mysqli_num_rows($edit_query) > 0) {
                while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
        ?>
        <form action="" method="post" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
            <h3 class="text-center">Update Product</h3>
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
            <div class="mb-3">
                <input type="text" class="form-control" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" required name="update_p_artist" value="<?php echo $fetch_edit['artist']; ?>">
            </div>
            <div class="mb-3">
                <input type="number" min="0" class="form-control" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
            </div>
            <div class="mb-3">
                <input type="file" class="form-control" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
            </div>
            <button type="submit" value="update the product" name="update_product" class="btn btn-success">Update the Product</button>
            <button type="reset" value="cancel" id="close-edit" class="btn btn-secondary">Cancel</button>
        </form>
        <?php
                }
            }
         }
        ?>
    </section>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Manage Orders</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $orders = mysqli_query($conn, "SELECT * FROM `cart`");
            if (mysqli_num_rows($orders) > 0) {
                while ($order = mysqli_fetch_assoc($orders)) {
                    $total = $order['price'] * $order['quantity'];
                    ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['name']; ?></td>
                        <td>PHP <?php echo number_format($order['price'], 2); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td>PHP <?php echo number_format($total, 2); ?></td>
                        <td>
                            <a href="admin.php?delete_order=<?php echo $order['id']; ?>" onclick="return confirm('Delete this order?');" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="admin.php?clear_orders" onclick="return confirm('Are you sure you want to clear all orders?');" class="btn btn-warning">Clear All Orders</a>
    </div>
</div>


<div class="container text-center mt-4">
    <a href="?action=logout" class="btn btn-danger">Logout</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
