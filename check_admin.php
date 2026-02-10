<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Kiểm tra xem đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header("Location: ../Login.php");
    exit();
}

// 2. Kiểm tra Role ID (1: Grandmaster, 2: Elite Keeper)
$userRole = $_SESSION['user']['role_id'];

if ($userRole != 1 && $userRole != 2) {
    // Nếu không phải role 1 hoặc 2, đá về trang chủ hoặc báo lỗi
    echo "<script>alert('Ngài không có quyền truy cập vào lãnh địa này.'); window.location.href='../index.php';</script>";
    exit();
}
