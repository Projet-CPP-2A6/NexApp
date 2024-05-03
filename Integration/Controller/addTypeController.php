<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '/../../config.php'; 
    $addTypeController = new AddTypeController(Config::getConnexion()); 
}

class AddTypeController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index()
    {
        if (isset($_COOKIE['user_id'])) {
            $user_id = htmlentities($_COOKIE['user_id']);
        } else {
            setcookie('user_id', $this->createUniqueId(), time() + 60 * 60 * 24 * 30);
        }

        if (isset($_POST['add'])) {
            $new_name = $_POST['name'];
            $new_name = filter_var($new_name, FILTER_SANITIZE_STRING);

            // Check if the name is not empty
            if (empty($new_name)) {
                echo "Error: Name cannot be empty.";
                return;
            }

            // Insert the new type into the database
            $unique_id = $this->createUniqueId();
            $add_type = $this->conn->prepare("INSERT INTO `types` (id, name) VALUES (?, ?)");

            try {
                $add_type->execute([$unique_id, $new_name]);
                // Redirect to indexType.php or any other appropriate page
                header('location: indexType.php');
            } catch (PDOException $e) {
                // Handle integrity constraint violation
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function getTypes()
    {
        // Fetch types from the database
        $types_query = $this->conn->query("SELECT * FROM `types`");
        return $types_query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function createUniqueId()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
$addTypeController = new AddTypeController(Config::getConnexion());

?>
