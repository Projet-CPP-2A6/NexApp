<?php
session_start(); // Start the session
require __DIR__ . '/../../config.php';
$conn = Config::getConnexion();

// Check if type_id is set in the URL
if (isset($_GET['id'])) {
    $type_id = $_GET['id'];

    // Delete the type from the database
    $delete_type = $conn->prepare("DELETE FROM `types` WHERE id = ?");
    $delete_type->execute([$type_id]);

    $_SESSION['success_msg'] = 'Product type deleted!';
}

// Redirect to indexType.php or another appropriate page
header('Location: indexType.php');
exit();
?>
