<?php

if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $annonesadmincontroller = new AnnoncesAdminCOntroller(Config::getConnexion());}


class AnnoncesAdminController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleCRUDOperations()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete'])) {
                $this->deleteAnnouncement();
            }
        }
    }

    private function deleteAnnouncement()
    {
        $id_annonces = $_POST['id_annonces'];

        $stmt = $this->conn->prepare("DELETE FROM annonces WHERE id_annonces = :id_annonces");
        $stmt->bindParam(':id_annonces', $id_annonces);
        $stmt->execute();

        header('Location: admin_actions.php');
        exit();
    }
}
?>
