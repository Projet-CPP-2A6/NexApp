<?php
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

        header("Location: confirmation.php");
        exit; // Make sure to exit to stop further execution
 
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>

    <link rel="stylesheet" href="/Integration/View/General/style.css">
    <style> 
    .logo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 180px;
    height: 180px;
    background-color: #D7B20B;
    border-radius: 50%;
    border :1px solid #000000;
    position: fixed;
    top: 20px;
    left: 20px;
    box-shadow: 0 0 20px rgb(0, 0, 0);
    z-index: 3;
}
.logo img {
    width: 150px;
    height: 70px;
}
.menu {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    padding: 15px;
    position: fixed;
    top: 0px;
    left: 200px;
    right: 120px;
    font-size: 20px;
    z-index: 1000;
    background-color:#DEDEDE;
    width: auto;
    border-bottom-left-radius: 150px;
    border-bottom-right-radius: 150px;
    border: 1px solid #000000;
    opacity: 0.85;
    box-shadow: 0 0 20px rgb(0, 0, 0);
}
.menu a {
    color: #000000;
    background-color: #DEDEDE;
    text-decoration: none;
    padding: 10px 20px; /* Ajustez la taille des boutons selon vos préférences */
    border: 1px solid #000000;
    border-radius: 160px;
    transition: all 0.3s; /* Ajoutez une transition pour une animation fluide */
}
.menu a:hover {
    background-color: #BD0055; /* Change la couleur de fond au survol */
    transform: scale(1.1); /* Agrandit le bouton au survol */
    color: #FFFFFF;
    border: 1px solid #000000; /* Vous pouvez personnaliser la bordure du bouton au survol */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.576);
}
.btn_admin {
    position: fixed;
    padding: 10px 20px;
    top: 0px;
    right: 0px;
    font-size: 12px;
    font-weight: bold;
    z-index: 1000;
}
.btn_admin a{
    color: #000000;
    background-color: #DEDEDE;
    text-decoration: none;
    padding: 10px 20px ; /* Ajustez la taille des boutons selon vos préférences */
    border: 1px solid #000000;
    border-bottom-left-radius: 160px;
    border-bottom-right-radius: 160px;
    transition: all 0.3s; /* Ajoutez une transition pour une animation fluide */
}
.btn_admin a:hover {
    background-color: #BD0055; /* Change la couleur de fond au survol */
    transform: scale(1.1); /* Agrandit le bouton au survol */
    color: #FFFFFF;
    border: 1px solid #000000; /* Vous pouvez personnaliser la bordure du bouton au survol */
}


body {
    font-family :'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #DEDEDE;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: auto;
}
       .rectanglecover h1{
         
    text-align: center;
    top: 15%;
    color: #02567A;
    text-decoration: none;
    padding: 77px 8px;
    border-radius: 20px;
    font-size: 70px;
    padding-right: 90px;
        }


       .btn {
            text-align: center;
            margin-top: 20px;
        }

        .btn input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 18px 50px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .center-container {
    max-width: 2000px; /* Adjust the max-width for the yellow box */
    width: 100%;
    border-radius: 6px;
    padding: 50px;
    background-color: #02567A;
}

.center-container header {
    font-size: 50px;
    font-weight: 100;
    color: #D7B20B;
}

.center-container form {
    max-width: 1800px; /* Adjust the max-width for the blue box */
    margin-top: 16px;
    min-height: 490px;
    background-color: #D7B20B;
}

.center-container form .details {
    margin-top: 30px;
}

.center-container form .title {
    font-size: 16px;
    font-weight: 500;
    margin: 6px 0;
    color: #000000;
}

.center-container form .fields {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.center-container form .fields .input-field {
    display: flex;
    width: calc(33.33% - 15px);
    flex-direction: column;
    margin: 4px;
}

.input-field label {
    font-size: 16px;
    font-weight: 500;
    color: #000000;
    margin-bottom: 4px;
}

.input-field input {
    height: 42px;
    margin: 0;
    outline: none;
    font-size: 14px;
    font-weight: 400;
    color: #333;
    border-radius: 5px;
    border: 1px solid #aaa;
    padding: 0 15px;
}

.input-field input:is(:focus, :valid) {
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.13);
}

/* Increase the font size of the placeholder text */
.input-field input::placeholder {
    font-size: 14px; /* Adjust the font size as needed */
}
.imagesprestations h2{
    font-family: 'Roboto',cursive;
        text-align: center;
        font-size: 1.8em;
        color: #BD0055;
        font-weight: 300;
        margin: 15px;
}

.texte{
    display: flex;
    position: relative;
    margin-left: 15%;
    margin-top: 3.5%;
    margin-right: 2%;
    z-index: -1000;
}
.rectangle {
    margin-bottom: 60px;
    display: flex;
    background-color: #00000033;
    color: #000000;
    width: 100%; 
    max-width: 1500px; 
    border-radius: 60px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    opacity: 1;
}
.rectanglecover  {
    position: fixed;
    top: 0px;
    right: 0px;
    left: 0px;
    background-color: #DEDEDE;
    width: 2000px;
    height: 250px;
    padding: 10px 0;
    z-index: 2;
}
.sidebarannonce {
    position: fixed;
    top: 150px;
    right: 0px;
    background-color: #02567A;
    width: 60px;
    height: auto;
    padding: 10px 0;
    border: 1px solid black;
    border-top-left-radius: 30px; /* Adjust the radius as needed for curved corners */
    border-bottom-left-radius: 30px; /* Adjust the radius as needed for curved corners */
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.631);
    z-index: 1000;
}

.sidebarannonce a{
    writing-mode: vertical-lr; /* Écriture verticale de bas en haut (de gauche à droite) */
    display: flex;
    position: relative;
    color: #FFFFFF;
    background-color: #02567A;
    text-decoration: none;
    font-size: 25px;
    padding: 10px 20px ; /* Ajustez la taille des boutons selon vos préférences */
    overflow: hidden;
    border-bottom-left-radius: 160px;
    border-bottom-right-radius: 160px;
    transition: all 0.3s; /* Ajoutez une transition pour une animation fluide */
}

.sidebarannonce a:hover{
    writing-mode: vertical-lr; /* Écriture verticale de bas en haut (de gauche à droite) */
    display: flex;
    position: relative;
    color: #D7B20B;
    background-color: #02567A;
    text-decoration: none;
    font-size: 30px;
    padding: 10px 20px ; /* Ajustez la taille des boutons selon vos préférences */
    overflow: hidden;
    border-bottom-left-radius: 160px;
    border-bottom-right-radius: 160px;
    transition: all 0.2s; /* Ajoutez une transition pour une animation fluide */
}



    </style>
   <div class="menu">
        <a href="../General/Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Product/View_Products.php">Notre Boutique</a>
        <a href="../General/Actions/actions.php">Nos actions</a>

    </div>
</head>


<body>
    <div class="imageprincipale">
        <a href="#">
            <img src="../Sources/rajel.jpg" alt="facebookiiii89">
        </a>
    </div>
    <div class="rectanglecover">
        <h1>Le Blog Des Dons</h1>
    </div>
    <div class="logo"> 
        <img src="../Sources/LOGO.png" alt="Logo88"> </div>
 
 

    <div id="prestations">
        <div class="imagesprestations ">
            <h2>                </h2>
            <div class="center-container">
                <header>Detail du Donnateur</header>
                <form id="registrationForm" method="POST" action="ajout.php">
                    <div class="form first">
                        <div class="detail personal">
                            <span class="title"></span>
                            <div class="fields">
                                <div class="input-field">
                                    <label for="nom">Nom complet</label>
                                    <input type="text" name="nom" placeholder="enter your name" id="nom" >
                                    <span id="nomError" style="color: red;"></span>
                                </div>
                                <div class="input-field">
                                    <label for="email">Adresse email</label>
                                    <input type="email" name="email" placeholder="enter your email" id="email" >
                                    <span id="emailError" style="color: red;"></span>
                                </div>
                                <div class="input-field">
                                    <label for="numero">Numero</label>
                                    <input type="number" name="numero" placeholder="enter your phone number" id="numero" >
                                    <span id="numeroError" style="color: red;"></span>
                                </div>
                                <div class="input-field">
                                    <label for="societe">Nom de la société</label>
                                    <input type="text" name="societe" placeholder="enter your company name" id="societe" >
                                </div>
                                <div class="input-field">
                                    <label for="matricule">Matricule de la société</label>
                                    <input type="text" name="matricule" placeholder="enter your company registration number" id="matricule" >
                                </div>
                                <div class="input-field">
                                    <label for="pays">Pays</label>
                                    <input type="text" name="pays" placeholder="enter your country" id="pays" >
                                </div>
                                <div class="input-field">
                                    <label for="region">Région</label>
                                    <input type="text" name="region" placeholder="enter your region" id="region" >
                                </div>
                                <div class="input-field">
                                    <label for="Postcode">Postcode</label>
                                    <input type="text" name="Postcode" placeholder="enter your Postcode" id="Postcode" >
                                </div>
                                <div class="input-field">
                            <label for="categorie">Catégorie</label>
                            <select name="categorie" id="categorie">
                            
                               <option value="argent">Argent</option>
                              <option value="habits">Habits</option>
                             <option value="nourriture">Nourriture</option>
                               </select>
                              <span id="typededonError" style="color: red;"></span>
                              </div>
                              
                            </div>
                            <div class="g-recaptcha" data-sitekey="VOTRE_CLE_PUBLIQUE"></div>
                        </div>
                    </div>
                    <div class="input-field" id="montantField" style="display: none;">
    <label for="montant">Montant</label>
    <br>
    <input type="text" name="montant" placeholder="enter the amount" id="montant" onclick="return validateForm();">
</div>
<div class="input-field" id="quantiteField" style="display: none;">
    <label for="quantite">Quantité</label>
    <br>
    <input type="text" name="quantite" placeholder="enter the quantity" id="quantite" onclick="return validateForm();">
</div>
                    <div class="btn">
                        <input type="submit" value="valider" name="ok" id="submitButton"  onclick="return validateForm();">
                    </div>
                </form>

            </div>
        </div>
    </div>

    <button id="scrollToTopBtn">↑</button>
    <script src="/Integration/View/General/Accueil/accueil.js"></script>
    <script src="/Integration/View/General/Actions/action.js"></script>
    <script src="/Integration/View/User/connexion.js"></script>
    <script>
         document.getElementById("registrationForm").addEventListener("submit", function (event) {
            if (!validateForm()) {
                event.preventDefault(); // Empêche l'envoi du formulaire si la validation échoue
            }
        });

        function validateForm() {
    var nom = document.getElementById("nom").value;
    var email = document.getElementById("email").value;
    var numero = document.getElementById("numero").value;
    var societe = document.getElementById("societe").value;
    var matricule = document.getElementById("matricule").value;
    var pays = document.getElementById("pays").value;
    var region = document.getElementById("region").value;
    var postcode = document.getElementById("Postcode").value;
    var categorie = document.getElementById("categorie").value;
    var montant = document.getElementById("montant").value;
    var quantite = document.getElementById("quantite").value;

    //valider toutes les champs 
    if (nom.trim() === "" || email.trim() === "" || numero.trim() === "" || societe.trim() === "" || matricule.trim() === "" || pays.trim() === "" || region.trim() === "" || postcode.trim() === "" || categorie.trim() === "" || (categorie === "argent" && montant.trim() === "") || ((categorie === "habits" || categorie === "nourriture") && quantite.trim() === "")) {
        alert("Veuillez remplir tous les champs.");
        return false; // Empêcher l'envoi du formulaire
    }

    var isValid = true;

    // Validation du champ nom (minimum 2 caractères, maximum 30 caractères)
    if (nom.trim().length < 2 || nom.trim().length > 30) {
        document.getElementById("nomError").innerHTML = "Veuillez entrer un nom entre 2 et 30 caractères";
        isValid = false;
    } else {
        document.getElementById("nomError").innerHTML = "";
    }

    // Validation pour le numéro de téléphone ne dépassant pas 8 chiffres
    if (numero.length > 8) {
        document.getElementById("numeroError").innerHTML = "Le numéro ne peut pas dépasser 8 chiffres";
        isValid = false;
    } else {
        document.getElementById("numeroError").innerHTML = "";
    }

    // Validation de l'e-mail
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById("emailError").innerHTML = "Veuillez entrer une adresse e-mail valide";
        isValid = false;
    } else {
        document.getElementById("emailError").innerHTML = "";
    }

    // Validation du champ société (non vide)
    if (societe.trim() === "") {
        document.getElementById("societeError").innerHTML = "Veuillez entrer le nom de la société";
        isValid = false;
    } else {
        document.getElementById("societeError").innerHTML = "";
    }

    // Validation du champ matricule (non vide)
    if (matricule.trim() === "") {
        document.getElementById("matriculeError").innerHTML = "Veuillez entrer le matricule de la société";
        isValid = false;
    } else {
        document.getElementById("matriculeError").innerHTML = "";
    }

    // Validation du champ pays (non vide)
    if (pays.trim() === "") {
        document.getElementById("paysError").innerHTML = "Veuillez entrer le pays";
        isValid = false;
    } else {
        document.getElementById("paysError").innerHTML = "";
    }

    // Validation du champ région (non vide)
    if (region.trim() === "") {
        document.getElementById("regionError").innerHTML = "Veuillez entrer la région";
        isValid = false;
    } else {
        document.getElementById("regionError").innerHTML = "";
    }

    // Validation du champ Postcode (non vide)
    if (postcode.trim() === "") {
        document.getElementById("PostcodeError").innerHTML = "Veuillez entrer le code postal";
        isValid = false;
    } else {
        document.getElementById("PostcodeError").innerHTML = "";
    }

    // Validation du champ catégorie (non vide)
    if (categorie.trim() === "") {
        document.getElementById("typededonError").innerHTML = "Veuillez sélectionner une catégorie";
        isValid = false;
    } else {
        document.getElementById("typededonError").innerHTML = "";
    }

    // Validation du champ montant (si la catégorie est "argent")
    if (categorie === "argent" && montant.trim() === "") {
        document.getElementById("montantError").innerHTML = "Veuillez entrer le montant";
        isValid = false;
    } else {
        document.getElementById("montantError").innerHTML = "";
    }

    // Validation du champ quantité (si la catégorie est "habits" ou "nourriture")
    if ((categorie === "habits" || categorie === "nourriture") && quantite.trim() === "") {
        document.getElementById("quantiteError").innerHTML = "Veuillez entrer la quantité";
        isValid = false;
    } else {
        document.getElementById("quantiteError").innerHTML = "";
    }

    // Afficher le message d'erreur global si le formulaire n'est pas valide
  
}

// Ajoutez également cette fonction pour masquer le message d'erreur lorsque l'utilisateur commence à remplir le formulaire
function hideErrorMessage() {
    document.getElementById("errorMessage").style.display = "none";
}


        
    



    </script>
    <script>
    document.getElementById("categorie").addEventListener("change", function () {
        var selectedCategory = this.value;
        var montantField = document.getElementById("montantField");
        var quantiteField = document.getElementById("quantiteField");

        // Réinitialiser les champs de texte à chaque changement
        document.getElementById("montant").value = "";
        document.getElementById("quantite").value = "";

        // Afficher/masquer les champs de texte en fonction de la catégorie sélectionnée
        if (selectedCategory === "argent") {
            montantField.style.display = "block";
            quantiteField.style.display = "none";
        } else if (selectedCategory === "habits" || selectedCategory === "nourriture") {
            montantField.style.display = "none";
            quantiteField.style.display = "block";
        } else {
            // Cacher les deux champs si la catégorie n'est ni "argent" ni "habits" ni "nourriture"
            montantField.style.display = "none";
            quantiteField.style.display = "none";
        }
    });

</script>

   
</body>



</html>