<?php

session_start();

require_once "../../config/database.php";

require_once "../../models/Order.php";
require_once "../../models/OrderItem.php";

$orderModel = new Order($conn);
$orderItemModel = new OrderItem($conn);

// GET ALL ORDERS
$orders = $orderModel->getAll();

?>

<h1>Manage Orders</h1>

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
            Client:
            <?= $order['client_id'] ?>
        </p>

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

        <!-- STATUS UPDATE -->

        <form
            action="../../controllers/orderController.php"
            method="POST"
        >

            <input
                type="hidden"
                name="order_id"
                value="<?= $order['id_order'] ?>"
            >

            <select name="status">

                <option value="pending">
                    Pending
                </option>

                <option value="confirmed">
                    Confirmed
                </option>

                <option value="cancelled">
                    Cancelled
                </option>

            </select>

            <button
                type="submit"
                name="update_status"
            >
                Update Status
            </button>

        </form>

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
                    src="../../public/uploads/<?= $item['image'] ?>"
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