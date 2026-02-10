<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/User.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // LẤY ĐỦ 4 THÔNG TIN TỪ FORM
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // KIỂM TRA ĐIỀU KIỆN (Thêm $fullname vào đây)
    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đủ thông tin nghi thức.']);
        exit;
    }

    $userModel = new User();
    $result = $userModel->register($fullname, $username, $email, $password);

    if ($result === true) {
        echo json_encode(['status' => 'success', 'message' => 'Chào mừng Ngài gia nhập Inner Circle!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $result]);
    }
}