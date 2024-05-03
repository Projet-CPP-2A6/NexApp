<?php
    if (!class_exists('Config')) {
        require_once __DIR__ . '../../config.php';
        $UserController = new UserController($conn);}

require_once "User.php";

class UserController
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::getConnexion();
    }

    public function handleRegistration()
    {
        $user = new User($this->conn);

        // If not logged in, redirect to the login page
        if (!$user->isLoggedIn()) {
            header("location: login.php");
        }

        // Get current user data
        $currentUser = $user->getUser();

        // Process form submission
        if (isset($_POST['submit'])) {
            $name = htmlentities($_POST['name']);
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);

            $this->insertUser($name, $email, $password);

            header("location: index.php");
        }

        // Include HTML template
    }

    private function insertUser($name, $email, $password)
    {
        $query = $this->conn->prepare("INSERT INTO `tblogin`(`name`, `email`, `password`) VALUES (:name, :email, :password)");
        $query->bindParam(":name", $name);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);

        $query->execute();
    }
}

$userController = new UserController();
$userController->handleRegistration();
?>
