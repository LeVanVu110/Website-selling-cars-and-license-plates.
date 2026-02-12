<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Place.php";

$plateModel = new Place();
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// 1. XỬ LÝ XÓA
if ($action == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($plateModel->deletePlate($id)) {
        header("Location: Inventory.php?msg=success");
    } else {
        header("Location: Inventory.php?msg=error");
    }
    exit;
}

// 2. XỬ LÝ THÊM HOẶC SỬA
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $plate_number = $_POST['plate_number'];
    $province = $_POST['province'];
    $price = $_POST['starting_price'];
    $status = $_POST['status'];

    if ($id) {
        // Nếu có ID -> Cập nhật
        $result = $plateModel->updatePlate($id, $plate_number, $province, $price, $status);
    } else {
        // Nếu không có ID -> Thêm mới
        $result = $plateModel->addPlate($plate_number, $province, $price, $status);
    }

    if ($result) {
        header("Location: Inventory.php?msg=success");
    } else {
        header("Location: Inventory.php?msg=error");
    }
    exit;
}