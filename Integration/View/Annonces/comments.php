<?php require __DIR__ . '/../../config.php'; ?>
<?php require_once __DIR__ . '/../../Controller/CommentsController.php'; ?>

<?php
// Assuming your Config class is correctly defined
$conn = Config::getConnexion();

// Instantiate the CommentsController with the database connection
$commentsController = new CommentsController($conn);

// Call the method to handle comment submission
$commentsController->handleCommentSubmission();

// Check if the id_annonces is set in the URL
if (isset($_GET['id_annonces'])) {
    $id_annonces = $_GET['id_annonces'];

    // Fetch the selected announcement
    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_annonces");
    $stmt->bindParam(':id_annonces', $id_annonces);
    $stmt->execute();
    $announcement = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch comments for the selected announcement from the database
    $comments = $commentsController->fetchCommentsForAnnouncement($id_annonces);

    // Assign values to variables for use in HTML
    $viewId = $announcement['id_annonces'];
    $viewTitle = $announcement['titre'];
    $viewDescription = $announcement['description'];

    // Initialize $commentError to an empty string
    $commentError = "";
} else {
    // If id_annonces is not set, redirect to actions.php
    header('Location: actions.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <!-- Add your stylesheets here -->
    <link rel="stylesheet" href="../General/Accueil/accueil.css">
    <link rel="stylesheet" href="../General/Actions/actions.css">

    <style>
   .voting-stars {
        margin-top: 20px;
        /* Add some top margin for spacing */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .voting-stars form {
        display: flex;
        align-items: center;
        margin-left: 10px;
        /* Add some left margin for spacing */
    }

    #vote {
        margin-left: 5px;
        /* Adjust spacing between the dropdown and the button */
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        /* Add a smooth transition effect */
    }

    input[type="submit"]:hover {
        background-color: #45a049;
        /* Change color on hover */
    }

    .center-container {
        text-align: center;
        margin-top: 220px;
        /* Adjusted margin for better spacing */
    }


    .rectangle {
        display: flex;
        align-items: center;
        border: 1px solid #d7b20b;
        padding: 10px;
        margin-bottom: 0;
        /* Remove the margin at the bottom */
    }


    .texte h3 {
        margin-bottom: 10px;
        font-size: 20px;
        /* Adjust the font size as needed */
    }


    .rectangle .logo1 {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }


    .logo1 {
        padding: 25px;
        margin-left: 50px;
        /* Adjust the margin as needed */
    }

    .texte {
        flex: 1;
        padding: 0px;
        font-size: 20px;
    }

    .comments-section {
        margin-top: 0px;
    }

    .comment-box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 5px;
        max-width: 100%;
        box-sizing: border-box;
    }

    .comment-id {
        font-weight: bold;
        color: #333;
    }

    .comment-text {
        margin-top: 5px;
        color: #555;
    }

    .comments-container {
        margin-top: 10px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
        text-align: center;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 10px; /* Ajustement de la marge en bas */
    }

    #desc_comment {
        width: 100%;
        padding: 8px;
        margin-top: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f4f4f4;
    }

    .comment-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
</style>




</head>

<body>
    <!-- Add your menu and navigation bar here -->
    <div class="menu">
        <a href="../General/Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Product/View_Products.php">Notre Boutique</a>
        <a href="../General/Actions/actions.php">Nos actions</a>

    </div>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>
    <div class="center-container">
        <div class="rectangle">
            <div class="logo1">
                <img src="../Sources/crt.png" alt="Logo">
            </div>
            <div class="voting-stars">
                <form action="comments.php" method="post">
                    <input type="hidden" name="id_annonces" value="<?= $viewId ?>">
                    <label for="vote">Vote:</label>
                    <select name="vote" id="vote">
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                    <input type="submit" value="Vote" name="submitVote">
                </form>
            </div>

            <div class="texte">
                <h3><?= $viewTitle ?></h3>
            </div>
            <div class="texte1">
                <p><?= $viewDescription ?></p>
            </div>
        </div>
    </div>

    <div class="comments-container">
        <h4>Comments</h4>
        <?php foreach ($comments as $comment) : ?>
        <div class="comment-box">
            <p class="comment-id">Comment ID: <?= $comment['id_comments'] ?></p>
            <p class="comment-text"><?= $comment['desc_comment'] ?></p>
        </div>
        <?php endforeach; ?>

        <!-- Add a form to submit new comments with client-side validation -->
        <form action="" method="post" id="commentForm" onsubmit="return validateComment();">
            <input type="hidden" name="id_annonces" value="<?= $id_annonces ?>">
            <label for="desc_comment">Add a comment:</label>
            <textarea name="desc_comment" id="desc_comment" rows="4" cols="50"></textarea>
            <div id="commentError"><?php echo $commentError; ?></div>
            <button type="submit" name="addComment" class="comment-button">Add Comment</button>
        </form>
    </div>
    <!-- Updated JavaScript code in the <head> section of your HTML -->
    <script>
    function addComment(event) {
        event.preventDefault(); // Prevent the default form submission

        if (validateComment()) {
            var commentInput = document.getElementById('desc_comment');
            var commentError = document.getElementById('commentError');

            // Check if the comment is empty
            if (commentInput.value.trim() === "") {
                commentError.textContent = "Please enter a non-empty comment.";
                return;
            }

            // Clear the error message if the comment is not empty
            commentError.textContent = "";

            // Create a new comment box
            var newCommentBox = document.createElement("div");
            newCommentBox.className = "comment-box";

            // Create a paragraph for the comment ID
            var commentIdParagraph = document.createElement("p");
            commentIdParagraph.className = "comment-id";
            commentIdParagraph.textContent = "Comment ID: New";

            // Create a paragraph for the comment text
            var commentTextParagraph = document.createElement("p");
            commentTextParagraph.className = "comment-text";
            commentTextParagraph.textContent = commentInput.value;

            // Append paragraphs to the comment box
            newCommentBox.appendChild(commentIdParagraph);
            newCommentBox.appendChild(commentTextParagraph);

            // Append the new comment box to the comments section
            var commentsSection = document.querySelector(".comments-section");
            commentsSection.appendChild(newCommentBox);

            // Optionally, clear the textarea or do any other necessary actions
            commentInput.value = '';
        }

        function validateComment() {
            var commentInput = document.getElementById('desc_comment');
            var commentError = document.getElementById('commentError');

            // Check if the comment is empty
            if (commentInput.value.trim() === "") {
                commentError.textContent = "Please enter a non-empty comment.";
                return false;
            }

            // Clear the error message if the comment is not empty
            commentError.textContent = "";

            // Add any additional validation logic here if needed

            return true;
        }
    }    
    </script>
    <button id="scrollToTopBtn">↑</button>
    <script src="accueil.js"></script>
    <script src="action.js"></script>
    <script src="connexion.js"></script>
</body>

</html>