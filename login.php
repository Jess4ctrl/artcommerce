<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container my-5">
        <?php
        
        @include 'config.php';

        
        if (isset($_POST['login'])) {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                if (password_verify($password, $user['password'])) {
                    echo '<div class="alert alert-success" role="alert">Login successful!</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Invalid username or password.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Invalid username or password.</div>';
            }
        }
        ?>

        <h2 class="text-center mb-4">Login</h2>

        <form action="login.php" method="POST" id="login-form" class="border p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Continue</button>
            <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign-up</a></p>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
