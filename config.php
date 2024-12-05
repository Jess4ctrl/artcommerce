<?php

$conn = mysqli_connect('localhost','root','','user_registration') or die('connection failed');

if (!$conn) {
    echo '<div class="alert alert-danger" role="alert">Database connection failed: ' . mysqli_connect_error() . '</div>';
}

?>