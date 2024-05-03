<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../Controller/ProductController.php';

$ProductController = new ProductController();

// Fetch types before the form submission
$types = $ProductController->getTypes();

if (isset($_POST['add'])) {
    $ProductController->index();
    // Fetch types after the form submission
    $types = $ProductController->getTypes();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders</title>
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
<section class="product-form">
   <form action="" method="POST" enctype="multipart/form-data">
      <h3>product info</h3>
      <p>product name <span>*</span></p>
      <input type="text" name="name" placeholder="enter product name" required maxlength="50" class="box">
      <p>product price <span>*</span></p>
      <input type="number" name="price" placeholder="enter product price" required min="0" max="9999999999" maxlength="10" class="box">
      <p>Product Type <span>*</span></p>
      <select name="type_id" class="box" required>
         <?php foreach ($types as $type): ?>
            <option value="<?= $type['id']; ?>"><?= $type['name']; ?></option>
         <?php endforeach; ?>
      </select>
      <p>product image <span>*</span></p>
      <input type="file" name="image" required accept="image/*" class="box">
      <input type="submit" class="btn" name="add" value="add product">
   </form>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include '../User/components/alert.php'; ?>

</body>
</html>