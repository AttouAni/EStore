<?php

require_once "../config/database.php";

require_once "../models/Order.php";
require_once "../models/OrderItem.php";

session_start();

$orderModel = new Order($conn);
$orderItemModel = new OrderItem($conn);

if (isset($_POST['order_book'])) {

    $client_id = $_SESSION['user_id'];
    $book_id = $_POST['id_book'];
    $quantity = 0; // $_POST['quantity'];

    $order_id = $orderModel->create($client_id);

    $orderItemModel->create(
        $order_id,
        $book_id,
        $quantity
    );

    $orderModel->updateTotal($order_id);
    //$orderModel->updateStatus($order_id, Status::Pending);

    echo "Order created successfully!";
}

if (isset($_POST['update_status'])) {

    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $orderModel->updateStatus(
        $order_id,
        $status
    );

    header("Location: ../views/admin/orders.php");
    exit();
}

?>