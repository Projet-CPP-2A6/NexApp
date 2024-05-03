<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $EditAnnounceController = new EditAnnounceController(Config::getConnexion());}
class EditAnnounceController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleAnnounceUpdate()
    {
        // Check if form is submitted and the update button is clicked
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            // Get values from the form
            $id_annonces = $_POST['id_annonces'];
            $newTitle = htmlspecialchars($_POST['actionTitle']);
            $newDescription = htmlspecialchars($_POST['actionDescription']);

            // Update the database
            $updateStmt = $this->conn->prepare("UPDATE annonces SET titre = :titre, description = :description WHERE id_annonces = :id_annonces");
            $updateStmt->bindParam(':id_annonces', $id_annonces);
            $updateStmt->bindParam(':titre', $newTitle);
            $updateStmt->bindParam(':description', $newDescription);
            $updateStmt->execute();

            // Redirect to actions.php after the update
            header('Location: actions.php');
            exit();
        }
    }
}
?>
