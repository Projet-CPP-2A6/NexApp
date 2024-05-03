<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $associationController = new AssociationsController(Config::getConnexion());}

class AssociationController
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
                $this->deleteOrganization();
            }
        }
    }

    public function deleteOrganization($organizationIdToDelete)
    {
        $stmtDeleteOrganization = $this->conn->prepare("DELETE FROM organisations WHERE ID_Organisation = :orgId");
        $stmtDeleteOrganization->bindParam(':orgId', $organizationIdToDelete, PDO::PARAM_INT);

        if ($stmtDeleteOrganization->execute()) {
            exit();
        } else {
            echo "Failed to delete organization.";
        }
    }

    public function getOrganisations($searchTerm = '')
    {
        $sql = "SELECT * FROM organisations";

        if (!empty($searchTerm)) {
            $sql .= " WHERE Nom_Org LIKE :searchTerm";
        }

        $stmtOrganisations = $this->conn->prepare($sql);

        if (!empty($searchTerm)) {
            $searchTerm = "%$searchTerm%";
            $stmtOrganisations->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        }

        $stmtOrganisations->execute();
        return $stmtOrganisations->fetchAll(PDO::FETCH_ASSOC);
    }
}