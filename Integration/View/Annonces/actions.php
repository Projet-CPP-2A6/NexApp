<?php
 require __DIR__ . '/../../config.php';
 require_once __DIR__ . '/../../Controller/AnnoncesController.php';
 require_once __DIR__ . '/../../Controller/AnnoncesAdminController.php';

$conn = Config::getConnexion();
$annonesController = new AnnoncesController($conn);
$annonesController->handleCRUDOperations();
$rows = $annonesController->fetchAllAnnouncements();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>
    <link rel="stylesheet" href="../General/Accueil/accueil.css">
    <link rel="stylesheet" href="../General/Actions/actions.css">
    <style>
    .logo {
        padding: 5px;
    }

    .menu {
        background-color: #dedede#;
        overflow: hidden;
    }

    .menu a {
        float: left;
        display: block;
        color: #000000;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .menu a:hover {
        background-color: #d7b20b;
        color: black;
    }

    .center-container {
        text-align: center;
        margin-top: 220px;
    }

    table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #d7b20b;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #ffffff;
    }

    .edit-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }

    .delete-button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }

    .comments-button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }

    /* Ajouter le style pour séparer le titre et la description */
    .rectangle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #d7b20b;
        padding: 10px;
        margin-bottom: 20px;
    }

    .texte {
        flex: 1;
        padding: 0 10px;
    }

    .texte h3 {
        margin-bottom: 10px;
    }

    .rectangle_don {
        text-align: center;
        width: 200px; 
    }

    .logo1 {
        margin-right: 100px;
        /* Ajuster la marge à droite pour séparer l'image du texte */
    }

    /* Ajouter le style pour le bouton "Faire un don" */
    .rectangle_don a {
        background-color: #d7b20b;
        color: white;
        text-decoration: none;
        padding: 10px 30px;
        border-radius: 4px;
    }

    .rectangle_don a:hover {
        background-color: #c69c08;
    }
    </style>

</head>

    <!-- Add any additional stylesheets if needed -->
    <body>    
    <div class="menu">
        <a href="../General/Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Product/View_Products.php">Notre Boutique</a>
        <a href="../General/Actions/actions.php">Nos actions</a>

    </div>



    <div class="sidebar">
        <a href="#">
            <img src="../Sources/icons/facebook1.png" alt="facebook">
        </a>
        <a href="#">
            <img src="../Sources/icons/instagramm.png" alt="Instagram">
        </a>
        <a href="#">
            <img src="../Sources/icons/linkedin.png" alt="linkedin">
        </a>
        <a href="#">
            <img src="../Sources/icons/whatsapp.png" alt="whatsapp">
        </a>
    </div>
    <div class="rectanglecover">
        <h1>Actions en cours</h1>
    </div>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>

    <div class="center-container">
        <?php foreach ($rows as $row) : ?>
        <div class="rectangle">
            <div class="logo1">
                <img src="../Sources/crt.png" alt="Logo">
            </div>
            <div class="texte">
                <h3><?= $row['titre'] ?></h3>
                <p><?= $row['description'] ?></p>
            </div>
            <div class="rectangle_don">
                <a href="/Integration/View/User/Login.php">Faire un don</a>
            </div>
            <div class="edit-delete-buttons">
                <a href="edit_announce.php?edit=<?= $row['id_annonces'] ?>" class="edit-button">Edit</a>
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="id_annonces" value="<?= $row['id_annonces'] ?>">
                    <input type="hidden" name="delete" value="1">
                    <input type="submit" value="Delete" class="delete-button" onclick="return confirm('Are you sure?')">
                </form>
                <a href="comments.php?id_annonces=<?= $row['id_annonces'] ?>" class="comments-button">Comments</a>

            </div>
        </div>
        <?php endforeach; ?>
    </div>


    <script>
    function filterTable(tableId) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(tableId === 'dataTable' ? 'searchBar' : 'searchCommentsBar');
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tableId === 'dataTable' ? 1 : 2];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function filterCommentsTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('searchCommentsBar');
        filter = input.value.toUpperCase();
        table = document.getElementById('commentsTable');
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Assuming Announcement ID is in the second column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    </script>
    <button id="scrollToTopBtn">↑</button>
    <script src="accueil.js"></script>
    <script src="action.js"></script>
    <script src="connexion.js"></script>
    <div class="sidebarannonce">
    <a href="/Integration/View/User/Login.php">Créer une annonce</a>
</body>

</html>
