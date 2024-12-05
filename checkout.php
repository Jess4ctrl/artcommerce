<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chechout</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container my-5">
        <div class="shipping-form border p-4 rounded shadow-sm">
            <h3 class="text-center mb-4">Shipping Address</h3>
            <form id="shipping-form">
                <div class="mb-3">
                    <label for="shipping-name" class="form-label">Full Name</label>
                    <input type="text" id="shipping-name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="shipping-address" class="form-label">Address</label>
                    <input type="text" id="shipping-address" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="shipping-city" class="form-label">City</label>
                    <input type="text" id="shipping-city" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="shipping-zip" class="form-label">Zip Code</label>
                    <input type="text" id="shipping-zip" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="shipping-country" class="form-label">Country</label>
                    <input type="text" id="shipping-country" class="form-control" required>
                </div>

                <h3 class="text-center mt-4">Payment Information</h3>
                <div class="mb-3">
                    <label for="card-name" class="form-label">Name on Card</label>
                    <input type="text" id="card-name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="card-number" class="form-label">Card Number</label>
                    <input type="text" id="card-number" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="expiry-date" class="form-label">Expiry Date (MM/YY)</label>
                    <input type="text" id="expiry-date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" id="cvv" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100" type="submit">Place Order</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
