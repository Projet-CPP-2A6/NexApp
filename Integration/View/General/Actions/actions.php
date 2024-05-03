<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>
    <link rel="stylesheet" href="../Accueil/accueil.css">
    <link rel="stylesheet" href="actions.css">
    <div class="menu">
        <a href="../Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="/Integration/View/Product/View_Products.php">Notre Boutique</a>
        <a href="../Actions/actions.php">Nos actions</a>

    </div>
</head>

<body>
<a href="/Integration/View/User/Login.php">
    <div class="notification-icon" id="notification-icon">
        <img src="/Integration/View/Sources/icon_not.png" alt="Notification Icon">
    </div>
</a>
    <div class="sidebar">
        <a href="#">
        <img src="../../Sources/icons/facebook1.png" alt="facebook">
    </a>
    <a href="#">
        <img src="../../Sources/icons/instagramm.png" alt="Instagram">
    </a>
        <a href="#">
        <img src="../../Sources/icons/linkedin.png" alt="linkedin">
    </a>
        <a href="#">
        <img src="../../Sources/icons/whatsapp.png" alt="whatsapp">
    </a>
    </div>
    <div class="rectanglecover">
        <h1>Actions en cours</h1>
    </div>
<div class="logo"> <img src="../../Sources/LOGO.png" alt="Logo"> </div>

<!-- <div class="btn_admin">
        <a href="../connexion/connexion.html">Se connecter en tant qu'admin</a>
    </div> -->
<div class="center-container">
    <div class="rectangle">
        <div class="logo1">
            <img src="../../Sources/crt.png" alt="Logo">
        </div>
        <div class="texte">
            <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla pariatur odit quas tempora eaque, quis veniam maxime? Cupiditate ducimus illum quisquam quos soluta, tempore consectetur, blanditiis fugiat nemo tenetur nisi.</h3>
        </div>
        <div class="rectangle_don">
            <a href="/Integration/View/Dons/formulaire.php">Faire un don</a>
        </div>
    </div>

    <div class="rectangle">
        <div class="logo1">
            <img src="../../Sources/crt.png" alt="Logo">
        </div>
        <div class="texte">
            <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla pariatur odit quas tempora eaque, quis veniam maxime? Cupiditate ducimus illum quisquam quos soluta, tempore consectetur, blanditiis fugiat nemo tenetur nisi.</h3>
        </div>
        <div class="rectangle_don">
            <a href="/Integration/View/Dons/formulaire.php">Faire un don</a>
        </div>
    </div>
    <div class="rectangle">
        <div class="logo1">
            <img src="../../Sources/crt.png" alt="Logo">
        </div>
        <div class="texte">
            <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla pariatur odit quas tempora eaque, quis veniam maxime? Cupiditate ducimus illum quisquam quos soluta, tempore consectetur, blanditiis fugiat nemo tenetur nisi.</h3>
        </div>
        <div class="rectangle_don">
            <a href="/Integration/View/Dons/formulaire.php">Faire un don</a>
        </div>
    </div>
    <div class="rectangle">
        <div class="logo1">
            <img src="../../Sources/crt.png" alt="Logo">
        </div>
        <div class="texte">
            <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla pariatur odit quas tempora eaque, quis veniam maxime? Cupiditate ducimus illum quisquam quos soluta, tempore consectetur, blanditiis fugiat nemo tenetur nisi.</h3>
        </div>
        <div class="rectangle_don">
            <a href="/Integration/View/Dons/formulaire.php">Faire un don</a>
        </div>
    </div>
</div>

</div>
<button id="scrollToTopBtn">↑</button>
<script src="Accueil/accueil.js"></script>
<script src="action.js"></script>
<script src="connexion.js"></script>
<div class="sidebarannonce">
    <a href="/Integration/View/Annonces/create_announce.php">Créer une annonce</a>
</div>
<style>
.notification-icon {
    position: fixed;
    top: 20px;
    right: 20px;
    cursor: pointer;
    z-index: 999; /* Adjust the value as needed */
}

.notification-icon img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}
</style>
</body>