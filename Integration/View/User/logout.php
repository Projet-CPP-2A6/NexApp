<?php
    // Lampirkan db dan User
    require __DIR__ . '/../../config.php';
    require_once "User.php";
    $conn = Config::getConnexion();

    // Buat object user
    $user = new User($conn);

    // Logout! hapus session user
    $user->logout();

    // Redirect ke login
    header('location: login.php');
 ?>
