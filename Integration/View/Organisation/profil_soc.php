<?php
require __DIR__ . '/../../config.php';
$conn = Config::getConnexion();

// Initialize variables
$nomSoc = $descriptionSoc = $matricule = $nomAssociationBeneficiaire = "";

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les données associées à l'ID depuis la base de données
    $stmt = $conn->prepare("SELECT s.*, o.Nom_Org AS Nom_Association FROM société s LEFT JOIN organisations o ON s.organisation_aff = o.ID_Organisation WHERE s.ID_Soc = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si des données ont été trouvées
    if ($result) {
        $nomSoc = $result['Nom_Soc'];
        $descriptionSoc = $result['Desc_Soc'];
        $matricule = $result['matricule'];
        $nomAssociationBeneficiaire = $result['Nom_Association'];
    } else {
        // Gérer le cas où aucune donnée n'est trouvée pour l'ID donné
        echo "Aucune société trouvée pour l'ID donné.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Société</title>
    <link rel="stylesheet" href="profil.css">
    <link rel="stylesheet" href="../General/Accueil/accueil.css">
    <link rel="stylesheet" href="../General/Actions/actions.css">
    <link rel="stylesheet" href="/Integration/View/User/connexion.css">
</head>

<body>

    <div class="menu">
        <a href="../General/Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Product/View_Products.php">Notre Boutique</a>
        <a href="../General/Actions/actions.php">Nos actions</a>
    </div>
    <div class="logo"> <img src="../Sources/LOGO.png" alt="Logo"> </div>

    <div class="container">
        <!-- Affichez les données récupérées ici -->
        <h1>Profil de la Société</h1>
        <p><strong>Nom :</strong> <?= $nomSoc; ?></p>
        <p><strong>Description :</strong> <?= $descriptionSoc; ?></p>
        <p><strong>Matricule :</strong> <?= $matricule; ?></p>
        <p><strong>Association bénéficiaire :</strong> <?= $nomAssociationBeneficiaire; ?></p>
        <div class="actions">
            <button id="editBtn" data-soc-id="<?= $id; ?>">Modifier</button>
            <button id="deleteBtn" data-soc-id="<?= $id; ?>">Supprimer</button>
        </div>
    </div>

    <!-- Votre script JavaScript -->
    <script>
        document.getElementById('editBtn').addEventListener('click', function() {
            // Récupérer l'ID de la société à modifier
            var societeId = this.getAttribute('data-soc-id');

            // Rediriger vers la page de modification avec l'ID en paramètre
            window.location.href = 'edit_societe.php?id=' + societeId;
        });

        document.getElementById('deleteBtn').addEventListener('click', function() {
            // Récupérer l'ID de la société à supprimer
            var societeId = this.getAttribute('data-soc-id');

            // Demander confirmation avant de supprimer
            var confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer cette société ?");
            if (confirmDelete) {
                // Rediriger vers la page de suppression avec l'ID en paramètre
                window.location.href = 'delete_societe.php?id=' + societeId;
            }
        });
    </script>

    <style>
        .actions {
            text-align: center;
            margin-top: 20px;
            display: flex;
            /* Utiliser Flexbox pour centrer les boutons */
            justify-content: center;
        }

        .actions button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .actions button:hover {
            background-color: #45a049;
        }

        /* Style spécifique pour le bouton "Supprimer" */
        .actions #deleteBtn {
            background-color: #f44336;
        }

        .actions #deleteBtn:hover {
            background-color: #d32f2f;
        }
    </style>
</body>

</html>
