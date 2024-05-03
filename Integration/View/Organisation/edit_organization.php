<?php
 require __DIR__ . '/../../config.php';
 $conn = Config::getConnexion();

// Récupérer l'ID à partir de l'URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    // Gérer le cas où l'ID n'est pas spécifié
    echo "ID non spécifié.";
    exit();
}

// Récupérer les données de l'organisation depuis la base de données
$stmt = $conn->prepare("SELECT * FROM organisations WHERE ID_Organisation = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$organizationData = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si des données ont été trouvées
if (!$organizationData) {
    echo "Aucune organisation trouvée pour l'ID donné.";
    exit();
}

// Traitement des données du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newNomOrg = htmlspecialchars($_POST['nomAssociation']);
    $newDescriptionOrg = htmlspecialchars($_POST['descriptionAssociation']);

    // Gestion de la mise à jour de l'image
    if ($_FILES["imageAssociation"]["name"] !== "") {
        // Générez un nom de fichier unique pour éviter les remplacements
        $targetFileName = uniqid() . '_' . basename($_FILES["imageAssociation"]["name"]);
        $targetDir = "upload/"; // Change this to your desired directory
        $targetFile = $targetDir . $targetFileName;

        // Déplacez le fichier téléchargé vers le répertoire cible
        move_uploaded_file($_FILES["imageAssociation"]["tmp_name"], $targetFile);

        // Mettez à jour le chemin de l'image dans la base de données
        $updateImageStmt = $conn->prepare("UPDATE organisations SET Image_Path = :newImagePath WHERE ID_Organisation = :id");
        $updateImageStmt->bindParam(':newImagePath', $targetFile);
        $updateImageStmt->bindParam(':id', $id);
        $updateImageStmt->execute();
    }

    // Mettez à jour les autres données dans la base de données
    $updateStmt = $conn->prepare("UPDATE organisations SET Nom_Org = :newNomOrg, Description = :newDescriptionOrg WHERE ID_Organisation = :id");
    $updateStmt->bindParam(':newNomOrg', $newNomOrg);
    $updateStmt->bindParam(':newDescriptionOrg', $newDescriptionOrg);
    $updateStmt->bindParam(':id', $id);

    if ($updateStmt->execute()) {
        // Rediriger vers la page du profil après la modification
        header("Location: profil.php?id={$id}");
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'organisation.";
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Organismes</title>
        <link rel="stylesheet" href="profil.css">
        <link rel="stylesheet" href="../General/Accueil/accueil.css">
        <link rel="stylesheet" href="../General/Actions/actions.css">
        <link rel="stylesheet" href="../General/User/connexion.css">
    </head>
    <body>

    

        <div class="logo"> <img src="../Sources/LOGO.png" alt="Logo"> </div>
    <div class="container">
        <h1>Modifier l'Organisation</h1>

        <div class="container">
    <h1>Modifier l'Organisation</h1>

    <form action="edit_organization.php?id=<?php echo $id; ?>" method="post" class="form" enctype="multipart/form-data">
        <label for="nomAssociation">Nom :</label>
        <input type="text" name="nomAssociation" id="nomAssociation" value="<?php echo $organizationData['Nom_Org']; ?>" >

        <label for="descriptionAssociation">Description :</label>
        <textarea name="descriptionAssociation" id="descriptionAssociation" rows="4" cols="50" ><?php echo $organizationData['Description']; ?></textarea>

        <label for="imageAssociation">Changer l'image :</label>
        <input type="file" name="imageAssociation" id="imageAssociation">

        <input type="submit" value="Enregistrer les modifications">
    </form>
</div>
    </div>

    </body>
    </html>
    <style>
        
    .container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container h1 {
        text-align: center;
        color: #333;
    }

    .form label {
        display: block;
        margin: 10px 0 5px;
        color: #555;
    }

    .form input[type="text"],
    .form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form textarea {
        resize: vertical;
    }

    .form input[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .form input[type="submit"]:hover {
        background-color: #45a049;
    }
    </style>