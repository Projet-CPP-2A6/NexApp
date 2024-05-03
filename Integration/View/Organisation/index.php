<?php
 require __DIR__ . '/../../config.php';
 $conn = Config::getConnexion();


$notificationMessage = ''; // Initialize the variable to store the notification message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the form type
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    if ($type === 'association') {
        $Nom_Org = htmlspecialchars($_POST['nomAssociation']);
        $Description = htmlspecialchars($_POST['descriptionAssociation']);

        // Handle image upload
        $targetDir = "upload/"; // Change this to your desired directory
        $targetFile = $targetDir . basename($_FILES["imageAssociation"]["name"]);

        if (isset($_FILES["imageAssociation"])) {
            move_uploaded_file($_FILES["imageAssociation"]["tmp_name"], $targetFile);
        }

        $stmt = $conn->prepare("INSERT INTO organisations (Nom_Org, Description, Image_Path) VALUES (:Nom_Org, :Description, :Image_Path)");
        $stmt->bindParam(':Nom_Org', $Nom_Org);
        $stmt->bindParam(':Description', $Description);
        $stmt->bindParam(':Image_Path', $targetFile);
        $stmt->execute();
        $lastInsertedId = $conn->lastInsertId(); // Get the newly inserted ID
        $notificationMessage = 'Organisation added successfully';
    } elseif ($type === 'societe') {
        $Nom_Soc = htmlspecialchars($_POST['nom']);
        $Desc_Soc = htmlspecialchars($_POST['description']);
        $matricule = htmlspecialchars($_POST['matricule']);

        $stmt = $conn->prepare("INSERT INTO société (Nom_Soc, Desc_Soc, matricule, organisation_aff) VALUES (:Nom_Soc, :Desc_soc, :matricule, :organisation_aff)");
        $stmt->bindParam(':Nom_Soc', $Nom_Soc);
        $stmt->bindParam(':Desc_soc', $Desc_Soc);
        $stmt->bindParam(':matricule', $matricule);

        // Ajoutez la liaison pour l'association bénéficiaire
        $associationBeneficiaire = htmlspecialchars($_POST['associationBeneficiaire']);
        $stmt->bindParam(':organisation_aff', $associationBeneficiaire);

        $stmt->execute();
        $lastInsertedId = $conn->lastInsertId(); // Get the newly inserted ID
        $notificationMessage = 'Entreprise added successfully!';
    }
}
if (!empty($notificationMessage)) {
    echo '
    <div class="notification-icon" id="notification-icon" onclick="redirectToProfile()">
        <img src="../Sources/icon_not.png" alt="Notification Icon">
    </div>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organismes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../General/Accueil/accueil.css">
    <link rel="stylesheet" href="../General/Actions/actions.css">
    <link rel="stylesheet" href="/Integration/View/User/connexion.css">
</head>
<body>
<div class="notification-icon" id="notification-icon" onclick="redirectToProfile()">
    <img src="../Sources/icon_not.png" alt="Notification Icon">
</div>
<div class="menu">
        <a href="../General/Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Product/View_Products.php">Notre Boutique</a>
        <a href="../General/Actions/actions.php">Nos actions</a>

    </div>
    <div class="logo"> <img src="../Sources/LOGO.png" alt="Logo"> </div>

    <div class="form-container" id="association-container">
    <form action="" method="post" class="form" enctype="multipart/form-data">
        <h2>Je suis une association</h2>
        <label for="nomAssociation">Nom :</label>
        <input type="text" name="nomAssociation" id="nomAssociation">
        <label for="descriptionAssociation">Description :</label>
        <textarea name="descriptionAssociation" id="descriptionAssociation" rows="4" cols="50"></textarea>
        <label for="imageAssociation">Image :</label>
        <input type="file" name="imageAssociation" id="imageAssociation">
        <input type="hidden" name="type" value="association">
        <input type="submit" value="Ajouter organisation">
        <div id="notification"></div>
    </form>
</div>

<div class="form-container" id="entreprise-container">
    <form action="" method="post" class="form" enctype="multipart/form-data">
        <h2>Je suis une société</h2>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom">
        <label for="matricule">Matricule fiscale :</label>
        <input type="text" name="matricule" id="matricule">
        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="4" cols="50"></textarea>
        <label for="associationBeneficiaire">Association bénéficiaire :</label>
<select name="associationBeneficiaire" id="associationBeneficiaire">
    <option value="">Sélectionnez une organisation</option>
    <?php
    // Récupérez les organisations depuis la base de données
    $stmtOrg = $conn->prepare("SELECT ID_Organisation, Nom_Org FROM organisations");
    $stmtOrg->execute();
    $organisations = $stmtOrg->fetchAll(PDO::FETCH_ASSOC);

    // Affichez chaque organisation comme une option dans le menu déroulant
    foreach ($organisations as $organisation) {
        echo '<option value="' . $organisation['ID_Organisation'] . '">' . $organisation['Nom_Org'] . '</option>';
    }
    ?>
</select>
        <label for="imageSociete">Image :</label>
        <input type="file" name="imageSociete" id="imageSociete">
        <input type="hidden" name="type" value="societe">
        <input type="submit" value="Ajouter entreprise">
    </form>
</div>
    <div id="notification-container" class="notification-container"></div>
    <script>
    function showNotification(message, entityId, entityType) {
        var notificationContainer = document.getElementById('notification-container');
        notificationContainer.innerHTML = message;
        notificationContainer.style.display = 'block';

        // Vérifier le type d'entité et construire le lien en conséquence
        var entityLink = '';
        if (entityType === 'association') {
            entityLink = 'profil.php?id=' + entityId;
        } else if (entityType === 'societe') {
            entityLink = 'profil_soc.php?id=' + entityId;
        }

        // Ajouter un lien vers la page profil avec l'ID
        var linkElement = document.createElement('a');
        linkElement.href = entityLink;
        linkElement.textContent = ' Consulter votre profil';
        notificationContainer.appendChild(linkElement);

        setTimeout(function() {
            notificationContainer.style.display = 'none';
        }, 5000); // La notification disparaîtra après 3 secondes
    }

    // Ajoutez ceci pour gérer la notification côté client
    var successMessage = "<?php echo $notificationMessage; ?>";
    var entityId = "<?php echo $lastInsertedId; ?>";
    var entityType = "<?php echo $type; ?>"; // Ajoutez ceci pour récupérer le type

    if (successMessage) {
        showNotification(successMessage, entityId, entityType);
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to validate the association form
        function validateAssociationForm() {
            var nomAssociationField = document.getElementById('nomAssociation');
            var descriptionAssociationField = document.getElementById('descriptionAssociation');

            if (nomAssociationField.value.trim() === '') {
                alert('Veuillez saisir le nom de l\'association.');
                return false;
            }

            if (descriptionAssociationField.value.trim() === '') {
                alert('Veuillez saisir la description de l\'association.');
                return false;
            }

            return true;
        }

        // Function to validate the entreprise form
        function validateEntrepriseForm() {
            var nomField = document.getElementById('nom');
            var matriculeField = document.getElementById('matricule');
            var descriptionField = document.getElementById('description');

            if (nomField.value.trim() === '') {
                alert('Veuillez saisir le nom de la société.');
                return false;
            }

            if (matriculeField.value.trim() === '') {
                alert('Veuillez saisir le matricule fiscale de la société.');
                return false;
            }

            if (descriptionField.value.trim() === '') {
                alert('Veuillez saisir la description de la société.');
                return false;
            }

            return true;
        }

        // Event listener for the association form
        var associationForm = document.querySelector('#association-container .form');
        associationForm.addEventListener('submit', function (event) {
            if (!validateAssociationForm()) {
                event.preventDefault(); // Prevent form submission
            }
        });

        // Event listener for the entreprise form
        var entrepriseForm = document.querySelector('#entreprise-container .form');
        entrepriseForm.addEventListener('submit', function (event) {
            if (!validateEntrepriseForm()) {
                event.preventDefault(); // Prevent form submission
            }
        });
    });


    function redirectToProfile() {
        var entityId = "<?php echo $lastInsertedId; ?>";
        var entityType = "<?php echo $type; ?>";

        if (entityType === 'association') {
            window.location.href = 'profil.php?id=' + entityId;
        } else if (entityType === 'societe') {
            window.location.href = 'profil_soc.php?id=' + entityId;
        }
    }
</script>

<style>
    .notification-icon {
        position: fixed;
        top: 20px;
        right: 20px;
        cursor: pointer;
    }

    .notification-icon img {
        width: 60px; /* Ajustez la taille de l'icône selon vos besoins */
        height: 60px;
        border-radius: 50%; /* Rend l'icône circulaire, ajustez si nécessaire */
    }
</style>
</body>
</html>
