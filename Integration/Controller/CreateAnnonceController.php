<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $CreateAnnonceController = new CreateAnnonceController(Config::getConnexion());
}

class CreateAnnonceController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleAnnounceCreation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
            $titre = htmlspecialchars($_POST['actionTitle']);
            $description = htmlspecialchars($_POST['actionDescription']);

            $stmt = $this->conn->prepare("INSERT INTO annonces (titre, description) VALUES (:titre, :description)");
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            // Redirect to actions.php after creating the announcement
            header('Location: actions.php');
            exit();
        }
    }
}
?>
