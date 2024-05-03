<?php

if (!class_exists('Config')) {
    require_once __DIR__ . '/../../config.php'; 
    $categoriesController = new CategoriesController(Config::getConnexion()); 
}

class CategoriesController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index()
    {
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch all categories
            $pdostat = $this->conn->prepare('SELECT * FROM categories');
            $executeisok = $pdostat->execute();
            $categories = $pdostat->fetchAll(PDO::FETCH_ASSOC);

            // Check if the form is submitted and the parameter is set
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_nom_categorie'])) {
                // Supprimer la ligne de la base de données
                $delete_nom_categorie = $_POST['delete_nom_categorie'];

                // Use DELETE statement to remove rows with a specific nom_categorie
                $deleteStatement = $this->conn->prepare('DELETE FROM categories WHERE nom_categorie = :delete_nom_categorie');
                $deleteStatement->bindParam(':delete_nom_categorie', $delete_nom_categorie);
                $deleteStatement->execute();
            }
            

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getCategories()
    {
        $pdostat = $this->conn->prepare('SELECT * FROM categories');
        $executeisok = $pdostat->execute();
        return $pdostat->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>