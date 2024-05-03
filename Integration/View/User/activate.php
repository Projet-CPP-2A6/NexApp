<?php
 require __DIR__ . '/../../config.php';
 $conn = Config::getConnexion();

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Update the 'etat' column to "Activé" for the specified user ID
    $query = $conn->prepare("UPDATE tblogin SET etat = 'Activé' WHERE id = :id");
    $query->bindParam(':id', $userId, PDO::PARAM_INT);

    // Execute the query
    if ($query->execute()) {
        // Redirect to the user list page after successful activation
        header("location: index.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating user state.";
    }
} else {
    // Handle the case where the 'id' parameter is not set
    echo "Invalid user ID.";
}
?>






require_once "UserController.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $uc = new UserController();
    $uc->activate($userId);
    header("location: index.php");

} else {
        // Handle the case where the update fails
        echo "Error updating user state.";
    }
} else {
    // Handle the case where the 'id' parameter is not set
    echo "Invalid user ID.";
}
?>


