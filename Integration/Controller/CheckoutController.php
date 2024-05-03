<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';

    $checkoutController = new checkoutController(Config::getConnexion());
}

class CheckoutController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createUniqueID()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function placeOrder()
    {
        if (isset($_POST['place_order'])) {
            $name = $_POST['name'];
            $number = $_POST['number'];
            $email = $_POST['email'];
            $address = $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
            $address_type = $_POST['address_type'];
            $method = $_POST['method'];

            $verifyCart = $this->conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $verifyCart->execute([$user_id]);

            if (isset($_GET['get_id'])) {
                $get_product = $this->conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $get_product->execute([$_GET['get_id']]);

                if ($get_product->rowCount() > 0) {
                    while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                        $insert_order = $this->conn->prepare("INSERT INTO `orders` (id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $insert_order->execute([
                            $this->createUniqueID(),
                            $user_id,
                            $name,
                            $number,
                            $email,
                            $address,
                            $address_type,
                            $method,
                            $fetch_p['id'],
                            $fetch_p['price'],
                            1
                        ]);

                        header('location:orders.php');
                    }
                } else {
                    $warning_msg[] = 'Something went wrong!';
                }
            } elseif ($verifyCart->rowCount() > 0) {
                while ($f_cart = $verifyCart->fetch(PDO::FETCH_ASSOC)) {
                    $insert_order = $this->conn->prepare("INSERT INTO `orders` (id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insert_order->execute([
                        $this->createUniqueID(),
                        $user_id,
                        $name,
                        $number,
                        $email,
                        $address,
                        $address_type,
                        $method,
                        $f_cart['product_id'],
                        $f_cart['price'],
                        $f_cart['qty']
                    ]);
                }

                if ($insert_order) {
                    $delete_cart_id = $this->conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                    $delete_cart_id->execute([$user_id]);
                    header('location:orders.php');
                }
            } else {
                $warning_msg[] = 'Your cart is empty!';
            }
        }
    }

    public function getCartItems()
    {
        $cartItems = [];
        $select_cart = $this->conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $select_products = $this->conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$fetch_cart['product_id']]);
            $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
            $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);

            $cartItems[] = [
                'image' => $fetch_product['image'],
                'name' => $fetch_product['name'],
                'price' => $fetch_product['price'],
                'qty' => $fetch_cart['qty'],
            ];
        }

        return $cartItems;
    }
    
}

?>
