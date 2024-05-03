<?php
 require __DIR__ . '/../../config.php';

 $conn = Config::getConnexion();
    
    // Buat object user
    $user = new User($conn);
    // Jika belum login
    if(!$user->isLoggedIn()){
        header("location: login.php"); //Redirect ke halaman login
    }
    // Ambil data user saat ini
    $currentUser = $user->getUser();
    
    //===============
    if(isset($_GET["id"])){
        // Prepared statement untuk menghapus data
        $query = $db->prepare("DELETE FROM `tblogin` WHERE id=:id");
        $query->bindParam(":id", $_GET["id"]);
        // Jalankan Perintah SQL
        $query->execute();
        // Alihkan ke index.php
        header("location: index.php");
    }
?>
