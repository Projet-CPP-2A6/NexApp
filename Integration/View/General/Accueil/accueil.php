<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="accueil.css">
    <div class="menu">
        <a href="../Accueil/accueil.php">Accueil</a>
        <a href="#nos_chiffres">A propos</a>
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
<div class="logo"> <img src="../../Sources/LOGO.png" alt="Logo"> </div>

<!-- <div class="btn_admin">
        <a href="../connexion/connexion.html">Se connecter en tant qu'admin</a>
    </div> -->
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
    <div class="image-in-rectangle">
        <img src="../../Sources/omar.jpg" alt="Your Photo">
    </div>
    <div class="image-in-circle">
        <img src="../../Sources/rajel.jpg" >
    </div>
    <div class="paragraphe1">
        <h5>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, <br>
            consequatur ad quos consequuntur suscipit beatae nobis nihil <br>
            asperiores dolore, nisi aperiam officia accusantium libero ratione earum fuga et eum eos <br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum deserunt doloremque <br>
            veritatis ab blanditiis labore dolores modi. Nemo nisi quibusdam nulla optio ad, <br>
            ipsam explicabo deleniti id dicta ipsa fuga.
        </h5>
    </div>
    <div class="Titre">
        <h1> Ensemble nous <br>
            faisons la <br>
            différence
            <hr size="7" color="#D7B20B" width="80%">
        </h1>
    </div>
    <div class="paragraphe2">
        <h4>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, <br>
            consequatur ad quos consequuntur suscipit beatae nobis nihil <br>
            asperiores dolore, nisi aperiam officia accusantium libero ratione earum fuga et eum eos <br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum deserunt doloremque <br>
            veritatis ab blanditiis labore dolores modi. Nemo nisi quibusdam nulla optio ad, <br>
            ipsam explicabo deleniti id dicta ipsa fuga.
        </h4>
    </div>
<div id="a_propos">
    <div class="apropos">
        <h4>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, <br>
            consequatur ad quos consequuntur suscipit beatae nobis nihil <br>
            asperiores dolore, nisi aperiam officia accusantium libero ratione earum fuga et eum eos <br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum deserunt doloremque <br>
            veritatis ab blanditiis labore dolores modi. Nemo nisi quibusdam nulla optio ad, <br>
            ipsam explicabo deleniti id dicta ipsa fuga.
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, <br>
            consequatur ad quos consequuntur suscipit beatae nobis nihil <br>
            asperiores dolore, nisi aperiam officia accusantium libero ratione earum fuga et eum eos <br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum deserunt doloremque <br>
            veritatis ab blanditiis labore dolores modi. Nemo nisi quibusdam nulla optio ad, <br>
            ipsam explicabo deleniti id dicta ipsa fuga
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, <br>
            consequatur ad quos consequuntur suscipit beatae nobis nihil <br>
            asperiores dolore, nisi aperiam officia accusantium libero ratione earum fuga et eum eos <br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum deserunt doloremque <br>
        </h4>
    </div>
</div>
<div id="nos_chiffres" class="statistiques-container">
    <h1>Nos chiffres</h1>
    <div class="stat-rectangle">
        <h1 class="stat-value" data-final-value="956">0</h1>
        <h5>Actions</h5>
    </div>
    <div class="stat-rectangle">
        <h1 class="stat-value" data-final-value="84">0</h1>
        <h5>Partenaires</h5>
    </div>
    <div class="stat-rectangle">
        <h1 class="stat-value" data-final-value="9">0</h1>
        <h5>Régions visitées</h5>
    </div>    <div class="stat-rectangle">
        <h1 class="stat-value" data-final-value="2400">0</h1>
        <h5>Personnes aidées</h5>
    </div>
    <div class="stat-rectangle">
        <h1 class="stat-value" data-final-value="63">0</h1>
        <h5>Clubs</h5>    </div>
    <div class="stat-rectangle">
        <h1 class="stat-value" data-final-value="1">0</h1>
        <h5>Objectif</h5>    </div>
    </div>
</div>

<button id="scrollToTopBtn">↑</button>
<script src="/Integration/View/General/Actions/accueil.js"></script>
<script src="/Integration/View/General/Actions/action.js"></script>
<script src="/Integration/View/User/Login.js"></script>
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
</html>