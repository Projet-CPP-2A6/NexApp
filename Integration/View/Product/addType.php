<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../Controller/AddTypeController.php';

$addTypeController->index();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add type</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>
    <link rel="stylesheet" href="../General/Accueil/accueil.css">
    <link rel="stylesheet" href="../General/Actions/actions.css">
    <link rel="stylesheet" href="../General/Boutique/Boutique.css">
   <link rel="stylesheet" href="../General/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="add-type">

    <h1 class="heading">Add Product Type</h1>

    <div class="container">
        <form action="" method="POST" name="addTypeForm">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <input type="submit" name="add" value="Add">
        </form>
    </div>

</section>

<?php include '../User/components/alert.php'; ?>

</body>
</html>
