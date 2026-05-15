<?php

session_start();

require_once "../config/database.php";

require_once "../models/Order.php";
require_once "../models/OrderItem.php";

$orderModel = new Order($conn);
$orderItemModel = new OrderItem($conn);

// GET USER ORDERS
$orders = $orderModel->getByUser(
    $_SESSION['user_id']
);

?>

<h1>My Orders</h1>

<?php foreach ($orders as $order): ?>

    <div
        style="
            border:1px solid black;
            margin-bottom:20px;
            padding:15px;
        "
    >

        <h3>
            Order #<?= $order['id_order'] ?>
        </h3>

        <p>
            Total:
            <?= $order['total_price'] ?> DT
        </p>

        <p>
            Status:
            <?= $order['status'] ?>
        </p>

        <p>
            Date:
            <?= $order['order_date'] ?>
        </p>

        <hr>

        <h4>Books:</h4>

        <?php

        $items = $orderItemModel->getByOrder(
            $order['id_order']
        );

        ?>

        <?php foreach ($items as $item): ?>

            <div style="margin-bottom:10px;">

                <img
                    src="../public/uploads/<?= $item['image'] ?>"
                    width="80"
                >

                <p>
                    <?= $item['title'] ?>
                </p>

                <p>
                    Quantity:
                    <?= $item['quantity'] ?>
                </p>

                <p>
                    Subtotal:
                    <?= $item['price'] ?> DT
                </p>

            </div>

        <?php endforeach; ?>

    </div>

<?php endforeach; ?>