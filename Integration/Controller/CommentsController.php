<?php

if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $commentsController = new CommentsController(Config::getConnexion());
}

class CommentsController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleCommentSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addComment'])) {
            $id_annonces = isset($_POST['id_annonces']) ? $_POST['id_annonces'] : null;
            $desc_comment = htmlspecialchars($_POST['desc_comment']);

            if (!empty($desc_comment)) {
                try {
                    // Save the new comment to the database
                    $stmt = $this->conn->prepare("INSERT INTO comments (desc_comment, id_annonces) VALUES (:desc_comment, :id_annonces)");
                    $stmt->bindParam(':desc_comment', $desc_comment);
                    $stmt->bindParam(':id_annonces', $id_annonces);
                    $stmt->execute();

                    // Optionally, you can redirect the user after adding a comment
                    header("Location: comments.php?id_annonces=$id_annonces");
                    exit();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                $commentError = "Please enter a non-empty comment.";
            }
        }
    }

    public function fetchCommentsForAnnouncement($id_annonces)
    {
        $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id_annonces = :id_annonces");
        $stmt->bindParam(':id_annonces', $id_annonces);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
