<?php
if (!class_exists('Config')) {
    require_once __DIR__ . '../../config.php';
    $deleteOrderController = new DeleteOrderController(Config::getConnexion());
}

class DeleteOrderController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function deleteOrder($order_id)
    {
        // Check if the order belongs to the current user
        $check_order = $this->conn->prepare("SELECT * FROM `orders` WHERE id = ?");
        $check_order->execute([$order_id]);

        if ($check_order->rowCount() > 0) {
            // Order belongs to the user, delete it
            $delete_order = $this->conn->prepare("DELETE FROM `orders` WHERE id = ?");
            $delete_order->execute([$order_id]);

            if ($delete_order) {
                // Order deleted successfully
                return true;
            } else {
                // Failed to delete order
                return false;
            }
        } else {
            // Order does not belong to the user
            return false;
        }
    }
}

?>
