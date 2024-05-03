    <?php
    if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $macController = new MacController($conn);}

    class MacController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleDelete()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
                $delete_id = $_POST['delete_id'];
                $deleteStatement = $this->conn->prepare('DELETE FROM mac WHERE id_mac = :id');
                $deleteStatement->bindParam(':id', $delete_id);
                $deleteStatement->execute();
            }

            $pdostat = $this->conn->prepare('SELECT * FROM mac');
            $executeisok = $pdostat->execute();
            return $pdostat->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}

    ?>
