<?php
    // Lampirkan db dan User
    require __DIR__ . '/../../config.php';
    $conn = Config::getConnexion();
    
    // Buat object user
    $user = new User($conn);
    if (isset($_POST['register'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        if ($user->register($email, $password)) {
            // Registration successful, you can redirect the user or display a success message
            header("location: /Integration/View/Organisation/index.php");
        } else {
            // Registration failed, handle the error
            $error = $user->getLastError();
        }
    }
    // Jika sudah login
    if($user->isLoggedIn()){
        header("location: index.php"); //Redirect ke index
    }

    // Jika ada data dikirim
    if(isset($_POST['kirim'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        

        // Registrasi user baru
        if($user->register($name, $email, $password)){
            // Jika berhasil set variable success ke true
            $success = true;
        }else{
            // Jika gagal, ambil pesan error
            $error = $user->getLastError();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="actions.css">
    <link rel="stylesheet" href="connexion.css">
</head>
<body>
<div class="menu">
        <a href="../General/Accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Product/View_Products.php">Notre Boutique</a>
        <a href="../General/Actions/actions.php">Nos actions</a>

    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-page">
                    <div class="form">
                        <form class="register-form" method="post" id="userForm">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?php echo $error ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($success)): ?>
                                <div class="alert alert-success">
                                    User created. <a href="login.php">Login</a>
                                </div>
                            <?php endif; ?>
                            <h1 class="mb-4">Register...</h1>
                            <hr>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Nom" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email address" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" />
                            </div>
                            <button type="submit" class="btn btn-primary" name="kirim">Create</button>
                            <p class="mt-3">Already registered? <a href="login.php">Sign In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $("#userForm").validate();
    });
</script>
</body>
</html>
