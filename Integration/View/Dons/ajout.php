<?php
 // Include the configuration file
 require __DIR__ . '/../../config.php';

// Get the PDO instance
$conn = Config::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Utilize distinct variable names for each field
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $numero = htmlspecialchars($_POST['numero']);
    $societe = htmlspecialchars($_POST['societe']);
    $matricule = htmlspecialchars($_POST['matricule']);
    $pays = htmlspecialchars($_POST['pays']);
    $region = htmlspecialchars($_POST['region']);
    $postcode = htmlspecialchars($_POST['Postcode']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $montant = htmlspecialchars($_POST['montant']); // Add this line
    $quantite = htmlspecialchars($_POST['quantite']); // Add this line

    // ... Validation code here ...

    // If validation is successful, proceed to add data to the database

    // Prepare and execute the SQL query for the 'categories' table
    $stmtCategories = $conn->prepare("INSERT INTO categories (nom_categorie, montant, quantite) VALUES (:nom_categorie, :montant, :quantite)");
    $stmtCategories->bindParam(':nom_categorie', $categorie);
    $stmtCategories->bindParam(':montant', $montant);
    $stmtCategories->bindParam(':quantite', $quantite);
    $stmtCategories->execute();
    $lastInsertedCategoryId = $conn->lastInsertId();

    // Prepare and execute the SQL query for the 'mac' table
    $stmtMac = $conn->prepare("INSERT INTO mac (nom, email, numero, societe, matricule, pays, region, Postcode, categorie_id) VALUES (:nom, :email, :numero, :societe, :matricule, :pays, :region, :postcode, :categorie_id)");
    $stmtMac->bindParam(':nom', $nom);
    $stmtMac->bindParam(':email', $email);
    $stmtMac->bindParam(':numero', $numero);
    $stmtMac->bindParam(':societe', $societe);
    $stmtMac->bindParam(':matricule', $matricule);
    $stmtMac->bindParam(':pays', $pays);
    $stmtMac->bindParam(':region', $region);
    $stmtMac->bindParam(':postcode', $postcode);
    $stmtMac->bindParam(':categorie_id', $lastInsertedCategoryId);
    $stmtMac->execute();

    header('Location: formulaire.php');
    $validationSuccessful = true; // You need to replace this with your actual validation logic

    if ($validationSuccessful) {
        header("Location: confirmation.php");
        exit; // Make sure to exit to stop further execution
    }
}

?>
