<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '/../../config.php'; 
    $categoriesController = new CategoriesController(Config::getConnexion()); 
}

$conn = Config::getConnexion();

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $success_msg[] = 'Cart quantity updated!';
}

if(isset($_POST['delete_item'])){
   $cart_id = $_POST['cart_id'];
   $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
   $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
   $verify_delete_item->execute([$cart_id]);
   if($verify_delete_item->rowCount() > 0){
      $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
      $delete_cart_id->execute([$cart_id]);
      $success_msg[] = 'Cart item deleted!';
   }else{
      $warning_msg[] = 'Cart item already deleted!';
   } 
}

if(isset($_POST['empty_cart'])){
   $verify_empty_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $verify_empty_cart->execute([$user_id]);
   if($verify_empty_cart->rowCount() > 0){
      $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart_id->execute([$user_id]);
      $success_msg[] = 'Cart emptied!';
   }else{
      $warning_msg[] = 'Cart already emptied!';
   } 
}

?>
