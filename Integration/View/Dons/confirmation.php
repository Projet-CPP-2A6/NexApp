<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

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
            font-size: 20px;
            background-color: #DEDEDE;
            width: 100%;
            border-bottom: 1px solid #000000;
            box-shadow: 0 0 20px rgb(0, 0, 0);
        }

        .menu a {
            color: #000000;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 160px;
            transition: all 0.3s;
        }

        .menu a:hover {
            background-color: #BD0055;
            transform: scale(1.1);
            color: #FFFFFF;
            border: 1px solid #000000;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.576);
        }

        .confirmation-container {
            perspective: 1000px;
            width: 600px; /* Set width for the card container */
            height: 600px; /* Set height for the card container */
            margin-top: 20px; /* Adjust the margin to your preference */
        }

        .confirmation-card {
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.5s;
            transform-origin: center right;
            width: 100%;
            height: 100%;
        }

        .confirmation-box,
        .comment-box {
            background-color: #02567A;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            backface-visibility: hidden;
        }

        .comment-box {
            transform: rotateY(180deg);


        }
        h2 {
            color: #FFD700;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 30px;
            line-height: 1.6;
        }

      

        /* Style for the buttons */
        .btn {
            background-color: #FFD700;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }

        .btn:hover {
            background-color: #FFA500;
        }

        /* Style for paragraphs */
        p {
            margin-bottom: 10px;
        }

        /* Card flip animation */
        .flipped {
            transform: rotateY(180deg);
        }

        /* Style for the textarea */
        .comment-box textarea {
            width: 100%;
            height: 100px; /* Set your preferred height */
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #fff; /* Border color */
            border-radius: 5px;
            font-family: 'Arial', sans-serif; /* Use your preferred font */
            font-size: 12px;
            color: #333; /* Text color */
            background-color: #fff; /* Textarea background color */
        }
        
        .back-button {
            position: absolute;
            bottom: 20px; /* Ajustez la position verticale selon vos préférences */
            left: 80%;
            transform: translateX(-50%);
            background-color: #FFD700;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #FFA500;
        }
        .envoyer-button {
            background-color: #FFD700;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            transition: background-color 0.3s;
        }

        .envoyer-button:hover {
            background-color: #FFA500;
        }
    </style>
</head>

<body>
    <div class="logo"> 
        <img src="../Sources/LOGO.png" alt="Logo88"> </div>
   


    <div class="confirmation-container" id="confirmationContainer">
        <div class="confirmation-card" id="confirmationCard">
            <div class="confirmation-box">
                <h2>Confirmation Page</h2>
                <p>Nous tenons à exprimer notre sincère gratitude pour votre généreux don. Votre soutien contribue de manière significative à nos efforts et nous aide à poursuivre notre mission. Merci pour votre engagement envers notre cause.</p>
                <button class="back-button" onclick="goBack()">Go Back</button>
                <button class="btn" onclick="flipCard()">Commentaires</button>
            </div>
            <div class="comment-box">
                <textarea placeholder="Ajouter un commentaire"></textarea>
                <button class="btn" onclick="flipCard()">Retour</button>
                <button class="envoyer-button" onclick="envoyerCommentaire()">Envoyer</button>
            </div>
            
        </div>
    </div>
    
    <script>
        function flipCard() {
            var card = document.getElementById('confirmationCard');
            card.classList.toggle('flipped');
        }
        function goBack() {
            window.location.href = 'formulaire.php';
        }
    </script>
</body>

</html>
