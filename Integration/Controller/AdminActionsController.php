<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $AdminActionsController = new AdminActionsController(Config::getConnexion());}

class AdminActionsController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleAnnounceDeletion()
    {
        // Handle form submissions (delete)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
            $idToDelete = $_POST['id_annonces'];

            // Delete logic
            $stmt = $this->conn->prepare("DELETE FROM annonces WHERE id_annonces = :id_annonces");
            $stmt->bindParam(':id_annonces', $idToDelete);
            $stmt->execute();

            // Redirect to the main admin_actions.php page after delete
            header('Location: admin_actions.php');
            exit();
        }
    }

    public function getAllAnnouncements()
    {
        // Fetch all data for displaying
        $stmt = $this->conn->prepare("SELECT * FROM annonces");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
