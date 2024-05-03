<?php
 require __DIR__ . '/../../config.php';
 require_once "vendor/autoload.php";
require_once "User.php";


$conn = Config::getConnexion();

$user = new User($conn);

// Process user login
if(isset($_POST['kirim'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($user->login($email, $password)){
        $userData = $user->getUser();

        if ($userData['etat'] == 'Activé') {
            header("location: index.php");
        } else {
            $error = "Your account is inactive. Please contact support.";
        }
    } else {
        $error = $user->getLastError();
    }
}

// Process user registration
if(isset($_POST['register'])){
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];
    $newPassword = $_POST['new_password'];

    if($user->register($newName, $newEmail, $newPassword)){
        $newUserData = $user->getUser();
        sendWelcomeEmail($newEmail);
        header("location: /Integration/View/Organisation/index.php");
    } else {
        $error = $user->getLastError();
    }
}

function sendWelcomeEmail($toEmail) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->Host ='smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username ='ouayess.zidi@esprit.tn';
    $mail->Password ='221JMT0810';
    $mail->SMTPSecure ='tls';
    $mail->Port = 587;

    $mail->setFrom('HWIJA@gmail.com', 'HWIJA');
    $mail->addAddress($toEmail);
    $mail->Subject = 'Welcome to Our Website';
    $mail->Body = 'Thank you for registering on HWIJAA. Welcome aboard!';

    $mail->send();
    echo 'Message has been sent';
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Login Form -->
            <div class="col-md-6">
                <form class="login-form p-4 border rounded" method="post" id="userForm">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error ?>
                        </div>
                    <?php endif; ?>
                    <h1 class="mb-4">Sign In...</h1>
                    <hr>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required/>
                    </div>
                    <button type="submit" class="btn btn-primary" name="kirim">Login</button>
                    <p class="mt-3">Don't have an account? <a href="register.php">Register Here</a></p>
                </form>
            </div>

            <!-- Registration Form -->
            <div class="col-md-6">
                <form class="register-form p-4 border rounded" method="post" id="registerForm">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error ?>
                        </div>
                    <?php endif; ?>
                    <h1 class="mb-4">Register...</h1>
                    <hr>
                    <div class="form-group">
                        <input type="text" class="form-control" name="new_name" placeholder="Name" required/>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="new_email" placeholder="Email" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="new_password" placeholder="Password" required/>
                    </div>
                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                    <p class="mt-3">Already have an account? <a href="login.php">Login Here</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#userForm").validate();
            $("#registerForm").validate();
        });
    </script>
</body>
</html>
