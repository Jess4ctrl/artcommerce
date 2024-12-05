<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <?php
        @include 'config.php';

        if (isset($_POST['register'])) {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirmpassword']);

            if ($password !== $confirm_password) {
                echo '<div class="alert alert-danger" role="alert">Passwords do not match.</div>';
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                
                if (mysqli_query($conn, $query)) {
                    echo '<div class="alert alert-success" role="alert">Registration successful!</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Registration failed: ' . mysqli_error($conn) . '</div>';
                }
            }
        }
        ?>

        <h2 class="text-center mb-4">Registration</h2>

        
        <form action="signup.php" method="post" id="RegistrationForm" class="border p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="username" class="form-label">Full Name</label>
                <input type="text" id="username" name="username" placeholder="Type your full name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="confirmpassword" class="form-label">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required>
            </div>
            
            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
            
            <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
