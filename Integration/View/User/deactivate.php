<?php
// deactivate.php

require __DIR__ . '/../../config.php';


$conn = Config::getConnexion();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    // Update the 'etat' column to 'desactivé'
    $query = $conn->prepare("UPDATE tblogin SET etat = 'Desactivé' WHERE id = :id");
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    
    if ($query->execute()) {
        // Redirect back to the user list after deactivation
        header("Location: index.php");
    } else {
        echo "Error deactivating user.";
    }
}
?>
