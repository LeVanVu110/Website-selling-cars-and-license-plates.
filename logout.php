<?php
session_start();

// 1. Hủy bỏ tất cả các biến session
$_SESSION = array();

// 2. Nếu muốn xóa sạch cookie session (về mặt bảo mật)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Hủy bỏ phiên làm việc trên server
session_destroy();

// 4. Chuyển hướng về trang Login
header("Location: ../Website-selling-cars-and-license-plates/Login.php");
exit();