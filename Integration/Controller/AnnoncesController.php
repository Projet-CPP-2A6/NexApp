<?php

if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $annonesController = new AnnoncesController(Config::getConnexion());}

class AnnoncesController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleCRUDOperations()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['create_organization'])) {
                $this->createOrganization();
            } elseif (isset($_POST['update_organization'])) {
                $this->updateOrganization();
            } elseif (isset($_POST['delete_organization'])) {
                // Pass the organization ID to deleteOrganization
                $this->deleteOrganization($_POST['delete_organization']);
            }
        }
    }

    private function createAnnouncement()
    {
        $titre = htmlspecialchars($_POST['actionTitle']);
        $description = htmlspecialchars($_POST['actionDescription']);

        $stmt = $this->conn->prepare("INSERT INTO annonces (titre, description) VALUES (:titre, :description)");
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    private function updateAnnouncement()
    {
        $id_comments = $_POST['id_annonces'];
        $titre = htmlspecialchars($_POST['actionTitle']);
        $description = htmlspecialchars($_POST['actionDescription']);

        $stmt = $this->conn->prepare("UPDATE annonces SET titre = :titre, description = :description WHERE id_annonces = :id_comments");
        $stmt->bindParam(':id_comments', $id_comments);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    private function deleteAnnouncement()
    {
        $id_comments = $_POST['id_annonces'];

        $stmt = $this->conn->prepare("DELETE FROM annonces WHERE id_annonces = :id_comments");
        $stmt->bindParam(':id_comments', $id_comments);
        $stmt->execute();
    }

    private function handleVote()
    {
        $userIdentifier = $_SERVER['REMOTE_ADDR'];
        $announceId = $_POST['announce_id'];
        $voteValue = $_POST['vote'];

        $stmt = $this->conn->prepare("INSERT INTO votes (user_identifier, announce_id, vote_value) VALUES (:user_identifier, :announce_id, :vote_value)");
        $stmt->bindParam(':user_identifier', $userIdentifier);
        $stmt->bindParam(':announce_id', $announceId);
        $stmt->bindParam(':vote_value', $voteValue);
        $stmt->execute();

        header("Location: view_announce.php?id=$announceId");
        exit();
    }

    public function fetchAllAnnouncements()
    {
        $stmt = $this->conn->prepare("SELECT * FROM annonces");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAnnouncementById($id_comments)
    {
        $stmt = $this->conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_comments");
        $stmt->bindParam(':id_comments', $id_comments);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
