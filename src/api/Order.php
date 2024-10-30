<?php

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
use App\api\OrderController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderController = new OrderController();
    $data = json_decode(file_get_contents('php://input'), true);
    $summary = $orderController->post($data);
    echo json_encode($summary);
}
else {
    http_response_code(405);
    die();
}
