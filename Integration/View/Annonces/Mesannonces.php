<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../Controller/AdminActionsController.php';

$conn = Config::getConnexion();
$adminActionsController = new AdminActionsController($conn);
$adminActionsController->handleAnnounceDeletion();
$rows = $adminActionsController->getAllAnnouncements();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin actions</title>
    <link rel="stylesheet" href="../General/Accueil/accueil.css">
    <link rel="stylesheet" href="../General/Actions/actions.css">
    <!-- Add any additional stylesheets if needed -->
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
        margin-top: 20px;
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
    </style>
</head>

<body>
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
        <h1>- Mes Actions -</h1>
    </div>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>

    <div class="menu">
        <a href="../General/Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Product/View_Products.php">Notre Boutique</a>
        <a href="../General/Actions/actions.php">Nos actions</a>

    </div>

    <div class="center-container">
        <!-- Search Bar for Announcements -->
        <input type="text" id="searchBar" onkeyup="filterTable('dataTable')" placeholder="Search by Title">



        <!-- Displaying Announcements Table -->
        <table id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['id_annonces'] ?></td>
                    <td><?= $row['titre'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="id_annonces" value="<?= $row['id_annonces'] ?>">
                            <input type="hidden" name="delete" value="1">
                            <input type="submit" value="Delete" class="delete-button"
                                onclick="return confirm('Are you sure?')">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

</html>