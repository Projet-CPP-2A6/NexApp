<?php

class User
{
    private $db;
    private $error;

    function __construct($db_conn)
    {
        $this->db = $db_conn;
        session_start();
    }

    public function register($name, $email, $password)
    {
        try
        {
            $hashPasswd = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $query = $this->db->prepare("INSERT INTO tbLogin(name, email, password) VALUES(:name, :email, :pass)");
            $query->bindParam(":name", $name);
            $query->bindParam(":email", $email);
            $query->bindParam(":pass", $hashPasswd);
            $query->execute();

            return true;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] == 23000) {
                $this->error = "Email already exists!";
                return false;
            } else {
                echo $e->getMessage();
                return false;
            }
        }
    }

    public function login($email, $password)
    {
        try
        {
            // Get data from the database
            $query = $this->db->prepare("SELECT * FROM tbLogin WHERE email = :email");
            $query->bindParam(":email", $email);
            $query->execute();
            $data = $query->fetch();

            // If the number of rows > 0
            if ($query->rowCount() > 0) {
                // If the entered password matches the one in the database
                if (password_verify($password, $data['password'])) {
                    $_SESSION['user_session'] = $data['id'];
                    return true;
                } else {
                    $this->error = "error";
                    return false;
                }
            } else {
                $this->error = "This email does not exist";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_session'])) {
            return true;
        }
    }

    public function getUser()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }

        try {
            $query = $this->db->prepare("SELECT * FROM tbLogin WHERE id = :id");
            $query->bindParam(":id", $_SESSION['user_session']);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }

    public function getLastError()
    {
        return $this->error;
    }
}
?>
