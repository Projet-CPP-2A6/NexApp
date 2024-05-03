<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '/../../config.php'; 
    $ProductController = new ProductController(Config::getConnexion()); 
}

class ProductController
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::getConnexion();
    }

    public function index()
    {
        $types_query = $this->conn->query("SELECT * FROM `types`");
        $types = $types_query->fetchAll(PDO::FETCH_ASSOC);

        $warning_msg = [];
        $success_msg = [];

        if (isset($_POST['add'])) {
            $id = $this->createUniqueId();
            $name = $_POST['name'];
            $name = filter_var($name, FILTER_SANITIZE_STRING);
            $price = $_POST['price'];
            $price = filter_var($price, FILTER_SANITIZE_STRING);
            $type_id = $_POST['type_id'];

            $image = $_FILES['image']['name'];
            $image = filter_var($image, FILTER_SANITIZE_STRING);
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $rename = $this->createUniqueId() . '.' . $ext;
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_size = $_FILES['image']['size'];
            $image_folder = 'uploaded_files/' . $rename;

            if ($image_size > 2000000) {
                $warning_msg[] = 'Image size is too large!';
            } else {
                $add_product = $this->conn->prepare("INSERT INTO `products` (id, name, price, image, type_id) VALUES (?, ?, ?, ?, ?)");
                $add_product->execute([$id, $name, $price, $rename, $type_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'Product added!';
            }
        }
    }

    public function getTypes()
    {
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

$ProductController = new ProductController();
$types = $ProductController->getTypes();
?>